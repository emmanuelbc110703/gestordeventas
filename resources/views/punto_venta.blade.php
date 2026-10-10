<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta - Los Amates</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

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

        .contenido {
            width: calc(100% - 250px);
            margin-left: 250px;
            min-height: 100vh;
        }

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

        .perfil {
            position: relative;
        }

        .avatar {
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

        .avatar:hover {
            transform: scale(1.06);
            border-color: var(--morado);
        }

        .avatar img {
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

        .cabecera-punto {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 22px;
        }

        .icono-punto {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: var(--morado-claro);
            color: var(--morado);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .cabecera-punto h3 {
            margin: 0;
            font-size: 18px;
        }

        .cabecera-punto span {
            display: block;
            margin-top: 4px;
            color: var(--texto-suave);
            font-size: 13px;
        }

        .contenido-punto {
            display: grid;
            grid-template-columns: minmax(0, 1.6fr) minmax(300px, 1fr);
            gap: 22px;
        }

        .tarjeta {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 17px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.04);
        }

        .tarjeta-titulo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .tarjeta-titulo h3 {
            margin: 0;
            font-size: 17px;
        }

        .estado {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e8f5e9;
            color: #2e7d32;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .estado i {
            font-size: 8px;
        }

        .datos-punto {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .dato {
            background: #faf9fb;
            border: 1px solid var(--borde);
            border-radius: 12px;
            padding: 17px;
        }

        .dato .etiqueta {
            display: flex;
            align-items: center;
            color: var(--texto-suave);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 8px;
        }

        .dato .etiqueta i {
            color: var(--morado);
            margin-right: 7px;
            font-size: 13px;
        }

        .dato .valor {
            display: block;
            color: var(--texto);
            font-size: 15px;
            font-weight: bold;
            word-break: break-word;
        }

        .reloj-card {
            margin-top: 18px;
            background: linear-gradient(135deg, #f8f1fb, #ffffff);
            border: 1px solid #e7d9ed;
            border-radius: 14px;
            padding: 25px;
            text-align: center;
        }

        .fecha {
            color: var(--texto-suave);
            font-size: 14px;
            margin-bottom: 8px;
        }

        .hora {
            color: var(--morado);
            font-size: 45px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .apertura-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 100%;
        }

        .icono-apertura {
            width: 65px;
            height: 65px;
            border-radius: 16px;
            background: var(--morado);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 18px;
        }

        .apertura-card h3 {
            margin: 0 0 8px;
            font-size: 20px;
        }

        .apertura-card p {
            margin: 0 0 22px;
            color: var(--texto-suave);
            font-size: 13px;
            line-height: 1.5;
        }

        .boton-iniciar {
            width: 100%;
            padding: 16px;
            background: var(--morado);
            color: white;
            border: none;
            border-radius: 11px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.25s;
        }

        .boton-iniciar:hover {
            background: var(--morado-oscuro);
            transform: translateY(-3px);
            box-shadow: 0 7px 18px rgba(106,27,154,0.25);
        }

        .boton-iniciar i {
            margin-right: 8px;
        }

        .boton-regresar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
            color: var(--texto-suave);
            text-decoration: none;
            font-size: 13px;
            transition: 0.2s;
        }

        .boton-regresar:hover {
            color: var(--morado);
            transform: translateX(-3px);
        }

        .overlay-caja {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(30,20,35,0.62);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
            backdrop-filter: blur(3px);
        }

        .modal-caja {
            width: 100%;
            max-width: 460px;
            background: white;
            border-radius: 18px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 15px 45px rgba(0,0,0,0.30);
            animation: aparecerCaja 0.30s ease;
        }

        @keyframes aparecerCaja {
            from {
                opacity: 0;
                transform: scale(0.90) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .icono-exito,
        .icono-informacion,
        .icono-advertencia {
            width: 75px;
            height: 75px;
            margin: 0 auto 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icono-exito {
            background: #e8f5e9;
            color: #2e7d32;
            font-size: 36px;
        }

        .icono-informacion {
            background: var(--morado-claro);
            color: var(--morado);
            font-size: 32px;
        }

        .icono-advertencia {
            background: #fff8e1;
            color: #f9a825;
            font-size: 36px;
        }

        .modal-caja h2 {
            margin: 0 0 10px;
            color: var(--texto);
            font-size: 25px;
        }

        .mensaje-caja {
            color: var(--texto-suave);
            margin: 0 0 22px;
            font-size: 14px;
            line-height: 1.5;
        }

        .informacion-apertura {
            background: #faf7fb;
            border: 1px solid #eee3f2;
            border-radius: 12px;
            padding: 15px 18px;
            margin-bottom: 18px;
            text-align: left;
        }

        .informacion-apertura .fila {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 9px 0;
            border-bottom: 1px solid #e9e0ed;
        }

        .informacion-apertura .fila:last-child {
            border-bottom: none;
        }

        .informacion-apertura span {
            color: var(--texto-suave);
            font-size: 13px;
        }

        .informacion-apertura strong {
            color: var(--texto);
            font-size: 14px;
            text-align: right;
        }

        .advertencia-caja,
        .aviso-fuera-horario {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            text-align: left;
            border-radius: 10px;
            padding: 13px;
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.45;
        }

        .advertencia-caja {
            background: #fff8e1;
            color: #795548;
            border: 1px solid #ffe082;
        }

        .advertencia-caja i {
            color: #f9a825;
        }

        .aviso-fuera-horario {
            background: #fff3e0;
            color: #6d4c41;
            border: 1px solid #ffcc80;
        }

        .aviso-fuera-horario i {
            color: #ef6c00;
            font-size: 18px;
        }

        .aviso-fuera-horario strong {
            color: #e65100;
        }

        .grupo-dinero {
            text-align: left;
            margin-bottom: 18px;
        }

        .grupo-dinero label {
            display: block;
            color: #555;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .campo-dinero {
            position: relative;
        }

        .campo-dinero span {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--morado);
            font-size: 19px;
            font-weight: bold;
        }

        .campo-dinero input {
            width: 100%;
            padding: 14px 14px 14px 36px;
            border: 2px solid #dddddd;
            border-radius: 10px;
            font-size: 19px;
            outline: none;
            transition: 0.2s;
        }

        .campo-dinero input:focus {
            border-color: var(--morado);
            box-shadow: 0 0 0 3px rgba(106,27,154,0.10);
        }

        .boton-confirmar {
            width: 100%;
            padding: 15px;
            background: var(--morado);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.25s;
        }

        .boton-confirmar:hover {
            background: var(--morado-oscuro);
            transform: translateY(-2px);
        }

        .boton-continuar {
            width: 100%;
            padding: 15px;
            background: #ef6c00;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.25s;
        }

        .boton-continuar:hover {
            background: #d84315;
            transform: translateY(-2px);
        }

        .boton-cancelar {
            width: 100%;
            padding: 13px;
            margin-top: 9px;
            background: #eeeeee;
            color: #555;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .boton-cancelar:hover {
            background: #dddddd;
        }

        .dinero-inicial {
            background: var(--morado-claro);
            border-radius: 12px;
            padding: 17px;
            margin-bottom: 17px;
        }

        .dinero-inicial span {
            display: block;
            color: var(--texto-suave);
            font-size: 13px;
            margin-bottom: 5px;
        }

        .dinero-inicial strong {
            display: block;
            color: var(--morado);
            font-size: 30px;
        }

        .texto-continuar {
            margin-top: 20px;
            color: var(--texto-suave);
            font-size: 13px;
        }

        .barra-tiempo {
            width: 100%;
            height: 5px;
            background: #eeeeee;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 11px;
        }

        #progresoCaja {
            width: 100%;
            height: 100%;
            background: var(--morado);
            animation: disminuirTiempo 5s linear forwards;
        }

        @keyframes disminuirTiempo {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        @media (max-width: 1200px) {
            .contenido-punto {
                grid-template-columns: 1fr;
            }

            .apertura-card {
                min-height: auto;
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

            .datos-punto {
                grid-template-columns: 1fr;
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

            .hora {
                font-size: 38px;
            }
        }

        @media (max-width: 450px) {
            .menu {
                grid-template-columns: 1fr 1fr;
            }

            .contenedor {
                padding: 18px 12px;
            }

            .tarjeta {
                padding: 17px;
            }

            .modal-caja {
                padding: 25px 18px;
            }

            .modal-caja h2 {
                font-size: 23px;
            }

            .hora {
                font-size: 32px;
            }
        }
    </style>
</head>

<body>
<div class="dashboard">

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

        @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'administrador')
            <div class="menu-titulo">Administración</div>

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
        @endif

        <div class="menu-titulo">

    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'administrador')
        Administrador
    @elseif(auth()->user()->rol === 'vendedor')
        Vendedor
    @else
        {{ ucfirst(auth()->user()->rol) }}
    @endif

</div>

<nav class="menu">

   @if(auth()->user()->rol === 'vendedor')

        <a href="{{ route('vendedor.dashboard') }}">
            <i class="fa-solid fa-house"></i>
            Menu Principal
        </a>

    @endif


    @if(auth()->user()->puntoVenta)

        <a
            href="{{ route('empleado.punto_venta') }}"
            class="activo"
        >
            <i class="fa-solid fa-cash-register"></i>
            Punto de venta
        </a>

    @endif


    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'administrador')

    <a href="{{ route('admin.informacion') }}">
        <i class="fa-solid fa-user"></i>
        Mi información
    </a>

@elseif(auth()->user()->rol === 'vendedor')

    <a href="{{ route('vendedor.informacion') }}">
        <i class="fa-solid fa-user"></i>
        Mi información
    </a>

@endif

</nav>
    </aside>

    <main class="contenido">
        <header class="topbar">
            <div class="saludo">
                <h1>Punto de Venta</h1>
                <p>Apertura y control de caja</p>
            </div>

            <div class="perfil">
                <button type="button" class="avatar" id="botonPerfil">
                    @if(auth()->user()->foto_perfil)
                        <img
                            src="{{ asset('storage/' . auth()->user()->foto_perfil) }}"
                            alt="Foto de perfil"
                        >
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </button>

                <div class="menu-perfil" id="menuPerfil">
                    <div class="nombre-usuario">
                        {{ auth()->user()->name }}

                        <small>
                            @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'administrador')
                                Administrador
                            @elseif(auth()->user()->rol === 'vendedor')
                                Vendedor
                            @elseif(auth()->user()->rol === 'cliente')
                                Cliente
                            @else
                                {{ ucfirst(auth()->user()->rol) }}
                            @endif
                        </small>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="boton-logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <section class="contenedor">
            <div class="titulo-seccion">
                <h2>Apertura de caja</h2>
                <p>
                    Verifica los datos de tu punto de venta antes de comenzar operaciones.
                </p>
            </div>

            <div class="cabecera-punto">
                <div class="icono-punto">
                    <i class="fa-solid fa-cash-register"></i>
                </div>

                <div>
                    <h3>{{ $puntoVenta->nombre_caja }}</h3>
                    <span>Punto de venta asignado</span>
                </div>
            </div>

            <div class="contenido-punto">
                <div class="tarjeta">
                    <div class="tarjeta-titulo">
                        <h3>Información del punto</h3>

                        @if(session('caja_abierta') && session('punto_venta_id') == $puntoVenta->id)
                            <span class="estado">
                                <i class="fa-solid fa-circle"></i>
                                Caja abierta
                            </span>
                        @else
                            <span class="estado">
                                <i class="fa-solid fa-circle"></i>
                                Disponible
                            </span>
                        @endif
                    </div>

                    <div class="datos-punto">
                        <div class="dato">
                            <span class="etiqueta">
                                <i class="fa-solid fa-store"></i>
                                Sucursal
                            </span>

                            <span class="valor">
                                {{ $puntoVenta->sucursal }}
                            </span>
                        </div>

                        <div class="dato">
                            <span class="etiqueta">
                                <i class="fa-solid fa-hashtag"></i>
                                Número de caja
                            </span>

                            <span class="valor">
                                {{ $puntoVenta->numero_caja }}
                            </span>
                        </div>

                        <div class="dato">
                            <span class="etiqueta">
                                <i class="fa-solid fa-cash-register"></i>
                                Nombre de caja
                            </span>

                            <span class="valor">
                                {{ $puntoVenta->nombre_caja }}
                            </span>
                        </div>
                    </div>

                    <div class="reloj-card">
                        <div class="fecha" id="fecha">
                            Cargando fecha...
                        </div>

                        <div class="hora" id="hora">
                            00:00:00
                        </div>
                    </div>
                </div>

                <div class="tarjeta apertura-card">
                    <div class="icono-apertura">
                        <i class="fa-solid fa-lock-open"></i>
                    </div>

                    <h3>Abrir caja</h3>

                    <p>
                        Registra el dinero inicial de cambio
                        para comenzar las operaciones de esta caja.
                    </p>

                    @if(!session('caja_abierta') || session('punto_venta_id') != $puntoVenta->id)
                        <button
                            type="button"
                            class="boton-iniciar"
                            onclick="mostrarFormularioCaja()"
                        >
                            <i class="fa-solid fa-lock-open"></i>
                            Abrir caja
                        </button>
                    @else
                        <a
                            href="{{ route('punto_venta.caja', $puntoVenta->id) }}"
                            class="boton-iniciar"
                            style="display:flex;align-items:center;justify-content:center;text-decoration:none;"
                        >
                            <i class="fa-solid fa-cash-register"></i>
                            Entrar a caja
                        </a>
                    @endif

                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'administrador')
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="boton-regresar"
                        >
                            <i class="fa-solid fa-arrow-left"></i>
                            Regresar al dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('vendedor.dashboard') }}"
                            class="boton-regresar"
                        >
                            <i class="fa-solid fa-arrow-left"></i>
                            Regresar
                        </a>
                    @endif
                </div>
            </div>
        </section>
    </main>
</div>

<div class="overlay-caja" id="modalApertura" style="display:none;">
    <div class="modal-caja">
        <div class="icono-informacion">
            <i class="fa-solid fa-cash-register"></i>
        </div>

        <h2>Apertura de caja</h2>

        <p class="mensaje-caja">
            Antes de comenzar las operaciones,
            registra el dinero inicial de la caja.
        </p>

        <div class="informacion-apertura">
            <div class="fila">
                <span>Sucursal</span>
                <strong>{{ $puntoVenta->sucursal }}</strong>
            </div>

            <div class="fila">
                <span>Caja</span>
                <strong>{{ $puntoVenta->nombre_caja }}</strong>
            </div>

            <div class="fila">
                <span>Fecha de apertura</span>
                <strong id="fechaApertura">—</strong>
            </div>

            <div class="fila">
                <span>Hora de apertura</span>
                <strong id="horaApertura">—</strong>
            </div>
        </div>

        <div class="advertencia-caja">
            <i class="fa-solid fa-triangle-exclamation"></i>

            <span>
                Verifica cuidadosamente el dinero de cambio
                antes de abrir la caja. Esta cantidad será
                registrada como dinero inicial.
            </span>
        </div>

        <form
            action="{{ route('punto_venta.abrir', $puntoVenta->id) }}"
            method="POST"
        >
            @csrf

            <div class="grupo-dinero">
                <label for="dinero_inicial">
                    Dinero inicial / Cambio
                </label>

                <div class="campo-dinero">
                    <span>$</span>

                    <input
                        type="number"
                        name="dinero_inicial"
                        id="dinero_inicial"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        required
                        autofocus
                    >
                </div>
            </div>

            <button type="submit" class="boton-confirmar">
                <i class="fa-solid fa-check"></i>
                Confirmar apertura
            </button>

            <button
                type="button"
                class="boton-cancelar"
                onclick="cerrarFormularioCaja()"
            >
                Cancelar
            </button>
        </form>
    </div>
</div>

<div class="overlay-caja" id="modalFueraHorario" style="display:none;">
    <div class="modal-caja">
        <div class="icono-advertencia">
            <i class="fa-solid fa-clock"></i>
        </div>

        <h2>Apertura fuera de horario</h2>

        <p class="mensaje-caja">
            Actualmente estás intentando abrir la caja
            fuera del horario normal de trabajo.
        </p>

        <div class="informacion-apertura">
            <div class="fila">
                <span>Horario de trabajo</span>
                <strong>08:00 - 20:00</strong>
            </div>

            <div class="fila">
                <span>Hora actual</span>
                <strong id="horaFueraHorario">—</strong>
            </div>
        </div>

        <div class="aviso-fuera-horario">
            <i class="fa-solid fa-circle-exclamation"></i>

            <span>
                <strong>Importante:</strong>
                no se solicitará dinero inicial.

                <br><br>

                Las ventas realizadas fuera del horario
                de trabajo se considerarán para el
                <strong>día siguiente</strong>.
            </span>
        </div>

        <form
            action="{{ route('punto_venta.abrir', $puntoVenta->id) }}"
            method="POST"
        >
            @csrf

            <button type="submit" class="boton-continuar">
                <i class="fa-solid fa-arrow-right"></i>
                Continuar sin dinero inicial
            </button>

            <button
                type="button"
                class="boton-cancelar"
                onclick="cerrarFueraHorario()"
            >
                Cancelar
            </button>
        </form>
    </div>
</div>

@if(session('error'))
    <div class="overlay-caja" id="modalError">
        <div class="modal-caja">
            <div
                class="icono-informacion"
                style="background:#ffebee;color:#c62828;"
            >
                <i class="fa-solid fa-xmark"></i>
            </div>

            <h2>No se pudo abrir</h2>

            <p class="mensaje-caja">
                {{ session('error') }}
            </p>

            <button
                type="button"
                class="boton-confirmar"
                onclick="document.getElementById('modalError').style.display='none'"
            >
                Entendido
            </button>
        </div>
    </div>
@endif

@if(session('mostrar_apertura'))
    <div class="overlay-caja" id="overlayCaja">
        <div class="modal-caja">
            <div class="icono-exito">
                <i class="fa-solid fa-check"></i>
            </div>

            <h2>¡Caja abierta!</h2>

            <p class="mensaje-caja">
                La caja está lista para comenzar operaciones.
            </p>

            <div class="dinero-inicial">
                <span>Dinero inicial / Cambio</span>

                <strong>
                    ${{ number_format(session('dinero_inicial', 0), 2) }}
                </strong>
            </div>

            <div class="informacion-apertura">
                <div class="fila">
                    <span>Fecha de apertura</span>
                    <strong>{{ session('fecha_apertura') }}</strong>
                </div>

                <div class="fila">
                    <span>Hora de apertura</span>
                    <strong>{{ session('hora_apertura') }}</strong>
                </div>
            </div>

            @if(session('caja_fuera_horario'))
                <div class="aviso-fuera-horario">
                    <i class="fa-solid fa-clock"></i>

                    <span>
                        La caja fue abierta
                        <strong>fuera del horario normal.</strong>

                        Las ventas realizadas fuera del horario
                        se considerarán para el día siguiente.
                    </span>
                </div>
            @else
                <div class="advertencia-caja">
                    <i class="fa-solid fa-triangle-exclamation"></i>

                    <span>
                        El dinero inicial quedó registrado.
                        Revisa que la cantidad mostrada sea correcta
                        antes de comenzar a realizar operaciones.
                    </span>
                </div>
            @endif

            <div class="texto-continuar">
                Entrando a la caja registradora...
            </div>

            <div class="barra-tiempo">
                <div id="progresoCaja"></div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = "{{ route('punto_venta.caja', $puntoVenta->id) }}";
        }, 5000);
    </script>
@endif

<script>
    const botonPerfil = document.getElementById('botonPerfil');
    const menuPerfil = document.getElementById('menuPerfil');

    botonPerfil.addEventListener('click', function(event) {
        event.stopPropagation();
        menuPerfil.classList.toggle('activo');
    });

    function actualizarFechaHora() {
        const ahora = new Date();

        const opcionesFecha = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        let fecha = ahora.toLocaleDateString('es-MX', opcionesFecha);

        fecha = fecha.charAt(0).toUpperCase() + fecha.slice(1);

        document.getElementById('fecha').textContent = fecha;

        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        const segundos = String(ahora.getSeconds()).padStart(2, '0');

        document.getElementById('hora').textContent =
            `${horas}:${minutos}:${segundos}`;
    }

    actualizarFechaHora();
    setInterval(actualizarFechaHora, 1000);

    function mostrarFormularioCaja() {
        const ahora = new Date();
        const hora = ahora.getHours();

        const dentroHorario = hora >= 8 && hora < 20;

        if (dentroHorario) {
            document.getElementById('modalApertura').style.display = 'flex';

            actualizarDatosApertura();

            setTimeout(function() {
                const input = document.getElementById('dinero_inicial');

                if (input) {
                    input.focus();
                }
            }, 100);
        } else {
            document.getElementById('modalFueraHorario').style.display = 'flex';

            actualizarHoraFueraHorario();
        }
    }

    function cerrarFormularioCaja() {
        document.getElementById('modalApertura').style.display = 'none';
    }

    function cerrarFueraHorario() {
        document.getElementById('modalFueraHorario').style.display = 'none';
    }

    function actualizarDatosApertura() {
        const ahora = new Date();

        const fecha = ahora.toLocaleDateString('es-MX', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });

        const hora = ahora.toLocaleTimeString('es-MX', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        document.getElementById('fechaApertura').textContent = fecha;
        document.getElementById('horaApertura').textContent = hora;
    }

    function actualizarHoraFueraHorario() {
        const ahora = new Date();

        const hora = ahora.toLocaleTimeString('es-MX', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        const elemento = document.getElementById('horaFueraHorario');

        if (elemento) {
            elemento.textContent = hora;
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            cerrarFormularioCaja();
            cerrarFueraHorario();
        }
    });

    document.addEventListener('click', function(event) {
        if (
            !botonPerfil.contains(event.target) &&
            !menuPerfil.contains(event.target)
        ) {
            menuPerfil.classList.remove('activo');
        }
    });
</script>

</body>
</html>