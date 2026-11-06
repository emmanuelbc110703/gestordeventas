@php
    $hoy = \Carbon\Carbon::today();

    try {
        $mesCalendario = request('mes')
            ? \Carbon\Carbon::createFromFormat('Y-m-d', request('mes') . '-01')->startOfMonth()
            : $hoy->copy()->startOfMonth();
    } catch (\Throwable $e) {
        $mesCalendario = $hoy->copy()->startOfMonth();
    }

    $nombresMes = [1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
                   7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'];

    $mesAnterior  = $mesCalendario->copy()->subMonth()->format('Y-m');
    $mesSiguiente = $mesCalendario->copy()->addMonth()->format('Y-m');
    $primerDia    = $mesCalendario->dayOfWeek;
    $diasDelMes   = $mesCalendario->daysInMonth;

    $vistaInicial = (request('vista') === 'calendario' || request('mes')) ? 'calendario' : 'lista';

    $pendientes     = $servicios->where('estado', 'Pendiente');
    $totalPendiente = $pendientes->where('tipo_movimiento', '!=', 'ingreso')->sum('monto');
    $totalPorCobrar = $pendientes->where('tipo_movimiento', 'ingreso')->sum('monto');
    $vencidos = $servicios->filter(fn ($s) =>
        $s->estado === 'Pendiente' && $s->fecha_vencimiento && $s->fecha_vencimiento->lt($hoy)
    );

    $porDia = $servicios->filter(fn ($s) => $s->fecha_pago)
        ->groupBy(fn ($s) => $s->fecha_pago->format('Y-m-d'));
@endphp

<x-layouts.panel
    titulo="Pago de servicios"
    :migas="[['texto' => 'Pago de servicios', 'url' => null]]"
>

<x-lista-estilos />

@push('estilos')
    <style>
        .pg-resumen {
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            background: #fff; 
            border: 1px solid var(--borde); 
            margin-bottom: 20px;
        }
        .pg-resumen > div { 
            padding: 16px 20px; 
            border-right: 1px solid var(--borde); 
        }
        .pg-resumen > div:last-child { border-right: none; }
        .pg-resumen small { display: block; font-size: 12px; font-weight: 600; text-transform: uppercase;
            letter-spacing: .04em; color: var(--texto-suave); margin-bottom: 6px; }
        .pg-resumen strong { font-size: 22px; font-weight: 700; color: var(--texto); }
        .pg-resumen .rojo strong { color: #b91c1c; }

        .pg-alerta { 
            padding: 12px 16px; 
            margin-bottom: 16px; 
            font-size: 14px;
            background: #ecfdf3; 
            border: 1px solid #abefc6; 
            color: #067647; 
        }

        .pg-vistas { 
            display: flex; 
            gap: 24px; 
            border-bottom: 1px solid var(--borde); 
            margin-bottom: 20px; 
        }
        .pg-vista { 
            background: none; 
            border: none; 
            border-bottom: 2px solid transparent; 
            margin-bottom: -1px;
            padding: 10px 2px; 
            font: inherit; 
            font-size: 15px; 
            font-weight: 500; 
            color: var(--texto-suave); 
            cursor: pointer; 
        }
        .pg-vista:hover { color: var(--primario); }
        .pg-vista.activo { color: var(--primario); border-bottom-color: var(--primario); font-weight: 600; }
        .pg-n { margin-left: 6px; font-size: 12px; color: var(--texto-suave); }
        .lst-tab.activo .pg-n { color: var(--primario); }
        .pg-nombre { font-weight: 600; color: var(--texto); }
        .pg-desc { font-size: 13px; color: var(--texto-suave); margin-top: 2px; }
        .pg-badge { 
            display: inline-block; 
            padding: 3px 10px; 
            font-size: 12px; 
            font-weight: 600; 
            border: 1px solid; 
        }
        .pg-badge.pagado    { background: #ecfdf3; color: #067647; border-color: #abefc6; }
        .pg-badge.pendiente { background: #fffaeb; color: #b54708; border-color: #fedf89; }
        .pg-tipo { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; margin-top: 4px; }
        .pg-tipo.egreso  { color: #b54708; }
        .pg-tipo.ingreso { color: #067647; }
        .pg-monto.ingreso { color: #067647; font-weight: 600; }
        .pg-cuenta { font-size: 14px; }
        .pg-sin-cuenta { color: #b54708; font-size: 13px; }
        .pg-enc-acciones { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
        .pg-btn-sec { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 44px; padding: 0 18px;
            background: #fff; border: 1px solid var(--borde); color: var(--texto); font-size: 14px; font-weight: 600;
            text-decoration: none; white-space: nowrap; transition: border-color .2s, background .2s; }
        .pg-btn-sec:hover { border-color: #c4b5fd; background: #fcfbff; }
        .lst-btn-registrar { display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px;
            background: #ecfdf3; border: 1px solid #abefc6; color: #067647; text-decoration: none; font-size: 13px; }
        .lst-btn-registrar:hover { background: #067647; border-color: #067647; color: #fff; }
        .pg-vencido { color: #b91c1c; font-weight: 600; }
        .pg-monto { white-space: nowrap; font-variant-numeric: tabular-nums; }
        .pg-acciones { display: flex; gap: 6px; justify-content: flex-end; }
        .pg-acciones form { margin: 0; }
        tr.fila-pago { cursor: pointer; }

        .pg-cal-barra { display: flex; flex-wrap: wrap; align-items: center; gap: 10px 16px; margin-bottom: 14px; }
        .pg-cal-mes { font-size: 18px; font-weight: 700; min-width: 170px; text-align: center; }
        .pg-cal-btn { padding: 7px 14px; background: #fff; border: 1px solid var(--borde); color: var(--texto);
            text-decoration: none; font-size: 14px; font-weight: 500; }
        .pg-cal-btn:hover { border-color: var(--primario); color: var(--primario); }
        .pg-cal-scroll { overflow-x: auto; }
        .pg-cal { 
            min-width: 720px; 
            background: #fff; 
            border: 1px solid var(--borde); 
        }
        .pg-cal-cab, .pg-cal-dias { 
            display: grid; 
            grid-template-columns: repeat(7, minmax(0, 1fr)); 
        }
        .pg-cal-cab div { 
            padding: 10px; 
            text-align: center; 
            font-size: 12px; 
            font-weight: 600;
            text-transform: uppercase; 
            letter-spacing: .04em; color: var(--texto-suave);
            background: #fafafb; 
            border-bottom: 1px solid var(--borde); 
        }
        .pg-dia { 
            min-height: 96px; 
            padding: 6px; 
            border-right: 1px solid var(--borde); 
            border-bottom: 1px solid var(--borde); 
        }
        .pg-dia:nth-child(7n) { border-right: none; }
        .pg-dia.vacio { background: #fafafb; }
        .pg-dia.hoy { background: var(--primario-suave); }
        .pg-dia-n { 
            font-size: 13px; 
            font-weight: 600; 
            color: var(--texto-suave); 
            margin-bottom: 4px; 
        }
        .pg-dia.hoy .pg-dia-n { color: var(--primario); }
        .pg-chip { 
            display: block; 
            padding: 3px 6px; 
            margin-bottom: 3px; 
            font-size: 12px; 
            font-weight: 500;
            text-decoration: none; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            white-space: nowrap; 
            border-left: 3px solid; 
        }
        .pg-chip.pagado    { background: #ecfdf3; color: #067647; border-color: #12b76a; }
        .pg-chip.pendiente { background: #fffaeb; color: #b54708; border-color: #f79009; }

        @media (max-width: 700px) {
            .pg-resumen { grid-template-columns: 1fr; }
            .pg-resumen > div { border-right: none; border-bottom: 1px solid var(--borde); }
            .pg-resumen > div:last-child { border-bottom: none; }
        }
    </style>
@endpush

<x-sidebar activo="pagos" />

<div class="lst-pagina">

    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Pago de servicios</h1>
            </div>
            <p>Controla los servicios y pagos recurrentes del negocio.</p>
        </div>
        <div class="pg-enc-acciones">
            <a href="{{ route('admin.pago_servicios.historial') }}" class="pg-btn-sec">
                <i class="fa-solid fa-clock-rotate-left"></i> Pagos realizados
            </a>
            <a href="{{ route('admin.pago_servicios.registrar') }}" class="pg-btn-sec">
                <i class="fa-solid fa-receipt"></i> Registrar pago
            </a>
            <a href="{{ route('admin.pago_servicios.create') }}" class="lst-btn-principal">Agregar servicio</a>
        </div>
    </div>

    @if(session('success'))
        <div class="pg-alerta">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="lst-mensaje error">{{ $errors->first() }}</div>
    @endif

    <div class="pg-resumen">
        <div>
            <small>Pendiente por pagar</small>
            <strong>${{ number_format($totalPendiente, 2) }}</strong>
        </div>
        <div>
            <small>Pendiente por cobrar</small>
            <strong>${{ number_format($totalPorCobrar, 2) }}</strong>
        </div>
        <div class="{{ $vencidos->count() ? 'rojo' : '' }}">
            <small>Pagos vencidos</small>
            <strong>{{ $vencidos->count() }}</strong>
        </div>
    </div>

    <div class="pg-vistas">
        <button type="button" class="pg-vista {{ $vistaInicial === 'lista' ? 'activo' : '' }}" data-vista="lista">Lista</button>
        <button type="button" class="pg-vista {{ $vistaInicial === 'calendario' ? 'activo' : '' }}" data-vista="calendario">Calendario</button>
    </div>
    <section id="vistaLista" @if($vistaInicial !== 'lista') hidden @endif>

        <div class="lst-herramientas">
            <div class="lst-tabs">
                <button type="button" class="lst-tab activo" data-estado="todos">Todos<span class="pg-n">{{ $servicios->count() }}</span></button>
                <button type="button" class="lst-tab" data-estado="Pendiente">Pendientes<span class="pg-n">{{ $servicios->where('estado', 'Pendiente')->count() }}</span></button>
                <button type="button" class="lst-tab" data-estado="Pagado">Pagados<span class="pg-n">{{ $servicios->where('estado', 'Pagado')->count() }}</span></button>
            </div>

            <div class="lst-controles">
                <div class="lst-buscador">
                    <input type="text" id="buscadorPagos" placeholder="Buscar servicio..." autocomplete="off">
                </div>
                <div class="lst-selector">
                    <select id="ordenPagos" aria-label="Ordenar pagos">
                        <option value="fecha-asc">Pago más próximo</option>
                        <option value="fecha-desc">Pago más reciente</option>
                        <option value="monto-desc">Monto: mayor a menor</option>
                        <option value="monto-asc">Monto: menor a mayor</option>
                    </select>
                </div>
                <div class="lst-contador" id="contadorPagos"></div>
            </div>
        </div>

        @if($servicios->isNotEmpty())
            <div class="lst-tabla-wrap">
                <table class="lst-tabla">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Próxima fecha</th>
                            <th>Vencimiento</th>
                            <th>Periodicidad</th>
                            <th>Cuenta</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th style="text-align:right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyPagos">
                        @foreach($servicios as $s)
                            @php
                                $vencido = $s->estado === 'Pendiente' && $s->fecha_vencimiento && $s->fecha_vencimiento->lt($hoy);
                            @endphp
                            <tr class="fila-pago"
                                data-url="{{ $s->estado === 'Pendiente' ? route('admin.pago_servicios.edit', $s->id) : '' }}"
                                data-estado="{{ $s->estado }}"
                                data-fecha="{{ $s->fecha_pago?->format('Y-m-d') }}"
                                data-monto="{{ $s->monto ?? 0 }}"
                                data-texto="{{ $s->servicio }} {{ $s->descripcion }} {{ $s->observaciones }}">
                                <td data-label="Servicio">
                                    <div class="pg-nombre">{{ $s->servicio }}</div>
                                    @if($s->descripcion)
                                        <div class="pg-desc">{{ $s->descripcion }}</div>
                                    @endif
                                    <div class="pg-tipo {{ $s->tipo_movimiento === 'ingreso' ? 'ingreso' : 'egreso' }}">
                                        <i class="fa-solid {{ $s->tipo_movimiento === 'ingreso' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                                        {{ $s->tipo_movimiento === 'ingreso' ? 'Ingreso' : 'Pago' }}
                                    </div>
                                </td>
                                <td data-label="Fecha de pago">{{ $s->fecha_pago?->format('d/m/Y') ?? '—' }}</td>
                                <td data-label="Vencimiento">
                                    @if($s->fecha_vencimiento)
                                        <span class="{{ $vencido ? 'pg-vencido' : '' }}">
                                            {{ $s->fecha_vencimiento->format('d/m/Y') }}{{ $vencido ? ' · Vencido' : '' }}
                                        </span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td data-label="Periodicidad">{{ $periodicidades[$s->periodicidad] ?? '—' }}</td>
                                <td data-label="Cuenta" class="pg-cuenta">
                                    @if($s->cuenta)
                                        {{ $s->cuenta->nombre }}
                                    @else
                                        <span class="pg-sin-cuenta">Sin cuenta</span>
                                    @endif
                                </td>
                                <td data-label="Monto" class="pg-monto {{ $s->tipo_movimiento === 'ingreso' ? 'ingreso' : '' }}">
                                <td data-label="Estado">
                                    <span class="pg-badge {{ $s->estado === 'Pagado' ? 'pagado' : 'pendiente' }}">{{ $s->estado }}</span>
                                </td>
                                <td data-label="Acciones">
                                    <div class="pg-acciones">
                                        @if($s->estado === 'Pendiente')
                                            <a href="{{ route('admin.pago_servicios.registrar', ['servicio' => $s->id]) }}"
                                               class="lst-btn-registrar"
                                               title="{{ $s->tipo_movimiento === 'ingreso' ? 'Registrar cobro' : 'Registrar pago' }}"
                                               aria-label="Registrar {{ $s->servicio }}">
                                                <i class="fa-solid fa-receipt"></i>
                                            </a>
                                            <a href="{{ $s->estado === 'Pendiente' ? route('admin.pago_servicios.edit', $s->id) : route('admin.pago_servicios.historial', ['servicio' => $s->servicio]) }}"
                                                class="pg-chip {{ $s->estado === 'Pagado' ? 'pagado' : 'pendiente' }}"
                                                title="{{ $s->servicio }} · {{ $s->estado }}">{{ $s->servicio }}
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.pago_servicios.destroy', $s->id) }}" method="POST"
                                              onsubmit="return confirm('¿Deseas eliminar este servicio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="lst-btn-eliminar" title="Eliminar" aria-label="Eliminar {{ $s->servicio }}">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="lst-vacio" id="sinResultadosPagos">Ningún servicio coincide con los filtros.</div>
        @else
            <div class="lst-vacio" style="display:block;">
                No hay servicios registrados. Agrega el primero con el botón "Agregar servicio".
            </div>
        @endif
    </section>

    <section id="vistaCalendario" @if($vistaInicial !== 'calendario') hidden @endif>

        <div class="pg-cal-barra">
            <a href="{{ url()->current() }}?mes={{ $mesAnterior }}" class="pg-cal-btn">Anterior</a>
            <div class="pg-cal-mes">{{ $nombresMes[$mesCalendario->month] }} {{ $mesCalendario->year }}</div>
            <a href="{{ url()->current() }}?mes={{ $mesSiguiente }}" class="pg-cal-btn">Siguiente</a>
            @if($mesCalendario->format('Y-m') !== $hoy->format('Y-m'))
                <a href="{{ url()->current() }}?vista=calendario" class="pg-cal-btn">Hoy</a>
            @endif
        </div>

        <div class="pg-cal-scroll">
            <div class="pg-cal">
                <div class="pg-cal-cab">
                    @foreach(['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'] as $d)
                        <div>{{ $d }}</div>
                    @endforeach
                </div>
                <div class="pg-cal-dias">
                    @for($i = 0; $i < $primerDia; $i++)
                        <div class="pg-dia vacio"></div>
                    @endfor

                    @for($dia = 1; $dia <= $diasDelMes; $dia++)
                        @php
                            $fecha = $mesCalendario->copy()->day($dia);
                            $delDia = $porDia->get($fecha->format('Y-m-d'), collect());
                        @endphp
                        <div class="pg-dia {{ $fecha->isToday() ? 'hoy' : '' }}">
                            <div class="pg-dia-n">{{ $dia }}</div>
                            @foreach($delDia as $s)
                                <a href="{{ route('admin.pago_servicios.edit', $s->id) }}"
                                   class="pg-chip {{ $s->estado === 'Pagado' ? 'pagado' : 'pendiente' }}"
                                   title="{{ $s->servicio }} · {{ $s->estado }}">{{ $s->servicio }}</a>
                            @endforeach
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

</div>

@push('scripts')
<script>
(function () {
    const norm = t => (t || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
    const botonesVista = document.querySelectorAll('.pg-vista');
    const vistas = { lista: document.getElementById('vistaLista'), calendario: document.getElementById('vistaCalendario') };

    botonesVista.forEach(b => b.addEventListener('click', () => {
        botonesVista.forEach(x => x.classList.toggle('activo', x === b));
        Object.entries(vistas).forEach(([k, el]) => el.hidden = (k !== b.dataset.vista));
    }));

    const tbody = document.getElementById('tbodyPagos');
    if (!tbody) return;

    const filas = Array.from(tbody.querySelectorAll('tr.fila-pago'));
    const tabs = document.querySelectorAll('.lst-tab');
    const buscador = document.getElementById('buscadorPagos');
    const orden = document.getElementById('ordenPagos');
    const contador = document.getElementById('contadorPagos');
    const vacio = document.getElementById('sinResultadosPagos');
    let estado = 'todos';

    function aplicar() {
        const q = norm(buscador.value.trim());
        const [campo, sentido] = orden.value.split('-');
        const factor = sentido === 'asc' ? 1 : -1;

        filas.sort((a, b) => {
            if (campo === 'monto') return (parseFloat(a.dataset.monto) - parseFloat(b.dataset.monto)) * factor;
            return a.dataset.fecha.localeCompare(b.dataset.fecha) * factor;
        }).forEach(f => tbody.appendChild(f));

        let visibles = 0;
        filas.forEach(f => {
            const ok = (estado === 'todos' || f.dataset.estado === estado) && norm(f.dataset.texto).includes(q);
            f.style.display = ok ? '' : 'none';
            if (ok) visibles++;
        });

        contador.textContent = visibles + (visibles === 1 ? ' servicio' : ' servicios');
        vacio.style.display = visibles ? 'none' : 'block';
    }

    tabs.forEach(t => t.addEventListener('click', () => {
        tabs.forEach(x => x.classList.toggle('activo', x === t));
        estado = t.dataset.estado;
        aplicar();
    }));
    buscador.addEventListener('input', aplicar);
    orden.addEventListener('change', aplicar);

    tbody.addEventListener('click', e => {
        if (e.target.closest('a, button, form')) return;
        if (window.getSelection().toString()) return;
        const fila = e.target.closest('tr.fila-pago');
        if (fila && fila.dataset.url) window.location.href = fila.dataset.url;
    });

    aplicar();
})();
</script>
@endpush

</x-layouts.panel>