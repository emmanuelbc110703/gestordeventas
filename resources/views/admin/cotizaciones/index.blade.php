<x-layouts.panel
    titulo="Pedidos"
    :regresar="route('admin.dashboard')"
    :migas="[
        ['texto' => 'Pedidos', 'url' => route('admin.cotizaciones')],
    ]"
>

<x-lista-estilos />
<x-pedido-estilos />

@php
    $conteos = $cotizaciones->countBy('estado');
    $estadosTexto = [
        'enviado' => 'Enviado',
        'procesando' => 'Procesando',
        'finalizado' => 'Finalizado',
        'terminado' => 'Terminado',
    ];
@endphp

@push('estilos')
<style>
    .ped-tab-n {
        margin-left: 6px;
        font-size: 12px;
        font-weight: 500;
        color: #9ca3af;
    }
    .lst-tab.activo .ped-tab-n {
        color: var(--primario);
    }
    .ped-btn-ver {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 34px;
        padding: 0 18px;
        background: var(--primario-suave);
        border: 1px solid #ddd6fe;
        border-radius: 0;
        font-size: 13px;
        font-weight: 500;
        color: var(--primario);
        text-decoration: none;
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
    }
    .ped-btn-ver:hover {
        background: var(--primario);
        border-color: var(--primario);
        color: #fff;
    }
    .lst-tabla th.num,
    .lst-tabla td.num {
        text-align: right;
        font-variant-numeric: tabular-nums;
    }
    .ped-total {
        font-weight: 700;
    }
</style>
@endpush

<x-sidebar activo="pedidos" :pedidos-pendientes="$conteos->get('enviado', 0)" />

<div class="lst-pagina">
    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Pedidos</h1>
            </div>
            <p>Consulta y administra los pedidos realizados por los clientes.</p>
        </div>
    </div>
    @if(session('success'))
        <div class="lst-mensaje exito">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="lst-mensaje error">{{ $errors->first() }}</div>
    @endif
    @if($cotizaciones->isNotEmpty())
        <div class="lst-herramientas">
            <div class="lst-tabs">
                <button type="button" class="lst-tab activo" data-estado="todos">
                    Todos<span class="ped-tab-n">{{ $cotizaciones->count() }}</span>
                </button>
                @foreach($estadosTexto as $clave => $texto)
                    <button type="button" class="lst-tab" data-estado="{{ $clave }}">
                        {{ $texto }}s<span class="ped-tab-n">{{ $conteos->get($clave, 0) }}</span>
                    </button>
                @endforeach
            </div>
            <div class="lst-controles">
                <div class="lst-buscador">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="buscadorPedidos" placeholder="Buscar por folio o cliente..." autocomplete="off">
                    <button type="button" class="lst-btn-limpiar" id="btnLimpiar" aria-label="Limpiar búsqueda">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="lst-selector">
                    <select id="ordenPedidos">
                        <option value="antiguos">Orden: Más antiguos primero</option>
                        <option value="recientes">Orden: Más recientes primero</option>
                        <option value="total-desc">Orden: Total (mayor a menor)</option>
                        <option value="total-asc">Orden: Total (menor a mayor)</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <span class="lst-contador" id="contadorPedidos">
                    <strong>{{ $cotizaciones->count() }}</strong>
                    {{ $cotizaciones->count() === 1 ? 'registro' : 'registros' }}
                </span>
            </div>
        </div>
        <div class="lst-tabla-wrap" id="tablaPedidos">
            <table class="lst-tabla">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th class="num">Servicios</th>
                        <th>Forma de pago</th>
                        <th>Estado</th>
                        <th class="num">Total</th>
                        <th class="lst-col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaPedidos">
                    @foreach($cotizaciones as $cotizacion)
                        @php
                            $cliente = $cotizacion->usuario
                                ? trim($cotizacion->usuario->name . ' ' . $cotizacion->usuario->apellido)
                                : 'Sin nombre';
                            $estadoTexto = $estadosTexto[$cotizacion->estado] ?? ucfirst($cotizacion->estado);
                        @endphp

                        <tr
                            class="lst-fila"
                            data-url="{{ route('admin.cotizaciones.mostrar', $cotizacion->id) }}"
                            data-folio="{{ $cotizacion->folio }}"
                            data-cliente="{{ $cliente }}"
                            data-pago="{{ $cotizacion->forma_pago }}"
                            data-estado="{{ $cotizacion->estado }}"
                            data-estado-texto="{{ $estadoTexto }}"
                            data-fecha="{{ $cotizacion->created_at?->timestamp ?? 0 }}"
                            data-total="{{ $cotizacion->total }}"
                        >
                            <td data-label="Folio"><span class="ped-folio">{{ $cotizacion->folio }}</span></td>
                            <td data-label="Cliente">{{ $cliente }}</td>
                            <td data-label="Fecha">{{ $cotizacion->created_at?->format('d/m/Y H:i') }}</td>
                            <td data-label="Servicios" class="num">{{ $cotizacion->detalles->sum('cantidad') }}</td>
                            <td data-label="Forma de pago">{{ ucfirst($cotizacion->forma_pago) }}</td>
                            <td data-label="Estado">
                                <span class="ped-estado {{ $cotizacion->estado }}">{{ $estadoTexto }}</span>
                            </td>
                            <td data-label="Total" class="num ped-total">${{ number_format($cotizacion->total, 2) }}</td>
                            <td class="lst-col-acciones">
                                <div class="lst-acciones">
                                    <a href="{{ route('admin.cotizaciones.mostrar', $cotizacion->id) }}" class="ped-btn-ver">Ver</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="lst-vacio" id="sinResultados">
            <h3>No se encontraron resultados</h3>
            <p>Intenta cambiar el filtro o realizar otra búsqueda.</p>
        </div>

    @else
        <div class="lst-vacio visible">
            <h3>No hay pedidos</h3>
            <p>Actualmente no existen pedidos realizados por los clientes.</p>
        </div>

    @endif

</div>

@push('scripts')
<script>
    (function () {
        const cuerpo = document.getElementById('listaPedidos');
        if (!cuerpo) return;
        cuerpo.addEventListener('click', function (evento) {
            if (evento.target.closest('a, button')) return;

            if (window.getSelection().toString()) return;

            const fila = evento.target.closest('.lst-fila');
            if (fila) window.location.href = fila.dataset.url;
        });

        const tabla = document.getElementById('tablaPedidos');
        const buscador = document.getElementById('buscadorPedidos');
        const btnLimpiar = document.getElementById('btnLimpiar');
        const orden = document.getElementById('ordenPedidos');
        const tabs = document.querySelectorAll('.lst-tab');
        const sinResultados = document.getElementById('sinResultados');
        const contador = document.getElementById('contadorPedidos');

        let estadoActual = 'todos';

        function normalizar(texto) {
            return (texto || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
        }

        function aplicar() {
            const texto = normalizar(buscador.value);
            btnLimpiar.style.display = buscador.value ? 'flex' : 'none';

            const filas = Array.from(cuerpo.querySelectorAll('.lst-fila'));

            filas.sort(function (a, b) {
                switch (orden.value) {
                    case 'recientes':  return Number(b.dataset.fecha) - Number(a.dataset.fecha);
                    case 'total-desc': return Number(b.dataset.total) - Number(a.dataset.total);
                    case 'total-asc':  return Number(a.dataset.total) - Number(b.dataset.total);
                    default:           return Number(a.dataset.fecha) - Number(b.dataset.fecha);
                }
            });

            let visibles = 0;
            filas.forEach(function (fila) {
                cuerpo.appendChild(fila);
                const coincideEstado = estadoActual === 'todos' || fila.dataset.estado === estadoActual;
                const contenido = normalizar(
                    fila.dataset.folio + ' ' +
                    fila.dataset.cliente + ' ' +
                    fila.dataset.pago + ' ' +
                    fila.dataset.estadoTexto
                );
                const mostrar = coincideEstado && contenido.includes(texto);

                fila.style.display = mostrar ? '' : 'none';
                if (mostrar) visibles++;
            });

            tabla.style.display = visibles === 0 ? 'none' : '';
            sinResultados.classList.toggle('visible', visibles === 0);
            contador.innerHTML = '<strong>' + visibles + '</strong> ' + (visibles === 1 ? 'registro' : 'registros');
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('activo'); });
                this.classList.add('activo');
                estadoActual = this.dataset.estado;
                aplicar();
            });
        });

        buscador.addEventListener('input', aplicar);
        orden.addEventListener('change', aplicar);

        btnLimpiar.addEventListener('click', function () {
            buscador.value = '';
            aplicar();
            buscador.focus();
        });

        const estadoUrl = new URLSearchParams(window.location.search).get('estado');
        const tabInicial = document.querySelector('.lst-tab[data-estado="' + estadoUrl + '"]');

        if (tabInicial) {
            tabInicial.click();
        } else {
            aplicar();
        }
    })();
</script>
@endpush

</x-layouts.panel>