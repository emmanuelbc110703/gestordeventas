<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
    private const VENTAS_POR_PAGINA = 20;

    /**
     * Mostrar la lista de empleados.
     */
    public function index()
    {
        $empleados = User::whereIn('rol', [
            'admin',
            'vendedor'
        ])->get();

        return view(
            'admin.empleados.index',
            compact('empleados')
        );
    }


    /**
     * Mostrar el formulario para agregar un empleado.
     */
    public function create()
    {
        return view('admin.empleados.agregar');
    }


    /**
     * Guardar un nuevo empleado.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'rol' => 'required|in:admin,vendedor',
            'password' => 'required|string|min:8|confirmed',
        ]);


        User::create([
            'name' => $datos['name'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            'rol' => $datos['rol'],
            'foto_perfil' => null,
            'color_perfil' => '#6a1b9a',
            'password' => Hash::make($datos['password']),
        ]);


        return redirect()
            ->route('admin.empleados')
            ->with('success', 'Empleado registrado correctamente.');
    }

        public function destroy($id)
{
    $empleado = User::findOrFail($id);

    $empleado->delete();

    return redirect()
        ->route('admin.empleados')
        ->with('success', 'Empleado eliminado correctamente.');
}

/**
 * Mostrar formulario para editar empleado.
 */
public function edit($id)
{
    $empleado = User::whereIn('rol', [
        'admin',
        'vendedor'
    ])->findOrFail($id);

    return view(
        'admin.empleados.editar',
        compact('empleado')
    );
}


/**
 * Actualizar información del empleado.
 */
public function update(Request $request, $id)
{
    $empleado = User::whereIn('rol', [
        'admin',
        'vendedor'
    ])->findOrFail($id);

    $datos = $request->validate([
        'name' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $empleado->id,
        'telefono' => 'nullable|string|max:20',
        'rol' => 'required|in:admin,vendedor',
    ]);

    $empleado->update([
        'name' => $datos['name'],
        'apellido' => $datos['apellido'],
        'email' => $datos['email'],
        'telefono' => $datos['telefono'] ?? null,
        'rol' => $datos['rol'],
    ]);

    return redirect()
        ->route('admin.empleados')
        ->with('success', 'Empleado actualizado correctamente.');
}


/**
 * Mostrar el detalle del empleado con el historial de ventas
 * que ha realizado en el punto de venta (con filtros por fecha,
 * forma de pago y folio).
 */
public function ventas(Request $request, $id)
{
    $empleado = User::whereIn('rol', [
        'admin',
        'vendedor'
    ])->findOrFail($id);

    // ───────────── Filtros ─────────────
    $validador = Validator::make($request->query(), [
        'desde'      => ['nullable', 'date'],
        'hasta'      => ['nullable', 'date', 'after_or_equal:desde'],
        'forma_pago' => ['nullable', 'in:efectivo,tarjeta,transferencia'],
        'q'          => ['nullable', 'string', 'max:50'],
    ], [
        'desde.date'           => 'La fecha inicial no es válida.',
        'hasta.date'           => 'La fecha final no es válida.',
        'hasta.after_or_equal' => 'La fecha final no puede ser anterior a la fecha inicial.',
        'forma_pago.in'        => 'La forma de pago seleccionada no es válida.',
        'q.max'                => 'La búsqueda es demasiado larga.',
    ]);

    $errorFiltro = $validador->fails() ? $validador->errors()->first() : null;
    $filtros     = $errorFiltro ? [] : $validador->validated();

    // Sin filtros = todas las ventas del empleado
    $desde     = $filtros['desde'] ?? null;
    $hasta     = $filtros['hasta'] ?? null;
    $formaPago = $filtros['forma_pago'] ?? null;
    $busqueda  = trim($filtros['q'] ?? '');

    // ───────────── Consulta base ─────────────
    $base = DB::table('ventas')->where('ventas.empleado_id', $empleado->id);

    if ($desde) {
        $base->where('ventas.created_at', '>=', Carbon::parse($desde)->startOfDay());
    }
    if ($hasta) {
        $base->where('ventas.created_at', '<=', Carbon::parse($hasta)->endOfDay());
    }
    if ($formaPago) {
        $base->where('ventas.forma_pago', $formaPago);
    }
    if ($busqueda !== '') {
        $base->where('ventas.folio', 'like', '%' . addcslashes($busqueda, '%_\\') . '%');
    }

    // ───────────── Resumen (sobre todo el filtro, no solo la página) ─────────────
    $agregado = (clone $base)
        ->selectRaw('COUNT(*) AS num_ventas, COALESCE(SUM(ventas.total), 0) AS total')
        ->first();

    $totalVentas = (int) $agregado->num_ventas;
    $resumen = [
        'ventas'    => $totalVentas,
        'total'     => (float) $agregado->total,
        'ticket'    => $totalVentas > 0 ? (float) $agregado->total / $totalVentas : 0.0,
        'productos' => (int) DB::table('detalle_ventas')
            ->whereIn('venta_id', (clone $base)->select('ventas.id'))
            ->sum('cantidad'),
    ];

    $porPago = [
        'efectivo'      => ['ventas' => 0, 'total' => 0.0],
        'tarjeta'       => ['ventas' => 0, 'total' => 0.0],
        'transferencia' => ['ventas' => 0, 'total' => 0.0],
    ];

    $filasPago = (clone $base)
        ->selectRaw('ventas.forma_pago, COUNT(*) AS num_ventas, SUM(ventas.total) AS total')
        ->groupBy('ventas.forma_pago')
        ->get();

    foreach ($filasPago as $fila) {
        $porPago[$fila->forma_pago] = [
            'ventas' => (int) $fila->num_ventas,
            'total'  => (float) $fila->total,
        ];
    }

    // ───────────── Historial paginado ─────────────
    $ventas = (clone $base)
        ->leftJoin('puntos_venta', 'puntos_venta.id', '=', 'ventas.punto_venta_id')
        ->leftJoin('users as clientes', 'clientes.id', '=', 'ventas.cliente_id')
        ->select(
            'ventas.*',
            'puntos_venta.nombre_caja',
            'puntos_venta.sucursal',
            'clientes.name as cliente_nombre',
            'clientes.apellido as cliente_apellido'
        )
        ->selectSub(
            DB::table('detalle_ventas')
                ->selectRaw('COALESCE(SUM(cantidad), 0)')
                ->whereColumn('detalle_ventas.venta_id', 'ventas.id'),
            'articulos'
        )
        ->orderByDesc('ventas.created_at')
        ->orderByDesc('ventas.id')
        ->paginate(self::VENTAS_POR_PAGINA)
        ->withQueryString();

    $ventas->getCollection()->transform(function ($venta) {
        $venta->fecha = Carbon::parse($venta->created_at);
        return $venta;
    });

    // ───────────── Datos auxiliares ─────────────
    $caja = DB::table('puntos_venta')->where('empleado_id', $empleado->id)->first();

    $hoy         = Carbon::today();
    $mesAnterior = $hoy->copy()->subMonthNoOverflow();

    $definiciones = [
        ['etiqueta' => 'Todo',           'desde' => null,                                                 'hasta' => null],
        ['etiqueta' => 'Hoy',            'desde' => $hoy->toDateString(),                                 'hasta' => $hoy->toDateString()],
        ['etiqueta' => 'Ayer',           'desde' => $hoy->copy()->subDay()->toDateString(),               'hasta' => $hoy->copy()->subDay()->toDateString()],
        ['etiqueta' => 'Últimos 7 días', 'desde' => $hoy->copy()->subDays(6)->toDateString(),             'hasta' => $hoy->toDateString()],
        ['etiqueta' => 'Este mes',       'desde' => $hoy->copy()->startOfMonth()->toDateString(),         'hasta' => $hoy->toDateString()],
        ['etiqueta' => 'Mes anterior',   'desde' => $mesAnterior->copy()->startOfMonth()->toDateString(), 'hasta' => $mesAnterior->copy()->endOfMonth()->toDateString()],
    ];

    $atajos = array_map(function ($atajo) use ($desde, $hasta) {
        $atajo['activo'] = $atajo['desde'] === $desde && $atajo['hasta'] === $hasta;
        return $atajo;
    }, $definiciones);

    $formato = fn (string $fecha) => Carbon::parse($fecha)->format('d/m/Y');

    if ($desde && $hasta) {
        $periodoTexto = $desde === $hasta
            ? 'Día ' . $formato($desde)
            : 'Del ' . $formato($desde) . ' al ' . $formato($hasta);
    } elseif ($desde) {
        $periodoTexto = 'Desde el ' . $formato($desde);
    } elseif ($hasta) {
        $periodoTexto = 'Hasta el ' . $formato($hasta);
    } else {
        $periodoTexto = 'Todo el historial';
    }

    return view('admin.empleados.ventas', [
        'empleado'       => $empleado,
        'nombreCompleto' => trim($empleado->name . ' ' . $empleado->apellido),
        'caja'           => $caja,
        'ventas'         => $ventas,
        'resumen'        => $resumen,
        'porPago'        => $porPago,
        'atajos'         => $atajos,
        'desde'          => $desde,
        'hasta'          => $hasta,
        'formaPago'      => $formaPago,
        'busqueda'       => $busqueda,
        'periodoTexto'   => $periodoTexto,
        'errorFiltro'    => $errorFiltro,
    ]);
}

}