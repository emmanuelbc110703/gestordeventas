<?php

namespace App\Http\Controllers;

use App\Models\PuntoVenta;
use App\Models\User;
use App\Models\Inventario;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PuntoVentaController extends Controller
{
    // ========================================
    // PANEL DE PUNTOS DE VENTA - ADMIN
    // ========================================

    public function index()
    {
        $puntosVenta = PuntoVenta::with('empleado')->get();

        return view(
            'admin.puntos_venta',
            compact('puntosVenta')
        );
    }


    // ========================================
    // FORMULARIO CREAR PUNTO DE VENTA
    // ========================================

    public function create()
    {
        $empleados = User::whereIn('rol', [
            'vendedor',
            'administrador',
            'admin'
        ])->get();

        return view(
            'admin.agregar_punto_venta',
            compact('empleados')
        );
    }


    // ========================================
    // GUARDAR PUNTO DE VENTA
    // ========================================

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre_caja' => 'required|string|max:255',
            'numero_caja' => 'required|string|max:50',
            'sucursal' => 'required|string|max:255',
            'empleado_id' => 'required|exists:users,id',
        ]);

        $empleado = User::where('id', $datos['empleado_id'])
            ->whereIn('rol', [
                'vendedor',
                'administrador',
                'admin'
            ])
            ->first();

        if (!$empleado) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'El empleado seleccionado no es válido.'
                );
        }

        if ($empleado->puntoVenta) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Este empleado ya tiene un punto de venta asignado.'
                );
        }

        PuntoVenta::create($datos);

        return redirect()
            ->route('admin.puntos_venta')
            ->with(
                'success',
                'Punto de venta creado correctamente.'
            );
    }


    // ========================================
    // FORMULARIO EDITAR
    // ========================================

    public function edit($id)
    {
        $puntoVenta = PuntoVenta::findOrFail($id);

        $empleados = User::whereIn('rol', [
            'vendedor',
            'administrador',
            'admin'
        ])->get();

        return view(
            'admin.editar_punto_venta',
            compact(
                'puntoVenta',
                'empleados'
            )
        );
    }


    // ========================================
    // ACTUALIZAR
    // ========================================

    public function update(Request $request, $id)
    {
        $puntoVenta = PuntoVenta::findOrFail($id);

        $datos = $request->validate([
            'nombre_caja' => 'required|string|max:255',
            'numero_caja' => 'required|string|max:50',
            'sucursal' => 'required|string|max:255',
            'empleado_id' => 'required|exists:users,id',
        ]);

        $empleado = User::where('id', $datos['empleado_id'])
            ->whereIn('rol', [
                'vendedor',
                'administrador',
                'admin'
            ])
            ->first();

        if (!$empleado) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'El empleado seleccionado no es válido.'
                );
        }

        $otroPunto = PuntoVenta::where(
            'empleado_id',
            $datos['empleado_id']
        )
            ->where(
                'id',
                '!=',
                $puntoVenta->id
            )
            ->first();

        if ($otroPunto) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Este empleado ya tiene otro punto de venta asignado.'
                );
        }

        $puntoVenta->update($datos);

        return redirect()
            ->route('admin.puntos_venta')
            ->with(
                'success',
                'Punto de venta actualizado correctamente.'
            );
    }


    // ========================================
    // ELIMINAR
    // ========================================

    public function destroy($id)
    {
        $puntoVenta = PuntoVenta::findOrFail($id);

        $puntoVenta->delete();

        return redirect()
            ->route('admin.puntos_venta')
            ->with(
                'success',
                'Punto de venta eliminado correctamente.'
            );
    }


    // ========================================
    // MOSTRAR PUNTO DE VENTA
    // ========================================

    public function mostrar($id)
    {
        $puntoVenta = PuntoVenta::findOrFail($id);

        return view(
            'punto_venta',
            compact('puntoVenta')
        );
    }


    // ========================================
    // ABRIR CAJA
    // ========================================

// ========================================
// ABRIR CAJA
// ========================================

public function abrir(Request $request, $id)
{
    $puntoVenta = PuntoVenta::findOrFail($id);

    $horaActual = now()->hour;

    /*
    |--------------------------------------------------------------------------
    | HORARIO DE TRABAJO
    |--------------------------------------------------------------------------
    | 08:00 hasta 19:59
    */

    $dentroHorario = $horaActual >= 8 && $horaActual < 20;


    /*
    |--------------------------------------------------------------------------
    | SI ESTÁ DENTRO DEL HORARIO
    |--------------------------------------------------------------------------
    | Se requiere dinero inicial.
    */

    if ($dentroHorario) {

        $datos = $request->validate([
            'dinero_inicial' => 'required|numeric|min:0',
        ]);

        $dineroInicial = $datos['dinero_inicial'];

        $fueraHorario = false;

    } else {

        /*
        |--------------------------------------------------------------------------
        | FUERA DEL HORARIO
        |--------------------------------------------------------------------------
        | No se solicita dinero inicial.
        */

        $dineroInicial = 0;

        $fueraHorario = true;
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR APERTURA EN SESIÓN
    |--------------------------------------------------------------------------
    */

    session([
        'caja_abierta' => true,

        'punto_venta_id' => $puntoVenta->id,

        'dinero_inicial' => $dineroInicial,

        'fecha_apertura' => now()->format('Y-m-d'),

        'hora_apertura' => now()->format('H:i:s'),

        'caja_fuera_horario' => $fueraHorario,
    ]);


    /*
    |--------------------------------------------------------------------------
    | ENTRAR A LA CAJA
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            'punto_venta.caja',
            $puntoVenta->id
        )
        ->with(
            'apertura_fuera_horario',
            $fueraHorario
        );
}


    // ========================================
// MOSTRAR CAJA
// ========================================

public function caja($id)
{
    $puntoVenta = PuntoVenta::findOrFail($id);

    // Verificar que la caja esté abierta
    if (
        !session('caja_abierta') ||
        session('punto_venta_id') != $puntoVenta->id
    ) {
        return redirect()->route('empleado.punto_venta');
    }

    // Obtener únicamente los servicios disponibles
    $servicios = Inventario::where('tipo', 'servicio')
        ->where('cantidad', '>', 0)
        ->orderBy('nombre', 'asc')
        ->get();

    // Obtener los clientes registrados
    $clientes = User::where('rol', 'cliente')
        ->orderBy('name', 'asc')
        ->get([
            'id',
            'name',
            'apellido'
        ]);

    // Enviar todo a caja.blade.php
    return view(
        'punto_venta.caja',
        compact(
            'puntoVenta',
            'servicios',
            'clientes'
        )
    );
}

// ========================================
// REGISTRAR CLIENTE DESDE LA CAJA
// ========================================

public function registrarClienteCaja(Request $request)
{
    $datos = $request->validate([
        'name' => 'required|string|max:255',
        'apellido' => 'nullable|string|max:255',
        'telefono' => 'nullable|string|max:20',
    ]);

    $cliente = User::create([
        'name' => $datos['name'],
        'apellido' => $datos['apellido'] ?? '',
        'telefono' => $datos['telefono'] ?? null,

        'email' => null,
        'direccion' => null,
        'fecha_nacimiento' => null,
        'foto_perfil' => null,

        // Color predeterminado para clientes registrados desde caja
        'color_perfil' => '#6a1b9a',

        'rol' => 'cliente',
        'password' => null,
    ]);

    return response()->json([
        'success' => true,

        'cliente' => [
            'id' => $cliente->id,
            'name' => $cliente->name,
            'apellido' => $cliente->apellido,
        ],
    ]);
}

// ========================================
// CERRAR CAJA
// ========================================

public function cerrar(Request $request)
{
    session()->forget([
        'caja_abierta',
        'punto_venta_id',
        'dinero_inicial',
        'fecha_apertura',
        'hora_apertura',
    ]);

    return redirect()
        ->route('empleado.punto_venta')
        ->with(
            'success',
            'La caja se cerró correctamente.'
        );
}

public function registrarCliente(Request $request)
{
    $datos = $request->validate([
        'name' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:20',
    ]);

    $cliente = User::create([
        'name' => $datos['name'],
        'apellido' => $datos['apellido'],
        'telefono' => $datos['telefono'] ?? null,

        'email' => null,
        'direccion' => null,
        'fecha_nacimiento' => null,
        'foto_perfil' => null,
        'color_perfil' => null,

        'rol' => 'cliente',
        'password' => null,
    ]);

    return redirect()
        ->route('punto_venta.caja', session('punto_venta_id'))
        ->with('cliente_registrado', $cliente->id);
}

// ========================================
// GUARDAR VENTA
// ========================================

public function guardarVenta(Request $request)
{
    $datos = $request->validate([
        'cliente_id' => 'nullable|exists:users,id',

        'productos' => 'required|array|min:1',

        'productos.*.id' => 'required|exists:inventarios,id',
        'productos.*.cantidad' => 'required|integer|min:1',
        'productos.*.precio' => 'required|numeric|min:0',

        'subtotal' => 'required|numeric|min:0',

        'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
        'descuento' => 'required|numeric|min:0',

        'impuesto_porcentaje' => 'nullable|numeric|min:0|max:100',
        'impuesto' => 'required|numeric|min:0',

        'total' => 'required|numeric|min:0',

        'metodo_pago' => 'required|string|in:efectivo,tarjeta,transferencia',

        'efectivo_recibido' => 'nullable|numeric|min:0',
        'cambio' => 'nullable|numeric|min:0',
    ]);


    // ========================================
    // VERIFICAR CAJA ABIERTA
    // ========================================

    if (
        !session('caja_abierta') ||
        !session('punto_venta_id')
    ) {
        return response()->json([
            'success' => false,
            'message' => 'La caja no está abierta.'
        ], 400);
    }


    // ========================================
    // OBTENER PUNTO DE VENTA
    // ========================================

    $puntoVenta = PuntoVenta::findOrFail(
        session('punto_venta_id')
    );


    // ========================================
    // CREAR VENTA
    // ========================================

    $venta = DB::transaction(function () use (
        $datos,
        $puntoVenta
    ) {

        $venta = Venta::create([

            'punto_venta_id' =>
                $puntoVenta->id,

            'empleado_id' =>
                auth()->id(),

            'cliente_id' =>
                $datos['cliente_id'] ?? null,

            'subtotal' =>
                $datos['subtotal'],

            'descuento_porcentaje' =>
                $datos['descuento_porcentaje'] ?? 0,

            'descuento' =>
                $datos['descuento'],

            'impuesto_porcentaje' =>
                $datos['impuesto_porcentaje'] ?? 0,

            'impuesto' =>
                $datos['impuesto'],

            'total' =>
                $datos['total'],

            'metodo_pago' =>
                $datos['metodo_pago'],

            'efectivo_recibido' =>
                $datos['efectivo_recibido'] ?? 0,

            'cambio' =>
                $datos['cambio'] ?? 0,

            'fecha_venta' =>
                now(),
        ]);


        // ========================================
        // GUARDAR DETALLES
        // ========================================

        foreach ($datos['productos'] as $producto) {

            $inventario = Inventario::findOrFail(
                $producto['id']
            );


            // Verificar existencia
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


            $cantidad =
                (int) $producto['cantidad'];


            $precio =
                (float) $producto['precio'];


            $subtotalProducto =
                $precio * $cantidad;


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


            // ========================================
            // DESCONTAR INVENTARIO
            // ========================================

            $inventario->decrement(
                'cantidad',
                $cantidad
            );
        }


        return $venta;
    });


    // ========================================
    // RESPUESTA
    // ========================================

    return response()->json([

        'success' => true,

        'venta_id' =>
            $venta->id,

        'ticket_url' =>
            route(
                'punto_venta.ticket',
                $venta->id
            ),

    ]);
}

}