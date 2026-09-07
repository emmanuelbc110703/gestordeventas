<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cotizaciones - Los Amates</title>

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
            width: 90%;
            max-width: 1100px;
            margin: 35px auto;
        }


        /* ========================================
           CABECERA DE LA PÁGINA
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
            color: #333;
        }


        /* ========================================
           BOTÓN CREAR
        ======================================== */

        .boton-crear {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            background: #6a1b9a;
            color: white;

            padding: 12px 18px;

            border-radius: 8px;

            text-decoration: none;

            font-weight: bold;

            transition: 0.3s;
        }

        .boton-crear:hover {
            background: #4a116d;
            transform: translateY(-2px);
        }


        /* ========================================
           MENSAJE VACÍO
        ======================================== */

        .vacio {
            background: white;
            border-radius: 12px;
            padding: 50px 25px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,.12);
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
            margin-bottom: 20px;
        }


        /* ========================================
           GRID DE COTIZACIONES
        ======================================== */

        .cotizaciones {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }


        /* ========================================
           TARJETA
        ======================================== */

        .tarjeta {
            background: white;
            border-radius: 12px;
            padding: 20px;

            box-shadow: 0 3px 10px rgba(0,0,0,.12);

            transition: 0.3s;
        }

        .tarjeta:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,.16);
        }


        /* ========================================
           PARTE SUPERIOR
        ======================================== */

        .tarjeta-superior {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;

            margin-bottom: 15px;
        }

        .folio {
            font-weight: bold;
            font-size: 17px;
            color: #6a1b9a;
        }


        /* ========================================
           ESTADOS
        ======================================== */

        .estado {
            padding: 6px 10px;
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
           INFORMACIÓN
        ======================================== */

        .informacion {
            font-size: 14px;
            line-height: 1.7;
        }

        .informacion strong {
            color: #333;
        }


        /* ========================================
           TOTAL
        ======================================== */

        .total {
            margin-top: 15px;
            padding-top: 15px;

            border-top: 1px solid #eee;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total span:first-child {
            font-weight: bold;
        }

        .total-precio {
            font-size: 20px;
            font-weight: bold;
            color: #6a1b9a;
        }


        /* ========================================
           BOTÓN VER
        ======================================== */

        .boton-ver {
            display: block;

            margin-top: 15px;

            text-align: center;

            background: #6a1b9a;
            color: white;

            padding: 10px;

            border-radius: 7px;

            text-decoration: none;

            font-weight: bold;

            transition: 0.3s;
        }

        .boton-ver:hover {
            background: #4a116d;
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
                align-items: stretch;
            }

            .boton-crear {
                justify-content: center;
            }

            .cotizaciones {
                grid-template-columns: 1fr;
            }

            .tarjeta-superior {
                align-items: flex-start;
                flex-direction: column;
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
            Orquídeas y más "Los Amates"
        </p>

    </div>


    {{-- ========================================
         CONTENIDO
    ======================================== --}}

    <div class="contenedor">


        <div class="cabecera-pagina">

            <h2>
                Mis pedidos
            </h2>


            <a
                href="{{ route('cliente.cotizaciones.crear') }}"
                class="boton-crear"
            >

                <i class="fa-solid fa-plus"></i>

                Crear cotización

            </a>

        </div>


        {{-- ========================================
             SI NO HAY COTIZACIONES
        ======================================== --}}

        @if($cotizaciones->isEmpty())

            <div class="vacio">

                <i class="fa-solid fa-file-invoice"></i>

                <h3>
                    Todavía no tienes cotizaciones
                </h3>

                <p>
                    Puedes crear una cotización seleccionando
                    los servicios que necesitas.
                </p>

                <a
                    href="{{ route('cliente.cotizaciones.crear') }}"
                    class="boton-crear"
                >

                    <i class="fa-solid fa-cart-plus"></i>

                    Crear mi primera cotización

                </a>

            </div>


        @else


            {{-- ========================================
                 LISTA DE COTIZACIONES
            ======================================== --}}

            <div class="cotizaciones">

                @foreach($cotizaciones as $cotizacion)

                    <div class="tarjeta">


                        {{-- FOLIO + ESTADO --}}

                        <div class="tarjeta-superior">

                            <div class="folio">

                                {{ $cotizacion->folio }}

                            </div>


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


                        {{-- INFORMACIÓN --}}

                        <div class="informacion">

                            <strong>
                                Fecha:
                            </strong>

                            {{ $cotizacion->created_at?->format('d/m/Y H:i') }}

                            <br>


                            <strong>
                                Servicios:
                            </strong>

                            {{ $cotizacion->detalles->sum('cantidad') }}

                            <br>


                            <strong>
                                Forma de pago:
                            </strong>

                            {{ ucfirst($cotizacion->forma_pago) }}

                        </div>


                        {{-- TOTAL --}}

                        <div class="total">

                            <span>
                                Total actual:
                            </span>

                            <span class="total-precio">

                                ${{ number_format($cotizacion->total, 2) }}

                            </span>

                        </div>


                        {{-- VER PEDIDO --}}

                        <a
                            href="{{ route(
                                'cliente.cotizaciones.mostrar',
                                $cotizacion->id
                            ) }}"
                            class="boton-ver"
                        >

                            <i class="fa-solid fa-eye"></i>

                            Ver seguimiento

                        </a>

                    </div>

                @endforeach

            </div>

        @endif


        {{-- VOLVER AL DASHBOARD --}}

        <a
            href="{{ route('cliente.dashboard') }}"
            class="volver"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Volver al panel

        </a>


    </div>

</body>

</html>