<x-layouts.panel
    titulo="Editar pedido"
    :regresar="route('admin.cotizaciones.mostrar', $cotizacion->id)"
    :migas="[
        ['texto' => 'Pedidos', 'url' => route('admin.cotizaciones')],
        ['texto' => $cotizacion->folio, 'url' => route('admin.cotizaciones.mostrar', $cotizacion->id)],
        ['texto' => 'Editar'],
    ]"
>

<x-formulario-estilos />
<x-pedido-estilos />

<div class="frm-pagina">
    <div class="frm-encabezado">
        <div>
            <h1>Editar pedido</h1>
            <p><span class="ped-folio">{{ $cotizacion->folio }}</span></p>
        </div>

        <div class="frm-acciones">
            <a href="{{ route('admin.cotizaciones.mostrar', $cotizacion->id) }}" class="frm-btn-cancelar">Cancelar</a>
            <button type="submit" form="formEditar" class="frm-btn-guardar" id="btnGuardar">Guardar cambios</button>
        </div>
    </div>
    @if($errors->has('error'))
        <div class="frm-alerta">{{ $errors->first('error') }}</div>
    @elseif($errors->any())
        <div class="frm-alerta">Revisa las cantidades y los porcentajes e inténtalo de nuevo.</div>
    @endif
    <form id="formEditar" method="POST" action="{{ route('admin.cotizaciones.actualizar', $cotizacion->id) }}">
        @csrf
        @method('PUT')

        <div class="frm-grid">
            <section class="frm-card ped-card-plana">
                <h2 class="frm-card-titulo">Servicios del pedido</h2>

                <div class="ped-tabla-wrap">
                    <table class="ped-tabla">
                        <thead>
                            <tr>
                                <th>Servicio</th>
                                <th class="num">Precio</th>
                                <th class="num">Cantidad</th>
                                <th class="num">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cotizacion->detalles as $detalle)
                                <tr>
                                    <td class="ped-nombre">{{ $detalle->nombre }}</td>
                                    <td class="num">${{ number_format($detalle->precio, 2) }}</td>
                                    <td class="num">
                                        <input
                                            type="number"
                                            name="cantidades[{{ $detalle->id }}]"
                                            value="{{ old('cantidades.' . $detalle->id, $detalle->cantidad) }}"
                                            min="1"
                                            step="1"
                                            class="ped-cantidad cantidad {{ $errors->has('cantidades.' . $detalle->id) ? 'invalido' : '' }}"
                                            data-precio="{{ $detalle->precio }}"
                                            aria-label="Cantidad de {{ $detalle->nombre }}"
                                            required
                                        >
                                    </td>
                                    <td class="num importe-detalle">${{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="ped-columna">
                <section class="frm-card">
                    <h2 class="frm-card-titulo">Descuento e impuesto</h2>
                    <div class="frm-fila">
                        <div class="frm-campo">
                            <label for="descuento_porcentaje">Descuento (%) <span class="frm-req">*</span></label>
                            <div class="frm-control">
                                <input
                                    type="number"
                                    id="descuento_porcentaje"
                                    name="descuento_porcentaje"
                                    value="{{ old('descuento_porcentaje', $cotizacion->descuento_porcentaje) }}"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    class="{{ $errors->has('descuento_porcentaje') ? 'invalido' : '' }}"
                                    required
                                >
                            </div>
                            @error('descuento_porcentaje')
                                <span class="frm-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="frm-campo">
                            <label for="impuesto_porcentaje">Impuesto (%) <span class="frm-req">*</span></label>
                            <div class="frm-control">
                                <input
                                    type="number"
                                    id="impuesto_porcentaje"
                                    name="impuesto_porcentaje"
                                    value="{{ old('impuesto_porcentaje', $cotizacion->impuesto_porcentaje) }}"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    class="{{ $errors->has('impuesto_porcentaje') ? 'invalido' : '' }}"
                                    required
                                >
                            </div>
                            @error('impuesto_porcentaje')
                                <span class="frm-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </section>
                <section class="frm-card">
                    <h2 class="frm-card-titulo">Resumen</h2>

                    <div class="ped-resumen">
                        <div class="ped-linea">
                            <span>Subtotal</span>
                            <span id="subtotal">$0.00</span>
                        </div>
                        <div class="ped-linea">
                            <span>Descuento</span>
                            <span id="descuento">$0.00</span>
                        </div>
                        <div class="ped-linea">
                            <span>Base</span>
                            <span id="base">$0.00</span>
                        </div>
                        <div class="ped-linea">
                            <span>Impuesto</span>
                            <span id="impuesto">$0.00</span>
                        </div>
                        <div class="ped-linea total">
                            <span>Total</span>
                            <span id="total">$0.00</span>
                        </div>
                    </div>
                </section>

            </div>

        </div>
    </form>

</div>

@push('scripts')
<script>
    (function () {
        const formato = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        function dinero(valor) {
            return '$' + formato.format(valor);
        }

        function numero(valor) {
            const resultado = parseFloat(valor);
            return isNaN(resultado) ? 0 : resultado;
        }

        function porcentaje(id) {
            return Math.min(Math.max(numero(document.getElementById(id).value), 0), 100);
        }

        function calcular() {
            let subtotal = 0;

            document.querySelectorAll('.cantidad').forEach(function (input) {
                let cantidad = parseInt(input.value, 10);
                if (!cantidad || cantidad < 1) cantidad = 1;

                const importe = numero(input.dataset.precio) * cantidad;
                subtotal += importe;

                input.closest('tr').querySelector('.importe-detalle').textContent = dinero(importe);
            });

            const descuento = subtotal * (porcentaje('descuento_porcentaje') / 100);
            const base = subtotal - descuento;
            const impuesto = base * (porcentaje('impuesto_porcentaje') / 100);
            const total = base + impuesto;

            document.getElementById('subtotal').textContent = dinero(subtotal);
            document.getElementById('descuento').textContent = '- ' + dinero(descuento);
            document.getElementById('base').textContent = dinero(base);
            document.getElementById('impuesto').textContent = dinero(impuesto);
            document.getElementById('total').textContent = dinero(total);
        }

        document.querySelectorAll('.cantidad').forEach(function (input) {
            input.addEventListener('input', calcular);
        });
        document.getElementById('descuento_porcentaje').addEventListener('input', calcular);
        document.getElementById('impuesto_porcentaje').addEventListener('input', calcular);

        calcular();

        const formulario = document.getElementById('formEditar');
        const boton = document.getElementById('btnGuardar');

        formulario.addEventListener('submit', function () {
            boton.disabled = true;
        });

        window.addEventListener('pageshow', function () {
            boton.disabled = false;
        });
    })();
</script>
@endpush

</x-layouts.panel>