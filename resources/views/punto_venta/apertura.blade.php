<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apertura de caja</title>

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
            min-height: 100vh;

            font-family: Arial, sans-serif;

            background: #f4f4f4;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;
        }

        .contenedor {
            width: 100%;
            max-width: 500px;

            background: white;

            border-radius: 20px;

            padding: 35px;

            box-shadow:
                0 5px 25px rgba(0, 0, 0, 0.15);

            text-align: center;
        }

        .icono {
            width: 85px;
            height: 85px;

            margin: 0 auto 20px;

            border-radius: 50%;

            background: #6a1b9a;

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 38px;
        }

        h1 {
            margin: 0 0 10px;

            color: #333;

            font-size: 28px;
        }

        .subtitulo {
            color: #777;

            margin-bottom: 25px;

            font-size: 15px;
        }

        .informacion {
            background: #fafafa;

            border: 1px solid #eeeeee;

            border-radius: 12px;

            overflow: hidden;

            margin-bottom: 25px;

            text-align: left;
        }

        .dato {
            display: flex;

            justify-content: space-between;

            padding: 14px 16px;

            border-bottom: 1px solid #eeeeee;
        }

        .dato:last-child {
            border-bottom: none;
        }

        .etiqueta {
            color: #777;
        }

        .valor {
            font-weight: bold;

            color: #333;
        }

        .seccion-cantidad {
            text-align: left;

            margin-bottom: 20px;
        }

        .seccion-cantidad label {
            display: block;

            color: #444;

            font-weight: bold;

            margin-bottom: 8px;
        }

        .input-cantidad {
            width: 100%;

            padding: 16px;

            border: 2px solid #ddd;

            border-radius: 12px;

            font-size: 22px;

            outline: none;

            text-align: center;
        }

        .input-cantidad:focus {
            border-color: #6a1b9a;
        }

        .advertencia {
            display: flex;

            gap: 10px;

            align-items: flex-start;

            text-align: left;

            background: #fff8e1;

            border: 1px solid #ffe082;

            color: #795548;

            border-radius: 10px;

            padding: 14px;

            margin-bottom: 22px;

            font-size: 14px;

            line-height: 1.4;
        }

        .advertencia i {
            color: #f9a825;

            margin-top: 2px;
        }

        .boton-confirmar {
            width: 100%;

            padding: 17px;

            border: none;

            border-radius: 12px;

            background: #6a1b9a;

            color: white;

            font-size: 18px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .boton-confirmar:hover {
            background: #4a126b;

            transform: translateY(-2px);
        }

        .boton-regresar {
            display: block;

            width: 100%;

            padding: 14px;

            margin-top: 12px;

            border-radius: 12px;

            background: #eeeeee;

            color: #555;

            text-decoration: none;

            font-weight: bold;
        }

        .boton-regresar:hover {
            background: #ddd;
        }

        .error {
            background: #ffebee;

            color: #c62828;

            border: 1px solid #ef9a9a;

            border-radius: 10px;

            padding: 12px;

            margin-bottom: 20px;
        }

        @media (max-width: 500px) {

            .contenedor {
                padding: 25px 20px;
            }

            h1 {
                font-size: 24px;
            }

        }

    </style>

</head>

<body>

<div class="contenedor">

    <!-- ICONO -->

    <div class="icono">

        <i class="fa-solid fa-cash-register"></i>

    </div>


    <!-- TITULO -->

    <h1>
        Apertura de caja
    </h1>

    <div class="subtitulo">

        Ingresa el dinero inicial con el que comenzarás operaciones.

    </div>


    <!-- ERRORES -->

    @if($errors->any())

        <div class="error">

            {{ $errors->first() }}

        </div>

    @endif


    <!-- INFORMACIÓN -->

    <div class="informacion">

        <div class="dato">

            <span class="etiqueta">
                Sucursal
            </span>

            <span class="valor">
                {{ $puntoVenta->sucursal }}
            </span>

        </div>


        <div class="dato">

            <span class="etiqueta">
                Número de caja
            </span>

            <span class="valor">
                {{ $puntoVenta->numero_caja }}
            </span>

        </div>


        <div class="dato">

            <span class="etiqueta">
                Nombre de caja
            </span>

            <span class="valor">
                {{ $puntoVenta->nombre_caja }}
            </span>

        </div>


        <div class="dato">

            <span class="etiqueta">
                Fecha
            </span>

            <span class="valor">
                {{ now()->format('d/m/Y') }}
            </span>

        </div>


        <div class="dato">

            <span class="etiqueta">
                Hora de apertura
            </span>

            <span class="valor">
                {{ now()->format('H:i:s') }}
            </span>

        </div>

    </div>


    <!-- FORMULARIO -->

    <form
        action="{{ route('punto_venta.abrir', $puntoVenta->id) }}"
        method="POST"
    >

        @csrf


        <div class="seccion-cantidad">

            <label for="dinero_inicial">

                Dinero inicial / Cambio

            </label>


            <input
                type="number"
                id="dinero_inicial"
                name="dinero_inicial"
                class="input-cantidad"
                min="0"
                step="0.01"
                placeholder="0.00"
                required
                autofocus
            >

        </div>


        <!-- ADVERTENCIA -->

        <div class="advertencia">

            <i class="fa-solid fa-triangle-exclamation"></i>

            <span>

                Verifica cuidadosamente la cantidad antes de
                confirmar. El dinero inicial quedará registrado
                como el cambio con el que comienza la caja.

            </span>

        </div>


        <!-- CONFIRMAR -->

        <button
            type="submit"
            class="boton-confirmar"
        >

            <i class="fa-solid fa-lock-open"></i>

            Confirmar apertura

        </button>

    </form>


    <!-- REGRESAR -->

    <a
        href="{{ route('empleado.punto_venta') }}"
        class="boton-regresar"
    >

        <i class="fa-solid fa-arrow-left"></i>

        Regresar

    </a>

</div>

</body>

</html>