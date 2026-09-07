<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar información - Gestor de Ventas Los Amates</title>

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

        .encabezado h1 {
            margin: 5px 0;
        }

        .encabezado p {
            margin: 5px 0;
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
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .tarjeta h2 {
            text-align: center;
            color: #6a1b9a;
            margin-top: 0;
            margin-bottom: 30px;
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
            position: relative;
        }

        .campo-completo {
            grid-column: 1 / -1;
        }

        .campo label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
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
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.1);
        }


        /* =========================
           ERRORES
        ========================= */

        .error {
            color: #d32f2f;
            font-size: 13px;
            margin-top: 5px;
        }


        /* =========================
           BOTONES
        ========================= */

        .acciones {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .boton-guardar,
        .boton-cancelar {
            padding: 13px 22px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .boton-guardar {
            background-color: #6a1b9a;
            color: white;
            border: none;
        }

        .boton-guardar:hover {
            background-color: #4a126d;
            transform: translateY(-2px);
        }

        .boton-cancelar {
            background-color: #eee;
            color: #555;
            border: none;
        }

        .boton-cancelar:hover {
            background-color: #ddd;
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 650px) {

            .formulario {
                grid-template-columns: 1fr;
            }

            .campo-completo,
            .acciones {
                grid-column: 1;
            }

            .acciones {
                flex-direction: column;
            }

            .boton-guardar,
            .boton-cancelar {
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

        <a href="{{ route('vendedor.informacion') }}"
           class="boton-regresar">

            <i class="fa-solid fa-arrow-left"></i>
            Regresar

        </a>

        <h1>Editar información</h1>

        <p>Actualiza los datos de tu cuenta</p>

    </div>


    <!-- =========================
         CONTENIDO
    ========================= -->

    <div class="contenedor">

        <div class="tarjeta">

            <h2>
                <i class="fa-solid fa-user-pen"></i>
                Información personal
            </h2>


            <!-- =========================
                 FORMULARIO
            ========================= -->

            <form
                action="{{ route('vendedor.informacion.actualizar') }}"
                method="POST"
                class="formulario"
            >

                @csrf
                @method('PUT')


                <!-- NOMBRE -->

                <div class="campo">

                    <label>
                        <i class="fa-solid fa-user"></i>
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', auth()->user()->name) }}"
                    >

                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                <!-- APELLIDOS -->

                <div class="campo">

                    <label>
                        <i class="fa-solid fa-user"></i>
                        Apellidos
                    </label>

                    <input
                        type="text"
                        name="apellido"
                        value="{{ old('apellido', auth()->user()->apellido) }}"
                    >

                    @error('apellido')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                <!-- CORREO -->

                <div class="campo campo-completo">

                    <label>
                        <i class="fa-solid fa-envelope"></i>
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', auth()->user()->email) }}"
                    >

                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                <!-- TELÉFONO -->

                <div class="campo">

                    <label>
                        <i class="fa-solid fa-phone"></i>
                        Teléfono
                    </label>

                    <input
                        type="tel"
                        name="telefono"
                        value="{{ old('telefono', auth()->user()->telefono) }}"
                    >

                    @error('telefono')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                <!-- FECHA DE NACIMIENTO -->

                <div class="campo">

                    <label>
                        <i class="fa-solid fa-calendar"></i>
                        Fecha de nacimiento
                    </label>

                    <input
                        type="date"
                        name="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento', auth()->user()->fecha_nacimiento) }}"
                    >

                    @error('fecha_nacimiento')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                <!-- DIRECCIÓN -->

                <div class="campo campo-completo">

                    <label>
                        <i class="fa-solid fa-location-dot"></i>
                        Dirección
                    </label>

                    <input
                        type="text"
                        name="direccion"
                        value="{{ old('direccion', auth()->user()->direccion) }}"
                    >

                    @error('direccion')
                        <div class="error">{{ $message }}</div>
                    @enderror

                </div>


                <!-- =========================
                     BOTONES
                ========================= -->

                <div class="acciones">

                    <button
                        type="submit"
                        class="boton-guardar"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar cambios

                    </button>


                    <a
                        href="{{ route('vendedor.informacion') }}"
                        class="boton-cancelar"
                    >

                        <i class="fa-solid fa-xmark"></i>
                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</body>
</html>