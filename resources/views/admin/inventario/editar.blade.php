<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Bien - Orquídeas y más Los Amates</title>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        /* =========================
           BARRA SUPERIOR
        ========================= */

        .barra-superior {
            width: 100%;
            background: #6a1b9a;
            color: white;
            padding: 17px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);
        }

        .titulo-barra {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 21px;
            font-weight: bold;
        }

        .titulo-barra i {
            font-size: 24px;
        }

        .btn-regresar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 17px;
            background: white;
            color: #6a1b9a;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-regresar:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        /* =========================
           CONTENEDOR
        ========================= */

        .contenedor {
            width: 92%;
            max-width: 1000px;
            margin: 40px auto;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 30px;
        }

        .encabezado h1 {
            margin: 0 0 8px;
            color: #6a1b9a;
            font-size: 36px;
        }

        .encabezado p {
            margin: 0;
            color: #777;
            font-size: 16px;
        }

        /* =========================
           ERRORES
        ========================= */

        .errores {
            background: #fde8e8;
            color: #b42318;
            border: 1px solid #f5b5b5;
            border-radius: 10px;
            padding: 15px 18px;
            margin-bottom: 20px;
        }

        .errores ul {
            margin: 0;
            padding-left: 20px;
        }

        /* =========================
           FORMULARIO
        ========================= */

        .formulario-card {
            background: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .formulario-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .campo {
            display: flex;
            flex-direction: column;
        }

        .campo-completo {
            grid-column: 1 / -1;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #444;
        }

        label i {
            color: #6a1b9a;
            margin-right: 6px;
        }

        input,
        textarea {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d2d2d2;
            border-radius: 8px;
            font-size: 15px;
            font-family: Arial, sans-serif;
            outline: none;
            transition: 0.2s;
        }

        input:focus,
        textarea:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.08);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* =========================
           FOTO
        ========================= */

        .foto-area {
            border: 2px dashed #c9a7db;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            background: #faf7fc;
        }

        .vista-previa {
            width: 100%;
            max-width: 300px;
            height: 200px;
            margin: 0 auto 18px;
            border-radius: 10px;
            overflow: hidden;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vista-previa img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sin-imagen {
            color: #888;
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .sin-imagen i {
            font-size: 50px;
            color: #6a1b9a;
        }

        .input-imagen {
            display: none;
        }

        .btn-seleccionar-imagen {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: #6a1b9a;
            border: 2px solid #6a1b9a;
            padding: 11px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-seleccionar-imagen:hover {
            background: #6a1b9a;
            color: white;
        }

        .texto-foto {
            margin-top: 12px;
            color: #777;
            font-size: 13px;
        }

        /* =========================
           BOTÓN ACTUALIZAR
        ========================= */

        .acciones {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-actualizar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-width: 220px;
            padding: 14px 25px;
            border: none;
            border-radius: 9px;
            background: #6a1b9a;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(106, 27, 154, 0.25);
        }

        .btn-actualizar:hover {
            background: #4a126d;
            transform: translateY(-2px);
        }

        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 700px) {

            .barra-superior {
                flex-direction: column;
                gap: 14px;
                text-align: center;
            }

            .btn-regresar {
                width: 100%;
                justify-content: center;
            }

            .contenedor {
                width: 94%;
                margin: 30px auto;
            }

            .encabezado h1 {
                font-size: 29px;
            }

            .formulario-card {
                padding: 22px;
            }

            .formulario-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .campo-completo {
                grid-column: auto;
            }

            .btn-actualizar {
                width: 100%;
            }
        }

        @media (max-width: 400px) {

            .formulario-card {
                padding: 17px;
            }

            .encabezado h1 {
                font-size: 25px;
            }

            .titulo-barra {
                font-size: 18px;
            }
        }

    </style>

</head>

<body>

    <!-- =========================
         BARRA SUPERIOR
    ========================== -->

    <header class="barra-superior">

        <div class="titulo-barra">

            <i class="fa-solid fa-box"></i>

            Editar Bien

        </div>


        <a
            href="{{ route('admin.bienes') }}"
            class="btn-regresar"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Regresar

        </a>

    </header>


    <!-- =========================
         CONTENIDO
    ========================== -->

    <main class="contenedor">

        <div class="encabezado">

            <h1>

                <i class="fa-solid fa-pen-to-square"></i>

                Editar Bien

            </h1>

            <p>

                Modifica la información del bien seleccionado.

            </p>

        </div>


        <!-- =========================
             ERRORES
        ========================== -->

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
        ========================== -->

        <form
            action="{{ route('admin.inventario.actualizar', $inventario->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="formulario-card"
        >

            @csrf

            @method('PUT')


            <div class="formulario-grid">


                <!-- =========================
                     NOMBRE
                ========================== -->

                <div class="campo campo-completo">

                    <label for="nombre">

                        <i class="fa-solid fa-tag"></i>

                        Nombre del bien

                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre', $inventario->nombre) }}"
                        placeholder="Ej. Escritorio de oficina"
                        required
                    >

                </div>


                <!-- =========================
                     FOTO
                ========================== -->

                <div class="campo campo-completo">

                    <label>

                        <i class="fa-solid fa-image"></i>

                        Foto del bien

                    </label>


                    <div class="foto-area">

                        <div class="vista-previa">

                            @if($inventario->foto)

                                <img
                                    id="imagenPrevia"
                                    src="{{ asset('storage/' . $inventario->foto) }}"
                                    alt="{{ $inventario->nombre }}"
                                >

                                <div
                                    class="sin-imagen"
                                    id="sinImagen"
                                    style="display: none;"
                                >

                                    <i class="fa-regular fa-image"></i>

                                    <span>
                                        Vista previa de la imagen
                                    </span>

                                </div>

                            @else

                                <img
                                    id="imagenPrevia"
                                    src=""
                                    alt="Vista previa"
                                    style="display: none;"
                                >

                                <div
                                    class="sin-imagen"
                                    id="sinImagen"
                                >

                                    <i class="fa-regular fa-image"></i>

                                    <span>
                                        Sin imagen
                                    </span>

                                </div>

                            @endif

                        </div>


                        <label
                            for="foto"
                            class="btn-seleccionar-imagen"
                        >

                            <i class="fa-solid fa-folder-open"></i>

                            Cambiar imagen

                        </label>


                        <input
                            type="file"
                            id="foto"
                            name="foto"
                            class="input-imagen"
                            accept="image/jpg,image/jpeg,image/png,image/webp"
                        >


                        <div class="texto-foto">

                            Selecciona una nueva imagen solamente si deseas cambiarla.

                        </div>

                    </div>

                </div>


                <!-- =========================
                     DESCRIPCIÓN
                ========================== -->

                <div class="campo campo-completo">

                    <label for="descripcion">

                        <i class="fa-solid fa-align-left"></i>

                        Descripción

                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        placeholder="Describe las características del bien..."
                    >{{ old('descripcion', $inventario->descripcion) }}</textarea>

                </div>


                <!-- =========================
                     CANTIDAD
                ========================== -->

                <div class="campo">

                    <label for="cantidad">

                        <i class="fa-solid fa-boxes-stacked"></i>

                        Cantidad

                    </label>

                    <input
                        type="number"
                        id="cantidad"
                        name="cantidad"
                        min="0"
                        value="{{ old('cantidad', $inventario->cantidad) }}"
                        placeholder="Ej. 5"
                        required
                    >

                </div>


                <!-- =========================
                     PRECIO
                ========================== -->

                <div class="campo">

                    <label for="precio">

                        <i class="fa-solid fa-dollar-sign"></i>

                        Valor o costo

                    </label>

                    <input
                        type="number"
                        id="precio"
                        name="precio"
                        min="0"
                        step="0.01"
                        value="{{ old('precio', $inventario->precio) }}"
                        placeholder="Ej. 2500.00"
                        required
                    >

                </div>

            </div>


            <!-- =========================
                 ACTUALIZAR
            ========================== -->

            <div class="acciones">

                <button
                    type="submit"
                    class="btn-actualizar"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    Actualizar Bien

                </button>

            </div>

        </form>

    </main>


    <!-- =========================
         VISTA PREVIA
    ========================== -->

    <script>

        const inputFoto =
            document.getElementById('foto');

        const imagenPrevia =
            document.getElementById('imagenPrevia');

        const sinImagen =
            document.getElementById('sinImagen');


        inputFoto.addEventListener('change', function () {

            const archivo = this.files[0];


            if (archivo) {

                const lector = new FileReader();


                lector.onload = function (evento) {

                    imagenPrevia.src =
                        evento.target.result;

                    imagenPrevia.style.display =
                        'block';

                    sinImagen.style.display =
                        'none';

                };


                lector.readAsDataURL(archivo);

            }

        });

    </script>

</body>

</html>