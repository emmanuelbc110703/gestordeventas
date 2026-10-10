<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mi información - Los Amates</title>

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
            --rojo: #d9534f;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--fondo);
            color: var(--texto);
        }

        /* =====================================
           ESTRUCTURA
        ===================================== */

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* =====================================
           SIDEBAR
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
           PERFIL TOPBAR
        ===================================== */

        .perfil-top {
            position: relative;
        }

        .avatar-top {
            width: 45px;
            height: 45px;
            border: 3px solid var(--morado-claro);
            border-radius: 50%;
            background-color: {{ auth()->user()->color_perfil ?? '#6a1b9a' }};
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

        .avatar-top:hover {
            transform: scale(1.06);
            border-color: var(--morado);
        }

        .avatar-top img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

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
           MENSAJE
        ===================================== */

        .mensaje {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 22px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #c8e6c9;
        }

        /* =====================================
           TARJETA PRINCIPAL
        ===================================== */

        .tarjeta {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.04);
        }

        /* =====================================
           CABECERA PERFIL
        ===================================== */

        .cabecera-perfil {
            display: flex;
            align-items: center;
            gap: 25px;
            padding-bottom: 28px;
            border-bottom: 1px solid var(--borde);
        }

        .perfil-avatar {
            position: relative;
            width: 115px;
            height: 115px;
            flex-shrink: 0;
        }

        .avatar {
            width: 105px;
            height: 105px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: bold;
            overflow: hidden;
            border: 5px solid var(--morado-claro);
            box-shadow: 0 5px 15px rgba(0,0,0,0.10);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* =====================================
           BOTÓN EDITAR FOTO
        ===================================== */

        .boton-editar-foto {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 38px;
            height: 38px;
            border: 3px solid white;
            border-radius: 50%;
            background: var(--morado);
            color: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.20);
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .boton-editar-foto:hover {
            background: var(--morado-oscuro);
            transform: scale(1.08);
        }

        /* =====================================
           MENÚ FOTO
        ===================================== */

        .menu-foto {
            display: none;
            position: absolute;
            top: 120px;
            left: 0;
            width: 200px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: 1px solid var(--borde);
            overflow: hidden;
            z-index: 100;
        }

        .menu-foto.mostrar {
            display: block;
        }

        .menu-foto button {
            width: 100%;
            padding: 13px 15px;
            border: none;
            background: white;
            color: #444;
            text-align: left;
            cursor: pointer;
            font-size: 14px;
            transition: 0.25s;
        }

        .menu-foto button:hover {
            background: var(--morado-claro);
            color: var(--morado);
        }

        .menu-foto button i {
            width: 25px;
            color: var(--morado);
        }

        /* =====================================
           PANEL COLORES
        ===================================== */

        .panel-colores {
            display: none;
            position: absolute;
            top: 120px;
            left: 0;
            width: 230px;
            background: white;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: 1px solid var(--borde);
            z-index: 101;
        }

        .panel-colores.mostrar {
            display: block;
        }

        .panel-colores p {
            margin: 0 0 13px;
            color: var(--texto);
            font-size: 14px;
            font-weight: bold;
        }

        .colores {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .color-opcion {
            width: 45px;
            height: 45px;
            border: 3px solid transparent;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
        }

        .color-opcion:hover {
            transform: scale(1.12);
            border-color: #333;
        }

        .formulario-oculto {
            display: none;
        }

        /* =====================================
           TEXTO PERFIL
        ===================================== */

        .datos-perfil h2 {
            margin: 0 0 6px;
            color: var(--texto);
            font-size: 23px;
        }

        .datos-perfil p {
            margin: 0;
            color: var(--texto-suave);
            font-size: 14px;
        }

        .etiqueta-admin {
            display: inline-block;
            margin-top: 12px;
            padding: 6px 11px;
            background: var(--morado-claro);
            color: var(--morado);
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        /* =====================================
           INFORMACIÓN
        ===================================== */

        .titulo-informacion {
            margin: 30px 0 17px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .titulo-informacion i {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--morado-claro);
            color: var(--morado);
            border-radius: 9px;
        }

        .titulo-informacion h3 {
            margin: 0;
            font-size: 17px;
        }

        .informacion {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .dato {
            background: #faf9fb;
            padding: 17px;
            border: 1px solid var(--borde);
            border-radius: 12px;
            transition: 0.25s;
        }

        .dato:hover {
            border-color: #d8c1e2;
            background: #fcf9fd;
        }

        .dato strong {
            display: flex;
            align-items: center;
            color: var(--texto-suave);
            margin-bottom: 8px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .dato i {
            color: var(--morado);
            margin-right: 8px;
            font-size: 14px;
        }

        .dato span {
            color: var(--texto);
            font-size: 14px;
            word-break: break-word;
        }

        /* =====================================
           BOTÓN EDITAR
        ===================================== */

        .acciones {
            display: flex;
            justify-content: flex-end;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid var(--borde);
        }

        .boton-editar {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            background: var(--morado);
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: 0.25s;
        }

        .boton-editar:hover {
            background: var(--morado-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(106,27,154,0.20);
        }

        /* =====================================
           RESPONSIVE
        ===================================== */

        @media (max-width: 1100px) {

            .informacion {
                grid-template-columns: 1fr;
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
                height: 72px;
                padding: 0 18px;
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

            .tarjeta {
                padding: 20px;
            }

            .cabecera-perfil {
                flex-direction: column;
                text-align: center;
            }

            .menu-foto,
            .panel-colores {
                left: 50%;
                transform: translateX(-50%);
            }

            .acciones {
                justify-content: center;
            }

            .boton-editar {
                width: 100%;
                justify-content: center;
            }

        }

        @media (max-width: 450px) {

            .menu {
                grid-template-columns: 1fr 1fr;
            }

            .informacion {
                grid-template-columns: 1fr;
            }

            .cabecera-perfil {
                gap: 15px;
            }

            .datos-perfil h2 {
                font-size: 20px;
            }

        }

    </style>

</head>


<body>


<div class="dashboard">


    <!-- =====================================
         SIDEBAR
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

            <a
                href="{{ route('admin.informacion') }}"
                class="activo"
            >

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
         CONTENIDO
    ====================================== -->

    <main class="contenido">


        <!-- =====================================
             TOPBAR
        ====================================== -->

        <header class="topbar">

            <div class="saludo">

                <h1>
                    Mi información
                </h1>

                <p>
                    Administra los datos de tu cuenta
                </p>

            </div>


            <!-- PERFIL -->

            <div class="perfil-top">

                <button
                    type="button"
                    class="avatar-top"
                    id="botonPerfil"
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
                    Información de mi cuenta
                </h2>

                <p>
                    Consulta y administra tus datos personales y preferencias.
                </p>

            </div>


            @if(session('success'))

                <div class="mensaje">

                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}

                </div>

            @endif


            <!-- =====================================
                 TARJETA
            ====================================== -->

            <div class="tarjeta">


                <!-- CABECERA PERFIL -->

                <div class="cabecera-perfil">


                    <div class="perfil-avatar">


                        <!-- AVATAR -->

                        <div
                            class="avatar"
                            style="
                                background-color:
                                {{ auth()->user()->color_perfil ?? '#6a1b9a' }};
                            "
                        >

                            @if(auth()->user()->foto_perfil)

                                <img
                                    src="{{ asset('storage/' . auth()->user()->foto_perfil) }}"
                                    alt="Foto de perfil"
                                >

                            @else

                                {{ strtoupper(
                                    substr(auth()->user()->name, 0, 1)
                                ) }}

                            @endif

                        </div>


                        <!-- BOTÓN EDITAR FOTO -->

                        <button
                            type="button"
                            class="boton-editar-foto"
                            id="botonEditarFoto"
                            title="Editar foto de perfil"
                        >

                            <i class="fa-solid fa-pen"></i>

                        </button>


                        <!-- MENÚ FOTO -->

                        <div
                            class="menu-foto"
                            id="menuFoto"
                        >

                            <button
                                type="button"
                                id="subirFoto"
                            >

                                <i class="fa-solid fa-camera"></i>

                                Subir foto

                            </button>


                            <button
                                type="button"
                                id="cambiarColor"
                            >

                                <i class="fa-solid fa-palette"></i>

                                Cambiar color

                            </button>

                        </div>


                        <!-- PANEL COLORES -->

                        <div
                            class="panel-colores"
                            id="panelColores"
                        >

                            <form
                                id="formularioColor"
                                action="{{ route('admin.color.actualizar') }}"
                                method="POST"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="color_perfil"
                                    id="colorPerfilSeleccionado"
                                >


                                <p>
                                    Selecciona un color
                                </p>


                                <div class="colores">

                                    <button
                                        type="button"
                                        class="color-opcion"
                                        data-color="#6a1b9a"
                                        style="background-color:#6a1b9a;"
                                        title="Morado"
                                    ></button>


                                    <button
                                        type="button"
                                        class="color-opcion"
                                        data-color="#2196F3"
                                        style="background-color:#2196F3;"
                                        title="Azul"
                                    ></button>


                                    <button
                                        type="button"
                                        class="color-opcion"
                                        data-color="#F44336"
                                        style="background-color:#F44336;"
                                        title="Rojo"
                                    ></button>


                                    <button
                                        type="button"
                                        class="color-opcion"
                                        data-color="#4CAF50"
                                        style="background-color:#4CAF50;"
                                        title="Verde"
                                    ></button>


                                    <button
                                        type="button"
                                        class="color-opcion"
                                        data-color="#FF9800"
                                        style="background-color:#FF9800;"
                                        title="Naranja"
                                    ></button>


                                    <button
                                        type="button"
                                        class="color-opcion"
                                        data-color="#263238"
                                        style="background-color:#263238;"
                                        title="Oscuro"
                                    ></button>

                                </div>

                            </form>

                        </div>


                        <!-- FORMULARIO FOTO -->

                        <form
                            id="formularioFoto"
                            class="formulario-oculto"
                            action="{{ route('admin.foto.actualizar') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            @csrf

                            <input
                                type="file"
                                id="inputFotoPerfil"
                                name="foto_perfil"
                                accept="image/*"
                            >

                        </form>

                    </div>


                    <!-- DATOS DEL PERFIL -->

                    <div class="datos-perfil">

                        <h2>
                            {{ auth()->user()->name }}
                            {{ auth()->user()->apellido }}
                        </h2>


                        <p>
                            Administrador de Orquídeas y más "Los Amates"
                        </p>


                        <span class="etiqueta-admin">

                            <i class="fa-solid fa-shield-halved"></i>

                            Administrador

                        </span>

                    </div>

                </div>


                <!-- =====================================
                     INFORMACIÓN
                ====================================== -->

                <div class="titulo-informacion">

                    <i class="fa-solid fa-address-card"></i>

                    <h3>
                        Datos personales
                    </h3>

                </div>


                <div class="informacion">


                    <!-- NOMBRE -->

                    <div class="dato">

                        <strong>

                            <i class="fa-solid fa-user"></i>

                            Nombre

                        </strong>

                        <span>
                            {{ auth()->user()->name }}
                        </span>

                    </div>


                    <!-- APELLIDOS -->

                    <div class="dato">

                        <strong>

                            <i class="fa-solid fa-user"></i>

                            Apellidos

                        </strong>

                        <span>
                            {{ auth()->user()->apellido }}
                        </span>

                    </div>


                    <!-- CORREO -->

                    <div class="dato">

                        <strong>

                            <i class="fa-solid fa-envelope"></i>

                            Correo electrónico

                        </strong>

                        <span>
                            {{ auth()->user()->email }}
                        </span>

                    </div>


                    <!-- TELÉFONO -->

                    <div class="dato">

                        <strong>

                            <i class="fa-solid fa-phone"></i>

                            Teléfono

                        </strong>

                        <span>
                            {{ auth()->user()->telefono ?? 'No registrado' }}
                        </span>

                    </div>


                    <!-- DIRECCIÓN -->

                    <div class="dato">

                        <strong>

                            <i class="fa-solid fa-location-dot"></i>

                            Dirección

                        </strong>

                        <span>
                            {{ auth()->user()->direccion ?? 'No registrada' }}
                        </span>

                    </div>


                    <!-- FECHA NACIMIENTO -->

                    <div class="dato">

                        <strong>

                            <i class="fa-solid fa-calendar"></i>

                            Fecha de nacimiento

                        </strong>

                        <span>
                            {{ auth()->user()->fecha_nacimiento ?? 'No registrada' }}
                        </span>

                    </div>

                </div>


                <!-- =====================================
                     ACCIONES
                ====================================== -->

                <div class="acciones">

                    <a
                        href="{{ route('admin.informacion.editar') }}"
                        class="boton-editar"
                    >

                        <i class="fa-solid fa-pen-to-square"></i>

                        Editar información

                    </a>

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
       MENÚ PERFIL TOPBAR
    ====================================== */

    const botonPerfil =
        document.getElementById('botonPerfil');

    const menuPerfil =
        document.getElementById('menuPerfil');


    botonPerfil.addEventListener(
        'click',
        function(event) {

            event.stopPropagation();

            menuPerfil.classList.toggle('activo');

        }
    );


    /* =====================================
       ELEMENTOS FOTO
    ====================================== */

    const botonEditarFoto =
        document.getElementById('botonEditarFoto');

    const menuFoto =
        document.getElementById('menuFoto');

    const panelColores =
        document.getElementById('panelColores');

    const subirFoto =
        document.getElementById('subirFoto');

    const cambiarColor =
        document.getElementById('cambiarColor');

    const inputFotoPerfil =
        document.getElementById('inputFotoPerfil');

    const formularioFoto =
        document.getElementById('formularioFoto');

    const formularioColor =
        document.getElementById('formularioColor');

    const colorPerfilSeleccionado =
        document.getElementById('colorPerfilSeleccionado');

    const opcionesColor =
        document.querySelectorAll('.color-opcion');


    /* =====================================
       ABRIR MENÚ FOTO
    ====================================== */

    botonEditarFoto.addEventListener(
        'click',
        function(event) {

            event.stopPropagation();

            menuFoto.classList.toggle('mostrar');

            panelColores.classList.remove('mostrar');

        }
    );


    /* =====================================
       SUBIR FOTO
    ====================================== */

    subirFoto.addEventListener(
        'click',
        function(event) {

            event.stopPropagation();

            inputFotoPerfil.click();

        }
    );


    /* =====================================
       GUARDAR FOTO
    ====================================== */

    inputFotoPerfil.addEventListener(
        'change',
        function() {

            if (this.files.length > 0) {

                formularioFoto.submit();

            }

        }
    );


    /* =====================================
       CAMBIAR COLOR
    ====================================== */

    cambiarColor.addEventListener(
        'click',
        function(event) {

            event.stopPropagation();

            menuFoto.classList.remove('mostrar');

            panelColores.classList.toggle('mostrar');

        }
    );


    /* =====================================
       SELECCIONAR COLOR
    ====================================== */

    opcionesColor.forEach(
        function(opcion) {

            opcion.addEventListener(
                'click',
                function(event) {

                    event.stopPropagation();

                    const color =
                        this.getAttribute('data-color');

                    colorPerfilSeleccionado.value =
                        color;

                    formularioColor.submit();

                }
            );

        }
    );


    /* =====================================
       CERRAR MENÚS
    ====================================== */

    document.addEventListener(
        'click',
        function(event) {

            if (
                !botonEditarFoto.contains(event.target) &&
                !menuFoto.contains(event.target) &&
                !panelColores.contains(event.target)
            ) {

                menuFoto.classList.remove('mostrar');

                panelColores.classList.remove('mostrar');

            }


            if (
                !botonPerfil.contains(event.target) &&
                !menuPerfil.contains(event.target)
            ) {

                menuPerfil.classList.remove('activo');

            }

        }
    );

</script>


</body>

</html>