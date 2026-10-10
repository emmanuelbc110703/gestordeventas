<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pago de servicios - Gestor de Ventas Los Amates</title>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        :root {
            --morado: #6a1b9a;
            --morado-oscuro: #4a126d;
            --morado-claro: #f3e8f8;
            --blanco: #ffffff;
            --fondo: #f6f5f8;
            --texto: #29252d;
            --texto-suave: #77727c;
            --borde: #e9e5ec;
            --verde: #2e9d67;
            --azul: #3978d4;
            --naranja: #e58a35;
            --rojo: #d9534f;
        }


        /* =====================================
           GENERAL
        ===================================== */

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--fondo);
            color: var(--texto);
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }


        /* =====================================
           BARRA LATERAL
        ===================================== */

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: var(--morado);
            color: white;
            padding: 25px 18px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 100;
        }

        .logo-container {
            text-align: center;
            padding-bottom: 25px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.18);
        }

        .logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
            background: white;
            border-radius: 18px;
            padding: 8px;
            margin-bottom: 12px;
        }

        .logo-container h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .logo-container p {
            margin: 5px 0 0;
            font-size: 12px;
            opacity: 0.75;
        }

        .menu-titulo {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.6;
            margin: 25px 12px 10px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: 0.25s ease;
        }

        .menu a i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .menu a:hover {
            background: rgba(255,255,255,0.14);
            transform: translateX(3px);
        }

        .menu a.activo {
            background: white;
            color: var(--morado);
            font-weight: bold;
        }


        /* =====================================
           CONTENIDO PRINCIPAL
        ===================================== */

        .contenido {
            width: calc(100% - 250px);
            margin-left: 250px;
            min-height: 100vh;
        }


        /* =====================================
           TOPBAR
        ===================================== */

        .topbar {
            height: 82px;
            background: white;
            border-bottom: 1px solid var(--borde);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .saludo h1 {
            margin: 0;
            font-size: 23px;
            color: var(--texto);
        }

        .saludo p {
            margin: 5px 0 0;
            color: var(--texto-suave);
            font-size: 13px;
        }


        /* =====================================
           PERFIL
        ===================================== */

        .perfil {
            position: relative;
        }

        .avatar {
            width: 45px;
            height: 45px;
            border: 3px solid var(--morado-claro);
            border-radius: 50%;
            background-color:
                {{ auth()->user()->color_perfil ?? '#6a1b9a' }};
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 0;
            transition: 0.25s;
        }

        .avatar:hover {
            transform: scale(1.06);
            border-color: var(--morado);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        /* =====================================
           MENÚ PERFIL
        ===================================== */

        .menu-perfil {
            display: none;
            position: absolute;
            top: 58px;
            right: 0;
            width: 210px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: 1px solid var(--borde);
        }

        .menu-perfil.activo {
            display: block;
        }

        .nombre-usuario {
            padding: 16px;
            font-weight: bold;
            color: var(--texto);
            border-bottom: 1px solid var(--borde);
        }

        .nombre-usuario small {
            display: block;
            margin-top: 4px;
            color: var(--texto-suave);
            font-weight: normal;
        }

        .logout-form {
            margin: 0;
        }

        .boton-logout {
            width: 100%;
            padding: 14px 16px;
            background: white;
            color: #d33d3d;
            border: none;
            text-align: left;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s;
        }

        .boton-logout:hover {
            background: #fff0f0;
        }

        .boton-logout i {
            width: 22px;
            margin-right: 6px;
        }


        /* =====================================
           CONTENEDOR
        ===================================== */

        .contenedor {
            padding: 35px;
            max-width: 1500px;
            margin: auto;
        }


        /* =====================================
           CABECERA DE SECCIÓN
        ===================================== */

        .titulo-seccion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .titulo-seccion-contenido {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icono-seccion {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: var(--morado-claro);
            color: var(--morado);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .titulo-seccion h2 {
            margin: 0;
            font-size: 23px;
        }

        .titulo-seccion p {
            margin: 6px 0 0;
            color: var(--texto-suave);
            font-size: 14px;
        }


        /* =====================================
           BOTÓN AGREGAR
        ===================================== */

        .btn-agregar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--morado);
            color: white;
            padding: 12px 18px;
            border-radius: 9px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.25s;
            white-space: nowrap;
        }

        .btn-agregar:hover {
            background: var(--morado-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(106,27,154,0.18);
        }


        /* =====================================
           ALERTAS
        ===================================== */

        .alerta {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alerta-exito {
            background: #e6f4ec;
            color: #176b43;
            border-left: 4px solid var(--verde);
        }

        .alerta-error {
            background: #fde8e8;
            color: #842029;
            border-left: 4px solid var(--rojo);
        }

        .alerta i {
            margin-right: 6px;
        }


        /* =====================================
           CONTENIDO
        ===================================== */

        .contenido-servicios {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(350px, 1fr);
            gap: 20px;
            align-items: start;
        }

        .panel {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 22px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.05);
        }

        .panel-titulo {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 0 0 20px;
            color: var(--texto);
            font-size: 18px;
        }

        .panel-titulo i {
            color: var(--morado);
        }


        /* =====================================
           CALENDARIO
        ===================================== */

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
            border-radius: 10px;
            background: var(--morado-claro);
            color: var(--morado);
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-calendario:hover {
            background: var(--morado);
            color: white;
            transform: scale(1.05);
        }

        .mes-actual {
            font-size: 20px;
            font-weight: bold;
            color: var(--texto);
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
            border-radius: 8px;
            background: #f0edf2;
            color: #555;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn-hoy:hover {
            background: var(--morado);
            color: white;
        }


        /* =====================================
           DÍAS SEMANA
        ===================================== */

        .dias-semana {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 5px;
        }

        .dia-semana {
            text-align: center;
            font-weight: bold;
            color: var(--texto-suave);
            padding: 10px 2px;
            font-size: 12px;
        }


        /* =====================================
           DÍAS
        ===================================== */

        .dias {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .dia {
            min-height: 95px;
            border: 1px solid var(--borde);
            border-radius: 8px;
            padding: 7px;
            background: #fafafa;
            overflow: hidden;
            transition: 0.15s;
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
            border: 2px solid var(--morado) !important;
            background: #f4efff !important;
        }

        .dia-hoy .numero {
            color: var(--morado);
        }


        /* =====================================
           SERVICIO CALENDARIO
        ===================================== */

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
            background: var(--naranja);
        }

        .servicio-pagado {
            background: var(--verde);
        }


        /* =====================================
           LISTA DE SERVICIOS
        ===================================== */

        .lista-servicios {
            max-height: 650px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .servicio {
            border: 1px solid var(--borde);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            transition: 0.2s;
        }

        .servicio:hover {
            border-color: #cbb7ec;
            box-shadow: 0 4px 12px rgba(106,27,154,0.07);
            transform: translateY(-1px);
        }

        .servicio-cabecera {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }

        .servicio-nombre {
            font-weight: bold;
            font-size: 16px;
            color: var(--texto);
        }

        .servicio-descripcion {
            color: var(--texto-suave);
            font-size: 13px;
            margin-top: 4px;
        }


        /* =====================================
           ESTADO
        ===================================== */

        .estado {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            white-space: nowrap;
        }

        .pendiente {
            background: #fff0df;
            color: #9a5b0b;
        }

        .pagado {
            background: #e6f4ec;
            color: #176b43;
        }


        /* =====================================
           INFORMACIÓN
        ===================================== */

        .informacion {
            margin-top: 13px;
            color: var(--texto-suave);
            font-size: 13px;
            line-height: 1.8;
        }

        .informacion strong {
            color: #444;
        }

        .informacion i {
            width: 17px;
            color: var(--morado);
        }


        /* =====================================
           ACCIONES
        ===================================== */

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
            padding: 8px 12px;
            border-radius: 7px;
            color: white;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-editar {
            background: var(--azul);
        }

        .btn-editar:hover {
            background: #2865b7;
            color: white;
            transform: translateY(-1px);
        }

        .btn-eliminar {
            background: var(--rojo);
        }

        .btn-eliminar:hover {
            background: #bd3f3b;
            transform: translateY(-1px);
        }


        /* =====================================
           SIN SERVICIOS
        ===================================== */

        .sin-servicios {
            text-align: center;
            color: var(--texto-suave);
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
            color: #555;
        }


        /* =====================================
           VOLVER
        ===================================== */

        .volver {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 25px;
            color: var(--morado);
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .volver:hover {
            text-decoration: underline;
        }


        /* =====================================
           RESPONSIVE
        ===================================== */

        @media (max-width: 1200px) {

            .contenido-servicios {
                grid-template-columns: 1fr;
            }

            .lista-servicios {
                max-height: none;
            }

        }


        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            .contenido {
                width: calc(100% - 210px);
                margin-left: 210px;
            }

        }


        @media (max-width: 700px) {

            .dashboard {
                display: block;
            }

            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
                padding: 15px;
            }

            .logo-container {
                display: flex;
                align-items: center;
                text-align: left;
                gap: 12px;
                padding-bottom: 15px;
                margin-bottom: 10px;
            }

            .logo {
                width: 55px;
                height: 55px;
                margin: 0;
            }

            .logo-container p {
                display: none;
            }

            .menu-titulo {
                display: none;
            }

            .menu {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }

            .menu a {
                font-size: 12px;
                padding: 10px;
            }

            .contenido {
                width: 100%;
                margin-left: 0;
            }

            .topbar {
                padding: 0 18px;
                height: 72px;
            }

            .saludo h1 {
                font-size: 18px;
            }

            .saludo p {
                font-size: 11px;
            }

            .contenedor {
                padding: 22px 16px;
            }

            .titulo-seccion {
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


        @media (max-width: 450px) {

            .menu {
                grid-template-columns: 1fr 1fr;
            }

            .titulo-seccion-contenido {
                align-items: flex-start;
            }

            .icono-seccion {
                width: 45px;
                height: 45px;
                min-width: 45px;
                font-size: 18px;
            }

            .titulo-seccion h2 {
                font-size: 19px;
            }

            .mes-actual {
                font-size: 17px;
            }

            .dia {
                min-height: 58px;
            }

        }

    </style>

</head>


<body>


<div class="dashboard">


    <!-- =====================================
         BARRA LATERAL
    ====================================== -->

    <aside class="sidebar">

        <div class="logo-container">

            <img
                src="{{ asset('images/logo-los-amates.png') }}"
                alt="Logo Los Amates"
                class="logo"
            >

            <div>
                <h2>Los Amates</h2>
                <p>Gestor de Ventas</p>
            </div>

        </div>


        <div class="menu-titulo">
            Administración
        </div>


        <nav class="menu">

            <a href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-house"></i>
                Menu Principal
            </a>

            <a href="{{ route('admin.inventario') }}">
                <i class="fa-solid fa-boxes-stacked"></i>
                Inventario
            </a>

            <a href="{{ route('admin.puntos_venta') }}">
                <i class="fa-solid fa-store"></i>
                Puntos de venta
            </a>

            <a href="{{ route('admin.empleados') }}">
                <i class="fa-solid fa-users"></i>
                Empleados
            </a>

            <a href="{{ route('admin.clientes') }}">
                <i class="fa-solid fa-user-group"></i>
                Clientes
            </a>

            <a href="{{ route('admin.cotizaciones') }}">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Pedidos
            </a>

            <a href="{{ route('admin.gastos_comerciales') }}">
                <i class="fa-solid fa-money-bill-wave"></i>
                Gastos comerciales
            </a>

            <a href="#">
                <i class="fa-solid fa-building-columns"></i>
                Cuenta del negocio
            </a>

            <a
                href="{{ route('admin.pago_servicios.index') }}"
                class="activo"
            >
                <i class="fa-solid fa-file-invoice"></i>
                Pago de servicios
            </a>

        </nav>


        <div class="menu-titulo">
            Mi cuenta
        </div>


        <nav class="menu">

            <a href="{{ route('admin.informacion') }}">
                <i class="fa-solid fa-user"></i>
                Mi información
            </a>


            @if(auth()->user()->puntoVenta)

                <a href="{{ route('empleado.punto_venta') }}">
                    <i class="fa-solid fa-cash-register"></i>
                    Punto de venta
                </a>

            @endif

        </nav>

    </aside>



    <!-- =====================================
         CONTENIDO PRINCIPAL
    ====================================== -->

    <main class="contenido">


        <!-- =====================================
             TOPBAR
        ====================================== -->

        <header class="topbar">

            <div class="saludo">

                <h1>
                    Bienvenido, {{ auth()->user()->name }}
                </h1>

                <p>
                    Panel de administración · Los Amates
                </p>

            </div>


            <!-- PERFIL -->

            <div class="perfil">

                <button
                    type="button"
                    class="avatar"
                    onclick="toggleMenuPerfil()"
                >

                    @if(auth()->user()->foto_perfil)

                        <img
                            src="{{ asset('storage/' . auth()->user()->foto_perfil) }}"
                            alt="Foto de perfil"
                        >

                    @else

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    @endif

                </button>


                <!-- MENÚ PERFIL -->

                <div
                    class="menu-perfil"
                    id="menuPerfil"
                >

                    <div class="nombre-usuario">

                        {{ auth()->user()->name }}

                        <small>
                            Administrador
                        </small>

                    </div>


                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        class="logout-form"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="boton-logout"
                        >

                            <i class="fa-solid fa-right-from-bracket"></i>

                            Cerrar sesión

                        </button>

                    </form>

                </div>

            </div>

        </header>



        <!-- =====================================
             CONTENIDO
        ====================================== -->

        <section class="contenedor">


            <!-- =====================================
                 PREPARAR CALENDARIO
            ====================================== -->

            @php

                use Carbon\Carbon;

                $mesCalendario = request('mes')
                    ? Carbon::createFromFormat(
                        'Y-m',
                        request('mes')
                    )->startOfMonth()
                    : Carbon::now()->startOfMonth();

                $inicioMes = $mesCalendario->copy()->startOfMonth();

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



            <!-- =====================================
                 TÍTULO
            ====================================== -->

            <div class="titulo-seccion">

                <div class="titulo-seccion-contenido">

                    <div class="icono-seccion">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>

                    <div>

                        <h2>
                            Pago de servicios
                        </h2>

                        <p>
                            Controla los servicios y pagos del negocio desde un solo lugar.
                        </p>

                    </div>

                </div>


                <a
                    href="{{ route('admin.pago_servicios.create') }}"
                    class="btn-agregar"
                >

                    <i class="fa-solid fa-plus"></i>

                    Agregar servicio

                </a>

            </div>



            <!-- =====================================
                 MENSAJE ÉXITO
            ====================================== -->

            @if(session('success'))

                <div class="alerta alerta-exito">

                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}

                </div>

            @endif



            <!-- =====================================
                 ERRORES
            ====================================== -->

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



            <!-- =====================================
                 CONTENIDO PRINCIPAL
            ====================================== -->

            <div class="contenido-servicios">


                <!-- =====================================
                     CALENDARIO
                ====================================== -->

                <div class="panel">

                    <h2 class="panel-titulo">

                        <i class="fa-regular fa-calendar-days"></i>

                        Calendario de pagos

                    </h2>


                    <!-- NAVEGACIÓN -->

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



                    <!-- HOY -->

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



                    <!-- DÍAS DE LA SEMANA -->

                    <div class="dias-semana">

                        <div class="dia-semana">Dom</div>
                        <div class="dia-semana">Lun</div>
                        <div class="dia-semana">Mar</div>
                        <div class="dia-semana">Mié</div>
                        <div class="dia-semana">Jue</div>
                        <div class="dia-semana">Vie</div>
                        <div class="dia-semana">Sáb</div>

                    </div>



                    <!-- DÍAS DEL MES -->

                    <div class="dias">


                        <!-- ESPACIOS -->

                        @for(
                            $i = 0;
                            $i < $primerDiaSemana;
                            $i++
                        )

                            <div class="dia dia-vacio"></div>

                        @endfor



                        <!-- DÍAS -->

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



                <!-- =====================================
                     SERVICIOS REGISTRADOS
                ====================================== -->

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


                                <!-- CABECERA -->

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



                                    <!-- ESTADO -->

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



                                <!-- INFORMACIÓN -->

                                <div class="informacion">

                                    <div>

                                        <strong>

                                            <i class="fa-regular fa-calendar"></i>

                                            Fecha de pago:

                                        </strong>

                                        {{ $servicio->fecha_pago
                                            ? Carbon::parse(
                                                $servicio->fecha_pago
                                            )->format('d/m/Y')
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



                                <!-- ACCIONES -->

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



            <!-- =====================================
                 VOLVER AL PANEL
            ====================================== -->

            <a
                href="{{ route('admin.dashboard') }}"
                class="volver"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Volver al panel

            </a>

        </section>

    </main>

</div>



<!-- =====================================
     JAVASCRIPT
====================================== -->

<script>

    function toggleMenuPerfil() {

        document
            .getElementById('menuPerfil')
            .classList
            .toggle('activo');

    }


    document.addEventListener('click', function(event) {

        const perfil =
            document.querySelector('.perfil');

        const menu =
            document.getElementById('menuPerfil');

        if (!perfil.contains(event.target)) {

            menu.classList.remove('activo');

        }

    });

</script>


</body>

</html>

