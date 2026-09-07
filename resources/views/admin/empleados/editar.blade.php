<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar empleado - Gestor de Ventas Los Amates</title>

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
           PERFIL
        ========================= */

        .perfil {
            text-align: center;
            margin-bottom: 30px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            margin: auto;
            margin-bottom: 15px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .perfil h2 {
            color: #333;
            margin: 0 0 10px;
        }

        /* =========================
           ROL ACTUAL
        ========================= */

        .rol-actual {
            display: inline-block;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .rol-admin {
            background-color: #ede0f5;
            color: #6a1b9a;
        }

        .rol-vendedor {
            background-color: #e1f5e8;
            color: #218838;
        }

        /* =========================
           FILAS
        ========================= */

        .fila {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .campo {
            position: relative;
            margin-bottom: 20px;
        }

        .campo i {
            position: absolute;
            left: 15px;
            top: 14px;
            color: #6a1b9a;
            z-index: 1;
        }

        .campo input,
        .campo select {
            width: 100%;
            padding: 13px 15px 13px 45px;
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

        .campo select {
            cursor: pointer;
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

        <a href="{{ route('admin.empleados') }}"
           class="boton-regresar">

            <i class="fa-solid fa-arrow-left"></i>
            Regresar

        </a>

        <h1>Editar empleado</h1>

        <p>Modifica la información del empleado</p>

    </div>



    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">

        <div class="tarjeta">


            <!-- PERFIL -->

            <div class="perfil">

                <div
                    class="avatar"
                    style="background-color: {{ $empleado->color_perfil ?? '#6a1b9a' }};"
                >

                    @if($empleado->foto_perfil)

                        <img
                            src="{{ asset('storage/' . $empleado->foto_perfil) }}"
                            alt="Foto de {{ $empleado->name }}"
                        >

                    @else

                        {{ strtoupper(substr($empleado->name, 0, 1)) }}

                    @endif

                </div>


                <h2>
                    {{ $empleado->name }}
                    {{ $empleado->apellido }}
                </h2>


                <!-- ROL ACTUAL -->

                @if($empleado->rol === 'admin')

                    <span class="rol-actual rol-admin">
                        <i class="fa-solid fa-user-shield"></i>
                        Administrador
                    </span>

                @elseif($empleado->rol === 'vendedor')

                    <span class="rol-actual rol-vendedor">
                        <i class="fa-solid fa-user-tie"></i>
                        Vendedor
                    </span>

                @endif

            </div>



            <!-- =========================
                 FORMULARIO
            ========================== -->

            <form
                action="{{ route('admin.empleados.actualizar', $empleado->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')



                <!-- NOMBRE Y APELLIDO -->

                <div class="fila">


                    <!-- NOMBRE -->

                    <div class="campo">

                        <i class="fa-solid fa-user"></i>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $empleado->name) }}"
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
                            value="{{ old('apellido', $empleado->apellido) }}"
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
                        value="{{ old('email', $empleado->email) }}"
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
                        value="{{ old('telefono', $empleado->telefono) }}"
                        placeholder="Teléfono"
                    >

                    @error('telefono')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- ROL -->

                <div class="campo">

                    <i class="fa-solid fa-user-tag"></i>

                    <select name="rol" required>

                        <option value="admin"
                            {{ old('rol', $empleado->rol) === 'admin' ? 'selected' : '' }}>
                            Administrador
                        </option>

                        <option value="vendedor"
                            {{ old('rol', $empleado->rol) === 'vendedor' ? 'selected' : '' }}>
                            Vendedor
                        </option>

                    </select>

                    @error('rol')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- BOTONES -->

                <div class="botones">


                    <a
                        href="{{ route('admin.empleados') }}"
                        class="boton-cancelar"
                    >

                        <i class="fa-solid fa-xmark"></i>
                        Cancelar

                    </a>


                    <button
                        type="submit"
                        class="boton-guardar"
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