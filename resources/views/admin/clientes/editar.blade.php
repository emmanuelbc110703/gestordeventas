<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar cliente - Gestor de Ventas Los Amates</title>

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
            margin: 0;
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
        }

        .campo input {
            width: 100%;
            padding: 13px 15px 13px 45px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        .campo input:focus {
            border-color: #6a1b9a;
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

        .puesto-perfil {
    margin-top: 8px;
    color: #6a1b9a;
    font-size: 14px;
    font-weight: bold;
}

.puesto-perfil i {
    margin-right: 5px;
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

        <h1>Editar cliente</h1>

        <p>Modifica la información del cliente</p>

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
                    style="background-color: {{ $cliente->color_perfil ?? '#6a1b9a' }};"
                >

                    @if($cliente->foto_perfil)

                        <img
                            src="{{ asset('storage/' . $cliente->foto_perfil) }}"
                            alt="Foto de {{ $cliente->name }}"
                        >

                    @else

                        {{ strtoupper(substr($cliente->name, 0, 1)) }}

                    @endif

                </div>


                <h2>
                    {{ $cliente->name }}
                    {{ $cliente->apellido }}
                </h2>

                <div class="puesto-perfil">
    <i class="fa-solid fa-user"></i>
    Cliente
</div>

            </div>



            <!-- =========================
                 FORMULARIO
            ========================== -->

            <form
                action="{{ route('admin.clientes.actualizar', $cliente->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')



                <!-- NOMBRE Y APELLIDOS -->

                <div class="fila">


                    <!-- NOMBRE -->

                    <div class="campo">

                        <i class="fa-solid fa-user"></i>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $cliente->name) }}"
                            placeholder="Nombre"
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

                        <i class="fa-solid fa-user"></i>

                        <input
                            type="text"
                            name="apellido"
                            value="{{ old('apellido', $cliente->apellido) }}"
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
                        value="{{ old('email', $cliente->email) }}"
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
                        value="{{ old('telefono', $cliente->telefono) }}"
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
                        value="{{ old('direccion', $cliente->direccion) }}"
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
                        value="{{ old('fecha_nacimiento', $cliente->fecha_nacimiento) }}"
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

                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar cambios

                    </button>


                </div>


            </form>


        </div>

    </div>


</body>

</html>

