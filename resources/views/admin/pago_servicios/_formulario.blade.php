@php
    $esEdicion = isset($pago) && $pago;
    $sugerencias = ['Luz', 'Agua', 'Internet', 'Teléfono', 'Renta', 'Permiso'];

    $tipoActual = old('tipo_movimiento', $esEdicion ? ($pago->tipo_movimiento ?: 'egreso') : 'egreso');
    $cuentaActual = (string) old('cuenta_financiera_id', $esEdicion ? $pago->cuenta_financiera_id : '');
    $periodicidadActual = old('periodicidad', $esEdicion ? $pago->periodicidad : '');
@endphp

<style>
    .frm-control textarea {
        width: 100%;
        min-height: 120px;
        padding: 12px 14px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        color: var(--texto);
        outline: none;
        resize: vertical;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .frm-control textarea::placeholder { color: #9ca3af; }
    .frm-control textarea:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .frm-aviso {
        margin-bottom: 24px;
        padding: 14px 18px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        color: #9a3412;
        font-size: 14px;
    }
    .frm-aviso a { color: inherit; font-weight: 600; }
</style>

<div class="frm-pagina">

    <form method="POST" action="{{ $action }}" id="formPago" novalidate>
        @csrf
        @if($esEdicion) @method('PUT') @endif

        <div class="frm-encabezado">
            <div>
                <h1>{{ $titulo }}</h1>
                <p>{{ $subtitulo }}</p>
            </div>
            <div class="frm-acciones">
                <a href="{{ route('admin.pago_servicios.index') }}" class="frm-btn-cancelar">Cancelar</a>
                <button type="submit" class="frm-btn-guardar" id="btnGuardarPago">{{ $textoBoton }}</button>
            </div>
        </div>

        @if($errors->any())
            <div class="frm-alerta">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if($cuentas->isEmpty())
            <div class="frm-aviso">
                No hay cuentas activas del negocio. Primero
                <a href="{{ route('admin.cuentas.create') }}">registra una cuenta de tipo Activo</a>
                para poder programar pagos e ingresos.
            </div>
        @endif

        <div class="frm-grid">

            <div class="frm-card">
                <div class="frm-card-titulo">Información del servicio</div>

                <div class="frm-campo">
                    <label for="tipo_movimiento">Tipo <span class="frm-req">*</span></label>
                    <div class="frm-control">
                        <select name="tipo_movimiento" id="tipo_movimiento" required class="{{ $errors->has('tipo_movimiento') ? 'invalido' : '' }}">
                            @foreach($tiposMovimiento as $valor => $texto)
                                <option value="{{ $valor }}" @selected($tipoActual === $valor)>{{ $texto }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                    </div>
                    @error('tipo_movimiento') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="servicio">Servicio <span class="frm-req">*</span></label>
                    <div class="frm-control">
                        <input type="text" name="servicio" id="servicio" maxlength="255" required list="listaServicios"
                               class="{{ $errors->has('servicio') ? 'invalido' : '' }}"
                               value="{{ old('servicio', $esEdicion ? $pago->servicio : '') }}"
                               placeholder="Ej. Luz, Internet, Renta de local">
                        <datalist id="listaServicios">
                            @foreach($sugerencias as $sugerencia)
                                <option value="{{ $sugerencia }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    @error('servicio') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="descripcion">Descripción</label>
                    <div class="frm-control">
                        <input type="text" name="descripcion" id="descripcion" maxlength="255"
                               class="{{ $errors->has('descripcion') ? 'invalido' : '' }}"
                               value="{{ old('descripcion', $esEdicion ? $pago->descripcion : '') }}"
                               placeholder="Ej. Recibo CFE">
                    </div>
                    @error('descripcion') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="observaciones">Observaciones</label>
                    <div class="frm-control">
                        <textarea name="observaciones" id="observaciones" rows="5"
                                  class="{{ $errors->has('observaciones') ? 'invalido' : '' }}"
                                  placeholder="Información adicional...">{{ old('observaciones', $esEdicion ? $pago->observaciones : '') }}</textarea>
                    </div>
                    @error('observaciones') <span class="frm-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="frm-card">
                <div class="frm-card-titulo">Recurrencia y cuenta</div>

                <div class="frm-campo">
                    <label for="cuenta_financiera_id" id="etiquetaCuenta">Cuenta <span class="frm-req">*</span></label>
                    <div class="frm-control">
                        <select name="cuenta_financiera_id" id="cuenta_financiera_id" required class="{{ $errors->has('cuenta_financiera_id') ? 'invalido' : '' }}">
                            <option value="">Selecciona una cuenta</option>
                            @foreach($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}" @selected($cuentaActual === (string) $cuenta->id)>{{ $cuenta->nombre }} · {{ $cuenta->moneda }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                    </div>
                    <span class="frm-ayuda" id="ayudaCuenta"></span>
                    @error('cuenta_financiera_id') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="periodicidad">Periodicidad <span class="frm-req">*</span></label>
                    <div class="frm-control">
                        <select name="periodicidad" id="periodicidad" required class="{{ $errors->has('periodicidad') ? 'invalido' : '' }}">
                            <option value="">Selecciona la periodicidad</option>
                            @foreach($periodicidades as $valor => $texto)
                                <option value="{{ $valor }}" @selected($periodicidadActual === $valor)>{{ $texto }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                    </div>
                    @error('periodicidad') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-fila">
                    <div class="frm-campo">
                        <label for="fecha_pago">Próxima fecha <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <input type="date" name="fecha_pago" id="fecha_pago" required
                                   class="{{ $errors->has('fecha_pago') ? 'invalido' : '' }}"
                                   value="{{ old('fecha_pago', $esEdicion ? $pago->fecha_pago?->format('Y-m-d') : '') }}">
                        </div>
                        @error('fecha_pago') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="frm-campo">
                        <label for="fecha_vencimiento">Vencimiento</label>
                        <div class="frm-control">
                            <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"
                                   class="{{ $errors->has('fecha_vencimiento') ? 'invalido' : '' }}"
                                   value="{{ old('fecha_vencimiento', $esEdicion ? $pago->fecha_vencimiento?->format('Y-m-d') : '') }}">
                        </div>
                        @error('fecha_vencimiento') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="frm-campo">
                    <label for="monto">Monto esperado <span class="frm-req">*</span></label>
                    <div class="frm-control">
                        <input type="number" name="monto" id="monto" min="0.01" step="0.01" placeholder="0.00" required
                               class="{{ $errors->has('monto') ? 'invalido' : '' }}"
                               value="{{ old('monto', $esEdicion ? $pago->monto : '') }}">
                    </div>
                    <span class="frm-ayuda">Al registrar el recibo se captura el monto real y se programa el siguiente periodo automáticamente.</span>
                    @error('monto') <span class="frm-error">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
(function () {
    const form = document.getElementById('formPago');
    const btn = document.getElementById('btnGuardarPago');
    const texto = btn.textContent;
    form.addEventListener('submit', () => { btn.disabled = true; btn.textContent = 'Guardando...'; });
    window.addEventListener('pageshow', () => { btn.disabled = false; btn.textContent = texto; });

    const tipo = document.getElementById('tipo_movimiento');
    const etiqueta = document.getElementById('etiquetaCuenta');
    const ayuda = document.getElementById('ayudaCuenta');
    function actualizarTipo() {
        const ingreso = tipo.value === 'ingreso';
        etiqueta.innerHTML = (ingreso ? 'Cuenta de destino' : 'Cuenta de origen') + ' <span class="frm-req">*</span>';
        ayuda.textContent = ingreso
            ? 'El dinero se depositará en esta cuenta al registrar el cobro.'
            : 'El dinero se descontará de esta cuenta al registrar el pago.';
    }
    tipo.addEventListener('change', actualizarTipo);
    actualizarTipo();
})();
</script>
@endpush