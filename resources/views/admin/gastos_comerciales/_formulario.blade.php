@php
    $esEdicion = isset($gasto) && $gasto;

    $categorias = [
        'publicidad'    => 'Publicidad',
        'transporte'    => 'Transporte',
        'papeleria'     => 'Papelería',
        'servicios'     => 'Servicios',
        'mantenimiento' => 'Mantenimiento',
        'compras'       => 'Compras',
        'otros'         => 'Otros',
    ];

    $categoriaActual = old('categoria', $esEdicion ? $gasto->categoria : '');

    // Si la categoría guardada no está en la lista, se agrega para no perderla al editar.
    if ($categoriaActual && !isset($categorias[$categoriaActual])) {
        $categorias = [$categoriaActual => ucfirst($categoriaActual)] + $categorias;
    }
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

    <form method="POST" action="{{ $action }}" id="formGasto" novalidate>
        @csrf
        @if($esEdicion) @method('PUT') @endif

        <div class="frm-encabezado">
            <div>
                <h1>{{ $titulo }}</h1>
                <p>{{ $subtitulo }}</p>
            </div>
            <div class="frm-acciones">
                <a href="{{ route('admin.gastos_comerciales') }}" class="frm-btn-cancelar">Cancelar</a>
                <button type="submit" class="frm-btn-guardar" id="btnGuardarGasto">{{ $textoBoton }}</button>
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
                <div class="frm-card-titulo">Detalle del gasto</div>

                <div class="frm-campo">
                    <label for="concepto">Concepto</label>
                    <div class="frm-control">
                        <input type="text" name="concepto" id="concepto" maxlength="255" required
                               class="{{ $errors->has('concepto') ? 'invalido' : '' }}"
                               value="{{ old('concepto', $esEdicion ? $gasto->concepto : '') }}"
                               placeholder="Ej. Compra de macetas">
                    </div>
                    @error('concepto') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="categoria">Categoría</label>
                    <div class="frm-control">
                        <select name="categoria" id="categoria" required class="{{ $errors->has('categoria') ? 'invalido' : '' }}">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $clave => $nombre)
                                <option value="{{ $clave }}" @selected($categoriaActual === $clave)>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                    </div>
                    @error('categoria') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="descripcion">Descripción</label>
                    <div class="frm-control">
                        <textarea name="descripcion" id="descripcion" rows="5" maxlength="1000"
                                  class="{{ $errors->has('descripcion') ? 'invalido' : '' }}"
                                  placeholder="Detalles adicionales del gasto...">{{ old('descripcion', $esEdicion ? $gasto->descripcion : '') }}</textarea>
                    </div>
                    @error('descripcion') <span class="frm-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="frm-card">
                <div class="frm-card-titulo">Importe</div>

                <div class="frm-campo">
                    <label for="fecha">Fecha</label>
                    <div class="frm-control">
                        <input type="date" name="fecha" id="fecha" required
                               class="{{ $errors->has('fecha') ? 'invalido' : '' }}"
                               value="{{ old('fecha', $esEdicion ? $gasto->fecha->format('Y-m-d') : date('Y-m-d')) }}">
                    </div>
                    @error('fecha') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="monto">Monto (MXN)</label>
                    <div class="frm-control">
                        <input type="number" name="monto" id="monto" min="0.01" step="0.01" required placeholder="0.00"
                               class="{{ $errors->has('monto') ? 'invalido' : '' }}"
                               value="{{ old('monto', $esEdicion ? $gasto->monto : '') }}">
                    </div>
                    @error('monto') <span class="frm-error">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
(function () {
    const form = document.getElementById('formGasto');
    const btn = document.getElementById('btnGuardarGasto');
    const texto = btn.textContent;
    form.addEventListener('submit', () => { btn.disabled = true; btn.textContent = 'Guardando...'; });
    window.addEventListener('pageshow', () => { btn.disabled = false; btn.textContent = texto; });
})();
</script>
@endpush