@php
    $esEdicion = isset($categoria) && $categoria;
    $enUso = $esEdicion && $categoria->estaEnUso();
    $tipoActual = old('tipo', $esEdicion ? $categoria->tipo : ($tipoInicial ?? ''));
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
    .cat-ayuda {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: var(--texto-suave);
    }
</style>

<div class="frm-pagina">

    <form method="POST" action="{{ $action }}" id="formCategoria" novalidate>
        @csrf
        @if($esEdicion) @method('PUT') @endif

        <div class="frm-encabezado">
            <div>
                <h1>{{ $titulo }}</h1>
                <p>{{ $subtitulo }}</p>
            </div>
            <div class="frm-acciones">
                <a href="{{ route('admin.categorias.index') }}" class="frm-btn-cancelar">Cancelar</a>
                <button type="submit" class="frm-btn-guardar" id="btnGuardarCategoria">{{ $textoBoton }}</button>
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
                <div class="frm-card-titulo">Datos de la categoría</div>

                <div class="frm-campo">
                    <label for="nombre">Nombre</label>
                    <div class="frm-control">
                        <input type="text" name="nombre" id="nombre" maxlength="255" required
                               class="{{ $errors->has('nombre') ? 'invalido' : '' }}"
                               value="{{ old('nombre', $esEdicion ? $categoria->nombre : '') }}"
                               placeholder="Ej. Orquídeas">
                    </div>
                    @error('nombre') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="tipo">Tipo</label>
                    <div class="frm-control">
                        <select name="tipo" id="tipo" required
                                class="{{ $errors->has('tipo') ? 'invalido' : '' }}"
                                @disabled($enUso)>
                            <option value="">Selecciona un tipo</option>
                            @foreach(\App\Models\Categoria::TIPOS as $clave => $etiquetas)
                                <option value="{{ $clave }}" @selected($tipoActual === $clave)>{{ $etiquetas['singular'] }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                    </div>
                    @if($enUso)
                        <span class="cat-ayuda">El tipo no se puede cambiar mientras la categoría esté en uso.</span>
                    @endif
                    @error('tipo') <span class="frm-error">{{ $message }}</span> @enderror
                </div>

                <div class="frm-campo">
                    <label for="descripcion">Descripción</label>
                    <div class="frm-control">
                        <textarea name="descripcion" id="descripcion" rows="5" maxlength="1000"
                                  class="{{ $errors->has('descripcion') ? 'invalido' : '' }}"
                                  placeholder="Para qué se usa esta categoría (opcional)...">{{ old('descripcion', $esEdicion ? $categoria->descripcion : '') }}</textarea>
                    </div>
                    @error('descripcion') <span class="frm-error">{{ $message }}</span> @enderror
                </div>
            </div>

            @if($esEdicion)
                <div class="frm-card">
                    <div class="frm-card-titulo">Uso actual</div>

                    <div class="frm-campo">
                        @if($enUso)
                            <p style="margin:0; font-size:15px; color:var(--texto);">
                                Esta categoría se utiliza en {{ $categoria->descripcionDeUsos() }}.
                            </p>
                            <span class="cat-ayuda">No se puede eliminar hasta que esos registros usen otra categoría.</span>
                        @else
                            <p style="margin:0; font-size:15px; color:var(--texto-suave);">
                                Ningún registro usa esta categoría por ahora.
                            </p>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </form>
</div>

@push('scripts')
<script>
(function () {
    const form = document.getElementById('formCategoria');
    const btn = document.getElementById('btnGuardarCategoria');
    const texto = btn.textContent;
    form.addEventListener('submit', () => { btn.disabled = true; btn.textContent = 'Guardando...'; });
    window.addEventListener('pageshow', () => { btn.disabled = false; btn.textContent = texto; });
})();
</script>
@endpush