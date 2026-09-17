<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pago de servicios - Administrador - Los Amates</title>

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
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .contenedor {
            width: 95%;
            max-width: 1450px;
            margin: 30px auto;
        }

        /* =========================
           ENCABEZADO
        ========================= */

        .encabezado {
            background: #6a1b9a;
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;

            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .titulo h1 {
            margin: 0;
            font-size: 28px;
        }

        .titulo p {
            margin: 8px 0 0;
            font-size: 15px;
            opacity: .9;
        }

        .btn-agregar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            background: white;
            color: #6a1b9a;

            padding: 12px 18px;
            border-radius: 8px;

            text-decoration: none;
            font-weight: bold;

            transition: .2s;
        }

        .btn-agregar:hover {
            background: #f3e5f5;
            transform: translateY(-1px);
        }

        /* =========================
           MENSAJES
        ========================= */

        .alerta {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alerta-exito {
            background: #d1e7dd;
            color: #0f5132;
        }

        .alerta-error {
            background: #f8d7da;
            color: #842029;
        }

        /* =========================
           CONTENIDO
        ========================= */

        .contenido {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(350px, 1fr);
            gap: 22px;
            align-items: start;
        }

        .panel {
            background: white;
            border-radius: 13px;
            padding: 22px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .08);
        }

        .panel-titulo {
            display: flex;
            align-items: center;
            gap: 9px;

            margin: 0 0 20px;

            color: #444;
            font-size: 20px;
        }

        .panel-titulo i {
            color: #6a1b9a;
        }

        /* =========================
           CALENDARIO
        ========================= */

        .calendario-navegacion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .btn-calendario {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: #6a1b9a;
            color: white;

            text-decoration: none;

            transition: .2s;
        }

        .btn-calendario:hover {
            background: #4a116d;
            color: white;
            transform: scale(1.05);
        }

        .mes-actual {
            font-size: 21px;
            font-weight: bold;
            color: #333;
            text-transform: capitalize;
        }

        .contenedor-hoy {
            text-align: center;
            margin-bottom: 15px;
        }

        .btn-hoy {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 7px 14px;

            border-radius: 7px;

            background: #eee;
            color: #555;

            text-decoration: none;
            font-size: 13px;
            font-weight: bold;

            transition: .2s;
        }

        .btn-hoy:hover {
            background: #6a1b9a;
            color: white;
        }

        /* =========================
           DÍAS DE LA SEMANA
        ========================= */

        .dias-semana {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 5px;
        }

        .dia-semana {
            text-align: center;
            font-weight: bold;
            color: #777;
            padding: 10px 2px;
            font-size: 13px;
        }

        /* =========================
           DÍAS
        ========================= */

        .dias {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .dia {
            min-height: 95px;

            border: 1px solid #e5e5e5;
            border-radius: 7px;

            padding: 7px;

            background: #fafafa;

            overflow: hidden;

            transition: .15s;
        }

        .dia:hover {
            background: #faf7fc;
            border-color: #d6c5f5;
        }

        .dia-vacio {
            background: transparent !important;
            border: none !important;
        }

        .numero {
            font-weight: bold;
            color: #444;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .dia-hoy {
            border: 2px solid #6a1b9a !important;
            background: #f4efff !important;
        }

        .dia-hoy .numero {
            color: #6a1b9a;
        }

        /* =========================
           SERVICIO EN CALENDARIO
        ========================= */

        .servicio-calendario {
            display: block;

            margin-top: 5px;
            padding: 5px 6px;

            border-radius: 5px;

            color: white;

            font-size: 10px;
            font-weight: bold;

            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .servicio-pendiente {
            background: #f0ad4e;
        }

        .servicio-pagado {
            background: #28a745;
        }

        /* =========================
           LISTA DE SERVICIOS
        ========================= */

        .lista-servicios {
            max-height: 650px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .servicio {
            border: 1px solid #e2e2e2;
            border-radius: 10px;

            padding: 15px;
            margin-bottom: 12px;

            transition: .2s;
        }

        .servicio:hover {
            border-color: #cbb7ec;
            box-shadow: 0 2px 8px rgba(106, 27, 154, .08);
        }

        .servicio-cabecera {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            gap: 10px;
        }

        .servicio-nombre {
            font-weight: bold;
            font-size: 17px;
            color: #333;
        }

        .servicio-descripcion {
            color: #777;
            font-size: 13px;
            margin-top: 4px;
        }

        /* =========================
           ESTADO
        ========================= */

        .estado {
            padding: 5px 10px;
            border-radius: 20px;

            font-size: 11px;
            font-weight: bold;

            white-space: nowrap;
        }

        .pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .pagado {
            background: #d1e7dd;
            color: #0f5132;
        }

        /* =========================
           INFORMACIÓN
        ========================= */

        .informacion {
            margin-top: 12px;

            color: #666;

            font-size: 13px;
            line-height: 1.7;
        }

        .informacion strong {
            color: #444;
        }

        /* =========================
           ACCIONES
        ========================= */

        .acciones {
            display: flex;
            gap: 8px;
            margin-top: 13px;
        }

        .btn-editar,
        .btn-eliminar {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            border: none;

            padding: 7px 12px;

            border-radius: 6px;

            color: white;

            cursor: pointer;

            font-size: 12px;
            font-weight: bold;

            text-decoration: none;
        }

        .btn-editar {
            background: #f0ad4e;
        }

        .btn-editar:hover {
            background: #d9952e;
            color: white;
        }

        .btn-eliminar {
            background: #dc3545;
        }

        .btn-eliminar:hover {
            background: #bb2d3b;
        }

        /* =========================
           SIN SERVICIOS
        ========================= */

        .sin-servicios {
            text-align: center;
            color: #888;
            padding: 45px 10px;
        }

        .sin-servicios i {
            display: block;
            font-size: 45px;
            margin-bottom: 15px;
            color: #bbb;
        }

        .sin-servicios p {
            margin: 0 0 5px;
            font-weight: bold;
        }

        /* =========================
           VOLVER
        ========================= */

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

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 1000px) {

            .contenido {
                grid-template-columns: 1fr;
            }

            .lista-servicios {
                max-height: none;
            }
        }

        @media(max-width: 650px) {

            .encabezado {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-agregar {
                width: 100%;
            }

            .panel {
                padding: 15px;
            }

            .dia {
                min-height: 65px;
                padding: 5px;
            }

            .dia-semana {
                font-size: 10px;
            }

            .servicio-calendario {
                font-size: 8px;
                padding: 3px;
            }

            .servicio-cabecera {
                flex-direction: column;
            }

            .acciones {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    {{-- ==================================================
         ENCABEZADO
    ================================================== --}}

    <div class="encabezado">

        <div class="titulo">

            <h1>
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Pago de servicios
            </h1>

            <p>
                Control de los servicios y pagos del negocio.
            </p>

        </div>

        <a
            href="{{ route('admin.pago_servicios.create') }}"
            class="btn-agregar"
        >
            <i class="fa-solid fa-plus"></i>
            Agregar servicio
        </a>

    </div>


    {{-- ==================================================
         MENSAJE DE ÉXITO
    ================================================== --}}

    @if(session('success'))

        <div class="alerta alerta-exito">

            <i class="fa-solid fa-circle-check"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- ==================================================
         ERRORES
    ================================================== --}}

    @if($errors->any())

        <div class="alerta alerta-error">

            <strong>
                <i class="fa-solid fa-triangle-exclamation"></i>
                Hay algunos errores:
            </strong>

            <ul style="margin-bottom:0;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ==================================================
         PREPARAR CALENDARIO
    ================================================== --}}

    @php

        use Carbon\Carbon;

        $mesCalendario = request('mes')
            ? Carbon::createFromFormat(
                'Y-m',
                request('mes')
            )->startOfMonth()
            : Carbon::now()->startOfMonth();

        $inicioMes = $mesCalendario->copy()->startOfMonth();

        /*
         * Carbon:
         * Domingo = 0
         * Lunes = 1
         * ...
         * Sábado = 6
         */

        $primerDiaSemana = $inicioMes->dayOfWeek;

        $diasDelMes = $mesCalendario->daysInMonth;

        $mesAnterior = $mesCalendario
            ->copy()
            ->subMonth()
            ->format('Y-m');

        $mesSiguiente = $mesCalendario
            ->copy()
            ->addMonth()
            ->format('Y-m');

        $meses = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre',
        ];

        $nombreMes =
            $meses[$mesCalendario->month]
            . ' '
            . $mesCalendario->year;

    @endphp


    {{-- ==================================================
         CONTENIDO PRINCIPAL
    ================================================== --}}

    <div class="contenido">


        {{-- ==================================================
             CALENDARIO
        ================================================== --}}

        <div class="panel">

            <h2 class="panel-titulo">

                <i class="fa-regular fa-calendar-days"></i>

                Calendario de pagos

            </h2>


            {{-- NAVEGACIÓN DEL CALENDARIO --}}

            <div class="calendario-navegacion">

                <a
                    href="{{ url()->current() }}?mes={{ $mesAnterior }}"
                    class="btn-calendario"
                    title="Mes anterior"
                >

                    <i class="fa-solid fa-chevron-left"></i>

                </a>


                <div class="mes-actual">

                    {{ ucfirst($nombreMes) }}

                </div>


                <a
                    href="{{ url()->current() }}?mes={{ $mesSiguiente }}"
                    class="btn-calendario"
                    title="Mes siguiente"
                >

                    <i class="fa-solid fa-chevron-right"></i>

                </a>

            </div>


            {{-- BOTÓN HOY --}}

            @if(
                $mesCalendario->format('Y-m')
                !==
                now()->format('Y-m')
            )

                <div class="contenedor-hoy">

                    <a
                        href="{{ url()->current() }}"
                        class="btn-hoy"
                    >

                        <i class="fa-solid fa-calendar-day"></i>

                        Hoy

                    </a>

                </div>

            @endif


            {{-- DÍAS DE LA SEMANA --}}

            <div class="dias-semana">

                <div class="dia-semana">Domingo</div>
                <div class="dia-semana">Lunes</div>
                <div class="dia-semana">Martes</div>
                <div class="dia-semana">Miércoles</div>
                <div class="dia-semana">Jueves</div>
                <div class="dia-semana">Viernes</div>
                <div class="dia-semana">Sábado</div>

            </div>


            {{-- DÍAS DEL MES --}}

            <div class="dias">

                {{-- ESPACIOS ANTES DEL PRIMER DÍA --}}

                @for(
                    $i = 0;
                    $i < $primerDiaSemana;
                    $i++
                )

                    <div class="dia dia-vacio"></div>

                @endfor


                {{-- DÍAS REALES --}}

                @for(
                    $dia = 1;
                    $dia <= $diasDelMes;
                    $dia++
                )

                    @php

                        $fechaActual = $mesCalendario
                            ->copy()
                            ->day($dia);

                        $serviciosDelDia = collect(
                            $servicios ?? []
                        )->filter(
                            function ($servicio) use ($fechaActual) {

                                if (!$servicio->fecha_pago) {
                                    return false;
                                }

                                return Carbon::parse(
                                    $servicio->fecha_pago
                                )->format('Y-m-d')
                                ===
                                $fechaActual->format('Y-m-d');
                            }
                        );

                        $esHoy = $fechaActual->isToday();

                    @endphp


                    <div
                        class="dia {{ $esHoy ? 'dia-hoy' : '' }}"
                    >

                        <div class="numero">
                            {{ $dia }}
                        </div>


                        @foreach(
                            $serviciosDelDia as $servicio
                        )

                            <div
                                class="servicio-calendario
                                {{ $servicio->estado === 'Pagado'
                                    ? 'servicio-pagado'
                                    : 'servicio-pendiente' }}"
                                title="{{ $servicio->servicio }}"
                            >

                                @if(
                                    $servicio->estado === 'Pagado'
                                )

                                    <i class="fa-solid fa-circle-check"></i>

                                @else

                                    <i class="fa-solid fa-clock"></i>

                                @endif

                                {{ $servicio->servicio }}

                            </div>

                        @endforeach

                    </div>

                @endfor

            </div>

        </div>


        {{-- ==================================================
             SERVICIOS REGISTRADOS
        ================================================== --}}

        <div class="panel">

            <h2 class="panel-titulo">

                <i class="fa-solid fa-list"></i>

                Servicios registrados

            </h2>


            <div class="lista-servicios">

                @forelse(
                    $servicios ?? []
                    as $servicio
                )

                    <div class="servicio">


                        {{-- CABECERA --}}

                        <div class="servicio-cabecera">

                            <div>

                                <div class="servicio-nombre">

                                    {{ $servicio->servicio }}

                                </div>


                                @if($servicio->descripcion)

                                    <div class="servicio-descripcion">

                                        {{ $servicio->descripcion }}

                                    </div>

                                @endif

                            </div>


                            {{-- ESTADO --}}

                            @if(
                                $servicio->estado === 'Pagado'
                            )

                                <span class="estado pagado">

                                    <i class="fa-solid fa-check"></i>

                                    Pagado

                                </span>

                            @else

                                <span class="estado pendiente">

                                    <i class="fa-solid fa-clock"></i>

                                    Pendiente

                                </span>

                            @endif

                        </div>


                        {{-- INFORMACIÓN --}}

                        <div class="informacion">

                            <div>

                                <strong>

                                    <i class="fa-regular fa-calendar"></i>

                                    Fecha de pago:

                                </strong>

                                {{ $servicio->fecha_pago
                                    ? Carbon::parse($servicio->fecha_pago)->format('d/m/Y')
                                    : 'Sin fecha' }}

                            </div>


                            <div>

                                <strong>

                                    <i class="fa-solid fa-dollar-sign"></i>

                                    Monto:

                                </strong>

                                ${{ number_format(
                                    $servicio->monto ?? 0,
                                    2
                                ) }}

                            </div>


                            @if($servicio->fecha_vencimiento)

                                <div>

                                    <strong>

                                        <i class="fa-solid fa-calendar-xmark"></i>

                                        Vencimiento:

                                    </strong>

                                    {{ Carbon::parse(
                                        $servicio->fecha_vencimiento
                                    )->format('d/m/Y') }}

                                </div>

                            @endif


                            @if($servicio->observaciones)

                                <div>

                                    <strong>

                                        <i class="fa-solid fa-note-sticky"></i>

                                        Observaciones:

                                    </strong>

                                    {{ $servicio->observaciones }}

                                </div>

                            @endif

                        </div>


                        {{-- ACCIONES --}}

                        <div class="acciones">

                            <a
                                href="{{ route(
                                    'admin.pago_servicios.edit',
                                    $servicio->id
                                ) }}"
                                class="btn-editar"
                            >

                                <i class="fa-solid fa-pen"></i>

                                Editar

                            </a>


                            <form
                                action="{{ route(
                                    'admin.pago_servicios.destroy',
                                    $servicio->id
                                ) }}"
                                method="POST"
                                onsubmit="return confirm(
                                    '¿Deseas eliminar este servicio?'
                                );"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn-eliminar"
                                >

                                    <i class="fa-solid fa-trash"></i>

                                    Eliminar

                                </button>

                            </form>

                        </div>

                    </div>

                @empty

                    <div class="sin-servicios">

                        <i class="fa-solid fa-file-circle-xmark"></i>

                        <p>
                            No hay servicios registrados.
                        </p>

                        <small>
                            Agrega tu primer servicio para comenzar.
                        </small>

                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- ==================================================
         VOLVER AL PANEL
    ================================================== --}}

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

