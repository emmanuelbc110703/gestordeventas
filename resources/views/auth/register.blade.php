<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro - Orquídeas y más Los Amates</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 100px 20px 30px;
        }

        /* =========================
           BARRA SUPERIOR
        ========================= */
        nav {
            width: 100%;
            padding: 15px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.96);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .marca {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6a1b9a;
            font-size: 20px;
            font-weight: bold;
        }

        .marca i {
            font-size: 25px;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .menu a {
            color: #444;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .menu a:hover {
            color: #6a1b9a;
        }

        /* =========================
           CONTENEDOR REGISTRO
        ========================= */
        .contenedor {
            width: 90%;
            max-width: 500px;
            background-color: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .logo {
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        h1 {
            color: #6a1b9a;
            margin: 5px 0;
        }

        .subtitulo {
            color: #666;
            margin-bottom: 25px;
        }

        .fila {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .campo {
            position: relative;
            margin-bottom: 18px;
            text-align: left;
        }

        .campo i {
            position: absolute;
            left: 15px;
            top: 14px;
            color: #6a1b9a;
        }

        .campo input {
            width: 100%;
            padding: 13px 15px 13px 45px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        .campo input:focus {
            border-color: #6a1b9a;
        }

        .terminos {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 5px 0 20px;
            text-align: left;
            font-size: 14px;
            color: #555;
        }

        .terminos input {
            accent-color: #6a1b9a;
        }

        .terminos a {
            color: #6a1b9a;
            text-decoration: none;
            font-weight: bold;
        }

        .terminos a:hover {
            text-decoration: underline;
        }

        .boton-registro {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background-color: #6a1b9a;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .boton-registro:hover {
            background-color: #4a126d;
        }

        .login {
            margin-top: 22px;
            color: #666;
        }

        .login a {
            color: #6a1b9a;
            font-weight: bold;
            text-decoration: none;
        }

        .login a:hover {
            text-decoration: underline;
        }

        /* =========================
           RESPONSIVO - TABLET Y CELULAR
        ========================= */
        @media (max-width: 750px) {

            nav {
                padding: 12px 5%;
                flex-direction: column;
                gap: 12px;
            }

            .marca {
                font-size: 18px;
            }

            .menu {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px 15px;
            }

            .menu a {
                font-size: 14px;
            }

            body {
                padding-top: 150px;
            }
        }

        @media (max-width: 600px) {

            .fila {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .contenedor {
                width: 100%;
                padding: 25px 20px;
            }
        }

        @media (max-width: 500px) {

            nav {
                gap: 8px;
            }

            .marca {
                font-size: 16px;
            }

            .marca i {
                font-size: 20px;
            }

            .menu {
                gap: 7px 10px;
            }

            .menu a {
                font-size: 13px;
            }

            body {
                padding-top: 145px;
            }
        }
    </style>
</head>

<body>

    <!-- BARRA DE NAVEGACIÓN -->
    <nav>

        <div class="marca">
            <i class="fa-solid fa-seedling"></i>
            Orquídeas y más
        </div>

        <div class="menu">

            <a href="{{ route('inicio') }}">
                <i class="fa-solid fa-house"></i>
                Inicio
            </a>

            <a href="{{ route('inicio') }}#nosotros">
                <i class="fa-solid fa-circle-info"></i>
                Nosotros
            </a>

            <a href="{{ route('inicio') }}#productos">
                <i class="fa-solid fa-leaf"></i>
                Productos
            </a>

        </div>

    </nav>


    <!-- REGISTRO -->
    <form action="{{ route('register.store') }}" method="POST" class="contenedor">

        @csrf

        <img
            src="{{ asset('images/logo-los-amates.png') }}"
            alt="Logo Los Amates"
            class="logo"
        >

        <h1>Crear cuenta</h1>

        <p class="subtitulo">
            Orquídeas y más "Los Amates"
        </p>


        <!-- NOMBRE Y APELLIDOS -->
        <div class="fila">

            <div class="campo">

                <i class="fa-solid fa-user"></i>

                <input
                    type="text"
                    name="name"
                    placeholder="Nombre"
                    required
                >

            </div>

            <div class="campo">

                <i class="fa-solid fa-user"></i>

                <input
                    type="text"
                    name="apellido"
                    placeholder="Apellidos"
                    required
                >

            </div>

        </div>


        <!-- CORREO -->
        <div class="campo">

            <i class="fa-solid fa-envelope"></i>

            <input
                type="email"
                name="email"
                placeholder="Correo electrónico"
                required
            >

        </div>


        <!-- TELÉFONO -->
        <div class="campo">

            <i class="fa-solid fa-phone"></i>

            <input
                type="tel"
                name="telefono"
                placeholder="Teléfono"
            >

        </div>


        <!-- DIRECCIÓN -->
        <div class="campo">

            <i class="fa-solid fa-location-dot"></i>

            <input
                type="text"
                name="direccion"
                placeholder="Dirección"
            >

        </div>


        <!-- FECHA DE NACIMIENTO -->
        <div class="campo">

            <i class="fa-solid fa-calendar"></i>

            <input
                type="date"
                name="fecha_nacimiento"
            >

        </div>


        <!-- CONTRASEÑA -->
        <div class="campo">

            <i class="fa-solid fa-lock"></i>

            <input
                type="password"
                name="password"
                placeholder="Contraseña"
                required
            >

        </div>


        <!-- CONFIRMAR CONTRASEÑA -->
        <div class="campo">

            <i class="fa-solid fa-lock"></i>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirmar contraseña"
                required
            >

        </div>


        <!-- TÉRMINOS -->
        <div class="terminos">

            <input
                type="checkbox"
                id="terminos"
                name="terminos"
                required
            >

            <label for="terminos">
                Acepto los
                <a href="#">términos y condiciones</a>
            </label>

        </div>


        <!-- BOTÓN -->
        <button type="submit" class="boton-registro">

            <i class="fa-solid fa-user-plus"></i>

            Crear cuenta

        </button>


        <!-- ENLACE A LOGIN -->
        <div class="login">

            ¿Ya tienes una cuenta?

            <a href="{{ route('login') }}">
                Iniciar sesión
            </a>

        </div>

    </form>

</body>
</html>