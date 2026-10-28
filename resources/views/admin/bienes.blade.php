<x-layouts.panel
    titulo="Inventario de Bienes"
    :regresar="route('admin.inventario')"
    :migas="[
        ['texto' => 'Administración', 'url' => route('admin.dashboard')],
        ['texto' => 'Inventario'],
    ]"
>

@push('estilos')
<style>
    /* ===== ENCABEZADO DE LA PÁGINA ===== */
    .pagina-bienes { 
        padding: 40px 0 56px; 
    }
    .pagina-encabezado { 
        display: flex; 
        justify-content: space-between; 
        align-items: flex-end; 
        gap: 16px; 
        padding-bottom: 24px; 
        margin-bottom: 28px; 
        border-bottom: 1px solid var(--borde); 
    }
    .pagina-encabezado h1 { 
        margin: 0 0 6px; 
        font-size: 32px; 
        font-weight: 700; 
        letter-spacing: -0.02em; 
        color: var(--texto); 
    }
    .pagina-encabezado p { 
        margin: 0; 
        font-size: 15px; 
        color: var(--texto-suave); 
    }

    /* ===== BOTÓN AGREGAR ===== */
    .btn-agregar { 
        display: inline-flex; 
        align-items: center; 
        gap: 10px; 
        padding: 14px 20px; 
        background: var(--primario); 
        color: #fff; 
        border-radius: 6px; 
        font-size: 15px; 
        font-weight: 600; 
        text-decoration: none; 
        white-space: nowrap; 
        transition: background 0.2s ease; 
    }
    .btn-agregar:hover { 
        background: var(--primario-oscuro); 
    }

    /* ===== BUSCADOR Y FILTRO DE ORDEN ===== */
    .barra-herramientas { 
        display: flex; 
        gap: 16px; 
        margin-bottom: 28px; 
    }
    .buscador { 
        position: relative; 
        flex: 1; 
    }
    .buscador i { 
        position: absolute; 
        left: 18px; 
        top: 50%; 
        transform: translateY(-50%); 
        color: #9ca3af; 
        font-size: 14px; 
    }
    .buscador input { 
        width: 100%; 
        height: 52px; 
        padding: 0 18px 0 46px; 
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 6px; 
        font-family: inherit; 
        font-size: 15px; 
        color: var(--texto); 
        outline: none; 
        transition: border-color 0.2s ease, box-shadow 0.2s ease; 
    }
    .buscador input::placeholder { 
        color: #9ca3af; 
    }
    .buscador input:focus { 
        border-color: var(--primario); 
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1); 
    }
    .filtro { 
        position: relative; 
    }
    .boton-filtro { 
        height: 52px; 
        display: inline-flex; 
        align-items: center; 
        gap: 10px; 
        padding: 0 20px; 
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 6px; 
        font-family: inherit; 
        font-size: 15px; 
        font-weight: 500; 
        color: var(--texto); 
        cursor: pointer; 
        white-space: nowrap; 
        transition: border-color 0.2s ease, background 0.2s ease; 
    }
    .boton-filtro:hover { 
        border-color: #c4b5fd; 
        background: #fcfbff; 
    }
    .menu-filtro { 
        display: none; 
        position: absolute; 
        top: calc(100% + 6px);
        right: 0; 
        width: 200px; 
        padding: 6px; 
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 8px; 
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); 
        z-index: 100; 
    }
    .menu-filtro.activo { 
        display: block; 
    }
    .menu-filtro button { 
        width: 100%; 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        padding: 10px 12px; 
        background: none; border: none; 
        border-radius: 6px; 
        font-family: inherit; 
        font-size: 14px; 
        color: var(--texto); 
        text-align: left; 
        cursor: pointer; 
        transition: background 0.2s ease; 
    }
    .menu-filtro button:hover { 
        background: var(--primario-suave); color: var(--primario); 
    }

    /* ===== TARJETA DE BIEN ===== */
    .bienes-grid { 
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        gap: 24px; 
        margin-bottom: 32px; 
    }
    .bien-card { 
        display: block; 
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 8px; 
        overflow: hidden; 
        text-decoration: none; 
        color: inherit; 
        cursor: pointer; 
        transition: border-color 0.2s ease, box-shadow 0.2s ease; 
    }
    .bien-card:hover { 
        border-color: #c4b5fd; 
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07); 
    }
    .bien-imagen { 
        width: 100%; 
        height: 220px; 
        background: #f3f4f6; 
    }
    .bien-imagen img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        display: block; 
    }
    .imagen-sin-foto { 
        width: 100%; 
        height: 100%; 
        display: flex; 
        flex-direction: column; 
        align-items: center;
        justify-content: center; 
        gap: 8px; 
        color: #9ca3af; 
        font-size: 14px; 
    }
    .imagen-sin-foto i { 
        font-size: 40px; 
        color: #c4b5fd; 
    }
    .bien-contenido { 
        padding: 22px 26px 24px; 
    }
    .bien-fila { 
        display: flex; 
        justify-content: space-between; 
        align-items: baseline; 
        gap: 12px; 
    }
    .bien-nombre { 
        margin: 0; 
        font-size: 18px; 
        font-weight: 600; 
        color: var(--texto); 
    }
    .bien-precio { 
        font-size: 18px; 
        font-weight: 600; 
        color: var(--texto); 
        white-space: nowrap; 
    }
    .bien-cantidad { 
        margin: 6px 0 0; 
        font-size: 15px; 
        color: var(--texto-suave); 
    }
    .bien-pie { 
        display: flex; 
        justify-content: flex-end; 
        margin-top: 22px; 
        padding-top: 18px; 
        border-top: 1px solid #f0f0f3; 
    }
    .btn-editar { 
        padding: 8px 18px; 
        border: 1px solid #ddd6fe; 
        border-radius: 6px; 
        font-size: 15px; 
        font-weight: 500; 
        color: var(--primario); 
        transition: background 0.2s ease; 
    }
    .bien-card:hover .btn-editar { 
        background: var(--primario-suave); 
    }

    /* ===== SIN RESULTADOS ===== */
    .sin-resultados { 
        grid-column: 1 / -1; 
        padding: 48px 20px; 
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 8px; 
        text-align: center; 
        color: var(--texto-suave); 
    }
    .sin-resultados i { 
        font-size: 36px; 
        color: #c4b5fd; 
        margin-bottom: 12px; 
    }
    .sin-resultados h3 { 
        margin: 4px 0; 
        font-size: 17px; 
        color: var(--texto); 
    }
    .sin-resultados p { 
        margin: 0; font-size: 14px; 
    }

    /* ===== PIE DE LA LISTA ===== */
    .pie-lista { 
        padding: 22px 28px; 
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 8px; 
        font-size: 15px; 
        color: var(--texto-suave); 
    }

    /* ===== MODAL ELIMINAR (se usará en la edición) ===== */
    .modal { 
        display: none; 
        position: fixed; 
        inset: 0; 
        z-index: 2000; 
        align-items: center; 
        justify-content: center; 
        padding: 20px; 
        background: rgba(17, 24, 39, 0.55); 
    }
    .modal.activo { 
        display: flex; 
    }
    .modal-contenido { 
        width: 100%; 
        max-width: 400px; 
        padding: 30px; 
        background: #fff; 
        border-radius: 12px; 
        text-align: center; 
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25); 
        animation: aparecerModal 0.25s ease; 
    }
    .modal-icono { 
        width: 64px; 
        height: 64px; 
        margin: 0 auto 16px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 50%; 
        background: #fee2e2; 
        color: #dc2626; 
        font-size: 26px; 
    }
    .modal-contenido h2 { 
        margin: 8px 0; 
        color: var(--texto); 
    }
    .modal-contenido p { 
        margin: 0 0 24px; 
        line-height: 1.5; 
        color: var(--texto-suave); 
    }
    .modal-botones { 
        display: flex; 
        gap: 12px; 
    }
    .boton-cancelar, .boton-confirmar { 
        flex: 1; 
        padding: 12px; 
        border: none; 
        border-radius: 6px; 
        font-family: inherit; 
        font-size: 14px; 
        font-weight: 600; 
        cursor: pointer; 
        transition: background 0.2s ease; 
    }
    .boton-cancelar { 
        background: #e5e7eb; 
        color: #374151; 
    }
    .boton-cancelar:hover { 
        background: #d1d5db; 
    }
    .boton-confirmar { 
        background: #dc2626; 
        color: #fff; 
    }
    .boton-confirmar:hover { 
        background: #b91c1c; 
    }
    @keyframes aparecerModal { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

    /* ===== RESPONSIVO ===== */
    @media (max-width: 950px) {
        .bienes-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 650px) {
        .pagina-bienes { padding: 28px 0 40px; }
        .pagina-encabezado { flex-direction: column; align-items: stretch; }
        .pagina-encabezado h1 { font-size: 26px; }
        .btn-agregar { justify-content: center; }
        .barra-herramientas { flex-direction: column; }
        .boton-filtro { width: 100%; justify-content: center; }
        .menu-filtro { width: 100%; left: 0; right: auto; }
        .bienes-grid { grid-template-columns: 1fr; }
        .modal-botones { flex-direction: column; }
    }
</style>
@endpush

<div class="pagina-bienes">

    <!-- =========================
         ENCABEZADO Y BOTÓN AGREGAR
    ========================= -->
    <div class="pagina-encabezado">
        <div>
            <h1>Inventario de Bienes</h1>
            <p>Gestión directa de activos y existencias.</p>
        </div>
        <a href="{{ route('admin.agregar_bien') }}" class="btn-agregar">
            <i class="fa-solid fa-plus"></i>
            Agregar Bien
        </a>
    </div>

    <!-- =========================
         BUSCADOR Y FILTRO DE ORDEN
    ========================= -->
    <div class="barra-herramientas">
        <div class="buscador">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="buscadorBienes" placeholder="Buscar por nombre..." autocomplete="off">
        </div>
        <div class="filtro">
            <button type="button" class="boton-filtro" id="botonFiltro">
                <i class="fa-solid fa-arrow-down-up-across-line"></i>
                Ordenar
            </button>
            <div class="menu-filtro" id="menuFiltro">
                <button type="button" id="ordenAscendente">
                    <i class="fa-solid fa-arrow-down-a-z"></i>
                    Nombre: A → Z
                </button>
                <button type="button" id="ordenDescendente">
                    <i class="fa-solid fa-arrow-up-z-a"></i>
                    Nombre: Z → A
                </button>
            </div>
        </div>
    </div>

    <!-- =========================
         LISTA DE BIENES
    ========================= -->
    <div class="bienes-grid" id="listaBienes">
        @forelse($bienes as $bien)
            <!-- TARJETA DE BIEN (abre la edición) -->
            <a href="{{ route('admin.inventario.editar', $bien->id) }}" class="bien-card" data-nombre="{{ $bien->nombre }}">

                <!-- Foto -->
                <div class="bien-imagen">
                    @if($bien->foto)
                        <img src="{{ asset('storage/' . $bien->foto) }}" alt="{{ $bien->nombre }}" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="imagen-sin-foto" style="display: none;">
                            <i class="fa-regular fa-image"></i>
                            <span>Sin imagen</span>
                        </div>
                    @else
                        <div class="imagen-sin-foto">
                            <i class="fa-regular fa-image"></i>
                            <span>Sin imagen</span>
                        </div>
                    @endif
                </div>

                <!-- Información -->
                <div class="bien-contenido">
                    <div class="bien-fila">
                        <h2 class="bien-nombre">{{ $bien->nombre }}</h2>
                        <span class="bien-precio">$ {{ number_format($bien->precio, 2) }}</span>
                    </div>
                    <p class="bien-cantidad">{{ $bien->cantidad }} {{ $bien->cantidad == 1 ? 'unidad' : 'unidades' }}</p>
                    <div class="bien-pie">
                        <span class="btn-editar">Editar</span>
                    </div>
                </div>

            </a>

        @empty

            <!-- SIN BIENES REGISTRADOS -->
            <div class="sin-resultados" id="sinBienes">
                <i class="fa-solid fa-box-open"></i>
                <h3>No hay bienes registrados</h3>
                <p>Todavía no has agregado ningún bien al inventario.</p>
            </div>

        @endforelse

        <!-- SIN RESULTADOS DE BÚSQUEDA -->
        <div class="sin-resultados" id="sinResultados" style="display: none;">
            <i class="fa-solid fa-box-open"></i>
            <h3>No se encontraron bienes</h3>
            <p>Intenta buscar utilizando otro nombre.</p>
        </div>

    </div>

    <!-- =========================
         PIE DE LA LISTA (TOTAL)
    ========================= -->
    @if($bienes->count() > 0)
        <div class="pie-lista">
            <span id="contadorBienes">{{ $bienes->count() }} {{ $bienes->count() == 1 ? 'bien' : 'bienes' }} en total</span>
        </div>
    @endif

</div>

<!-- =========================
     MODAL ELIMINAR BIEN
========================= -->
<div id="modalEliminar" class="modal">
    <div class="modal-contenido">
        <div class="modal-icono">
            <i class="fa-solid fa-trash"></i>
        </div>
        <h2>Eliminar bien</h2>
        <p id="mensajeEliminar">¿Estás seguro de que deseas eliminar este bien?</p>
        <form id="formEliminar" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-botones">
                <!-- CANCELAR -->
                <button type="button" class="boton-cancelar" onclick="cerrarModalEliminar()">Cancelar</button>
                <!-- CONFIRMAR -->
                <button type="submit" class="boton-confirmar">
                    <i class="fa-solid fa-trash"></i>
                    Sí, eliminar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const buscador = document.getElementById('buscadorBienes');
    const listaBienes = document.getElementById('listaBienes');
    const sinResultados = document.getElementById('sinResultados');
    const botonFiltro = document.getElementById('botonFiltro');
    const menuFiltro = document.getElementById('menuFiltro');
    const contador = document.getElementById('contadorBienes');
    const totalBienes = listaBienes.querySelectorAll('.bien-card').length;

    /* ===== UTILIDADES ===== */
    // Minúsculas y sin acentos: "Orquídea" coincide con "orquidea"
    function normalizar(texto) {
        return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
    }

    function actualizarContador(visibles) {
        if (!contador) return;
        contador.textContent = visibles === totalBienes
            ? totalBienes + (totalBienes === 1 ? ' bien' : ' bienes') + ' en total'
            : visibles + ' de ' + totalBienes + ' bienes';
    }

    /* ===== BUSCADOR ===== */
    function filtrarBienes() {
        const texto = normalizar(buscador.value);
        let encontrados = 0;
        listaBienes.querySelectorAll('.bien-card').forEach(function (bien) {
            const coincide = normalizar(bien.dataset.nombre).includes(texto);
            bien.style.display = coincide ? '' : 'none';
            if (coincide) encontrados++;
        });
        sinResultados.style.display = (encontrados === 0 && totalBienes > 0) ? 'block' : 'none';
        actualizarContador(encontrados);
    }

    if (buscador) buscador.addEventListener('input', filtrarBienes);

    /* ===== ORDENAR ===== */
    function ordenarBienes(tipo) {
        const bienes = Array.from(listaBienes.querySelectorAll('.bien-card'));
        bienes.sort(function (a, b) {
            const orden = a.dataset.nombre.localeCompare(b.dataset.nombre, 'es', { sensitivity: 'base' });
            return tipo === 'asc' ? orden : -orden;
        });
        bienes.forEach(function (bien) { listaBienes.appendChild(bien); });
        filtrarBienes();
    }

    document.getElementById('ordenAscendente').addEventListener('click', function () {
        ordenarBienes('asc');
        menuFiltro.classList.remove('activo');
    });

    document.getElementById('ordenDescendente').addEventListener('click', function () {
        ordenarBienes('desc');
        menuFiltro.classList.remove('activo');
    });

    /* ===== MENÚ DEL FILTRO ===== */
    botonFiltro.addEventListener('click', function (event) {
        event.stopPropagation();
        menuFiltro.classList.toggle('activo');
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.filtro')) menuFiltro.classList.remove('activo');
    });

    /* ===== MODAL ELIMINAR ===== */
    function abrirModalEliminar(id, nombre) {
        document.getElementById('mensajeEliminar').innerHTML =
            '¿Estás seguro de que deseas eliminar el bien <strong>' + escapeHtml(nombre) + '</strong>?';
        document.getElementById('formEliminar').action = "{{ url('/admin/inventario') }}/" + id;
        document.getElementById('modalEliminar').classList.add('activo');
    }

    function cerrarModalEliminar() {
        document.getElementById('modalEliminar').classList.remove('activo');
    }

    window.addEventListener('click', function (event) {
        if (event.target === document.getElementById('modalEliminar')) cerrarModalEliminar();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') cerrarModalEliminar();
    });

    // Evita inyección de HTML en el nombre del bien
    function escapeHtml(texto) {
        const div = document.createElement('div');
        div.textContent = texto;
        return div.innerHTML;
    }
</script>
@endpush
</x-layouts.panel>