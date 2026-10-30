<x-layouts.panel
    titulo="Inventario"
    :regresar="route('admin.dashboard')"
    :migas="[
        ['texto' => 'Inventario', 'url' => route('admin.inventario')],
    ]"
>

@push('estilos')
<style>
    .pagina-inv {
        padding: 48px 0 56px;
    }

    /* ===== ENCABEZADO ===== */
    .inv-encabezado {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        padding-bottom: 24px;
        margin-bottom: 28px;
        border-bottom: 1px solid var(--borde);
    }
    .inv-encabezado h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--texto);
    }
    .inv-titulo-fila {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 6px;
    }
    .inv-encabezado p {
        margin: 0;
        font-size: 15px;
        color: var(--texto-suave);
    }
    .inv-acciones {
        display: flex;
        gap: 12px;
    }
    .btn-exportar,
    .btn-registrar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        height: 44px;
        padding: 0 20px;
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        font-weight: 600;
        white-space: nowrap;
        cursor: pointer;
        transition: background 0.2s ease, border-color 0.2s ease;
        text-decoration: none; 
    }
    .btn-exportar {
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--texto);
    }
    .btn-exportar:hover {
        border-color: #c4b5fd;
        background: #fcfbff;
    }
    .btn-registrar {
        background: var(--primario);
        border: 1px solid var(--primario);
        color: #fff;
    }
    .btn-registrar:hover {
        background: var(--primario-oscuro);
        border-color: var(--primario-oscuro);
    }
    .btn-registrar .fa-chevron-down {
        font-size: 11px;
    }

    /* ===== MENÚ REGISTRAR NUEVO ===== */
    .desplegable {
        position: relative;
    }
    .menu-desplegable {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        width: 210px;
        padding: 6px;
        background: #fff;
        border: 1px solid var(--borde);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        z-index: 100;
    }
    .menu-desplegable.activo { display: block; }
    .menu-desplegable a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        font-size: 14px;
        color: var(--texto);
        text-decoration: none;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .menu-desplegable a:hover {
        background: var(--primario-suave);
        color: var(--primario);
    }
    .menu-desplegable a i {
        width: 16px;
        text-align: center;
    }

    /* ===== MENSAJE DE ÉXITO ===== */
    .mensaje-exito {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        padding: 14px 18px;
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #15803d;
        font-size: 14px;
        font-weight: 600;
    }

    /* ===== BARRA DE HERRAMIENTAS ===== */
    .inv-herramientas {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }
    .tabs {
        display: inline-flex;
        gap: 4px;
        padding: 4px;
        background: #f1f2f6;
        border: 1px solid var(--borde);
    }
    .tab {
        height: 36px;
        padding: 0 18px;
        background: transparent;
        border: none;
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        font-weight: 500;
        color: var(--texto-suave);
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .tab:hover { color: var(--primario); }
    .tab.activo {
        background: #fff;
        color: var(--primario);
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
    }

    .inv-controles {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .buscador {
        position: relative;
        width: 280px;
    }
    .buscador > i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 13px;
        pointer-events: none;
    }
    .buscador input {
        width: 100%;
        height: 44px;
        padding: 0 40px 0 38px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        color: var(--texto);
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .buscador input::placeholder { color: #9ca3af; }
    .buscador input:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .btn-limpiar {
        display: none;
        position: absolute;
        right: 6px;
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
        font-size: 13px;
        cursor: pointer;
        transition: color 0.2s ease, background 0.2s ease;
    }
    .btn-limpiar:hover {
        color: var(--primario);
        background: var(--primario-suave);
    }

    .selector {
        position: relative;
    }
    .selector select {
        height: 44px;
        min-width: 220px;
        padding: 0 38px 0 16px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        appearance: none;
        -webkit-appearance: none;
        font-family: inherit;
        font-size: 14px;
        color: var(--texto);
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .selector select:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .selector i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 11px;
        color: var(--texto-suave);
        pointer-events: none;
    }

    .vistas {
        display: inline-flex;
        height: 44px;
        background: #fff;
        border: 1px solid var(--borde);
    }
    .vista-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0 16px;
        background: transparent;
        border: none;
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        font-weight: 500;
        color: var(--texto-suave);
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .vista-btn:hover { color: var(--primario); }
    .vista-btn.activo {
        background: var(--primario-suave);
        color: var(--primario);
        font-weight: 600;
    }

    .contador-registros {
        font-size: 14px;
        color: var(--texto-suave);
        white-space: nowrap;
    }
    .contador-registros strong {
        color: var(--texto);
        font-weight: 700;
    }

    /* ===== CUADRÍCULA DE TARJETAS ===== */
    .inv-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .inv-card {
        display: flex;
        flex-direction: column;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        overflow: hidden;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .inv-card:hover {
        border-color: #c4b5fd;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.07);
    }

    .inv-imagen {
        position: relative;
        flex-shrink: 0;
        height: 260px;
        background: #f3f4f6;
    }
    .inv-imagen img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .inv-centro {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #9ca3af;
        font-size: 13px;
    }
    .inv-centro .icono-bien {
        font-size: 38px;
        color: #c4b5fd;
    }
    .inv-centro .icono-servicio {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid #ddd6fe;
        font-size: 20px;
        color: var(--primario);
    }

    .badge-tipo {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 9px;
        background: #fff;
        border: 1px solid var(--borde);
        font-size: 12px;
        font-weight: 600;
        color: var(--texto-suave);
    }
    .badge-tipo::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #9ca3af;
    }
    .badge-tipo.servicio {
        background: var(--primario-suave);
        border-color: #ddd6fe;
        color: var(--primario);
    }
    .badge-tipo.servicio::before { background: var(--primario); }

    .inv-cuerpo {
        flex: 1;
        display: flex;
        flex-direction: column;
        padding: 18px 20px 20px;
        min-width: 0;
    }
    .inv-nombre {
        margin: 0 0 6px;
        font-size: 15px;
        font-weight: 600;
        color: var(--texto);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .inv-descripcion {
        margin: 0;
        font-size: 13px;
        color: var(--texto-suave);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .inv-pie {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 12px;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #f0f0f3;
    }
    .inv-card .inv-descripcion {
        margin-bottom: 16px;
    }
    .inv-etiqueta {
        display: block;
        margin-bottom: 2px;
        font-size: 11px;
        color: #9ca3af;
    }
    .inv-precio {
        font-size: 17px;
        font-weight: 700;
        color: var(--texto);
    }
    .inv-precio small {
        font-size: 12px;
        font-weight: 400;
        color: var(--texto-suave);
    }
    .btn-editar {
        padding: 6px 16px;
        background: var(--primario-suave);
        border: 1px solid #ddd6fe;
        border-radius: 0;
        font-size: 13px;
        font-weight: 500;
        color: var(--primario);
        text-decoration: none;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .btn-editar:hover {
        background: var(--primario);
        border-color: var(--primario);
        color: #fff;
    }

    /* ===== VISTA EN LISTA ===== */
    .inv-grid.lista {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .inv-grid.lista .inv-card {
        flex-direction: row;
    }
    .inv-grid.lista .inv-imagen {
        width: 200px;
        height: auto;
        min-height: 130px;
    }
    .inv-grid.lista .inv-cuerpo {
        justify-content: center;
    }

    /* ===== SIN RESULTADOS ===== */
    .sin-resultados {
        display: none;
        padding: 56px 20px;
        background: #fff;
        border: 1px solid var(--borde);
        text-align: center;
        color: var(--texto-suave);
    }
    .sin-resultados.visible { display: block; }
    .sin-resultados i {
        margin-bottom: 12px;
        font-size: 36px;
        color: #c4b5fd;
    }
    .sin-resultados h3 {
        margin: 4px 0;
        font-size: 17px;
        color: var(--texto);
    }
    .sin-resultados p {
        margin: 0;
        font-size: 14px;
    }

    /* ===== PIE Y PAGINACIÓN ===== */
    .inv-pie-lista {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-top: 32px;
        padding-top: 22px;
        border-top: 1px solid var(--borde);
        font-size: 13px;
        color: var(--texto-suave);
    }
    .inv-pie-lista strong {
        color: var(--texto);
        font-weight: 600;
    }
    .paginacion {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .pag-btn {
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        border-radius: 0;
        font-family: inherit;
        font-size: 12px;
        color: #c9ccd3;
        cursor: default;
    }
    .pag-btn.actual {
        background: var(--primario);
        color: #fff;
        font-weight: 600;
    }

    /* ===== RESPONSIVO ===== */
    @media (max-width: 1100px) {
        .inv-herramientas { flex-direction: column; align-items: stretch; }
        .inv-controles { flex-wrap: wrap; }
        .buscador { flex: 1; min-width: 220px; }
    }
    @media (max-width: 950px) {
        .inv-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 650px) {
        .pagina-inv { padding: 28px 0 40px; }
        .inv-encabezado { flex-direction: column; align-items: stretch; }
        .inv-encabezado h1 { font-size: 26px; }
        .inv-acciones { flex-direction: column; }
        .btn-exportar, .btn-registrar { width: 100%; }
        .menu-desplegable { width: 100%; }
        .tabs { display: flex; }
        .tab { flex: 1; padding: 0 8px; }
        .inv-controles { flex-direction: column; align-items: stretch; }
        .buscador { width: 100%; }
        .selector select { width: 100%; }
        .vistas { width: 100%; }
        .vista-btn { flex: 1; justify-content: center; }
        .inv-grid { grid-template-columns: 1fr; }
        .inv-grid.lista .inv-card { flex-direction: column; }
        .inv-grid.lista .inv-imagen { width: 100%; height: 200px; }
        .inv-pie-lista { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush
<x-sidebar activo="inventario" :total-inventario="$inventarios->count()" />
<div class="pagina-inv">

    <!-- =========================
         ENCABEZADO Y ACCIONES
    ========================= -->
    <div class="inv-encabezado">
        <div>
            <div class="inv-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Inventario</h1>
            </div>
            <p>Consulta y gestión centralizada de activos, insumos y servicios de la empresa.</p>
        </div>

        <div class="inv-acciones">
            <button type="button" class="btn-exportar">
                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                Exportar
            </button>

            <div class="desplegable">
                <button type="button" class="btn-registrar" id="btnRegistrar">
                    <i class="fa-solid fa-plus"></i>
                    Registrar Nuevo
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="menu-desplegable" id="menuRegistrar">
                    <a href="{{ route('admin.agregar_bien') }}">
                        <i class="fa-solid fa-box"></i>
                        Bien
                    </a>
                    <a href="{{ \Illuminate\Support\Facades\Route::has('admin.agregar_servicio') ? route('admin.agregar_servicio') : route('admin.servicios') }}">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        Servicio
                    </a>
                </div>
            </div>
            <a href="#" class="btn-registrar" id="btnAgregarDirecto" style="display: none;">
                <i class="fa-solid fa-plus"></i>
                <span id="textoAgregar">Agregar Bien</span>
            </a>
        </div>
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
         PESTAÑAS Y CONTROLES
    ========================= -->
    <div class="inv-herramientas">

        <div class="tabs">
            <button type="button" class="tab activo" data-tipo="todos">Todos</button>
            <button type="button" class="tab" data-tipo="bien">Bienes</button>
            <button type="button" class="tab" data-tipo="servicio">Servicios</button>
        </div>

        <div class="inv-controles">

            <div class="buscador">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorInventario" placeholder="Buscar por nombre..." autocomplete="off">
                <button type="button" class="btn-limpiar" id="btnLimpiar" aria-label="Limpiar búsqueda">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="selector">
                <select id="ordenInventario">
                    <option value="az">Orden: Nombre (A – Z)</option>
                    <option value="za">Orden: Nombre (Z – A)</option>
                    <option value="precio-asc">Orden: Precio (menor a mayor)</option>
                    <option value="precio-desc">Orden: Precio (mayor a menor)</option>
                </select>
                <i class="fa-solid fa-chevron-down"></i>
            </div>

            <div class="vistas">
                <button type="button" class="vista-btn activo" data-vista="cuadricula">
                    <i class="fa-solid fa-table-cells-large"></i>
                    Cuadrícula
                </button>
                <button type="button" class="vista-btn" data-vista="lista">
                    <i class="fa-solid fa-list"></i>
                    Lista
                </button>
            </div>

            <span class="contador-registros" id="contadorRegistros"><strong>{{ $inventarios->count() }}</strong> registros</span>

        </div>
    </div>

    <!-- =========================
         LISTA DE INVENTARIO
    ========================= -->
    @if($inventarios->count() > 0)

        <div class="inv-grid" id="listaInventario">
            @foreach($inventarios as $inventario)
                <article
                    class="inv-card"
                    data-nombre="{{ $inventario->nombre }}"
                    data-tipo="{{ $inventario->tipo }}"
                    data-precio="{{ $inventario->precio }}"
                >

                    <!-- Imagen -->
                    <div class="inv-imagen">
                        <span class="badge-tipo {{ $inventario->tipo === 'servicio' ? 'servicio' : '' }}">
                            {{ $inventario->tipo === 'servicio' ? 'Servicio' : 'Bien' }}
                        </span>

                        @if($inventario->foto)
                            <img
                                src="{{ asset('storage/' . $inventario->foto) }}"
                                alt=""
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >
                            <div class="inv-centro" style="display: none;">
                                @if($inventario->tipo === 'servicio')
                                    <span class="icono-servicio"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                                @else
                                    <i class="fa-regular fa-image icono-bien"></i>
                                    <span>Sin imagen</span>
                                @endif
                            </div>
                        @else
                            <div class="inv-centro">
                                @if($inventario->tipo === 'servicio')
                                    <span class="icono-servicio"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                                @else
                                    <i class="fa-regular fa-image icono-bien"></i>
                                    <span>Sin imagen</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Información -->
                    <div class="inv-cuerpo">
                        <h3 class="inv-nombre" title="{{ $inventario->nombre }}">{{ $inventario->nombre }}</h3>
                        <p class="inv-descripcion">{{ $inventario->descripcion ?: 'Sin descripción' }}</p>

                        <div class="inv-pie">
                            <div>
                                <span class="inv-etiqueta">{{ $inventario->tipo === 'servicio' ? 'Tarifa' : 'Valor unitario' }}</span>
                                <span class="inv-precio">$ {{ number_format($inventario->precio, 2) }}</span>
                            </div>
                            <a href="{{ route('admin.inventario.editar', $inventario->id) }}" class="btn-editar">Editar</a>
                        </div>
                    </div>

                </article>
            @endforeach
        </div>

        <!-- SIN RESULTADOS DE BÚSQUEDA -->
        <div class="sin-resultados" id="sinResultados">
            <i class="fa-solid fa-box-open"></i>
            <h3>No se encontraron resultados</h3>
            <p>Intenta cambiar el filtro o realizar otra búsqueda.</p>
        </div>

        <!-- PIE Y PAGINACIÓN -->
        <div class="inv-pie-lista">
            <span id="textoMostrando">Mostrando <strong>1 – {{ $inventarios->count() }}</strong> de <strong>{{ $inventarios->count() }}</strong> elementos registrados</span>

            <div class="paginacion">
                <span class="pag-btn"><i class="fa-solid fa-chevron-left"></i></span>
                <span class="pag-btn actual">1</span>
                <span class="pag-btn"><i class="fa-solid fa-chevron-right"></i></span>
            </div>
        </div>

    @else

        <!-- SIN REGISTROS -->
        <div class="sin-resultados visible">
            <i class="fa-solid fa-box-open"></i>
            <h3>No hay registros en el inventario</h3>
            <p>Agrega un bien o servicio para que aparezca aquí.</p>
        </div>

    @endif

</div>

@push('scripts')
<script>
    const lista = document.getElementById('listaInventario');

    /* ===== MENÚ REGISTRAR NUEVO ===== */
    const btnRegistrar = document.getElementById('btnRegistrar');
    const menuRegistrar = document.getElementById('menuRegistrar');

    btnRegistrar.addEventListener('click', function (event) {
        event.stopPropagation();
        menuRegistrar.classList.toggle('activo');
    });
    document.addEventListener('click', function (event) {
        if (!event.target.closest('.desplegable')) menuRegistrar.classList.remove('activo');
    });

    /* ===== FILTROS, BÚSQUEDA, ORDEN Y VISTA ===== */
    if (lista) {
        const buscador = document.getElementById('buscadorInventario');
        const btnLimpiar = document.getElementById('btnLimpiar');
        const orden = document.getElementById('ordenInventario');
        const tabs = document.querySelectorAll('.tab');
        const botonesVista = document.querySelectorAll('.vista-btn');
        const sinResultados = document.getElementById('sinResultados');
        const contador = document.getElementById('contadorRegistros');
        const textoMostrando = document.getElementById('textoMostrando');
        const total = lista.querySelectorAll('.inv-card').length;
        const desplegable = document.querySelector('.desplegable');
        const btnAgregarDirecto = document.getElementById('btnAgregarDirecto');
        const textoAgregar = document.getElementById('textoAgregar');
        const enlacesRegistrar = menuRegistrar.querySelectorAll('a');
        const migasPanel = document.getElementById('migasPanel');
        const nombresTipo = { bien: 'Bienes', servicio: 'Servicios' };

        let tipoActual = 'todos';

        function normalizar(texto) {
            return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
        }

        function actualizarBotonAgregar() {
            if (tipoActual === 'todos') {
                desplegable.style.display = '';
                btnAgregarDirecto.style.display = 'none';
                return;
            }

            const esBien = tipoActual === 'bien';
            desplegable.style.display = 'none';
            menuRegistrar.classList.remove('activo');
            btnAgregarDirecto.style.display = '';
            btnAgregarDirecto.href = enlacesRegistrar[esBien ? 0 : 1].href;
            textoAgregar.textContent = esBien ? 'Agregar Bien' : 'Agregar Servicio';
        }

        function actualizarMigas() {
            if (!migasPanel) return;
            migasPanel.innerHTML = '';

            if (!nombresTipo[tipoActual]) {
                migasPanel.innerHTML = '<span class="miga-actual">Inventario</span>';
                return;
            }

            const enlace = document.createElement('a');
            enlace.href = '{{ route('admin.inventario') }}';
            enlace.textContent = 'Inventario';
            enlace.addEventListener('click', function (evento) {
                evento.preventDefault();
                document.querySelector('.tab[data-tipo="todos"]').click();
            });

            const separador = document.createElement('i');
            separador.className = 'fa-solid fa-chevron-right migas-sep';

            const actual = document.createElement('span');
            actual.className = 'miga-actual';
            actual.textContent = nombresTipo[tipoActual];

            migasPanel.append(enlace, separador, actual);
        }

        function aplicar() {
            const texto = normalizar(buscador.value);
            btnLimpiar.style.display = buscador.value ? 'flex' : 'none';

            const tarjetas = Array.from(lista.querySelectorAll('.inv-card'));
            tarjetas.sort(function (a, b) {
                switch (orden.value) {
                    case 'za':
                        return b.dataset.nombre.localeCompare(a.dataset.nombre, 'es', { sensitivity: 'base' });
                    case 'precio-asc':
                        return parseFloat(a.dataset.precio) - parseFloat(b.dataset.precio);
                    case 'precio-desc':
                        return parseFloat(b.dataset.precio) - parseFloat(a.dataset.precio);
                    default:
                        return a.dataset.nombre.localeCompare(b.dataset.nombre, 'es', { sensitivity: 'base' });
                }
            });

            let visibles = 0;
            tarjetas.forEach(function (tarjeta) {
                lista.appendChild(tarjeta);
                const coincideTipo = tipoActual === 'todos' || tarjeta.dataset.tipo === tipoActual;
                const coincideTexto = normalizar(tarjeta.dataset.nombre).includes(texto);
                const mostrar = coincideTipo && coincideTexto;
                tarjeta.style.display = mostrar ? '' : 'none';
                if (mostrar) visibles++;
            });

            sinResultados.classList.toggle('visible', visibles === 0);
            contador.innerHTML = '<strong>' + visibles + '</strong> ' + (visibles === 1 ? 'registro' : 'registros');
            textoMostrando.innerHTML = visibles === 0
                ? 'Mostrando <strong>0</strong> de <strong>' + total + '</strong> elementos registrados'
                : 'Mostrando <strong>1 – ' + visibles + '</strong> de <strong>' + total + '</strong> elementos registrados';
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('activo'); });
                this.classList.add('activo');
                tipoActual = this.dataset.tipo;
                actualizarMigas();
                actualizarBotonAgregar();
                aplicar();
            });
        });

        botonesVista.forEach(function (boton) {
            boton.addEventListener('click', function () {
                botonesVista.forEach(function (b) { b.classList.remove('activo'); });
                this.classList.add('activo');
                lista.classList.toggle('lista', this.dataset.vista === 'lista');
            });
        });

        buscador.addEventListener('input', aplicar);
        orden.addEventListener('change', aplicar);

        btnLimpiar.addEventListener('click', function () {
            buscador.value = '';
            aplicar();
            buscador.focus();
        });

        const tipoUrl = new URLSearchParams(window.location.search).get('tipo');
        const tabInicial = document.querySelector('.tab[data-tipo="' + tipoUrl + '"]');

        if (tabInicial) {
            tabInicial.click();
        } else {
            aplicar();
        }
    }
</script>
@endpush

</x-layouts.panel>