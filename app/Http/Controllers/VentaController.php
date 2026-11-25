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
            'punto_venta_id'    => 'required|exists:puntos_venta,id',
            'cliente_id'        => 'nullable|exists:users,id',
            'forma_pago'        => ['required', 'in:efectivo,tarjeta,transferencia'],
            'efectivo_recibido' => 'nullable|numeric|min:0',
            'productos'            => 'required|array|min:1',
            'productos.*.id'       => 'required|exists:inventarios,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        if (
            !session('caja_abierta') ||
            session('punto_venta_id') != $datos['punto_venta_id']
        ) {
            return response()->json([
                'success' => false,
                'message' => 'La caja no está abierta o no corresponde al punto de venta actual.'
            ], 403);
        }

        try {
            $venta = DB::transaction(function () use ($datos) {

                $tasaIva = 0.16;
                $lineas = [];
                $subtotal = 0;
                $descuentoTotal = 0;

                foreach ($datos['productos'] as $producto) {

                    $inventario = Inventario::with('promociones')
                        ->lockForUpdate()
                        ->findOrFail($producto['id']);

                    $cantidad = (int) $producto['cantidad'];

                    if ($inventario->cantidad < $cantidad) {
                        throw new \Exception(
                            'No hay suficiente existencia de "' . $inventario->nombre . '".'
                        );
                    }

                    $precio = (float) $inventario->precio;
                    $promo = $inventario->promocionVigente();
                    $descuentoUnit = $promo ? $promo->calcularDescuento($precio) : 0;

                    $subtotalLinea = round($precio * $cantidad, 2);
                    $descuentoLinea = round($descuentoUnit * $cantidad, 2);

                    $subtotal += $subtotalLinea;
                    $descuentoTotal += $descuentoLinea;

                    $lineas[] = [
                        'inventario'     => $inventario,
                        'cantidad'       => $cantidad,
                        'precio'         => $precio,
                        'subtotal'       => $subtotalLinea,
                        'descuento'      => $descuentoLinea,
                        'promocion_id'   => $promo?->id,
                    ];
                }

                $subtotal = round($subtotal, 2);
                $descuentoTotal = round($descuentoTotal, 2);
                $base = round($subtotal - $descuentoTotal, 2);
                $impuesto = round($base * $tasaIva, 2);
                $total = round($base + $impuesto, 2);
                $descuentoPorcentaje = $subtotal > 0
                    ? round(($descuentoTotal / $subtotal) * 100, 2)
                    : 0;

                $efectivoRecibido = null;
                $cambio = null;

                if ($datos['forma_pago'] === 'efectivo') {
                    $efectivoRecibido = (float) ($datos['efectivo_recibido'] ?? 0);

                    if ($efectivoRecibido < $total) {
                        throw new \Exception(
                            'El efectivo recibido no puede ser menor al total de la venta.'
                        );
                    }

                    $cambio = round($efectivoRecibido - $total, 2);
                }

                $ultimaVenta = Venta::latest('id')->first();
                $folio = str_pad(($ultimaVenta ? $ultimaVenta->id + 1 : 1), 8, '0', STR_PAD_LEFT);

                $venta = Venta::create([
                    'folio'                => $folio,
                    'punto_venta_id'       => $datos['punto_venta_id'],
                    'empleado_id'          => auth()->id(),
                    'cliente_id'           => $datos['cliente_id'] ?? null,
                    'subtotal'             => $subtotal,
                    'descuento_porcentaje' => $descuentoPorcentaje,
                    'descuento'            => $descuentoTotal,
                    'impuesto_porcentaje'  => 16,
                    'impuesto'             => $impuesto,
                    'total'                => $total,
                    'forma_pago'           => $datos['forma_pago'],
                    'efectivo_recibido'    => $efectivoRecibido,
                    'cambio'               => $cambio,
                ]);

                foreach ($lineas as $linea) {
                    DetalleVenta::create([
                        'venta_id'        => $venta->id,
                        'inventario_id'   => $linea['inventario']->id,
                        'promocion_id'    => $linea['promocion_id'],
                        'cantidad'        => $linea['cantidad'],
                        'precio_unitario' => $linea['precio'],
                        'subtotal'        => $linea['subtotal'],
                        'descuento'       => $linea['descuento'],
                    ]);

                    $linea['inventario']->decrement('cantidad', $linea['cantidad']);
                }

                return $venta;
            });

            return response()->json([
                'success'    => true,
                'message'    => 'Venta registrada correctamente.',
                'venta_id'   => $venta->id,
                'folio'      => $venta->folio,
                'ticket_url' => route('venta.ticket', $venta->id),
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
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