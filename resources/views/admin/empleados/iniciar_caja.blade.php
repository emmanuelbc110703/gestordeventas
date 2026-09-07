<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar Caja - Orquídeas y más Los Amates</title>

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


        /* =========================
           CONTENEDOR
        ========================= */

        .contenedor {

            width: 100%;

            max-width: 600px;

            background: white;

            border-radius: 20px;

            padding: 40px;

            box-shadow:
                0 5px 25px rgba(0, 0, 0, 0.15);
        }


        /* =========================
           ICONO
        ========================= */

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


        /* =========================
           TITULO
        ========================= */

        h1 {

            text-align: center;

            margin: 0 0 8px;

            color: #333;

            font-size: 30px;
        }


        .subtitulo {

            text-align: center;

            color: #777;

            margin-bottom: 30px;

            font-size: 16px;
        }


        /* =========================
           DATOS CAJA
        ========================= */

        .datos-caja {

            border: 1px solid #eeeeee;

            border-radius: 12px;

            overflow: hidden;

            margin-bottom: 25px;
        }


        .dato {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 14px 16px;

            background: #fafafa;

            border-bottom: 1px solid #eeeeee;
        }


        .dato:last-child {

            border-bottom: none;
        }


        .etiqueta {

            color: #777;

            font-size: 15px;
        }


        .valor {

            color: #333;

            font-weight: bold;

            text-align: right;
        }


        /* =========================
           MENSAJE ADVERTENCIA
        ========================= */

        .advertencia {

            background: #fff8e1;

            border: 1px solid #f1d27a;

            border-radius: 12px;

            padding: 18px;

            margin-bottom: 25px;

            color: #6d5700;
        }


        .advertencia-titulo {

            display: flex;

            align-items: center;

            gap: 10px;

            font-weight: bold;

            font-size: 17px;

            margin-bottom: 10px;
        }


        .advertencia-titulo i {

            color: #d99a00;

            font-size: 21px;
        }


        .advertencia ul {

            margin: 0;

            padding-left: 22px;
        }


        .advertencia li {

            margin-bottom: 7px;

            line-height: 1.4;
        }


        .advertencia li:last-child {

            margin-bottom: 0;
        }


        /* =========================
           ERRORES
        ========================= */

        .error {

            background: #fde8e8;

            color: #b42318;

            border: 1px solid #f5b5b5;

            border-radius: 10px;

            padding: 14px 16px;

            margin-bottom: 20px;
        }


        /* =========================
           DINERO INICIAL
        ========================= */

        .campo {

            margin-bottom: 25px;
        }


        .campo label {

            display: block;

            color: #444;

            font-weight: bold;

            margin-bottom: 9px;
        }


        .campo label i {

            color: #6a1b9a;

            margin-right: 6px;
        }


        .input-dinero {

            position: relative;
        }


        .simbolo {

            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            color: #6a1b9a;

            font-size: 20px;

            font-weight: bold;
        }


        .campo input {

            width: 100%;

            padding: 15px 15px 15px 38px;

            border: 1px solid #d2d2d2;

            border-radius: 9px;

            font-size: 18px;

            outline: none;
        }


        .campo input:focus {

            border-color: #6a1b9a;

            box-shadow:
                0 0 0 2px rgba(106, 27, 154, 0.08);
        }


        .ayuda {

            margin-top: 7px;

            color: #888;

            font-size: 13px;
        }


        /* =========================
           BOTÓN EMPEZAR
        ========================= */

        .boton-empezar {

            width: 100%;

            padding: 17px;

            background: #6a1b9a;

            color: white;

            border: none;

            border-radius: 11px;

            font-size: 18px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }


        .boton-empezar i {

            margin-right: 8px;
        }


        .boton-empezar:hover {

            background: #4a126b;

            transform: translateY(-2px);

            box-shadow:
                0 5px 15px rgba(106, 27, 154, 0.25);
        }


        /* =========================
           REGRESAR
        ========================= */

        .boton-regresar {

            display: block;

            width: 100%;

            padding: 14px;

            margin-top: 12px;

            background: #eeeeee;

            color: #555;

            border-radius: 11px;

            text-align: center;

            text-decoration: none;

            font-weight: bold;

            transition: 0.3s;
        }


        .boton-regresar:hover {

            background: #dddddd;

            color: #333;
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 600px) {

            .contenedor {

                padding: 28px 20px;
            }

            h1 {

                font-size: 26px;
            }

            .dato {

                flex-direction: column;

                align-items: flex-start;

                gap: 5px;
            }

            .valor {

                text-align: left;
            }
        }

    </style>

</head>


<body>


<div class="contenedor">


    <!-- =========================
         ICONO
    ========================= -->

    <div class="icono">

        <i class="fa-solid fa-cash-register"></i>

    </div>


    <!-- =========================
         TITULO
    ========================= -->

    <h1>

        Iniciar Caja

    </h1>


    <div class="subtitulo">

        Registra el dinero de cambio para comenzar la jornada.

    </div>


    <!-- =========================
         DATOS DEL PUNTO DE VENTA
    ========================= -->

    <div class="datos-caja">


        <div class="dato">

            <span class="etiqueta">

                <i class="fa-solid fa-store"></i>

                Sucursal

            </span>

            <span class="valor">

                {{ $puntoVenta->sucursal }}

            </span>

        </div>


        <div class="dato">

            <span class="etiqueta">

                <i class="fa-solid fa-hashtag"></i>

                Número de caja

            </span>

            <span class="valor">

                {{ $puntoVenta->numero_caja }}

            </span>

        </div>


        <div class="dato">

            <span class="etiqueta">

                <i class="fa-solid fa-cash-register"></i>

                Nombre de caja

            </span>

            <span class="valor">

                {{ $puntoVenta->nombre_caja }}

            </span>

        </div>


    </div>


    <!-- =========================
         MENSAJE DE ADVERTENCIA
    ========================= -->

    <div class="advertencia">

        <div class="advertencia-titulo">

            <i class="fa-solid fa-triangle-exclamation"></i>

            Importante

        </div>


        <ul>

            <li>
                Una vez iniciada la caja,
                <strong>el dinero inicial no podrá modificarse.</strong>
            </li>

            <li>
                El horario de apertura de caja es de
                <strong>9:00 AM a 7:00 PM.</strong>
            </li>

            <li>
                Cualquier venta realizada fuera del horario
                se considerará para el <strong>día siguiente.</strong>
            </li>

        </ul>

    </div>


    <!-- =========================
         ERRORES
    ========================= -->

    @if(session('error'))

        <div class="error">

            <i class="fa-solid fa-circle-exclamation"></i>

            {{ session('error') }}

        </div>

    @endif


    @if($errors->any())

        <div class="error">

            <strong>Hay un problema:</strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- =========================
         FORMULARIO
    ========================= -->

    <form
        action="{{ route('empleado.caja.abrir', $puntoVenta->id) }}"
        method="POST"
    >

        @csrf


        <!-- DINERO INICIAL -->

        <div class="campo">

            <label for="dinero_inicial">

                <i class="fa-solid fa-money-bill-wave"></i>

                Dinero de cambio inicial

            </label>


            <div class="input-dinero">

                <span class="simbolo">

                    $

                </span>


                <input
                    type="number"
                    id="dinero_inicial"
                    name="dinero_inicial"
                    value="{{ old('dinero_inicial') }}"
                    min="0"
                    step="0.01"
                    placeholder="0.00"
                    required
                    autofocus
                >

            </div>


            <div class="ayuda">

                Ingresa la cantidad de efectivo con la que comienza la caja.

            </div>

        </div>


        <!-- =========================
             BOTÓN
        ========================= -->

        <button
            type="submit"
            class="boton-empezar"
        >

            <i class="fa-solid fa-play"></i>

            Empezar caja

        </button>


    </form>


    <!-- =========================
         REGRESAR
    ========================= -->

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