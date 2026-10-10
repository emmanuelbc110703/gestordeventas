<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventario - Orquídeas y más Los Amates</title>

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
           HEADER
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
           MENSAJE DE ÉXITO
        ===================================== */

        .mensaje-exito {
            background: #e6f4ec;
            color: var(--verde);
            border: 1px solid #c8e6d5;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
            font-size: 14px;
            font-weight: bold;
        }

        /* =====================================
           TARJETA DE OPCIONES
        ===================================== */

        .opciones-card {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 18px;
        }

        .opciones-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 15px;
        }

        .opciones-header h3 {
            margin: 0;
            font-size: 17px;
        }

        .opciones-header span {
            color: var(--texto-suave);
            font-size: 13px;
        }

        .opciones-inventario {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-inventario {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 11px 17px;
            border-radius: 10px;
            border: 1px solid var(--borde);
            background: white;
            color: var(--texto);
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: 0.25s;
        }

        .btn-inventario:hover {
            border-color: var(--morado);
            color: var(--morado);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106,27,154,0.08);
        }

        .btn-inventario.activo {
            background: var(--morado);
            color: white;
            border-color: var(--morado);
        }

        /* =====================================
           TARJETAS DE FILTROS Y BUSCADOR
        ===================================== */

        .filtros-contenedor,
        .buscador-contenedor {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 18px;
        }

        .titulo-filtros {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .titulo-filtros i {
            color: var(--morado);
        }

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-filtro {
            border: 1px solid var(--borde);
            background: white;
            color: var(--texto-suave);
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.25s;
        }

        .btn-filtro i {
            margin-right: 6px;
        }

        .btn-filtro:hover {
            border-color: var(--morado);
            color: var(--morado);
        }

        .btn-filtro.activo {
            background: var(--morado);
            color: white;
            border-color: var(--morado);
        }

        /* =====================================
           BUSCADOR
        ===================================== */

        .buscador {
            position: relative;
        }

        .buscador i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--morado);
        }

        .buscador input {
            width: 100%;
            padding: 13px 15px 13px 45px;
            border: 1px solid var(--borde);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            color: var(--texto);
            background: white;
            transition: 0.25s;
        }

        .buscador input:focus {
            border-color: var(--morado);
            box-shadow: 0 0 0 3px rgba(106,27,154,0.08);
        }

        /* =====================================
           TABLA
        ===================================== */

        .tabla-seccion {
            margin-top: 25px;
        }

        .tabla-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .tabla-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .tabla-header span {
            color: var(--texto-suave);
            font-size: 13px;
        }

        .tabla-contenedor {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        thead {
            background: var(--morado);
            color: white;
        }

        th {
            padding: 15px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--borde);
            vertical-align: middle;
            font-size: 14px;
        }

        tbody tr {
            transition: 0.2s;
        }

        tbody tr:hover {
            background: var(--morado-claro);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* =====================================
           FOTO
        ===================================== */

        .foto-producto {
            width: 58px;
            height: 58px;
            border-radius: 10px;
            object-fit: cover;
            background: #f0edf2;
            display: block;
        }

        .foto-sin-imagen {
            width: 58px;
            height: 58px;
            border-radius: 10px;
            background: var(--morado-claro);
            color: var(--morado);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        /* =====================================
           NOMBRE
        ===================================== */

        .nombre-producto {
            color: var(--morado);
            font-weight: bold;
        }

        /* =====================================
           PRECIO
        ===================================== */

        .precio {
            font-weight: bold;
            color: var(--texto);
        }

        /* =====================================
           CANTIDAD
        ===================================== */

        .cantidad {
            font-weight: bold;
            color: var(--texto);
        }

        /* =====================================
           TIPO
        ===================================== */

        .tipo {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .bien {
            background: var(--morado-claro);
            color: var(--morado);
        }

        .servicio {
            background: #e6f4ec;
            color: var(--verde);
        }

        /* =====================================
           SIN REGISTROS
        ===================================== */

        .sin-registros {
            text-align: center;
            padding: 55px 20px;
            color: var(--texto-suave);
        }

        .sin-registros i {
            font-size: 42px;
            color: var(--morado);
            margin-bottom: 15px;
        }

        .sin-registros h3 {
            margin: 5px 0 8px;
            color: var(--texto);
            font-size: 17px;
        }

        .sin-registros p {
            margin: 0;
            font-size: 13px;
        }

        /* =====================================
           SIN RESULTADOS
        ===================================== */

        .sin-resultados {
            display: none;
            background: white;
            padding: 45px 20px;
            border-radius: 15px;
            text-align: center;
            color: var(--texto-suave);
            border: 1px solid var(--borde);
            margin-top: 18px;
        }

        .sin-resultados i {
            font-size: 40px;
            color: var(--morado);
            margin-bottom: 12px;
        }

        .sin-resultados h3 {
            margin: 5px 0;
            color: var(--texto);
        }

        .sin-resultados p {
            margin: 5px 0 0;
            font-size: 13px;
        }

        /* =====================================
           RESPONSIVE
        ===================================== */

        @media (max-width: 1200px) {

            .contenedor {
                padding: 30px;
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

            .topbar {
                padding: 0 25px;
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

            .opciones-inventario {
                flex-direction: column;
            }

            .btn-inventario {
                width: 100%;
                justify-content: center;
            }

            .filtros {
                flex-direction: column;
            }

            .btn-filtro {
                width: 100%;
            }

            .tabla-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 5px;
            }
        }

        @media (max-width: 450px) {

            .menu {
                grid-template-columns: 1fr 1fr;
            }

            .contenedor {
                padding: 18px 12px;
            }

            .saludo h1 {
                font-size: 16px;
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

            <a href="{{ route('admin.inventario') }}" class="activo">
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

        <!-- TOPBAR -->

        <header class="topbar">

            <div class="saludo">

                <h1>
                    Gestión de Inventario
                </h1>

                <p>
                    Administración de bienes y servicios · Los Amates
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

            <div class="titulo-seccion">

                <h2>
                    Inventario
                </h2>

                <p>
                    Administra y consulta los bienes y servicios disponibles.
                </p>

            </div>


            <!-- MENSAJE DE ÉXITO -->

            @if(session('success'))

                <div class="mensaje-exito">

                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}

                </div>

            @endif


            <!-- =====================================
                 OPCIONES DE INVENTARIO
            ====================================== -->

            <div class="opciones-card">

                <div class="opciones-header">

                    <h3>
                        Gestión de inventario
                    </h3>

                    <span>
                        Selecciona el tipo de registro
                    </span>

                </div>

                <div class="opciones-inventario">

                    <a
                        href="{{ route('admin.bienes') }}"
                        class="btn-inventario"
                    >

                        <i class="fa-solid fa-box"></i>

                        Bienes

                    </a>

                    <a
                        href="{{ route('admin.servicios') }}"
                        class="btn-inventario"
                    >

                        <i class="fa-solid fa-screwdriver-wrench"></i>

                        Servicios

                    </a>

                </div>

            </div>


            <!-- =====================================
                 FILTROS
            ====================================== -->

            <div class="filtros-contenedor">

                <div class="titulo-filtros">

                    <i class="fa-solid fa-filter"></i>

                    Filtrar inventario

                </div>

                <div class="filtros">

                    <!-- TODOS -->

                    <button
                        type="button"
                        class="btn-filtro activo"
                        data-tipo="todos"
                        id="filtroTodos"
                    >

                        <i class="fa-solid fa-list"></i>

                        Todos

                    </button>


                    <!-- BIENES -->

                    <button
                        type="button"
                        class="btn-filtro"
                        data-tipo="bien"
                    >

                        <i class="fa-solid fa-box"></i>

                        Solo bienes

                    </button>


                    <!-- SERVICIOS -->

                    <button
                        type="button"
                        class="btn-filtro"
                        data-tipo="servicio"
                    >

                        <i class="fa-solid fa-screwdriver-wrench"></i>

                        Solo servicios

                    </button>


                    <!-- A-Z -->

                    <button
                        type="button"
                        class="btn-filtro activo"
                        id="ordenAZ"
                    >

                        <i class="fa-solid fa-arrow-down-a-z"></i>

                        A → Z

                    </button>


                    <!-- Z-A -->

                    <button
                        type="button"
                        class="btn-filtro"
                        id="ordenZA"
                    >

                        <i class="fa-solid fa-arrow-down-z-a"></i>

                        Z → A

                    </button>

                </div>

            </div>


            <!-- =====================================
                 BUSCADOR
            ====================================== -->

            <div class="buscador-contenedor">

                <div class="buscador">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        id="buscadorInventario"
                        placeholder="Buscar en el inventario por nombre..."
                        autocomplete="off"
                    >

                </div>

            </div>


            <!-- =====================================
                 TABLA
            ====================================== -->

            <div class="tabla-seccion">

                <div class="tabla-header">

                    <h3>
                        Registros del inventario
                    </h3>

                    <span>
                        Bienes y servicios registrados
                    </span>

                </div>

                <div class="tabla-contenedor">

                    <table>

                        <thead>

                            <tr>

                                <th>Foto</th>

                                <th>Nombre</th>

                                <th>Descripción</th>

                                <th>Precio</th>

                                <th>Cantidad</th>

                                <th>Tipo de inventario</th>

                            </tr>

                        </thead>


                        <tbody id="tablaInventario">

                            @forelse($inventarios as $inventario)

                                <tr
                                    class="fila-inventario"
                                    data-nombre="{{ strtolower($inventario->nombre) }}"
                                    data-tipo="{{ $inventario->tipo }}"
                                >

                                    <!-- FOTO -->

                                    <td>

                                        @if($inventario->foto)

                                            <img
                                                src="{{ asset('storage/' . $inventario->foto) }}"
                                                alt="{{ $inventario->nombre }}"
                                                class="foto-producto"
                                            >

                                        @else

                                            <div class="foto-sin-imagen">

                                                <i class="fa-solid fa-image"></i>

                                            </div>

                                        @endif

                                    </td>


                                    <!-- NOMBRE -->

                                    <td>

                                        <span class="nombre-producto">

                                            {{ $inventario->nombre }}

                                        </span>

                                    </td>


                                    <!-- DESCRIPCIÓN -->

                                    <td>

                                        {{ $inventario->descripcion ?: 'Sin descripción' }}

                                    </td>


                                    <!-- PRECIO -->

                                    <td>

                                        <span class="precio">

                                            ${{ number_format($inventario->precio, 2) }}

                                        </span>

                                    </td>


                                    <!-- CANTIDAD -->

                                    <td>

                                        <span class="cantidad">

                                            {{ $inventario->cantidad }}

                                        </span>

                                    </td>


                                    <!-- TIPO -->

                                    <td>

                                        @if($inventario->tipo === 'bien')

                                            <span class="tipo bien">

                                                <i class="fa-solid fa-box"></i>

                                                Bien

                                            </span>

                                        @elseif($inventario->tipo === 'servicio')

                                            <span class="tipo servicio">

                                                <i class="fa-solid fa-screwdriver-wrench"></i>

                                                Servicio

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr id="filaSinRegistros">

                                    <td colspan="6">

                                        <div class="sin-registros">

                                            <i class="fa-solid fa-box-open"></i>

                                            <h3>
                                                No hay registros en el inventario
                                            </h3>

                                            <p>
                                                Agrega un bien o servicio para que aparezca aquí.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <!-- SIN RESULTADOS -->

                <div
                    class="sin-resultados"
                    id="sinResultados"
                >

                    <i class="fa-solid fa-box-open"></i>

                    <h3>
                        No se encontraron resultados
                    </h3>

                    <p>
                        Intenta cambiar el filtro o realizar otra búsqueda.
                    </p>

                </div>

            </div>

        </section>

    </main>

</div>


<!-- =====================================
     JAVASCRIPT
====================================== -->

<script>

    /* =====================================
       MENÚ DE PERFIL
    ====================================== */

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


    /* =====================================
       FILTROS + BUSCADOR + ORDEN
    ====================================== */

    const buscador =
        document.getElementById('buscadorInventario');

    const tabla =
        document.getElementById('tablaInventario');

    const sinResultados =
        document.getElementById('sinResultados');

    const botonesTipo =
        document.querySelectorAll('[data-tipo]');

    const botonAZ =
        document.getElementById('ordenAZ');

    const botonZA =
        document.getElementById('ordenZA');


    let tipoSeleccionado = 'todos';

    let ordenSeleccionado = 'az';


    function obtenerFilas() {

        return Array.from(
            document.querySelectorAll('.fila-inventario')
        );

    }


    function aplicarFiltros() {

        const filas = obtenerFilas();

        const texto =
            buscador.value
                .toLowerCase()
                .trim();


        /* ORDENAR */

        filas.sort(function(a, b) {

            const nombreA =
                a.dataset.nombre;

            const nombreB =
                b.dataset.nombre;


            if (ordenSeleccionado === 'az') {

                return nombreA.localeCompare(
                    nombreB,
                    'es',
                    {
                        sensitivity: 'base'
                    }
                );

            } else {

                return nombreB.localeCompare(
                    nombreA,
                    'es',
                    {
                        sensitivity: 'base'
                    }
                );

            }

        });


        /* INSERTAR FILAS ORDENADAS */

        filas.forEach(function(fila) {

            tabla.appendChild(fila);

        });


        /* FILTRAR */

        let encontrados = 0;


        filas.forEach(function(fila) {

            const nombre =
                fila.dataset.nombre;

            const tipo =
                fila.dataset.tipo;


            const coincideTipo =
                tipoSeleccionado === 'todos' ||
                tipo === tipoSeleccionado;


            const coincideBusqueda =
                nombre.includes(texto);


            if (coincideTipo && coincideBusqueda) {

                fila.style.display = '';

                encontrados++;

            } else {

                fila.style.display = 'none';

            }

        });


        /* MENSAJE SIN RESULTADOS */

        if (encontrados === 0 && filas.length > 0) {

            sinResultados.style.display = 'block';

        } else {

            sinResultados.style.display = 'none';

        }

    }


    /* =====================================
       FILTROS DE TIPO
    ====================================== */

    botonesTipo.forEach(function(boton) {

        boton.addEventListener('click', function() {

            tipoSeleccionado =
                this.dataset.tipo;


            botonesTipo.forEach(function(btn) {

                btn.classList.remove('activo');

            });


            this.classList.add('activo');

            aplicarFiltros();

        });

    });


    /* =====================================
       A → Z
    ====================================== */

    botonAZ.addEventListener('click', function() {

        ordenSeleccionado = 'az';

        botonAZ.classList.add('activo');

        botonZA.classList.remove('activo');

        aplicarFiltros();

    });


    /* =====================================
       Z → A
    ====================================== */

    botonZA.addEventListener('click', function() {

        ordenSeleccionado = 'za';

        botonZA.classList.add('activo');

        botonAZ.classList.remove('activo');

        aplicarFiltros();

    });


    /* =====================================
       BUSCADOR
    ====================================== */

    buscador.addEventListener('input', function() {

        aplicarFiltros();

    });


    /* =====================================
       INICIAR
    ====================================== */

    aplicarFiltros();

</script>

</body>

</html>