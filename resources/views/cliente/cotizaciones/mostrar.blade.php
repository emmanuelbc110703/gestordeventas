@php
    $estadosTexto = [
        'enviado' => 'Enviado',
        'procesando' => 'Procesando',
        'finalizado' => 'Finalizado',
        'terminado' => 'Terminado',
    ];
    $estadoTexto = $estadosTexto[$cotizacion->estado] ?? ucfirst($cotizacion->estado);

    $pasos = [
        'enviado'    => ['texto' => 'Enviado',    'icono' => 'fa-paper-plane'],
        'procesando' => ['texto' => 'Procesando', 'icono' => 'fa-gears'],
        'finalizado' => ['texto' => 'Finalizado', 'icono' => 'fa-check'],
        'terminado'  => ['texto' => 'Terminado',  'icono' => 'fa-flag-checkered'],
    ];
    $posicionActual = array_search($cotizacion->estado, array_keys($pasos));
    $posicionActual = $posicionActual === false ? 0 : $posicionActual;
@endphp

<x-layouts.panel
    :titulo="'Pedido ' . $cotizacion->folio"
    :regresar="route('cliente.cotizaciones')"
    :migas="[
        ['texto' => 'Mis pedidos', 'url' => route('cliente.cotizaciones')],
        ['texto' => $cotizacion->folio],
    ]"
>

<x-formulario-estilos />
<x-pedido-estilos />

@push('estilos')
<style>
    .seg-card { margin-bottom: 16px; }

    .seg-pasos {
        --seg-tam: 40px;
        --seg-sep: 10px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--seg-sep);
    }

    .seg-paso {
        position: relative;
        text-align: center;
        font-size: 13px;
        color: #9ca3af;
    }

    .seg-paso:not(:first-child)::before {
        content: '';
        position: absolute;
        top: calc(var(--seg-tam) / 2 - 1px);
        right: 50%;
        width: calc(100% + var(--seg-sep));
        height: 2px;
        background: #e5e7eb;
        z-index: 0;
    }
    .seg-paso.hecho::before,
    .seg-paso.actual::before { background: var(--primario); }

    .seg-circulo {
        position: relative;
        z-index: 1;
        width: var(--seg-tam);
        height: var(--seg-tam);
        margin: 0 auto 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef0f4;
        color: #9ca3af;
        font-size: 15px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .seg-paso.hecho { color: var(--texto-suave); }
    .seg-paso.hecho .seg-circulo {
        background: var(--primario-suave);
        color: var(--primario);
        box-shadow: inset 0 0 0 1px var(--primario);
    }

    .seg-paso.actual { color: var(--primario); font-weight: 600; }
    .seg-paso.actual .seg-circulo {
        background: var(--primario);
        color: #fff;
    }

    @media (max-width: 700px) {
        .seg-pasos { --seg-tam: 32px; --seg-sep: 6px; }
        .seg-circulo { font-size: 13px; }
        .seg-paso { font-size: 11px; }
    }
</style>
@endpush

<div class="frm-pagina">
    <div class="frm-encabezado">
        <div>
            <h1>Seguimiento del pedido</h1>
            <p>
                <span class="ped-folio">{{ $cotizacion->folio }}</span>
                <span class="ped-estado {{ $cotizacion->estado }}">{{ $estadoTexto }}</span>
            </p>
        </div>

        <div class="frm-acciones">
            <a href="{{ route('cliente.cotizaciones') }}" class="frm-btn-cancelar">Volver</a>
        </div>
    </div>

    @if(session('success'))
        <div class="ped-exito">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="frm-alerta">{{ $errors->first() }}</div>
    @endif

    {{-- Progreso del pedido --}}
    <section class="frm-card seg-card">
        <h2 class="frm-card-titulo">Estado del pedido</h2>
        <div class="seg-pasos">
            @foreach($pasos as $clave => $paso)
                @php $posicion = $loop->index; @endphp
                <div class="seg-paso {{ $posicion < $posicionActual ? 'hecho' : '' }} {{ $posicion === $posicionActual ? 'actual' : '' }}">
                    <div class="seg-circulo"><i class="fa-solid {{ $paso['icono'] }}"></i></div>
                    {{ $paso['texto'] }}
                </div>
            @endforeach
        </div>
    </section>

    <div class="frm-grid">
        <section class="frm-card ped-card-plana">
            <h2 class="frm-card-titulo">Servicios solicitados</h2>

            <div class="ped-tabla-wrap">
                <table class="ped-tabla">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th class="num">Cantidad</th>
                            <th class="num">Precio</th>
                            <th class="num">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizacion->detalles as $detalle)
                            <tr>
                                <td class="ped-nombre">{{ $detalle->nombre }}</td>
                                <td class="num">{{ $detalle->cantidad }}</td>
                                <td class="num">${{ number_format($detalle->precio, 2) }}</td>
                                <td class="num">${{ number_format($detalle->subtotal, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="ped-vacio-fila">No hay servicios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="ped-totales">
                <div class="ped-linea">
                    <span>Subtotal</span>
                    <span>${{ number_format($cotizacion->subtotal, 2) }}</span>
                </div>
                @if($cotizacion->descuento > 0)
                    <div class="ped-linea">
                        <span>Descuento ({{ number_format($cotizacion->descuento_porcentaje, 2) }}%)</span>
                        <span>- ${{ number_format($cotizacion->descuento, 2) }}</span>
                    </div>
                @endif
                @if($cotizacion->impuesto > 0)
                    <div class="ped-linea">
                        <span>Impuesto ({{ number_format($cotizacion->impuesto_porcentaje, 2) }}%)</span>
                        <span>${{ number_format($cotizacion->impuesto, 2) }}</span>
                    </div>
                @endif
                <div class="ped-linea total">
                    <span>Total</span>
                    <span>${{ number_format($cotizacion->total, 2) }}</span>
                </div>
            </div>
        </section>

        <section class="frm-card">
            <h2 class="frm-card-titulo">Datos del pedido</h2>

            <dl class="ped-info">
                <div>
                    <dt>Folio</dt>
                    <dd>{{ $cotizacion->folio }}</dd>
                </div>
                <div>
                    <dt>Fecha de solicitud</dt>
                    <dd>{{ $cotizacion->created_at?->format('d/m/Y H:i') }}</dd>
                </div>
                <div>
                    <dt>Forma de pago</dt>
                    <dd>{{ ucfirst($cotizacion->forma_pago) }}</dd>
                </div>
            </dl>
        </section>
    </div>
</div>

</x-layouts.panel>