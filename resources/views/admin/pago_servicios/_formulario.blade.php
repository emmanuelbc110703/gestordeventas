@php
    $esEdicion = isset($pago) && $pago;
    $opcionesServicio = ['Luz', 'Agua', 'Internet', 'Permiso', 'Otro'];
    $servicioActual = old('servicio', $esEdicion ? $pago->servicio : '');

    // Si el valor guardado no está en la lista, se agrega para no perderlo al editar.
    if ($servicioActual && !in_array($servicioActual, $opcionesServicio, true)) {
        array_unshift($opcionesServicio, $servicioActual);
    }

    $estadoActual = old('estado', $esEdicion ? $pago->estado : 'Pendiente');
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

        <div class="frm-grid">

            <div class="frm-card">
                <div class="frm-card-titulo">Información del servicio</div>

                <div class="frm-campo">
                    <label for="servicio">Servicio</label>
                    <div class="frm-control">
                        <select name="servicio" id="servicio" class="{{ $errors->has('servicio') ? 'invalido' : '' }}" required>
                            <option value="">Selecciona un servicio</option>
                            @foreach($opcionesServicio as $opcion)
                                <option value="{{ $opcion }}" @selected($servicioActual === $opcion)>{{ $opcion }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down frm-icono-select"></i>
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
                <div class="frm-card-titulo">Pago</div>

                <div class="frm-campo">
                    <label for="fecha_pago">Fecha de pago</label>
                    <div class="frm-control">
                        <input type="date" name="fecha_pago" id="fecha_pago" required
                               class="{{ $errors->has('fecha_pago') ? 'invalido' : '' }}"
                               value="{{ old('fecha_pago', $esEdicion ? $pago->fecha_pago?->format('Y-m-d') : '') }}">
                    </div>
                    @error('fecha_pago') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="fecha_vencimiento">Fecha de vencimiento</label>
                    <div class="frm-control">
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"
                               class="{{ $errors->has('fecha_vencimiento') ? 'invalido' : '' }}"
                               value="{{ old('fecha_vencimiento', $esEdicion ? $pago->fecha_vencimiento?->format('Y-m-d') : '') }}">
                    </div>
                    @error('fecha_vencimiento') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="monto">Monto</label>
                    <div class="frm-control">
                        <input type="number" name="monto" id="monto" min="0" step="0.01" placeholder="0.00"
                               class="{{ $errors->has('monto') ? 'invalido' : '' }}"
                               value="{{ old('monto', $esEdicion ? $pago->monto : '') }}">
                    </div>
                    @error('monto') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="estado">Estado</label>
                    <div class="frm-control">
                        <select name="estado" id="estado" required class="{{ $errors->has('estado') ? 'invalido' : '' }}">
                            <option value="Pendiente" @selected($estadoActual === 'Pendiente')>Pendiente</option>
                            <option value="Pagado" @selected($estadoActual === 'Pagado')>Pagado</option>
                        </select>
                        <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                    </div>
                    @error('estado') <span class="frm-error">{{ $message }}</span> @enderror
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
})();
</script>
@endpush