<x-layouts.panel
    titulo="Inventario de Servicios"
    :regresar="route('admin.inventario')"
    :migas="[
        ['texto' => 'Administración', 'url' => route('admin.dashboard')],
        ['texto' => 'Inventario', 'url' => route('admin.inventario')],
        ['texto' => 'Servicios', 'url' => route('admin.servicios')],
    ]"
>

@push('estilos')
<style>
    /* ===== ENCABEZADO DE LA PÁGINA ===== */
    .pagina-servicios { 
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

    /* ===== MENSAJE DE ÉXITO ===== */
    .mensaje-exito {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 18px;
        margin-bottom: 28px;
        background: #e8f5e9;
        border: 1px solid #a5d6a7;
        border-radius: 0;
        font-size: 15px;
        font-weight: 600;
        color: #2e7d32;
    }

    /* ===== BOTÓN AGREGAR ===== */
    .btn-agregar { 
        display: inline-flex; 
        align-items: center; 
        gap: 10px; 
        padding: 11px 20px; 
        background: var(--primario); 
        color: #fff; 
        border-radius: 0; 
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
        height: 44px; 
        padding: 0 44px 0 46px;
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 0; 
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
        height: 44px; 
        display: inline-flex; 
        align-items: center; 
        gap: 10px; 
        padding: 0 20px; 
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 0; 
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
        border-radius: 0; 
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
        border-radius: 0; 
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

    /* ===== BOTÓN LIMPIAR BÚSQUEDA ===== */
    .btn-limpiar { 
        display: none; 
        position: absolute; 
        right: 8px; 
        top: 50%; 
        transform: translateY(-50%); 
        width: 28px; 
        height: 28px; 
        align-items: center; 
        justify-content: center; 
        background: none; 
        border: none; 
        border-radius: 0; 
        color: #9ca3af; 
        cursor: pointer; 
        transition: color 0.2s ease, background 0.2s ease; 
    }
    .btn-limpiar:hover { 
        color: var(--primario); 
        background: var(--primario-suave); 
    }
    /* Anula el estilo de la lupa (.buscador i) para el icono de la X */
    .buscador .btn-limpiar i { 
        position: static; 
        transform: none; 
        font-size: 14px; 
        color: inherit; 
    }

    /* ===== TARJETA DE SERVICIO ===== */
    .servicios-grid { 
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        gap: 24px; 
        margin-bottom: 32px; 
    }
    .servicio-card { 
        display: block; 
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 0; 
        overflow: hidden; 
        text-decoration: none; 
        color: inherit; 
        cursor: pointer; 
        transition: border-color 0.2s ease, box-shadow 0.2s ease; 
    }
    .servicio-card:hover { 
        border-color: #c4b5fd; 
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07); 
    }
    .servicio-imagen { 
        width: 100%; 
        height: 220px; 
        background: #f3f4f6; 
    }
    .servicio-imagen img { 
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
    .servicio-contenido { 
        padding: 22px 26px 24px; 
    }
    .servicio-fila { 
        display: flex; 
        justify-content: space-between; 
        align-items: baseline; 
        gap: 12px; 
    }
    .servicio-nombre { 
        margin: 0; 
        font-size: 18px; 
        font-weight: 600; 
        color: var(--texto); 
    }
    .servicio-precio { 
        font-size: 18px; 
        font-weight: 600; 
        color: var(--texto); 
        white-space: nowrap; 
    }
    .servicio-descripcion { 
        margin: 8px 0 0; 
        min-height: 42px;
        font-size: 14px; 
        line-height: 1.5; 
        color: var(--texto-suave); 
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .servicio-cantidad { 
        margin: 6px 0 0; 
        font-size: 15px; 
        color: var(--texto-suave); 
    }
    .servicio-pie { 
        display: flex; 
        justify-content: flex-end; 
        margin-top: 22px; 
        padding-top: 18px; 
        border-top: 1px solid #f0f0f3; 
    }
    .btn-editar { 
        padding: 6px 18px;
        border: 1px solid #ddd6fe; 
        border-radius: 0; 
        font-size: 15px; 
        font-weight: 500; 
        color: var(--primario); 
        transition: background 0.2s ease; 
    }
    .servicio-card:hover .btn-editar { 
        background: var(--primario-suave); 
    }

    /* ===== SIN RESULTADOS ===== */
    .sin-resultados { 
        grid-column: 1 / -1; 
        padding: 48px 20px; 
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 0; 
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
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        gap: 16px; 
        padding: 10px 28px;
        background: #fff; 
        border: 1px solid var(--borde); 
        border-radius: 0;
        font-size: 15px; 
        color: var(--texto-suave); 
    }

    /* ===== PAGINACIÓN ===== */
    .paginacion { 
        display: flex; 
        align-items: center; 
        gap: 20px; 
    }
    .paginacion-enlace { 
        font-size: 15px; 
        color: #9ca3af; 
        text-decoration: none; 
        cursor: pointer; 
        transition: color 0.2s ease; 
    }
    .paginacion-enlace:hover { 
        color: var(--primario); 
    }
    .paginacion-actual { 
        min-width: 34px; 
        padding: 4px 10px; 
        background: var(--primario); 
        color: #fff; 
        font-size: 15px; 
        font-weight: 500; 
        text-align: center; 
        border-radius: 0;
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
        border-radius: 0; 
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
        padding: 10px;
        border: none; 
        border-radius: 0; 
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
        .servicios-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 650px) {
        .pagina-servicios { padding: 28px 0 40px; }
        .pagina-encabezado { flex-direction: column; align-items: stretch; }
        .pagina-encabezado h1 { font-size: 26px; }
        .btn-agregar { justify-content: center; }
        .barra-herramientas { flex-direction: column; }
        .boton-filtro { width: 100%; justify-content: center; }
        .menu-filtro { width: 100%; left: 0; right: auto; }
        .servicios-grid { grid-template-columns: 1fr; }
        .modal-botones { flex-direction: column; }
    }
</style>
@endpush

<div class="pagina-servicios">

    <!-- =========================
         ENCABEZADO Y BOTÓN AGREGAR
    ========================= -->
    <div class="pagina-encabezado">
        <div>
            <h1>Inventario de Servicios</h1>
            <p>Consulta y administra los servicios registrados.</p>
        </div>
        <a href="{{ route('admin.agregar_servicio') }}" class="btn-agregar">
            <i class="fa-solid fa-plus"></i>
            Agregar Servicio
        </a>
    </div>

    <!-- =========================
         MENSAJE DE ÉXITO
    ========================= -->
    @if(session('success'))
        <div class="mensaje-exito">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- =========================
         BUSCADOR Y FILTRO DE ORDEN
    ========================= -->
    <div class="barra-herramientas">
        <div class="buscador">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="buscadorServicios" placeholder="Buscar servicio por nombre..." autocomplete="off">
            <button type="button" class="btn-limpiar" id="btnLimpiar" aria-label="Limpiar búsqueda">
                <i class="fa-solid fa-xmark"></i>
            </button>
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
         LISTA DE SERVICIOS
    ========================= -->
    <div class="servicios-grid" id="listaServicios">
        @forelse($servicios as $servicio)
            <!-- TARJETA DE SERVICIO (abre la edición) -->
            <a href="{{ route('admin.inventario.editar', $servicio->id) }}" class="servicio-card" data-nombre="{{ $servicio->nombre }}">

                <!-- Foto -->
                <div class="servicio-imagen">
                    @if($servicio->foto)
                        <img src="{{ asset('storage/' . $servicio->foto) }}" alt="{{ $servicio->nombre }}" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
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
                <div class="servicio-contenido">
                    <div class="servicio-fila">
                        <h2 class="servicio-nombre">{{ $servicio->nombre }}</h2>
                        <span class="servicio-precio">$ {{ number_format($servicio->precio, 2) }}</span>
                    </div>
                    <p class="servicio-descripcion">
                        {{ $servicio->descripcion ?: 'Sin descripción disponible.' }}
                    </p>
                    <p class="servicio-cantidad">Cantidad: {{ $servicio->cantidad }}</p>
                    <div class="servicio-pie">
                        <span class="btn-editar">Editar</span>
                    </div>
                </div>

            </a>

        @empty

            <!-- SIN SERVICIOS REGISTRADOS -->
            <div class="sin-resultados" id="sinServicios">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                <h3>No existen servicios registrados</h3>
                <p>Agrega un servicio para comenzar a llenar el inventario.</p>
            </div>

        @endforelse

        <!-- SIN RESULTADOS DE BÚSQUEDA -->
        <div class="sin-resultados" id="sinResultados" style="display: none;">
            <i class="fa-solid fa-magnifying-glass"></i>
            <h3>No se encontraron servicios</h3>
            <p>Intenta buscar utilizando otro nombre.</p>
        </div>

    </div>

    <!-- =========================
         PIE DE LA LISTA (TOTAL)
    ========================= -->
    @if($servicios->count() > 0)
        <div class="pie-lista">
            <span id="contadorServicios">{{ $servicios->count() }} {{ $servicios->count() == 1 ? 'servicio' : 'servicios' }} en total</span>

            <div class="paginacion">
                <a class="paginacion-enlace">Anterior</a>
                <span class="paginacion-actual">1</span>
                <a class="paginacion-enlace">Siguiente</a>
            </div>
        </div>
    @endif

</div>

<!-- =========================
     MODAL ELIMINAR SERVICIO
========================= -->
<div id="modalEliminar" class="modal">
    <div class="modal-contenido">
        <div class="modal-icono">
            <i class="fa-solid fa-trash"></i>
        </div>
        <h2>Eliminar servicio</h2>
        <p id="mensajeEliminar">¿Estás seguro de que deseas eliminar este servicio?</p>
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
    const buscador = document.getElementById('buscadorServicios');
    const listaServicios = document.getElementById('listaServicios');
    const sinResultados = document.getElementById('sinResultados');
    const botonFiltro = document.getElementById('botonFiltro');
    const menuFiltro = document.getElementById('menuFiltro');
    const contador = document.getElementById('contadorServicios');
    const totalServicios = listaServicios.querySelectorAll('.servicio-card').length;
    const btnLimpiar = document.getElementById('btnLimpiar');

    /* ===== UTILIDADES ===== */
    // Minúsculas y sin acentos: "Poda" coincide con "poda", "Instalación" con "instalacion"
    function normalizar(texto) {
        return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
    }

    function actualizarContador(visibles) {
        if (!contador) return;
        contador.textContent = visibles === totalServicios
            ? totalServicios + (totalServicios === 1 ? ' servicio' : ' servicios') + ' en total'
            : visibles + ' de ' + totalServicios + ' servicios';
    }

    /* ===== BUSCADOR ===== */
    function filtrarServicios() {
        btnLimpiar.style.display = buscador.value ? 'flex' : 'none';
        const texto = normalizar(buscador.value);
        let encontrados = 0;
        listaServicios.querySelectorAll('.servicio-card').forEach(function (servicio) {
            const coincide = normalizar(servicio.dataset.nombre).includes(texto);
            servicio.style.display = coincide ? '' : 'none';
            if (coincide) encontrados++;
        });
        sinResultados.style.display = (encontrados === 0 && totalServicios > 0) ? 'block' : 'none';
        actualizarContador(encontrados);
    }

    if (buscador) buscador.addEventListener('input', filtrarServicios);

    btnLimpiar.addEventListener('click', function () {
        buscador.value = '';
        filtrarServicios();
        buscador.focus();
    });

    /* ===== ORDENAR ===== */
    function ordenarServicios(tipo) {
        const servicios = Array.from(listaServicios.querySelectorAll('.servicio-card'));
        servicios.sort(function (a, b) {
            const orden = a.dataset.nombre.localeCompare(b.dataset.nombre, 'es', { sensitivity: 'base' });
            return tipo === 'asc' ? orden : -orden;
        });
        servicios.forEach(function (servicio) { listaServicios.appendChild(servicio); });
        filtrarServicios();
    }

    document.getElementById('ordenAscendente').addEventListener('click', function () {
        ordenarServicios('asc');
        menuFiltro.classList.remove('activo');
    });

    document.getElementById('ordenDescendente').addEventListener('click', function () {
        ordenarServicios('desc');
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
            '¿Estás seguro de que deseas eliminar el servicio <strong>' + escapeHtml(nombre) + '</strong>?';
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

    // Evita inyección de HTML en el nombre del servicio
    function escapeHtml(texto) {
        const div = document.createElement('div');
        div.textContent = texto;
        return div.innerHTML;
    }
</script>
@endpush
</x-layouts.panel>