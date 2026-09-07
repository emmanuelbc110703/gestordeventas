<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Administrador - Gestor de Ventas</title>

    <!-- Font Awesome -->
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
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }


        /* =========================
           ENCABEZADO
        ========================= */

        .encabezado {
            position: relative;

            background-color: #6a1b9a;

            color: white;

            padding: 25px;

            text-align: center;
        }


        .logo {
            width: 120px;
            height: 120px;

            object-fit: contain;

            background-color: white;

            border-radius: 15px;

            padding: 10px;

            margin-bottom: 10px;
        }


        .encabezado h1 {
            margin: 5px 0;

            font-size: 30px;
        }


        .encabezado p {
            margin: 5px 0;

            font-size: 16px;
        }


        /* =========================
           PERFIL
        ========================= */

        .perfil {
            position: absolute;

            top: 20px;

            right: 25px;
        }


        /* =========================
           AVATAR
        ========================= */

        .avatar {
            width: 48px;
            height: 48px;

            border: none;

            border-radius: 50%;

            background-color:
                {{ auth()->user()->color_perfil ?? '#6a1b9a' }};

            color: white;

            font-size: 22px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;

            display: flex;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            padding: 0;
        }


        .avatar img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;
        }


        .avatar:hover {
            transform: scale(1.08);
        }


        /* =========================
           MENÚ PERFIL
        ========================= */

        .menu-perfil {
            display: none;

            position: absolute;

            top: 58px;

            right: 0;

            width: 190px;

            background-color: white;

            border-radius: 10px;

            overflow: hidden;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.25);

            z-index: 100;
        }


        .menu-perfil.activo {
            display: block;
        }


        .nombre-usuario {
            padding: 14px 15px;

            color: #333;

            font-weight: bold;

            border-bottom: 1px solid #eee;

            text-align: left;
        }


        /* =========================
           CERRAR SESIÓN
        ========================= */

        .logout-form {
            margin: 0;
        }


        .boton-logout {
            width: 100%;

            padding: 14px 15px;

            background-color: white;

            color: #6a1b9a;

            border: none;

            text-align: left;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }


        .boton-logout i {
            margin-right: 8px;
        }


        .boton-logout:hover {
            background-color: #6a1b9a;

            color: white;
        }


        /* =========================
           CONTENEDOR
        ========================= */

        .contenedor {
            width: 90%;

            max-width: 1000px;

            margin: 40px auto;
        }


        .contenedor h2 {
            text-align: center;

            color: #333;

            margin-bottom: 30px;
        }


        /* =========================
           BOTONES
        ========================= */

        .botones {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 20px;
        }


        .boton {
            background-color: white;

            color: #333;

            border: none;

            border-radius: 12px;

            padding: 30px 20px;

            font-size: 18px;

            font-weight: bold;

            cursor: pointer;

            text-decoration: none;

            text-align: center;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, 0.15);

            transition: 0.3s;
        }


        /* =========================
           ICONOS
        ========================= */

        .boton i {
            display: block;

            font-size: 40px;

            color: #6a1b9a;

            margin-bottom: 15px;

            transition: 0.3s;
        }


        /* =========================
           HOVER
        ========================= */

        .boton:hover {
            background-color: #6a1b9a;

            color: white;

            transform: translateY(-5px);

            box-shadow:
                0 6px 15px rgba(0, 0, 0, 0.2);
        }


        .boton:hover i {
            color: white;
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 700px) {

            .botones {
                grid-template-columns: 1fr;
            }


            .encabezado h1 {
                font-size: 24px;
            }


            .perfil {
                top: 15px;

                right: 15px;
            }


            .avatar {
                width: 42px;

                height: 42px;

                font-size: 19px;
            }


            .menu-perfil {
                top: 52px;

                width: 180px;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         ENCABEZADO
    ========================= -->

    <div class="encabezado">


        <!-- =========================
             PERFIL
        ========================= -->

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


            <!-- MENÚ DESPLEGABLE -->

            <div
                class="menu-perfil"
                id="menuPerfil"
            >

                <div class="nombre-usuario">

                    {{ auth()->user()->name }}

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


        <!-- =========================
             LOGO
        ========================= -->

        <img
            src="{{ asset('images/logo-los-amates.png') }}"
            alt="Logo Los Amates"
            class="logo"
        >


        <h1>
            Bienvenido Administrador
        </h1>


        <p>
            Gestor de Ventas "Los Amates"
        </p>

    </div>



    <!-- =========================
         CONTENIDO
    ========================= -->

    <div class="contenedor">


        <h2>
            Panel de Administración
        </h2>


        <div class="botones">


            <!-- INVENTARIO -->

            <a
                href="{{ route('admin.inventario') }}"
                class="boton"
            >

                <i class="fa-solid fa-boxes-stacked"></i>

                Inventario

            </a>


            <!-- PUNTOS DE VENTA -->

            <a href="{{ route('admin.puntos_venta') }}" class="boton">
    <i class="fa-solid fa-store"></i>
    Puntos de venta
</a>


            <!-- EMPLEADOS -->

            <a
                href="{{ route('admin.empleados') }}"
                class="boton"
            >

                <i class="fa-solid fa-users"></i>

                Empleados

            </a>


            <!-- CLIENTES -->

            <a
                href="{{ route('admin.clientes') }}"
                class="boton"
            >

                <i class="fa-solid fa-users"></i>

                Clientes

            </a>


<!-- COTIZACIONES -->

<a
    href="{{ route('admin.cotizaciones') }}"
    class="boton"
>

    <i class="fa-solid fa-file-invoice-dollar"></i>

    Cotizaciones

</a>


            <!-- GASTOS COMERCIALES -->

            <a
                href="#"
                class="boton"
            >

                <i class="fa-solid fa-money-bill-wave"></i>

                Gastos Comerciales

            </a>


            <!-- =========================
                 MI INFORMACIÓN
            ========================= -->

            <a
                href="{{ route('admin.informacion') }}"
                class="boton"
            >

                <i class="fa-solid fa-user"></i>

                Mi información

            </a>

            @if(auth()->user()->puntoVenta)
    <a href="{{ route('empleado.punto_venta') }}" class="boton">
        <i class="fa-solid fa-cash-register"></i>
        Punto de venta
    </a>
@endif


        </div>

    </div>



    <!-- =========================
         JAVASCRIPT
    ========================= -->

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