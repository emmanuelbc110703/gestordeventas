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
                    <div style="position:relative;">
                        <select name="servicio" id="servicio" class="frm-control" required>
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
                    <input type="text" name="descripcion" id="descripcion" class="frm-control" maxlength="255"
                           value="{{ old('descripcion', $esEdicion ? $pago->descripcion : '') }}"
                           placeholder="Ej. Recibo CFE">
                    @error('descripcion') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="observaciones">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="frm-control" rows="5"
                              placeholder="Información adicional...">{{ old('observaciones', $esEdicion ? $pago->observaciones : '') }}</textarea>
                    @error('observaciones') <span class="frm-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="frm-card">
                <div class="frm-card-titulo">Pago</div>

                <div class="frm-campo">
                    <label for="fecha_pago">Fecha de pago</label>
                    <input type="date" name="fecha_pago" id="fecha_pago" class="frm-control" required
                           value="{{ old('fecha_pago', $esEdicion ? $pago->fecha_pago?->format('Y-m-d') : '') }}">
                    @error('fecha_pago') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="fecha_vencimiento">Fecha de vencimiento</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="frm-control"
                           value="{{ old('fecha_vencimiento', $esEdicion ? $pago->fecha_vencimiento?->format('Y-m-d') : '') }}">
                    @error('fecha_vencimiento') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="monto">Monto</label>
                    <input type="number" name="monto" id="monto" class="frm-control" min="0" step="0.01"
                           value="{{ old('monto', $esEdicion ? $pago->monto : '') }}" placeholder="0.00">
                    @error('monto') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="estado">Estado</label>
                    <div style="position:relative;">
                        <select name="estado" id="estado" class="frm-control" required>
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