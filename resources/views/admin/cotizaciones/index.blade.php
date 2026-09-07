<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cotizaciones - Administrador - Los Amates</title>

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
            max-width: 1200px;
            margin: 35px auto;
        }


        /* ========================================
           CABECERA
        ======================================== */

        .cabecera-pagina {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;

            margin-bottom: 25px;
        }

        .cabecera-pagina h2 {
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
           TABLA
        ======================================== */

        .tabla-contenedor {
            background: white;

            border-radius: 12px;

            box-shadow:
                0 3px 10px rgba(0,0,0,.12);

            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        thead {
            background: #6a1b9a;
            color: white;
        }

        th {
            padding: 14px 12px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #faf7fc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }


        /* ========================================
           FOLIO
        ======================================== */

        .folio {
            color: #6a1b9a;
            font-weight: bold;
        }


        /* ========================================
           ESTADOS
        ======================================== */

        .estado {
            display: inline-block;

            padding: 6px 10px;

            border-radius: 20px;

            font-size: 11px;

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
           TOTAL
        ======================================== */

        .total {
            color: #6a1b9a;
            font-weight: bold;
            font-size: 16px;
        }


        /* ========================================
           BOTÓN VER
        ======================================== */

        .boton-ver {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 7px;

            background: #6a1b9a;

            color: white;

            padding: 9px 13px;

            border-radius: 7px;

            text-decoration: none;

            font-weight: bold;

            font-size: 13px;

            transition: .3s;
        }

        .boton-ver:hover {
            background: #4a116d;
            transform: translateY(-1px);
        }


        /* ========================================
           VACÍO
        ======================================== */

        .vacio {
            background: white;

            border-radius: 12px;

            padding: 60px 25px;

            text-align: center;

            box-shadow:
                0 3px 10px rgba(0,0,0,.12);
        }

        .vacio i {
            font-size: 55px;
            color: #6a1b9a;
            margin-bottom: 15px;
        }

        .vacio h3 {
            margin: 5px 0 10px;
        }

        .vacio p {
            color: #777;
        }


        /* ========================================
           BOTÓN VOLVER
        ======================================== */

        .volver {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            margin-top: 25px;

            color: #6a1b9a;

            text-decoration: none;

            font-weight: bold;
        }

        .volver:hover {
            text-decoration: underline;
        }


        /* ========================================
           RESPONSIVO
        ======================================== */

        @media (max-width: 700px) {

            .cabecera-pagina {
                flex-direction: column;
                align-items: flex-start;
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
            Cotizaciones
        </h1>

        <p>
            Panel de administración -
            Orquídeas y más "Los Amates"
        </p>

    </div>


    <div class="contenedor">


        {{-- ========================================
             CABECERA
        ======================================== --}}

        <div class="cabecera-pagina">

            <h2>
                Pedidos de clientes
            </h2>

        </div>


        {{-- ========================================
             MENSAJE DE ÉXITO
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
             COTIZACIONES
        ======================================== --}}

        @if($cotizaciones->isEmpty())


            <div class="vacio">

                <i class="fa-solid fa-file-invoice"></i>

                <h3>
                    No hay cotizaciones
                </h3>

                <p>
                    Actualmente no existen pedidos
                    realizados por los clientes.
                </p>

            </div>


        @else


            <div class="tabla-contenedor">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Folio
                            </th>

                            <th>
                                Cliente
                            </th>

                            <th>
                                Fecha
                            </th>

                            <th>
                                Servicios
                            </th>

                            <th>
                                Forma de pago
                            </th>

                            <th>
                                Estado
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($cotizaciones as $cotizacion)

                            <tr>


                                {{-- FOLIO --}}

                                <td>

                                    <span class="folio">

                                        {{ $cotizacion->folio }}

                                    </span>

                                </td>


                                {{-- CLIENTE --}}

                                <td>

                                    {{ $cotizacion->usuario->name ?? 'Sin nombre' }}

                                </td>


                                {{-- FECHA --}}

                                <td>

                                    {{ $cotizacion->created_at?->format('d/m/Y H:i') }}

                                </td>


                                {{-- SERVICIOS --}}

                                <td>

                                    {{ $cotizacion->detalles->sum('cantidad') }}

                                </td>


                                {{-- FORMA DE PAGO --}}

                                <td>

                                    {{ ucfirst($cotizacion->forma_pago) }}

                                </td>


                                {{-- ESTADO --}}

                                <td>

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

                                </td>


                                {{-- TOTAL --}}

                                <td>

                                    <span class="total">

                                        ${{ number_format(
                                            $cotizacion->total,
                                            2
                                        ) }}

                                    </span>

                                </td>


                                {{-- ACCIÓN --}}

                                <td>

                                    <a
                                        href="{{ route(
                                            'admin.cotizaciones.mostrar',
                                            $cotizacion->id
                                        ) }}"
                                        class="boton-ver"
                                    >

                                        <i class="fa-solid fa-eye"></i>

                                        Ver

                                    </a>

                                </td>


                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


        @endif


        {{-- ========================================
             VOLVER
        ======================================== --}}

        <a
            href="{{ route('admin.dashboard') }}"
            class="volver"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Volver al panel

        </a>


    </div>


</body>

</html>