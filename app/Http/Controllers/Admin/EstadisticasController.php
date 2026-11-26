<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GastoComercial;
use App\Models\Inventario;
use App\Models\PagoServicio;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EstadisticasController extends Controller
{
    private const CONCLUIDOS = ['finalizado', 'terminado'];
    private const STOCK_BAJO = 5;

    public function index(Request $request)
    {
        return view('admin.estadisticas.index', $this->datos($request));
    }

    public function pdf(Request $request, string $seccion)
    {
        $request->validate([
            'imgs'   => ['nullable', 'array', 'max:20'],
            'imgs.*' => ['string', 'max:3000000'],
        ]);

        $imagenes = collect($request->input('imgs', []))
            ->filter(fn ($v) => is_string($v) && preg_match('#^data:image/png;base64,[A-Za-z0-9+/=]+$#', $v))
            ->all();

        $datos = $this->datos($request) + ['seccion' => $seccion, 'imagenes' => $imagenes];

        $nombre = 'reporte-' . $seccion . '-'
            . $datos['inicio']->format('Ymd') . '-'
            . $datos['fin']->format('Ymd') . '.pdf';

        return Pdf::loadView('admin.estadisticas.pdf', $datos)
            ->setPaper('letter', 'portrait')
            ->download($nombre);
    }

    private function datos(Request $request): array
    {
        $request->validate([
            'desde' => ['nullable', 'date'],
            'hasta' => ['nullable', 'date'],
        ]);

        $inicio = $request->filled('desde')
            ? Carbon::parse($request->input('desde'))->startOfDay()
            : now()->startOfMonth();
        $fin = $request->filled('hasta')
            ? Carbon::parse($request->input('hasta'))->endOfDay()
            : now()->endOfDay();

        if ($fin->lt($inicio)) {
            [$inicio, $fin] = [$fin->copy()->startOfDay(), $inicio->copy()->endOfDay()];
        }

        $rango  = [$inicio, $fin];
        $fechas = [$inicio->toDateString(), $fin->toDateString()];

        $qVentas  = fn () => DB::table('ventas')->whereBetween('ventas.created_at', $rango);
        $qPedidos = fn () => DB::table('cotizaciones')->whereBetween('cotizaciones.created_at', $rango);
        $qGastos  = fn () => DB::table('gastos_comerciales')->whereBetween('gastos_comerciales.fecha', $fechas);
        $qRecibos = fn () => DB::table('recibos_pagos_servicios')->whereBetween('recibos_pagos_servicios.fecha_pago', $fechas);

        $qDetalleVenta = fn () => DB::table('detalle_ventas as d')
            ->join('ventas as v', 'v.id', '=', 'd.venta_id')
            ->join('inventarios as i', 'i.id', '=', 'd.inventario_id')
            ->leftJoin('categorias as c', 'c.id', '=', 'i.categoria_id')
            ->whereBetween('v.created_at', $rango);

        $qDetallePedido = fn () => DB::table('cotizacion_detalles as d')
            ->join('cotizaciones as q', 'q.id', '=', 'd.cotizacion_id')
            ->join('inventarios as i', 'i.id', '=', 'd.inventario_id')
            ->leftJoin('categorias as c', 'c.id', '=', 'i.categoria_id')
            ->whereBetween('q.created_at', $rango);

        $porMes  = $inicio->diffInDays($fin) > 62;
        $fmtSql  = $porMes ? '%Y-%m' : '%Y-%m-%d';
        $fmtPhp  = $porMes ? 'Y-m' : 'Y-m-d';
        $periodos = collect(CarbonPeriod::create(
            $porMes ? $inicio->copy()->startOfMonth() : $inicio->copy(),
            $porMes ? '1 month' : '1 day',
            $fin
        ));
        $claves    = $periodos->map(fn ($p) => $p->format($fmtPhp));
        $etiquetas = $periodos->map(fn ($p) => $p->translatedFormat($porMes ? 'M Y' : 'd M'))->all();

        $serie = function ($consulta, string $col, string $suma) use ($fmtSql, $claves) {
            $filas = $consulta
                ->selectRaw("DATE_FORMAT($col, '$fmtSql') as k, COALESCE(SUM($suma), 0) as v")
                ->groupBy('k')
                ->pluck('v', 'k');

            return $claves->map(fn ($k) => round((float) ($filas[$k] ?? 0), 2))->all();
        };
        $sumar = fn (array ...$a) => array_map(fn (...$v) => round(array_sum($v), 2), ...$a);

        $ingVentas    = (float) $qVentas()->sum('total');
        $ingPedidos   = (float) $qPedidos()->whereIn('estado', self::CONCLUIDOS)->sum('total');
        $ingServicios = (float) $qRecibos()->where('tipo_movimiento', 'ingreso')->sum('monto_pagado');
        $egrGastos    = (float) $qGastos()->sum('monto');
        $egrServicios = (float) $qRecibos()->where('tipo_movimiento', 'egreso')->sum('monto_pagado');

        $general = [
            'ingresos_ventas'    => $ingVentas,
            'ingresos_pedidos'   => $ingPedidos,
            'ingresos_servicios' => $ingServicios,
            'ingresos'           => $ingVentas + $ingPedidos + $ingServicios,
            'egresos_gastos'     => $egrGastos,
            'egresos_servicios'  => $egrServicios,
            'egresos'            => $egrGastos + $egrServicios,
        ];
        $general['balance'] = $general['ingresos'] - $general['egresos'];

        $sVentas     = $serie($qVentas(), 'created_at', 'total');
        $sPedidos    = $serie($qPedidos()->whereIn('estado', self::CONCLUIDOS), 'created_at', 'total');
        $sIngServ    = $serie($qRecibos()->where('tipo_movimiento', 'ingreso'), 'fecha_pago', 'monto_pagado');
        $sGastos     = $serie($qGastos(), 'fecha', 'monto');
        $sEgrServ    = $serie($qRecibos()->where('tipo_movimiento', 'egreso'), 'fecha_pago', 'monto_pagado');

        $vr = $qVentas()->selectRaw(
            'COUNT(*) as n, COALESCE(SUM(total),0) as total, COALESCE(SUM(descuento),0) as descuentos, COALESCE(SUM(impuesto),0) as impuestos'
        )->first();

        $ventas = [
            'n'          => (int) $vr->n,
            'total'      => (float) $vr->total,
            'promedio'   => $vr->n ? $vr->total / $vr->n : 0,
            'descuentos' => (float) $vr->descuentos,
            'impuestos'  => (float) $vr->impuestos,
            'formas'     => $qVentas()->selectRaw('forma_pago, COUNT(*) as n, SUM(total) as total')
                ->groupBy('forma_pago')->orderByDesc('total')->get(),
            'puntos'     => $qVentas()->join('puntos_venta as p', 'p.id', '=', 'ventas.punto_venta_id')
                ->groupBy('p.id', 'p.nombre_caja', 'p.sucursal')
                ->selectRaw('p.nombre_caja, p.sucursal, COUNT(*) as n, SUM(ventas.total) as total')
                ->orderByDesc('total')->get(),
            'top'        => $qDetalleVenta()->groupBy('i.id', 'i.nombre')
                ->selectRaw('i.nombre, SUM(d.cantidad) as cantidad, SUM(d.subtotal) as importe')
                ->orderByDesc('importe')->limit(10)->get(),
        ];

        $categorias = [
            'ventas'  => $qDetalleVenta()->groupBy('c.id', 'c.nombre')
                ->selectRaw("COALESCE(c.nombre, 'Sin categoría') as nombre, SUM(d.cantidad) as cantidad, SUM(d.subtotal) as importe")
                ->orderByDesc('importe')->get(),
            'pedidos' => $qDetallePedido()->groupBy('c.id', 'c.nombre')
                ->selectRaw("COALESCE(c.nombre, 'Sin categoría') as nombre, SUM(d.cantidad) as cantidad, SUM(d.subtotal) as importe")
                ->orderByDesc('importe')->get(),
            'gastos'  => $qGastos()->leftJoin('categorias as c', 'c.id', '=', 'gastos_comerciales.categoria_id')
                ->groupBy('c.id', 'c.nombre')
                ->selectRaw("COALESCE(c.nombre, 'Sin categoría') as nombre, COUNT(*) as n, SUM(gastos_comerciales.monto) as total")
                ->orderByDesc('total')->get(),
        ];

        $inventario = [
            'registros'   => Inventario::count(),
            'bienes'      => Inventario::where('tipo', 'bien')->count(),
            'servicios'   => Inventario::where('tipo', 'servicio')->count(),
            'unidades'    => (int) Inventario::sum('cantidad'),
            'valor'       => (float) Inventario::sum(DB::raw('precio * cantidad')),
            'agotados'    => Inventario::where('cantidad', 0)->count(),
            'adquiridos'  => Inventario::whereBetween('fecha_adquisicion', $fechas)->count(),
            'stock_bajo'  => self::STOCK_BAJO,
            'bajo'        => Inventario::with('categoria')->where('cantidad', '<=', self::STOCK_BAJO)
                ->orderBy('cantidad')->orderBy('nombre')->limit(10)->get(),
            'porCategoria' => DB::table('inventarios as i')
                ->leftJoin('categorias as c', 'c.id', '=', 'i.categoria_id')
                ->groupBy('c.id', 'c.nombre', 'i.tipo')
                ->selectRaw("COALESCE(c.nombre, 'Sin categoría') as nombre, i.tipo, COUNT(*) as registros, SUM(i.cantidad) as unidades, SUM(i.precio * i.cantidad) as valor")
                ->orderByDesc('valor')->get(),
        ];

        $pr = $qPedidos()->selectRaw('COUNT(*) as n, COALESCE(SUM(total),0) as total')->first();

        $pedidos = [
            'n'          => (int) $pr->n,
            'total'      => (float) $pr->total,
            'concluidos' => $qPedidos()->whereIn('estado', self::CONCLUIDOS)->count(),
            'porEstado'  => $qPedidos()->selectRaw('estado, COUNT(*) as n, SUM(total) as total')
                ->groupBy('estado')->orderByDesc('n')->get(),
            'servicios'  => $qDetallePedido()->groupBy('d.nombre')
                ->selectRaw('d.nombre, SUM(d.cantidad) as cantidad, SUM(d.subtotal) as importe')
                ->orderByDesc('importe')->limit(10)->get(),
            'clientes'   => $qPedidos()->join('users as u', 'u.id', '=', 'cotizaciones.user_id')
                ->groupBy('u.id', 'u.name', 'u.apellido')
                ->selectRaw("CONCAT(u.name, ' ', u.apellido) as cliente, COUNT(*) as n, SUM(cotizaciones.total) as total")
                ->orderByDesc('total')->limit(10)->get(),
        ];

        $cr = $qGastos()->selectRaw('COUNT(*) as n, COALESCE(SUM(monto),0) as total')->first();

        $compras = [
            'n'         => (int) $cr->n,
            'total'     => (float) $cr->total,
            'promedio'  => $cr->n ? $cr->total / $cr->n : 0,
            'recientes' => GastoComercial::with('categoria')->whereBetween('fecha', $fechas)
                ->orderByDesc('fecha')->orderByDesc('id')->limit(10)->get(),
        ];

        $pendientes = PagoServicio::where('estado', 'Pendiente');

        $pagos = [
            'n'                => $qRecibos()->count(),
            'egresos'          => $egrServicios,
            'ingresos'         => $ingServicios,
            'pendientes_n'     => (clone $pendientes)->count(),
            'pendientes_monto' => (float) (clone $pendientes)->sum('monto'),
            'vencidos'         => (clone $pendientes)->whereDate('fecha_vencimiento', '<', today())->count(),
            'porServicio'      => $qRecibos()->groupBy('servicio', 'tipo_movimiento')
                ->selectRaw('servicio, tipo_movimiento, COUNT(*) as n, SUM(monto_pagado) as total')
                ->orderByDesc('total')->get(),
            'proximos'         => (clone $pendientes)->orderByRaw('fecha_vencimiento IS NULL')
                ->orderBy('fecha_vencimiento')->limit(8)->get(),
        ];

        $graficas = [
            'periodos'   => $etiquetas,
            'ingresos'   => $sumar($sVentas, $sPedidos, $sIngServ),
            'egresos'    => $sumar($sGastos, $sEgrServ),
            'ventas'     => $sVentas,
            'pedidos'    => $serie($qPedidos(), 'created_at', '1'),
            'gastos'     => $sGastos,
            'formas'     => ['l' => $ventas['formas']->map(fn ($f) => ucfirst($f->forma_pago))->all(),
                             'd' => $ventas['formas']->pluck('total')->map(fn ($v) => round($v, 2))->all()],
            'catVentas'  => ['l' => $categorias['ventas']->pluck('nombre')->all(),
                             'd' => $categorias['ventas']->pluck('importe')->map(fn ($v) => round($v, 2))->all()],
            'catGastos'  => ['l' => $categorias['gastos']->pluck('nombre')->all(),
                             'd' => $categorias['gastos']->pluck('total')->map(fn ($v) => round($v, 2))->all()],
            'invCat'     => ['l' => $inventario['porCategoria']->map(fn ($c) => $c->nombre . ' (' . $c->tipo . ')')->all(),
                             'd' => $inventario['porCategoria']->pluck('unidades')->map(fn ($v) => (int) $v)->all()],
            'estados'    => ['l' => $pedidos['porEstado']->map(fn ($e) => ucfirst($e->estado))->all(),
                             'd' => $pedidos['porEstado']->pluck('n')->map(fn ($v) => (int) $v)->all()],
            'servicios'  => ['l' => $pagos['porServicio']->map(fn ($s) => $s->servicio . ' (' . $s->tipo_movimiento . ')')->all(),
                             'd' => $pagos['porServicio']->pluck('total')->map(fn ($v) => round($v, 2))->all()],
        ];

        return compact(
            'inicio', 'fin', 'general', 'ventas', 'categorias', 'inventario',
            'pedidos', 'compras', 'pagos', 'graficas'
        );
    }
}