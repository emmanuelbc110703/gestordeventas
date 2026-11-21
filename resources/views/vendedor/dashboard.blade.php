<x-layouts.panel
    titulo="Inicio"
    :inicio="route('vendedor.dashboard')"
    :migas="[
        ['texto' => 'Inicio'],
    ]"
>

<x-lista-estilos />

@php
    $usuario = auth()->user();
    $tieneCaja = (bool) $usuario->puntoVenta;
@endphp

@push('estilos')
<style>
    .cd-pagina {
        --cd-sombra: 0 1px 2px rgba(17, 24, 39, 0.04), 0 4px 14px rgba(17, 24, 39, 0.05);
        --cd-primario-suave: color-mix(in srgb, var(--primario) 10%, #fff);
    }

    .cd-resumen {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 40px;
    }
    .cd-resumen-card {
        --acento: var(--primario);
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--borde);
        box-shadow: var(--cd-sombra);
        transition: border-color 0.2s ease;
    }
    .cd-resumen-card:hover { border-color: var(--acento); }
    .cd-resumen-icono {
        flex: 0 0 auto;
        display: grid;
        place-items: center;
        width: 46px;
        height: 46px;
        color: var(--acento);
        background: color-mix(in srgb, var(--acento) 12%, #fff);
    }
    .cd-resumen-icono svg { width: 22px; height: 22px; }
    .cd-resumen-card strong {
        display: block;
        font-size: 20px;
        font-weight: 700;
        line-height: 1.1;
        color: var(--texto);
    }
    .cd-resumen-card span {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--texto-suave);
    }
    .cd-c-azul { --acento: #2563eb; }

    .cd-modulos-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 12px;
        margin-bottom: 18px;
    }
    .cd-modulos-header h3 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        font-size: 17px;
        color: var(--texto);
    }
    .cd-modulos-header h3::before {
        content: "";
        width: 4px;
        height: 18px;
        background: var(--primario);
    }
    .cd-modulos-header span { font-size: 13px; color: var(--texto-suave); }

    .cd-botones {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }
    .cd-boton {
        display: flex;
        flex-direction: column;
        min-height: 170px;
        padding: 22px;
        background: #fff;
        border: 1px solid var(--borde);
        box-shadow: var(--cd-sombra);
        color: var(--texto);
        text-decoration: none;
        transition: border-color 0.2s ease;
    }
    .cd-boton:hover { border-color: var(--primario); }
    .cd-boton:focus-visible { outline: 2px solid var(--primario); outline-offset: 2px; }
    .cd-icono {
        display: grid;
        place-items: center;
        width: 44px;
        height: 44px;
        margin-bottom: 16px;
        color: var(--primario);
        background: var(--cd-primario-suave);
    }
    .cd-icono svg { width: 22px; height: 22px; }
    .cd-boton strong { margin-bottom: 6px; font-size: 15px; }
    .cd-desc {
        font-size: 13px;
        line-height: 1.5;
        color: var(--texto-suave);
    }
    .cd-ir {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: auto;
        padding-top: 16px;
        font-size: 13px;
        font-weight: 600;
        color: var(--primario);
    }
    .cd-ir svg { width: 14px; height: 14px; }

    @media (max-width: 600px) {
        .cd-resumen, .cd-botones { grid-template-columns: 1fr; gap: 12px; }
        .cd-boton { min-height: 0; }
    }
</style>
@endpush

<x-sidebar activo="dashboard" />

<div class="lst-pagina cd-pagina">
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
                <h1>Bienvenido, {{ $usuario->name }}</h1>
            </div>
            <p>Panel de vendedor · Los Amates</p>
        </div>
    </div>

    <div class="cd-resumen">
        <div class="cd-resumen-card">
            <div class="cd-resumen-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2"/>
                </svg>
            </div>
            <div>
                <strong>Mi información</strong>
                <span>Cuenta</span>
            </div>
        </div>

        @if($tieneCaja)
            <div class="cd-resumen-card cd-c-azul">
                <div class="cd-resumen-icono">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                        <path d="M6 3h12v6H6z M4 9h16v12H4z M8 13h8 M8 17h8"/>
                    </svg>
                </div>
                <div>
                    <strong>Punto de venta</strong>
                    <span>Operación</span>
                </div>
            </div>
        @endif
    </div>

    <div class="cd-modulos-header">
        <h3>Accesos rápidos</h3>
        <span>Módulos disponibles</span>
    </div>
    <div class="cd-botones">
        <a href="{{ route('vendedor.informacion') }}" class="cd-boton">
            <div class="cd-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2"/>
                </svg>
            </div>
            <strong>Mi información</strong>
            <span class="cd-desc">Consulta y actualiza tu información personal.</span>
            <span class="cd-ir">
                Abrir
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="square" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
            </span>
        </a>

        @if($tieneCaja)
            <a href="{{ route('empleado.punto_venta') }}" class="cd-boton">
                <div class="cd-icono">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                        <path d="M6 3h12v6H6z M4 9h16v12H4z M8 13h8 M8 17h8"/>
                    </svg>
                </div>
                <strong>Punto de venta</strong>
                <span class="cd-desc">Accede al sistema para realizar las operaciones de venta.</span>
                <span class="cd-ir">
                    Abrir
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="square" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
                </span>
            </a>
        @endif
    </div>
</div>
</x-layouts.panel>