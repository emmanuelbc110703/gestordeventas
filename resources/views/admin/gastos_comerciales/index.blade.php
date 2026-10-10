<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gastos comerciales - Gestor de Ventas</title>

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

        /* =====================================
           ENCABEZADO DE SECCIÓN
        ===================================== */

        .titulo-seccion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .titulo-seccion-izquierda {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icono-seccion {
            width: 55px;
            height: 55px;
            min-width: 55px;
            border-radius: 14px;
            background: var(--morado-claro);
            color: var(--morado);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .titulo-seccion h2 {
            margin: 0;
            font-size: 22px;
        }

        .titulo-seccion p {
            color: var(--texto-suave);
            margin: 6px 0 0;
            font-size: 14px;
        }

        /* =====================================
           BOTÓN AGREGAR
        ===================================== */

        .boton-agregar {
            background: var(--morado);
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.25s;
            white-space: nowrap;
        }

        .boton-agregar:hover {
            background: var(--morado-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(106,27,154,0.20);
        }

        /* =====================================
           MENSAJE ÉXITO
        ===================================== */

        .mensaje-exito {
            background: #e7f6ed;
            color: #267a50;
            border: 1px solid #c9ead8;
            border-left: 4px solid var(--verde);
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .mensaje-exito i {
            margin-right: 7px;
        }

        /* =====================================
           TARJETA PRINCIPAL
        ===================================== */

        .tarjeta {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.05);
        }

        /* =====================================
           BUSCADOR
        ===================================== */

        .buscador {
            position: relative;
            margin-bottom: 18px;
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
            padding: 14px 15px 14px 45px;
            border: 1px solid var(--borde);
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            transition: 0.25s;
            color: var(--texto);
            background: #fff;
        }

        .buscador input:focus {
            border-color: var(--morado);
            box-shadow: 0 0 0 3px rgba(106,27,154,0.08);
        }

        /* =====================================
           FILTROS
        ===================================== */

        .filtros {
            background: #faf6fc;
            border: 1px solid #eee5f3;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
        }

        .filtros-titulo {
            color: var(--texto);
            font-weight: bold;
            margin-right: 5px;
            font-size: 14px;
        }

        .boton-filtro {
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 8px;
            background: white;
            color: var(--texto-suave);
            border: 1px solid var(--borde);
            transition: 0.25s;
            font-size: 13px;
        }

        .boton-filtro:hover {
            border-color: var(--morado);
            color: var(--morado);
        }

        .boton-filtro.activo {
            background: var(--morado);
            color: white;
            border-color: var(--morado);
        }

        /* =====================================
           TABLA
        ===================================== */

        .tabla-contenedor {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--borde);
            border-radius: 10px;
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
            padding: 14px 12px;
            text-align: left;
            font-size: 13px;
            white-space: nowrap;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--borde);
            color: var(--texto-suave);
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fcf9fd;
        }

        .fecha {
            color: var(--texto-suave);
            white-space: nowrap;
        }

        .concepto {
            color: var(--texto);
            font-weight: bold;
        }

        .monto {
            color: var(--morado);
            font-weight: bold;
            white-space: nowrap;
        }

        .categoria {
            display: inline-block;
            background: var(--morado-claro);
            color: var(--morado);
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .descripcion {
            max-width: 280px;
            line-height: 1.4;
        }

        .sin-descripcion {
            color: #aaa;
            font-style: italic;
        }

        .sin-datos {
            text-align: center;
            padding: 55px 20px !important;
            color: var(--texto-suave);
        }

        .sin-datos i {
            display: block;
            font-size: 42px;
            color: #c9c5cc;
            margin-bottom: 15px;
        }

        /* =====================================
           ACCIONES
        ===================================== */

        .acciones {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .boton-editar,
        .boton-eliminar {
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.25s;
            text-decoration: none;
        }

        .boton-editar {
            background: #e8f1ff;
            color: #3978d4;
        }

        .boton-editar:hover {
            background: #3978d4;
            color: white;
            transform: translateY(-2px);
        }

        .boton-eliminar {
            background: #fdeaea;
            color: var(--rojo);
        }

        .boton-eliminar:hover {
            background: var(--rojo);
            color: white;
            transform: translateY(-2px);
        }

        /* =====================================
           TOTAL
        ===================================== */

        .total {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .total-caja {
            background: #faf6fc;
            border: 1px solid #eee5f3;
            border-left: 4px solid var(--morado);
            padding: 15px 20px;
            border-radius: 9px;
            min-width: 250px;
        }

        .total-caja span {
            color: var(--texto-suave);
            font-size: 13px;
        }

        .total-caja strong {
            display: block;
            color: var(--morado);
            font-size: 24px;
            margin-top: 5px;
        }

        /* =====================================
           MODAL ELIMINAR
        ===================================== */

        .modal-eliminar {
            display: none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            background: rgba(0,0,0,0.55);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-eliminar.activo {
            display: flex;
        }

        .contenido-modal {
            background: white;
            width: 100%;
            max-width: 450px;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            animation: aparecer 0.2s ease;
        }

        @keyframes aparecer {

            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }

        }

        .icono-modal {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: #fde8e8;
            color: var(--rojo);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .contenido-modal h2 {
            margin: 10px 0;
            color: var(--texto);
        }

        .contenido-modal p {
            color: var(--texto-suave);
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .botones-modal {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .botones-modal button {
            border: none;
            padding: 11px 18px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.25s;
        }

        .boton-cancelar {
            background: #eee;
            color: #555;
        }

        .boton-cancelar:hover {
            background: #ddd;
        }

        .boton-confirmar {
            background: var(--rojo);
            color: white;
        }

        .boton-confirmar:hover {
            background: #b02a37;
        }

        .boton-confirmar i {
            margin-right: 6px;
        }

        /* =====================================
           RESPONSIVE
        ===================================== */

        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            .contenido {
                width: calc(100% - 210px);
                margin-left: 210px;
            }

            .titulo-seccion {
                align-items: flex-start;
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

            .titulo-seccion-izquierda {
                align-items: flex-start;
            }

            .boton-agregar {
                width: 100%;
                justify-content: center;
            }

            .tarjeta {
                padding: 18px 15px;
            }

            .filtros {
                align-items: stretch;
                flex-direction: column;
            }

            .boton-filtro {
                text-align: center;
            }

            .total {
                justify-content: stretch;
            }

            .total-caja {
                width: 100%;
            }

            .contenido-modal {
                padding: 25px 20px;
            }

            .botones-modal {
                flex-direction: column;
            }

            .botones-modal button {
                width: 100%;
            }

        }

        @media (max-width: 450px) {

            .menu {
                grid-template-columns: 1fr 1fr;
            }

            .titulo-seccion h2 {
                font-size: 19px;
            }

            .icono-seccion {
                width: 48px;
                height: 48px;
                min-width: 48px;
                font-size: 19px;
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

                <p>
                    Gestor de Ventas
                </p>

            </div>

        </div>


        <div class="menu-titulo">
            Administración
        </div>


        <nav class="menu">

            <!-- DASHBOARD -->

            <a href="{{ route('admin.dashboard') }}">

                <i class="fa-solid fa-house"></i>
                Menu Principal

            </a>


            <!-- INVENTARIO -->

            <a href="{{ route('admin.inventario') }}">

                <i class="fa-solid fa-boxes-stacked"></i>

                Inventario

            </a>


            <!-- PUNTOS DE VENTA -->

            <a href="{{ route('admin.puntos_venta') }}">

                <i class="fa-solid fa-store"></i>

                Puntos de venta

            </a>


            <!-- EMPLEADOS -->

            <a href="{{ route('admin.empleados') }}">

                <i class="fa-solid fa-users"></i>

                Empleados

            </a>


            <!-- CLIENTES -->

            <a href="{{ route('admin.clientes') }}">

                <i class="fa-solid fa-user-group"></i>

                Clientes

            </a>


            <!-- COTIZACIONES -->

            <a href="{{ route('admin.cotizaciones') }}">

                <i class="fa-solid fa-file-invoice-dollar"></i>

                Pedidos

            </a>


            <!-- GASTOS COMERCIALES -->

            <a
                href="{{ route('admin.gastos_comerciales') }}"
                class="activo"
            >

                <i class="fa-solid fa-money-bill-wave"></i>

                Gastos comerciales

            </a>


            <!-- CUENTA DEL NEGOCIO -->

            <a href="#">

                <i class="fa-solid fa-building-columns"></i>

                Cuenta del negocio

            </a>


            <!-- PAGO DE SERVICIOS -->

            <a href="{{ route('admin.pago_servicios.index') }}">

                <i class="fa-solid fa-file-invoice"></i>

                Pago de servicios

            </a>

        </nav>


        <div class="menu-titulo">
            Mi cuenta
        </div>


        <nav class="menu">

            <!-- MI INFORMACIÓN -->

            <a href="{{ route('admin.informacion') }}">

                <i class="fa-solid fa-user"></i>

                Mi información

            </a>


            <!-- PUNTO DE VENTA -->

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
                    Gastos comerciales
                </h1>

                <p>
                    Administración · Los Amates
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

                <div class="titulo-seccion-izquierda">

                    <div class="icono-seccion">

                        <i class="fa-solid fa-money-bill-wave"></i>

                    </div>

                    <div>

                        <h2>
                            Registro de gastos
                        </h2>

                        <p>
                            Consulta y administra los gastos comerciales.
                        </p>

                    </div>

                </div>


                <!-- REGISTRAR -->

                <a
                    href="{{ route('admin.gastos_comerciales.create') }}"
                    class="boton-agregar"
                >

                    <i class="fa-solid fa-plus"></i>

                    Registrar gasto

                </a>

            </div>


            <!-- =====================================
                 TARJETA
            ====================================== -->

            <div class="tarjeta">


                <!-- MENSAJE DE ÉXITO -->

                @if(session('success'))

                    <div class="mensaje-exito">

                        <i class="fa-solid fa-circle-check"></i>

                        {{ session('success') }}

                    </div>

                @endif


                <!-- =====================================
                     BUSCADOR
                ====================================== -->

                <div class="buscador">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        id="buscadorGastos"
                        placeholder="Buscar gasto por concepto, categoría o descripción..."
                    >

                </div>


                <!-- =====================================
                     FILTROS
                ====================================== -->

                <div class="filtros">

                    <span class="filtros-titulo">

                        <i class="fa-solid fa-filter"></i>

                        Filtrar:

                    </span>


                    <!-- TODOS -->

                    <a
                        href="{{ route('admin.gastos_comerciales', ['filtro' => 'todos']) }}"
                        class="boton-filtro {{ ($filtro ?? 'todos') === 'todos' ? 'activo' : '' }}"
                    >

                        <i class="fa-solid fa-list"></i>

                        Todos

                    </a>


                    <!-- SEMANA -->

                    <a
                        href="{{ route('admin.gastos_comerciales', ['filtro' => 'semana']) }}"
                        class="boton-filtro {{ ($filtro ?? '') === 'semana' ? 'activo' : '' }}"
                    >

                        <i class="fa-solid fa-calendar-week"></i>

                        Esta semana

                    </a>


                    <!-- MES -->

                    <a
                        href="{{ route('admin.gastos_comerciales', ['filtro' => 'mes']) }}"
                        class="boton-filtro {{ ($filtro ?? '') === 'mes' ? 'activo' : '' }}"
                    >

                        <i class="fa-solid fa-calendar-days"></i>

                        Este mes

                    </a>

                </div>


                <!-- =====================================
                     TABLA
                ====================================== -->

                <div class="tabla-contenedor">

                    <table id="tablaGastos">

                        <thead>

                            <tr>

                                <th>
                                    Fecha
                                </th>

                                <th>
                                    Concepto
                                </th>

                                <th>
                                    Categoría
                                </th>

                                <th>
                                    Descripción
                                </th>

                                <th>
                                    Monto
                                </th>

                                <th>
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($gastos as $gasto)

                                <tr>

                                    <!-- FECHA -->

                                    <td class="fecha">

                                        {{ $gasto->fecha->format('d/m/Y') }}

                                    </td>


                                    <!-- CONCEPTO -->

                                    <td class="concepto">

                                        {{ $gasto->concepto }}

                                    </td>


                                    <!-- CATEGORÍA -->

                                    <td>

                                        <span class="categoria">

                                            {{ $gasto->categoria }}

                                        </span>

                                    </td>


                                    <!-- DESCRIPCIÓN -->

                                    <td class="descripcion">

                                        @if($gasto->descripcion)

                                            {{ $gasto->descripcion }}

                                        @else

                                            <span class="sin-descripcion">

                                                Sin descripción

                                            </span>

                                        @endif

                                    </td>


                                    <!-- MONTO -->

                                    <td class="monto">

                                        ${{ number_format($gasto->monto, 2) }}

                                    </td>


                                    <!-- ACCIONES -->

                                    <td>

                                        <div class="acciones">


                                            <!-- EDITAR -->

                                            <a
                                                href="{{ route('admin.gastos_comerciales.edit', $gasto->id) }}"
                                                class="boton-editar"
                                                title="Editar gasto"
                                            >

                                                <i class="fa-solid fa-pen-to-square"></i>

                                            </a>


                                            <!-- ELIMINAR -->

                                            <button
                                                type="button"
                                                class="boton-eliminar"
                                                title="Eliminar gasto"
                                                onclick="abrirModalEliminar(
                                                    {{ $gasto->id }},
                                                    @json($gasto->concepto)
                                                )"
                                            >

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="sin-datos"
                                    >

                                        <i class="fa-solid fa-receipt"></i>

                                        No hay gastos comerciales registrados
                                        para este período.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <!-- =====================================
                     TOTAL
                ====================================== -->

                @if($gastos->count() > 0)

                    <div class="total">

                        <div class="total-caja">

                            <span>
                                Total de gastos mostrados
                            </span>

                            <strong>
                                ${{ number_format($gastos->sum('monto'), 2) }}
                            </strong>

                        </div>

                    </div>

                @endif

            </div>

        </section>

    </main>

</div>


<!-- =====================================
     MODAL ELIMINAR
====================================== -->

<div
    id="modalEliminar"
    class="modal-eliminar"
>

    <div class="contenido-modal">


        <div class="icono-modal">

            <i class="fa-solid fa-triangle-exclamation"></i>

        </div>


        <h2>
            ¿Eliminar gasto?
        </h2>


        <p id="mensajeEliminar">

            ¿Estás seguro de que deseas eliminar este gasto?

        </p>


        <div class="botones-modal">


            <!-- CANCELAR -->

            <button
                type="button"
                class="boton-cancelar"
                onclick="cerrarModalEliminar()"
            >

                Cancelar

            </button>


            <!-- FORMULARIO -->

            <form
                id="formEliminar"
                method="POST"
            >

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="boton-confirmar"
                >

                    <i class="fa-solid fa-trash"></i>

                    Eliminar

                </button>

            </form>

        </div>

    </div>

</div>


<!-- =====================================
     JAVASCRIPT
====================================== -->

<script>


    /* =====================================
       MENÚ PERFIL
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
       BUSCADOR
    ====================================== */

    const buscador =
        document.getElementById('buscadorGastos');

    if (buscador) {

        buscador.addEventListener('input', function() {

            const texto =
                this.value
                    .toLowerCase()
                    .trim();

            const filas =
                document.querySelectorAll(
                    '#tablaGastos tbody tr'
                );


            filas.forEach(function(fila) {

                const contenido =
                    fila.textContent
                        .toLowerCase();

                if (contenido.includes(texto)) {

                    fila.style.display = '';

                } else {

                    fila.style.display = 'none';

                }

            });

        });

    }


    /* =====================================
       ABRIR MODAL ELIMINAR
    ====================================== */

    function abrirModalEliminar(id, concepto) {

        const modal =
            document.getElementById('modalEliminar');

        const formulario =
            document.getElementById('formEliminar');

        const mensaje =
            document.getElementById('mensajeEliminar');


        mensaje.innerHTML =
            '¿Estás seguro de que deseas eliminar el gasto ' +
            '<strong>"' +
            escapeHtml(concepto) +
            '"</strong>? Esta acción no se puede deshacer.';


        formulario.action =
            "{{ url('/admin/gastos-comerciales') }}/" + id;


        modal.classList.add('activo');

    }


    /* =====================================
       PROTEGER TEXTO DEL MODAL
    ====================================== */

    function escapeHtml(text) {

        const div =
            document.createElement('div');

        div.textContent = text;

        return div.innerHTML;

    }


    /* =====================================
       CERRAR MODAL
    ====================================== */

    function cerrarModalEliminar() {

        const modal =
            document.getElementById('modalEliminar');

        modal.classList.remove('activo');

    }


    /* =====================================
       CERRAR AL HACER CLIC AFUERA
    ====================================== */

    window.addEventListener('click', function(event) {

        const modal =
            document.getElementById('modalEliminar');

        if (event.target === modal) {

            cerrarModalEliminar();

        }

    });


    /* =====================================
       CERRAR CON ESC
    ====================================== */

    window.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {

            cerrarModalEliminar();

        }

    });

</script>

</body>

</html>

