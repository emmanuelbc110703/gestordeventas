<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Seguimiento de cotización - Los Amates
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
            font-size: 15px;
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
            color: #333;
        }

        .folio {
            color: #6a1b9a;
            font-weight: bold;
        }


        /* ========================================
           BOTÓN VOLVER
        ======================================== */

        .volver {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            color: #6a1b9a;

            text-decoration: none;

            font-weight: bold;
        }

        .volver:hover {
            text-decoration: underline;
        }


        /* ========================================
           TARJETAS
        ======================================== */

        .tarjeta {
            background: white;
            border-radius: 12px;
            padding: 22px;

            box-shadow: 0 3px 10px rgba(0,0,0,.12);

            margin-bottom: 20px;
        }

        .tarjeta h3 {
            margin-top: 0;
            color: #6a1b9a;
        }


        /* ========================================
           ESTADO
        ======================================== */

        .estado-contenedor {
            text-align: center;
        }

        .estado {
            display: inline-block;

            padding: 10px 20px;

            border-radius: 25px;

            font-size: 15px;
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
           PROGRESO
        ======================================== */

        .progreso {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;

            margin-top: 25px;
        }

        .paso {
            text-align: center;
            color: #aaa;
            font-size: 13px;
        }

        .paso .circulo {
            width: 42px;
            height: 42px;

            margin: 0 auto 8px;

            border-radius: 50%;

            background: #ddd;
            color: #777;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: bold;
        }

        .paso.activo {
            color: #6a1b9a;
            font-weight: bold;
        }

        .paso.activo .circulo {
            background: #6a1b9a;
            color: white;
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
            background: #f8f8f8;
            border-radius: 8px;
            padding: 14px;
        }

        .dato strong {
            display: block;
            margin-bottom: 5px;
            color: #6a1b9a;
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
        }

        th {
            background: #6a1b9a;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #fafafa;
        }


        /* ========================================
           TOTALES
        ======================================== */

        .totales {
            max-width: 400px;
            margin-left: auto;
            margin-top: 20px;
        }

        .fila-total {
            display: flex;
            justify-content: space-between;

            padding: 9px 0;

            border-bottom: 1px solid #eee;
        }

        .fila-total.descuento {
            color: #198754;
        }

        .fila-total.impuesto {
            color: #555;
        }

        .total-final {
            display: flex;
            justify-content: space-between;

            margin-top: 10px;
            padding-top: 15px;

            border-top: 2px solid #6a1b9a;

            font-size: 22px;
            font-weight: bold;

            color: #6a1b9a;
        }


        /* ========================================
           RESPONSIVO
        ======================================== */

        @media (max-width: 700px) {

            .cabecera {
                flex-direction: column;
                align-items: flex-start;
            }

            .informacion {
                grid-template-columns: 1fr;
            }

            .progreso {
                grid-template-columns: repeat(2, 1fr);
                row-gap: 20px;
            }

            th,
            td {
                white-space: nowrap;
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
            Seguimiento de cotización
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

            <div>

                <h2>
                    Mi cotización
                </h2>

                <div class="folio">
                    {{ $cotizacion->folio }}
                </div>

            </div>


            <a
                href="{{ route('cliente.cotizaciones') }}"
                class="volver"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Volver a cotizaciones

            </a>

        </div>


        {{-- ========================================
             ESTADO
        ======================================== --}}

        <div class="tarjeta estado-contenedor">

            <h3>
                Estado del pedido
            </h3>


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


            {{-- ====================================
                 PROGRESO
            ==================================== --}}

            @php

                $estados = [
                    'enviado' => 1,
                    'procesando' => 2,
                    'finalizado' => 3,
                    'terminado' => 4
                ];

                $estadoActual =
                    $estados[$cotizacion->estado] ?? 1;

            @endphp


            <div class="progreso">


                {{-- ENVIADO --}}

                <div
                    class="paso
                    {{ $estadoActual >= 1 ? 'activo' : '' }}"
                >

                    <div class="circulo">

                        <i class="fa-solid fa-paper-plane"></i>

                    </div>

                    Enviado

                </div>


                {{-- PROCESANDO --}}

                <div
                    class="paso
                    {{ $estadoActual >= 2 ? 'activo' : '' }}"
                >

                    <div class="circulo">

                        <i class="fa-solid fa-gears"></i>

                    </div>

                    Procesando

                </div>


                {{-- FINALIZADO --}}

                <div
                    class="paso
                    {{ $estadoActual >= 3 ? 'activo' : '' }}"
                >

                    <div class="circulo">

                        <i class="fa-solid fa-check"></i>

                    </div>

                    Finalizado

                </div>


                {{-- TERMINADO --}}

                <div
                    class="paso
                    {{ $estadoActual >= 4 ? 'activo' : '' }}"
                >

                    <div class="circulo">

                        <i class="fa-solid fa-flag-checkered"></i>

                    </div>

                    Terminado

                </div>


            </div>

        </div>


        {{-- ========================================
             INFORMACIÓN
        ======================================== --}}

        <div class="tarjeta">

            <h3>
                <i class="fa-solid fa-circle-info"></i>
                Información de la cotización
            </h3>


            <div class="informacion">


                <div class="dato">

                    <strong>
                        Folio
                    </strong>

                    {{ $cotizacion->folio }}

                </div>


                <div class="dato">

                    <strong>
                        Fecha
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
                        Cliente
                    </strong>

                    {{ $cotizacion->usuario->name ?? 'Cliente' }}

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

                        @foreach($cotizacion->detalles as $detalle)

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

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- ====================================
                 TOTALES
            ==================================== --}}

            <div class="totales">


                <div class="fila-total">

                    <span>
                        Subtotal
                    </span>

                    <strong>
                        ${{ number_format($cotizacion->subtotal, 2) }}
                    </strong>

                </div>


                @if($cotizacion->descuento > 0)

                    <div class="fila-total descuento">

                        <span>
                            Descuento
                            ({{ number_format(
                                $cotizacion->descuento_porcentaje,
                                2
                            ) }}%)
                        </span>

                        <strong>
                            -${{ number_format(
                                $cotizacion->descuento,
                                2
                            ) }}
                        </strong>

                    </div>

                @endif


                @if($cotizacion->impuesto > 0)

                    <div class="fila-total impuesto">

                        <span>
                            Impuesto
                            ({{ number_format(
                                $cotizacion->impuesto_porcentaje,
                                2
                            ) }}%)
                        </span>

                        <strong>
                            ${{ number_format(
                                $cotizacion->impuesto,
                                2
                            ) }}
                        </strong>

                    </div>

                @endif


                <div class="total-final">

                    <span>
                        Total
                    </span>

                    <span>
                        ${{ number_format(
                            $cotizacion->total,
                            2
                        ) }}
                    </span>

                </div>


            </div>

        </div>


        {{-- ========================================
             VOLVER
        ======================================== --}}

        <a
            href="{{ route('cliente.cotizaciones') }}"
            class="volver"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Volver a mis cotizaciones

        </a>


    </div>


</body>

</html>