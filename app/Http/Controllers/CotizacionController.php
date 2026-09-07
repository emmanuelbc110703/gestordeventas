<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\CotizacionDetalle;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{
    /**
     * ==========================================================
     * CLIENTE - LISTA DE SUS COTIZACIONES
     * ==========================================================
     */
    public function indexCliente()
    {
        $cotizaciones = Cotizacion::where('user_id', Auth::id())
            ->with('detalles')
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'cliente.cotizaciones.index',
            compact('cotizaciones')
        );
    }


    /**
     * ==========================================================
     * CLIENTE - MOSTRAR CATÁLOGO PARA CREAR COTIZACIÓN
     * ==========================================================
     */
    public function crear()
    {
        $servicios = Inventario::where('tipo', 'servicio')
            ->orderBy('nombre', 'asc')
            ->get();

        return view(
            'cliente.cotizaciones.crear',
            compact('servicios')
        );
    }


    /**
     * ==========================================================
     * CLIENTE - GUARDAR COTIZACIÓN
     * ==========================================================
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'forma_pago' => [
                'required',
                'in:efectivo,transferencia'
            ],

            'productos' => [
                'required',
                'array',
                'min:1'
            ],

            'productos.*.id' => [
                'required',
                'integer',
                'exists:inventarios,id'
            ],

            'productos.*.cantidad' => [
                'required',
                'integer',
                'min:1'
            ],
        ]);


        DB::beginTransaction();

        try {

            /*
             * Obtener los servicios reales de la base de datos.
             */
            $ids = collect($datos['productos'])
                ->pluck('id')
                ->unique()
                ->values();

            $servicios = Inventario::whereIn('id', $ids)
                ->where('tipo', 'servicio')
                ->get()
                ->keyBy('id');


            /*
             * Verificar que todos los productos
             * realmente sean servicios.
             */
            if ($servicios->count() !== $ids->count()) {

                DB::rollBack();

                return back()
                    ->withErrors([
                        'productos' =>
                            'Uno de los servicios seleccionados ya no está disponible.'
                    ])
                    ->withInput();
            }


            /*
             * Calcular subtotal.
             */
            $subtotal = 0;

            foreach ($datos['productos'] as $producto) {

                $servicio = $servicios->get(
                    $producto['id']
                );

                $subtotal +=
                    $servicio->precio *
                    $producto['cantidad'];
            }


            /*
             * Crear folio.
             */
            $folio = 'COT-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(
                    substr(uniqid(), -4)
                );


            /*
             * Crear cotización.
             *
             * Al enviarse comienza en estado:
             * enviado
             */
            $cotizacion = Cotizacion::create([

                'user_id' => Auth::id(),

                'folio' => $folio,

                'estado' => 'enviado',

                'forma_pago' => $datos['forma_pago'],

                'subtotal' => $subtotal,

                'descuento' => 0,

                'descuento_porcentaje' => 0,

                'impuesto' => 0,

                'impuesto_porcentaje' => 0,

                'total' => $subtotal,

            ]);


            /*
             * Guardar cada servicio.
             */
            foreach ($datos['productos'] as $producto) {

                $servicio = $servicios->get(
                    $producto['id']
                );

                $cantidad = $producto['cantidad'];

                $precio = $servicio->precio;

                $subtotalDetalle =
                    $precio * $cantidad;


                CotizacionDetalle::create([

                    'cotizacion_id' =>
                        $cotizacion->id,

                    'inventario_id' =>
                        $servicio->id,

                    /*
                     * Guardamos una copia del nombre.
                     */
                    'nombre' =>
                        $servicio->nombre,

                    /*
                     * Guardamos la cantidad.
                     */
                    'cantidad' =>
                        $cantidad,

                    /*
                     * Guardamos el precio actual.
                     */
                    'precio' =>
                        $precio,

                    /*
                     * Guardamos el subtotal.
                     */
                    'subtotal' =>
                        $subtotalDetalle,

                ]);
            }


            DB::commit();


            /*
             * Regresar al listado del cliente.
             */
            return redirect()
                ->route('cliente.cotizaciones')
                ->with(
                    'success',
                    'Pedido enviado correctamente.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withErrors([
                    'error' =>
                        'No fue posible enviar la cotización.'
                ])
                ->withInput();
        }
    }


    /**
     * ==========================================================
     * CLIENTE - VER UNA COTIZACIÓN
     * ==========================================================
     */
    public function mostrar($id)
    {
        $cotizacion = Cotizacion::with([
            'detalles',
            'usuario'
        ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);


        return view(
            'cliente.cotizaciones.mostrar',
            compact('cotizacion')
        );
    }


    /**
     * ==========================================================
     * ADMIN - LISTAR TODAS LAS COTIZACIONES
     * ==========================================================
     */
    public function indexAdmin()
    {
        $cotizaciones = Cotizacion::with([
            'usuario',
            'detalles'
        ])
            ->orderBy('created_at', 'asc')
            ->get();


        return view(
            'admin.cotizaciones.index',
            compact('cotizaciones')
        );
    }


    /**
     * ==========================================================
     * ADMIN - VER COTIZACIÓN
     * ==========================================================
     */
    public function mostrarAdmin($id)
    {
        $cotizacion = Cotizacion::with([
            'usuario',
            'detalles'
        ])->findOrFail($id);


        return view(
            'admin.cotizaciones.mostrar',
            compact('cotizacion')
        );
    }


    /**
     * ==========================================================
     * ADMIN - CONFIRMAR PEDIDO
     *
     * ENVIADO → PROCESANDO
     * ==========================================================
     */
    public function procesar($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);


        /*
         * Solo se puede confirmar un pedido
         * que esté en enviado.
         */
        if ($cotizacion->estado !== 'enviado') {

            return back()->withErrors([
                'error' =>
                    'Esta cotización no puede pasar a procesamiento.'
            ]);
        }


        $cotizacion->update([
            'estado' => 'procesando'
        ]);


        return back()->with(
            'success',
            'La cotización ahora está en procesamiento.'
        );
    }


    /**
     * ==========================================================
     * ADMIN - EDITAR COTIZACIÓN
     *
     * SOLO PROCESANDO
     * ==========================================================
     */
    public function editar($id)
    {
        $cotizacion = Cotizacion::with('detalles')
            ->findOrFail($id);


        /*
         * No permitir edición fuera de procesando.
         */
        if ($cotizacion->estado !== 'procesando') {

            abort(403);
        }


        return view(
            'admin.cotizaciones.editar',
            compact('cotizacion')
        );
    }


    /**
     * ==========================================================
     * ADMIN - ACTUALIZAR COTIZACIÓN
     * ==========================================================
     */
    public function actualizar(Request $request, $id)
    {
        $cotizacion = Cotizacion::with('detalles')
            ->findOrFail($id);


        /*
         * MUY IMPORTANTE:
         *
         * Solo se puede modificar mientras
         * está procesando.
         */
        if ($cotizacion->estado !== 'procesando') {

            abort(403);
        }


        $datos = $request->validate([

            'descuento_porcentaje' =>
                'required|numeric|min:0|max:100',

            'impuesto_porcentaje' =>
                'required|numeric|min:0|max:100',

            'cantidades' =>
                'required|array',

            'cantidades.*' =>
                'required|integer|min:1',

        ]);


        DB::beginTransaction();

        try {

            $subtotal = 0;


            /*
             * Actualizar cantidades.
             */
            foreach ($cotizacion->detalles as $detalle) {

                if (
                    !isset(
                        $datos['cantidades'][
                            $detalle->id
                        ]
                    )
                ) {
                    continue;
                }


                $cantidad =
                    $datos['cantidades'][
                        $detalle->id
                    ];


                $subtotalDetalle =
                    $detalle->precio *
                    $cantidad;


                $detalle->update([

                    'cantidad' =>
                        $cantidad,

                    'subtotal' =>
                        $subtotalDetalle,

                ]);


                $subtotal +=
                    $subtotalDetalle;
            }


            /*
             * Descuento.
             */
            $descuentoPorcentaje =
                $datos['descuento_porcentaje'];


            $descuento =
                $subtotal *
                ($descuentoPorcentaje / 100);


            /*
             * Base después del descuento.
             */
            $base =
                $subtotal -
                $descuento;


            /*
             * Impuesto.
             */
            $impuestoPorcentaje =
                $datos['impuesto_porcentaje'];


            $impuesto =
                $base *
                ($impuestoPorcentaje / 100);


            /*
             * Total final.
             */
            $total =
                $base +
                $impuesto;


            $cotizacion->update([

                'subtotal' =>
                    $subtotal,

                'descuento' =>
                    $descuento,

                'descuento_porcentaje' =>
                    $descuentoPorcentaje,

                'impuesto' =>
                    $impuesto,

                'impuesto_porcentaje' =>
                    $impuestoPorcentaje,

                'total' =>
                    $total,

            ]);


            DB::commit();


            return redirect()
                ->route(
                    'admin.cotizaciones.mostrar',
                    $cotizacion->id
                )
                ->with(
                    'success',
                    'Cotización actualizada correctamente.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withErrors([
                    'error' =>
                        'No fue posible actualizar la cotización.'
                ])
                ->withInput();
        }
    }


    /**
     * ==========================================================
     * ADMIN - FINALIZAR COTIZACIÓN
     *
     * PROCESANDO → FINALIZADO
     * ==========================================================
     */
    public function finalizar($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);


        /*
         * Solo se puede finalizar
         * cuando está procesando.
         */
        if ($cotizacion->estado !== 'procesando') {

            return back()->withErrors([
                'error' =>
                    'La cotización todavía no puede finalizarse.'
            ]);
        }


        $cotizacion->update([
            'estado' => 'finalizado'
        ]);


        return back()->with(
            'success',
            'La cotización fue finalizada correctamente.'
        );
    }


    /**
     * ==========================================================
     * ADMIN - MARCAR COMO TERMINADO
     *
     * FINALIZADO → TERMINADO
     * ==========================================================
     */
    public function terminar($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);


        /*
         * Solo se puede terminar
         * una cotización finalizada.
         */
        if ($cotizacion->estado !== 'finalizado') {

            return back()->withErrors([
                'error' =>
                    'La cotización todavía no puede marcarse como terminada.'
            ]);
        }


        $cotizacion->update([
            'estado' => 'terminado'
        ]);


        return back()->with(
            'success',
            'La cotización fue marcada como terminada.'
        );
    }
}