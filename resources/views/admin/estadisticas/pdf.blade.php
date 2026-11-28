@php
    $empresa = [
        'nombre'   => 'Orquídeas y más "Los Amates"',
        'contacto' => '',
    ];
    $rutaLogo = public_path('images/logo-los-amates.png');
    $logo = file_exists($rutaLogo)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($rutaLogo))
        : null;

    $m = fn ($v) => '$' . number_format((float) $v, 2);
    $n = fn ($v) => number_format((float) $v);
    $f = fn ($v) => $v ? \Carbon\Carbon::parse($v)->format('d/m/Y') : '—';
    $img = fn ($k) => !empty($imagenes[$k])
        ? '<img class="graf" src="' . $imagenes[$k] . '">'
        : '<div class="vacio">Gráfica no disponible.</div>';

    $titulos = [
        'general' => 'Reporte general', 'ventas' => 'Ventas', 'puntos' => 'Ventas por punto de venta',
        'descuentos' => 'Descuentos aplicados', 'categorias' => 'Categorías',
        'inventario' => 'Inventario', 'pedidos' => 'Pedidos', 'compras' => 'Compras',
        'pagos' => 'Pagos de servicios', 'completo' => 'Reporte completo',
    ];
    $secciones = $seccion === 'completo'
        ? ['general', 'ventas', 'puntos', 'descuentos', 'categorias', 'inventario', 'pedidos', 'compras', 'pagos']
        : [$seccion];

    $folio = 'RPT-' . now()->format('Ymd-His');
    $generadoPor = trim((auth()->user()->name ?? '') . ' ' . (auth()->user()->apellido ?? ''));
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>{{ $titulos[$seccion] }} - {{ $empresa['nombre'] }}</title>
<style>
    @page { margin: 88px 40px 50px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 8.5px; color: #111827; line-height: 1.35; }

    header { position: fixed; top: -72px; left: 0; right: 0; height: 60px; border-bottom: 2px solid #6d28d9; }
    header table { width: 100%; border-collapse: collapse; }
    header td { vertical-align: middle; padding: 0 0 6px; }
    .logo { height: 40px; }
    .emp-nombre { font-size: 12px; font-weight: bold; color: #4c1d95; }
    .emp-contacto { font-size: 7px; color: #6b7280; margin-top: 2px; }
    .rep-titulo { text-align: right; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: .8px; color: #6d28d9; }
    .rep-sub { text-align: right; font-size: 7.5px; color: #4b5563; margin-top: 2px; }

    footer { position: fixed; bottom: -34px; left: 0; right: 0; border-top: 1px solid #c4b5fd; padding-top: 4px; font-size: 7px; color: #6b7280; }
    footer table { width: 100%; border-collapse: collapse; }
    footer td { padding: 0; }
    .pagenum:before { content: counter(page); }

    table.meta { width: 100%; border-collapse: collapse; margin: 0 0 10px; border: 1px solid #c4b5fd; }
    table.meta td { padding: 4px 7px; font-size: 8px; border-right: 1px solid #ddd6fe; background: #faf8ff; }
    table.meta td:last-child { border-right: none; }
    table.meta b { display: block; font-size: 6.5px; text-transform: uppercase; letter-spacing: .5px; color: #6d28d9; font-weight: normal; }

    h2 { margin: 0 0 8px; padding: 4px 8px; font-size: 10.5px; color: #fff; background: #6d28d9; text-transform: uppercase; letter-spacing: .8px; }
    h3 { margin: 0 0 5px; padding-left: 6px; border-left: 3px solid #6d28d9; font-size: 8.5px; color: #111827; text-transform: uppercase; letter-spacing: .4px; }
    .salto { page-break-before: always; }
    .nota { margin: 0 0 8px; padding: 4px 8px; background: #f5f3ff; border-left: 3px solid #6d28d9; font-size: 7.5px; color: #4c1d95; }

    table.ind { width: 100%; table-layout: fixed; border-collapse: collapse; margin: 0 0 10px; border: 1px solid #c4b5fd; }
    table.ind td { padding: 6px 8px; vertical-align: top; border-right: 1px solid #ddd6fe; border-top: 3px solid #6d28d9; background: #fff; }
    table.ind td:nth-child(5n+2) { border-top-color: #059669; }
    table.ind td:nth-child(5n+3) { border-top-color: #2563eb; }
    table.ind td:nth-child(5n+4) { border-top-color: #d97706; }
    table.ind td:nth-child(5n+5) { border-top-color: #0d9488; }
    table.ind td:last-child { border-right: none; }
    table.ind small { display: block; font-size: 6.5px; letter-spacing: .5px; text-transform: uppercase; color: #6b7280; }
    table.ind strong { display: block; margin: 3px 0 1px; font-size: 11.5px; color: #111827; }
    table.ind em { display: block; font-style: normal; font-size: 6.5px; color: #6b7280; }

    .caja { margin: 0 0 12px; page-break-inside: avoid; }
    .caja.libre { page-break-inside: auto; }
    .graf { width: 100%; border: 1px solid #ddd6fe; }
    table.t { width: 100%; border-collapse: collapse; }
    table.t th { text-align: left; font-size: 7px; text-transform: uppercase; letter-spacing: .4px; color: #4c1d95; padding: 4px 5px; border-top: 1px solid #6d28d9; border-bottom: 1px solid #6d28d9; background: #f5f3ff; }
    table.t td { padding: 3.5px 5px; border-bottom: 1px solid #ece9f5; }
    table.t tbody tr:nth-child(even) td { background: #faf9fd; }
    table.t tr.total td { font-weight: bold; border-top: 1px solid #6d28d9; border-bottom: 1px solid #6d28d9; background: #f5f3ff; color: #4c1d95; }
    .der { text-align: right; }
    .neg { color: #b91c1c; }
    .vacio { color: #6b7280; padding: 6px 0; text-align: center; font-style: italic; }
</style>
</head>
<body>
<header>
    <table><tr>
        <td style="width:50px">@if($logo)<img class="logo" src="{{ $logo }}">@endif</td>
        <td>
            <div class="emp-nombre">{{ $empresa['nombre'] }}</div>
            @if($empresa['contacto'])<div class="emp-contacto">{{ $empresa['contacto'] }}</div>@endif
        </td>
        <td style="width:38%">
            <div class="rep-titulo">{{ $titulos[$seccion] }}</div>
            <div class="rep-sub">Periodo: {{ $inicio->format('d/m/Y') }} al {{ $fin->format('d/m/Y') }}</div>
        </td>
    </tr></table>
</header>

<footer>
    <table><tr>
        <td>{{ $empresa['nombre'] }} · Folio {{ $folio }} · Documento de uso interno y confidencial</td>
        <td style="text-align:right">Página <span class="pagenum"></span></td>
    </tr></table>
</footer>

<main>
    <table class="meta"><tr>
        <td><b>Reporte</b>{{ $titulos[$seccion] }}</td>
        <td><b>Periodo</b>{{ $inicio->format('d/m/Y') }} al {{ $fin->format('d/m/Y') }}</td>
        <td><b>Fecha de emisión</b>{{ now()->format('d/m/Y H:i') }}</td>
        <td><b>Elaborado por</b>{{ $generadoPor ?: '—' }}</td>
        <td><b>Folio</b>{{ $folio }}</td>
    </tr></table>

@foreach($secciones as $s)
<div class="{{ $seccion === 'completo' && !$loop->first ? 'salto' : '' }}">
    @if($seccion === 'completo')<h2>{{ $loop->iteration }}. {{ $titulos[$s] }}</h2>@endif
    @if($s === 'general')
        <table class="ind"><tr>
            <td><small>Ingresos</small><strong>{{ $m($general['ingresos']) }}</strong><em>Ventas + pedidos + servicios</em></td>
            <td><small>Egresos</small><strong>{{ $m($general['egresos']) }}</strong><em>Compras + pagos de servicios</em></td>
            <td><small>Balance</small><strong class="{{ $general['balance'] < 0 ? 'neg' : '' }}">{{ $m($general['balance']) }}</strong><em>Ingresos − egresos</em></td>
            <td><small>Ventas (punto de venta)</small><strong>{{ $m($ventas['total']) }}</strong><em>{{ $n($ventas['n']) }} ventas</em></td>
            <td><small>Pedidos</small><strong>{{ $n($pedidos['n']) }}</strong><em>{{ $n($pedidos['concluidos']) }} concluidos</em></td>
        </tr></table>

        <div class="caja"><h3>Ingresos vs egresos</h3>{!! $img('general') !!}</div>

        <div class="caja">
            <h3>Resumen del periodo</h3>
            <table class="t">
                <thead><tr><th>Concepto</th><th>Tipo</th><th class="der">Monto</th></tr></thead>
                <tbody>
                    <tr><td>Ventas del punto de venta</td><td>Ingreso</td><td class="der">{{ $m($general['ingresos_ventas']) }}</td></tr>
                    <tr><td>Pedidos finalizados / terminados</td><td>Ingreso</td><td class="der">{{ $m($general['ingresos_pedidos']) }}</td></tr>
                    <tr><td>Servicios registrados como ingreso</td><td>Ingreso</td><td class="der">{{ $m($general['ingresos_servicios']) }}</td></tr>
                    <tr><td>Compras (gastos comerciales)</td><td>Egreso</td><td class="der">{{ $m($general['egresos_gastos']) }}</td></tr>
                    <tr><td>Pagos de servicios</td><td>Egreso</td><td class="der">{{ $m($general['egresos_servicios']) }}</td></tr>
                    <tr class="total"><td>Balance</td><td></td><td class="der {{ $general['balance'] < 0 ? 'neg' : '' }}">{{ $m($general['balance']) }}</td></tr>
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'ventas')
        <table class="ind"><tr>
            <td><small>Total vendido</small><strong>{{ $m($ventas['total']) }}</strong></td>
            <td><small>Núm. de ventas</small><strong>{{ $n($ventas['n']) }}</strong></td>
            <td><small>Ticket promedio</small><strong>{{ $m($ventas['promedio']) }}</strong></td>
            <td><small>Descuentos</small><strong>{{ $m($ventas['descuentos']) }}</strong></td>
            <td><small>Impuestos</small><strong>{{ $m($ventas['impuestos']) }}</strong></td>
        </tr></table>

        <p class="nota">
            Pedidos en línea considerados: {{ $n($pedidos['concluidos']) }} ({{ $m($general['ingresos_pedidos']) }}, solo finalizados/terminados).
            Pedidos pendientes excluidos de los ingresos: {{ $n($ventas['pedidos_pendientes']) }}.
        </p>

        <div class="caja"><h3>Ventas por periodo</h3>{!! $img('ventas') !!}</div>
        <div class="caja"><h3>Ingresos por mes</h3>{!! $img('ventasMes') !!}</div>
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
    @if($s === 'puntos')
        <table class="ind"><tr>
            <td><small>Puntos con ventas</small><strong>{{ $n($ventas['puntos']->count()) }}</strong></td>
            <td><small>Ingresos</small><strong>{{ $m($ventas['total']) }}</strong></td>
            <td><small>Ventas</small><strong>{{ $n($ventas['n']) }}</strong></td>
            <td><small>Promedio</small><strong>{{ $m($ventas['promedio']) }}</strong></td>
        </tr></table>

        <div class="caja"><h3>Ingresos por punto de venta</h3>{!! $img('puntos') !!}</div>

        <div class="caja">
            <h3>Comparativa</h3>
            <table class="t">
                <thead><tr><th>Caja</th><th>Sucursal</th><th class="der">Ventas</th><th class="der">Ingresos</th><th class="der">Promedio</th></tr></thead>
                <tbody>
                @forelse($ventas['puntos'] as $p)
                    <tr><td>{{ $p->nombre_caja }}</td><td>{{ $p->sucursal }}</td><td class="der">{{ $n($p->n) }}</td><td class="der">{{ $m($p->total) }}</td><td class="der">{{ $m($p->promedio) }}</td></tr>
                @empty
                    <tr><td colspan="5" class="vacio">Sin ventas en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'descuentos')
        <p class="nota">Solo se consideran descuentos de ventas completadas; los pedidos pendientes no se incluyen.</p>

        <table class="ind"><tr>
            <td><small>Total descontado</small><strong>{{ $m($descuentos['total']) }}</strong></td>
            <td><small>Líneas con descuento</small><strong>{{ $n($descuentos['n']) }}</strong></td>
            <td><small>Precio original</small><strong>{{ $m($descuentos['original']) }}</strong></td>
            <td><small>Descuento promedio</small><strong>{{ number_format($descuentos['promedio'], 1) }}%</strong></td>
        </tr></table>

        <div class="caja"><h3>Descuento por producto</h3>{!! $img('descProd') !!}</div>

        <div class="caja libre">
            <h3>Detalle de descuentos</h3>
            <table class="t">
                <thead><tr><th>Folio</th><th>Fecha</th><th>Producto</th><th class="der">Original</th><th class="der">%</th><th class="der">Descontado</th><th class="der">Final</th></tr></thead>
                <tbody>
                @forelse($descuentos['filas'] as $d)
                    <tr><td>{{ $d->folio }}</td><td>{{ $f($d->fecha) }}</td><td>{{ $d->nombre }}</td><td class="der">{{ $m($d->precio_original) }}</td><td class="der">{{ number_format($d->porcentaje, 1) }}%</td><td class="der">{{ $m($d->descontado) }}</td><td class="der">{{ $m($d->precio_final) }}</td></tr>
                @empty
                    <tr><td colspan="7" class="vacio">Sin descuentos con esos criterios.</td></tr>
                @endforelse
                <tr class="total"><td colspan="5">Total descontado</td><td class="der">{{ $m($descuentos['total']) }}</td><td></td></tr>
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'categorias')
        <div class="caja"><h3>Ventas por categoría</h3>{!! $img('catVentas') !!}</div>
        <div class="caja"><h3>Gastos por categoría</h3>{!! $img('catGastos') !!}</div>
        <div class="caja"><h3>Registros por categoría</h3>{!! $img('catRegistros') !!}</div>

        <div class="caja libre">
            <h3>Categorías registradas</h3>
            <table class="t">
                <thead><tr><th>Nombre</th><th>Tipo</th><th>Descripción</th><th class="der">Inventario</th><th class="der">Gastos (periodo)</th></tr></thead>
                <tbody>
                @forelse($categorias['lista'] as $c)
                    <tr><td>{{ $c->nombre }}</td><td>{{ $c->tipo_etiqueta }}</td><td>{{ $c->descripcion ?: '—' }}</td><td class="der">{{ $n($c->inventarios_count) }}</td><td class="der">{{ $n($c->gastos_periodo_count) }}</td></tr>
                @empty
                    <tr><td colspan="5" class="vacio">Sin categorías con esos criterios.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

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
        <p class="nota">El inventario refleja el estado actual; solo “Adquiridos en el periodo” depende de las fechas seleccionadas.</p>

        <table class="ind"><tr>
            <td><small>Registros</small><strong>{{ $n($inventario['registros']) }}</strong><em>{{ $n($inventario['bienes']) }} bienes · {{ $n($inventario['servicios']) }} servicios</em></td>
            <td><small>Unidades disponibles</small><strong>{{ $n($inventario['unidades']) }}</strong></td>
            <td><small>Valor a precio de venta</small><strong>{{ $m($inventario['valor']) }}</strong><em>Precio × cantidad</em></td>
            <td><small>Agotados</small><strong class="{{ $inventario['agotados'] ? 'neg' : '' }}">{{ $n($inventario['agotados']) }}</strong></td>
            <td><small>Adquiridos en el periodo</small><strong>{{ $n($inventario['adquiridos']) }}</strong></td>
        </tr></table>

        <div class="caja"><h3>Registros por categoría</h3>{!! $img('invCat') !!}</div>

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
                    <tr><td>{{ $c->nombre }}</td><td>{{ ucfirst($c->tipo) }}</td><td class="der">{{ $n($c->registros) }}</td><td class="der">{{ $n($c->unidades) }}</td><td class="der">{{ $m($c->valor) }}</td></tr>
                @empty
                    <tr><td colspan="5" class="vacio">Sin registros de inventario.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="caja libre">
            <h3>Registros del inventario</h3>
            <table class="t">
                <thead><tr><th>Nombre</th><th>Tipo</th><th>Categoría</th><th class="der">Precio</th><th class="der">Existencia</th></tr></thead>
                <tbody>
                @forelse($inventario['lista'] as $i)
                    <tr><td>{{ $i->nombre }}</td><td>{{ ucfirst($i->tipo) }}</td><td>{{ $i->categoria->nombre ?? 'Sin categoría' }}</td><td class="der">{{ $m($i->precio) }}</td><td class="der {{ $i->cantidad == 0 ? 'neg' : '' }}">{{ $i->cantidad }}</td></tr>
                @empty
                    <tr><td colspan="5" class="vacio">Sin registros.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'pedidos')
        <table class="ind"><tr>
            <td><small>Pedidos</small><strong>{{ $n($pedidos['n']) }}</strong></td>
            <td><small>Monto cotizado</small><strong>{{ $m($pedidos['total']) }}</strong></td>
            <td><small>Concluidos</small><strong>{{ $n($pedidos['concluidos']) }}</strong><em>Finalizados o terminados</em></td>
        </tr></table>

        <div class="caja"><h3>Pedidos por periodo</h3>{!! $img('pedidos') !!}</div>
        <div class="caja"><h3>Pedidos por estado</h3>{!! $img('estados') !!}</div>

        <div class="caja">
            <h3>Resumen por estado</h3>
            <table class="t">
                <thead><tr><th>Estado</th><th class="der">Pedidos</th><th class="der">Monto</th></tr></thead>
                <tbody>
                @forelse($pedidos['porEstado'] as $e)
                    <tr><td>{{ ucfirst($e->estado) }}</td><td class="der">{{ $n($e->n) }}</td><td class="der">{{ $m($e->total) }}</td></tr>
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

        <table class="ind"><tr>
            <td><small>Total gastado</small><strong>{{ $m($compras['total']) }}</strong></td>
            <td><small>Registros</small><strong>{{ $n($compras['n']) }}</strong></td>
            <td><small>Promedio por registro</small><strong>{{ $m($compras['promedio']) }}</strong></td>
        </tr></table>

        <div class="caja"><h3>Gastos por periodo</h3>{!! $img('gastos') !!}</div>
        <div class="caja"><h3>Gastos por categoría</h3>{!! $img('catGastos2') !!}</div>

        <div class="caja libre">
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

        <div class="caja libre">
            <h3>Bienes adquiridos en el periodo</h3>
            <table class="t">
                <thead><tr><th>Fecha</th><th>Bien</th><th>Categoría</th><th class="der">Cantidad</th><th class="der">Costo</th></tr></thead>
                <tbody>
                @forelse($compras['bienes'] as $b)
                    <tr><td>{{ $f($b->fecha_adquisicion) }}</td><td>{{ $b->nombre }}</td><td>{{ $b->categoria->nombre ?? 'Sin categoría' }}</td><td class="der">{{ $n($b->cantidad) }}</td><td class="der">{{ $b->costo !== null ? $m($b->costo) : '—' }}</td></tr>
                @empty
                    <tr><td colspan="5" class="vacio">Sin bienes adquiridos en el periodo.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
    @if($s === 'pagos')
        <table class="ind"><tr>
            <td><small>Monto registrado</small><strong>{{ $m($pagos['registrado']) }}</strong><em>{{ $n($pagos['lista']->count()) }} servicios</em></td>
            <td><small>Pagado</small><strong>{{ $m($pagos['pagado_periodo']) }}</strong></td>
            <td><small>Pendiente</small><strong class="neg">{{ $m($pagos['pendiente_periodo']) }}</strong><em>{{ $n($pagos['pendientes_n']) }} pendientes · {{ $n($pagos['vencidos']) }} vencidos</em></td>
            <td><small>Egresos por recibos</small><strong>{{ $m($pagos['egresos']) }}</strong></td>
            <td><small>Recibos del periodo</small><strong>{{ $n($pagos['n']) }}</strong></td>
        </tr></table>
        <div class="caja"><h3>Monto por servicio</h3>{!! $img('servicios') !!}</div>
        <div class="caja libre">
            <h3>Servicios del periodo</h3>
            <table class="t">
                <thead><tr><th>Servicio</th><th>Estado</th><th>Vence</th><th class="der">Monto</th></tr></thead>
                <tbody>
                @forelse($pagos['lista'] as $x)
                    <tr><td>{{ $x->servicio }}</td><td>{{ $x->estado }}</td><td>{{ $f($x->fecha_vencimiento) }}</td><td class="der">{{ $x->monto !== null ? $m($x->monto) : '—' }}</td></tr>
                @empty
                    <tr><td colspan="4" class="vacio">Sin servicios con esos criterios.</td></tr>
                @endforelse
                <tr class="total"><td colspan="3">Pagado / Pendiente</td><td class="der">{{ $m($pagos['pagado_periodo']) }} / {{ $m($pagos['pendiente_periodo']) }}</td></tr>
                </tbody>
            </table>
        </div>

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
                    <tr><td>{{ $x->servicio }}</td><td>{{ ucfirst($x->tipo_movimiento) }}</td><td class="der">{{ $n($x->n) }}</td><td class="der">{{ $m($x->total) }}</td></tr>
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