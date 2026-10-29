@props([
    'activo' => '',
    'totalInventario' => null,
    'pedidosPendientes' => null,
])

@php
    $usuario = auth()->user();

    // Los módulos vienen de config/modulos.php (misma lista que usa el buscador del header)
    $secciones = [];
    foreach (config('modulos', []) as $titulo => $items) {
        $secciones[$titulo] = array_map(function ($item) use ($totalInventario, $pedidosPendientes) {
            $item['url'] = !empty($item['ruta']) ? route($item['ruta']) : '#';
            $item['badge'] = match ($item['clave']) {
                'inventario' => $totalInventario,
                'pedidos'    => $pedidosPendientes,
                default      => null,
            };
            return $item;
        }, $items);
    }

    // Solo aparece si el usuario tiene un punto de venta asignado
    if ($usuario && $usuario->puntoVenta) {
        $secciones['Mi cuenta'][] = [
            'clave' => 'punto_venta',
            'texto' => 'Punto de venta',
            'icono' => 'fa-cash-register',
            'url'   => route('empleado.punto_venta'),
            'badge' => null,
        ];
    }

    // Nombre del módulo actual (el que se muestra en grande arriba, como en ERPNext)
    $nombreModulo = 'Menú';
    foreach ($secciones as $items) {
        foreach ($items as $item) {
            if ($item['clave'] === $activo) {
                $nombreModulo = $item['texto'];
            }
        }
    }
@endphp

@push('estilos')
<style>
    :root {
        --ancho-sidebar: 260px;
        --alto-header: 64px;
    }

    /* ===== ESTADO ABIERTO / OCULTO ===== */
    /* Solo el contenido de la página se corre a la derecha; el header nunca cambia */
    body.con-sidebar .cuerpo-app { padding-left: var(--ancho-sidebar); }
    body.sb-listo .cuerpo-app { transition: padding-left 0.25s ease; }

    /* Con la barra abierta, el título grande vive en la barra: se oculta el de la página */
    body.con-sidebar .titulo-pagina { display: none; }

    /* La barra queda DEBAJO del header, sin tapar su espacio */
    .sidebar-app {
        position: fixed;
        top: var(--alto-header);
        left: 0;
        bottom: 0;
        width: var(--ancho-sidebar);
        display: flex;
        flex-direction: column;
        background: #fff;
        border-right: 1px solid var(--borde);
        z-index: 400;
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
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 22px 16px 16px 14px;
    }
    /* Mismo tamaño que el título grande de las páginas (h1) */
    .sb-titulo-modulo {
        margin: 0;
        min-width: 0;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.15;
        color: var(--texto);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        word-break: break-word;
    }

    /* Botón hamburguesa que al pasar el mouse se vuelve una flecha a la izquierda */
    .sb-cerrar {
        position: relative;
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        background: none;
        border: none;
        border-radius: 0;
        color: var(--texto-suave);
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .sb-cerrar i {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        transition: opacity 0.18s ease, transform 0.18s ease;
    }
    .sb-cerrar .ic-flecha {
        opacity: 0;
        transform: translateX(8px);
    }
    .sb-cerrar:hover,
    .sb-cerrar:focus-visible {
        background: var(--primario-suave);
        color: var(--primario);
        outline: none;
    }
    .sb-cerrar:hover .ic-barras,
    .sb-cerrar:focus-visible .ic-barras {
        opacity: 0;
        transform: translateX(-8px);
    }
    .sb-cerrar:hover .ic-flecha,
    .sb-cerrar:focus-visible .ic-flecha {
        opacity: 1;
        transform: none;
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
        top: var(--alto-header);
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(17, 24, 39, 0.45);
        z-index: 350;
    }

    @media (max-width: 900px) {
        body.con-sidebar .cuerpo-app { padding-left: 0; }
        body.con-sidebar .titulo-pagina { display: block; }
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

    <!-- Cabecera -->
    <div class="sb-cabecera">
        <button type="button" class="sb-cerrar" id="sbCerrar" aria-label="Ocultar menú lateral" title="Ocultar menú">
            <i class="fa-solid fa-bars ic-barras"></i>
            <i class="fa-solid fa-arrow-left ic-flecha"></i>
        </button>

        <h2 class="sb-titulo-modulo" title="{{ $nombreModulo }}">{{ $nombreModulo }}</h2>
    </div>

    <!-- Navegación -->
    <nav class="sb-nav">
        @foreach($secciones as $titulo => $items)
            <div class="sb-seccion">
                <p class="sb-titulo">{{ $titulo }}</p>

                @foreach($items as $item)
                    <a
                        href="{{ $item['url'] }}"
                        class="sb-link {{ $activo === $item['clave'] ? 'activo' : '' }}"
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

</aside>

<div class="sb-fondo" id="sbFondo"></div>

@push('scripts')
<script>
    (function () {
        var cuerpo = document.body;

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

        // Fondo oscuro (móvil): ocultar
        document.getElementById('sbFondo').addEventListener('click', ocultar);

        // Cualquier botón con data-abrir-sidebar (la hamburguesa) abre el menú
        document.querySelectorAll('[data-abrir-sidebar]').forEach(function (boton) {
            boton.addEventListener('click', abrir);
        });

        // Al cambiar el tamaño de la ventana, ajusta el estado
        window.addEventListener('resize', function () {
            if (esMovil()) {
                cuerpo.classList.remove('con-sidebar');
            } else {
                var oculta = false;
                try { oculta = localStorage.getItem('sidebarOculta') === '1'; } catch (e) {}
                if (!oculta) cuerpo.classList.add('con-sidebar');
            }
        });

        // Esc cierra el menú en móvil
        document.addEventListener('keydown', function (evento) {
            if (evento.key === 'Escape' && esMovil()) ocultar();
        });
    })();
</script>
@endpush