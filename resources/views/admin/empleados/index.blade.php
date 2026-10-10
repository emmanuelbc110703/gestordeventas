<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Empleados - Gestor de Ventas Los Amates</title>

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
           CABECERA DEL MÓDULO
        ===================================== */

        .modulo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .modulo-info h3 {
            margin: 0;
            font-size: 18px;
        }

        .modulo-info span {
            display: block;
            margin-top: 5px;
            color: var(--texto-suave);
            font-size: 13px;
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
            font-size: 14px;
            font-weight: bold;
            transition: 0.25s ease;
        }

        .boton-agregar:hover {
            background: var(--morado-oscuro);
            transform: translateY(-2px);
            box-shadow: 0 7px 18px rgba(106,27,154,0.18);
        }

        /* =====================================
           BUSCADOR
        ===================================== */

        .buscador-contenedor {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 20px;
        }

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
            outline: none;
            font-size: 14px;
            color: var(--texto);
            background: #fff;
            transition: 0.25s;
        }

        .buscador input:focus {
            border-color: var(--morado);
            box-shadow: 0 0 0 3px var(--morado-claro);
        }

        /* =====================================
           TABLA
        ===================================== */

        .tabla-contenedor {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        thead {
            background: var(--morado);
            color: white;
        }

        th {
            padding: 14px 15px;
            text-align: left;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        th:first-child {
            border-radius: 8px 0 0 8px;
        }

        th:last-child {
            border-radius: 0 8px 8px 0;
        }

        td {
            padding: 14px 15px;
            text-align: left;
            border-bottom: 1px solid var(--borde);
            color: var(--texto);
            font-size: 14px;
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
           AVATAR TABLA
        ===================================== */

        .avatar-tabla {
            width: 43px;
            height: 43px;
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
           ROL
        ===================================== */

        .rol {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .rol-admin {
            background: #f1e5f7;
            color: var(--morado);
        }

        .rol-vendedor {
            background: #e6f4ec;
            color: var(--verde);
        }

        /* =====================================
           ACCIONES
        ===================================== */

        .acciones {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .boton-editar,
        .boton-eliminar {
            width: 36px;
            height: 36px;
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
            background: #fde9e8;
            color: var(--rojo);
        }

        .boton-eliminar:hover {
            background: var(--rojo);
            color: white;
            transform: translateY(-2px);
        }

        /* =====================================
           SIN EMPLEADOS
        ===================================== */

        .sin-empleados {
            text-align: center;
            padding: 55px 30px;
            color: var(--texto-suave);
        }

        .sin-empleados i {
            display: block;
            font-size: 48px;
            color: var(--morado);
            margin-bottom: 15px;
        }

        .sin-empleados h3 {
            margin: 0 0 8px;
            color: var(--texto);
            font-size: 18px;
        }

        .sin-empleados p {
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
            background: rgba(41,37,45,0.55);
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
            border-radius: 15px;
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
            background: #fde9e8;
            color: var(--rojo);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
        }

        .modal-contenido h2 {
            color: var(--texto);
            margin: 10px 0;
            font-size: 20px;
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
            background: #f0eef1;
            color: #555;
        }

        .boton-cancelar:hover {
            background: #e2dfe4;
        }

        .boton-confirmar {
            background: var(--rojo);
            color: white;
        }

        .boton-confirmar:hover {
            background: #b93f3b;
            transform: translateY(-2px);
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

        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            .contenido {
                width: calc(100% - 210px);
                margin-left: 210px;
            }

            .contenedor {
                padding: 28px;
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

            .modulo-header {
                align-items: stretch;
                flex-direction: column;
            }

            .boton-agregar {
                justify-content: center;
            }

            .tabla-contenedor {
                padding: 12px;
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

            <a href="{{ route('admin.empleados') }}" class="activo">
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

                <h1> Empleados </h1> 
                <p> Administra los usuarios con perfil de administrador y vendedor. </p>

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
             CONTENIDO DEL MÓDULO
        ====================================== -->

        <section class="contenedor">


            <!-- CABECERA -->

            <div class="modulo-header">

                <div class="modulo-info">

                    <h3>
                        Personal registrado
                    </h3>

                    <span>
                        Consulta, modifica o elimina empleados del sistema.
                    </span>

                </div>

                <a
                    href="{{ route('admin.empleados.agregar') }}"
                    class="boton-agregar"
                >

                    <i class="fa-solid fa-user-plus"></i>

                    Agregar empleado

                </a>

            </div>


            <!-- BUSCADOR -->

            <div class="buscador-contenedor">

                <div class="buscador">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        id="buscadorEmpleados"
                        placeholder="Buscar empleado por nombre, apellido o correo..."
                    >

                </div>

            </div>


            <!-- TABLA -->

            <div class="tabla-contenedor">

                @if($empleados->count() > 0)

                    <table id="tablaEmpleados">

                        <thead>

                            <tr>
                                <th>Perfil</th>
                                <th>Nombre completo</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($empleados as $empleado)

                                <tr>

                                    <!-- PERFIL -->

                                    <td>

                                        <div
                                            class="avatar-tabla"
                                            style="background-color: {{ $empleado->color_perfil ?? '#6a1b9a' }};"
                                        >

                                            @if($empleado->foto_perfil)

                                                <img
                                                    src="{{ asset('storage/' . $empleado->foto_perfil) }}"
                                                    alt="Foto de {{ $empleado->name }}"
                                                >

                                            @else

                                                {{ strtoupper(substr($empleado->name, 0, 1)) }}

                                            @endif

                                        </div>

                                    </td>


                                    <!-- NOMBRE -->

                                    <td>

                                        <strong>
                                            {{ $empleado->name }}
                                            {{ $empleado->apellido }}
                                        </strong>

                                    </td>


                                    <!-- CORREO -->

                                    <td>
                                        {{ $empleado->email }}
                                    </td>


                                    <!-- TELÉFONO -->

                                    <td>
                                        {{ $empleado->telefono ?? 'No registrado' }}
                                    </td>


                                    <!-- ROL -->

                                    <td>

                                        @if($empleado->rol === 'admin')

                                            <span class="rol rol-admin">

                                                <i class="fa-solid fa-user-shield"></i>

                                                Administrador

                                            </span>

                                        @elseif($empleado->rol === 'vendedor')

                                            <span class="rol rol-vendedor">

                                                <i class="fa-solid fa-user-tie"></i>

                                                Vendedor

                                            </span>

                                        @endif

                                    </td>


                                    <!-- ACCIONES -->

                                    <td>

                                        <div class="acciones">

                                            <!-- EDITAR -->

                                            <a
                                                href="{{ route('admin.empleados.editar', $empleado->id) }}"
                                                class="boton-editar"
                                                title="Editar empleado"
                                            >

                                                <i class="fa-solid fa-pen-to-square"></i>

                                            </a>


                                            <!-- ELIMINAR -->

                                            <button
                                                type="button"
                                                class="boton-eliminar"
                                                title="Eliminar empleado"
                                                onclick="abrirModalEliminar(
                                                    {{ $empleado->id }},
                                                    @js($empleado->name . ' ' . $empleado->apellido)
                                                )"
                                            >

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="sin-empleados">

                        <i class="fa-solid fa-users"></i>

                        <h3>
                            No hay empleados registrados
                        </h3>

                        <p>
                            Actualmente no existen administradores ni vendedores registrados.
                        </p>

                    </div>

                @endif

            </div>

        </section>

    </main>

</div>


<!-- =====================================
     MODAL ELIMINAR EMPLEADO
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
            Eliminar empleado
        </h2>

        <p id="mensajeEliminar">
            ¿Estás seguro de que deseas eliminar este empleado?
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

    /* =====================================
       MENÚ DE PERFIL
    ===================================== */

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
    ===================================== */

    const buscador =
        document.getElementById('buscadorEmpleados');


    if (buscador) {

        buscador.addEventListener('input', function() {

            const texto =
                this.value.toLowerCase().trim();

            const filas =
                document.querySelectorAll(
                    '#tablaEmpleados tbody tr'
                );


            filas.forEach(function(fila) {

                const nombre =
                    fila.cells[1].textContent.toLowerCase();

                const correo =
                    fila.cells[2].textContent.toLowerCase();

                const telefono =
                    fila.cells[3].textContent.toLowerCase();

                const rol =
                    fila.cells[4].textContent.toLowerCase();


                if (
                    nombre.includes(texto) ||
                    correo.includes(texto) ||
                    telefono.includes(texto) ||
                    rol.includes(texto)
                ) {

                    fila.style.display = '';

                } else {

                    fila.style.display = 'none';

                }

            });

        });

    }


    /* =====================================
       ABRIR MODAL
    ===================================== */

    function abrirModalEliminar(id, nombre) {

        const modal =
            document.getElementById('modalEliminar');

        const formulario =
            document.getElementById('formEliminar');

        const mensaje =
            document.getElementById('mensajeEliminar');


        mensaje.innerHTML =
            '¿Estás seguro de que deseas eliminar a <strong>' +
            nombre +
            '</strong>?';


        formulario.action =
            "{{ url('/admin/empleados') }}/" + id;


        modal.classList.add('activo');

    }


    /* =====================================
       CERRAR MODAL
    ===================================== */

    function cerrarModalEliminar() {

        const modal =
            document.getElementById('modalEliminar');

        modal.classList.remove('activo');

    }


    /* =====================================
       CERRAR AL HACER CLIC FUERA
    ===================================== */

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

