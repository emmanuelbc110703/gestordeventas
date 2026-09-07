<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Registrar una venta desde la caja.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([

            'punto_venta_id' =>
                'required|exists:puntos_venta,id',

            'cliente_id' =>
                'nullable|exists:users,id',

            'subtotal' =>
                'required|numeric|min:0',

            'descuento_porcentaje' =>
                'required|numeric|min:0|max:100',

            'descuento' =>
                'required|numeric|min:0',

            'impuesto_porcentaje' =>
                'required|numeric|min:0|max:100',

            'impuesto' =>
                'required|numeric|min:0',

            'total' =>
                'required|numeric|min:0',

            'forma_pago' => [
                'required',
                'in:efectivo,tarjeta,transferencia'
            ],

            'efectivo_recibido' =>
                'nullable|numeric|min:0',

            'cambio' =>
                'nullable|numeric|min:0',

            'productos' =>
                'required|array|min:1',

            'productos.*.id' =>
                'required|exists:inventarios,id',

            'productos.*.cantidad' =>
                'required|integer|min:1',

            'productos.*.precio' =>
                'required|numeric|min:0',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Verificar caja
        |--------------------------------------------------------------------------
        */

        if (
            !session('caja_abierta') ||
            session('punto_venta_id') != $datos['punto_venta_id']
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'La caja no está abierta o no corresponde al punto de venta actual.'
            ], 403);
        }


        /*
        |--------------------------------------------------------------------------
        | Validar efectivo
        |--------------------------------------------------------------------------
        */

        if ($datos['forma_pago'] === 'efectivo') {

            if (
                !isset($datos['efectivo_recibido']) ||
                $datos['efectivo_recibido'] < $datos['total']
            ) {
                return response()->json([
                    'success' => false,
                    'message' =>
                        'El efectivo recibido no puede ser menor al total de la venta.'
                ], 422);
            }

            $datos['cambio'] =
                $datos['efectivo_recibido'] -
                $datos['total'];

        } else {

            $datos['efectivo_recibido'] = null;
            $datos['cambio'] = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Guardar venta
        |--------------------------------------------------------------------------
        */

        try {

            $venta = DB::transaction(function () use ($datos) {

                /*
                |--------------------------------------------------------------------------
                | Generar folio
                |--------------------------------------------------------------------------
                */

                $ultimaVenta =
                    Venta::latest('id')->first();

                $numeroFolio =
                    $ultimaVenta
                        ? $ultimaVenta->id + 1
                        : 1;

                $folio =
                    str_pad(
                        $numeroFolio,
                        8,
                        '0',
                        STR_PAD_LEFT
                    );


                /*
                |--------------------------------------------------------------------------
                | Crear venta
                |--------------------------------------------------------------------------
                */

                $venta = Venta::create([

                    'folio' =>
                        $folio,

                    'punto_venta_id' =>
                        $datos['punto_venta_id'],

                    'empleado_id' =>
                        auth()->id(),

                    'cliente_id' =>
                        $datos['cliente_id'] ?? null,

                    'subtotal' =>
                        $datos['subtotal'],

                    'descuento_porcentaje' =>
                        $datos['descuento_porcentaje'],

                    'descuento' =>
                        $datos['descuento'],

                    'impuesto_porcentaje' =>
                        $datos['impuesto_porcentaje'],

                    'impuesto' =>
                        $datos['impuesto'],

                    'total' =>
                        $datos['total'],

                    'forma_pago' =>
                        $datos['forma_pago'],

                    'efectivo_recibido' =>
                        $datos['efectivo_recibido'],

                    'cambio' =>
                        $datos['cambio'],
                ]);


                /*
                |--------------------------------------------------------------------------
                | Guardar productos
                |--------------------------------------------------------------------------
                */

                foreach ($datos['productos'] as $producto) {

                    $inventario =
                        Inventario::lockForUpdate()
                            ->findOrFail(
                                $producto['id']
                            );


                    /*
                    |--------------------------------------------------------------------------
                    | Verificar stock
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $inventario->cantidad <
                        $producto['cantidad']
                    ) {

                        throw new \Exception(
                            'No hay suficiente existencia de "' .
                            $inventario->nombre .
                            '".'
                        );
                    }


                    $precio =
                        $producto['precio'];

                    $cantidad =
                        $producto['cantidad'];

                    $subtotalProducto =
                        $precio * $cantidad;


                    /*
                    |--------------------------------------------------------------------------
                    | Crear detalle
                    |--------------------------------------------------------------------------
                    */

                    DetalleVenta::create([

                        'venta_id' =>
                            $venta->id,

                        'inventario_id' =>
                            $inventario->id,

                        'cantidad' =>
                            $cantidad,

                        'precio_unitario' =>
                            $precio,

                        'subtotal' =>
                            $subtotalProducto,
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Descontar inventario
                    |--------------------------------------------------------------------------
                    */

                    $inventario->decrement(
                        'cantidad',
                        $cantidad
                    );
                }


                return $venta;
            });


            /*
            |--------------------------------------------------------------------------
            | Respuesta
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'message' =>
                    'Venta registrada correctamente.',

                'venta_id' =>
                    $venta->id,

                'folio' =>
                    $venta->folio,

                'ticket_url' =>
                    route(
                        'venta.ticket',
                        $venta->id
                    ),
            ]);


        } catch (\Throwable $e) {

            return response()->json([

                'success' => false,

                'message' =>
                    $e->getMessage(),

            ], 422);
        }
    }


    /**
     * Mostrar ticket.
     */
    public function ticket(Venta $venta)
    {
        $venta->load([
            'puntoVenta',
            'empleado',
            'cliente',
            'detalles.inventario',
        ]);

        return view(
            'tickets.ticket',
            compact('venta')
        );
    }
}