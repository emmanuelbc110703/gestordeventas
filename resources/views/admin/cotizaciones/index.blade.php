<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Pedidos - Dashboard Administrador</title>

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

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--fondo);
            color: var(--texto);
        }

        /* =====================================
           ESTRUCTURA PRINCIPAL
        ===================================== */

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
           CONTENIDO
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

        .titulo-seccion {
            margin-bottom: 25px;
        }

        .titulo-seccion h2 {
            margin: 0;
            font-size: 22px;
        }

        .titulo-seccion p {
            color: var(--texto-suave);
            margin: 7px 0 0;
            font-size: 14px;
        }

        /* =====================================
           CABECERA DE PÁGINA
        ===================================== */

        .cabecera-pagina {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .cabecera-pagina h2 {
            margin: 0;
            font-size: 22px;
        }

        .cabecera-pagina p {
            margin: 7px 0 0;
            color: var(--texto-suave);
            font-size: 14px;
        }

        /* =====================================
           TARJETAS DE RESUMEN
        ===================================== */

        .resumen {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .resumen-card {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: 0.25s;
        }

        .resumen-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .resumen-icono {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: var(--morado-claro);
            color: var(--morado);
            flex-shrink: 0;
        }

        .resumen-info span {
            display: block;
            font-size: 12px;
            color: var(--texto-suave);
            margin-bottom: 4px;
        }

        .resumen-info strong {
            font-size: 19px;
        }

        /* =====================================
           MENSAJES
        ===================================== */

        .mensaje {
            padding: 15px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid transparent;
        }

        .mensaje-exito {
            background: #e6f4ec;
            color: #176b45;
            border-color: #c7e7d5;
        }

        .mensaje-error {
            background: #fff0f0;
            color: #a72e2e;
            border-color: #f0cccc;
        }

        /* =====================================
           TABLA
        ===================================== */

        .tabla-contenedor {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            overflow-x: auto;
            box-shadow: 0 5px 18px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        thead {
            background: var(--morado);
            color: white;
        }

        th {
            padding: 15px 14px;
            text-align: left;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        td {
            padding: 15px 14px;
            border-bottom: 1px solid var(--borde);
            font-size: 13px;
            vertical-align: middle;
        }

        tbody tr {
            transition: 0.2s;
        }

        tbody tr:hover {
            background: #faf7fc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* =====================================
           FOLIO
        ===================================== */

        .folio {
            color: var(--morado);
            font-weight: bold;
        }

        /* =====================================
           ESTADOS
        ===================================== */

        .estado {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .estado-enviado {
            background: #fff3cd;
            color: #856404;
        }

        .estado-procesando {
            background: #e7f0fc;
            color: #245ca8;
        }

        .estado-finalizado {
            background: #e6f4ec;
            color: #176b45;
        }

        .estado-terminado {
            background: #ececef;
            color: #55515a;
        }

        /* =====================================
           TOTAL
        ===================================== */

        .total {
            color: var(--morado);
            font-weight: bold;
            font-size: 15px;
            white-space: nowrap;
        }

        /* =====================================
           BOTÓN VER
        ===================================== */

        .boton-ver {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: var(--morado);
            color: white;
            padding: 9px 13px;
            border-radius: 9px;
            text-decoration: none;
            font-weight: bold;
            font-size: 12px;
            transition: 0.25s;
            white-space: nowrap;
        }

        .boton-ver:hover {
            background: var(--morado-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(106,27,154,0.2);
        }

        /* =====================================
           VACÍO
        ===================================== */

        .vacio {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 70px 25px;
            text-align: center;
            box-shadow: 0 5px 18px rgba(0,0,0,0.05);
        }

        .vacio i {
            width: 75px;
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border-radius: 20px;
            background: var(--morado-claro);
            color: var(--morado);
            font-size: 32px;
        }

        .vacio h3 {
            margin: 5px 0 10px;
            font-size: 19px;
        }

        .vacio p {
            color: var(--texto-suave);
            margin: 0;
            font-size: 14px;
        }

        /* =====================================
           RESPONSIVE
        ===================================== */

        @media (max-width: 1200px) {

            .resumen {
                grid-template-columns: repeat(2, 1fr);
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

            .resumen {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .resumen-card {
                padding: 14px;
            }

            .resumen-icono {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .resumen-info strong {
                font-size: 15px;
            }

        }

        @media (max-width: 450px) {

            .menu {
                grid-template-columns: 1fr 1fr;
            }

            .resumen {
                grid-template-columns: 1fr;
            }

            .resumen-card {
                min-height: 65px;
            }

            .cabecera-pagina {
                align-items: flex-start;
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

                <h2>
                    Los Amates
                </h2>

                <p>
                    Gestor de Ventas
                </p>

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


            <!-- PEDIDOS ACTIVO -->

            <a
                href="{{ route('admin.cotizaciones') }}"
                class="activo"
            >

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


            <a href="{{ route('admin.pago_servicios.index') }}">

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
                    Panel de Pedidos
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


            <!-- TÍTULO -->

            <div class="titulo-seccion">

                <h2>
                    Pedidos
                </h2>

                <p>
                    Consulta y administra los pedidos realizados por los clientes.
                </p>

            </div>


            <!-- =====================================
                 RESUMEN
            ====================================== -->

            <div class="resumen">


                <div class="resumen-card">

                    <div class="resumen-icono">

                        <i class="fa-solid fa-file-invoice-dollar"></i>

                    </div>

                    <div class="resumen-info">

                        <span>
                            Gestión
                        </span>

                        <strong>
                            Pedidos
                        </strong>

                    </div>

                </div>


                <div class="resumen-card">

                    <div class="resumen-icono">

                        <i class="fa-solid fa-users"></i>

                    </div>

                    <div class="resumen-info">

                        <span>
                            Clientes
                        </span>

                        <strong>
                            Pedidos
                        </strong>

                    </div>

                </div>


                <div class="resumen-card">

                    <div class="resumen-icono">

                        <i class="fa-solid fa-clock"></i>

                    </div>

                    <div class="resumen-info">

                        <span>
                            Seguimiento
                        </span>

                        <strong>
                            Estados
                        </strong>

                    </div>

                </div>


                <div class="resumen-card">

                    <div class="resumen-icono">

                        <i class="fa-solid fa-money-bill-wave"></i>

                    </div>

                    <div class="resumen-info">

                        <span>
                            Información
                        </span>

                        <strong>
                            Totales
                        </strong>

                    </div>

                </div>


            </div>


            <!-- =====================================
                 MENSAJES
            ====================================== -->

            @if(session('success'))

                <div class="mensaje mensaje-exito">

                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}

                </div>

            @endif


            @if($errors->any())

                <div class="mensaje mensaje-error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    {{ $errors->first() }}

                </div>

            @endif


            <!-- =====================================
                 CABECERA
            ====================================== -->

            <div class="cabecera-pagina">

                <div>

                    <h2>
                        Pedidos de clientes
                    </h2>

                    <p>
                        Revisa los pedidos realizados por los clientes.
                    </p>

                </div>

            </div>


            <!-- =====================================
                 PEDIDOS
            ====================================== -->

            @if($cotizaciones->isEmpty())


                <!-- SIN PEDIDOS -->

                <div class="vacio">

                    <i class="fa-solid fa-file-invoice"></i>

                    <h3>
                        No hay pedidos
                    </h3>

                    <p>
                        Actualmente no existen pedidos realizados por los clientes.
                    </p>

                </div>


            @else


                <!-- TABLA -->

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


                                    <!-- FOLIO -->

                                    <td>

                                        <span class="folio">

                                            {{ $cotizacion->folio }}

                                        </span>

                                    </td>


                                    <!-- CLIENTE -->

                                    <td>

                                        {{ $cotizacion->usuario->name ?? 'Sin nombre' }}

                                    </td>


                                    <!-- FECHA -->

                                    <td>

                                        {{ $cotizacion->created_at?->format('d/m/Y H\:i') }}

                                    </td>


                                    <!-- SERVICIOS -->

                                    <td>

                                        {{ $cotizacion->detalles->sum('cantidad') }}

                                    </td>


                                    <!-- FORMA DE PAGO -->

                                    <td>

                                        {{ ucfirst($cotizacion->forma_pago) }}

                                    </td>


                                    <!-- ESTADO -->

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

                                            @else

                                                {{ ucfirst($cotizacion->estado) }}

                                            @endif

                                        </span>

                                    </td>


                                    <!-- TOTAL -->

                                    <td>

                                        <span class="total">

                                            ${{ number_format(
                                                $cotizacion->total,
                                                2
                                            ) }}

                                        </span>

                                    </td>


                                    <!-- ACCIÓN -->

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