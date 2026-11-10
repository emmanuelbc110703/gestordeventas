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
    .cd-salir {
        display: inline-flex;
        align-items: center;
        height: 44px;
        padding: 0 20px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font: inherit;
        font-size: 14px;
        font-weight: 600;
        color: var(--texto-suave);
        cursor: pointer;
        transition: border-color 0.2s ease, color 0.2s ease, background 0.2s ease;
    }
    .cd-salir:hover {
        border-color: #fecaca;
        background: #fef2f2;
        color: #b91c1c;
    }

    /* Resumen */
    .cd-resumen {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin: 8px 0 36px;
    }
    .cd-resumen-card {
        padding: 18px 20px;
        background: #fff;
        border: 1px solid var(--borde);
        border-left: 3px solid var(--primario);
    }
    .cd-resumen-card span {
        display: block;
        margin-bottom: 10px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--texto-suave);
    }
    .cd-resumen-card strong {
        display: block;
        font-size: 28px;
        font-weight: 700;
        line-height: 1;
        font-variant-numeric: tabular-nums;
        color: var(--texto);
    }

    /* Accesos rápidos */
    .cd-modulos-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding-bottom: 12px;
        margin-bottom: 18px;
        border-bottom: 1px solid var(--borde);
    }
    .cd-modulos-header h3 { margin: 0; font-size: 17px; color: var(--texto); }
    .cd-modulos-header span { font-size: 13px; color: var(--texto-suave); }

    .cd-botones {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    .cd-boton {
        display: flex;
        flex-direction: column;
        min-height: 135px;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--texto);
        text-decoration: none;
        transition: border-color 0.2s ease, background 0.2s ease;
    }
    .cd-boton:hover {
        border-color: var(--primario);
        background: #fcfbff;
    }
    .cd-boton strong {
        margin-bottom: 6px;
        font-size: 15px;
    }
    .cd-desc {
        font-size: 13px;
        line-height: 1.45;
        color: var(--texto-suave);
    }
    .cd-ir {
        margin-top: auto;
        padding-top: 16px;
        font-size: 13px;
        font-weight: 600;
        color: var(--primario);
    }
    .cd-boton:hover .cd-ir { text-decoration: underline; }

    .cd-boton.cd-deshabilitado { cursor: default; background: #fafafa; }
    .cd-boton.cd-deshabilitado:hover { border-color: var(--borde); background: #fafafa; }
    .cd-boton.cd-deshabilitado strong { color: var(--texto-suave); }
    .cd-etiqueta {
        margin-top: auto;
        padding-top: 16px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #9ca3af;
    }

    @media (max-width: 1100px) {
        .cd-resumen, .cd-botones { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .cd-resumen, .cd-botones { grid-template-columns: 1fr; }
        .cd-resumen { gap: 12px; }
    }
</style>
@endpush

<x-sidebar activo="dashboard" />

<div class="lst-pagina">
    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <h1>Bienvenido, {{ $usuario->name }}</h1>
            </div>
            <p>Panel del cliente · Orquídeas y más "Los Amates"</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="cd-salir">Cerrar sesión</button>
        </form>
    </div>

    <div class="cd-resumen">
        <div class="cd-resumen-card">
            <span>Mis cotizaciones</span>
            <strong>{{ $totalPedidos }}</strong>
        </div>
        <div class="cd-resumen-card">
            <span>Enviadas</span>
            <strong>{{ $enviados }}</strong>
        </div>
        <div class="cd-resumen-card">
            <span>En proceso</span>
            <strong>{{ $procesando }}</strong>
        </div>
        <div class="cd-resumen-card">
            <span>Finalizadas</span>
            <strong>{{ $terminados }}</strong>
        </div>
    </div>

    <div class="cd-modulos-header">
        <h3>Accesos rápidos</h3>
        <span>Todo lo que puedes hacer</span>
    </div>
    <div class="cd-botones">
        <div class="cd-boton cd-deshabilitado" aria-disabled="true">
            <strong>Compras</strong>
            <span class="cd-desc">Consulta el historial de tus compras.</span>
            <span class="cd-etiqueta">Próximamente</span>
        </div>
        <a href="{{ route('cliente.cotizaciones') }}" class="cd-boton">
            <strong>Mis pedidos</strong>
            <span class="cd-desc">Consulta el seguimiento de tus cotizaciones.</span>
            <span class="cd-ir">Abrir</span>
        </a>
        <a href="{{ route('cliente.cotizaciones.crear') }}" class="cd-boton">
            <strong>Nueva cotización</strong>
            <span class="cd-desc">Selecciona servicios y solicita tu cotización.</span>
            <span class="cd-ir">Abrir</span>
        </a>
        <a href="{{ route('cliente.informacion') }}" class="cd-boton">
            <strong>Mi información</strong>
            <span class="cd-desc">Revisa y actualiza los datos de tu cuenta.</span>
            <span class="cd-ir">Abrir</span>
        </a>
    </div>
</div>
</x-layouts.panel>