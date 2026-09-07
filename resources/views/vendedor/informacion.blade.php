<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mi información - Orquídeas y más Los Amates</title>

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
            background-color: #f4f4f4;
        }


        /* =========================
           ENCABEZADO
        ========================= */

        .encabezado {
            background-color: #6a1b9a;
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
        }

        .encabezado h1 {
            margin: 5px 0;
        }

        .encabezado p {
            margin: 5px 0;
        }


        /* =========================
           BOTÓN REGRESAR
        ========================= */

        .boton-regresar {
            position: absolute;
            top: 20px;
            left: 25px;

            background-color: white;
            color: #6a1b9a;

            text-decoration: none;

            padding: 10px 15px;

            border-radius: 8px;

            font-weight: bold;

            transition: 0.3s;
        }

        .boton-regresar:hover {
            background-color: #4a126d;
            color: white;
        }


        /* =========================
           CONTENEDOR
        ========================= */

        .contenedor {
            width: 90%;
            max-width: 750px;

            margin: 40px auto;
        }

        .tarjeta {
            background-color: white;

            border-radius: 15px;

            padding: 35px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.15);
        }


        /* =========================
           PERFIL
        ========================= */

        .perfil {
            text-align: center;
            margin-bottom: 30px;
        }

        .perfil-avatar {
            position: relative;

            width: 100px;
            height: 115px;

            margin: auto;
            margin-bottom: 15px;
        }


        /* =========================
           AVATAR
        ========================= */

        .avatar {
            width: 100px;
            height: 100px;

            border-radius: 50%;

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 42px;
            font-weight: bold;

            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }


        /* =========================
           BOTÓN EDITAR FOTO
        ========================= */

        .boton-editar-foto {
            position: absolute;

            bottom: 0;
            right: -5px;

            width: 36px;
            height: 36px;

            border: none;
            border-radius: 50%;

            background-color: white;
            color: #6a1b9a;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, 0.25);

            cursor: pointer;

            font-size: 15px;

            transition: 0.3s;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .boton-editar-foto:hover {
            background-color: #4a126d;
            color: white;

            transform: scale(1.1);
        }


        /* =========================
           MENÚ FOTO
        ========================= */

        .menu-foto {
            display: none;

            position: absolute;

            top: 105px;
            left: 50%;

            transform: translateX(-50%);

            width: 190px;

            background-color: white;

            border-radius: 10px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.2);

            overflow: hidden;

            z-index: 100;
        }

        .menu-foto.mostrar {
            display: block;
        }

        .menu-foto button {
            width: 100%;

            padding: 12px 15px;

            border: none;

            background-color: white;

            color: #444;

            text-align: left;

            cursor: pointer;

            font-size: 14px;

            transition: 0.3s;
        }

        .menu-foto button:hover {
            background-color: #f0e4f5;
            color: #6a1b9a;
        }

        .menu-foto button i {
            width: 25px;

            color: #6a1b9a;
        }


        /* =========================
           ELIMINAR FOTO
        ========================= */

        .boton-eliminar-foto {
            color: #d32f2f !important;
        }

        .boton-eliminar-foto i {
            color: #d32f2f !important;
        }

        .boton-eliminar-foto:hover {
            background-color: #ffebee !important;
            color: #b71c1c !important;
        }

        .boton-eliminar-foto:hover i {
            color: #b71c1c !important;
        }


        /* =========================
           PANEL DE COLORES
        ========================= */

        .panel-colores {
            display: none;

            position: absolute;

            top: 105px;
            left: 50%;

            transform: translateX(-50%);

            width: 220px;

            background-color: white;

            border-radius: 10px;

            padding: 15px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.2);

            z-index: 101;
        }

        .panel-colores.mostrar {
            display: block;
        }

        .panel-colores p {
            margin: 0 0 12px;

            color: #444;

            font-size: 14px;

            font-weight: bold;
        }

        .colores {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 12px;
        }

        .color-opcion {
            width: 45px;
            height: 45px;

            border: 3px solid transparent;

            border-radius: 50%;

            cursor: pointer;

            transition: 0.3s;
        }

        .color-opcion:hover {
            transform: scale(1.12);

            border-color: #333;
        }


        /* =========================
           FORMULARIO FOTO
        ========================= */

        .formulario-oculto {
            display: none;
        }


        /* =========================
           TEXTO PERFIL
        ========================= */

        .perfil h2 {
            color: #333;

            margin-bottom: 5px;
        }

        .perfil p {
            color: #777;

            margin: 0;
        }


        /* =========================
           INFORMACIÓN
        ========================= */

        .informacion {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 18px;

            margin-top: 30px;
        }

        .dato {
            background-color: #f8f8f8;

            padding: 18px;

            border-radius: 10px;

            border-left: 5px solid #6a1b9a;
        }

        .dato i {
            color: #6a1b9a;

            margin-right: 8px;
        }

        .dato strong {
            display: block;

            color: #555;

            margin-bottom: 7px;
        }

        .dato span {
            color: #222;

            word-break: break-word;
        }


        /* =========================
           BOTÓN EDITAR INFORMACIÓN
        ========================= */

        .contenedor-boton {
            text-align: center;

            margin-top: 30px;
        }

        .boton-editar {
            display: inline-block;

            background-color: #6a1b9a;

            color: white;

            padding: 13px 25px;

            border-radius: 8px;

            text-decoration: none;

            font-weight: bold;

            transition: 0.3s;
        }

        .boton-editar:hover {
            background-color: #4a126d;

            transform: translateY(-2px);
        }

        .boton-editar i {
            margin-right: 8px;
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 600px) {

            .informacion {
                grid-template-columns: 1fr;
            }

            .boton-regresar {
                position: static;

                display: inline-block;

                margin-bottom: 15px;
            }

            .encabezado {
                padding: 20px;
            }

            .tarjeta {
                padding: 25px 20px;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         ENCABEZADO
    ========================= -->

    <div class="encabezado">

        <a
            href="{{ route('vendedor.dashboard') }}"
            class="boton-regresar"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Regresar

        </a>


        <h1>
            Mi información
        </h1>


        <p>
            Datos de tu cuenta
        </p>

    </div>



    <!-- =========================
         CONTENIDO
    ========================= -->

    <div class="contenedor">

        <div class="tarjeta">


            <!-- =========================
                 PERFIL
            ========================= -->

            <div class="perfil">


                <div class="perfil-avatar">


                    <!-- AVATAR -->

                    <div
                        class="avatar"
                        style="
                            background-color:
                            {{ auth()->user()->color_perfil ?? '#6a1b9a' }};
                        "
                    >

                        @if(auth()->user()->foto_perfil)

                            <img
                                src="{{ asset('storage/' . auth()->user()->foto_perfil) }}"
                                alt="Foto de perfil"
                            >

                        @else

                            {{ strtoupper(
                                substr(auth()->user()->name, 0, 1)
                            ) }}

                        @endif

                    </div>



                    <!-- =========================
                         BOTÓN EDITAR
                    ========================= -->

                    <button
                        type="button"
                        class="boton-editar-foto"
                        id="botonEditarFoto"
                        title="Editar foto de perfil"
                    >

                        <i class="fa-solid fa-pen"></i>

                    </button>



                    <!-- =========================
                         MENÚ
                    ========================= -->

                    <div
                        class="menu-foto"
                        id="menuFoto"
                    >


                        <!-- SUBIR FOTO -->

                        <button
                            type="button"
                            id="subirFoto"
                        >

                            <i class="fa-solid fa-camera"></i>

                            Subir foto

                        </button>



                        <!-- CAMBIAR COLOR -->

                        <button
                            type="button"
                            id="cambiarColor"
                        >

                            <i class="fa-solid fa-palette"></i>

                            Cambiar color

                        </button>



                        <!-- ELIMINAR FOTO -->

                        @if(auth()->user()->foto_perfil)

                            <form
                                action="{{ route('vendedor.foto.eliminar') }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="boton-eliminar-foto"
                                    onclick="
                                        return confirm(
                                            '¿Seguro que quieres eliminar tu foto de perfil?'
                                        );
                                    "
                                >

                                    <i class="fa-solid fa-trash"></i>

                                    Eliminar foto

                                </button>

                            </form>

                        @endif


                    </div>



                    <!-- =========================
                         PANEL DE COLORES
                    ========================= -->

                    <div
                        class="panel-colores"
                        id="panelColores"
                    >

                        <form
                            id="formularioColor"
                            action="{{ route('vendedor.color.actualizar') }}"
                            method="POST"
                        >

                            @csrf


                            <input
                                type="hidden"
                                name="color_perfil"
                                id="colorPerfilSeleccionado"
                            >


                            <p>
                                Selecciona un color
                            </p>


                            <div class="colores">


                                <!-- MORADO -->

                                <button
                                    type="button"
                                    class="color-opcion"
                                    data-color="#6a1b9a"
                                    style="background-color:#6a1b9a;"
                                    title="Morado"
                                ></button>



                                <!-- AZUL -->

                                <button
                                    type="button"
                                    class="color-opcion"
                                    data-color="#2196F3"
                                    style="background-color:#2196F3;"
                                    title="Azul"
                                ></button>



                                <!-- ROJO -->

                                <button
                                    type="button"
                                    class="color-opcion"
                                    data-color="#F44336"
                                    style="background-color:#F44336;"
                                    title="Rojo"
                                ></button>



                                <!-- VERDE -->

                                <button
                                    type="button"
                                    class="color-opcion"
                                    data-color="#4CAF50"
                                    style="background-color:#4CAF50;"
                                    title="Verde"
                                ></button>



                                <!-- NARANJA -->

                                <button
                                    type="button"
                                    class="color-opcion"
                                    data-color="#FF9800"
                                    style="background-color:#FF9800;"
                                    title="Naranja"
                                ></button>



                                <!-- OSCURO -->

                                <button
                                    type="button"
                                    class="color-opcion"
                                    data-color="#263238"
                                    style="background-color:#263238;"
                                    title="Oscuro"
                                ></button>


                            </div>

                        </form>

                    </div>



                    <!-- =========================
                         FORMULARIO FOTO
                    ========================= -->

                    <form
                        id="formularioFoto"
                        class="formulario-oculto"
                        action="{{ route('vendedor.foto.actualizar') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        <input
                            type="file"
                            id="inputFotoPerfil"
                            name="foto_perfil"
                            accept="image/*"
                        >

                    </form>


                </div>



                <!-- =========================
                     NOMBRE
                ========================= -->

                <h2>

                    {{ auth()->user()->name }}

                    {{ auth()->user()->apellido }}

                </h2>


                <p>
                    Vendedor de Orquídeas y más "Los Amates"
                </p>


            </div>



            <!-- =========================
                 INFORMACIÓN
            ========================= -->

            <div class="informacion">


                <div class="dato">

                    <strong>

                        <i class="fa-solid fa-user"></i>

                        Nombre

                    </strong>

                    <span>
                        {{ auth()->user()->name }}
                    </span>

                </div>



                <div class="dato">

                    <strong>

                        <i class="fa-solid fa-user"></i>

                        Apellidos

                    </strong>

                    <span>
                        {{ auth()->user()->apellido }}
                    </span>

                </div>



                <div class="dato">

                    <strong>

                        <i class="fa-solid fa-envelope"></i>

                        Correo electrónico

                    </strong>

                    <span>
                        {{ auth()->user()->email }}
                    </span>

                </div>



                <div class="dato">

                    <strong>

                        <i class="fa-solid fa-phone"></i>

                        Teléfono

                    </strong>

                    <span>
                        {{ auth()->user()->telefono ?? 'No registrado' }}
                    </span>

                </div>



                <div class="dato">

                    <strong>

                        <i class="fa-solid fa-location-dot"></i>

                        Dirección

                    </strong>

                    <span>
                        {{ auth()->user()->direccion ?? 'No registrada' }}
                    </span>

                </div>



                <div class="dato">

                    <strong>

                        <i class="fa-solid fa-calendar"></i>

                        Fecha de nacimiento

                    </strong>

                    <span>
                        {{ auth()->user()->fecha_nacimiento ?? 'No registrada' }}
                    </span>

                </div>


            </div>



            <!-- =========================
                 EDITAR INFORMACIÓN
            ========================= -->

            <div class="contenedor-boton">

                <a
                    href="{{ route('vendedor.informacion.editar') }}"
                    class="boton-editar"
                >

                    <i class="fa-solid fa-pen-to-square"></i>

                    Editar información

                </a>

            </div>


        </div>

    </div>



    <!-- =========================
         JAVASCRIPT
    ========================= -->

    <script>

        const botonEditarFoto =
            document.getElementById('botonEditarFoto');

        const menuFoto =
            document.getElementById('menuFoto');

        const panelColores =
            document.getElementById('panelColores');

        const subirFoto =
            document.getElementById('subirFoto');

        const cambiarColor =
            document.getElementById('cambiarColor');

        const inputFotoPerfil =
            document.getElementById('inputFotoPerfil');

        const formularioFoto =
            document.getElementById('formularioFoto');

        const formularioColor =
            document.getElementById('formularioColor');

        const colorPerfilSeleccionado =
            document.getElementById('colorPerfilSeleccionado');

        const opcionesColor =
            document.querySelectorAll('.color-opcion');



        /* =========================
           ABRIR MENÚ
        ========================= */

        botonEditarFoto.addEventListener(
            'click',
            function(event) {

                event.stopPropagation();

                menuFoto.classList.toggle('mostrar');

                panelColores.classList.remove('mostrar');

            }
        );



        /* =========================
           SUBIR FOTO
        ========================= */

        subirFoto.addEventListener(
            'click',
            function(event) {

                event.stopPropagation();

                inputFotoPerfil.click();

            }
        );



        /* =========================
           GUARDAR FOTO
        ========================= */

        inputFotoPerfil.addEventListener(
            'change',
            function() {

                if (this.files.length > 0) {

                    formularioFoto.submit();

                }

            }
        );



        /* =========================
           CAMBIAR COLOR
        ========================= */

        cambiarColor.addEventListener(
            'click',
            function(event) {

                event.stopPropagation();

                menuFoto.classList.remove('mostrar');

                panelColores.classList.toggle('mostrar');

            }
        );



        /* =========================
           SELECCIONAR COLOR
        ========================= */

        opcionesColor.forEach(
            function(opcion) {

                opcion.addEventListener(
                    'click',
                    function(event) {

                        event.stopPropagation();

                        const color =
                            this.getAttribute('data-color');

                        colorPerfilSeleccionado.value =
                            color;

                        formularioColor.submit();

                    }
                );

            }
        );



        /* =========================
           CERRAR MENÚS
        ========================= */

        document.addEventListener(
            'click',
            function(event) {

                if (
                    !botonEditarFoto.contains(event.target) &&
                    !menuFoto.contains(event.target) &&
                    !panelColores.contains(event.target)
                ) {

                    menuFoto.classList.remove('mostrar');

                    panelColores.classList.remove('mostrar');

                }

            }
        );

    </script>


</body>

</html>