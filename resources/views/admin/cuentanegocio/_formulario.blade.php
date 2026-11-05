@php
    $cuenta = $cuenta ?? null;
    $esEdicion = $cuenta !== null;

    $accion = $esEdicion
        ? route('admin.cuentas.update', $cuenta->id)
        : route('admin.cuentas.store');

    $tipoActual = old('tipo', $cuenta?->tipo ?? 'activo');
    $esPasivo = $tipoActual === 'pasivo';

    $fechaSaldo = old(
        'fecha_saldo_inicial',
        $cuenta?->fecha_saldo_inicial ? $cuenta->fecha_saldo_inicial->format('Y-m-d') : date('Y-m-d')
    );

    $activaActual = (string) old('activa', $cuenta ? (int) $cuenta->activa : 1);

    $tipos = \App\Models\CuentaFinanciera::TIPOS;
    $monedas = \App\Models\CuentaFinanciera::MONEDAS;
    $tiposPasivo = \App\Models\CuentaFinanciera::TIPOS_PASIVO;
    $direcciones = \App\Models\CuentaFinanciera::DIRECCIONES_PASIVO;
    $periodos = \App\Models\CuentaFinanciera::PERIODOS_INTERES;
@endphp

<x-formulario-estilos />

<style>
    .frm-control textarea {
        width: 100%;
        min-height: 110px;
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
    #bloquePasivo { grid-column: 1 / -1; }
    #bloquePasivo[hidden] { display: none; }
</style>
<div class="frm-pagina">
    <div class="frm-encabezado">
        <div>
            <h1>{{ $esEdicion ? 'Editar cuenta' : 'Nueva cuenta' }}</h1>
            <p>
                {{ $esEdicion
                    ? 'Modifica los datos de ' . $cuenta->nombre . '.'
                    : 'Registra una tarjeta o cuenta financiera del negocio.' }}
            </p>
        </div>
        <div class="frm-acciones">
            <a href="{{ route('admin.cuentas.index') }}" class="frm-btn-cancelar">Cancelar</a>
            <button type="submit" form="formCuenta" class="frm-btn-guardar" id="btnGuardar">
                {{ $esEdicion ? 'Guardar cambios' : 'Registrar cuenta' }}
            </button>
        </div>
    </div>
    @if(session('error'))
        <div class="frm-alerta">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="frm-alerta">Revisa los campos marcados e inténtalo de nuevo.</div>
    @endif
    <form id="formCuenta" action="{{ $accion }}" method="POST" novalidate>
        @csrf
        @if($esEdicion)
            @method('PUT')
        @endif
        <div class="frm-grid">
            <section class="frm-card">
                <h2 class="frm-card-titulo">Datos de la cuenta</h2>

                <div class="frm-campo">
                    <label for="nombre">Nombre <span class="frm-req">*</span></label>
                    <div class="frm-control">
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre', $cuenta?->nombre) }}"
                            maxlength="255"
                            placeholder="Ej. Tarjeta de débito BBVA"
                            class="{{ $errors->has('nombre') ? 'invalido' : '' }}"
                            required
                            {{ $esEdicion ? '' : 'autofocus' }}
                        >
                    </div>
                    @error('nombre') <span class="frm-error">{{ $message }}</span> @enderror
                </div>
                <div class="frm-fila">
                    <div class="frm-campo">
                        <label for="tipo">Tipo de cuenta <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <select id="tipo" name="tipo" class="{{ $errors->has('tipo') ? 'invalido' : '' }}" required>
                                @foreach($tipos as $clave => $texto)
                                    <option value="{{ $clave }}" @selected($tipoActual === $clave)>{{ $texto }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                        </div>
                        @error('tipo') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="frm-campo">
                        <label for="moneda">Moneda <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <select id="moneda" name="moneda" class="{{ $errors->has('moneda') ? 'invalido' : '' }}" required>
                                @foreach($monedas as $clave => $texto)
                                    <option value="{{ $clave }}" @selected(old('moneda', $cuenta?->moneda ?? 'MXN') === $clave)>{{ $texto }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                        </div>
                        @error('moneda') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="frm-fila">
                    <div class="frm-campo">
                        <label for="numero_cuenta">Número de cuenta</label>
                        <div class="frm-control">
                            <input
                                type="text"
                                id="numero_cuenta"
                                name="numero_cuenta"
                                value="{{ old('numero_cuenta', $cuenta?->numero_cuenta) }}"
                                maxlength="50"
                                class="{{ $errors->has('numero_cuenta') ? 'invalido' : '' }}"
                            >
                        </div>
                        @error('numero_cuenta') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="frm-campo">
                        <label for="activa">Estado</label>
                        <div class="frm-control">
                            <select id="activa" name="activa" class="{{ $errors->has('activa') ? 'invalido' : '' }}">
                                <option value="1" @selected($activaActual === '1')>Activa</option>
                                <option value="0" @selected($activaActual === '0')>Inactiva</option>
                            </select>
                            <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                        </div>
                        @error('activa') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </section>
            <section class="frm-card">
                <h2 class="frm-card-titulo">Saldo y notas</h2>
                <div class="frm-fila">
                    <div class="frm-campo">
                        <label for="saldo_inicial">Saldo inicial <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <input
                                type="number"
                                id="saldo_inicial"
                                name="saldo_inicial"
                                value="{{ old('saldo_inicial', $cuenta?->saldo_inicial) }}"
                                min="0"
                                step="0.01"
                                placeholder="0.00"
                                class="{{ $errors->has('saldo_inicial') ? 'invalido' : '' }}"
                                required
                            >
                        </div>
                        @error('saldo_inicial') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="frm-campo">
                        <label for="fecha_saldo_inicial">Fecha del saldo inicial <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <input
                                type="date"
                                id="fecha_saldo_inicial"
                                name="fecha_saldo_inicial"
                                value="{{ $fechaSaldo }}"
                                class="{{ $errors->has('fecha_saldo_inicial') ? 'invalido' : '' }}"
                                required
                            >
                        </div>
                        @error('fecha_saldo_inicial') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="frm-campo">
                    <label for="notas">Notas</label>
                    <div class="frm-control">
                        <textarea
                            id="notas"
                            name="notas"
                            rows="4"
                            maxlength="1000"
                            placeholder="Información adicional de la cuenta..."
                            class="{{ $errors->has('notas') ? 'invalido' : '' }}"
                        >{{ old('notas', $cuenta?->notas) }}</textarea>
                    </div>
                    @error('notas') <span class="frm-error">{{ $message }}</span> @enderror
                </div>
            </section>
            <section class="frm-card" id="bloquePasivo" {{ $esPasivo ? '' : 'hidden' }}>
                <h2 class="frm-card-titulo">Datos del pasivo</h2>

                <div class="frm-fila">
                    <div class="frm-campo">
                        <label for="tipo_pasivo">Tipo de pasivo <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <select id="tipo_pasivo" name="tipo_pasivo" class="{{ $errors->has('tipo_pasivo') ? 'invalido' : '' }}">
                                <option value="">Selecciona una opción</option>
                                @foreach($tiposPasivo as $clave => $texto)
                                    <option value="{{ $clave }}" @selected(old('tipo_pasivo', $cuenta?->tipo_pasivo) === $clave)>{{ $texto }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                        </div>
                        @error('tipo_pasivo') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="frm-campo">
                        <label for="direccion_pasivo">¿Se debe o se lo deben? <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <select id="direccion_pasivo" name="direccion_pasivo" class="{{ $errors->has('direccion_pasivo') ? 'invalido' : '' }}">
                                <option value="">Selecciona una opción</option>
                                @foreach($direcciones as $clave => $texto)
                                    <option value="{{ $clave }}" @selected(old('direccion_pasivo', $cuenta?->direccion_pasivo) === $clave)>{{ $texto }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                        </div>
                        @error('direccion_pasivo') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="frm-fila">
                    <div class="frm-campo">
                        <label for="tasa_interes">Tasa de interés (%) <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <input
                                type="number"
                                id="tasa_interes"
                                name="tasa_interes"
                                value="{{ old('tasa_interes', $cuenta?->tasa_interes) }}"
                                min="0"
                                step="0.01"
                                placeholder="0.00"
                                class="{{ $errors->has('tasa_interes') ? 'invalido' : '' }}"
                            >
                        </div>
                        @error('tasa_interes') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="frm-campo">
                        <label for="periodo_interes">Periodo de interés <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <select id="periodo_interes" name="periodo_interes" class="{{ $errors->has('periodo_interes') ? 'invalido' : '' }}">
                                <option value="">Selecciona una opción</option>
                                @foreach($periodos as $clave => $texto)
                                    <option value="{{ $clave }}" @selected(old('periodo_interes', $cuenta?->periodo_interes) === $clave)>{{ $texto }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                        </div>
                        @error('periodo_interes') <span class="frm-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </section>

        </div>
    </form>
</div>

@push('scripts')
<script>
    (function () {
        const formulario = document.getElementById('formCuenta');
        const boton = document.getElementById('btnGuardar');
        const tipo = document.getElementById('tipo');
        const bloquePasivo = document.getElementById('bloquePasivo');

        function actualizarPasivo() {
            bloquePasivo.hidden = tipo.value !== 'pasivo';
        }

        tipo.addEventListener('change', actualizarPasivo);
        actualizarPasivo();

        formulario.addEventListener('submit', function () {
            boton.disabled = true;
        });
        window.addEventListener('pageshow', function () {
            boton.disabled = false;
        });
    })();
</script>
@endpush