<x-layouts.panel
    titulo="Agregar Bien"
    :regresar="route('admin.bienes')"
    :migas="[
        ['texto' => 'Administración', 'url' => route('admin.dashboard')],
        ['texto' => 'Inventario', 'url' => route('admin.inventario')],
        ['texto' => 'Bienes', 'url' => route('admin.bienes')],
        ['texto' => 'Nuevo'],
    ]"
>

@push('estilos')
<style>
    .pagina-editar {
        padding: 48px 0 56px;
    }

    /* ===== ENCABEZADO ===== */
    .editar-encabezado {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        padding-bottom: 28px;
        margin-bottom: 32px;
        border-bottom: 1px solid var(--borde);
    }
    .editar-titulo {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }
    .editar-titulo h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--texto);
    }
    .editar-subtitulo {
        margin: 8px 0 0;
        font-size: 15px;
        color: var(--texto-suave);
    }

    .editar-acciones {
        display: flex;
        gap: 12px;
    }
    .btn-cancelar,
    .btn-guardar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        height: 44px;
        padding: 0 22px;
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .btn-cancelar {
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--texto);
    }
    .btn-cancelar:hover {
        border-color: #c4b5fd;
        background: #fcfbff;
    }
    .btn-guardar {
        background: var(--primario);
        border: 1px solid var(--primario);
        color: #fff;
    }
    .btn-guardar:hover {
        background: var(--primario-oscuro);
        border-color: var(--primario-oscuro);
    }

    /* ===== ERRORES ===== */
    .errores {
        margin-bottom: 24px;
        padding: 16px 20px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b42318;
        font-size: 14px;
    }
    .errores ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    /* ===== LAYOUT DE DOS COLUMNAS ===== */
    .editar-grid {
        display: grid;
        grid-template-columns: 4fr 5fr;
        gap: 48px;
        align-items: start;
    }
    .tarjeta {
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
    }

    /* ===== FOTOGRAFÍA ===== */
    .tarjeta-foto {
        padding: 32px;
    }
    .foto-cabecera {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 12px;
        margin-bottom: 24px;
    }
    .foto-cabecera h2 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--texto);
    }
    .foto-dimensiones {
        font-size: 15px;
        color: #9ca3af;
    }
    .foto-vista {
        width: 100%;
        height: 420px;
        background: #f1f4f9;
        border: 1px solid var(--borde);
        overflow: hidden;
    }
    .foto-vista img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .foto-vacia {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #9ca3af;
        font-size: 14px;
    }
    .foto-vacia i {
        font-size: 40px;
        color: #c4b5fd;
    }
    .foto-pie {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
    }
    .foto-archivo {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        font-size: 14px;
        color: var(--texto-suave);
    }
    .btn-cambiar-imagen {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        height: 44px;
        padding: 0 20px;
        background: #f9fafb;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        font-weight: 500;
        color: var(--texto);
        white-space: nowrap;
        cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s ease;
    }
    .btn-cambiar-imagen:hover {
        border-color: #c4b5fd;
        background: #fcfbff;
    }
    .input-oculto { display: none; }

    /* ===== FORMULARIO ===== */
    .tarjeta-form {
        padding: 44px;
    }
    .campo {
        margin-bottom: 28px;
    }
    .campo:last-child { margin-bottom: 0; }
    .campo-fila {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 28px;
    }
    .campo-fila .campo { margin-bottom: 0; }

    .campo label {
        display: block;
        margin-bottom: 10px;
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
    }
    .campo-control {
        position: relative;
    }
    .campo-control input,
    .campo-control select,
    .campo-control textarea {
        width: 100%;
        height: 52px;
        padding: 0 16px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        color: var(--texto);
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .campo-control textarea {
        height: auto;
        min-height: 150px;
        padding: 16px;
        line-height: 1.6;
        resize: vertical;
    }
    .campo-control input:focus,
    .campo-control select:focus,
    .campo-control textarea:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .campo-control select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 44px;
        cursor: pointer;
    }
    .campo-control .icono-select {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 12px;
        color: var(--texto-suave);
        pointer-events: none;
    }
    .con-prefijo input { padding-left: 38px; }
    .prefijo {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 15px;
        pointer-events: none;
    }
    .con-sufijo input { padding-right: 70px; }
    .sufijo {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 15px;
        pointer-events: none;
    }

    /* ===== RESPONSIVO ===== */
    @media (max-width: 950px) {
        .editar-grid { grid-template-columns: 1fr; gap: 32px; }
        .foto-vista { height: 340px; }
    }
    @media (max-width: 650px) {
        .pagina-editar { padding: 28px 0 40px; }
        .editar-encabezado { flex-direction: column; align-items: stretch; }
        .editar-titulo h1 { font-size: 26px; }
        .editar-acciones { width: 100%; }
        .btn-cancelar, .btn-guardar { flex: 1; }
        .tarjeta-foto, .tarjeta-form { padding: 22px; }
        .campo-fila { grid-template-columns: 1fr; gap: 28px; }
        .foto-vista { height: 260px; }
        .foto-pie { flex-direction: column; align-items: stretch; }
        .btn-cambiar-imagen { justify-content: center; }
    }
</style>
@endpush

<div class="pagina-editar">

    <!-- =========================
         ENCABEZADO
    ========================= -->
    <div class="editar-encabezado">
        <div>
            <div class="editar-titulo">
                <h1>Agregar Elemento</h1>
            </div>
            <p class="editar-subtitulo">Ingresa los datos esenciales y la fotografía del nuevo producto en catálogo.</p>
        </div>

        <div class="editar-acciones">
            <a href="{{ route('admin.bienes') }}" class="btn-cancelar">Cancelar</a>
            <!-- El botón está fuera del form, por eso usa el atributo form -->
            <button type="submit" form="formAgregar" class="btn-guardar">
                <i class="fa-solid fa-check"></i>
                Guardar Bien
            </button>
        </div>
    </div>

    <!-- =========================
         ERRORES
    ========================= -->
    @if ($errors->any())
        <div class="errores">
            <strong>Hay algunos errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- =========================
         FORMULARIO
    ========================= -->
    <form
        id="formAgregar"
        action="{{ route('admin.bienes.guardar') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="editar-grid">

            <!-- ===== COLUMNA IZQUIERDA: FOTOGRAFÍA ===== -->
            <div class="tarjeta tarjeta-foto">
                <div class="foto-cabecera">
                    <h2>Fotografía del producto</h2>
                    <span class="foto-dimensiones" id="fotoDimensiones"></span>
                </div>

                <div class="foto-vista">
                    <img
                        id="imagenPrevia"
                        src=""
                        alt="Vista previa del bien"
                        style="display: none;"
                    >
                    <div class="foto-vacia" id="sinImagen">
                        <i class="fa-regular fa-image"></i>
                        <span>Sin imagen</span>
                    </div>
                </div>

                <div class="foto-pie">
                    <span class="foto-archivo" id="nombreArchivo">Ningún archivo</span>

                    <label for="foto" class="btn-cambiar-imagen">
                        <i class="fa-solid fa-camera"></i>
                        Seleccionar imagen
                    </label>
                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        class="input-oculto"
                        accept="image/jpg,image/jpeg,image/png,image/webp"
                    >
                </div>
            </div>

            <!-- ===== COLUMNA DERECHA: DATOS ===== -->
            <div class="tarjeta tarjeta-form">

                <!-- Nombre -->
                <div class="campo">
                    <label for="nombre">Nombre del bien *</label>
                    <div class="campo-control">
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            placeholder="Ej. Escritorio de oficina"
                            required
                        >
                    </div>
                </div>

                <!-- Categoría y precio -->
                <div class="campo-fila">
                    <div class="campo">
                        <label for="categoria">Categoría *</label>
                        <div class="campo-control">
                            <select id="categoria" name="categoria">
                                @php $categoriaActual = old('categoria', ''); @endphp
                                <option value="" disabled {{ $categoriaActual === '' ? 'selected' : '' }}>Selecciona una categoría</option>
                                <option value="Accesorios de Baño" {{ $categoriaActual === 'Accesorios de Baño' ? 'selected' : '' }}>Accesorios de Baño</option>
                                <option value="Muebles" {{ $categoriaActual === 'Muebles' ? 'selected' : '' }}>Muebles</option>
                                <option value="Decoración" {{ $categoriaActual === 'Decoración' ? 'selected' : '' }}>Decoración</option>
                            </select>
                            <i class="fa-solid fa-chevron-down icono-select"></i>
                        </div>
                    </div>

                    <div class="campo">
                        <label for="precio">Precio Unitario (MXN) *</label>
                        <div class="campo-control con-prefijo">
                            <span class="prefijo">$</span>
                            <input
                                type="number"
                                id="precio"
                                name="precio"
                                min="0"
                                step="0.01"
                                value="{{ old('precio') }}"
                                placeholder="0.00"
                                required
                            >
                        </div>
                    </div>
                </div>

                <!-- Cantidad -->
                <div class="campo">
                    <label for="cantidad">Cantidad disponible *</label>
                    <div class="campo-control con-sufijo">
                        <input
                            type="number"
                            id="cantidad"
                            name="cantidad"
                            min="0"
                            value="{{ old('cantidad') }}"
                            placeholder="0"
                            required
                        >
                        <span class="sufijo">unid.</span>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="campo">
                    <label for="descripcion">Descripción</label>
                    <div class="campo-control">
                        <textarea
                            id="descripcion"
                            name="descripcion"
                            placeholder="Describe las características del bien..."
                        >{{ old('descripcion') }}</textarea>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
    const inputFoto = document.getElementById('foto');
    const imagenPrevia = document.getElementById('imagenPrevia');
    const sinImagen = document.getElementById('sinImagen');
    const nombreArchivo = document.getElementById('nombreArchivo');
    const fotoDimensiones = document.getElementById('fotoDimensiones');

    // Muestra las dimensiones reales de la imagen (ancho × alto)
    imagenPrevia.addEventListener('load', function () {
        if (imagenPrevia.naturalWidth) {
            fotoDimensiones.textContent = imagenPrevia.naturalWidth + ' × ' + imagenPrevia.naturalHeight + ' px';
        }
    });

    // Vista previa al elegir una imagen
    inputFoto.addEventListener('change', function () {
        const archivo = this.files[0];

        if (archivo) {
            const lector = new FileReader();
            lector.onload = function (evento) {
                imagenPrevia.src = evento.target.result;
                imagenPrevia.style.display = 'block';
                sinImagen.style.display = 'none';
                nombreArchivo.textContent = archivo.name;
            };
            lector.readAsDataURL(archivo);
        } else {
            // Si se cancela la selección, vuelve al estado inicial
            imagenPrevia.removeAttribute('src');
            imagenPrevia.style.display = 'none';
            sinImagen.style.display = 'flex';
            nombreArchivo.textContent = 'Ningún archivo';
            fotoDimensiones.textContent = '';
        }
    });
</script>
@endpush

</x-layouts.panel>