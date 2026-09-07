<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agregar empleado - Gestor de Ventas Los Amates</title>

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
            max-width: 700px;
            margin: 40px auto;
        }

        .tarjeta {
            background-color: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        /* =========================
           FILAS
        ========================= */

        .fila {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        /* =========================
           CAMPOS
        ========================= */

        .campo {
            margin-bottom: 18px;
        }

        .campo label {
            display: block;
            color: #555;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .campo label i {
            color: #6a1b9a;
            margin-right: 6px;
        }

        .campo input,
        .campo select {
            width: 100%;
            padding: 13px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            background-color: white;
        }

        .campo input:focus,
        .campo select:focus {
            border-color: #6a1b9a;
        }

        /* =========================
           ERRORES
        ========================= */

        .error {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
        }

        /* =========================
           BOTÓN
        ========================= */

        .contenedor-boton {
            text-align: center;
            margin-top: 15px;
        }

        .boton-guardar {
            background-color: #6a1b9a;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 13px 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .boton-guardar:hover {
            background-color: #4a126d;
            transform: translateY(-2px);
        }

        .boton-guardar i {
            margin-right: 8px;
        }

        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 700px) {

            .boton-regresar {
                position: static;
                display: inline-block;
                margin-bottom: 15px;
            }

            .encabezado {
                padding: 20px;
            }

            .fila {
                grid-template-columns: 1fr;
                gap: 0;
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
    ========================== -->

    <div class="encabezado">

        <a href="{{ route('admin.empleados') }}"
           class="boton-regresar">

            <i class="fa-solid fa-arrow-left"></i>
            Regresar

        </a>

        <h1>Agregar empleado</h1>

        <p>Registra un nuevo administrador o vendedor</p>

    </div>


    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">

        <div class="tarjeta">


            <!-- FORMULARIO -->

            <form
                action="{{ route('admin.empleados.guardar') }}"
                method="POST"
            >

                @csrf


                <!-- NOMBRE Y APELLIDOS -->

                <div class="fila">

                    <div class="campo">

                        <label for="name">

                            <i class="fa-solid fa-user"></i>
                            Nombre

                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required
                        >

                        @error('name')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    <div class="campo">

                        <label for="apellido">

                            <i class="fa-solid fa-user"></i>
                            Apellidos

                        </label>

                        <input
                            type="text"
                            id="apellido"
                            name="apellido"
                            value="{{ old('apellido') }}"
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

                    <label for="email">

                        <i class="fa-solid fa-envelope"></i>
                        Correo electrónico

                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                    >

                    @error('email')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <!-- TELÉFONO Y FECHA -->

                <div class="fila">

                    <div class="campo">

                        <label for="telefono">

                            <i class="fa-solid fa-phone"></i>
                            Teléfono

                        </label>

                        <input
                            type="text"
                            id="telefono"
                            name="telefono"
                            value="{{ old('telefono') }}"
                        >

                    </div>


                    <div class="campo">

                        <label for="fecha_nacimiento">

                            <i class="fa-solid fa-calendar"></i>
                            Fecha de nacimiento

                        </label>

                        <input
                            type="date"
                            id="fecha_nacimiento"
                            name="fecha_nacimiento"
                            value="{{ old('fecha_nacimiento') }}"
                        >

                    </div>

                </div>


                <!-- DIRECCIÓN -->

                <div class="campo">

                    <label for="direccion">

                        <i class="fa-solid fa-location-dot"></i>
                        Dirección

                    </label>

                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        value="{{ old('direccion') }}"
                    >

                </div>


                <!-- ROL -->

                <div class="campo">

                    <label for="rol">

                        <i class="fa-solid fa-user-tag"></i>
                        Rol del empleado

                    </label>

                    <select
                        id="rol"
                        name="rol"
                        required
                    >

                        <option value="">
                            Selecciona un rol
                        </option>

                        <option
                            value="admin"
                            {{ old('rol') === 'admin' ? 'selected' : '' }}
                        >
                            Administrador
                        </option>

                        <option
                            value="vendedor"
                            {{ old('rol') === 'vendedor' ? 'selected' : '' }}
                        >
                            Vendedor
                        </option>

                    </select>

                    @error('rol')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <!-- CONTRASEÑA -->

                <div class="fila">

                    <div class="campo">

                        <label for="password">

                            <i class="fa-solid fa-lock"></i>
                            Contraseña

                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                        >

                        @error('password')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    <div class="campo">

                        <label for="password_confirmation">

                            <i class="fa-solid fa-lock"></i>
                            Confirmar contraseña

                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                        >

                    </div>

                </div>


                <!-- BOTÓN -->

                <div class="contenedor-boton">

                    <button
                        type="submit"
                        class="boton-guardar"
                    >

                        <i class="fa-solid fa-user-plus"></i>
                        Registrar empleado

                    </button>

                </div>


            </form>

        </div>

    </div>


</body>

</html>

