<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Vendedor - Gestor de Ventas</title>

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
           TARJETAS DE RESUMEN
        ===================================== */

        .resumen {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-bottom: 35px;
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
            flex-shrink: 0;
        }

        .resumen-card:nth-child(1) .resumen-icono {
            background: #f1e5f7;
            color: var(--morado);
        }

        .resumen-card:nth-child(2) .resumen-icono {
            background: #e7f0fc;
            color: var(--azul);
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
           MÓDULOS
        ===================================== */

        .modulos-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 18px;
        }

        .modulos-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .modulos-header span {
            color: var(--texto-suave);
            font-size: 13px;
        }

        .botones {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        /* =====================================
           BOTONES
        ===================================== */

        .boton {
            position: relative;

            background: white;
            color: var(--texto);

            border: 1px solid var(--borde);
            border-radius: 15px;

            padding: 24px 20px;
            min-height: 145px;

            text-decoration: none;

            transition: 0.25s ease;
            overflow: hidden;
        }

        .boton::after {
            content: "";

            position: absolute;

            width: 70px;
            height: 70px;

            background: var(--morado-claro);

            border-radius: 50%;

            right: -25px;
            bottom: -30px;

            transition: 0.25s;
        }

        .boton:hover {
            transform: translateY(-5px);

            border-color: var(--morado);

            box-shadow:
                0 10px 25px rgba(106,27,154,0.12);
        }

        .boton:hover::after {
            transform: scale(1.5);
        }

        .boton i {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--morado-claro);
            color: var(--morado);

            border-radius: 12px;

            font-size: 21px;

            margin-bottom: 17px;

            position: relative;
            z-index: 2;

            transition: 0.25s;
        }

        .boton:hover i {
            background: var(--morado);
            color: white;
        }

        .boton strong {
            display: block;

            font-size: 15px;

            margin-bottom: 5px;

            position: relative;
            z-index: 2;
        }

        .boton span {
            display: block;

            color: var(--texto-suave);

            font-size: 12px;
            line-height: 1.4;

            position: relative;
            z-index: 2;
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
                grid-template-columns: 1fr;
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

            .botones {
                grid-template-columns: 1fr;
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
            Vendedor
        </div>


        <nav class="menu">


            <!-- INICIO -->

            <a
                href="{{ route('vendedor.dashboard') }}"
                class="activo"
            >

                <i class="fa-solid fa-house"></i>

                Menú Principal

            </a>


            <!-- PUNTO DE VENTA -->

            @if(auth()->user()->puntoVenta)

                <a
                    href="{{ route('empleado.punto_venta') }}"
                >

                    <i class="fa-solid fa-cash-register"></i>

                    Punto de venta

                </a>

            @endif


            <!-- MI INFORMACIÓN -->

            <a
                href="{{ route('vendedor.informacion') }}"
            >

                <i class="fa-solid fa-user"></i>

                Mi información

            </a>


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

                    Panel de vendedor · Los Amates

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
                            Vendedor
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

                    Panel del Vendedor

                </h2>


                <p>

                    Accede rápidamente a las herramientas disponibles para realizar tu trabajo.

                </p>


            </div>


            <!-- =====================================
                 RESUMEN
            ====================================== -->

            <div class="resumen">


                <!-- MI INFORMACIÓN -->

                <div class="resumen-card">


                    <div class="resumen-icono">

                        <i class="fa-solid fa-user"></i>

                    </div>


                    <div class="resumen-info">

                        <span>
                            Cuenta
                        </span>

                        <strong>
                            Mi información
                        </strong>

                    </div>


                </div>


                <!-- PUNTO DE VENTA -->

                @if(auth()->user()->puntoVenta)

                    <div class="resumen-card">


                        <div class="resumen-icono">

                            <i class="fa-solid fa-cash-register"></i>

                        </div>


                        <div class="resumen-info">

                            <span>
                                Operación
                            </span>

                            <strong>
                                Punto de venta
                            </strong>

                        </div>


                    </div>

                @endif


            </div>


            <!-- =====================================
                 ACCESOS RÁPIDOS
            ====================================== -->

            <div class="modulos-header">


                <h3>
                    Accesos rápidos
                </h3>


                <span>
                    Módulos disponibles
                </span>


            </div>


            <div class="botones">


                <!-- MI INFORMACIÓN -->

                <a
                    href="{{ route('vendedor.informacion') }}"
                    class="boton"
                >


                    <i class="fa-solid fa-user"></i>


                    <strong>

                        Mi información

                    </strong>


                    <span>

                        Consulta y actualiza tu información personal.

                    </span>


                </a>


                <!-- PUNTO DE VENTA -->

                @if(auth()->user()->puntoVenta)

                    <a
                        href="{{ route('empleado.punto_venta') }}"
                        class="boton"
                    >


                        <i class="fa-solid fa-cash-register"></i>


                        <strong>

                            Punto de venta

                        </strong>


                        <span>

                            Accede al sistema para realizar las operaciones de venta.

                        </span>


                    </a>

                @endif


            </div>


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