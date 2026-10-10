<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Puntos de venta - Los Amates</title>

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
            --rojo-oscuro: #b52b27;
            --rojo-claro: #fbe9e8;
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

        /* =====================================
           ENCABEZADO
        ===================================== */

        .encabezado-seccion {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }

        .titulo-seccion h2 {
            margin: 0;
            font-size: 22px;
        }

        .titulo-seccion h2 i {
            color: var(--morado);
            margin-right: 8px;
        }

        .titulo-seccion p {
            color: var(--texto-suave);
            margin: 7px 0 0;
            font-size: 14px;
        }

        .boton-agregar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--morado);
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
            transition: 0.25s;
        }

        .boton-agregar:hover {
            background: var(--morado-oscuro);
            transform: translateY(-2px);
        }

        /* =====================================
           LISTA DE PUNTOS DE VENTA
        ===================================== */

        .lista-puntos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        /* =====================================
           TARJETA
        ===================================== */

        .tarjeta {
            position: relative;
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 22px;
            min-height: 300px;
            overflow: hidden;
            transition: 0.25s ease;
        }

        .tarjeta::after {
            content: "";
            position: absolute;
            width: 80px;
            height: 80px;
            background: var(--morado-claro);
            border-radius: 50%;
            right: -30px;
            bottom: -35px;
            transition: 0.25s;
        }

        .tarjeta:hover {
            transform: translateY(-4px);
            border-color: var(--morado);
            box-shadow: 0 10px 25px rgba(106,27,154,0.12);
        }

        .tarjeta:hover::after {
            transform: scale(1.5);
        }

        .icono-punto {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--morado-claro);
            color: var(--morado);
            font-size: 20px;
            margin-bottom: 17px;
            position: relative;
            z-index: 2;
            transition: 0.25s;
        }

        .tarjeta:hover .icono-punto {
            background: var(--morado);
            color: white;
        }

        .tarjeta h3 {
            margin: 0 0 15px;
            font-size: 17px;
            position: relative;
            z-index: 2;
        }

        /* =====================================
           DATOS
        ===================================== */

        .dato {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--borde);
            color: var(--texto-suave);
            font-size: 13px;
            line-height: 1.4;
            position: relative;
            z-index: 2;
        }

        .dato:last-of-type {
            border-bottom: none;
        }

        .dato i {
            width: 20px;
            min-width: 20px;
            color: var(--morado);
            text-align: center;
            margin-top: 2px;
        }

        .dato strong {
            color: var(--texto);
        }

        /* =====================================
           ACCIONES
        ===================================== */

        .acciones {
            display: flex;
            gap: 8px;
            margin-top: 20px;
            position: relative;
            z-index: 3;
        }

        .boton-editar,
        .boton-eliminar {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border: none;
            padding: 10px 12px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.25s;
        }

        .boton-editar {
            background: var(--morado);
            color: white;
        }

        .boton-editar:hover {
            background: var(--morado-oscuro);
            transform: translateY(-2px);
        }

        .boton-eliminar {
            background: var(--rojo);
            color: white;
        }

        .boton-eliminar:hover {
            background: var(--rojo-oscuro);
            transform: translateY(-2px);
        }

        /* =====================================
           SIN PUNTOS
        ===================================== */

        .sin-puntos {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 70px 25px;
            text-align: center;
        }

        .sin-puntos i {
            display: block;
            font-size: 50px;
            color: var(--morado);
            margin-bottom: 15px;
        }

        .sin-puntos h3 {
            margin: 0 0 8px;
        }

        .sin-puntos p {
            margin: 0;
            color: var(--texto-suave);
            font-size: 14px;
        }

        /* =====================================
           MODAL
        ===================================== */

        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            inset: 0;
            background: rgba(0,0,0,0.55);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.activo {
            display: flex;
        }

        .modal-contenido {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            animation: aparecerModal 0.25s ease;
        }

        .modal-icono {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: var(--rojo-claro);
            color: var(--rojo);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
        }

        .modal-contenido h2 {
            color: var(--texto);
            margin: 10px 0;
            font-size: 21px;
        }

        .modal-contenido p {
            color: var(--texto-suave);
            line-height: 1.5;
            margin-bottom: 25px;
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
            background: #eeeeee;
            color: #555;
        }

        .boton-cancelar:hover {
            background: #dcdcdc;
        }

        .boton-confirmar {
            background: var(--rojo);
            color: white;
        }

        .boton-confirmar:hover {
            background: var(--rojo-oscuro);
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
            .lista-puntos {
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

            .lista-puntos {
                grid-template-columns: repeat(2, 1fr);
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

            .encabezado-seccion {
                flex-direction: column;
                align-items: stretch;
            }

            .boton-agregar {
                width: 100%;
            }

            .lista-puntos {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 450px) {
            .acciones {
                flex-direction: column;
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

            <a
                href="{{ route('admin.puntos_venta') }}"
                class="activo"
            >
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
                    Puntos de venta
                </h1>

                <p>
                    Administración de cajas y empleados asignados
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


        <!-- CONTENIDO -->

        <section class="contenedor">

            <div class="encabezado-seccion">

                <div class="titulo-seccion">

                    <h2>
                        <i class="fa-solid fa-store"></i>
                        Mis puntos de venta
                    </h2>

                    <p>
                        Administra las cajas disponibles y los empleados asignados.
                    </p>

                </div>


                <a
                    href="{{ route('admin.puntos_venta.create') }}"
                    class="boton-agregar"
                >

                    <i class="fa-solid fa-plus"></i>

                    Crear punto de venta

                </a>

            </div>


            <!-- =====================================
                 LISTA DE PUNTOS DE VENTA
            ====================================== -->

            @if($puntosVenta->count() > 0)

                <div class="lista-puntos">

                    @foreach($puntosVenta as $punto)

                        <div class="tarjeta">

                            <div class="icono-punto">
                                <i class="fa-solid fa-cash-register"></i>
                            </div>


                            <h3>
                                {{ $punto->nombre_caja }}
                            </h3>


                            <div class="dato">

                                <i class="fa-solid fa-hashtag"></i>

                                <span>
                                    <strong>Caja:</strong>
                                    {{ $punto->numero_caja }}
                                </span>

                            </div>


                            <div class="dato">

                                <i class="fa-solid fa-location-dot"></i>

                                <span>
                                    <strong>Sucursal:</strong>
                                    {{ $punto->sucursal }}
                                </span>

                            </div>


                            <div class="dato">

                                <i class="fa-solid fa-user"></i>

                                <span>

                                    <strong>Empleado:</strong>

                                    @if($punto->empleado)

                                        {{ $punto->empleado->name }}
                                        {{ $punto->empleado->apellido }}

                                    @else

                                        Sin asignar

                                    @endif

                                </span>

                            </div>


                            <div class="acciones">

                                <a
                                    href="{{ route('admin.puntos_venta.edit', $punto->id) }}"
                                    class="boton-editar"
                                >

                                    <i class="fa-solid fa-pen"></i>
                                    Editar

                                </a>


                                <button
                                    type="button"
                                    class="boton-eliminar"
                                    onclick="abrirModalEliminar(
                                        {{ $punto->id }},
                                        @js($punto->nombre_caja)
                                    )"
                                >

                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar

                                </button>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="sin-puntos">

                    <i class="fa-solid fa-store"></i>

                    <h3>
                        No hay puntos de venta
                    </h3>

                    <p>
                        Todavía no has creado ningún punto de venta.
                    </p>

                </div>

            @endif

        </section>

    </main>

</div>


<!-- =====================================
     MODAL ELIMINAR
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
            Eliminar punto de venta
        </h2>


        <p id="mensajeEliminar">
            ¿Estás seguro de que deseas eliminar este punto de venta?
        </p>


        <form
            id="formEliminar"
            method="POST"
        >

            @csrf
            @method('DELETE')

            <div class="modal-botones">

                <button
                    type="button"
                    class="boton-cancelar"
                    onclick="cerrarModalEliminar()"
                >
                    Cancelar
                </button>


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


    function abrirModalEliminar(id, nombre) {

        const modal =
            document.getElementById('modalEliminar');

        const formulario =
            document.getElementById('formEliminar');

        const mensaje =
            document.getElementById('mensajeEliminar');


        mensaje.innerHTML =
            '¿Estás seguro de que deseas eliminar el punto de venta <strong>'
            + nombre +
            '</strong>?';


        formulario.action =
            "{{ url('/admin/puntos-venta') }}/" + id;


        modal.classList.add('activo');

    }


    function cerrarModalEliminar() {

        const modal =
            document.getElementById('modalEliminar');

        modal.classList.remove('activo');

    }


    window.addEventListener('click', function(event) {

        const modal =
            document.getElementById('modalEliminar');

        if (event.target === modal) {

            cerrarModalEliminar();

        }

    });

</script>

</body>
</html>

