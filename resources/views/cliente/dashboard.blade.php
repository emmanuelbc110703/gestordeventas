<x-layouts.panel
    titulo="Inicio"
    :inicio="route('cliente.dashboard')"
    :migas="[
        ['texto' => 'Inicio'],
    ]"
>

<x-lista-estilos />

@php
    $usuario = auth()->user();
    $conteos = \App\Models\Cotizacion::where('user_id', $usuario->id)
        ->get(['estado'])
        ->countBy('estado');

    $totalPedidos = $conteos->sum();
    $enviados     = $conteos->get('enviado', 0);
    $procesando   = $conteos->get('procesando', 0);
    $terminados   = $conteos->get('finalizado', 0) + $conteos->get('terminado', 0);
@endphp

@push('estilos')
<style>
    .cd-pagina {
        --cd-sombra: 0 1px 2px rgba(17, 24, 39, 0.04), 0 4px 14px rgba(17, 24, 39, 0.05);
        --cd-primario-suave: color-mix(in srgb, var(--primario) 10%, #fff);
    }

    .cd-encabezado {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 24px;
        padding-bottom: 22px;
        margin-bottom: 28px;
        border-bottom: 1px solid var(--borde);
    }
    .cd-eyebrow {
        display: block;
        margin-bottom: 8px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--primario);
    }
    .cd-encabezado h1 {
        margin: 0 0 4px;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -0.01em;
        line-height: 1.2;
        color: var(--texto);
    }
    .cd-encabezado p {
        margin: 0;
        font-size: 14px;
        color: var(--texto-suave);
    }

    .cd-salir {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 44px;
        padding: 0 20px;
        font: inherit;
        font-size: 14px;
        font-weight: 600;
        color: var(--texto-suave);
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        cursor: pointer;
        transition: border-color 0.2s ease;
    }
    .cd-salir svg { width: 16px; height: 16px; }
    .cd-salir:hover { border-color: var(--primario); }
    .cd-salir:focus-visible { outline: 2px solid var(--primario); outline-offset: 2px; }

    .cd-resumen {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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
        font-size: 28px;
        font-weight: 700;
        line-height: 1;
        font-variant-numeric: tabular-nums;
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
    .cd-c-azul  { --acento: #2563eb; }
    .cd-c-ambar { --acento: #d97706; }
    .cd-c-verde { --acento: #059669; }

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
        grid-template-columns: repeat(4, 1fr);
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

    .cd-boton.cd-deshabilitado {
        cursor: default;
        background: #fafafa;
        box-shadow: none;
    }
    .cd-boton.cd-deshabilitado:hover { border-color: var(--borde); }
    .cd-boton.cd-deshabilitado .cd-icono { color: #9ca3af; background: #f1f1f4; }
    .cd-boton.cd-deshabilitado strong { color: var(--texto-suave); }
    .cd-etiqueta {
        align-self: flex-start;
        margin-top: auto;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #6b7280;
        background: #ececf0;
    }

    @media (max-width: 1100px) {
        .cd-resumen, .cd-botones { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .cd-encabezado { flex-direction: column; align-items: flex-start; }
        .cd-encabezado h1 { font-size: 22px; }
        .cd-resumen, .cd-botones { grid-template-columns: 1fr; gap: 12px; }
        .cd-boton { min-height: 0; }
    }
</style>
@endpush

<x-sidebar activo="dashboard" />

<div class="lst-pagina cd-pagina">
    <div class="cd-encabezado">
        <div>
            <h1>Bienvenido, {{ $usuario->name }}</h1>
            <p>Panel de cliente · Los Amates</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    </div>

    <div class="cd-resumen">
        <div class="cd-resumen-card">
            <div class="cd-resumen-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M14 3H6v18h12V7z M14 3v4h4 M9 12h6 M9 16h6"/>
                </svg>
            </div>
            <div>
                <strong>{{ $totalPedidos }}</strong>
                <span>Mis cotizaciones</span>
            </div>
        </div>
        <div class="cd-resumen-card cd-c-azul">
            <div class="cd-resumen-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M3 5h18v14H3z M3 5l9 8 9-8"/>
                </svg>
            </div>
            <div>
                <strong>{{ $enviados }}</strong>
                <span>Enviadas</span>
            </div>
        </div>
        <div class="cd-resumen-card cd-c-ambar">
            <div class="cd-resumen-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18z M12 7v5l3 2"/>
                </svg>
            </div>
            <div>
                <strong>{{ $procesando }}</strong>
                <span>En proceso</span>
            </div>
        </div>
        <div class="cd-resumen-card cd-c-verde">
            <div class="cd-resumen-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M4 12l5 5L20 6"/>
                </svg>
            </div>
            <div>
                <strong>{{ $terminados }}</strong>
                <span>Finalizadas</span>
            </div>
        </div>
    </div>

    <div class="cd-modulos-header">
        <h3>Accesos rápidos</h3>
        <span>Todo lo que puedes hacer</span>
    </div>
    <div class="cd-botones">
        <a href="{{ route('cliente.compras') }}" class="cd-boton">
            <div class="cd-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M3 4h2l2.5 11h11L21 7H6 M9 20h.01 M17 20h.01"/>
                </svg>
            </div>
            <strong>Compras</strong>
            <span class="cd-desc">Consulta el historial de tus compras.</span>
            <span class="cd-ir">
                Abrir
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="square" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
            </span>
        </a>

        <a href="{{ route('cliente.cotizaciones') }}" class="cd-boton">
            <div class="cd-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M9 4h6v3H9z M7 5H4v16h16V5h-3 M8 12h8 M8 16h5"/>
                </svg>
            </div>
            <strong>Mis pedidos</strong>
            <span class="cd-desc">Consulta el seguimiento de tus cotizaciones.</span>
            <span class="cd-ir">
                Abrir
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="square" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
            </span>
        </a>

        <a href="{{ route('cliente.cotizaciones.crear') }}" class="cd-boton">
            <div class="cd-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M4 4h16v16H4z M12 8v8 M8 12h8"/>
                </svg>
            </div>
            <strong>Nueva cotización</strong>
            <span class="cd-desc">Selecciona servicios y solicita tu cotización.</span>
            <span class="cd-ir">
                Abrir
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="square" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
            </span>
        </a>

        <a href="{{ route('cliente.informacion') }}" class="cd-boton">
            <div class="cd-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z M4 21v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2"/>
                </svg>
            </div>
            <strong>Mi información</strong>
            <span class="cd-desc">Revisa y actualiza los datos de tu cuenta.</span>
            <span class="cd-ir">
                Abrir
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="square" aria-hidden="true"><path d="M4 12h16M14 6l6 6-6 6"/></svg>
            </span>
        </a>
    </div>
</div>
</x-layouts.panel>