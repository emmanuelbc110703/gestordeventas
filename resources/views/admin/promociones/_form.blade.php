@php
    $p = $promocion ?? null;
    $seleccionados = collect(old('inventarios', $p ? $p->inventarios->pluck('id')->all() : []))->map(fn ($i) => (int) $i)->all();
    $tipo = old('tipo_descuento', $p->tipo_descuento ?? 'porcentaje');
@endphp

@if ($errors->any())
    <div class="errores">
        <strong>Hay algunos errores:</strong>
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="tarjeta">
    <div class="campo">
        <label class="etiqueta" for="nombre">Nombre de la promoción *</label>
        <input type="text" id="nombre" name="nombre" maxlength="120" required
               value="{{ old('nombre', $p->nombre ?? '') }}" placeholder="Ej. Descuento de temporada">
    </div>

    <div class="campo">
        <label class="etiqueta" for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" placeholder="Describe las condiciones de la promoción...">{{ old('descripcion', $p->descripcion ?? '') }}</textarea>
    </div>

    <div class="fila-2">
        <div class="campo">
            <label class="etiqueta" for="tipo_descuento">Tipo de descuento *</label>
            <select id="tipo_descuento" name="tipo_descuento" required>
                <option value="porcentaje" @selected($tipo === 'porcentaje')>Porcentaje (%)</option>
                <option value="monto_fijo" @selected($tipo === 'monto_fijo')>Monto fijo ($)</option>
            </select>
        </div>
        <div class="campo">
            <label class="etiqueta" for="valor">Valor del descuento *</label>
            <div class="valor-wrap">
                <span class="simbolo" id="simboloValor">{{ $tipo === 'porcentaje' ? '%' : '$' }}</span>
                <input type="number" id="valor" name="valor" min="0.01" step="0.01" required
                       value="{{ old('valor', $p->valor ?? '') }}" placeholder="Ej. 15">
            </div>
        </div>
    </div>

    <div class="fila-2">
        <div class="campo">
            <label class="etiqueta" for="fecha_inicio">Fecha de inicio *</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required
                   value="{{ old('fecha_inicio', optional($p?->fecha_inicio)->format('Y-m-d')) }}">
        </div>
        <div class="campo">
            <label class="etiqueta" for="fecha_fin">Fecha de finalización *</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required
                   value="{{ old('fecha_fin', optional($p?->fecha_fin)->format('Y-m-d')) }}">
        </div>
    </div>

    <div class="campo">
        <label class="etiqueta">Estado</label>
        <div class="check-linea">
            <input type="hidden" name="activa" value="0">
            <input type="checkbox" id="activa" name="activa" value="1"
                   {{ old('activa', $p ? ($p->activa ? '1' : '0') : '1') == '1' ? 'checked' : '' }}>
            <label for="activa">Promoción activa (disponible para aplicarse en ventas)</label>
        </div>
    </div>

    <div class="campo">
        <label class="etiqueta">Aplica a productos y servicios</label>
        <div class="lista-productos">
            @forelse($inventarios as $item)
                <label>
                    <input type="checkbox" name="inventarios[]" value="{{ $item->id }}"
                           {{ in_array($item->id, $seleccionados, true) ? 'checked' : '' }}>
                    {{ $item->nombre }}
                    <small>{{ $item->tipo === 'servicio' ? 'Servicio' : 'Bien' }} · $ {{ number_format($item->precio, 2) }}</small>
                </label>
            @empty
                <div class="vacio">No hay elementos en el inventario.</div>
            @endforelse
        </div>
        <p class="ayuda">Selecciona los elementos a los que se aplicará el descuento.</p>
    </div>

    <div class="acciones-pie">
        <a href="{{ route('admin.promociones') }}" class="btn-p-sec">Cancelar</a>
        <button type="submit" class="btn-p">
            <i class="fa-solid fa-check"></i> {{ $textoBoton }}
        </button>
    </div>
</div>

<script>
    document.getElementById('tipo_descuento').addEventListener('change', function () {
        document.getElementById('simboloValor').textContent = this.value === 'porcentaje' ? '%' : '$';
    });
</script>