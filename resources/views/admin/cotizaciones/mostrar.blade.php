<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Cotización {{ $cotizacion->folio }} - Los Amates
    </title>

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
            background: #f4f4f4;
            color: #333;
        }

        /* ========================================
           ENCABEZADO
        ======================================== */

        .encabezado {
            background: #6a1b9a;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .encabezado h1 {
            margin: 0;
            font-size: 28px;
        }

        .encabezado p {
            margin: 8px 0 0;
        }


        /* ========================================
           CONTENEDOR
        ======================================== */

        .contenedor {
            width: 92%;
            max-width: 1100px;
            margin: 35px auto;
        }


        /* ========================================
           CABECERA
        ======================================== */

        .cabecera {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .cabecera h2 {
            margin: 0;
        }


        /* ========================================
           MENSAJES
        ======================================== */

        .mensaje {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .mensaje-exito {
            background: #d1e7dd;
            color: #0f5132;
        }

        .mensaje-error {
            background: #f8d7da;
            color: #842029;
        }


        /* ========================================
           TARJETAS
        ======================================== */

        .tarjeta {
            background: white;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 20px;

            box-shadow:
                0 3px 10px rgba(0,0,0,.12);
        }

        .tarjeta h3 {
            margin-top: 0;
            color: #6a1b9a;
        }


        /* ========================================
           INFORMACIÓN
        ======================================== */

        .informacion {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .dato {
            padding: 12px;
            background: #fafafa;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .dato strong {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }


        /* ========================================
           FOLIO
        ======================================== */

        .folio {
            color: #6a1b9a;
            font-size: 20px;
            font-weight: bold;
        }


        /* ========================================
           ESTADOS
        ======================================== */

        .estado {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .estado-enviado {
            background: #fff3cd;
            color: #856404;
        }

        .estado-procesando {
            background: #cfe2ff;
            color: #084298;
        }

        .estado-finalizado {
            background: #d1e7dd;
            color: #0f5132;
        }

        .estado-terminado {
            background: #e2e3e5;
            color: #41464b;
        }


        /* ========================================
           TABLA
        ======================================== */

        .tabla-contenedor {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        thead {
            background: #6a1b9a;
            color: white;
        }

        th,
        td {
            padding: 13px 12px;
            text-align: left;
        }

        td {
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #faf7fc;
        }


        /* ========================================
           TOTALES
        ======================================== */

        .totales {
            margin-top: 20px;
            margin-left: auto;
            max-width: 350px;
        }

        .linea-total {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .linea-total.total-final {
            border-top: 2px solid #eee;
            margin-top: 8px;
            padding-top: 14px;

            font-size: 21px;
            font-weight: bold;
            color: #6a1b9a;
        }


        /* ========================================
           ACCIONES
        ======================================== */

        .acciones {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .boton {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            border: none;
            border-radius: 7px;

            padding: 11px 16px;

            color: white;

            text-decoration: none;

            font-weight: bold;

            cursor: pointer;

            transition: .3s;
        }

        .boton:hover {
            transform: translateY(-2px);
        }

        .boton-procesar {
            background: #0d6efd;
        }

        .boton-procesar:hover {
            background: #0b5ed7;
        }

        .boton-editar {
            background: #6a1b9a;
        }

        .boton-editar:hover {
            background: #4a116d;
        }

        .boton-finalizar {
            background: #198754;
        }

        .boton-finalizar:hover {
            background: #146c43;
        }

        .boton-terminar {
            background: #495057;
        }

        .boton-terminar:hover {
            background: #343a40;
        }

        .boton-volver {
            background: #6c757d;
        }

        .boton-volver:hover {
            background: #565e64;
        }


        /* ========================================
           FORMULARIOS
        ======================================== */

        .form-accion {
            margin: 0;
        }


        /* ========================================
           RESPONSIVO
        ======================================== */

        @media (max-width: 700px) {

            .informacion {
                grid-template-columns: 1fr;
            }

            .cabecera {
                flex-direction: column;
                align-items: flex-start;
            }

            .acciones {
                flex-direction: column;
            }

            .boton {
                width: 100%;
            }

        }

    </style>

</head>


<body>


    {{-- ========================================
         ENCABEZADO
    ======================================== --}}

    <div class="encabezado">

        <h1>
            Detalle de cotización
        </h1>

        <p>
            Orquídeas y más "Los Amates"
        </p>

    </div>


    <div class="contenedor">


        {{-- ========================================
             CABECERA
        ======================================== --}}

        <div class="cabecera">

            <h2>

                Cotización

                <span class="folio">
                    {{ $cotizacion->folio }}
                </span>

            </h2>


            <span
                class="estado estado-{{ $cotizacion->estado }}"
            >

                @if($cotizacion->estado === 'enviado')

                    Enviado

                @elseif($cotizacion->estado === 'procesando')

                    Procesando

                @elseif($cotizacion->estado === 'finalizado')

                    Finalizado

                @elseif($cotizacion->estado === 'terminado')

                    Terminado

                @endif

            </span>

        </div>


        {{-- ========================================
             MENSAJE ÉXITO
        ======================================== --}}

        @if(session('success'))

            <div class="mensaje mensaje-exito">

                <i class="fa-solid fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- ========================================
             ERRORES
        ======================================== --}}

        @if($errors->any())

            <div class="mensaje mensaje-error">

                <i class="fa-solid fa-circle-exclamation"></i>

                {{ $errors->first() }}

            </div>

        @endif


        {{-- ========================================
             DATOS DEL CLIENTE
        ======================================== --}}

        <div class="tarjeta">

            <h3>
                <i class="fa-solid fa-user"></i>
                Información del cliente
            </h3>


            <div class="informacion">

                <div class="dato">

                    <strong>
                        Nombre
                    </strong>

                    {{ $cotizacion->usuario->name ?? 'Sin nombre' }}

                </div>


                <div class="dato">

                    <strong>
                        Fecha de solicitud
                    </strong>

                    {{ $cotizacion->created_at?->format('d/m/Y H:i') }}

                </div>


                <div class="dato">

                    <strong>
                        Forma de pago
                    </strong>

                    {{ ucfirst($cotizacion->forma_pago) }}

                </div>


                <div class="dato">

                    <strong>
                        Estado
                    </strong>

                    <span
                        class="estado estado-{{ $cotizacion->estado }}"
                    >

                        @if($cotizacion->estado === 'enviado')

                            Enviado

                        @elseif($cotizacion->estado === 'procesando')

                            Procesando

                        @elseif($cotizacion->estado === 'finalizado')

                            Finalizado

                        @elseif($cotizacion->estado === 'terminado')

                            Terminado

                        @endif

                    </span>

                </div>

            </div>

        </div>


        {{-- ========================================
             SERVICIOS
        ======================================== --}}

        <div class="tarjeta">

            <h3>
                <i class="fa-solid fa-list"></i>
                Servicios solicitados
            </h3>


            <div class="tabla-contenedor">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Servicio
                            </th>

                            <th>
                                Cantidad
                            </th>

                            <th>
                                Precio
                            </th>

                            <th>
                                Subtotal
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($cotizacion->detalles as $detalle)

                            <tr>

                                <td>
                                    {{ $detalle->nombre }}
                                </td>

                                <td>
                                    {{ $detalle->cantidad }}
                                </td>

                                <td>
                                    ${{ number_format($detalle->precio, 2) }}
                                </td>

                                <td>
                                    ${{ number_format($detalle->subtotal, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4">

                                    No hay servicios registrados.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- ====================================
                 TOTALES
            ==================================== --}}

            <div class="totales">

                <div class="linea-total">

                    <span>
                        Subtotal:
                    </span>

                    <span>
                        ${{ number_format($cotizacion->subtotal, 2) }}
                    </span>

                </div>


                <div class="linea-total">

                    <span>
                        Descuento
                        ({{ number_format(
                            $cotizacion->descuento_porcentaje,
                            2
                        ) }}%):
                    </span>

                    <span>
                        - ${{ number_format($cotizacion->descuento, 2) }}
                    </span>

                </div>


                <div class="linea-total">

                    <span>
                        Impuesto
                        ({{ number_format(
                            $cotizacion->impuesto_porcentaje,
                            2
                        ) }}%):
                    </span>

                    <span>
                        ${{ number_format($cotizacion->impuesto, 2) }}
                    </span>

                </div>


                <div class="linea-total total-final">

                    <span>
                        Total:
                    </span>

                    <span>
                        ${{ number_format($cotizacion->total, 2) }}
                    </span>

                </div>

            </div>

        </div>


        {{-- ========================================
             ACCIONES
        ======================================== --}}

        <div class="tarjeta">

            <h3>
                <i class="fa-solid fa-gears"></i>
                Acciones
            </h3>


            <div class="acciones">


                {{-- ====================================
                     ENVIADO → PROCESANDO
                ==================================== --}}

                @if($cotizacion->estado === 'enviado')

                    <form
                        action="{{ route(
                            'admin.cotizaciones.procesar',
                            $cotizacion->id
                        ) }}"
                        method="POST"
                        class="form-accion"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="boton boton-procesar"
                        >

                            <i class="fa-solid fa-play"></i>

                            Procesar cotización

                        </button>

                    </form>

                @endif


                {{-- ====================================
                     PROCESANDO → EDITAR
                ==================================== --}}

                @if($cotizacion->estado === 'procesando')

                    <a
                        href="{{ route(
                            'admin.cotizaciones.editar',
                            $cotizacion->id
                        ) }}"
                        class="boton boton-editar"
                    >

                        <i class="fa-solid fa-pen"></i>

                        Editar cotización

                    </a>

                @endif


                {{-- ====================================
                     PROCESANDO → FINALIZAR
                ==================================== --}}

                @if($cotizacion->estado === 'procesando')

                    <form
                        action="{{ route(
                            'admin.cotizaciones.finalizar',
                            $cotizacion->id
                        ) }}"
                        method="POST"
                        class="form-accion"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="boton boton-finalizar"
                        >

                            <i class="fa-solid fa-check"></i>

                            Finalizar cotización

                        </button>

                    </form>

                @endif


                {{-- ====================================
                     FINALIZADO → TERMINADO
                ==================================== --}}

                @if($cotizacion->estado === 'finalizado')

                    <form
                        action="{{ route(
                            'admin.cotizaciones.terminar',
                            $cotizacion->id
                        ) }}"
                        method="POST"
                        class="form-accion"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="boton boton-terminar"
                        >

                            <i class="fa-solid fa-flag-checkered"></i>

                            Marcar como terminado

                        </button>

                    </form>

                @endif


                {{-- ====================================
                     VOLVER
                ==================================== --}}

                <a
                    href="{{ route('admin.cotizaciones') }}"
                    class="boton boton-volver"
                >

                    <i class="fa-solid fa-arrow-left"></i>

                    Volver a cotizaciones

                </a>

            </div>

        </div>


    </div>


</body>

</html>