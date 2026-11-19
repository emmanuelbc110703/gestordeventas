<x-layouts.panel
    titulo="Menú principal"
    :migas="[
        ['texto' => 'Menú principal', 'url' => route('admin.dashboard')],
    ]"
>

@php
    $totalInventario  = $totalInventario  ?? 0;
    $totalPuntosVenta = $totalPuntosVenta ?? 0;
    $totalEmpleados   = $totalEmpleados   ?? 0;
    $totalPedidos     = $totalPedidos     ?? 0;
    $totalBienes      = $totalBienes      ?? 0;
    $totalServicios   = $totalServicios   ?? 0;
    $pedidosPorMes    = $pedidosPorMes    ?? ['labels' => [], 'datos' => []];
@endphp

@push('estilos')
<style>
    .pagina-dash {
        padding: 48px 0 56px;
    }

    .dash-encabezado {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        padding-bottom: 24px;
        margin-bottom: 36px;
        border-bottom: 1px solid var(--borde);
    }
    .dash-titulo-fila {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 6px;
    }
    .dash-encabezado h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--texto);
    }
    .dash-encabezado p {
        margin: 0;
        font-size: 15px;
        color: var(--texto-suave);
    }
    .dash-fecha {
        font-size: 13px;
        color: var(--texto-suave);
        text-transform: capitalize;
    }

    .c-violeta  { --ac: #6d28d9; --ac-suave: #f5f3ff; --ac-borde: #ddd6fe; }
    .c-esmeralda{ --ac: #059669; --ac-suave: #ecfdf5; --ac-borde: #a7f3d0; }
    .c-azul     { --ac: #2563eb; --ac-suave: #eff6ff; --ac-borde: #bfdbfe; }
    .c-ambar    { --ac: #d97706; --ac-suave: #fffbeb; --ac-borde: #fde68a; }
    .c-turquesa { --ac: #0d9488; --ac-suave: #f0fdfa; --ac-borde: #99f6e4; }
    .c-rosa     { --ac: #e11d48; --ac-suave: #fff1f2; --ac-borde: #fecdd3; }
    .c-indigo   { --ac: #4f46e5; --ac-suave: #eef2ff; --ac-borde: #c7d2fe; }
    .c-naranja  { --ac: #ea580c; --ac-suave: #fff7ed; --ac-borde: #fed7aa; }
    .c-pizarra  { --ac: #475569; --ac-suave: #f1f5f9; --ac-borde: #cbd5e1; }
    .c-fucsia   { --ac: #c026d3; --ac-suave: #fdf4ff; --ac-borde: #f5d0fe; }

    .dash-resumen {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 28px;
    }
    .kpi {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 22px 24px;
        background: #fff;
        border: 1px solid var(--borde);
        border-top: 2px solid var(--ac, var(--primario));
        color: inherit;
        text-decoration: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .kpi:hover {
        border-color: var(--ac-borde, #c4b5fd);
        border-top-color: var(--ac, var(--primario));
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07);
    }
    .kpi-cabecera {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }
    .kpi-etiqueta {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--texto-suave);
    }
    .kpi-icono {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--ac-suave, var(--primario-suave));
        border: 1px solid var(--ac-borde, #ddd6fe);
        font-size: 15px;
        color: var(--ac, var(--primario));
    }
    .kpi-valor {
        font-size: 38px;
        font-weight: 700;
        line-height: 1;
        letter-spacing: -0.03em;
        color: var(--texto);
    }
    .kpi-detalle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
        padding-top: 12px;
        border-top: 1px solid #f0f0f3;
        font-size: 12px;
        color: var(--texto-suave);
    }
    .kpi-detalle i {
        font-size: 11px;
        color: var(--ac, var(--primario));
        transition: transform 0.2s ease;
    }
    .kpi:hover .kpi-detalle i { transform: translateX(4px); }

    .dash-graficas {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 48px;
    }
    .panel-grafica {
        padding: 24px;
        background: #fff;
        border: 1px solid var(--borde);
        border-top: 2px solid var(--ac, var(--primario));
    }
    .panel-grafica-cabecera {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 20px;
    }
    .panel-grafica-cabecera h2 {
        margin: 0 0 4px;
        font-size: 15px;
        font-weight: 600;
        color: var(--texto);
    }
    .panel-grafica-cabecera p {
        margin: 0;
        font-size: 13px;
        color: var(--texto-suave);
    }
    .grafica-total {
        text-align: right;
    }
    .grafica-total strong {
        display: block;
        font-size: 22px;
        font-weight: 700;
        color: var(--texto);
    }
    .grafica-total span {
        font-size: 11px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #9ca3af;
    }
    .grafica-caja {
        position: relative;
        height: 280px;
    }
    .grafica-caja.dona {
        height: 200px;
    }
    .leyenda {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #f0f0f3;
    }
    .leyenda-fila {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: var(--texto-suave);
    }
    .leyenda-fila span {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .leyenda-fila span::before {
        content: '';
        width: 10px;
        height: 10px;
        background: var(--color, #9ca3af);
    }
    .leyenda-fila strong {
        color: var(--texto);
        font-weight: 600;
    }
    .grafica-vacia {
        display: none;
        position: absolute;
        inset: 0;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 8px;
        background: #fff;
        font-size: 13px;
        color: var(--texto-suave);
    }
    .grafica-vacia i {
        font-size: 28px;
        color: #c4b5fd;
    }
    .grafica-vacia.visible { display: flex; }

    .dash-seccion { margin-bottom: 40px; }
    .dash-seccion-cabecera {
        display: flex;
        align-items: baseline;
        gap: 14px;
        margin-bottom: 16px;
    }
    .dash-seccion-cabecera h2 {
        margin: 0;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--texto);
    }
    .dash-seccion-cabecera span {
        font-size: 13px;
        color: var(--texto-suave);
    }
    .dash-seccion-cabecera::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--borde);
        order: 3;
        align-self: center;
    }

    .dash-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
    .modulo {
        position: relative;
        display: flex;
        flex-direction: column;
        padding: 24px 22px 22px;
        background: #fff;
        border: 1px solid var(--borde);
        border-top: 2px solid var(--borde);
        color: inherit;
        text-decoration: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .modulo:hover {
        border-color: var(--ac-borde, #c4b5fd);
        border-top-color: var(--ac, var(--primario));
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07);
    }
    .modulo-icono {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        background: var(--ac-suave, var(--primario-suave));
        border: 1px solid var(--ac-borde, #ddd6fe);
        font-size: 18px;
        color: var(--ac, var(--primario));
        transition: background 0.2s ease, color 0.2s ease;
    }
    .modulo:hover .modulo-icono {
        background: var(--ac, var(--primario));
        border-color: var(--ac, var(--primario));
        color: #fff;
    }
    .modulo h3 {
        margin: 0 0 6px;
        font-size: 15px;
        font-weight: 600;
        color: var(--texto);
    }
    .modulo p {
        margin: 0 0 20px;
        font-size: 13px;
        line-height: 1.5;
        color: var(--texto-suave);
    }
    .modulo-pie {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid #f0f0f3;
        font-size: 13px;
        font-weight: 500;
        color: var(--ac, var(--primario));
    }
    .modulo-pie i {
        font-size: 12px;
        transition: transform 0.2s ease;
    }
    .modulo:hover .modulo-pie i { transform: translateX(4px); }

    @media (max-width: 1200px) {
        .dash-grid { grid-template-columns: repeat(3, 1fr); }
        .dash-resumen { grid-template-columns: repeat(2, 1fr); }
        .dash-graficas { grid-template-columns: 1fr; }
    }
    @media (max-width: 950px) {
        .dash-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 650px) {
        .pagina-dash { padding: 28px 0 40px; }
        .dash-encabezado { flex-direction: column; align-items: flex-start; }
        .dash-encabezado h1 { font-size: 26px; }
        .dash-resumen { grid-template-columns: 1fr; gap: 16px; }
        .kpi-valor { font-size: 32px; }
        .grafica-caja { height: 230px; }
        .dash-grid { grid-template-columns: 1fr; gap: 16px; }
    }
</style>
@endpush
<x-sidebar activo="dashboard" />
<div class="pagina-dash">
    <div class="dash-encabezado">
        <div>
            <div class="dash-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Bienvenido, {{ auth()->user()->name }}</h1>
            </div>
            <p>Panel de administración</p>
        </div>
        <span class="dash-fecha">{{ now()->timezone('America/Mexico_City')->locale('es')->translatedFormat('l, d \d\e F \d\e Y · h:i A') }}</span>
    </div>
    <div class="dash-resumen">
        <a href="{{ route('admin.inventario') }}" class="kpi c-violeta">
            <div class="kpi-cabecera">
                <span class="kpi-etiqueta">Inventario</span>
                <span class="kpi-icono"><i class="fa-solid fa-boxes-stacked"></i></span>
            </div>
            <span class="kpi-valor">{{ number_format($totalInventario) }}</span>
            <div class="kpi-detalle">
                <span>Bienes y servicios registrados</span>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('admin.puntos_venta') }}" class="kpi c-esmeralda">
            <div class="kpi-cabecera">
                <span class="kpi-etiqueta">Puntos de venta</span>
                <span class="kpi-icono"><i class="fa-solid fa-store"></i></span>
            </div>
            <span class="kpi-valor">{{ number_format($totalPuntosVenta) }}</span>
            <div class="kpi-detalle">
                <span>Establecimientos activos</span>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('admin.empleados') }}" class="kpi c-azul">
            <div class="kpi-cabecera">
                <span class="kpi-etiqueta">Empleados</span>
                <span class="kpi-icono"><i class="fa-solid fa-users"></i></span>
            </div>
            <span class="kpi-valor">{{ number_format($totalEmpleados) }}</span>
            <div class="kpi-detalle">
                <span>Personal registrado</span>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('admin.cotizaciones') }}" class="kpi c-ambar">
            <div class="kpi-cabecera">
                <span class="kpi-etiqueta">Pedidos</span>
                <span class="kpi-icono"><i class="fa-solid fa-file-invoice-dollar"></i></span>
            </div>
            <span class="kpi-valor">{{ number_format($totalPedidos) }}</span>
            <div class="kpi-detalle">
                <span>Pedidos registrados</span>
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>
    </div>
    <div class="dash-graficas">
        <div class="panel-grafica c-ambar">
            <div class="panel-grafica-cabecera">
                <div>
                    <h2>Pedidos por mes</h2>
                    <p>Actividad de los últimos 6 meses</p>
                </div>
                <div class="grafica-total">
                    <strong>{{ number_format(array_sum($pedidosPorMes['datos'])) }}</strong>
                    <span>En el periodo</span>
                </div>
            </div>
            <div class="grafica-caja">
                <canvas id="graficaPedidos"></canvas>
                <div class="grafica-vacia {{ array_sum($pedidosPorMes['datos']) === 0 ? 'visible' : '' }}">
                    <i class="fa-solid fa-chart-column"></i>
                    Aún no hay pedidos en este periodo
                </div>
            </div>
        </div>

        <div class="panel-grafica c-violeta">
            <div class="panel-grafica-cabecera">
                <div>
                    <h2>Composición del inventario</h2>
                    <p>Bienes frente a servicios</p>
                </div>
            </div>
            <div class="grafica-caja dona">
                <canvas id="graficaInventario"></canvas>
                <div class="grafica-vacia {{ ($totalBienes + $totalServicios) === 0 ? 'visible' : '' }}">
                    <i class="fa-solid fa-box-open"></i>
                    Sin registros en el inventario
                </div>
            </div>
            <div class="leyenda">
                <div class="leyenda-fila" style="--color: #6d28d9;">
                    <span>Bienes</span>
                    <strong>{{ number_format($totalBienes) }}</strong>
                </div>
                <div class="leyenda-fila" style="--color: #0d9488;">
                    <span>Servicios</span>
                    <strong>{{ number_format($totalServicios) }}</strong>
                </div>
            </div>
        </div>
    </div>
    <section class="dash-seccion">
        <div class="dash-seccion-cabecera">
            <h2>Operación</h2>
            <span>Productos, ventas y relación con clientes</span>
        </div>
        <div class="dash-grid">
            <a href="{{ route('admin.inventario') }}" class="modulo c-violeta">
                <span class="modulo-icono"><i class="fa-solid fa-boxes-stacked"></i></span>
                <h3>Inventario</h3>
                <p>Administra productos, servicios y existencias.</p>
                <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="{{ route('admin.puntos_venta') }}" class="modulo c-esmeralda">
                <span class="modulo-icono"><i class="fa-solid fa-store"></i></span>
                <h3>Puntos de venta</h3>
                <p>Gestiona los establecimientos del negocio.</p>
                <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="{{ route('admin.clientes') }}" class="modulo c-turquesa">
                <span class="modulo-icono"><i class="fa-solid fa-user-group"></i></span>
                <h3>Clientes</h3>
                <p>Consulta y administra tu cartera de clientes.</p>
                <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="{{ route('admin.cotizaciones') }}" class="modulo c-ambar">
                <span class="modulo-icono"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                <h3>Pedidos</h3>
                <p>Gestiona los pedidos y cotizaciones comerciales.</p>
                <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
            </a>
        </div>
    </section>
    <section class="dash-seccion">
        <div class="dash-seccion-cabecera">
            <h2>Finanzas y personal</h2>
            <span>Control económico y equipo de trabajo</span>
        </div>
        <div class="dash-grid">
            <a href="{{ route('admin.empleados') }}" class="modulo c-azul">
                <span class="modulo-icono"><i class="fa-solid fa-users"></i></span>
                <h3>Empleados</h3>
                <p>Administra el personal del negocio.</p>
                <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="{{ route('admin.gastos_comerciales') }}" class="modulo c-rosa">
                <span class="modulo-icono"><i class="fa-solid fa-money-bill-wave"></i></span>
                <h3>Gastos comerciales</h3>
                <p>Registra y consulta los gastos del negocio.</p>
                <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="{{ route('admin.cuentas.index') }}" class="modulo c-indigo">
                <span class="modulo-icono"><i class="fa-solid fa-building-columns"></i></span>
                <h3>Cuenta del negocio</h3>
                <p>Administra la información financiera.</p>
                <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="{{ route('admin.pago_servicios.index') }}" class="modulo c-naranja">
                <span class="modulo-icono"><i class="fa-solid fa-file-invoice"></i></span>
                <h3>Pago de servicios</h3>
                <p>Controla los pagos de servicios recurrentes.</p>
                <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
            </a>
        </div>
    </section>
    <section class="dash-seccion">
        <div class="dash-seccion-cabecera">
            <h2>Mi cuenta</h2>
            <span>Perfil y accesos personales</span>
        </div>
        <div class="dash-grid">
            <a href="{{ route('admin.informacion') }}" class="modulo c-pizarra">
                <span class="modulo-icono"><i class="fa-solid fa-user"></i></span>
                <h3>Mi información</h3>
                <p>Consulta y actualiza tu perfil.</p>
                <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            @if(auth()->user()->puntoVenta)
                <a href="{{ route('empleado.punto_venta') }}" class="modulo c-fucsia">
                    <span class="modulo-icono"><i class="fa-solid fa-cash-register"></i></span>
                    <h3>Punto de venta</h3>
                    <p>Accede al sistema de ventas.</p>
                    <span class="modulo-pie">Abrir módulo <i class="fa-solid fa-arrow-right"></i></span>
                </a>
            @endif
        </div>
    </section>

</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    (function () {
        if (typeof Chart === 'undefined') return;

        const estilos = getComputedStyle(document.documentElement);
        const primario = '#d97706';
        const textoSuave = (estilos.getPropertyValue('--texto-suave') || '').trim() || '#6b7280';
        const borde = (estilos.getPropertyValue('--borde') || '').trim() || '#e5e7eb';

        Chart.defaults.font.family = getComputedStyle(document.body).fontFamily;
        Chart.defaults.color = textoSuave;

        const pedidos = @json($pedidosPorMes);
        const canvasPedidos = document.getElementById('graficaPedidos');

        if (canvasPedidos) {
            const ctx = canvasPedidos.getContext('2d');
            const degradado = ctx.createLinearGradient(0, 0, 0, 280);
            degradado.addColorStop(0, 'rgba(217, 119, 6, 0.28)');
            degradado.addColorStop(1, 'rgba(217, 119, 6, 0)');

            new Chart(canvasPedidos, {
                type: 'line',
                data: {
                    labels: pedidos.labels,
                    datasets: [{
                        label: 'Pedidos',
                        data: pedidos.datos,
                        borderColor: primario,
                        backgroundColor: degradado,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: primario,
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 10,
                            cornerRadius: 0,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, border: { color: borde } },
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 },
                            grid: { color: '#f0f0f3' },
                            border: { display: false }
                        }
                    }
                }
            });
        }

        const canvasInventario = document.getElementById('graficaInventario');

        if (canvasInventario) {
            new Chart(canvasInventario, {
                type: 'doughnut',
                data: {
                    labels: ['Bienes', 'Servicios'],
                    datasets: [{
                        data: [{{ (int) $totalBienes }}, {{ (int) $totalServicios }}],
                        backgroundColor: ['#6d28d9', '#0d9488'],
                        borderColor: '#fff',
                        borderWidth: 3,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 10,
                            cornerRadius: 0
                        }
                    }
                }
            });
        }
    })();
</script>
@endpush

</x-layouts.panel>