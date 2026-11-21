@php
    $tipo = $tipo ?? null;
@endphp

<x-layouts.panel
    titulo="Categorías"
    :migas="[['texto' => 'Categorías', 'url' => null]]"
>

<x-lista-estilos />

@push('estilos')
<style>
    .cat-alerta {
        padding: 12px 16px;
        margin-bottom: 16px;
        font-size: 14px;
        background: #ecfdf3;
        border: 1px solid #abefc6;
        color: #067647;
    }
    .cat-alerta.error {
        background: #fef3f2;
        border-color: #fecdca;
        color: #b42318;
    }

    a.lst-tab {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
    }

    .cat-nombre { font-weight: 600; color: var(--texto); }
    .cat-desc {
        font-size: 13px;
        color: var(--texto-suave);
        margin-top: 2px;
        max-width: 460px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .cat-tipo {
        display: inline-block;
        padding: 3px 10px;
        font-size: 12px;
        font-weight: 600;
        background: var(--primario-suave);
        color: var(--primario-oscuro);
        border: 1px solid #ddd0fb;
    }
    .cat-uso { font-size: 13px; color: var(--texto); }
    .cat-sin-uso { font-size: 13px; color: var(--texto-suave); }
    .cat-acciones { display: flex; gap: 6px; justify-content: flex-end; }
    tr.fila-cat { cursor: pointer; }

    @media (max-width: 700px) {
        .cat-desc { max-width: none; white-space: normal; }
    }
</style>
@endpush

<x-sidebar activo="categorias" />
<div class="lst-pagina">
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
                <h1>Categorías</h1>
            </div>
            <p>Organiza los bienes, servicios y gastos del sistema.</p>
        </div>
        <a href="{{ route('admin.categorias.create', $tipo ? ['tipo' => $tipo] : []) }}" class="lst-btn-principal">Registrar categoría</a>
    </div>

    @if(session('success'))
        <div class="cat-alerta">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="cat-alerta error">{{ session('error') }}</div>
    @endif

    <div class="lst-herramientas">
        <div class="lst-tabs">
            <a href="{{ route('admin.categorias.index') }}"
               class="lst-tab {{ !$tipo ? 'activo' : '' }}">Todas</a>
            @foreach(\App\Models\Categoria::TIPOS as $clave => $etiquetas)
                <a href="{{ route('admin.categorias.index', ['tipo' => $clave]) }}"
                   class="lst-tab {{ $tipo === $clave ? 'activo' : '' }}">{{ $etiquetas['plural'] }}</a>
            @endforeach
        </div>

        <div class="lst-controles">
            <div class="lst-buscador">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorCategorias" placeholder="Buscar nombre o descripción..." autocomplete="off">
            </div>

            <span class="lst-contador" id="contadorCategorias"></span>
        </div>
    </div>

    @if($categorias->isNotEmpty())
        <div class="lst-tabla-wrap">
            <table class="lst-tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>En uso</th>
                        <th style="text-align:right;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyCategorias">
                    @foreach($categorias as $categoria)
                        @php $uso = $categoria->descripcionDeUsos(); @endphp
                        <tr class="fila-cat"
                            data-url="{{ route('admin.categorias.edit', $categoria->id) }}"
                            data-texto="{{ $categoria->nombre }} {{ $categoria->descripcion }} {{ $categoria->tipo_etiqueta }}">
                            <td data-label="Nombre">
                                <div class="cat-nombre">{{ $categoria->nombre }}</div>
                                @if($categoria->descripcion)
                                    <div class="cat-desc" title="{{ $categoria->descripcion }}">{{ $categoria->descripcion }}</div>
                                @endif
                            </td>
                            <td data-label="Tipo">
                                <span class="cat-tipo">{{ $categoria->tipo_etiqueta }}</span>
                            </td>
                            <td data-label="En uso">
                                @if($uso !== '')
                                    <span class="cat-uso">{{ $uso }}</span>
                                @else
                                    <span class="cat-sin-uso">Sin uso</span>
                                @endif
                            </td>
                            <td data-label="Acciones">
                                <div class="cat-acciones">
                                    <a href="{{ route('admin.categorias.edit', $categoria->id) }}"
                                       class="lst-btn-editar" title="Editar" aria-label="Editar {{ $categoria->nombre }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button type="button" class="lst-btn-eliminar" title="Eliminar"
                                            aria-label="Eliminar {{ $categoria->nombre }}"
                                            data-id="{{ $categoria->id }}"
                                            data-nombre="{{ $categoria->nombre }}"
                                            data-uso="{{ $uso }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="lst-vacio" id="sinResultadosCategorias">Ninguna categoría coincide con la búsqueda.</div>
    @else
        <div class="lst-vacio" style="display:block;">
            No hay categorías registradas{{ $tipo ? ' en este tipo' : '' }}.
        </div>
    @endif

</div>

<div class="lst-modal" id="modalEliminar" role="dialog" aria-modal="true" aria-labelledby="tituloModalEliminar">
    <div class="lst-modal-caja">
        <h2 id="tituloModalEliminar">Eliminar categoría</h2>
        <p id="mensajeEliminar"></p>

        <form id="formEliminar" method="POST">
            @csrf
            @method('DELETE')
            <div class="lst-modal-botones">
                <button type="button" class="lst-btn-cancelar" id="btnCancelarEliminar">Cancelar</button>
                <button type="submit" class="lst-btn-confirmar" id="btnConfirmarEliminar">Sí, eliminar</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const tbody = document.getElementById('tbodyCategorias');
    if (!tbody) return;

    const norm = t => (t || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();

    const filas = Array.from(tbody.querySelectorAll('tr.fila-cat'));
    const buscador = document.getElementById('buscadorCategorias');
    const contador = document.getElementById('contadorCategorias');
    const vacio = document.getElementById('sinResultadosCategorias');

    function aplicar() {
        const q = norm(buscador.value.trim());
        let visibles = 0;

        filas.forEach(f => {
            const ok = norm(f.dataset.texto).includes(q);
            f.style.display = ok ? '' : 'none';
            if (ok) visibles++;
        });

        contador.innerHTML = '<strong>' + visibles + '</strong> ' + (visibles === 1 ? 'categoría' : 'categorías');
        vacio.style.display = visibles ? 'none' : 'block';
    }

    buscador.addEventListener('input', aplicar);

    tbody.addEventListener('click', e => {
        if (e.target.closest('a, button, form')) return;
        if (window.getSelection().toString()) return;
        const fila = e.target.closest('tr.fila-cat');
        if (fila) window.location.href = fila.dataset.url;
    });

    const modal = document.getElementById('modalEliminar');
    const titulo = document.getElementById('tituloModalEliminar');
    const mensaje = document.getElementById('mensajeEliminar');
    const formulario = document.getElementById('formEliminar');
    const btnCancelar = document.getElementById('btnCancelarEliminar');
    const btnConfirmar = document.getElementById('btnConfirmarEliminar');
    const urlBase = @js(url('/admin/categorias'));

    function abrirModal(id, nombre, uso) {
        const fuerte = document.createElement('strong');
        fuerte.textContent = nombre;
        mensaje.textContent = '';

        if (uso) {
            titulo.textContent = 'No se puede eliminar';
            mensaje.append('La categoría ', fuerte, ' está en uso en ' + uso
                + '. Reasígnalos a otra categoría y vuelve a intentarlo.');
            btnConfirmar.style.display = 'none';
            btnCancelar.textContent = 'Entendido';
        } else {
            titulo.textContent = 'Eliminar categoría';
            mensaje.append('¿Seguro que deseas eliminar la categoría ', fuerte, '? Esta acción no se puede deshacer.');
            btnConfirmar.style.display = '';
            btnCancelar.textContent = 'Cancelar';
        }

        formulario.action = urlBase + '/' + id;
        modal.classList.add('activo');
    }

    function cerrarModal() { modal.classList.remove('activo'); }

    tbody.addEventListener('click', e => {
        const btn = e.target.closest('.lst-btn-eliminar');
        if (btn) abrirModal(btn.dataset.id, btn.dataset.nombre, btn.dataset.uso);
    });
    btnCancelar.addEventListener('click', cerrarModal);
    modal.addEventListener('click', e => { if (e.target === modal) cerrarModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });

    aplicar();
})();
</script>
@endpush

</x-layouts.panel>