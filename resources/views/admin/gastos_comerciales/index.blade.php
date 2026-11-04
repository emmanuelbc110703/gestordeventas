@php
    $filtro = $filtro ?? 'todos';

    $categorias = [
        'publicidad'    => 'Publicidad',
        'transporte'    => 'Transporte',
        'papeleria'     => 'Papelería',
        'servicios'     => 'Servicios',
        'mantenimiento' => 'Mantenimiento',
        'compras'       => 'Compras',
        'otros'         => 'Otros',
    ];

    $etiquetaCategoria = fn ($clave) => $categorias[$clave] ?? ucfirst($clave);

    $totalPeriodo = $gastos->sum('monto');

    $porCategoria = $gastos->groupBy('categoria')->map(fn ($g) => $g->sum('monto'))->sortDesc();
    $topCategoria = $porCategoria->keys()->first();
    $topMonto     = $porCategoria->first();
@endphp

<x-layouts.panel
    titulo="Gastos comerciales"
    :migas="[['texto' => 'Gastos comerciales', 'url' => null]]"
>

<x-lista-estilos />

@push('estilos')
<style>
    .gx-resumen {
        display: grid; 
        grid-template-columns: repeat(3, 1fr);
        background: #fff; 
        border: 1px solid var(--borde); 
        margin-bottom: 20px;
    }
    .gx-resumen > div { 
        padding: 16px 20px; 
        border-right: 1px solid var(--borde); 
        min-width: 0; 
    }
    .gx-resumen > div:last-child { border-right: none; }
    .gx-resumen small { 
        display: block; 
        font-size: 12px; 
        font-weight: 600; 
        text-transform: uppercase;
        letter-spacing: .04em; 
        color: var(--texto-suave); 
        margin-bottom: 6px; 
    }
    .gx-resumen strong { 
        font-size: 22px; 
        font-weight: 700; 
        color: var(--texto); 
    }
    .gx-resumen span { 
        font-size: 13px; 
        color: var(--texto-suave); 
        margin-left: 6px; 
    }

    .gx-alerta { 
        padding: 12px 16px; 
        margin-bottom: 16px; 
        font-size: 14px;
        background: #ecfdf3; 
        border: 1px solid #abefc6; 
        color: #067647; 
    }

    a.lst-tab { 
        display: inline-flex; 
        align-items: center; 
        text-decoration: none; 
    }

    .gx-concepto { 
        font-weight: 600; 
        color: var(--texto); 
    }
    .gx-desc { 
        font-size: 13px; 
        color: var(--texto-suave); 
        margin-top: 2px; 
        max-width: 460px;
        overflow: hidden; 
        text-overflow: ellipsis; 
        white-space: nowrap; 
    }
    .gx-categoria { 
        display: inline-block; 
        padding: 3px 10px; 
        font-size: 12px; 
        font-weight: 600;
        background: var(--primario-suave); 
        color: var(--primario-oscuro); 
        border: 1px solid #ddd0fb; 
    }
    .gx-monto { 
        white-space: nowrap; 
        font-weight: 600; 
        font-variant-numeric: tabular-nums; 
        text-align: right; 
    }
    .gx-acciones { 
        display: flex; 
        gap: 6px; 
        justify-content: flex-end; 
    }
    tr.fila-gasto { cursor: pointer; }

    @media (max-width: 700px) {
        .gx-resumen { grid-template-columns: 1fr; }
        .gx-resumen > div { border-right: none; border-bottom: 1px solid var(--borde); }
        .gx-resumen > div:last-child { border-bottom: none; }
        .gx-desc { max-width: none; white-space: normal; }
    }
</style>
@endpush

<x-sidebar activo="gastos" />
<div class="lst-pagina">
    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Gastos comerciales</h1>
            </div>
            <p>Consulta y administra los gastos del negocio.</p>
        </div>
        <a href="{{ route('admin.gastos_comerciales.create') }}" class="lst-btn-principal">Registrar gasto</a>
    </div>

    @if(session('success'))
        <div class="gx-alerta">{{ session('success') }}</div>
    @endif

    <div class="gx-resumen">
        <div>
            <small>Total del período</small>
            <strong>${{ number_format($totalPeriodo, 2) }}</strong>
        </div>
        <div>
            <small>Gastos registrados</small>
            <strong>{{ $gastos->count() }}</strong>
        </div>
        <div>
            <small>Mayor categoría</small>
            @if($topCategoria)
                <strong>{{ $etiquetaCategoria($topCategoria) }}</strong>
                <span>${{ number_format($topMonto, 2) }}</span>
            @else
                <strong>—</strong>
            @endif
        </div>
    </div>

    <div class="lst-herramientas">
        <div class="lst-tabs">
            <a href="{{ route('admin.gastos_comerciales', ['filtro' => 'todos']) }}"
               class="lst-tab {{ $filtro === 'todos' ? 'activo' : '' }}">Todos</a>
            <a href="{{ route('admin.gastos_comerciales', ['filtro' => 'semana']) }}"
               class="lst-tab {{ $filtro === 'semana' ? 'activo' : '' }}">Esta semana</a>
            <a href="{{ route('admin.gastos_comerciales', ['filtro' => 'mes']) }}"
               class="lst-tab {{ $filtro === 'mes' ? 'activo' : '' }}">Este mes</a>
        </div>

        <div class="lst-controles">
            <div class="lst-buscador">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorGastos" placeholder="Buscar concepto o descripción..." autocomplete="off">
            </div>

            <div class="lst-selector">
                <select id="categoriaGastos" aria-label="Filtrar por categoría">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $clave => $nombre)
                        <option value="{{ $clave }}">{{ $nombre }}</option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>

            <div class="lst-selector">
                <select id="ordenGastos" aria-label="Ordenar gastos">
                    <option value="fecha-desc">Más recientes</option>
                    <option value="fecha-asc">Más antiguos</option>
                    <option value="monto-desc">Monto: mayor a menor</option>
                    <option value="monto-asc">Monto: menor a mayor</option>
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>

            <span class="lst-contador" id="contadorGastos"></span>
        </div>
    </div>

    @if($gastos->isNotEmpty())
        <div class="lst-tabla-wrap">
            <table class="lst-tabla">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Categoría</th>
                        <th style="text-align:right;">Monto</th>
                        <th style="text-align:right;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyGastos">
                    @foreach($gastos as $gasto)
                        <tr class="fila-gasto"
                            data-url="{{ route('admin.gastos_comerciales.edit', $gasto->id) }}"
                            data-categoria="{{ $gasto->categoria }}"
                            data-fecha="{{ $gasto->fecha->format('Y-m-d') }}"
                            data-monto="{{ $gasto->monto }}"
                            data-texto="{{ $gasto->concepto }} {{ $gasto->descripcion }} {{ $etiquetaCategoria($gasto->categoria) }}">
                            <td data-label="Fecha">{{ $gasto->fecha->format('d/m/Y') }}</td>
                            <td data-label="Concepto">
                                <div class="gx-concepto">{{ $gasto->concepto }}</div>
                                @if($gasto->descripcion)
                                    <div class="gx-desc" title="{{ $gasto->descripcion }}">{{ $gasto->descripcion }}</div>
                                @endif
                            </td>
                            <td data-label="Categoría">
                                <span class="gx-categoria">{{ $etiquetaCategoria($gasto->categoria) }}</span>
                            </td>
                            <td data-label="Monto" class="gx-monto">${{ number_format($gasto->monto, 2) }}</td>
                            <td data-label="Acciones">
                                <div class="gx-acciones">
                                    <a href="{{ route('admin.gastos_comerciales.edit', $gasto->id) }}"
                                       class="lst-btn-editar" title="Editar" aria-label="Editar {{ $gasto->concepto }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button type="button" class="lst-btn-eliminar" title="Eliminar"
                                            aria-label="Eliminar {{ $gasto->concepto }}"
                                            data-id="{{ $gasto->id }}" data-nombre="{{ $gasto->concepto }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="lst-vacio" id="sinResultadosGastos">Ningún gasto coincide con los filtros.</div>
    @else
        <div class="lst-vacio" style="display:block;">
            No hay gastos registrados para este período.
        </div>
    @endif

</div>

<div class="lst-modal" id="modalEliminar" role="dialog" aria-modal="true" aria-labelledby="tituloModalEliminar">
    <div class="lst-modal-caja">
        <h2 id="tituloModalEliminar">Eliminar gasto</h2>
        <p id="mensajeEliminar"></p>

        <form id="formEliminar" method="POST">
            @csrf
            @method('DELETE')
            <div class="lst-modal-botones">
                <button type="button" class="lst-btn-cancelar" id="btnCancelarEliminar">Cancelar</button>
                <button type="submit" class="lst-btn-confirmar">Sí, eliminar</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const norm = t => (t || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
    const dinero = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });

    const tbody = document.getElementById('tbodyGastos');
    if (tbody) {
        const filas = Array.from(tbody.querySelectorAll('tr.fila-gasto'));
        filas.forEach((f, i) => f.dataset.i = i);

        const buscador = document.getElementById('buscadorGastos');
        const categoria = document.getElementById('categoriaGastos');
        const orden = document.getElementById('ordenGastos');
        const contador = document.getElementById('contadorGastos');
        const vacio = document.getElementById('sinResultadosGastos');

        function aplicar() {
            const q = norm(buscador.value.trim());
            const [campo, sentido] = orden.value.split('-');
            const factor = sentido === 'asc' ? 1 : -1;

            filas.sort((a, b) => {
                let r = campo === 'monto'
                    ? parseFloat(a.dataset.monto) - parseFloat(b.dataset.monto)
                    : a.dataset.fecha.localeCompare(b.dataset.fecha);
                if (r === 0) return (a.dataset.i - b.dataset.i);
                return r * factor;
            }).forEach(f => tbody.appendChild(f));

            let visibles = 0, total = 0;
            filas.forEach(f => {
                const ok = (!categoria.value || f.dataset.categoria === categoria.value)
                        && norm(f.dataset.texto).includes(q);
                f.style.display = ok ? '' : 'none';
                if (ok) { visibles++; total += parseFloat(f.dataset.monto); }
            });

            contador.innerHTML = '<strong>' + visibles + '</strong> ' + (visibles === 1 ? 'gasto' : 'gastos')
                + ' · ' + dinero.format(total);
            vacio.style.display = visibles ? 'none' : 'block';
        }

        buscador.addEventListener('input', aplicar);
        categoria.addEventListener('change', aplicar);
        orden.addEventListener('change', aplicar);

        tbody.addEventListener('click', e => {
            if (e.target.closest('a, button, form')) return;
            if (window.getSelection().toString()) return;
            const fila = e.target.closest('tr.fila-gasto');
            if (fila) window.location.href = fila.dataset.url;
        });

        const modal = document.getElementById('modalEliminar');
        const formulario = document.getElementById('formEliminar');
        const mensaje = document.getElementById('mensajeEliminar');
        const urlEliminar = @js(route('admin.gastos_comerciales.destroy', '__ID__'));

        function abrirModal(id, nombre) {
            const fuerte = document.createElement('strong');
            fuerte.textContent = nombre;
            mensaje.textContent = '';
            mensaje.append('¿Seguro que deseas eliminar el gasto ', fuerte, '? Esta acción no se puede deshacer.');
            formulario.action = urlEliminar.replace('__ID__', id);
            modal.classList.add('activo');
        }
        function cerrarModal() { modal.classList.remove('activo'); }

        tbody.addEventListener('click', e => {
            const btn = e.target.closest('.lst-btn-eliminar');
            if (btn) abrirModal(btn.dataset.id, btn.dataset.nombre);
        });
        document.getElementById('btnCancelarEliminar').addEventListener('click', cerrarModal);
        modal.addEventListener('click', e => { if (e.target === modal) cerrarModal(); });
        document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });

        aplicar();
    }
})();
</script>
@endpush

</x-layouts.panel>