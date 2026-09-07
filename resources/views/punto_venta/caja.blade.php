<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Caja registradora</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f4f2f7;
            color: #333;
        }

        /* ==========================================================
           ENCABEZADO
        ========================================================== */

        .encabezado {
            height: 75px;
            background: #6a1b9a;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 3px 12px rgba(0,0,0,.15);
        }

        .titulo-caja {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .titulo-caja i {
            font-size: 28px;
        }

        .titulo-caja h1 {
            margin: 0;
            font-size: 23px;
        }

        /* ==========================================================
           PERFIL
        ========================================================== */

        .perfil-caja {
            position: relative;
        }

        .perfil-boton {
            border: none;
            background: transparent;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px;
        }

        .perfil-foto,
        .perfil-icono {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .perfil-foto {
            object-fit: cover;
        }

        .perfil-icono {
            background: #8e44ad;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .perfil-nombre {
            font-weight: bold;
            font-size: 14px;
        }

        .perfil-flecha {
            font-size: 12px;
        }

        .menu-perfil {
            display: none;
            position: absolute;
            right: 0;
            top: 55px;
            width: 210px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,.18);
            overflow: hidden;
            z-index: 5000;
        }

        .menu-perfil.mostrar {
            display: block;
        }

        .menu-perfil-info {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .menu-perfil-info strong {
            display: block;
            color: #333;
            margin-bottom: 4px;
        }

        .menu-perfil-info span {
            color: #777;
            font-size: 13px;
        }

        .menu-perfil button {
            width: 100%;
            border: none;
            background: white;
            text-align: left;
            padding: 14px 16px;
            color: #c62828;
            cursor: pointer;
            font-size: 14px;
        }

        .menu-perfil button:hover {
            background: #fff4f4;
        }

        /* ==========================================================
           MENSAJE CLIENTE REGISTRADO
        ========================================================== */

        .mensaje-cliente-registrado {
            position: fixed;
            top: 95px;
            right: 25px;
            z-index: 15000;
            min-width: 320px;
            max-width: 430px;
            background: #e8f5e9;
            border-left: 5px solid #2e7d32;
            color: #2e7d32;
            padding: 16px 18px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,.15);
            display: none;
            align-items: center;
            gap: 12px;
            animation: aparecerMensajeCliente .25s ease;
        }

        .mensaje-cliente-registrado i {
            font-size: 25px;
            flex-shrink: 0;
        }

        .mensaje-cliente-registrado strong {
            display: block;
            margin-bottom: 4px;
        }

        .mensaje-cliente-registrado span {
            color: #555;
            font-size: 13px;
        }

        @keyframes aparecerMensajeCliente {

            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }

        }

        /* ==========================================================
           CONTENEDOR
        ========================================================== */

        .contenedor {
            width: 100%;
            max-width: 1500px;
            margin: auto;
            padding: 25px;
        }

        .caja-grid {
            display: grid;
            grid-template-columns:
                minmax(0, 1.7fr)
                minmax(350px, .9fr);
            gap: 25px;
        }

        .panel {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 4px 18px rgba(0,0,0,.08);
        }

        .panel-titulo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .panel-titulo i {
            color: #6a1b9a;
            font-size: 22px;
        }

        .panel-titulo h2 {
            margin: 0;
            font-size: 21px;
            color: #333;
        }

        /* ==========================================================
           BUSCADOR SERVICIOS
        ========================================================== */

        .buscador {
            position: relative;
            margin-bottom: 20px;
        }

        .buscador i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .buscador input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
        }

        .buscador input:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 0 3px rgba(106,27,154,.10);
        }

        /* ==========================================================
           SERVICIOS
        ========================================================== */

        .servicios {
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(210px,1fr));
            gap: 15px;
            max-height: 620px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .servicio {
            border: 1px solid #e5e5e5;
            border-radius: 14px;
            padding: 15px;
            background: #fff;
            transition: .2s;
        }

        .servicio:hover {
            border-color: #6a1b9a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106,27,154,.12);
        }

        .servicio-imagen {
            width: 100%;
            height: 145px;
            border-radius: 11px;
            overflow: hidden;
            background: #f2eafa;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .servicio-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .servicio-imagen-vacia {
            color: #6a1b9a;
            font-size: 42px;
        }

        .servicio h3 {
            margin: 0 0 7px;
            font-size: 17px;
        }

        .servicio-precio {
            color: #6a1b9a;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .servicio-stock {
            color: #777;
            font-size: 13px;
            margin-bottom: 13px;
        }

        .boton-agregar {
            width: 100%;
            border: none;
            padding: 11px;
            border-radius: 9px;
            background: #6a1b9a;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .boton-agregar:hover {
            background: #4a126b;
        }

        .sin-servicios {
            grid-column: 1/-1;
            text-align: center;
            color: #777;
            padding: 50px 20px;
        }

        .sin-servicios i {
            font-size: 45px;
            color: #b39ddb;
            margin-bottom: 15px;
        }

        /* ==========================================================
           CLIENTE
        ========================================================== */

        .cliente-panel {
            margin-bottom: 20px;
        }

        .cliente-buscador {
            display: flex;
            gap: 8px;
        }

        .cliente-buscador input {
            flex: 1;
            min-width: 0;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 9px;
            outline: none;
        }

        .boton-nuevo-cliente {
            border: none;
            border-radius: 9px;
            background: #6a1b9a;
            color: white;
            padding: 0 15px;
            cursor: pointer;
            font-weight: bold;
        }

        .clientes-lista {
            margin-top: 8px;
            max-height: 160px;
            overflow-y: auto;
        }

        .cliente-opcion {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .cliente-opcion:hover {
            background: #f5eff9;
        }

        .cliente-opcion strong {
            display: block;
        }

        .cliente-opcion span {
            color: #888;
            font-size: 12px;
        }

        .cliente-seleccionado {
            display: none;
            margin-top: 12px;
            padding: 12px;
            background: #f3e5f5;
            border-radius: 9px;
            color: #6a1b9a;
            font-weight: bold;
        }

        /* ==========================================================
           CARRITO
        ========================================================== */

        .carrito {
            min-height: 150px;
            max-height: 360px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .carrito-vacio {
            text-align: center;
            color: #999;
            padding: 45px 10px;
        }

        .carrito-vacio i {
            display: block;
            font-size: 38px;
            color: #c4a7d8;
            margin-bottom: 10px;
        }

        .producto-carrito {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            padding: 13px 0;
            border-bottom: 1px solid #eee;
        }

        .producto-info {
            display: flex;
            gap: 10px;
            align-items: center;
            min-width: 0;
        }

        .producto-imagen {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            border-radius: 9px;
            overflow: hidden;
            background: #f2eafa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6a1b9a;
        }

        .producto-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .producto-nombre {
            font-weight: bold;
        }

        .producto-precio {
            color: #6a1b9a;
            font-weight: bold;
            margin-top: 4px;
        }

        .producto-controles {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cantidad-btn {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 7px;
            background: #eee;
            cursor: pointer;
            font-weight: bold;
        }

        .cantidad {
            min-width: 25px;
            text-align: center;
            font-weight: bold;
        }

        .eliminar {
            color: #c62828;
            border: none;
            background: transparent;
            cursor: pointer;
            margin-left: 5px;
        }

        /* ==========================================================
           TOTALES
        ========================================================== */

        .totales {
            border-top: 2px solid #eee;
            padding-top: 15px;
        }

        .fila-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .campo-porcentaje {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .campo-porcentaje input {
            width: 95px;
            padding: 9px;
            text-align: right;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
        }

        .simbolo-porcentaje {
            color: #6a1b9a;
            font-weight: bold;
        }

        .fila-total-final {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 17px;
            padding-top: 17px;
            border-top: 1px solid #ddd;
        }

        .fila-total-final span {
            font-size: 19px;
            font-weight: bold;
        }

        #total {
            color: #6a1b9a;
            font-size: 29px;
        }

        .boton-cobrar {
            width: 100%;
            margin-top: 20px;
            padding: 16px;
            border: none;
            border-radius: 11px;
            background: #6a1b9a;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }

        .boton-cobrar:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .cerrar-punto {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

        /* ==========================================================
           MODALES GENERALES
        ========================================================== */

        .modal-cliente,
        .modal-cerrar-caja,
        .modal-cobro,
        .modal-venta-exitosa {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.55);
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-contenido,
        .modal-cobro-contenido {
            width: 100%;
            max-width: 520px;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,.28);
        }

        .modal-encabezado,
        .cobro-encabezado {
            background: #6a1b9a;
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 20px;
            font-weight: bold;
        }

        .modal-cerrar,
        .cobro-cerrar {
            border: none;
            background: transparent;
            color: white;
            font-size: 22px;
            cursor: pointer;
        }

        .modal-contenido form {
            padding: 25px;
        }

        .campo {
            margin-bottom: 18px;
        }

        .campo label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .campo input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 9px;
            outline: none;
        }

        .modal-botones,
        .cerrar-caja-botones,
        .botones-cobro {
            display: flex;
            gap: 10px;
        }

        .boton-cancelar,
        .boton-guardar,
        .boton-no,
        .boton-si,
        .boton-cobro-cancelar,
        .boton-confirmar-pago {
            flex: 1;
            padding: 13px;
            border: none;
            border-radius: 9px;
            font-weight: bold;
            cursor: pointer;
        }

        .boton-cancelar,
        .boton-no,
        .boton-cobro-cancelar {
            background: #eee;
            color: #555;
        }

        .boton-guardar {
            background: #6a1b9a;
            color: white;
        }

        .boton-guardar:disabled {
            opacity: .7;
            cursor: not-allowed;
        }

        .boton-si {
            background: #c62828;
            color: white;
        }

        /* ==========================================================
           CERRAR CAJA
        ========================================================== */

        .cerrar-caja-contenido {
            width: 100%;
            max-width: 470px;
            background: white;
            border-radius: 18px;
            padding: 28px;
            text-align: center;
        }

        .cerrar-caja-icono {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: #f3e5f5;
            color: #6a1b9a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
        }

        /* ==========================================================
           COBRO
        ========================================================== */

        .cobro-cuerpo {
            padding: 25px;
        }

        .total-cobro {
            text-align: center;
            background: #f3e5f5;
            border-radius: 13px;
            padding: 18px;
            margin-bottom: 23px;
        }

        .total-cobro small {
            display: block;
            color: #777;
            margin-bottom: 5px;
        }

        .total-cobro strong {
            color: #6a1b9a;
            font-size: 34px;
        }

        .titulo-metodo {
            font-weight: bold;
            margin-bottom: 12px;
        }

        .metodos-pago {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .metodo-pago {
            border: 2px solid #e5e5e5;
            background: white;
            border-radius: 12px;
            padding: 17px 8px;
            cursor: pointer;
            text-align: center;
            color: #555;
        }

        .metodo-pago i {
            display: block;
            font-size: 26px;
            margin-bottom: 8px;
        }

        .metodo-pago.seleccionado {
            border-color: #6a1b9a;
            background: #f3e5f5;
            color: #6a1b9a;
        }

        .datos-efectivo {
            display: none;
            background: #f8f8f8;
            border-radius: 12px;
            padding: 17px;
            margin-bottom: 20px;
        }

        .datos-efectivo.mostrar {
            display: block;
        }

        .campo-efectivo label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .campo-efectivo input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 9px;
            font-size: 18px;
        }

        .cambio {
            display: flex;
            justify-content: space-between;
            margin-top: 13px;
            padding-top: 13px;
            border-top: 1px solid #ddd;
        }

        #cambioValor {
            color: #2e7d32;
            font-size: 19px;
            font-weight: bold;
        }

        .mensaje-pago {
            display: none;
            padding: 11px 13px;
            border-radius: 8px;
            background: #ffebee;
            color: #c62828;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .mensaje-pago.mostrar {
            display: block;
        }

        .boton-confirmar-pago {
            background: #2e7d32;
            color: white;
        }

        .boton-confirmar-pago:disabled {
            background: #ccc;
        }

        /* ==========================================================
           MODAL VENTA EXITOSA
        ========================================================== */

        .modal-venta-exitosa {
            z-index: 12000;
        }

        .venta-exitosa-contenido {
            width: 100%;
            max-width: 430px;
            background: white;
            border-radius: 20px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,.30);
            animation: aparecerVenta .20s ease;
        }

        @keyframes aparecerVenta {

            from {
                opacity: 0;
                transform: scale(.92);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }

        }

        .venta-exitosa-icono {
            width: 75px;
            height: 75px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: #e8f5e9;
            color: #2e7d32;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }

        .venta-exitosa-contenido h2 {
            margin: 0 0 8px;
            color: #333;
            font-size: 25px;
        }

        .venta-exitosa-contenido p {
            margin: 0 0 22px;
            color: #777;
        }

        .folio-venta {
            background: #f3e5f5;
            border-radius: 13px;
            padding: 18px;
            margin-bottom: 24px;
        }

        .folio-venta span {
            display: block;
            color: #777;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .folio-venta strong {
            display: block;
            color: #6a1b9a;
            font-size: 30px;
        }

        .venta-exitosa-botones {
            display: flex;
            gap: 10px;
        }

        .boton-cerrar-exito,
        .boton-ticket {
            flex: 1;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .boton-cerrar-exito {
            background: #6a1b9a;
            color: white;
        }

        .boton-cerrar-exito:hover {
            background: #4a126b;
        }

        .boton-ticket {
            background: #2e7d32;
            color: white;
        }

        .boton-ticket:hover {
            background: #1b5e20;
        }

        /* ==========================================================
           RESPONSIVE
        ========================================================== */

        @media(max-width:950px) {

            .caja-grid {
                grid-template-columns: 1fr;
            }

            .servicios {
                max-height: none;
            }

        }

        @media(max-width:600px) {

            .encabezado {
                padding: 0 15px;
            }

            .titulo-caja h1 {
                font-size: 18px;
            }

            .perfil-nombre {
                display: none;
            }

            .contenedor {
                padding: 15px;
            }

            .panel {
                padding: 17px;
            }

            .servicios {
                grid-template-columns: 1fr 1fr;
            }

            .cliente-buscador {
                flex-wrap: wrap;
            }

            .cliente-buscador input {
                width: 100%;
                flex-basis: 100%;
            }

            .boton-nuevo-cliente {
                padding: 12px 15px;
            }

            .metodos-pago {
                grid-template-columns: 1fr;
            }

            .venta-exitosa-botones {
                flex-direction: column;
            }

            .mensaje-cliente-registrado {
                top: 85px;
                left: 15px;
                right: 15px;
                min-width: 0;
                max-width: none;
            }

        }

        @media(max-width:420px) {

            .servicios {
                grid-template-columns: 1fr;
            }

            .producto-carrito {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<header class="encabezado">

    <div class="titulo-caja">

        <i class="fa-solid fa-cash-register"></i>

        <h1>Caja registradora</h1>

    </div>

    <div class="perfil-caja">

        <button
            type="button"
            class="perfil-boton"
            onclick="toggleMenuPerfil()"
        >

            @if(auth()->user()->foto_perfil)

                <img
                    src="{{ asset('storage/' . auth()->user()->foto_perfil) }}"
                    class="perfil-foto"
                    alt="Perfil"
                >

            @else

                <div class="perfil-icono">
                    <i class="fa-solid fa-user"></i>
                </div>

            @endif

            <span class="perfil-nombre">
                {{ auth()->user()->name }}
            </span>

            <i class="fa-solid fa-chevron-down perfil-flecha"></i>

        </button>

        <div class="menu-perfil" id="menuPerfil">

            <div class="menu-perfil-info">

                <strong>
                    {{ auth()->user()->name }}
                    {{ auth()->user()->apellido ?? '' }}
                </strong>

                <span>
                    {{ ucfirst(auth()->user()->rol ?? '') }}
                </span>

            </div>

            <button
                type="button"
                onclick="abrirModalCerrarCaja()"
            >

                <i class="fa-solid fa-door-open"></i>

                Cerrar caja

            </button>

        </div>

    </div>

</header>


<!-- ==========================================================
     MENSAJE CLIENTE REGISTRADO
========================================================== -->

<div
    class="mensaje-cliente-registrado"
    id="mensajeClienteRegistrado"
>

    <i class="fa-solid fa-circle-check"></i>

    <div>

        <strong>
            ¡Cliente registrado correctamente!
        </strong>

        <span id="textoClienteRegistrado"></span>

    </div>

</div>


<main class="contenedor">

    <div class="caja-grid">

        <!-- ======================================================
             SERVICIOS
        ======================================================= -->

        <section class="panel">

            <div class="panel-titulo">

                <i class="fa-solid fa-list"></i>

                <h2>Servicios</h2>

            </div>

            <div class="buscador">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    id="buscarServicio"
                    placeholder="Buscar servicio..."
                >

            </div>

            <div
                class="servicios"
                id="listaServicios"
            >

                @forelse($servicios as $servicio)

                    <div
                        class="servicio"
                        data-nombre="{{ strtolower($servicio->nombre) }}"
                    >

                        <div class="servicio-imagen">

                            @if($servicio->foto)

                                <img
                                    src="{{ asset('storage/' . $servicio->foto) }}"
                                    alt="{{ $servicio->nombre }}"
                                >

                            @else

                                <div class="servicio-imagen-vacia">

                                    <i class="fa-solid fa-concierge-bell"></i>

                                </div>

                            @endif

                        </div>

                        <h3>
                            {{ $servicio->nombre }}
                        </h3>

                        <div class="servicio-precio">
                            ${{ number_format($servicio->precio,2) }}
                        </div>

                        <div class="servicio-stock">
                            Disponible: {{ $servicio->cantidad }}
                        </div>

                        <button
                            type="button"
                            class="boton-agregar"
                            onclick="agregarProducto(
                                {{ $servicio->id }},
                                @js($servicio->nombre),
                                {{ $servicio->precio }},
                                @js($servicio->foto),
                                {{ $servicio->cantidad }}
                            )"
                        >

                            <i class="fa-solid fa-plus"></i>

                            Agregar

                        </button>

                    </div>

                @empty

                    <div class="sin-servicios">

                        <i class="fa-solid fa-box-open"></i>

                        <div>
                            No hay servicios registrados.
                        </div>

                    </div>

                @endforelse

            </div>

        </section>


        <!-- ======================================================
             PANEL DERECHO
        ======================================================= -->

        <section class="panel">

            <!-- CLIENTE -->

            <div class="cliente-panel">

                <div class="panel-titulo">

                    <i class="fa-solid fa-user"></i>

                    <h2>Cliente</h2>

                </div>

                <div class="cliente-buscador">

                    <input
                        type="text"
                        id="buscarCliente"
                        placeholder="Buscar cliente..."
                        autocomplete="off"
                    >

                    <button
                        type="button"
                        class="boton-nuevo-cliente"
                        onclick="abrirModalCliente()"
                    >

                        <i class="fa-solid fa-user-plus"></i>

                        Nuevo cliente

                    </button>

                </div>

                <div
                    class="clientes-lista"
                    id="clientesLista"
                ></div>

                <div
                    class="cliente-seleccionado"
                    id="clienteSeleccionado"
                >

                    <i class="fa-solid fa-user-check"></i>

                    <span id="clienteNombre"></span>

                </div>

            </div>


            <!-- VENTA -->

            <div class="panel-titulo">

                <i class="fa-solid fa-cart-shopping"></i>

                <h2>Venta actual</h2>

            </div>

            <div
                class="carrito"
                id="carrito"
            >

                <div class="carrito-vacio">

                    <i class="fa-solid fa-cart-shopping"></i>

                    Agrega servicios a la venta.

                </div>

            </div>


            <!-- TOTALES -->

            <div class="totales">

                <div class="fila-total">

                    <span>Subtotal</span>

                    <strong id="subtotal">
                        $0.00
                    </strong>

                </div>

                <div class="fila-total">

                    <span>Descuento</span>

                    <div class="campo-porcentaje">

                        <input
                            type="number"
                            id="descuento"
                            value="0"
                            min="0"
                            max="100"
                            step="0.01"
                        >

                        <span class="simbolo-porcentaje">
                            %
                        </span>

                    </div>

                </div>

                <div class="fila-total">

                    <span>Impuesto</span>

                    <div class="campo-porcentaje">

                        <input
                            type="number"
                            id="impuesto"
                            value="0"
                            min="0"
                            max="100"
                            step="0.01"
                        >

                        <span class="simbolo-porcentaje">
                            %
                        </span>

                    </div>

                </div>

                <div class="fila-total-final">

                    <span>Total</span>

                    <span id="total">
                        $0.00
                    </span>

                </div>

                <button
                    type="button"
                    class="boton-cobrar"
                    id="botonCobrar"
                    disabled
                    onclick="abrirModalCobro()"
                >

                    <i class="fa-solid fa-money-bill-wave"></i>

                    Cobrar

                </button>

            </div>

        </section>

    </div>

</main>


<!-- ==========================================================
     MODAL CLIENTE
========================================================== -->

<div
    class="modal-cliente"
    id="modalCliente"
>

    <div class="modal-contenido">

        <div class="modal-encabezado">

            <div>

                <i class="fa-solid fa-user-plus"></i>

                Registrar cliente

            </div>

            <button
                type="button"
                onclick="cerrarModalCliente()"
                class="modal-cerrar"
            >

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <form
            method="POST"
            action="{{ route('cliente.registrar.caja') }}"
            id="formRegistrarCliente"
        >

            @csrf

            <div class="campo">

                <label>Nombre</label>

                <input
                    type="text"
                    name="name"
                    required
                    maxlength="255"
                    placeholder="Nombre del cliente"
                >

            </div>

            <div class="campo">

                <label>Apellido</label>

                <input
                    type="text"
                    name="apellido"
                    required
                    maxlength="255"
                    placeholder="Apellido del cliente"
                >

            </div>

            <div class="campo">

                <label>Teléfono</label>

                <input
                    type="text"
                    name="telefono"
                    maxlength="20"
                    placeholder="Número de teléfono"
                >

            </div>

            <div class="modal-botones">

                <button
                    type="button"
                    onclick="cerrarModalCliente()"
                    class="boton-cancelar"
                >

                    Cancelar

                </button>

                <button
                    type="submit"
                    class="boton-guardar"
                >

                    <i class="fa-solid fa-user-plus"></i>

                    Registrar cliente

                </button>

            </div>

        </form>

    </div>

</div>


<!-- ==========================================================
     MODAL CERRAR CAJA
========================================================== -->

<div
    class="modal-cerrar-caja"
    id="modalCerrarCaja"
>

    <div class="cerrar-caja-contenido">

        <div class="cerrar-caja-icono">

            <i class="fa-solid fa-cash-register"></i>

        </div>

        <h2>¿Cerrar la caja?</h2>

        <p>

            Vas a cerrar la caja.

            <br><br>

            Recuerda que
            <strong>
                no puedes volver a poner el dinero inicial
            </strong>.

        </p>

        <div class="cerrar-caja-botones">

            <button
                type="button"
                class="boton-no"
                onclick="cerrarModalCerrarCaja()"
            >

                Cancelar

            </button>

            <button
                type="button"
                class="boton-si"
                onclick="cerrarCaja()"
            >

                Sí, cerrar caja

            </button>

        </div>

    </div>

</div>


<!-- ==========================================================
     MODAL COBRO
========================================================== -->

<div
    class="modal-cobro"
    id="modalCobro"
>

    <div class="modal-cobro-contenido">

        <div class="cobro-encabezado">

            <div>

                <i class="fa-solid fa-cash-register"></i>

                Cobrar venta

            </div>

            <button
                type="button"
                class="cobro-cerrar"
                onclick="cerrarModalCobro()"
            >

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <div class="cobro-cuerpo">

            <div class="total-cobro">

                <small>
                    Total a pagar
                </small>

                <strong id="totalModalCobro">
                    $0.00
                </strong>

            </div>

            <div class="titulo-metodo">
                Selecciona la forma de pago:
            </div>

            <div class="metodos-pago">

                <button
                    type="button"
                    class="metodo-pago"
                    id="metodoEfectivo"
                    onclick="seleccionarMetodoPago('efectivo')"
                >

                    <i class="fa-solid fa-money-bill-wave"></i>

                    <span>Efectivo</span>

                </button>

                <button
                    type="button"
                    class="metodo-pago"
                    id="metodoTarjeta"
                    onclick="seleccionarMetodoPago('tarjeta')"
                >

                    <i class="fa-solid fa-credit-card"></i>

                    <span>Tarjeta</span>

                </button>

                <button
                    type="button"
                    class="metodo-pago"
                    id="metodoTransferencia"
                    onclick="seleccionarMetodoPago('transferencia')"
                >

                    <i class="fa-solid fa-building-columns"></i>

                    <span>Transferencia</span>

                </button>

            </div>

            <div
                class="datos-efectivo"
                id="datosEfectivo"
            >

                <div class="campo-efectivo">

                    <label>
                        Efectivo recibido
                    </label>

                    <input
                        type="number"
                        id="efectivoRecibido"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                    >

                </div>

                <div class="cambio">

                    <span>Cambio:</span>

                    <span id="cambioValor">
                        $0.00
                    </span>

                </div>

            </div>

            <div
                class="mensaje-pago"
                id="mensajePago"
            ></div>

            <div class="botones-cobro">

                <button
                    type="button"
                    class="boton-cobro-cancelar"
                    onclick="cerrarModalCobro()"
                >

                    Cancelar

                </button>

                <button
                    type="button"
                    class="boton-confirmar-pago"
                    id="botonConfirmarPago"
                    onclick="confirmarPago()"
                >

                    <i class="fa-solid fa-check"></i>

                    Confirmar pago

                </button>

            </div>

        </div>

    </div>

</div>


<!-- ==========================================================
     MODAL VENTA REGISTRADA
========================================================== -->

<div
    class="modal-venta-exitosa"
    id="modalVentaExitosa"
>

    <div class="venta-exitosa-contenido">

        <div class="venta-exitosa-icono">

            <i class="fa-solid fa-circle-check"></i>

        </div>

        <h2>
            ¡Venta registrada!
        </h2>

        <p>
            La venta se registró correctamente.
        </p>

        <div class="folio-venta">

            <span>
                Número de folio
            </span>

            <strong id="folioVenta">
                —
            </strong>

        </div>

        <div class="venta-exitosa-botones">

            <button
                type="button"
                class="boton-cerrar-exito"
                onclick="cerrarModalVentaExitosa()"
            >

                <i class="fa-solid fa-check"></i>

                Aceptar

            </button>

            <button
                type="button"
                class="boton-ticket"
                id="botonAbrirTicket"
                onclick="abrirTicket()"
                style="display:none;"
            >

                <i class="fa-solid fa-print"></i>

                Ver ticket

            </button>

        </div>

    </div>

</div>


<!-- ==========================================================
     FORMULARIO CERRAR CAJA
========================================================== -->

<form
    id="formCerrarCaja"
    method="POST"
    action="{{ route('punto_venta.cerrar') }}"
    style="display:none;"
>

    @csrf

</form>


<script>

    /* ==========================================================
       DATOS
    ========================================================== */

    let carrito = [];

    let clienteSeleccionado = null;

    let metodoPagoSeleccionado = null;

    let ticketUrlVenta = null;

    const clientes = @json($clientes ?? []);

    const puntoVentaId =
        @json(session('punto_venta_id'));

    const urlRegistrarVenta =
        @json(route('venta.store'));

    const csrfToken =
        document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');


    /* ==========================================================
       AGREGAR PRODUCTO
    ========================================================== */

    function agregarProducto(
        id,
        nombre,
        precio,
        foto,
        stock
    ) {

        const producto =
            carrito.find(item => item.id === id);

        if (producto) {

            if (producto.cantidad >= stock) {

                alert(
                    'No puedes agregar más unidades de "' +
                    nombre +
                    '". Existencia disponible: ' +
                    stock
                );

                return;
            }

            producto.cantidad++;

        } else {

            if (stock <= 0) {

                alert(
                    'El servicio "' +
                    nombre +
                    '" no tiene existencia disponible.'
                );

                return;
            }

            carrito.push({

                id: id,

                nombre: nombre,

                precio: parseFloat(precio),

                foto: foto,

                cantidad: 1,

                stock: stock

            });

        }

        mostrarCarrito();

        calcularTotal();

    }


    /* ==========================================================
       MOSTRAR CARRITO
    ========================================================== */

    function mostrarCarrito() {

        const contenedor =
            document.getElementById('carrito');

        if (carrito.length === 0) {

            contenedor.innerHTML = `

                <div class="carrito-vacio">

                    <i class="fa-solid fa-cart-shopping"></i>

                    Agrega servicios a la venta.

                </div>

            `;

            return;
        }

        contenedor.innerHTML = '';

        carrito.forEach((producto, indice) => {

            const subtotalProducto =
                producto.precio *
                producto.cantidad;

            let imagen;

            if (producto.foto) {

                imagen = `

                    <img
                        src="/storage/${producto.foto}"
                        alt="${escapeHtml(producto.nombre)}"
                    >

                `;

            } else {

                imagen = `

                    <i class="fa-solid fa-concierge-bell"></i>

                `;

            }

            contenedor.innerHTML += `

                <div class="producto-carrito">

                    <div class="producto-info">

                        <div class="producto-imagen">

                            ${imagen}

                        </div>

                        <div>

                            <div class="producto-nombre">

                                ${escapeHtml(producto.nombre)}

                            </div>

                            <div class="producto-precio">

                                $${subtotalProducto.toFixed(2)}

                            </div>

                        </div>

                    </div>

                    <div class="producto-controles">

                        <button
                            type="button"
                            class="cantidad-btn"
                            onclick="cambiarCantidad(${indice}, -1)"
                        >
                            -
                        </button>

                        <span class="cantidad">
                            ${producto.cantidad}
                        </span>

                        <button
                            type="button"
                            class="cantidad-btn"
                            onclick="cambiarCantidad(${indice}, 1)"
                        >
                            +
                        </button>

                        <button
                            type="button"
                            class="eliminar"
                            onclick="eliminarProducto(${indice})"
                        >

                            <i class="fa-solid fa-trash"></i>

                        </button>

                    </div>

                </div>

            `;

        });

    }


    /* ==========================================================
       ESCAPAR HTML
    ========================================================== */

    function escapeHtml(text) {

        const div =
            document.createElement('div');

        div.textContent = text;

        return div.innerHTML;

    }


    /* ==========================================================
       CAMBIAR CANTIDAD
    ========================================================== */

    function cambiarCantidad(
        indice,
        cambio
    ) {

        const producto =
            carrito[indice];

        if (!producto) {
            return;
        }

        const nuevaCantidad =
            producto.cantidad + cambio;

        if (nuevaCantidad > producto.stock) {

            alert(
                'No hay suficiente existencia. Disponible: ' +
                producto.stock
            );

            return;
        }

        producto.cantidad =
            nuevaCantidad;

        if (producto.cantidad <= 0) {

            carrito.splice(indice, 1);

        }

        mostrarCarrito();

        calcularTotal();

    }


    /* ==========================================================
       ELIMINAR
    ========================================================== */

    function eliminarProducto(indice) {

        carrito.splice(indice, 1);

        mostrarCarrito();

        calcularTotal();

    }


    /* ==========================================================
       TOTALES
    ========================================================== */

    function obtenerTotales() {

        let subtotal = 0;

        carrito.forEach(producto => {

            subtotal +=
                producto.precio *
                producto.cantidad;

        });

        let descuentoPorcentaje =
            parseFloat(
                document.getElementById('descuento').value
            ) || 0;

        let impuestoPorcentaje =
            parseFloat(
                document.getElementById('impuesto').value
            ) || 0;

        descuentoPorcentaje =
            Math.min(
                Math.max(
                    descuentoPorcentaje,
                    0
                ),
                100
            );

        impuestoPorcentaje =
            Math.min(
                Math.max(
                    impuestoPorcentaje,
                    0
                ),
                100
            );

        const descuento =
            subtotal *
            (descuentoPorcentaje / 100);

        const subtotalConDescuento =
            subtotal -
            descuento;

        const impuesto =
            subtotalConDescuento *
            (impuestoPorcentaje / 100);

        const total =
            Math.max(
                0,
                subtotalConDescuento + impuesto
            );

        return {

            subtotal,

            descuentoPorcentaje,

            descuento,

            impuestoPorcentaje,

            impuesto,

            total

        };

    }


    /* ==========================================================
       CALCULAR TOTAL
    ========================================================== */

    function calcularTotal() {

        const totales =
            obtenerTotales();

        document.getElementById(
            'subtotal'
        ).textContent =
            '$' +
            totales.subtotal.toFixed(2);

        document.getElementById(
            'total'
        ).textContent =
            '$' +
            totales.total.toFixed(2);

        document.getElementById(
            'botonCobrar'
        ).disabled =
            carrito.length === 0;

    }


    document
        .getElementById('descuento')
        .addEventListener(
            'input',
            calcularTotal
        );

    document
        .getElementById('impuesto')
        .addEventListener(
            'input',
            calcularTotal
        );


    /* ==========================================================
       BUSCAR SERVICIO
    ========================================================== */

    document
        .getElementById('buscarServicio')
        .addEventListener(
            'input',
            function() {

                const texto =
                    this.value
                        .toLowerCase()
                        .trim();

                document
                    .querySelectorAll('.servicio')
                    .forEach(servicio => {

                        const nombre =
                            servicio.dataset.nombre;

                        servicio.style.display =
                            nombre.includes(texto)
                                ? ''
                                : 'none';

                    });

            }
        );


    /* ==========================================================
       BUSCAR CLIENTES
    ========================================================== */

    document
        .getElementById('buscarCliente')
        .addEventListener(
            'input',
            function() {

                const texto =
                    this.value
                        .toLowerCase()
                        .trim();

                const lista =
                    document.getElementById(
                        'clientesLista'
                    );

                lista.innerHTML = '';

                if (!texto) {
                    return;
                }

                const resultados =
                    clientes.filter(cliente => {

                        const nombre =
                            (
                                (cliente.name || '') +
                                ' ' +
                                (cliente.apellido || '')
                            ).toLowerCase();

                        return nombre.includes(texto);

                    });

                resultados.forEach(cliente => {

                    const nombreCompleto =
                        (
                            (cliente.name || '') +
                            ' ' +
                            (cliente.apellido || '')
                        ).trim();

                    const elemento =
                        document.createElement('div');

                    elemento.className =
                        'cliente-opcion';

                    elemento.innerHTML = `

                        <strong>
                            ${escapeHtml(nombreCompleto)}
                        </strong>

                        <span>
                            Cliente registrado
                        </span>

                    `;

                    elemento.onclick =
                        function() {

                            seleccionarCliente(
                                cliente.id,
                                nombreCompleto
                            );

                        };

                    lista.appendChild(elemento);

                });

            }
        );


    /* ==========================================================
       SELECCIONAR CLIENTE
    ========================================================== */

    function seleccionarCliente(
        id,
        nombre
    ) {

        clienteSeleccionado = {

            id: id,

            nombre: nombre

        };

        document.getElementById(
            'clienteNombre'
        ).textContent =
            nombre;

        document.getElementById(
            'clienteSeleccionado'
        ).style.display =
            'block';

        document.getElementById(
            'clientesLista'
        ).innerHTML = '';

        document.getElementById(
            'buscarCliente'
        ).value =
            nombre;

    }


    /* ==========================================================
       MODAL CLIENTE
    ========================================================== */

    function abrirModalCliente() {

        document.getElementById(
            'modalCliente'
        ).style.display =
            'flex';

    }


    function cerrarModalCliente() {

        document.getElementById(
            'modalCliente'
        ).style.display =
            'none';

    }


    /* ==========================================================
       REGISTRAR CLIENTE CON FETCH
    ========================================================== */

    document
        .getElementById('formRegistrarCliente')
        .addEventListener(
            'submit',
            async function(event) {

                event.preventDefault();

                const formulario =
                    this;

                const boton =
                    formulario.querySelector(
                        '.boton-guardar'
                    );

                const textoOriginal =
                    boton.innerHTML;

                boton.disabled = true;

                boton.innerHTML = `

                    <i class="fa-solid fa-spinner fa-spin"></i>

                    Registrando...

                `;

                try {

                    const respuesta =
                        await fetch(
                            formulario.action,
                            {

                                method: 'POST',

                                credentials: 'same-origin',

                                headers: {

                                    'Accept':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        csrfToken,

                                    'X-Requested-With':
                                        'XMLHttpRequest'

                                },

                                body:
                                    new FormData(
                                        formulario
                                    )

                            }
                        );


                    const resultado =
                        await respuesta.json();


                    if (
                        !respuesta.ok ||
                        !resultado.success
                    ) {

                        throw new Error(
                            resultado.message ||
                            'No se pudo registrar el cliente.'
                        );

                    }


                    /* ==========================================
                       CLIENTE DEVUELTO POR EL CONTROLADOR
                    ========================================== */

                    const cliente =
                        resultado.cliente;


                    if (!cliente || !cliente.id) {

                        throw new Error(
                            'El servidor registró el cliente, pero no devolvió sus datos.'
                        );

                    }


                    /* ==========================================
                       AGREGAR CLIENTE A LA LISTA LOCAL
                    ========================================== */

                    clientes.push(cliente);


                    /* ==========================================
                       NOMBRE COMPLETO
                    ========================================== */

                    const nombreCompleto =
                        (
                            (cliente.name || '') +
                            ' ' +
                            (cliente.apellido || '')
                        ).trim();


                    /* ==========================================
                       SELECCIONAR AUTOMÁTICAMENTE
                    ========================================== */

                    seleccionarCliente(
                        cliente.id,
                        nombreCompleto
                    );


                    /* ==========================================
                       CERRAR MODAL
                    ========================================== */

                    cerrarModalCliente();


                    /* ==========================================
                       LIMPIAR FORMULARIO
                    ========================================== */

                    formulario.reset();


                    /* ==========================================
                       MOSTRAR MENSAJE
                    ========================================== */

                    const mensaje =
                        document.getElementById(
                            'mensajeClienteRegistrado'
                        );

                    const texto =
                        document.getElementById(
                            'textoClienteRegistrado'
                        );

                    texto.textContent =
                        nombreCompleto +
                        ' fue agregado correctamente.';

                    mensaje.style.display =
                        'flex';


                    /* ==========================================
                       OCULTAR MENSAJE
                    ========================================== */

                    setTimeout(
                        function() {

                            mensaje.style.display =
                                'none';

                        },
                        4000
                    );


                } catch (error) {

                    console.error(
                        'Error al registrar cliente:',
                        error
                    );

                    alert(
                        error.message ||
                        'Ocurrió un error al registrar el cliente.'
                    );


                } finally {

                    boton.disabled = false;

                    boton.innerHTML =
                        textoOriginal;

                }

            }
        );


    /* ==========================================================
       MENU PERFIL
    ========================================================== */

    function toggleMenuPerfil() {

        document
            .getElementById('menuPerfil')
            .classList
            .toggle('mostrar');

    }


    document.addEventListener(
        'click',
        function(event) {

            const perfil =
                document.querySelector(
                    '.perfil-caja'
                );

            const menu =
                document.getElementById(
                    'menuPerfil'
                );

            if (
                perfil &&
                !perfil.contains(event.target)
            ) {

                menu.classList.remove(
                    'mostrar'
                );

            }

        }
    );


    /* ==========================================================
       CERRAR CAJA
    ========================================================== */

    function abrirModalCerrarCaja() {

        document
            .getElementById('menuPerfil')
            .classList
            .remove('mostrar');

        document.getElementById(
            'modalCerrarCaja'
        ).style.display =
            'flex';

    }


    function cerrarModalCerrarCaja() {

        document.getElementById(
            'modalCerrarCaja'
        ).style.display =
            'none';

    }


    function cerrarCaja() {

        document
            .getElementById('formCerrarCaja')
            .submit();

    }


    function confirmarSalidaCaja(event) {

        event.preventDefault();

        abrirModalCerrarCaja();

        return false;

    }


    /* ==========================================================
       MODAL COBRO
    ========================================================== */

    function abrirModalCobro() {

        if (carrito.length === 0) {
            return;
        }

        const totales =
            obtenerTotales();

        document.getElementById(
            'totalModalCobro'
        ).textContent =
            '$' +
            totales.total.toFixed(2);

        metodoPagoSeleccionado = null;

        document
            .querySelectorAll('.metodo-pago')
            .forEach(boton => {

                boton.classList.remove(
                    'seleccionado'
                );

            });

        document.getElementById(
            'datosEfectivo'
        ).classList.remove(
            'mostrar'
        );

        document.getElementById(
            'efectivoRecibido'
        ).value = '';

        document.getElementById(
            'cambioValor'
        ).textContent =
            '$0.00';

        ocultarMensajePago();

        document.getElementById(
            'modalCobro'
        ).style.display =
            'flex';

    }


    function cerrarModalCobro() {

        document.getElementById(
            'modalCobro'
        ).style.display =
            'none';

    }


    /* ==========================================================
       METODO DE PAGO
    ========================================================== */

    function seleccionarMetodoPago(
        metodo
    ) {

        metodoPagoSeleccionado =
            metodo;

        document
            .querySelectorAll('.metodo-pago')
            .forEach(boton => {

                boton.classList.remove(
                    'seleccionado'
                );

            });

        const boton =
            document.getElementById(
                'metodo' +
                metodo.charAt(0).toUpperCase() +
                metodo.slice(1)
            );

        if (boton) {

            boton.classList.add(
                'seleccionado'
            );

        }

        if (metodo === 'efectivo') {

            document.getElementById(
                'datosEfectivo'
            ).classList.add(
                'mostrar'
            );

            document.getElementById(
                'efectivoRecibido'
            ).focus();

            calcularCambio();

        } else {

            document.getElementById(
                'datosEfectivo'
            ).classList.remove(
                'mostrar'
            );

            ocultarMensajePago();

        }

    }


    /* ==========================================================
       CAMBIO
    ========================================================== */

    function calcularCambio() {

        const totales =
            obtenerTotales();

        const recibido =
            parseFloat(
                document.getElementById(
                    'efectivoRecibido'
                ).value
            ) || 0;

        const cambio =
            recibido -
            totales.total;

        document.getElementById(
            'cambioValor'
        ).textContent =
            '$' +
            Math.max(
                0,
                cambio
            ).toFixed(2);

        if (
            recibido > 0 &&
            recibido < totales.total
        ) {

            mostrarMensajePago(
                'El efectivo recibido es menor al total.'
            );

        } else {

            ocultarMensajePago();

        }

    }


    document
        .getElementById('efectivoRecibido')
        .addEventListener(
            'input',
            calcularCambio
        );


    /* ==========================================================
       MENSAJES DE PAGO
    ========================================================== */

    function mostrarMensajePago(
        mensaje
    ) {

        const elemento =
            document.getElementById(
                'mensajePago'
            );

        elemento.textContent =
            mensaje;

        elemento.classList.add(
            'mostrar'
        );

    }


    function ocultarMensajePago() {

        document
            .getElementById('mensajePago')
            .classList
            .remove('mostrar');

    }


    /* ==========================================================
       MODAL VENTA EXITOSA
    ========================================================== */

    function mostrarModalVentaExitosa(
        folio,
        ticketUrl = null
    ) {

        ticketUrlVenta =
            ticketUrl;

        document.getElementById(
            'folioVenta'
        ).textContent =
            folio || '—';

        const botonTicket =
            document.getElementById(
                'botonAbrirTicket'
            );

        if (ticketUrlVenta) {

            botonTicket.style.display =
                'block';

        } else {

            botonTicket.style.display =
                'none';

        }

        document.getElementById(
            'modalVentaExitosa'
        ).style.display =
            'flex';

    }


    function cerrarModalVentaExitosa() {

        document.getElementById(
            'modalVentaExitosa'
        ).style.display =
            'none';

        ticketUrlVenta = null;

    }


    function abrirTicket() {

        if (!ticketUrlVenta) {
            return;
        }

        window.open(
            ticketUrlVenta,
            '_blank'
        );

    }


    /* ==========================================================
       CONFIRMAR PAGO
    ========================================================== */

    async function confirmarPago() {

        if (!metodoPagoSeleccionado) {

            mostrarMensajePago(
                'Selecciona una forma de pago para continuar.'
            );

            return;

        }

        if (!puntoVentaId) {

            mostrarMensajePago(
                'No se encontró el punto de venta actual en la sesión.'
            );

            return;

        }

        if (carrito.length === 0) {

            mostrarMensajePago(
                'El carrito está vacío.'
            );

            return;

        }

        const totales =
            obtenerTotales();

        let efectivoRecibido = null;

        let cambio = null;

        if (
            metodoPagoSeleccionado ===
            'efectivo'
        ) {

            efectivoRecibido =
                parseFloat(
                    document.getElementById(
                        'efectivoRecibido'
                    ).value
                ) || 0;

            if (
                efectivoRecibido <
                totales.total
            ) {

                mostrarMensajePago(
                    'El efectivo recibido no alcanza para cubrir el total.'
                );

                return;

            }

            cambio =
                efectivoRecibido -
                totales.total;

        }


        /* ======================================================
           DATOS DE LA VENTA
        ====================================================== */

        const datosVenta = {

            punto_venta_id:
                parseInt(puntoVentaId),

            cliente_id:
                clienteSeleccionado
                    ? clienteSeleccionado.id
                    : null,

            subtotal:
                Number(
                    totales.subtotal.toFixed(2)
                ),

            descuento_porcentaje:
                Number(
                    totales.descuentoPorcentaje.toFixed(2)
                ),

            descuento:
                Number(
                    totales.descuento.toFixed(2)
                ),

            impuesto_porcentaje:
                Number(
                    totales.impuestoPorcentaje.toFixed(2)
                ),

            impuesto:
                Number(
                    totales.impuesto.toFixed(2)
                ),

            total:
                Number(
                    totales.total.toFixed(2)
                ),

            forma_pago:
                metodoPagoSeleccionado,

            metodo_pago:
                metodoPagoSeleccionado,

            efectivo_recibido:
                efectivoRecibido !== null
                    ? Number(
                        efectivoRecibido.toFixed(2)
                    )
                    : null,

            cambio:
                cambio !== null
                    ? Number(
                        cambio.toFixed(2)
                    )
                    : null,

            productos:
                carrito.map(producto => ({

                    id:
                        producto.id,

                    cantidad:
                        producto.cantidad,

                    precio:
                        Number(
                            producto.precio.toFixed(2)
                        )

                }))

        };


        /* ======================================================
           BOTÓN
        ====================================================== */

        const boton =
            document.getElementById(
                'botonConfirmarPago'
            );

        boton.disabled = true;

        boton.innerHTML = `

            <i class="fa-solid fa-spinner fa-spin"></i>

            Registrando...

        `;

        ocultarMensajePago();


        try {

            const respuesta =
                await fetch(
                    urlRegistrarVenta,
                    {

                        method: 'POST',

                        credentials: 'same-origin',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrfToken,

                            'X-Requested-With':
                                'XMLHttpRequest'

                        },

                        body:
                            JSON.stringify(
                                datosVenta
                            )

                    }
                );


            const resultado =
                await respuesta.json();


            if (
                !respuesta.ok ||
                !resultado.success
            ) {

                throw new Error(
                    resultado.message ||
                    'No se pudo registrar la venta.'
                );

            }


            /* ==================================================
               LIMPIAR VENTA
            ================================================== */

            carrito = [];

            clienteSeleccionado = null;

            document.getElementById(
                'clienteSeleccionado'
            ).style.display =
                'none';

            document.getElementById(
                'buscarCliente'
            ).value = '';

            document.getElementById(
                'descuento'
            ).value =
                '0';

            document.getElementById(
                'impuesto'
            ).value =
                '0';

            mostrarCarrito();

            calcularTotal();

            cerrarModalCobro();


            /* ==================================================
               MOSTRAR VENTA EXITOSA
            ================================================== */

            mostrarModalVentaExitosa(
                resultado.folio,
                resultado.ticket_url || null
            );


        } catch (error) {

            console.error(
                'Error al registrar venta:',
                error
            );

            mostrarMensajePago(
                error.message ||
                'Ocurrió un error al registrar la venta.'
            );


        } finally {

            boton.disabled = false;

            boton.innerHTML = `

                <i class="fa-solid fa-check"></i>

                Confirmar pago

            `;

        }

    }


    /* ==========================================================
       CERRAR MODALES AL HACER CLICK AFUERA
    ========================================================== */

    document
        .getElementById('modalCliente')
        .addEventListener(
            'click',
            function(event) {

                if (event.target === this) {

                    cerrarModalCliente();

                }

            }
        );


    document
        .getElementById('modalCerrarCaja')
        .addEventListener(
            'click',
            function(event) {

                if (event.target === this) {

                    cerrarModalCerrarCaja();

                }

            }
        );


    document
        .getElementById('modalCobro')
        .addEventListener(
            'click',
            function(event) {

                if (event.target === this) {

                    cerrarModalCobro();

                }

            }
        );


    document
        .getElementById('modalVentaExitosa')
        .addEventListener(
            'click',
            function(event) {

                if (event.target === this) {

                    cerrarModalVentaExitosa();

                }

            }
        );


    /* ==========================================================
       INICIALIZAR
    ========================================================== */

    mostrarCarrito();

    calcularTotal();

</script>

</body>

</html>