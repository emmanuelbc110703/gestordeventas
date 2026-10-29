@props([
    'activo' => '',
    'totalInventario' => null,
    'pedidosPendientes' => null,
])

@php
    $usuario = auth()->user();
    $nombreCompleto = $usuario ? trim($usuario->name . ' ' . ($usuario->apellido ?? '')) : '';
    $iniciales = $usuario
        ? mb_strtoupper(mb_substr($usuario->name, 0, 1) . mb_substr($usuario->apellido ?? '', 0, 1))
        : '';

    $administracion = [
        ['clave' => 'dashboard',      'texto' => 'Menú Principal',       'icono' => 'fa-table-cells-large', 'url' => route('admin.dashboard')],
        ['clave' => 'inventario',     'texto' => 'Inventario',           'icono' => 'fa-boxes-stacked',     'url' => route('admin.inventario'), 'badge' => $totalInventario],
        ['clave' => 'puntos_venta',   'texto' => 'Puntos de venta',      'icono' => 'fa-store',             'url' => route('admin.puntos_venta')],
        ['clave' => 'empleados',      'texto' => 'Empleados',            'icono' => 'fa-id-badge',          'url' => route('admin.empleados')],
        ['clave' => 'clientes',       'texto' => 'Clientes',             'icono' => 'fa-user-group',        'url' => route('admin.clientes')],
        ['clave' => 'pedidos',        'texto' => 'Pedidos',              'icono' => 'fa-file-lines',        'url' => route('admin.cotizaciones'), 'badge' => $pedidosPendientes],
        ['clave' => 'gastos',         'texto' => 'Gastos comerciales',   'icono' => 'fa-wallet',            'url' => route('admin.gastos_comerciales')],
        ['clave' => 'cuenta',         'texto' => 'Cuenta del negocio',   'icono' => 'fa-building-columns',  'url' => '#'],
        ['clave' => 'pagos',          'texto' => 'Pago de servicios',    'icono' => 'fa-file-invoice',      'url' => route('admin.pago_servicios.index')],
    ];

    $miCuenta = [
        ['clave' => 'informacion',    'texto' => 'Mi información',       'icono' => 'fa-circle-user',       'url' => route('admin.informacion')],
        ['clave' => 'configuracion',  'texto' => 'Configuración',        'icono' => 'fa-gear',              'url' => '#'],
    ];

    // Solo aparece si el usuario tiene un punto de venta asignado
    if ($usuario && $usuario->puntoVenta) {
        $miCuenta[] = ['clave' => 'punto_venta', 'texto' => 'Punto de venta', 'icono' => 'fa-cash-register', 'url' => route('empleado.punto_venta')];
    }

    $secciones = [
        'Administración' => $administracion,
        'Mi cuenta'      => $miCuenta,
    ];
@endphp

@push('estilos')
<style>
    :root { --ancho-sidebar: 260px; }

    /* ===== ESTADO ABIERTO / OCULTO ===== */
    body.con-sidebar { padding-left: var(--ancho-sidebar); }
    body.sb-listo { transition: padding-left 0.25s ease; }

    .sidebar-app {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: var(--ancho-sidebar);
        display: flex;
        flex-direction: column;
        background: #fff;
        border-right: 1px solid var(--borde);
        z-index: 600;
        transform: translateX(-100%);
        visibility: hidden;
    }
    body.sb-listo .sidebar-app {
        transition: transform 0.25s ease, visibility 0s linear 0.25s;
    }
    body.con-sidebar .sidebar-app {
        transform: none;
        visibility: visible;
    }
    body.sb-listo.con-sidebar .sidebar-app {
        transition: transform 0.25s ease, visibility 0s;
    }

    /* ===== CABECERA ===== */
    .sb-cabecera {
        height: 64px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 0 16px 0 18px;
        border-bottom: 1px solid var(--borde);
    }
    .sb-marca {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }
    .sb-logo {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primario);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
    }
    .sb-marca-texto {
        display: flex;
        flex-direction: column;
        line-height: 1.25;
        min-width: 0;
    }
    .sb-marca-texto strong {
        font-size: 14px;
        font-weight: 700;
        color: var(--texto);
        white-space: nowrap;
    }
    .sb-marca-texto small {
        font-size: 12px;
        color: var(--texto-suave);
        white-space: nowrap;
    }
    .sb-cerrar {
        width: 28px;
        height: 28px;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        border-radius: 0;
        color: #9ca3af;
        font-size: 12px;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .sb-cerrar:hover {
        background: var(--primario-suave);
        color: var(--primario);
    }

    /* ===== BUSCADOR DE MÓDULOS ===== */
    .sb-buscador-caja {
        flex-shrink: 0;
        padding: 16px 16px 8px;
    }
    .sb-buscador {
        position: relative;
    }
    .sb-buscador > i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        color: #9ca3af;
        pointer-events: none;
    }
    .sb-buscador input {
        width: 100%;
        height: 36px;
        padding: 0 54px 0 34px;
        background: #f9fafb;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 13px;
        color: var(--texto);
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .sb-buscador input::placeholder { color: #9ca3af; }
    .sb-buscador input:focus {
        background: #fff;
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .sb-atajo {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        padding: 1px 6px;
        background: #eef0f4;
        border: 1px solid var(--borde);
        font-size: 11px;
        font-weight: 500;
        color: var(--texto-suave);
        pointer-events: none;
    }

    /* ===== NAVEGACIÓN ===== */
    .sb-nav {
        flex: 1;
        overflow-y: auto;
        padding-bottom: 12px;
    }
    .sb-titulo {
        margin: 18px 0 6px;
        padding: 0 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #9ca3af;
    }
    .sb-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 9px 20px 9px 17px;
        border-left: 3px solid transparent;
        font-size: 14px;
        color: #374151;
        text-decoration: none;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .sb-link i {
        width: 16px;
        text-align: center;
        font-size: 14px;
        color: #8b93a1;
        transition: color 0.2s ease;
    }
    .sb-link:hover {
        background: #f8f7fc;
        color: var(--primario);
    }
    .sb-link:hover i { color: var(--primario); }
    .sb-link.activo {
        background: var(--primario-suave);
        border-left-color: var(--primario);
        color: var(--primario);
        font-weight: 500;
    }
    .sb-link.activo i { color: var(--primario); }
    .sb-badge {
        margin-left: auto;
        padding: 1px 8px;
        background: #eef0f4;
        font-size: 11px;
        font-weight: 600;
        color: var(--texto-suave);
    }
    .sb-link.activo .sb-badge {
        background: #e4d9fb;
        color: var(--primario);
    }

    /* ===== PIE: USUARIO ===== */
    .sb-pie {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        border-top: 1px solid var(--borde);
    }
    .sb-avatar {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #e5e7eb;
        color: #374151;
        font-size: 12px;
        font-weight: 700;
    }
    .sb-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .sb-usuario {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        line-height: 1.3;
    }
    .sb-usuario strong {
        font-size: 13px;
        font-weight: 600;
        color: var(--texto);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sb-usuario small {
        font-size: 11px;
        color: var(--texto-suave);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .sb-pie form { margin: 0; }
    .sb-salir {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        border-radius: 0;
        color: #9ca3af;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .sb-salir:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    /* ===== BOTÓN HAMBURGUESA (solo visible con el menú oculto) ===== */
    .btn-menu-lateral {
        display: none;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        color: var(--texto);
        font-size: 16px;
        cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s ease, color 0.2s ease;
    }
    .btn-menu-lateral:hover {
        border-color: #c4b5fd;
        background: #fcfbff;
        color: var(--primario);
    }
    body:not(.con-sidebar) .btn-menu-lateral { display: inline-flex; }

    /* ===== FONDO OSCURO (solo móvil) ===== */
    .sb-fondo {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(17, 24, 39, 0.45);
        z-index: 550;
    }

    @media (max-width: 900px) {
        body.con-sidebar { padding-left: 0; }
        body.con-sidebar .sb-fondo { display: block; }
        body.con-sidebar .sidebar-app { box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25); }
    }
</style>
@endpush

<!-- Define el estado inicial antes de pintar, para evitar parpadeos -->
<script>
    (function () {
        var oculta = false;
        try { oculta = localStorage.getItem('sidebarOculta') === '1'; } catch (e) {}
        if (window.innerWidth > 900 && !oculta) document.body.classList.add('con-sidebar');
        window.addEventListener('load', function () {
            requestAnimationFrame(function () { document.body.classList.add('sb-listo'); });
        });
    })();
</script>

<aside class="sidebar-app" id="sidebarApp" aria-label="Menú lateral">
    <div class="sb-cabecera">
        <div class="sb-marca">
            <span class="sb-logo">LA</span>
            <span class="sb-marca-texto">
                <strong>Los Amates</strong>
                <small>Gestor de Ventas</small>
            </span>
        </div>
        <button type="button" class="sb-cerrar" id="sbCerrar" aria-label="Ocultar menú lateral" title="Ocultar menú">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
    </div>
    <div class="sb-buscador-caja">
        <div class="sb-buscador">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="sbBuscar" placeholder="Buscar módulo..." autocomplete="off">
            <span class="sb-atajo" id="sbAtajo">⌘K</span>
        </div>
    </div>
    <nav class="sb-nav">
        @foreach($secciones as $titulo => $items)
            <div class="sb-seccion">
                <p class="sb-titulo">{{ $titulo }}</p>

                @foreach($items as $item)
                    <a
                        href="{{ $item['url'] }}"
                        class="sb-link {{ $activo === $item['clave'] ? 'activo' : '' }}"
                        data-texto="{{ $item['texto'] }}"
                    >
                        <i class="fa-solid {{ $item['icono'] }}"></i>
                        <span>{{ $item['texto'] }}</span>
                        @if(!empty($item['badge']))
                            <span class="sb-badge">{{ $item['badge'] }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endforeach
    </nav>
    @if($usuario)
        <div class="sb-pie">
            <span class="sb-avatar">
                @if($usuario->foto_perfil)
                    <img
                        src="{{ asset('storage/' . $usuario->foto_perfil) }}"
                        alt=""
                        onerror="this.remove();"
                    >
                @endif
                <span class="sb-iniciales">{{ $iniciales }}</span>
            </span>

            <span class="sb-usuario">
                <strong>{{ $nombreCompleto }}</strong>
                <small>{{ $usuario->email }}</small>
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sb-salir" aria-label="Cerrar sesión" title="Cerrar sesión">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    @endif

</aside>

<div class="sb-fondo" id="sbFondo"></div>

@push('scripts')
<script>
    (function () {
        var cuerpo = document.body;
        var buscar = document.getElementById('sbBuscar');
        var atajo = document.getElementById('sbAtajo');

        function esMovil() { return window.innerWidth <= 900; }

        function guardar(valor) {
            try { localStorage.setItem('sidebarOculta', valor); } catch (e) {}
        }

        function abrir() {
            cuerpo.classList.add('con-sidebar');
            if (!esMovil()) guardar('0');
        }

        function ocultar() {
            cuerpo.classList.remove('con-sidebar');
            if (!esMovil()) guardar('1');
        }

        // Botón de la cabecera: ocultar
        document.getElementById('sbCerrar').addEventListener('click', ocultar);
        document.getElementById('sbFondo').addEventListener('click', ocultar);

        document.querySelectorAll('[data-abrir-sidebar]').forEach(function (boton) {
            boton.addEventListener('click', abrir);
        });

        window.addEventListener('resize', function () {
            if (esMovil()) {
                cuerpo.classList.remove('con-sidebar');
            } else {
                var oculta = false;
                try { oculta = localStorage.getItem('sidebarOculta') === '1'; } catch (e) {}
                if (!oculta) cuerpo.classList.add('con-sidebar');
            }
        });

        if (!/Mac|iPhone|iPad/.test(navigator.platform)) atajo.textContent = 'Ctrl K';

        document.addEventListener('keydown', function (evento) {
            if ((evento.ctrlKey || evento.metaKey) && evento.key.toLowerCase() === 'k') {
                evento.preventDefault();
                abrir();
                buscar.focus();
            }
            if (evento.key === 'Escape' && esMovil()) ocultar();
        });

        function normalizar(texto) {
            return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
        }

        buscar.addEventListener('input', function () {
            var consulta = normalizar(this.value);

            document.querySelectorAll('.sb-seccion').forEach(function (seccion) {
                var visibles = 0;

                seccion.querySelectorAll('.sb-link').forEach(function (enlace) {
                    var coincide = normalizar(enlace.dataset.texto).includes(consulta);
                    enlace.style.display = coincide ? '' : 'none';
                    if (coincide) visibles++;
                });

                seccion.style.display = visibles ? '' : 'none';
            });
        });
    })();
</script>
@endpush