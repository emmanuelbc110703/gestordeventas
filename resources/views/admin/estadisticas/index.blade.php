@php
    $m = fn ($v) => '$' . number_format((float) $v, 2);
    $n = fn ($v) => number_format((float) $v);
    $f = fn ($v) => $v ? \Carbon\Carbon::parse($v)->format('d/m/Y') : '—';

    $atajos = [
        'Hoy'             => [now(), now()],
        'Este mes'        => [now()->startOfMonth(), now()],
        'Mes pasado'      => [now()->subMonthNoOverflow()->startOfMonth(), now()->subMonthNoOverflow()->endOfMonth()],
        'Últimos 30 días' => [now()->subDays(29), now()],
        'Este año'        => [now()->startOfYear(), now()],
    ];
@endphp

<x-layouts.panel
    titulo="Estadísticas del negocio"
    :migas="[['texto' => 'Estadísticas del negocio']]">

    <x-lista-estilos />
    <x-sidebar activo="estadisticas" />

    @push('estilos')
    <style>
        .est-pagina { padding: 8px 0 56px; }
        .est-pagina .lst-encabezado { flex-wrap: wrap; }

        .est-filtros { display:flex; flex-wrap:wrap; align-items:center; gap:8px; }
        .est-atajos { display:flex; flex-wrap:wrap; gap:6px; }
        .est-atajos a { display:inline-flex; align-items:center; height:40px; padding:0 14px; border:1px solid var(--borde); background:#fff; color:var(--texto-suave); font-size:13px; font-weight:500; text-decoration:none; transition:border-color .2s ease, color .2s ease; }
        .est-atajos a:hover { color:var(--primario); border-color:var(--primario); }
        .est-atajos a.activo { background:var(--primario-suave); color:var(--primario); border-color:var(--primario); font-weight:600; }
        .est-filtros input[type=date] { height:40px; padding:0 10px; border:1px solid var(--borde); border-radius:0; font:inherit; font-size:13px; background:#fff; color:var(--texto); outline:none; }
        .est-filtros input[type=date]:focus { border-color:var(--primario); box-shadow:0 0 0 3px rgba(109,40,217,.1); }
        .est-btn { height:40px; padding:0 20px; border:none; border-radius:0; background:var(--primario); color:#fff; font:inherit; font-size:13px; font-weight:600; cursor:pointer; transition:background .2s ease; }
        .est-btn:hover { background:var(--primario-oscuro); }

        .est-tabs { display:flex; gap:0; overflow-x:auto; border-bottom:1px solid var(--borde); margin-bottom:28px; }
        .est-tab { padding:12px 20px; border:none; background:none; font:inherit; font-size:12px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--texto-suave); cursor:pointer; border-bottom:2px solid transparent; margin-bottom:-1px; white-space:nowrap; transition:color .2s ease; }
        .est-tab:hover { color:var(--primario); }
        .est-tab.activo { color:var(--primario); border-bottom-color:var(--primario); }
        .est-panel { display:none; }
        .est-panel.activo { display:block; }

        .est-tarjetas { display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:24px; margin-bottom:28px; }
        .est-tarjeta { --ac:#6d28d9; background:#fff; border:1px solid var(--borde); border-top:2px solid var(--ac); padding:20px 22px; transition:box-shadow .2s ease, border-color .2s ease; }
        .est-tarjeta:hover { border-color:var(--ac); box-shadow:0 3px 10px rgba(0,0,0,.07); }
        .est-tarjeta:nth-child(5n+2) { --ac:#059669; }
        .est-tarjeta:nth-child(5n+3) { --ac:#2563eb; }
        .est-tarjeta:nth-child(5n+4) { --ac:#d97706; }
        .est-tarjeta:nth-child(5n+5) { --ac:#0d9488; }
        .est-tarjeta small { display:block; font-size:12px; font-weight:600; letter-spacing:.08em; text-transform:uppercase; color:var(--texto-suave); }
        .est-tarjeta strong { display:block; margin-top:14px; font-size:30px; font-weight:700; line-height:1; letter-spacing:-.02em; font-variant-numeric:tabular-nums; color:var(--texto); }
        .est-tarjeta span { display:block; margin-top:14px; padding-top:10px; border-top:1px solid #f0f0f3; font-size:12px; color:var(--texto-suave); }
        .est-positivo { color:#047857 !important; } .est-negativo { color:#b91c1c !important; }

        .est-rejilla { display:grid; grid-template-columns:repeat(auto-fit, minmax(340px, 1fr)); gap:24px; margin-bottom:24px; }
        .est-caja { background:#fff; border:1px solid var(--borde); border-top:2px solid var(--primario); padding:24px; min-width:0; }
        .est-caja h3 { margin:0 0 18px; font-size:15px; font-weight:600; color:var(--texto); }
        .est-grafica { position:relative; height:280px; }
        .est-scroll { overflow-x:auto; }
        .est-tabla { width:100%; border-collapse:collapse; font-size:14px; }
        .est-tabla th { text-align:left; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.06em; color:#9ca3af; padding:8px 10px; border-bottom:1px solid var(--borde); }
        .est-tabla td { padding:11px 10px; border-bottom:1px solid #f0f0f3; font-variant-numeric:tabular-nums; }
        .est-tabla tr:last-child td { border-bottom:none; }
        .est-tabla tbody tr:hover td { background:#fafafc; }
        .est-der { text-align:right !important; }
        .est-vacio { padding:28px 0; text-align:center; color:var(--texto-suave); font-size:13px; }
        .est-nota { margin:0 0 24px; padding:12px 16px; background:var(--primario-suave); border-left:3px solid var(--primario); font-size:13px; color:var(--primario-oscuro); }
        .est-etiqueta { display:inline-block; padding:2px 10px; background:#eef0f4; font-size:11px; font-weight:600; letter-spacing:.04em; color:var(--texto-suave); }

        @media (max-width: 650px) {
            .est-tarjetas, .est-rejilla { grid-template-columns:1fr; gap:16px; }
            .est-tarjeta strong { font-size:26px; }
            .est-grafica { height:230px; }
        }
    </style>
    @endpush

    <div class="lst-pagina est-pagina">
        <div class="lst-encabezado">
            <div>
                <div class="lst-titulo-fila">
                    <button type="button" class="sb-cerrar" id="sbCerrar" aria-label="Ocultar menú lateral" title="Ocultar menú">
                        <i class="fa-solid fa-bars ic-barras"></i>
                        <i class="fa-solid fa-arrow-left ic-flecha"></i>
                    </button>
                    <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1>Estadísticas del negocio</h1>
                </div>
                <p>Del {{ $inicio->translatedFormat('d M Y') }} al {{ $fin->translatedFormat('d M Y') }}</p>
            </div>

            <form method="GET" action="{{ route('admin.estadisticas') }}" class="est-filtros" id="formFiltros">
                <div class="est-atajos">
                    @foreach($atajos as $texto => [$a, $b])
                        <a data-atajo
                        href="{{ route('admin.estadisticas', ['desde' => $a->toDateString(), 'hasta' => $b->toDateString()]) }}"
                        class="{{ $a->toDateString() === $inicio->toDateString() && $b->toDateString() === $fin->toDateString() ? 'activo' : '' }}">
                            {{ $texto }}
                        </a>
                    @endforeach
                </div>
                <input type="date" name="desde" value="{{ $inicio->toDateString() }}">
                <input type="date" name="hasta" value="{{ $fin->toDateString() }}">
                <button class="est-btn" type="submit">Aplicar</button>
            </form>
        </div>
    

        <div class="est-tabs" id="estTabs">
            <button class="est-tab activo" data-tab="general">Reporte general</button>
            <button class="est-tab" data-tab="ventas">Ventas</button>
            <button class="est-tab" data-tab="categorias">Categorías</button>
            <button class="est-tab" data-tab="inventario">Inventario</button>
            <button class="est-tab" data-tab="pedidos">Pedidos</button>
            <button class="est-tab" data-tab="compras">Compras</button>
            <button class="est-tab" data-tab="pagos">Pagos de servicios</button>
        </div>
        <section class="est-panel activo" id="tab-general">
            <div class="est-tarjetas">
                <div class="est-tarjeta"><small>Ingresos</small><strong class="est-positivo">{{ $m($general['ingresos']) }}</strong><span>Ventas + pedidos concluidos + servicios</span></div>
                <div class="est-tarjeta"><small>Egresos</small><strong class="est-negativo">{{ $m($general['egresos']) }}</strong><span>Compras (gastos) + pagos de servicios</span></div>
                <div class="est-tarjeta"><small>Balance</small><strong class="{{ $general['balance'] >= 0 ? 'est-positivo' : 'est-negativo' }}">{{ $m($general['balance']) }}</strong><span>Ingresos − egresos</span></div>
                <div class="est-tarjeta"><small>Ventas (punto de venta)</small><strong>{{ $m($ventas['total']) }}</strong><span>{{ $n($ventas['n']) }} ventas</span></div>
                <div class="est-tarjeta"><small>Pedidos</small><strong>{{ $n($pedidos['n']) }}</strong><span>{{ $n($pedidos['concluidos']) }} concluidos</span></div>
            </div>

            <div class="est-caja" style="margin-bottom:16px">
                <h3>Ingresos vs egresos</h3>
                <div class="est-grafica"><canvas id="g-general"></canvas></div>
            </div>

            <div class="est-caja">
                <h3>Resumen del periodo</h3>
                <div class="est-scroll">
                    <table class="est-tabla">
                        <thead><tr><th>Concepto</th><th>Tipo</th><th class="est-der">Monto</th></tr></thead>
                        <tbody>
                            <tr><td>Ventas del punto de venta</td><td>Ingreso</td><td class="est-der">{{ $m($general['ingresos_ventas']) }}</td></tr>
                            <tr><td>Pedidos finalizados / terminados</td><td>Ingreso</td><td class="est-der">{{ $m($general['ingresos_pedidos']) }}</td></tr>
                            <tr><td>Servicios registrados como ingreso</td><td>Ingreso</td><td class="est-der">{{ $m($general['ingresos_servicios']) }}</td></tr>
                            <tr><td>Compras (gastos comerciales)</td><td>Egreso</td><td class="est-der">{{ $m($general['egresos_gastos']) }}</td></tr>
                            <tr><td>Pagos de servicios</td><td>Egreso</td><td class="est-der">{{ $m($general['egresos_servicios']) }}</td></tr>
                            <tr><td><strong>Balance</strong></td><td></td><td class="est-der"><strong>{{ $m($general['balance']) }}</strong></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <section class="est-panel" id="tab-ventas">
            <div class="est-tarjetas">
                <div class="est-tarjeta"><small>Total vendido</small><strong>{{ $m($ventas['total']) }}</strong></div>
                <div class="est-tarjeta"><small>Número de ventas</small><strong>{{ $n($ventas['n']) }}</strong></div>
                <div class="est-tarjeta"><small>Ticket promedio</small><strong>{{ $m($ventas['promedio']) }}</strong></div>
                <div class="est-tarjeta"><small>Descuentos</small><strong>{{ $m($ventas['descuentos']) }}</strong></div>
                <div class="est-tarjeta"><small>Impuestos</small><strong>{{ $m($ventas['impuestos']) }}</strong></div>
            </div>

            <div class="est-rejilla">
                <div class="est-caja"><h3>Ventas por periodo</h3><div class="est-grafica"><canvas id="g-ventas"></canvas></div></div>
                <div class="est-caja"><h3>Forma de pago</h3><div class="est-grafica"><canvas id="g-formas"></canvas></div></div>
            </div>

            <div class="est-rejilla">
                <div class="est-caja">
                    <h3>Ventas por punto de venta</h3>
                    @forelse($ventas['puntos'] as $p)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Caja</th><th>Sucursal</th><th class="est-der">Ventas</th><th class="est-der">Total</th></tr></thead><tbody>@endif
                        <tr><td>{{ $p->nombre_caja }}</td><td>{{ $p->sucursal }}</td><td class="est-der">{{ $n($p->n) }}</td><td class="est-der">{{ $m($p->total) }}</td></tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">Sin ventas en el periodo.</div>
                    @endforelse
                </div>
                <div class="est-caja">
                    <h3>Más vendidos</h3>
                    @forelse($ventas['top'] as $p)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Artículo</th><th class="est-der">Cantidad</th><th class="est-der">Importe</th></tr></thead><tbody>@endif
                        <tr><td>{{ $p->nombre }}</td><td class="est-der">{{ $n($p->cantidad) }}</td><td class="est-der">{{ $m($p->importe) }}</td></tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">Sin ventas en el periodo.</div>
                    @endforelse
                </div>
            </div>
        </section>
        <section class="est-panel" id="tab-categorias">
            <div class="est-rejilla">
                <div class="est-caja"><h3>Ventas por categoría</h3><div class="est-grafica"><canvas id="g-catVentas"></canvas></div></div>
                <div class="est-caja"><h3>Gastos por categoría</h3><div class="est-grafica"><canvas id="g-catGastos"></canvas></div></div>
            </div>

            <div class="est-rejilla">
                <div class="est-caja">
                    <h3>Ventas por categoría</h3>
                    @forelse($categorias['ventas'] as $c)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Categoría</th><th class="est-der">Unidades</th><th class="est-der">Importe</th></tr></thead><tbody>@endif
                        <tr><td>{{ $c->nombre }}</td><td class="est-der">{{ $n($c->cantidad) }}</td><td class="est-der">{{ $m($c->importe) }}</td></tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">Sin ventas en el periodo.</div>
                    @endforelse
                </div>
                <div class="est-caja">
                    <h3>Pedidos por categoría</h3>
                    @forelse($categorias['pedidos'] as $c)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Categoría</th><th class="est-der">Cantidad</th><th class="est-der">Importe</th></tr></thead><tbody>@endif
                        <tr><td>{{ $c->nombre }}</td><td class="est-der">{{ $n($c->cantidad) }}</td><td class="est-der">{{ $m($c->importe) }}</td></tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">Sin pedidos en el periodo.</div>
                    @endforelse
                </div>
                <div class="est-caja">
                    <h3>Gastos por categoría</h3>
                    @forelse($categorias['gastos'] as $c)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Categoría</th><th class="est-der">Registros</th><th class="est-der">Total</th></tr></thead><tbody>@endif
                        <tr><td>{{ $c->nombre }}</td><td class="est-der">{{ $n($c->n) }}</td><td class="est-der">{{ $m($c->total) }}</td></tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">Sin gastos en el periodo.</div>
                    @endforelse
                </div>
            </div>
        </section>
        <section class="est-panel" id="tab-inventario">
            <p class="est-nota">El inventario muestra el estado actual; solo “Adquiridos en el periodo” depende de las fechas.</p>
            <div class="est-tarjetas">
                <div class="est-tarjeta"><small>Registros</small><strong>{{ $n($inventario['registros']) }}</strong><span>{{ $n($inventario['bienes']) }} bienes · {{ $n($inventario['servicios']) }} servicios</span></div>
                <div class="est-tarjeta"><small>Unidades disponibles</small><strong>{{ $n($inventario['unidades']) }}</strong></div>
                <div class="est-tarjeta"><small>Valor a precio de venta</small><strong>{{ $m($inventario['valor']) }}</strong><span>Precio × cantidad</span></div>
                <div class="est-tarjeta"><small>Agotados</small><strong class="{{ $inventario['agotados'] ? 'est-negativo' : '' }}">{{ $n($inventario['agotados']) }}</strong></div>
                <div class="est-tarjeta"><small>Adquiridos en el periodo</small><strong>{{ $n($inventario['adquiridos']) }}</strong></div>
            </div>

            <div class="est-rejilla">
                <div class="est-caja"><h3>Unidades por categoría</h3><div class="est-grafica"><canvas id="g-invCat"></canvas></div></div>
                <div class="est-caja">
                    <h3>Existencia baja (≤ {{ $inventario['stock_bajo'] }})</h3>
                    @forelse($inventario['bajo'] as $i)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Nombre</th><th>Categoría</th><th class="est-der">Cantidad</th></tr></thead><tbody>@endif
                        <tr><td>{{ $i->nombre }}</td><td>{{ $i->categoria->nombre ?? 'Sin categoría' }}</td><td class="est-der {{ $i->cantidad == 0 ? 'est-negativo' : '' }}">{{ $i->cantidad }}</td></tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">No hay artículos con existencia baja.</div>
                    @endforelse
                </div>
            </div>

            <div class="est-caja">
                <h3>Inventario por categoría</h3>
                <div class="est-scroll">
                    <table class="est-tabla">
                        <thead><tr><th>Categoría</th><th>Tipo</th><th class="est-der">Registros</th><th class="est-der">Unidades</th><th class="est-der">Valor</th></tr></thead>
                        <tbody>
                            @forelse($inventario['porCategoria'] as $c)
                                <tr><td>{{ $c->nombre }}</td><td><span class="est-etiqueta">{{ ucfirst($c->tipo) }}</span></td><td class="est-der">{{ $n($c->registros) }}</td><td class="est-der">{{ $n($c->unidades) }}</td><td class="est-der">{{ $m($c->valor) }}</td></tr>
                            @empty
                                <tr><td colspan="5" class="est-vacio">Sin registros de inventario.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <section class="est-panel" id="tab-pedidos">
            <div class="est-tarjetas">
                <div class="est-tarjeta"><small>Pedidos</small><strong>{{ $n($pedidos['n']) }}</strong></div>
                <div class="est-tarjeta"><small>Monto cotizado</small><strong>{{ $m($pedidos['total']) }}</strong></div>
                <div class="est-tarjeta"><small>Concluidos</small><strong>{{ $n($pedidos['concluidos']) }}</strong><span>Finalizados o terminados</span></div>
            </div>

            <div class="est-rejilla">
                <div class="est-caja"><h3>Pedidos por periodo</h3><div class="est-grafica"><canvas id="g-pedidos"></canvas></div></div>
                <div class="est-caja"><h3>Pedidos por estado</h3><div class="est-grafica"><canvas id="g-estados"></canvas></div></div>
            </div>

            <div class="est-rejilla">
                <div class="est-caja">
                    <h3>Resumen por estado</h3>
                    @forelse($pedidos['porEstado'] as $e)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Estado</th><th class="est-der">Pedidos</th><th class="est-der">Monto</th></tr></thead><tbody>@endif
                        <tr><td><span class="est-etiqueta">{{ ucfirst($e->estado) }}</span></td><td class="est-der">{{ $n($e->n) }}</td><td class="est-der">{{ $m($e->total) }}</td></tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">Sin pedidos en el periodo.</div>
                    @endforelse
                </div>
                <div class="est-caja">
                    <h3>Servicios más solicitados</h3>
                    @forelse($pedidos['servicios'] as $s)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Servicio</th><th class="est-der">Cantidad</th><th class="est-der">Importe</th></tr></thead><tbody>@endif
                        <tr><td>{{ $s->nombre }}</td><td class="est-der">{{ $n($s->cantidad) }}</td><td class="est-der">{{ $m($s->importe) }}</td></tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">Sin pedidos en el periodo.</div>
                    @endforelse
                </div>
                <div class="est-caja">
                    <h3>Mejores clientes</h3>
                    @forelse($pedidos['clientes'] as $c)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Cliente</th><th class="est-der">Pedidos</th><th class="est-der">Total</th></tr></thead><tbody>@endif
                        <tr><td>{{ $c->cliente }}</td><td class="est-der">{{ $n($c->n) }}</td><td class="est-der">{{ $m($c->total) }}</td></tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">Sin pedidos en el periodo.</div>
                    @endforelse
                </div>
            </div>
        </section>
        <section class="est-panel" id="tab-compras">
            <p class="est-nota">Las compras se calculan a partir de los gastos comerciales registrados.</p>
            <div class="est-tarjetas">
                <div class="est-tarjeta"><small>Total gastado</small><strong>{{ $m($compras['total']) }}</strong></div>
                <div class="est-tarjeta"><small>Registros</small><strong>{{ $n($compras['n']) }}</strong></div>
                <div class="est-tarjeta"><small>Promedio por registro</small><strong>{{ $m($compras['promedio']) }}</strong></div>
            </div>

            <div class="est-rejilla">
                <div class="est-caja"><h3>Gastos por periodo</h3><div class="est-grafica"><canvas id="g-gastos"></canvas></div></div>
                <div class="est-caja"><h3>Gastos por categoría</h3><div class="est-grafica"><canvas id="g-catGastos2"></canvas></div></div>
            </div>

            <div class="est-caja">
                <h3>Últimos registros</h3>
                @forelse($compras['recientes'] as $g)
                    @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Fecha</th><th>Concepto</th><th>Categoría</th><th class="est-der">Monto</th></tr></thead><tbody>@endif
                    <tr><td>{{ $g->fecha->format('d/m/Y') }}</td><td>{{ $g->concepto }}</td><td>{{ $g->categoria->nombre ?? 'Sin categoría' }}</td><td class="est-der">{{ $m($g->monto) }}</td></tr>
                    @if($loop->last)</tbody></table></div>@endif
                @empty
                    <div class="est-vacio">Sin gastos en el periodo.</div>
                @endforelse
            </div>
        </section>
        <section class="est-panel" id="tab-pagos">
            <div class="est-tarjetas">
                <div class="est-tarjeta"><small>Pagado (egresos)</small><strong class="est-negativo">{{ $m($pagos['egresos']) }}</strong></div>
                <div class="est-tarjeta"><small>Recibido (ingresos)</small><strong class="est-positivo">{{ $m($pagos['ingresos']) }}</strong></div>
                <div class="est-tarjeta"><small>Recibos del periodo</small><strong>{{ $n($pagos['n']) }}</strong></div>
                <div class="est-tarjeta"><small>Pendientes</small><strong>{{ $n($pagos['pendientes_n']) }}</strong><span>{{ $m($pagos['pendientes_monto']) }} · {{ $n($pagos['vencidos']) }} vencidos</span></div>
            </div>

            <div class="est-rejilla">
                <div class="est-caja"><h3>Monto por servicio</h3><div class="est-grafica"><canvas id="g-servicios"></canvas></div></div>
                <div class="est-caja">
                    <h3>Próximos vencimientos</h3>
                    @forelse($pagos['proximos'] as $p)
                        @if($loop->first)<div class="est-scroll"><table class="est-tabla"><thead><tr><th>Servicio</th><th>Vence</th><th class="est-der">Monto</th></tr></thead><tbody>@endif
                        <tr>
                            <td>{{ $p->servicio }}</td>
                            <td class="{{ $p->fecha_vencimiento && $p->fecha_vencimiento->isPast() ? 'est-negativo' : '' }}">{{ $f($p->fecha_vencimiento) }}</td>
                            <td class="est-der">{{ $p->monto !== null ? $m($p->monto) : '—' }}</td>
                        </tr>
                        @if($loop->last)</tbody></table></div>@endif
                    @empty
                        <div class="est-vacio">No hay pagos pendientes.</div>
                    @endforelse
                </div>
            </div>

            <div class="est-caja">
                <h3>Detalle por servicio</h3>
                <div class="est-scroll">
                    <table class="est-tabla">
                        <thead><tr><th>Servicio</th><th>Tipo</th><th class="est-der">Recibos</th><th class="est-der">Total</th></tr></thead>
                        <tbody>
                            @forelse($pagos['porServicio'] as $s)
                                <tr><td>{{ $s->servicio }}</td><td><span class="est-etiqueta">{{ ucfirst($s->tipo_movimiento) }}</span></td><td class="est-der">{{ $n($s->n) }}</td><td class="est-der">{{ $m($s->total) }}</td></tr>
                            @empty
                                <tr><td colspan="4" class="est-vacio">Sin recibos en el periodo.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        const G = @json($graficas);
        const paleta = ['#6d28d9', '#f59e0b', '#10b981', '#ef4444', '#3b82f6', '#ec4899', '#14b8a6', '#84cc16', '#f97316', '#a78bfa'];
        Chart.defaults.font.family = getComputedStyle(document.body).fontFamily;
        Chart.defaults.color = '#6b7280';
        const dinero = v => '$' + Number(v).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        function grafica(id, tipo, labels, series, formato = 'm') {
            const el = document.getElementById(id);
            if (!el) return;
            const circular = tipo === 'doughnut';
            const linea = tipo === 'line';
            const fmt = v => formato === 'n' ? Number(v).toLocaleString('es-MX') : dinero(v);

            new Chart(el, {
                type: tipo,
                data: {
                    labels,
                    datasets: series.map((s, i) => {
                        const color = s.color || paleta[i];
                        return {
                            label: s.nombre,
                            data: s.datos,
                            backgroundColor: circular ? paleta : (linea ? color + '22' : color),
                            borderColor: circular ? '#fff' : color,
                            borderWidth: circular ? 3 : 2.5,
                            borderRadius: 0,
                            fill: linea,
                            tension: 0.35,
                            pointRadius: linea ? 3 : 0,
                            pointHoverRadius: 5,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: color,
                            pointBorderWidth: 2,
                            hoverOffset: circular ? 4 : 0,
                        };
                    }),
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: circular ? '68%' : undefined,
                    interaction: { mode: circular ? 'nearest' : 'index', intersect: circular },
                    plugins: {
                        legend: { display: circular || series.length > 1, position: circular ? 'right' : 'top', labels: { boxWidth: 10, boxHeight: 10 } },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 10,
                            cornerRadius: 0,
                            callbacks: {
                                label: c => (circular ? c.label : c.dataset.label) + ': ' + fmt(circular ? c.parsed : c.parsed.y),
                            },
                        },
                    },
                    ...(circular ? {} : {
                        scales: {
                            x: { grid: { display: false } },
                            y: { beginAtZero: true, grid: { color: '#f0f0f3' }, border: { display: false }, ticks: { callback: v => fmt(v) } },
                        },
                    }),
                },
            });
        }

        const iniciadores = {
            general:    () => grafica('g-general', 'line', G.periodos, [
                { nombre: 'Ingresos', datos: G.ingresos, color: '#10b981' },
                { nombre: 'Egresos', datos: G.egresos, color: '#ef4444' },
            ]),
            ventas:     () => {
                grafica('g-ventas', 'bar', G.periodos, [{ nombre: 'Ventas', datos: G.ventas }]);
                grafica('g-formas', 'doughnut', G.formas.l, [{ nombre: 'Forma de pago', datos: G.formas.d }]);
            },
            categorias: () => {
                grafica('g-catVentas', 'doughnut', G.catVentas.l, [{ nombre: 'Ventas', datos: G.catVentas.d }]);
                grafica('g-catGastos', 'doughnut', G.catGastos.l, [{ nombre: 'Gastos', datos: G.catGastos.d }]);
            },
            inventario: () => grafica('g-invCat', 'bar', G.invCat.l, [{ nombre: 'Unidades', datos: G.invCat.d }], 'n'),
            pedidos:    () => {
                grafica('g-pedidos', 'bar', G.periodos, [{ nombre: 'Pedidos', datos: G.pedidos }], 'n');
                grafica('g-estados', 'doughnut', G.estados.l, [{ nombre: 'Pedidos', datos: G.estados.d }], 'n');
            },
            compras:    () => {
                grafica('g-gastos', 'bar', G.periodos, [{ nombre: 'Gastos', datos: G.gastos }]);
                grafica('g-catGastos2', 'doughnut', G.catGastos.l, [{ nombre: 'Gastos', datos: G.catGastos.d }]);
            },
            pagos:      () => grafica('g-servicios', 'bar', G.servicios.l, [{ nombre: 'Monto', datos: G.servicios.d }]),
        };

        const creadas = {};
        function activar(nombre) {
            if (!iniciadores[nombre]) nombre = 'general';
            document.querySelectorAll('.est-tab').forEach(b => b.classList.toggle('activo', b.dataset.tab === nombre));
            document.querySelectorAll('.est-panel').forEach(p => p.classList.toggle('activo', p.id === 'tab-' + nombre));
            if (!creadas[nombre]) { iniciadores[nombre](); creadas[nombre] = true; }
            history.replaceState(null, '', '#' + nombre);
        }

        document.querySelectorAll('.est-tab').forEach(b => b.addEventListener('click', () => activar(b.dataset.tab)));
        document.querySelectorAll('[data-atajo]').forEach(a => a.addEventListener('click', () => { a.href += location.hash; }));
        document.getElementById('formFiltros').addEventListener('submit', e => {
            e.target.action = e.target.action.split('#')[0] + location.hash;
        });

        activar(location.hash.replace('#', '') || 'general');
    </script>
    @endpush

</x-layouts.panel>