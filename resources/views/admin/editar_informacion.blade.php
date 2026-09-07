<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar información - Administrador</title>

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


        /* =========================
           TARJETA
        ========================= */

        .tarjeta {
            background-color: white;

            border-radius: 15px;

            padding: 35px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.15);
        }


        /* =========================
           TÍTULO
        ========================= */

        .titulo {
            text-align: center;

            margin-bottom: 30px;
        }

        .titulo h2 {
            color: #333;

            margin: 0 0 8px;
        }

        .titulo p {
            color: #777;

            margin: 0;
        }


        /* =========================
           FORMULARIO
        ========================= */

        .formulario {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 20px;
        }


        .campo {
            display: flex;

            flex-direction: column;
        }


        .campo-completo {
            grid-column: 1 / -1;
        }


        .campo label {
            color: #555;

            font-weight: bold;

            margin-bottom: 8px;
        }


        .campo label i {
            color: #6a1b9a;

            margin-right: 7px;
        }


        .campo input {
            width: 100%;

            padding: 13px;

            border: 1px solid #ccc;

            border-radius: 8px;

            font-size: 15px;

            outline: none;

            transition: 0.3s;
        }


        .campo input:focus {
            border-color: #6a1b9a;

            box-shadow:
                0 0 0 2px rgba(106, 27, 154, 0.12);
        }


        /* =========================
           ERRORES
        ========================= */

        .error {
            color: #d32f2f;

            font-size: 13px;

            margin-top: 6px;
        }


        /* =========================
           BOTONES
        ========================= */

        .botones {
            grid-column: 1 / -1;

            display: flex;

            justify-content: center;

            gap: 15px;

            margin-top: 10px;
        }


        .boton {
            padding: 13px 25px;

            border-radius: 8px;

            text-decoration: none;

            font-weight: bold;

            border: none;

            cursor: pointer;

            font-size: 15px;

            transition: 0.3s;
        }


        .boton-guardar {
            background-color: #6a1b9a;

            color: white;
        }


        .boton-guardar:hover {
            background-color: #4a126d;

            transform: translateY(-2px);
        }


        .boton-cancelar {
            background-color: #eeeeee;

            color: #555;
        }


        .boton-cancelar:hover {
            background-color: #ddd;

            transform: translateY(-2px);
        }


        .boton i {
            margin-right: 7px;
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 600px) {

            .formulario {
                grid-template-columns: 1fr;
            }

            .campo-completo {
                grid-column: auto;
            }

            .botones {
                grid-column: auto;

                flex-direction: column;
            }

            .boton {
                width: 100%;

                text-align: center;
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
            href="{{ route('admin.informacion') }}"
            class="boton-regresar"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Regresar

        </a>


        <h1>
            Editar información
        </h1>


        <p>
            Actualiza los datos de tu cuenta
        </p>

    </div>



    <!-- =========================
         CONTENIDO
    ========================= -->

    <div class="contenedor">

        <div class="tarjeta">


            <!-- TÍTULO -->

            <div class="titulo">

                <h2>
                    Información personal
                </h2>

                <p>
                    Modifica tus datos y guarda los cambios
                </p>

            </div>



            <!-- =========================
                 FORMULARIO
            ========================= -->

            <form
                action="{{ route('admin.informacion.actualizar') }}"
                method="POST"
                class="formulario"
            >

                @csrf

                @method('PUT')


                <!-- NOMBRE -->

                <div class="campo">

                    <label for="name">

                        <i class="fa-solid fa-user"></i>

                        Nombre

                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', auth()->user()->name) }}"
                        required
                    >

                    @error('name')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- APELLIDOS -->

                <div class="campo">

                    <label for="apellido">

                        <i class="fa-solid fa-user"></i>

                        Apellidos

                    </label>

                    <input
                        type="text"
                        id="apellido"
                        name="apellido"
                        value="{{ old('apellido', auth()->user()->apellido) }}"
                        required
                    >

                    @error('apellido')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- CORREO -->

                <div class="campo campo-completo">

                    <label for="email">

                        <i class="fa-solid fa-envelope"></i>

                        Correo electrónico

                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        required
                    >

                    @error('email')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- TELÉFONO -->

                <div class="campo">

                    <label for="telefono">

                        <i class="fa-solid fa-phone"></i>

                        Teléfono

                    </label>

                    <input
                        type="text"
                        id="telefono"
                        name="telefono"
                        value="{{ old('telefono', auth()->user()->telefono) }}"
                    >

                    @error('telefono')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- FECHA DE NACIMIENTO -->

                <div class="campo">

                    <label for="fecha_nacimiento">

                        <i class="fa-solid fa-calendar"></i>

                        Fecha de nacimiento

                    </label>

                    <input
                        type="date"
                        id="fecha_nacimiento"
                        name="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento', auth()->user()->fecha_nacimiento) }}"
                    >

                    @error('fecha_nacimiento')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- DIRECCIÓN -->

                <div class="campo campo-completo">

                    <label for="direccion">

                        <i class="fa-solid fa-location-dot"></i>

                        Dirección

                    </label>

                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        value="{{ old('direccion', auth()->user()->direccion) }}"
                    >

                    @error('direccion')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- BOTONES -->

                <div class="botones">

                    <a
                        href="{{ route('admin.informacion') }}"
                        class="boton boton-cancelar"
                    >

                        <i class="fa-solid fa-xmark"></i>

                        Cancelar

                    </a>


                    <button
                        type="submit"
                        class="boton boton-guardar"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        Guardar cambios

                    </button>

                </div>


            </form>


        </div>

    </div>


</body>

</html>