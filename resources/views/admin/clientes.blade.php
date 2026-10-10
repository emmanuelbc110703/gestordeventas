<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clientes - Gestor de Ventas Los Amates</title>

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
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
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
           BOTÓN AGREGAR
        ===================================== */

        .boton-agregar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--morado);
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 14px;
            transition: 0.25s ease;
            white-space: nowrap;
        }

        .boton-agregar:hover {
            background: var(--morado-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 7px 18px rgba(106,27,154,0.20);
        }

        /* =====================================
           BARRA DE HERRAMIENTAS
        ===================================== */

        .herramientas {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .buscador {
            position: relative;
            flex: 1;
        }

        .buscador > i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--morado);
            pointer-events: none;
        }

        .buscador input {
            width: 100%;
            padding: 13px 15px 13px 45px;
            border: 1px solid var(--borde);
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            color: var(--texto);
            background: #fff;
            transition: 0.2s;
        }

        .buscador input:focus {
            border-color: var(--morado);
            box-shadow: 0 0 0 3px rgba(106,27,154,0.08);
        }

        /* =====================================
           FILTRO
        ===================================== */

        .filtro {
            position: relative;
        }

        .boton-filtro {
            background: var(--morado-claro);
            color: var(--morado);
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 13px 17px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            white-space: nowrap;
            transition: 0.25s;
        }

        .boton-filtro:hover {
            background: var(--morado);
            color: white;
        }

        .boton-filtro i {
            margin-right: 6px;
        }

        .menu-filtro {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 210px;
            background: white;
            border-radius: 12px;
            padding: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: 1px solid var(--borde);
            z-index: 1000;
        }

        .menu-filtro.activo {
            display: block;
        }

        .menu-filtro button {
            width: 100%;
            background: none;
            border: none;
            padding: 12px;
            text-align: left;
            color: #444;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.2s;
        }

        .menu-filtro button:hover {
            background: var(--morado-claro);
            color: var(--morado);
        }

        .menu-filtro i {
            margin-right: 8px;
            color: var(--morado);
        }

        /* =====================================
           TABLA
        ===================================== */

        .tabla-contenedor {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 0;
            overflow-x: auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1050px;
        }

        thead {
            background: var(--morado);
            color: white;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--borde);
        }

        th {
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        td {
            color: #444;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr {
            transition: 0.2s;
        }

        tbody tr:hover {
            background: #faf6fc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* =====================================
           AVATAR TABLA
        ===================================== */

        .avatar-tabla {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 17px;
            overflow: hidden;
        }

        .avatar-tabla img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* =====================================
           NOMBRE CLIENTE
        ===================================== */

        .nombre-cliente {
            font-weight: bold;
            color: var(--texto);
        }

        /* =====================================
           INFORMACIÓN SECUNDARIA
        ===================================== */

        .texto-secundario {
            color: var(--texto-suave);
        }

        /* =====================================
           ACCIONES
        ===================================== */

        .acciones {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .boton-editar,
        .boton-eliminar {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: 0.25s;
        }

        .boton-editar {
            background: var(--morado-claro);
            color: var(--morado);
        }

        .boton-editar:hover {
            background: var(--morado);
            color: white;
            transform: translateY(-2px);
        }

        .boton-eliminar {
            background: #fff0f0;
            color: var(--rojo);
        }

        .boton-eliminar:hover {
            background: var(--rojo);
            color: white;
            transform: translateY(-2px);
        }

        /* =====================================
           SIN CLIENTES / RESULTADOS
        ===================================== */

        .sin-clientes {
            text-align: center;
            padding: 55px 30px;
            color: var(--texto-suave);
        }

        .sin-clientes i {
            display: block;
            font-size: 48px;
            color: var(--morado);
            margin-bottom: 15px;
        }

        .sin-clientes h3 {
            margin: 0 0 8px;
            color: var(--texto);
            font-size: 17px;
        }

        .sin-clientes p {
            margin: 0;
            font-size: 14px;
        }

        /* =====================================
           MODAL ELIMINAR
        ===================================== */

        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            inset: 0;
            background-color: rgba(41,37,45,0.55);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.activo {
            display: flex;
        }

        .modal-contenido {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.22);
            animation: aparecerModal 0.25s ease;
        }

        .modal-icono {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: #fff0f0;
            color: var(--rojo);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }

        .modal-contenido h2 {
            color: var(--texto);
            margin: 10px 0;
            font-size: 20px;
        }

        .modal-contenido p {
            color: var(--texto-suave);
            line-height: 1.5;
            margin: 0 0 25px;
            font-size: 14px;
        }

        .modal-botones {
            display: flex;
            gap: 12px;
        }

        .boton-cancelar,
        .boton-confirmar {
            flex: 1;
            border: none;
            border-radius: 9px;
            padding: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.25s;
        }

        .boton-cancelar {
            background: #f0eef1;
            color: #555;
        }

        .boton-cancelar:hover {
            background: #dedade;
        }

        .boton-confirmar {
            background: var(--rojo);
            color: white;
        }

        .boton-confirmar:hover {
            background: #b83f3b;
        }

        @keyframes aparecerModal {

            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }

        }

        /* =====================================
           RESPONSIVE
        ===================================== */

        @media (max-width: 1200px) {

            .contenedor {
                padding: 28px;
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

            .titulo-seccion {
                flex-direction: column;
            }

            .boton-agregar {
                align-self: flex-start;
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

            .titulo-seccion h2 {
                font-size: 20px;
            }

            .herramientas {
                flex-direction: column;
                align-items: stretch;
            }

            .filtro {
                width: 100%;
            }

            .boton-filtro {
                width: 100%;
            }

            .menu-filtro {
                width: 100%;
                left: 0;
                right: auto;
            }

            .boton-agregar {
                width: 100%;
                justify-content: center;
            }

        }

        @media (max-width: 450px) {

            .menu {
                grid-template-columns: 1fr 1fr;
            }

            .modal-botones {
                flex-direction: column;
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

            <a
                href="{{ route('admin.clientes') }}"
                class="activo"
            >
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


        <!-- =====================================
             TOPBAR
        ====================================== -->

        <header class="topbar">

            <div class="saludo">

                <h1> Panel de clientes </h1> 
                <p> Administra y consulta los clientes registrados en el sistema. </p>

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

                <div>

                    <h2>
                        Clientes
                    </h2>

                    <p>
                        Administra y consulta los clientes registrados en el sistema.
                    </p>

                </div>


                <a
                    href="{{ route('admin.clientes.agregar') }}"
                    class="boton-agregar"
                >

                    <i class="fa-solid fa-user-plus"></i>

                    Agregar cliente

                </a>

            </div>


            <!-- =====================================
                 BUSCADOR Y FILTRO
            ====================================== -->

            <div class="herramientas">

                <!-- BUSCADOR -->

                <div class="buscador">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        id="buscadorClientes"
                        placeholder="Buscar cliente por nombre, apellido o correo..."
                    >

                </div>


                <!-- FILTRO -->

                <div class="filtro">

                    <button
                        type="button"
                        class="boton-filtro"
                        id="botonFiltro"
                    >

                        <i class="fa-solid fa-arrow-down-a-z"></i>

                        Ordenar

                    </button>


                    <div
                        class="menu-filtro"
                        id="menuFiltro"
                    >

                        <button
                            type="button"
                            id="ordenAscendente"
                        >

                            <i class="fa-solid fa-arrow-down-a-z"></i>

                            Nombre: A → Z

                        </button>


                        <button
                            type="button"
                            id="ordenDescendente"
                        >

                            <i class="fa-solid fa-arrow-up-z-a"></i>

                            Nombre: Z → A

                        </button>

                    </div>

                </div>

            </div>


            <!-- =====================================
                 TABLA
            ====================================== -->

            <div class="tabla-contenedor">

                @if($clientes->count() > 0)

                    <table id="tablaClientes">

                        <thead>

                            <tr>

                                <th>
                                    Perfil
                                </th>

                                <th>
                                    Nombre completo
                                </th>

                                <th>
                                    Correo
                                </th>

                                <th>
                                    Teléfono
                                </th>

                                <th>
                                    Dirección
                                </th>

                                <th>
                                    Fecha de nacimiento
                                </th>

                                <th>
                                    Compras realizadas
                                </th>

                                <th>
                                    Acciones
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($clientes as $cliente)

                                <tr>

                                    <!-- PERFIL -->

                                    <td>

                                        <div
                                            class="avatar-tabla"
                                            style="background-color: {{ $cliente->color_perfil ?? '#6a1b9a' }};"
                                        >

                                            @if($cliente->foto_perfil)

                                                <img
                                                    src="{{ asset('storage/' . $cliente->foto_perfil) }}"
                                                    alt="Foto de {{ $cliente->name }}"
                                                >

                                            @else

                                                {{ strtoupper(substr($cliente->name, 0, 1)) }}

                                            @endif

                                        </div>

                                    </td>


                                    <!-- NOMBRE -->

                                    <td>

                                        <span class="nombre-cliente">

                                            {{ $cliente->name }}
                                            {{ $cliente->apellido }}

                                        </span>

                                    </td>


                                    <!-- CORREO -->

                                    <td>
                                        {{ $cliente->email }}
                                    </td>


                                    <!-- TELÉFONO -->

                                    <td>

                                        {{ $cliente->telefono ?? 'No registrado' }}

                                    </td>


                                    <!-- DIRECCIÓN -->

                                    <td>

                                        {{ $cliente->direccion ?? 'No registrada' }}

                                    </td>


                                    <!-- FECHA DE NACIMIENTO -->

                                    <td>

                                        {{ $cliente->fecha_nacimiento ?? 'No registrada' }}

                                    </td>


                                    <!-- COMPRAS REALIZADAS -->

                                    <td>

                                        0

                                    </td>


                                    <!-- ACCIONES -->

                                    <td>

                                        <div class="acciones">

                                            <!-- EDITAR -->

                                            <a
                                                href="{{ route('admin.clientes.editar', $cliente->id) }}"
                                                class="boton-editar"
                                                title="Editar cliente"
                                            >

                                                <i class="fa-solid fa-pen-to-square"></i>

                                            </a>


                                            <!-- ELIMINAR -->

                                            <button
                                                type="button"
                                                class="boton-eliminar"
                                                title="Eliminar cliente"
                                                onclick="abrirModalEliminar({{ $cliente->id }}, @js($cliente->name))"
                                            >

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>


                    <!-- =====================================
                         SIN RESULTADOS
                    ====================================== -->

                    <div
                        id="sinResultados"
                        class="sin-clientes"
                        style="display: none;"
                    >

                        <i class="fa-solid fa-user-slash"></i>

                        <h3>
                            No se encontró ningún cliente
                        </h3>

                        <p>
                            Intenta buscar con otro nombre, apellido o correo electrónico.
                        </p>

                    </div>

                @else

                    <!-- =====================================
                         SIN CLIENTES
                    ====================================== -->

                    <div class="sin-clientes">

                        <i class="fa-solid fa-users"></i>

                        <h3>
                            No hay clientes registrados
                        </h3>

                        <p>
                            Aún no existen clientes registrados en el sistema.
                        </p>

                    </div>

                @endif

            </div>

        </section>

    </main>

</div>


<!-- =====================================
     MODAL ELIMINAR CLIENTE
====================================== -->

<div
    id="modalEliminar"
    class="modal"
>

    <div class="modal-contenido">

        <div class="modal-icono">

            <i class="fa-solid fa-trash"></i>

        </div>


        <h2>
            Eliminar cliente
        </h2>


        <p id="mensajeEliminar">

            ¿Estás seguro de que deseas eliminar este cliente?

        </p>


        <form
            id="formEliminar"
            method="POST"
        >

            @csrf
            @method('DELETE')


            <div class="modal-botones">

                <!-- CANCELAR -->

                <button
                    type="button"
                    class="boton-cancelar"
                    onclick="cerrarModalEliminar()"
                >

                    Cancelar

                </button>


                <!-- CONFIRMAR -->

                <button
                    type="submit"
                    class="boton-confirmar"
                >

                    <i class="fa-solid fa-trash"></i>

                    Sí, eliminar

                </button>

            </div>

        </form>

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

        if (
            perfil &&
            menu &&
            !perfil.contains(event.target)
        ) {

            menu.classList.remove('activo');

        }

    });


    /* =====================================
       BUSCADOR
    ====================================== */

    const buscador =
        document.getElementById('buscadorClientes');

    const mensajeSinResultados =
        document.getElementById('sinResultados');


    if (buscador) {

        buscador.addEventListener('input', function () {

            const texto =
                this.value
                    .toLowerCase()
                    .trim();


            const filas =
                document.querySelectorAll(
                    '#tablaClientes tbody tr'
                );


            let resultadosEncontrados = 0;


            filas.forEach(function (fila) {

                const nombre =
                    fila.cells[1]
                        .textContent
                        .toLowerCase();


                const correo =
                    fila.cells[2]
                        .textContent
                        .toLowerCase();


                if (
                    nombre.includes(texto) ||
                    correo.includes(texto)
                ) {

                    fila.style.display = '';

                    resultadosEncontrados++;

                } else {

                    fila.style.display = 'none';

                }

            });


            if (
                resultadosEncontrados === 0 &&
                texto !== ''
            ) {

                if (mensajeSinResultados) {

                    mensajeSinResultados.style.display =
                        'block';

                }

            } else {

                if (mensajeSinResultados) {

                    mensajeSinResultados.style.display =
                        'none';

                }

            }

        });

    }


    /* =====================================
       FILTRO
    ====================================== */

    const botonFiltro =
        document.getElementById('botonFiltro');

    const menuFiltro =
        document.getElementById('menuFiltro');

    const ordenAscendente =
        document.getElementById('ordenAscendente');

    const ordenDescendente =
        document.getElementById('ordenDescendente');


    if (botonFiltro) {

        botonFiltro.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

                if (menuFiltro) {

                    menuFiltro.classList.toggle('activo');

                }

            }
        );

    }


    /* =====================================
       ORDENAR A → Z
    ====================================== */

    if (ordenAscendente) {

        ordenAscendente.addEventListener(
            'click',
            function () {

                ordenarClientes('asc');

                if (menuFiltro) {

                    menuFiltro.classList.remove('activo');

                }

            }
        );

    }


    /* =====================================
       ORDENAR Z → A
    ====================================== */

    if (ordenDescendente) {

        ordenDescendente.addEventListener(
            'click',
            function () {

                ordenarClientes('desc');

                if (menuFiltro) {

                    menuFiltro.classList.remove('activo');

                }

            }
        );

    }


    /* =====================================
       ORDENAR CLIENTES
    ====================================== */

    function ordenarClientes(tipo) {

        const tabla =
            document.getElementById('tablaClientes');


        if (!tabla) {
            return;
        }


        const cuerpo =
            tabla.querySelector('tbody');


        if (!cuerpo) {
            return;
        }


        const filas =
            Array.from(
                cuerpo.querySelectorAll('tr')
            );


        filas.sort(function (a, b) {

            const nombreA =
                a.cells[1]
                    .textContent
                    .trim()
                    .toLowerCase();


            const nombreB =
                b.cells[1]
                    .textContent
                    .trim()
                    .toLowerCase();


            if (tipo === 'asc') {

                return nombreA.localeCompare(
                    nombreB,
                    'es'
                );

            }


            return nombreB.localeCompare(
                nombreA,
                'es'
            );

        });


        filas.forEach(function (fila) {

            cuerpo.appendChild(fila);

        });

    }


    /* =====================================
       CERRAR FILTRO AL HACER CLIC FUERA
    ====================================== */

    document.addEventListener(
        'click',
        function (event) {

            const filtro =
                document.querySelector('.filtro');


            if (
                filtro &&
                !filtro.contains(event.target)
            ) {

                if (menuFiltro) {

                    menuFiltro.classList.remove('activo');

                }

            }

        }
    );


    /* =====================================
       MODAL ELIMINAR
    ====================================== */

    function abrirModalEliminar(id, nombre) {

        const modal =
            document.getElementById('modalEliminar');

        const formulario =
            document.getElementById('formEliminar');

        const mensaje =
            document.getElementById('mensajeEliminar');


        if (
            !modal ||
            !formulario ||
            !mensaje
        ) {

            return;

        }


        mensaje.innerHTML =
            '¿Estás seguro de que deseas eliminar a <strong>' +
            nombre +
            '</strong>?';


        formulario.action =
            "{{ url('/admin/clientes') }}/" + id;


        modal.classList.add('activo');

    }


    function cerrarModalEliminar() {

        const modal =
            document.getElementById('modalEliminar');


        if (modal) {

            modal.classList.remove('activo');

        }

    }


    /* =====================================
       CERRAR MODAL AL HACER CLIC FUERA
    ====================================== */

    window.addEventListener(
        'click',
        function (event) {

            const modal =
                document.getElementById('modalEliminar');


            if (
                modal &&
                event.target === modal
            ) {

                cerrarModalEliminar();

            }

        }
    );


    /* =====================================
       CERRAR MODAL CON ESC
    ====================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                cerrarModalEliminar();

            }

        }
    );

</script>

</body>

</html>
