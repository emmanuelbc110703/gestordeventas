@php
    $esIngreso = $seleccionado && $seleccionado->tipo_movimiento === 'ingreso';
    $cuentaPreseleccionada = (string) old('cuenta_financiera_id', $seleccionado?->cuenta_financiera_id);
@endphp
<x-layouts.panel
    titulo="Registrar pago de servicio"
    :regresar="route('admin.pago_servicios.index')"
    :migas="[
        ['texto' => 'Pago de servicios', 'url' => route('admin.pago_servicios.index')],
        ['texto' => 'Registrar pago', 'url' => null],
    ]"
>

<x-formulario-estilos />

@push('estilos')
<style>
    .rg-selector { background: #fff; border: 1px solid var(--borde); padding: 20px 24px; margin-bottom: 28px; }
    .rg-selector label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; }
    .rg-resumen { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 20px 24px; }
    .rg-resumen small { display: block; font-size: 12px; font-weight: 600; letter-spacing: .05em; text-transform: uppercase;
        color: var(--texto-suave); margin-bottom: 4px; }
    .rg-resumen strong { font-size: 15px; font-weight: 600; color: var(--texto); }
    .rg-aviso { display: none; margin-top: 10px; padding: 10px 14px; font-size: 13px; font-weight: 600;
        background: #fffaeb; border: 1px solid #fedf89; color: #b54708; }
    .rg-aviso.visible { display: block; }
    .rg-saldo { display: none; margin-top: 8px; font-size: 13px; color: var(--texto-suave); }
    .rg-saldo.visible { display: block; }
    .rg-saldo strong { color: var(--texto); }
    .rg-vacio { padding: 56px 20px; background: #fff; border: 1px solid var(--borde); text-align: center; color: var(--texto-suave); }
    .frm-control textarea { width: 100%; min-height: 96px; padding: 12px 14px; background: #fff; border: 1px solid var(--borde);
        border-radius: 0; font-family: inherit; font-size: 15px; color: var(--texto); outline: none; resize: vertical; }
    .frm-control textarea:focus { border-color: var(--primario); box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1); }
</style>
@endpush

<x-sidebar activo="pagos" />

<div class="frm-pagina">

    @if($pendientes->isEmpty())
        <div class="frm-encabezado">
            <div>
                <h1>Registrar pago</h1>
                <p>Registra el recibo de un servicio programado en la agenda.</p>
            </div>
            <div class="frm-acciones">
                <a href="{{ route('admin.pago_servicios.index') }}" class="frm-btn-cancelar">Volver a la agenda</a>
            </div>
        </div>
        <div class="rg-vacio">No hay servicios con pago pendiente.</div>
    @else
        <form method="POST" action="{{ route('admin.pago_servicios.registrar.store') }}" id="formRegistro" novalidate>
            @csrf

            <div class="frm-encabezado">
                <div>
                    <h1>{{ $esIngreso ? 'Registrar cobro' : 'Registrar pago' }}</h1>
                    <p>Selecciona el servicio del recibo y captura lo que realmente se {{ $esIngreso ? 'cobró' : 'pagó' }}.</p>
                </div>
                <div class="frm-acciones">
                    <a href="{{ route('admin.pago_servicios.historial') }}" class="frm-btn-cancelar">Ver pagos realizados</a>
                    @if($seleccionado)
                        <button type="submit" class="frm-btn-guardar" id="btnGuardarRegistro">
                            {{ $esIngreso ? 'Confirmar cobro' : 'Confirmar pago' }}
                        </button>
                    @endif
                </div>
            </div>

            @if($errors->any())
                <div class="frm-alerta">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="rg-selector">
                <label for="selectorServicio">Servicio con pago pendiente</label>
                <div class="frm-control">
                    <select id="selectorServicio" onchange="window.location = this.value ? '{{ route('admin.pago_servicios.registrar') }}?servicio=' + this.value : '{{ route('admin.pago_servicios.registrar') }}'">
                        <option value="">Selecciona el servicio del recibo…</option>
                        @foreach($pendientes as $p)
                            <option value="{{ $p->id }}" @selected($seleccionado && $seleccionado->id === $p->id)>
                                {{ $p->servicio }} · {{ $p->fecha_pago->format('d/m/Y') }}{{ $p->monto !== null ? ' · $'.number_format((float) $p->monto, 2) : '' }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                </div>
            </div>

            @if(request()->filled('servicio') && ! $seleccionado)
                <div class="frm-alerta">Ese servicio ya no tiene un pago pendiente.</div>
            @endif

            @if($seleccionado)
                <input type="hidden" name="pago_servicio_id" value="{{ $seleccionado->id }}">

                <div class="frm-grid">

                    <div class="frm-card">
                        <div class="frm-card-titulo">Registrado en la agenda</div>
                        <div class="rg-resumen">
                            <div><small>Servicio</small><strong>{{ $seleccionado->servicio }}</strong></div>
                            <div><small>Tipo</small><strong>{{ $esIngreso ? 'Ingreso' : 'Pago' }}</strong></div>
                            <div><small>Monto registrado</small>
                                <strong>{{ $seleccionado->monto !== null ? '$'.number_format((float) $seleccionado->monto, 2) : 'Sin monto' }}</strong></div>
                            <div><small>Fecha programada</small><strong>{{ $seleccionado->fecha_pago->format('d/m/Y') }}</strong></div>
                            <div><small>Vencimiento</small><strong>{{ $seleccionado->fecha_vencimiento?->format('d/m/Y') ?? '—' }}</strong></div>
                            <div><small>Periodicidad</small><strong>{{ $periodicidades[$seleccionado->periodicidad] ?? 'No definida' }}</strong></div>
                            <div><small>Descripción</small><strong>{{ $seleccionado->descripcion ?: '—' }}</strong></div>
                        </div>
                    </div>

                    <div class="frm-card">
                        <div class="frm-card-titulo">Datos del recibo</div>

                        <div class="frm-campo">
                            <label for="monto_pagado">Monto real {{ $esIngreso ? 'cobrado' : 'pagado' }} <span class="frm-req">*</span></label>
                            <div class="frm-control">
                                <input id="monto_pagado" name="monto_pagado" type="number" step="0.01" min="0.01" required
                                       class="{{ $errors->has('monto_pagado') ? 'invalido' : '' }}"
                                       value="{{ old('monto_pagado', $seleccionado->monto) }}">
                            </div>
                            <div class="rg-aviso" id="avisoMonto"></div>
                            @error('monto_pagado') <span class="frm-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="frm-campo">
                            <label for="cuenta_financiera_id">{{ $esIngreso ? 'Cuenta de destino' : 'Cuenta de origen' }} <span class="frm-req">*</span></label>
                            <div class="frm-control">
                                <select id="cuenta_financiera_id" name="cuenta_financiera_id" required
                                        class="{{ $errors->has('cuenta_financiera_id') ? 'invalido' : '' }}">
                                    <option value="">Selecciona una cuenta</option>
                                    @foreach($cuentas as $cuenta)
                                        <option value="{{ $cuenta->id }}" data-saldo="{{ $cuenta->saldo_actual }}"
                                                @selected($cuentaPreseleccionada === (string) $cuenta->id)>
                                            {{ $cuenta->nombre }} · {{ $cuenta->moneda }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                            </div>
                            <div class="rg-saldo" id="saldoCuenta"></div>
                            @error('cuenta_financiera_id') <span class="frm-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="frm-fila">
                            <div class="frm-campo">
                                <label for="fecha_recibo">Fecha del recibo <span class="frm-req">*</span></label>
                                <div class="frm-control">
                                    <input id="fecha_recibo" name="fecha_recibo" type="date" required max="{{ now()->toDateString() }}"
                                           class="{{ $errors->has('fecha_recibo') ? 'invalido' : '' }}"
                                           value="{{ old('fecha_recibo', now()->toDateString()) }}">
                                </div>
                                @error('fecha_recibo') <span class="frm-error">{{ $message }}</span> @enderror
                            </div>
                            <div class="frm-campo">
                                <label for="fecha_pago">Fecha de {{ $esIngreso ? 'cobro' : 'pago' }} <span class="frm-req">*</span></label>
                                <div class="frm-control">
                                    <input id="fecha_pago" name="fecha_pago" type="date" required max="{{ now()->toDateString() }}"
                                           class="{{ $errors->has('fecha_pago') ? 'invalido' : '' }}"
                                           value="{{ old('fecha_pago', now()->toDateString()) }}">
                                </div>
                                @error('fecha_pago') <span class="frm-error">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="frm-campo">
                            <label for="folio_recibo">Folio del recibo</label>
                            <div class="frm-control">
                                <input id="folio_recibo" name="folio_recibo" type="text" maxlength="100"
                                       class="{{ $errors->has('folio_recibo') ? 'invalido' : '' }}"
                                       value="{{ old('folio_recibo') }}">
                            </div>
                            @error('folio_recibo') <span class="frm-error">{{ $message }}</span> @enderror
                        </div>

                        @if(blank($seleccionado->periodicidad))
                            <div class="frm-campo">
                                <label for="periodicidad">Periodicidad <span class="frm-req">*</span></label>
                                <div class="frm-control">
                                    <select id="periodicidad" name="periodicidad" required
                                            class="{{ $errors->has('periodicidad') ? 'invalido' : '' }}">
                                        <option value="">Selecciona la periodicidad</option>
                                        @foreach($periodicidades as $valor => $texto)
                                            <option value="{{ $valor }}" @selected(old('periodicidad') === $valor)>{{ $texto }}</option>
                                        @endforeach
                                    </select>
                                    <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                                </div>
                                <span class="frm-ayuda">Este servicio no tenía periodicidad; se guardará para calcular el siguiente pago.</span>
                                @error('periodicidad') <span class="frm-error">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div class="frm-campo">
                            <label for="informacion_recibo">Información del recibo</label>
                            <div class="frm-control">
                                <textarea id="informacion_recibo" name="informacion_recibo" rows="3" maxlength="1000"
                                          class="{{ $errors->has('informacion_recibo') ? 'invalido' : '' }}"
                                          placeholder="Periodo facturado, número de contrato, notas…">{{ old('informacion_recibo') }}</textarea>
                            </div>
                            @error('informacion_recibo') <span class="frm-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>
            @endif
        </form>
    @endif
</div>

@push('scripts')
@if($seleccionado)
<script>
(function () {
    const esIngreso = @js($esIngreso);
    const base = {{ (float) $seleccionado->monto }};
    const campo = document.getElementById('monto_pagado');
    const aviso = document.getElementById('avisoMonto');
    const cuenta = document.getElementById('cuenta_financiera_id');
    const saldo = document.getElementById('saldoCuenta');
    const dinero = n => '$' + n.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    function revisarMonto() {
        const v = parseFloat(campo.value);
        if (!isNaN(v) && Math.round(v * 100) !== Math.round(base * 100)) {
            aviso.textContent = 'El monto es distinto al de la agenda (' + dinero(base) + '). Se actualizará con el monto real.';
            aviso.classList.add('visible');
        } else {
            aviso.classList.remove('visible');
        }
    }

    function revisarSaldo() {
        const opcion = cuenta.options[cuenta.selectedIndex];
        if (!opcion || !opcion.dataset.saldo) { saldo.classList.remove('visible'); return; }
        const actual = parseFloat(opcion.dataset.saldo);
        const monto = parseFloat(campo.value) || 0;
        const despues = esIngreso ? actual + monto : actual - monto;
        saldo.innerHTML = 'Saldo actual: <strong>' + dinero(actual) + '</strong> · Después del movimiento: <strong>' + dinero(despues) + '</strong>';
        saldo.classList.add('visible');
    }

    campo.addEventListener('input', () => { revisarMonto(); revisarSaldo(); });
    cuenta.addEventListener('change', revisarSaldo);
    revisarMonto();
    revisarSaldo();

    const form = document.getElementById('formRegistro');
    const btn = document.getElementById('btnGuardarRegistro');
    const texto = btn.textContent;
    form.addEventListener('submit', () => { btn.disabled = true; btn.textContent = 'Guardando...'; });
    window.addEventListener('pageshow', () => { btn.disabled = false; btn.textContent = texto; });
})();
</script>
@endif
@endpush

</x-layouts.panel>