<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar punto de venta - Gestor de Ventas Los Amates</title>

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
        ========================== */

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
        ========================== */

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
        ========================== */

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
           INFORMACION
        ========================== */

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
           CAMPOS
        ========================== */

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

        .campo input,
        .campo select {
            width: 100%;
            padding: 13px 15px 13px 45px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
            background-color: white;
        }

        .campo input:focus,
        .campo select:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.08);
        }


        /* =========================
           ERRORES
        ========================== */

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }


        /* =========================
           BOTONES
        ========================== */

        .botones {
            display: flex;
            gap: 15px;
            margin-top: 25px;
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
        ========================== */

        @media (max-width: 600px) {

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

        <a href="{{ route('admin.puntos_venta') }}"
           class="boton-regresar">

            <i class="fa-solid fa-arrow-left"></i>
            Regresar

        </a>

        <h1>Editar punto de venta</h1>

        <p>Modificar la información de la caja y empleado asignado</p>

    </div>



    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">

        <div class="tarjeta">


            <!-- TITULO -->

            <div class="titulo-formulario">

                <div class="icono-titulo">

                    <i class="fa-solid fa-cash-register"></i>

                </div>

                <h2>Editar punto de venta</h2>

                <p>
                    Modifica la información de la caja
                </p>

            </div>



            <!-- INFORMACION -->

            <div class="informacion">

                <i class="fa-solid fa-circle-info"></i>

                Puedes modificar el nombre, número de caja,
                sucursal o empleado asignado.

            </div>



            <!-- =========================
                 FORMULARIO
            ========================== -->

            <form
                action="{{ route('admin.puntos_venta.update', $puntoVenta->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')



                <!-- NOMBRE DE LA CAJA -->

                <div class="campo">

                    <i class="fa-solid fa-cash-register"></i>

                    <input
                        type="text"
                        name="nombre_caja"
                        value="{{ old('nombre_caja', $puntoVenta->nombre_caja) }}"
                        placeholder="Nombre de la caja"
                        required
                    >

                    @error('nombre_caja')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- NUMERO DE CAJA -->

                <div class="campo">

                    <i class="fa-solid fa-hashtag"></i>

                    <input
                        type="text"
                        name="numero_caja"
                        value="{{ old('numero_caja', $puntoVenta->numero_caja) }}"
                        placeholder="Número de caja"
                        required
                    >

                    @error('numero_caja')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- SUCURSAL -->

                <div class="campo">

                    <i class="fa-solid fa-location-dot"></i>

                    <input
                        type="text"
                        name="sucursal"
                        value="{{ old('sucursal', $puntoVenta->sucursal) }}"
                        placeholder="Sucursal"
                        required
                    >

                    @error('sucursal')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- EMPLEADO -->

                <div class="campo">

                    <i class="fa-solid fa-user"></i>

                    <select
                        name="empleado_id"
                        required
                    >

                        <option value="">
                            Seleccionar empleado
                        </option>

                        @foreach($empleados as $empleado)

                            <option
                                value="{{ $empleado->id }}"
                                {{ old('empleado_id', $puntoVenta->empleado_id) == $empleado->id ? 'selected' : '' }}
                            >

                                {{ $empleado->name }}
                                {{ $empleado->apellido }}

                                @if($empleado->rol === 'administrador')
                                @elseif($empleado->rol === 'vendedor')
                                @endif

                            </option>

                        @endforeach

                    </select>

                    @error('empleado_id')

                        <span class="error">
                            {{ $message }}
                        </span>

                    @enderror

                </div>



                <!-- ERROR GENERAL -->

                @if(session('error'))

                    <div class="error" style="margin-bottom: 15px;">

                        {{ session('error') }}

                    </div>

                @endif



                <!-- BOTONES -->

                <div class="botones">

                    <a
                        href="{{ route('admin.puntos_venta') }}"
                        class="boton-cancelar"
                    >

                        <i class="fa-solid fa-xmark"></i>

                        Cancelar

                    </a>


                    <button
                        type="submit"
                        class="boton-guardar"
                    >

                        <i class="fa-solid fa-pen"></i>

                        Actualizar punto de venta

                    </button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>