<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Punto de Venta</title>

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

        /* ========================================
           CONTENEDOR PRINCIPAL
        ======================================== */

        .contenedor {
            width: 100%;
            max-width: 550px;

            background: white;

            border-radius: 20px;

            padding: 40px 35px;

            text-align: center;

            box-shadow:
                0 5px 25px rgba(0, 0, 0, 0.15);
        }

        /* ========================================
           ICONO
        ======================================== */

        .icono {
            width: 90px;
            height: 90px;

            margin: 0 auto 20px;

            border-radius: 50%;

            background: #6a1b9a;

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 40px;
        }

        /* ========================================
           TITULO
        ======================================== */

        h1 {
            margin: 0 0 25px;

            color: #333;

            font-size: 30px;
        }

        /* ========================================
           DATOS DEL PUNTO
        ======================================== */

        .datos-punto {
            width: 100%;

            margin-bottom: 30px;

            border: 1px solid #eeeeee;

            border-radius: 12px;

            overflow: hidden;
        }

        .dato {
            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 16px 18px;

            background: #fafafa;

            border-bottom: 1px solid #eeeeee;

            text-align: left;
        }

        .dato:last-child {
            border-bottom: none;
        }

        .etiqueta {
            color: #777;

            font-size: 16px;
        }

        .etiqueta i {
            margin-right: 5px;
        }

        .valor {
            color: #333;

            font-size: 17px;

            font-weight: bold;

            text-align: right;
        }

        /* ========================================
           FECHA
        ======================================== */

        .fecha {
            color: #555;

            font-size: 18px;

            margin-bottom: 8px;
        }

        /* ========================================
           HORA
        ======================================== */

        .hora {
            color: #6a1b9a;

            font-size: 42px;

            font-weight: bold;

            margin-bottom: 30px;
        }

        /* ========================================
           BOTON ABRIR CAJA
        ======================================== */

        .boton-iniciar {
            display: block;

            width: 100%;

            padding: 18px;

            background: #6a1b9a;

            color: white;

            border: none;

            border-radius: 12px;

            font-size: 20px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .boton-iniciar i {
            margin-right: 10px;
        }

        .boton-iniciar:hover {
            background: #4a126b;

            transform: translateY(-3px);

            box-shadow:
                0 5px 15px rgba(106, 27, 154, 0.3);
        }

        /* ========================================
           BOTON REGRESAR
        ======================================== */

        .boton-regresar {
            display: block;

            width: 100%;

            padding: 15px;

            margin-top: 12px;

            background: #eeeeee;

            color: #555;

            border: none;

            border-radius: 12px;

            font-size: 17px;

            font-weight: bold;

            text-decoration: none;

            cursor: pointer;

            transition: 0.3s;
        }

        .boton-regresar i {
            margin-right: 8px;
        }

        .boton-regresar:hover {
            background: #dddddd;

            color: #333;

            transform: translateY(-2px);
        }

        /* ========================================
           OVERLAY
        ======================================== */

        .overlay-caja {
            position: fixed;

            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, 0.60);

            display: flex;

            align-items: center;
            justify-content: center;

            z-index: 9999;

            padding: 20px;
        }

        /* ========================================
           MODAL
        ======================================== */

        .modal-caja {
            width: 100%;

            max-width: 460px;

            background: white;

            border-radius: 20px;

            padding: 35px;

            text-align: center;

            box-shadow:
                0 10px 40px rgba(0, 0, 0, 0.30);

            animation: aparecerCaja 0.35s ease;
        }

        @keyframes aparecerCaja {

            from {
                opacity: 0;

                transform: scale(0.85);
            }

            to {
                opacity: 1;

                transform: scale(1);
            }

        }

        /* ========================================
           ICONOS MODALES
        ======================================== */

        .icono-exito {
            width: 80px;
            height: 80px;

            margin: 0 auto 18px;

            border-radius: 50%;

            background: #e8f5e9;

            color: #2e7d32;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 38px;
        }

        .icono-informacion {
            width: 75px;
            height: 75px;

            margin: 0 auto 18px;

            border-radius: 50%;

            background: #f3e5f5;

            color: #6a1b9a;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 34px;
        }

        .icono-advertencia {
            width: 80px;
            height: 80px;

            margin: 0 auto 18px;

            border-radius: 50%;

            background: #fff8e1;

            color: #f9a825;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 38px;
        }

        /* ========================================
           TITULOS MODAL
        ======================================== */

        .modal-caja h2 {
            margin: 0 0 10px;

            color: #333;

            font-size: 28px;
        }

        .mensaje-caja {
            color: #777;

            margin: 0 0 25px;

            font-size: 15px;

            line-height: 1.5;
        }

        /* ========================================
           INFORMACION APERTURA
        ======================================== */

        .informacion-apertura {
            background: #f8f5fa;

            border-radius: 12px;

            padding: 18px;

            margin-bottom: 18px;

            text-align: left;
        }

        .informacion-apertura .fila {
            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 9px 0;

            border-bottom: 1px solid #e8e0eb;
        }

        .informacion-apertura .fila:last-child {
            border-bottom: none;
        }

        .informacion-apertura span {
            color: #777;

            font-size: 14px;
        }

        .informacion-apertura strong {
            color: #333;

            font-size: 15px;
        }

        /* ========================================
           ADVERTENCIA
        ======================================== */

        .advertencia-caja {
            display: flex;

            gap: 10px;

            align-items: flex-start;

            text-align: left;

            background: #fff8e1;

            color: #795548;

            border: 1px solid #ffe082;

            border-radius: 10px;

            padding: 14px;

            margin-bottom: 20px;

            font-size: 14px;

            line-height: 1.4;
        }

        .advertencia-caja i {
            color: #f9a825;

            margin-top: 2px;
        }

        /* ========================================
           AVISO FUERA DE HORARIO
        ======================================== */

        .aviso-fuera-horario {
            display: flex;

            gap: 12px;

            align-items: flex-start;

            text-align: left;

            background: #fff3e0;

            color: #6d4c41;

            border: 1px solid #ffcc80;

            border-radius: 12px;

            padding: 16px;

            margin-bottom: 20px;

            font-size: 14px;

            line-height: 1.5;
        }

        .aviso-fuera-horario i {
            color: #ef6c00;

            font-size: 20px;

            margin-top: 2px;
        }

        .aviso-fuera-horario strong {
            color: #e65100;
        }

        /* ========================================
           INPUT DINERO
        ======================================== */

        .grupo-dinero {
            text-align: left;

            margin-bottom: 20px;
        }

        .grupo-dinero label {
            display: block;

            color: #555;

            font-weight: bold;

            margin-bottom: 8px;
        }

        .campo-dinero {
            position: relative;
        }

        .campo-dinero span {
            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            color: #6a1b9a;

            font-size: 20px;

            font-weight: bold;
        }

        .campo-dinero input {
            width: 100%;

            padding: 15px 15px 15px 38px;

            border: 2px solid #dddddd;

            border-radius: 10px;

            font-size: 20px;

            outline: none;

            transition: 0.2s;
        }

        .campo-dinero input:focus {
            border-color: #6a1b9a;

            box-shadow:
                0 0 0 3px rgba(106, 27, 154, 0.10);
        }

        /* ========================================
           BOTONES MODAL
        ======================================== */

        .boton-confirmar {
            width: 100%;

            padding: 16px;

            background: #6a1b9a;

            color: white;

            border: none;

            border-radius: 11px;

            font-size: 17px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .boton-confirmar:hover {
            background: #4a126b;

            transform: translateY(-2px);
        }

        .boton-continuar {
            width: 100%;

            padding: 16px;

            background: #ef6c00;

            color: white;

            border: none;

            border-radius: 11px;

            font-size: 17px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .boton-continuar:hover {
            background: #d84315;

            transform: translateY(-2px);
        }

        .boton-cancelar {
            width: 100%;

            padding: 14px;

            margin-top: 10px;

            background: #eeeeee;

            color: #555;

            border: none;

            border-radius: 11px;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;
        }

        .boton-cancelar:hover {
            background: #dddddd;
        }

        /* ========================================
           DINERO CONFIRMADO
        ======================================== */

        .dinero-inicial {
            background: #f5f1f8;

            border-radius: 12px;

            padding: 18px;

            margin-bottom: 18px;
        }

        .dinero-inicial span {
            display: block;

            color: #777;

            font-size: 14px;

            margin-bottom: 6px;
        }

        .dinero-inicial strong {
            display: block;

            color: #6a1b9a;

            font-size: 32px;
        }

        /* ========================================
           TEXTO CONTINUAR
        ======================================== */

        .texto-continuar {
            margin-top: 22px;

            color: #777;

            font-size: 14px;
        }

        /* ========================================
           BARRA
        ======================================== */

        .barra-tiempo {
            width: 100%;

            height: 5px;

            background: #eeeeee;

            border-radius: 10px;

            overflow: hidden;

            margin-top: 12px;
        }

        #progresoCaja {
            width: 100%;

            height: 100%;

            background: #6a1b9a;

            animation: disminuirTiempo 5s linear forwards;
        }

        @keyframes disminuirTiempo {

            from {
                width: 100%;
            }

            to {
                width: 0%;
            }

        }

        /* ========================================
           ERROR
        ======================================== */

        .mensaje-error {
            background: #ffebee;

            color: #c62828;

            border: 1px solid #ef9a9a;

            border-radius: 10px;

            padding: 12px;

            margin-bottom: 20px;

            font-size: 14px;

            text-align: left;
        }

        /* ========================================
           RESPONSIVO
        ======================================== */

        @media (max-width: 500px) {

            .contenedor {
                padding: 30px 20px;
            }

            h1 {
                font-size: 26px;
            }

            .hora {
                font-size: 36px;
            }

            .dato {
                padding: 14px;
            }

            .etiqueta {
                font-size: 14px;
            }

            .valor {
                font-size: 15px;
            }

            .modal-caja {
                padding: 28px 20px;
            }

            .modal-caja h2 {
                font-size: 25px;
            }

        }

    </style>

</head>


<body>


    <!-- ==================================================
         CONTENEDOR PRINCIPAL
    ================================================== -->

    <div class="contenedor">


        <!-- ICONO -->

        <div class="icono">

            <i class="fa-solid fa-cash-register"></i>

        </div>


        <!-- TITULO -->

        <h1>
            Punto de Venta
        </h1>


        <!-- ==================================================
             DATOS DEL PUNTO DE VENTA
        ================================================== -->

        <div class="datos-punto">


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

                    Nombre de la caja

                </span>

                <span class="valor">

                    {{ $puntoVenta->nombre_caja }}

                </span>

            </div>


        </div>


        <!-- ==================================================
             FECHA
        ================================================== -->

        <div
            class="fecha"
            id="fecha"
        >
            Cargando fecha...
        </div>


        <!-- ==================================================
             HORA
        ================================================== -->

        <div
            class="hora"
            id="hora"
        >
            00:00:00
        </div>


        <!-- ==================================================
             BOTON ABRIR CAJA
        ================================================== -->

        <button
            type="button"
            class="boton-iniciar"
            onclick="mostrarFormularioCaja()"
        >

            <i class="fa-solid fa-play"></i>

            Abrir caja

        </button>


        <!-- ==================================================
             REGRESAR
        ================================================== -->

        @if(auth()->user()->rol === 'admin')

            <a
                href="{{ route('admin.dashboard') }}"
                class="boton-regresar"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Regresar

            </a>

        @else

            <a
                href="{{ route('vendedor.dashboard') }}"
                class="boton-regresar"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Regresar

            </a>

        @endif


    </div>


    <!-- ==================================================
         MODAL APERTURA NORMAL
         08:00 - 19:59
    ================================================== -->

    <div
        class="overlay-caja"
        id="modalApertura"
        style="display: none;"
    >

        <div class="modal-caja">


            <div class="icono-informacion">

                <i class="fa-solid fa-cash-register"></i>

            </div>


            <h2>
                Apertura de caja
            </h2>


            <p class="mensaje-caja">

                Antes de comenzar las operaciones,
                registra el dinero inicial de la caja.

            </p>


            <!-- INFORMACION -->

            <div class="informacion-apertura">


                <div class="fila">

                    <span>
                        Sucursal
                    </span>

                    <strong>
                        {{ $puntoVenta->sucursal }}
                    </strong>

                </div>


                <div class="fila">

                    <span>
                        Caja
                    </span>

                    <strong>
                        {{ $puntoVenta->nombre_caja }}
                    </strong>

                </div>


                <div class="fila">

                    <span>
                        Fecha de apertura
                    </span>

                    <strong id="fechaApertura">
                        —
                    </strong>

                </div>


                <div class="fila">

                    <span>
                        Hora de apertura
                    </span>

                    <strong id="horaApertura">
                        —
                    </strong>

                </div>


            </div>


            <!-- ADVERTENCIA -->

            <div class="advertencia-caja">

                <i class="fa-solid fa-triangle-exclamation"></i>

                <span>

                    Verifica cuidadosamente el dinero de cambio
                    antes de abrir la caja. Esta cantidad será
                    registrada como dinero inicial.

                </span>

            </div>


            <!-- FORMULARIO NORMAL -->

            <form
                action="{{ route('punto_venta.abrir', $puntoVenta->id) }}"
                method="POST"
            >

                @csrf


                <div class="grupo-dinero">

                    <label for="dinero_inicial">

                        Dinero inicial / Cambio

                    </label>


                    <div class="campo-dinero">

                        <span>
                            $
                        </span>

                        <input
                            type="number"
                            name="dinero_inicial"
                            id="dinero_inicial"
                            min="0"
                            step="0.01"
                            placeholder="0.00"
                            required
                            autofocus
                        >

                    </div>

                </div>


                <button
                    type="submit"
                    class="boton-confirmar"
                >

                    <i class="fa-solid fa-check"></i>

                    Confirmar apertura

                </button>


                <button
                    type="button"
                    class="boton-cancelar"
                    onclick="cerrarFormularioCaja()"
                >

                    Cancelar

                </button>


            </form>


        </div>

    </div>


    <!-- ==================================================
         MODAL FUERA DE HORARIO
    ================================================== -->

    <div
        class="overlay-caja"
        id="modalFueraHorario"
        style="display: none;"
    >

        <div class="modal-caja">


            <!-- ICONO -->

            <div class="icono-advertencia">

                <i class="fa-solid fa-clock"></i>

            </div>


            <!-- TITULO -->

            <h2>
                Apertura fuera de horario
            </h2>


            <!-- MENSAJE -->

            <p class="mensaje-caja">

                Actualmente estás intentando abrir la caja
                fuera del horario normal de trabajo.

            </p>


            <!-- INFORMACION -->

            <div class="informacion-apertura">


                <div class="fila">

                    <span>
                        Horario de trabajo
                    </span>

                    <strong>
                        08:00 - 20:00
                    </strong>

                </div>


                <div class="fila">

                    <span>
                        Hora actual
                    </span>

                    <strong id="horaFueraHorario">
                        —
                    </strong>

                </div>


            </div>


            <!-- AVISO -->

            <div class="aviso-fuera-horario">

                <i class="fa-solid fa-circle-exclamation"></i>

                <span>

                    <strong>Importante:</strong>

                    no se solicitará dinero inicial.

                    <br><br>

                    Las ventas realizadas fuera del horario
                    de trabajo se considerarán para el
                    <strong>día siguiente</strong>.

                </span>

            </div>


            <!-- FORMULARIO -->

            <form
                action="{{ route('punto_venta.abrir', $puntoVenta->id) }}"
                method="POST"
            >

                @csrf

                <!--
                    El controlador detectará que estamos
                    fuera del horario y asignará dinero
                    inicial = 0.
                -->


                <button
                    type="submit"
                    class="boton-continuar"
                >

                    <i class="fa-solid fa-arrow-right"></i>

                    Continuar sin dinero inicial

                </button>


                <button
                    type="button"
                    class="boton-cancelar"
                    onclick="cerrarFueraHorario()"
                >

                    Cancelar

                </button>


            </form>


        </div>

    </div>


    <!-- ==================================================
         MENSAJE DE ERROR
    ================================================== -->

    @if(session('error'))

        <div
            class="overlay-caja"
            id="modalError"
        >

            <div class="modal-caja">


                <div
                    class="icono-informacion"
                    style="
                        background:#ffebee;
                        color:#c62828;
                    "
                >

                    <i class="fa-solid fa-xmark"></i>

                </div>


                <h2>
                    No se pudo abrir
                </h2>


                <p class="mensaje-caja">

                    {{ session('error') }}

                </p>


                <button
                    type="button"
                    class="boton-confirmar"
                    onclick="document.getElementById('modalError').style.display='none'"
                >

                    Entendido

                </button>


            </div>

        </div>

    @endif


    <!-- ==================================================
         VENTANA DE APERTURA CORRECTA
    ================================================== -->

    @if(session('mostrar_apertura'))

        <div
            class="overlay-caja"
            id="overlayCaja"
        >

            <div class="modal-caja">


                <div class="icono-exito">

                    <i class="fa-solid fa-check"></i>

                </div>


                <h2>
                    ¡Caja abierta!
                </h2>


                <p class="mensaje-caja">

                    La caja está lista para comenzar operaciones.

                </p>


                <!-- DINERO -->

                <div class="dinero-inicial">

                    <span>
                        Dinero inicial / Cambio
                    </span>

                    <strong>

                        ${{ number_format(session('dinero_inicial', 0), 2) }}

                    </strong>

                </div>


                <!-- INFORMACION -->

                <div class="informacion-apertura">


                    <div class="fila">

                        <span>
                            Fecha de apertura
                        </span>

                        <strong>

                            {{ session('fecha_apertura') }}

                        </strong>

                    </div>


                    <div class="fila">

                        <span>
                            Hora de apertura
                        </span>

                        <strong>

                            {{ session('hora_apertura') }}

                        </strong>

                    </div>


                </div>


                <!-- AVISO SI FUE FUERA DE HORARIO -->

                @if(session('caja_fuera_horario'))

                    <div class="aviso-fuera-horario">

                        <i class="fa-solid fa-clock"></i>

                        <span>

                            La caja fue abierta

                            <strong>fuera del horario normal.</strong>

                            Las ventas realizadas fuera del horario
                            se considerarán para el día siguiente.

                        </span>

                    </div>

                @else

                    <div class="advertencia-caja">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        <span>

                            El dinero inicial quedó registrado.
                            Revisa que la cantidad mostrada sea correcta
                            antes de comenzar a realizar operaciones.

                        </span>

                    </div>

                @endif


                <!-- TEXTO -->

                <div class="texto-continuar">

                    Entrando a la caja registradora...

                </div>


                <!-- BARRA -->

                <div class="barra-tiempo">

                    <div id="progresoCaja"></div>

                </div>


            </div>

        </div>


        <!-- REDIRECCIONAR -->

        <script>

            setTimeout(function () {

                window.location.href =
                    "{{ route('punto_venta.caja', $puntoVenta->id) }}";

            }, 5000);

        </script>

    @endif


    <!-- ==================================================
         JAVASCRIPT
    ================================================== -->

    <script>


        /* ========================================
           FECHA Y HORA
        ======================================== */

        function actualizarFechaHora() {

            const ahora = new Date();


            /* =========================
               FECHA
            ========================= */

            const opcionesFecha = {

                weekday: 'long',

                year: 'numeric',

                month: 'long',

                day: 'numeric'

            };


            let fecha =
                ahora.toLocaleDateString(
                    'es-MX',
                    opcionesFecha
                );


            fecha =
                fecha.charAt(0).toUpperCase() +
                fecha.slice(1);


            document.getElementById('fecha').textContent =
                fecha;


            /* =========================
               HORA
            ========================= */

            const horas =
                String(
                    ahora.getHours()
                ).padStart(2, '0');


            const minutos =
                String(
                    ahora.getMinutes()
                ).padStart(2, '0');


            const segundos =
                String(
                    ahora.getSeconds()
                ).padStart(2, '0');


            document.getElementById('hora').textContent =
                `${horas}:${minutos}:${segundos}`;

        }


        actualizarFechaHora();


        setInterval(
            actualizarFechaHora,
            1000
        );


        /* ========================================
           MOSTRAR VENTANA DE APERTURA
        ======================================== */

        function mostrarFormularioCaja() {

            const ahora = new Date();

            const hora =
                ahora.getHours();


            /*
             * 08:00 hasta 19:59
             * = horario normal
             */

            const dentroHorario =
                hora >= 8 &&
                hora < 20;


            if (dentroHorario) {

                /*
                 * APERTURA NORMAL
                 */

                document.getElementById(
                    'modalApertura'
                ).style.display = 'flex';


                actualizarDatosApertura();


                setTimeout(function () {

                    const input =
                        document.getElementById(
                            'dinero_inicial'
                        );


                    if (input) {

                        input.focus();

                    }

                }, 100);


            } else {

                /*
                 * APERTURA FUERA DE HORARIO
                 */

                document.getElementById(
                    'modalFueraHorario'
                ).style.display = 'flex';


                actualizarHoraFueraHorario();

            }

        }


        /* ========================================
           CERRAR APERTURA NORMAL
        ======================================== */

        function cerrarFormularioCaja() {

            document.getElementById(
                'modalApertura'
            ).style.display = 'none';

        }


        /* ========================================
           CERRAR FUERA DE HORARIO
        ======================================== */

        function cerrarFueraHorario() {

            document.getElementById(
                'modalFueraHorario'
            ).style.display = 'none';

        }


        /* ========================================
           FECHA Y HORA APERTURA
        ======================================== */

        function actualizarDatosApertura() {

            const ahora = new Date();


            const fecha =
                ahora.toLocaleDateString(
                    'es-MX',
                    {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    }
                );


            const hora =
                ahora.toLocaleTimeString(
                    'es-MX',
                    {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    }
                );


            document.getElementById(
                'fechaApertura'
            ).textContent = fecha;


            document.getElementById(
                'horaApertura'
            ).textContent = hora;

        }


        /* ========================================
           HORA FUERA DE HORARIO
        ======================================== */

        function actualizarHoraFueraHorario() {

            const ahora = new Date();


            const hora =
                ahora.toLocaleTimeString(
                    'es-MX',
                    {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    }
                );


            const elemento =
                document.getElementById(
                    'horaFueraHorario'
                );


            if (elemento) {

                elemento.textContent = hora;

            }

        }


        /* ========================================
           ESCAPE PARA CERRAR MODALES
        ======================================== */

        document.addEventListener(
            'keydown',
            function(event) {

                if (event.key === 'Escape') {

                    cerrarFormularioCaja();

                    cerrarFueraHorario();

                }

            }
        );


    </script>


</body>

</html>