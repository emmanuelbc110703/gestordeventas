@php
    $estadosTexto = [
        'enviado' => 'Enviado',
        'procesando' => 'Procesando',
        'finalizado' => 'Finalizado',
        'terminado' => 'Terminado',
    ];
    $estadoTexto = $estadosTexto[$cotizacion->estado] ?? ucfirst($cotizacion->estado);
    $cliente = $cotizacion->usuario;
    $nombreCliente = $cliente
        ? trim($cliente->name . ' ' . $cliente->apellido)
        : 'Sin nombre';
@endphp

<x-layouts.panel
    :titulo="'Pedido ' . $cotizacion->folio"
    :regresar="route('admin.cotizaciones')"
    :migas="[
        ['texto' => 'Pedidos', 'url' => route('admin.cotizaciones')],
        ['texto' => $cotizacion->folio],
    ]"
>

<x-formulario-estilos />
<x-pedido-estilos />

<div class="frm-pagina">
    <div class="frm-encabezado">
        <div>
            <h1>Detalle del pedido</h1>
            <p>
                <span class="ped-folio">{{ $cotizacion->folio }}</span>
                <span class="ped-estado {{ $cotizacion->estado }}">{{ $estadoTexto }}</span>
            </p>
        </div>

        <div class="frm-acciones">
            <a href="{{ route('admin.cotizaciones') }}" class="frm-btn-cancelar">Volver</a>

            @if($cotizacion->estado === 'enviado')
                <form action="{{ route('admin.cotizaciones.procesar', $cotizacion->id) }}" method="POST" class="ped-form-accion">
                    @csrf
                    <button type="submit" class="frm-btn-guardar">Procesar pedido</button>
                </form>
            @endif

            @if($cotizacion->estado === 'procesando')
                <a href="{{ route('admin.cotizaciones.editar', $cotizacion->id) }}" class="frm-btn-cancelar">Editar pedido</a>

                <form action="{{ route('admin.cotizaciones.finalizar', $cotizacion->id) }}" method="POST" class="ped-form-accion">
                    @csrf
                    <button type="submit" class="frm-btn-guardar">Finalizar pedido</button>
                </form>
            @endif

            @if($cotizacion->estado === 'finalizado')
                <form action="{{ route('admin.cotizaciones.terminar', $cotizacion->id) }}" method="POST" class="ped-form-accion">
                    @csrf
                    <button type="submit" class="frm-btn-guardar">Marcar como terminado</button>
                </form>
            @endif
        </div>
    </div>
    @if(session('success'))
        <div class="ped-exito">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="frm-alerta">{{ $errors->first() }}</div>
    @endif
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
                <div class="ped-linea">
                    <span>Descuento ({{ number_format($cotizacion->descuento_porcentaje, 2) }}%)</span>
                    <span>- ${{ number_format($cotizacion->descuento, 2) }}</span>
                </div>
                <div class="ped-linea">
                    <span>Impuesto ({{ number_format($cotizacion->impuesto_porcentaje, 2) }}%)</span>
                    <span>${{ number_format($cotizacion->impuesto, 2) }}</span>
                </div>
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
                    <dt>Cliente</dt>
                    <dd>{{ $nombreCliente }}</dd>
                </div>
                <div>
                    <dt>Correo</dt>
                    @if($cliente?->email)
                        <dd>{{ $cliente->email }}</dd>
                    @else
                        <dd class="vacio">No registrado</dd>
                    @endif
                </div>
                <div>
                    <dt>Teléfono</dt>
                    @if($cliente?->telefono)
                        <dd>{{ $cliente->telefono }}</dd>
                    @else
                        <dd class="vacio">No registrado</dd>
                    @endif
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
@push('scripts')
<script>
    (function () {
        document.querySelectorAll('.ped-form-accion').forEach(function (formulario) {
            formulario.addEventListener('submit', function () {
                formulario.querySelector('button').disabled = true;
            });
        });
        window.addEventListener('pageshow', function () {
            document.querySelectorAll('.ped-form-accion button').forEach(function (boton) {
                boton.disabled = false;
            });
        });
    })();
</script>
@endpush

</x-layouts.panel>