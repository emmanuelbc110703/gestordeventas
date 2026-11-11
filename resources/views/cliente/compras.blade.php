<x-layouts.panel
    titulo="Mis compras"
    :inicio="route('cliente.dashboard')"
    :migas="[
        ['texto' => 'Mis compras'],
    ]"
>

<x-lista-estilos />
<x-pedido-estilos />

@php
    // Estados que cuentan como compra (todo lo que ya salió de "enviado")
    $estadosTexto = [
        'procesando' => 'Procesando',
        'finalizado' => 'Finalizado',
        'terminado'  => 'Terminado',
    ];
    $etapas = array_keys($estadosTexto);
    $filtro = $filtro ?? '';

    $tabs = [
        ''            => 'Todas',
        'procesando'  => 'En proceso',
        'finalizadas' => 'Finalizadas',
    ];

    // AJUSTA este nombre de ruta al de tu vista de detalle del pedido
    $urlDetalle = fn ($compra) => route('cliente.cotizaciones.mostrar', $compra);
@endphp

@push('estilos')
<style>
    .cmp-pagina {
        --cmp-sombra: 0 1px 2px rgba(17, 24, 39, 0.04), 0 4px 14px rgba(17, 24, 39, 0.05);
        --cmp-primario-suave: color-mix(in srgb, var(--primario) 10%, #fff);
    }

    .cmp-encabezado {
        padding-bottom: 22px;
        margin-bottom: 28px;
        border-bottom: 1px solid var(--borde);
    }
    .cmp-eyebrow {
        display: block;
        margin-bottom: 8px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--primario);
    }
    .cmp-encabezado h1 {
        margin: 0 0 4px;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: -0.01em;
        line-height: 1.2;
        color: var(--texto);
    }
    .cmp-encabezado p { margin: 0; font-size: 14px; color: var(--texto-suave); }

    .cmp-resumen {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 36px;
    }
    .cmp-card {
        --acento: var(--primario);
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--borde);
        box-shadow: var(--cmp-sombra);
        transition: border-color 0.2s ease;
    }
    .cmp-card:hover { border-color: var(--acento); }
    .cmp-card-icono {
        flex: 0 0 auto;
        display: grid;
        place-items: center;
        width: 46px;
        height: 46px;
        color: var(--acento);
        background: color-mix(in srgb, var(--acento) 12%, #fff);
    }
    .cmp-card-icono svg { width: 22px; height: 22px; }
    .cmp-card strong {
        display: block;
        font-size: 26px;
        font-weight: 700;
        line-height: 1;
        font-variant-numeric: tabular-nums;
        color: var(--texto);
    }
    .cmp-card span {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--texto-suave);
    }
    .cmp-azul  { --acento: #2563eb; }
    .cmp-ambar { --acento: #d97706; }
    .cmp-verde { --acento: #059669; }

    .cmp-barra {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        margin-bottom: 18px;
        border-bottom: 1px solid var(--borde);
    }
    .cmp-tabs { display: flex; gap: 4px; }
    .cmp-tab {
        padding: 10px 16px;
        margin-bottom: -1px;
        font-size: 14px;
        font-weight: 600;
        color: var(--texto-suave);
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: color 0.2s ease, border-color 0.2s ease;
    }
    .cmp-tab:hover { color: var(--primario); }
    .cmp-tab.activa { color: var(--primario); border-bottom-color: var(--primario); }
    .cmp-cuenta {
        padding-bottom: 10px;
        font-size: 13px;
        color: var(--texto-suave);
    }

    .cmp-lista { display: flex; flex-direction: column; gap: 14px; }

    .cmp-item {
        display: grid;
        grid-template-columns: 1.1fr 1.6fr auto;
        align-items: center;
        gap: 28px;
        padding: 20px 22px;
        background: #fff;
        border: 1px solid var(--borde);
        box-shadow: var(--cmp-sombra);
        color: var(--texto);
        text-decoration: none;
        transition: border-color 0.2s ease;
    }
    .cmp-item:hover { border-color: var(--primario); }
    .cmp-item:focus-visible { outline: 2px solid var(--primario); outline-offset: 2px; }

    .cmp-id { display: flex; flex-direction: column; gap: 4px; }
    .cmp-folio { font-size: 15px; font-weight: 700; }
    .cmp-fecha { font-size: 13px; color: var(--texto-suave); }

    .cmp-detalle { display: flex; flex-direction: column; gap: 10px; }
    .cmp-meta { font-size: 13px; color: var(--texto-suave); }
    .cmp-meta b { font-weight: 600; color: var(--texto); }
    .cmp-meta i { margin: 0 8px; font-style: normal; color: #d1d5db; }

    .cmp-progreso { display: grid; grid-template-columns: repeat(3, 1fr); gap: 4px; max-width: 280px; }
    .cmp-progreso span { height: 4px; background: #e5e7eb; }
    .cmp-progreso span.on { background: var(--primario); }

    .cmp-lado {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
        text-align: right;
    }
    .cmp-total {
        font-size: 20px;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
        color: var(--texto);
    }
    .cmp-ver {
        font-size: 13px;
        font-weight: 600;
        color: var(--primario);
    }

    .cmp-vacio {
        padding: 48px 24px;
        text-align: center;
        background: #fff;
        border: 1px dashed var(--borde);
    }
    .cmp-vacio strong { display: block; margin-bottom: 6px; font-size: 16px; color: var(--texto); }
    .cmp-vacio p { margin: 0 0 18px; font-size: 14px; color: var(--texto-suave); }
    .cmp-btn {
        display: inline-flex;
        align-items: center;
        height: 42px;
        padding: 0 20px;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        background: var(--primario);
        border: 1px solid var(--primario);
    }

    @media (max-width: 1100px) {
        .cmp-resumen { grid-template-columns: repeat(2, 1fr); }
        .cmp-item { grid-template-columns: 1fr auto; }
        .cmp-detalle { grid-column: 1 / -1; order: 3; }
    }
    @media (max-width: 600px) {
        .cmp-encabezado h1 { font-size: 22px; }
        .cmp-resumen { grid-template-columns: 1fr; gap: 12px; }
        .cmp-barra { flex-direction: column; align-items: flex-start; gap: 0; }
        .cmp-cuenta { display: none; }
        .cmp-item { padding: 18px; gap: 16px; }
    }
</style>
@endpush

<x-sidebar activo="compras" />

<div class="lst-pagina cmp-pagina">
    <div class="cmp-encabezado">
        <h1>Mis compras</h1>
        <p>Pedidos que ya están en marcha o completados.</p>
    </div>
    <div class="cmp-resumen">
        <div class="cmp-card">
            <div class="cmp-card-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M3 4h2l2.5 11h11L21 7H6 M9 20h.01 M17 20h.01"/>
                </svg>
            </div>
            <div>
                <strong>{{ $resumen['total'] }}</strong>
                <span>Compras</span>
            </div>
        </div>
        <div class="cmp-card cmp-ambar">
            <div class="cmp-card-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18z M12 7v5l3 2"/>
                </svg>
            </div>
            <div>
                <strong>{{ $resumen['procesando'] }}</strong>
                <span>En proceso</span>
            </div>
        </div>
        <div class="cmp-card cmp-verde">
            <div class="cmp-card-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M4 12l5 5L20 6"/>
                </svg>
            </div>
            <div>
                <strong>{{ $resumen['finalizadas'] }}</strong>
                <span>Finalizadas</span>
            </div>
        </div>
        <div class="cmp-card cmp-azul">
            <div class="cmp-card-icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
                    <path d="M3 6h18v12H3z M3 10h18 M7 15h4"/>
                </svg>
            </div>
            <div>
                <strong>${{ number_format($resumen['invertido'], 2) }}</strong>
                <span>Total invertido</span>
            </div>
        </div>
    </div>
    <div class="cmp-barra">
        <nav class="cmp-tabs" aria-label="Filtrar compras">
            @foreach($tabs as $clave => $texto)
                <a
                    href="{{ $clave === '' ? route('cliente.compras') : route('cliente.compras', ['estado' => $clave]) }}"
                    class="cmp-tab {{ $filtro === (string) $clave ? 'activa' : '' }}"
                >{{ $texto }}</a>
            @endforeach
        </nav>
        <span class="cmp-cuenta">{{ $compras->count() }} {{ $compras->count() === 1 ? 'resultado' : 'resultados' }}</span>
    </div>
    @if($compras->isEmpty())
        <div class="cmp-vacio">
            <strong>{{ $filtro === '' ? 'Aún no tienes compras' : 'No hay compras en esta categoría' }}</strong>
            <p>
                {{ $filtro === ''
                    ? 'Cuando una de tus cotizaciones pase a proceso, aparecerá aquí.'
                    : 'Prueba con otro filtro para ver más resultados.' }}
            </p>
            @if($filtro === '')
                <a href="{{ route('cliente.cotizaciones.crear') }}" class="cmp-btn">Nueva cotización</a>
            @endif
        </div>
    @else
        <div class="cmp-lista">
            @foreach($compras as $compra)
                @php
                    $indice = array_search($compra->estado, $etapas);
                    $indice = $indice === false ? 0 : $indice;
                    $estadoTexto = $estadosTexto[$compra->estado] ?? ucfirst($compra->estado);
                @endphp

                <a href="{{ $urlDetalle($compra) }}" class="cmp-item">
                    <div class="cmp-id">
                        <span class="cmp-folio">{{ $compra->folio }}</span>
                        <span class="cmp-fecha">{{ $compra->created_at?->format('d/m/Y') }}</span>
                    </div>

                    <div class="cmp-detalle">
                        <div class="cmp-meta">
                            <b>{{ $compra->detalles_count }}</b> {{ $compra->detalles_count === 1 ? 'servicio' : 'servicios' }}
                            <i>·</i>
                            {{ ucfirst($compra->forma_pago) }}
                        </div>
                        <div class="cmp-progreso" role="img" aria-label="Avance: {{ $estadoTexto }}">
                            @for($i = 0; $i < count($etapas); $i++)
                                <span class="{{ $i <= $indice ? 'on' : '' }}"></span>
                            @endfor
                        </div>
                    </div>

                    <div class="cmp-lado">
                        <span class="cmp-total">${{ number_format($compra->total, 2) }}</span>
                        <span class="ped-estado {{ $compra->estado }}">{{ $estadoTexto }}</span>
                        <span class="cmp-ver">Ver detalle</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
</x-layouts.panel>