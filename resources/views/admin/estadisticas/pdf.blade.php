@php
    $m = fn ($v) => '$' . number_format((float) $v, 2);
    $n = fn ($v) => number_format((float) $v);
    $f = fn ($v) => $v ? \Carbon\Carbon::parse($v)->format('d/m/Y') : '—';
    $img = fn ($k) => !empty($imagenes[$k])
        ? '<img class="graf" src="' . $imagenes[$k] . '">'
        : '<div class="vacio">Gráfica no disponible.</div>';

    $titulos = [
        'general' => 'Reporte general', 'ventas' => 'Ventas', 'categorias' => 'Categorías',
        'inventario' => 'Inventario', 'pedidos' => 'Pedidos', 'compras' => 'Compras',
        'pagos' => 'Pagos de servicios', 'completo' => 'Reporte completo',
    ];
    $secciones = $seccion === 'completo'
        ? ['general', 'ventas', 'categorias', 'inventario', 'pedidos', 'compras', 'pagos']
        : [$seccion];
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>{{ $titulos[$seccion] }}</title>
<style>
    @page { margin: 70px 40px 50px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1f2937; }
    header { position: fixed; top: -50px; left: 0; right: 0; border-bottom: 2px solid #6d28d9; padding-bottom: 6px; }
    header h1 { margin: 0; font-size: 17px; color: #6d28d9; }
    header p { margin: 2px 0 0; color: #6b7280; }
    footer { position: fixed; bottom: -30px; left: 0; right: 0; text-align: right; font-size: 8px; color: #9ca3af; }
    .pagenum:before { content: counter(page); }

    h2 { margin: 0 0 10px; padding: 6px 10px; font-size: 13px; color: #fff; background: #6d28d9; }
    h3 { margin: 0 0 6px; font-size: 11px; color: #1f2937; }
    .salto { page-break-before: always; }
    .nota { margin: 0 0 8px; padding: 6px 10px; background: #f5f3ff; border-left: 3px solid #6d28d9; font-size: 9px; color: #4c1d95; }

    .tarjetas { width: 100%; table-layout: fixed; border-collapse: separate; border-spacing: 6px; margin: 0 -6px 4px; }
    .tarjetas td { border: 1px solid #e5e7eb; border-top: 3px solid #6d28d9; padding: 8px; vertical-align: top; background: #fff; }
    .tarjetas td.c2 { border-top-color: #059669; }
    .tarjetas td.c3 { border-top-color: #2563eb; }
    .tarjetas td.c4 { border-top-color: #d97706; }
    .tarjetas td.c5 { border-top-color: #0d9488; }
    .tarjetas small { display: block; font-size: 7px; letter-spacing: .5px; text-transform: uppercase; color: #6b7280; }
    .tarjetas strong { display: block; margin: 5px 0 3px; font-size: 14px; }
    .tarjetas em { display: block; font-style: normal; font-size: 8px; color: #6b7280; }

    .caja { border: 1px solid #e5e7eb; border-top: 3px solid #6d28d9; padding: 9px 10px; margin: 8px 0 12px; page-break-inside: avoid; }
    .graf { width: 100%; }

    table.t { width: 100%; border-collapse: collapse; }
    table.t th { text-align: left; background: #f3f4f6; font-size: 8px; text-transform: uppercase; letter-spacing: .4px; color: #6b7280; padding: 5px 6px; border-bottom: 1px solid #d1d5db; }
    table.t td { padding: 5px 6px; border-bottom: 1px solid #f0f0f3; }
    table.t tr:nth-child(even) td { background: #fafafc; }
    table.t tr.total td { background: #f5f3ff; font-weight: bold; border-top: 1px solid #6d28d9; }
    .der { text-align: right; }
    .pos { color: #047857; }
    .neg { color: #b91c1c; }
    .vacio { color: #9ca3af; padding: 8px 0; text-align: center; }
    .etiqueta { display: inline-block; padding: 1px 6px; background: #eef0f4; font-size: 8px; color: #6b7280; }
</style>
</head>
<body>
<header>
    <h1>{{ $titulos[$seccion] }}</h1>
    <p>Estadísticas del negocio · Del {{ $inicio->format('d/m/Y') }} al {{ $fin->format('d/m/Y') }}</p>
</header>
<footer>Generado el {{ now()->format('d/m/Y H:i') }} · Página <span class="pagenum"></span></footer>

<main>
@foreach($secciones as $s)
<div class="{{ $seccion === 'completo' && !$loop->first ? 'salto' : '' }}">
    @if($seccion === 'completo')<h2>{{ $titulos[$s] }}</h2>@endif
    @if($s === 'general')
        <table class="tarjetas"><tr>
            <td><small>Ingresos</small><strong class="pos">{{ $m($general['ingresos']) }}</strong><em>Ventas + pedidos + servicios</em></td>
            <td class="c2"><small>Egresos</small><strong class="neg">{{ $m($general['egresos']) }}</strong><em>Compras + pagos de servicios</em></td>
            <td class="c3"><small>Balance</small><strong class="{{ $general['balance'] >= 0 ? 'pos' : 'neg' }}">{{ $m($general['balance']) }}</strong><em>Ingresos − egresos</em></td>
            <td class="c4"><small>Ventas (punto de venta)</small><strong>{{ $m($ventas['total']) }}</strong><em>{{ $n($ventas['n']) }} ventas</em></td>
            <td class="c5"><small>Pedidos</small><strong>{{ $n($pedidos['n']) }}</strong><em>{{ $n($pedidos['concluidos']) }} concluidos</em></td>
        </tr></table>

        <div class="caja"><h3>Ingresos vs egresos</h3>{!! $img('general') !!}</div>

        <div class="caja">
            <h3>Resumen del periodo</h3>
            <table class="t">
                <thead><tr><th>Concepto</th><th>Tipo</th><th class="der">Monto</th></tr></thead>
                <tbody>
                    <tr><td>Ventas del punto de venta</td><td><span class="etiqueta">Ingreso</span></td><td class="der">{{ $m($general['ingresos_ventas']) }}</td></tr>
                    <tr><td>Pedidos finalizados / terminados</td><td><span class="etiqueta">Ingreso</span></td><td class="der">{{ $m($general['ingresos_pedidos']) }}</td></tr>
                    <tr><td>Servicios registrados como ingreso</td><td><span class="etiqueta">Ingreso</span></td><td class="der">{{ $m($general['ingresos_servicios']) }}</td></tr>
                    <tr><td>Compras (gastos comerciales)</td><td><span class="etiqueta">Egreso</span></td><td class="der">{{ $m($general['egresos_gastos']) }}</td></tr>
                    <tr><td>Pagos de servicios</td><td><span class="etiqueta">Egreso</span></td><td class="der">{{ $m($general['egresos_servicios']) }}</td></tr>
                    <tr class="total"><td>Balance</td><td></td><td class="der {{ $general['balance'] >= 0 ? 'pos' : 'neg' }}">{{ $m($general['balance']) }}</td></tr>
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'ventas')
        <table class="tarjetas"><tr>
            <td><small>Total vendido</small><strong>{{ $m($ventas['total']) }}</strong></td>
            <td class="c2"><small>Núm. de ventas</small><strong>{{ $n($ventas['n']) }}</strong></td>
            <td class="c3"><small>Ticket promedio</small><strong>{{ $m($ventas['promedio']) }}</strong></td>
            <td class="c4"><small>Descuentos</small><strong>{{ $m($ventas['descuentos']) }}</strong></td>
            <td class="c5"><small>Impuestos</small><strong>{{ $m($ventas['impuestos']) }}</strong></td>
        </tr></table>

        <div class="caja"><h3>Ventas por periodo</h3>{!! $img('ventas') !!}</div>
        <div class="caja"><h3>Forma de pago</h3>{!! $img('formas') !!}</div>

        <div class="caja">
            <h3>Ventas por punto de venta</h3>
            <table class="t">
                <thead><tr><th>Caja</th><th>Sucursal</th><th class="der">Ventas</th><th class="der">Total</th></tr></thead>
                <tbody>
                @forelse($ventas['puntos'] as $p)
                    <tr><td>{{ $p->nombre_caja }}</td><td>{{ $p->sucursal }}</td><td class="der">{{ $n($p->n) }}</td><td class="der">{{ $m($p->total) }}</td></tr>
                @empty
                    <tr><td colspan="4" class="vacio">Sin ventas en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="caja">
            <h3>Más vendidos</h3>
            <table class="t">
                <thead><tr><th>Artículo</th><th class="der">Cantidad</th><th class="der">Importe</th></tr></thead>
                <tbody>
                @forelse($ventas['top'] as $p)
                    <tr><td>{{ $p->nombre }}</td><td class="der">{{ $n($p->cantidad) }}</td><td class="der">{{ $m($p->importe) }}</td></tr>
                @empty
                    <tr><td colspan="3" class="vacio">Sin ventas en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'categorias')
        <div class="caja"><h3>Ventas por categoría</h3>{!! $img('catVentas') !!}</div>
        <div class="caja"><h3>Gastos por categoría</h3>{!! $img('catGastos') !!}</div>

        <div class="caja">
            <h3>Detalle de ventas por categoría</h3>
            <table class="t">
                <thead><tr><th>Categoría</th><th class="der">Unidades</th><th class="der">Importe</th></tr></thead>
                <tbody>
                @forelse($categorias['ventas'] as $c)
                    <tr><td>{{ $c->nombre }}</td><td class="der">{{ $n($c->cantidad) }}</td><td class="der">{{ $m($c->importe) }}</td></tr>
                @empty
                    <tr><td colspan="3" class="vacio">Sin ventas en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="caja">
            <h3>Pedidos por categoría</h3>
            <table class="t">
                <thead><tr><th>Categoría</th><th class="der">Cantidad</th><th class="der">Importe</th></tr></thead>
                <tbody>
                @forelse($categorias['pedidos'] as $c)
                    <tr><td>{{ $c->nombre }}</td><td class="der">{{ $n($c->cantidad) }}</td><td class="der">{{ $m($c->importe) }}</td></tr>
                @empty
                    <tr><td colspan="3" class="vacio">Sin pedidos en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="caja">
            <h3>Gastos por categoría</h3>
            <table class="t">
                <thead><tr><th>Categoría</th><th class="der">Registros</th><th class="der">Total</th></tr></thead>
                <tbody>
                @forelse($categorias['gastos'] as $c)
                    <tr><td>{{ $c->nombre }}</td><td class="der">{{ $n($c->n) }}</td><td class="der">{{ $m($c->total) }}</td></tr>
                @empty
                    <tr><td colspan="3" class="vacio">Sin gastos en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'inventario')
        <p class="nota">El inventario muestra el estado actual; solo “Adquiridos en el periodo” depende de las fechas.</p>

        <table class="tarjetas"><tr>
            <td><small>Registros</small><strong>{{ $n($inventario['registros']) }}</strong><em>{{ $n($inventario['bienes']) }} bienes · {{ $n($inventario['servicios']) }} servicios</em></td>
            <td class="c2"><small>Unidades disponibles</small><strong>{{ $n($inventario['unidades']) }}</strong></td>
            <td class="c3"><small>Valor a precio de venta</small><strong>{{ $m($inventario['valor']) }}</strong><em>Precio × cantidad</em></td>
            <td class="c4"><small>Agotados</small><strong class="{{ $inventario['agotados'] ? 'neg' : '' }}">{{ $n($inventario['agotados']) }}</strong></td>
            <td class="c5"><small>Adquiridos en el periodo</small><strong>{{ $n($inventario['adquiridos']) }}</strong></td>
        </tr></table>

        <div class="caja"><h3>Unidades por categoría</h3>{!! $img('invCat') !!}</div>

        <div class="caja">
            <h3>Existencia baja (≤ {{ $inventario['stock_bajo'] }})</h3>
            <table class="t">
                <thead><tr><th>Nombre</th><th>Categoría</th><th class="der">Cantidad</th></tr></thead>
                <tbody>
                @forelse($inventario['bajo'] as $i)
                    <tr><td>{{ $i->nombre }}</td><td>{{ $i->categoria->nombre ?? 'Sin categoría' }}</td><td class="der {{ $i->cantidad == 0 ? 'neg' : '' }}">{{ $i->cantidad }}</td></tr>
                @empty
                    <tr><td colspan="3" class="vacio">No hay artículos con existencia baja.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="caja">
            <h3>Inventario por categoría</h3>
            <table class="t">
                <thead><tr><th>Categoría</th><th>Tipo</th><th class="der">Registros</th><th class="der">Unidades</th><th class="der">Valor</th></tr></thead>
                <tbody>
                @forelse($inventario['porCategoria'] as $c)
                    <tr><td>{{ $c->nombre }}</td><td><span class="etiqueta">{{ ucfirst($c->tipo) }}</span></td><td class="der">{{ $n($c->registros) }}</td><td class="der">{{ $n($c->unidades) }}</td><td class="der">{{ $m($c->valor) }}</td></tr>
                @empty
                    <tr><td colspan="5" class="vacio">Sin registros de inventario.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'pedidos')
        <table class="tarjetas"><tr>
            <td><small>Pedidos</small><strong>{{ $n($pedidos['n']) }}</strong></td>
            <td class="c2"><small>Monto cotizado</small><strong>{{ $m($pedidos['total']) }}</strong></td>
            <td class="c3"><small>Concluidos</small><strong>{{ $n($pedidos['concluidos']) }}</strong><em>Finalizados o terminados</em></td>
        </tr></table>

        <div class="caja"><h3>Pedidos por periodo</h3>{!! $img('pedidos') !!}</div>
        <div class="caja"><h3>Pedidos por estado</h3>{!! $img('estados') !!}</div>

        <div class="caja">
            <h3>Resumen por estado</h3>
            <table class="t">
                <thead><tr><th>Estado</th><th class="der">Pedidos</th><th class="der">Monto</th></tr></thead>
                <tbody>
                @forelse($pedidos['porEstado'] as $e)
                    <tr><td><span class="etiqueta">{{ ucfirst($e->estado) }}</span></td><td class="der">{{ $n($e->n) }}</td><td class="der">{{ $m($e->total) }}</td></tr>
                @empty
                    <tr><td colspan="3" class="vacio">Sin pedidos en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="caja">
            <h3>Servicios más solicitados</h3>
            <table class="t">
                <thead><tr><th>Servicio</th><th class="der">Cantidad</th><th class="der">Importe</th></tr></thead>
                <tbody>
                @forelse($pedidos['servicios'] as $x)
                    <tr><td>{{ $x->nombre }}</td><td class="der">{{ $n($x->cantidad) }}</td><td class="der">{{ $m($x->importe) }}</td></tr>
                @empty
                    <tr><td colspan="3" class="vacio">Sin pedidos en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="caja">
            <h3>Mejores clientes</h3>
            <table class="t">
                <thead><tr><th>Cliente</th><th class="der">Pedidos</th><th class="der">Total</th></tr></thead>
                <tbody>
                @forelse($pedidos['clientes'] as $c)
                    <tr><td>{{ $c->cliente }}</td><td class="der">{{ $n($c->n) }}</td><td class="der">{{ $m($c->total) }}</td></tr>
                @empty
                    <tr><td colspan="3" class="vacio">Sin pedidos en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'compras')
        <p class="nota">Las compras se calculan a partir de los gastos comerciales registrados.</p>

        <table class="tarjetas"><tr>
            <td><small>Total gastado</small><strong>{{ $m($compras['total']) }}</strong></td>
            <td class="c2"><small>Registros</small><strong>{{ $n($compras['n']) }}</strong></td>
            <td class="c3"><small>Promedio por registro</small><strong>{{ $m($compras['promedio']) }}</strong></td>
        </tr></table>

        <div class="caja"><h3>Gastos por periodo</h3>{!! $img('gastos') !!}</div>
        <div class="caja"><h3>Gastos por categoría</h3>{!! $img('catGastos2') !!}</div>

        <div class="caja">
            <h3>Últimos registros</h3>
            <table class="t">
                <thead><tr><th>Fecha</th><th>Concepto</th><th>Categoría</th><th class="der">Monto</th></tr></thead>
                <tbody>
                @forelse($compras['recientes'] as $g)
                    <tr><td>{{ $g->fecha->format('d/m/Y') }}</td><td>{{ $g->concepto }}</td><td>{{ $g->categoria->nombre ?? 'Sin categoría' }}</td><td class="der">{{ $m($g->monto) }}</td></tr>
                @empty
                    <tr><td colspan="4" class="vacio">Sin gastos en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'pagos')
        <table class="tarjetas"><tr>
            <td><small>Pagado (egresos)</small><strong class="neg">{{ $m($pagos['egresos']) }}</strong></td>
            <td class="c2"><small>Recibido (ingresos)</small><strong class="pos">{{ $m($pagos['ingresos']) }}</strong></td>
            <td class="c3"><small>Recibos del periodo</small><strong>{{ $n($pagos['n']) }}</strong></td>
            <td class="c4"><small>Pendientes</small><strong>{{ $n($pagos['pendientes_n']) }}</strong><em>{{ $m($pagos['pendientes_monto']) }} · {{ $n($pagos['vencidos']) }} vencidos</em></td>
        </tr></table>

        <div class="caja"><h3>Monto por servicio</h3>{!! $img('servicios') !!}</div>

        <div class="caja">
            <h3>Próximos vencimientos</h3>
            <table class="t">
                <thead><tr><th>Servicio</th><th>Vence</th><th class="der">Monto</th></tr></thead>
                <tbody>
                @forelse($pagos['proximos'] as $p)
                    <tr>
                        <td>{{ $p->servicio }}</td>
                        <td class="{{ $p->fecha_vencimiento && $p->fecha_vencimiento->isPast() ? 'neg' : '' }}">{{ $f($p->fecha_vencimiento) }}</td>
                        <td class="der">{{ $p->monto !== null ? $m($p->monto) : '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="vacio">No hay pagos pendientes.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="caja">
            <h3>Detalle por servicio</h3>
            <table class="t">
                <thead><tr><th>Servicio</th><th>Tipo</th><th class="der">Recibos</th><th class="der">Total</th></tr></thead>
                <tbody>
                @forelse($pagos['porServicio'] as $x)
                    <tr><td>{{ $x->servicio }}</td><td><span class="etiqueta">{{ ucfirst($x->tipo_movimiento) }}</span></td><td class="der">{{ $n($x->n) }}</td><td class="der">{{ $m($x->total) }}</td></tr>
                @empty
                    <tr><td colspan="4" class="vacio">Sin recibos en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endforeach
</main>
</body>
</html>