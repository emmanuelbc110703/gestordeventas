<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agregar cliente - Gestor de Ventas Los Amates</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            min-height: 100vh;
            padding-bottom: 40px;
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
            max-width: 600px;
            margin: 40px auto;
        }

        .tarjeta {
            background-color: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }


        /* =========================
           TITULO
        ========================= */

        .titulo-formulario {
            text-align: center;
            margin-bottom: 30px;
        }

        .icono-titulo {
            width: 70px;
            height: 70px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background-color: #ede0f5;
            color: #6a1b9a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .titulo-formulario h2 {
            margin: 0 0 8px;
            color: #333;
        }

        .titulo-formulario p {
            margin: 0;
            color: #777;
            font-size: 14px;
        }


        /* =========================
           FILAS
        ========================= */

        .fila {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }


        /* =========================
           CAMPOS
        ========================= */

        .campo {
            position: relative;
            margin-bottom: 20px;
        }

        .campo i {
            position: absolute;
            left: 15px;
            top: 14px;
            color: #6a1b9a;
        }

        .campo input {
            width: 100%;
            padding: 13px 15px 13px 45px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }

        .campo input:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.08);
        }


        /* =========================
           ERRORES
        ========================= */

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }


        /* =========================
           INFORMACIÓN
        ========================= */

        .informacion {
            background-color: #f8f0fb;
            border-left: 4px solid #6a1b9a;
            padding: 13px 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            color: #555;
            font-size: 14px;
            line-height: 1.5;
        }

        .informacion i {
            color: #6a1b9a;
            margin-right: 6px;
        }


        /* =========================
           BOTONES
        ========================= */

        .botones {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .boton-guardar,
        .boton-cancelar {
            flex: 1;
            padding: 13px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .boton-guardar {
            border: none;
            background-color: #6a1b9a;
            color: white;
        }

        .boton-guardar:hover {
            background-color: #4a126d;
            transform: translateY(-2px);
        }

        .boton-cancelar {
            background-color: #eee;
            color: #555;
            text-decoration: none;
        }

        .boton-cancelar:hover {
            background-color: #ddd;
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 600px) {

            .fila {
                grid-template-columns: 1fr;
                gap: 0;
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

            .botones {
                flex-direction: column;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         ENCABEZADO
    ========================== -->

    <div class="encabezado">

        <a href="{{ route('admin.clientes') }}"
           class="boton-regresar">

            <i class="fa-solid fa-arrow-left"></i>
            Regresar

        </a>

        <h1>Agregar cliente</h1>

        <p>Registrar un nuevo cliente en el sistema</p>

    </div>



    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">

        <div class="tarjeta">


            <!-- TITULO -->

            <div class="titulo-formulario">

                <div class="icono-titulo">

                    <i class="fa-solid fa-user-plus"></i>

                </div>

                <h2>Nuevo cliente</h2>

                <p>
                    Ingresa la información del cliente
                </p>

            </div>



            <!-- INFORMACIÓN -->

            <div class="informacion">

                <i class="fa-solid fa-circle-info"></i>

                El cliente será registrado sin contraseña.
                Posteriormente podrá activar su cuenta y crear su contraseña
                desde el registro de la página principal.

            </div>



            <!-- =========================
                 FORMULARIO
            ========================== -->

            <form
                action="{{ route('admin.clientes.guardar') }}"
                method="POST"
            >

                @csrf



                <!-- NOMBRE Y APELLIDOS -->

                <div class="fila">


                    <!-- NOMBRE -->

                    <div class="campo">

                        <i class="fa-solid fa-user"></i>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Nombre"
                            required
                        >

                        @error('name')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>



                    <!-- APELLIDO -->

                    <div class="campo">

                        <i class="fa-solid fa-user"></i>

                        <input
                            type="text"
                            name="apellido"
                            value="{{ old('apellido') }}"
                            placeholder="Apellidos"
                            required
                        >

                        @error('apellido')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                </div>



                <!-- CORREO -->

                <div class="campo">

                    <i class="fa-solid fa-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Correo electrónico"
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

                    <i class="fa-solid fa-phone"></i>

                    <input
                        type="tel"
                        name="telefono"
                        value="{{ old('telefono') }}"
                        placeholder="Teléfono"
                    >

                    @error('telefono')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- DIRECCIÓN -->

                <div class="campo">

                    <i class="fa-solid fa-location-dot"></i>

                    <input
                        type="text"
                        name="direccion"
                        value="{{ old('direccion') }}"
                        placeholder="Dirección"
                    >

                    @error('direccion')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- FECHA DE NACIMIENTO -->

                <div class="campo">

                    <i class="fa-solid fa-calendar"></i>

                    <input
                        type="date"
                        name="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento') }}"
                    >

                    @error('fecha_nacimiento')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- BOTONES -->

                <div class="botones">


                    <a
                        href="{{ route('admin.clientes') }}"
                        class="boton-cancelar"
                    >

                        <i class="fa-solid fa-xmark"></i>
                        Cancelar

                    </a>


                    <button
                        type="submit"
                        class="boton-guardar"
                    >

                        <i class="fa-solid fa-user-plus"></i>
                        Registrar cliente

                    </button>


                </div>


            </form>


        </div>

    </div>


</body>

</html>