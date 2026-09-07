<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Orquídeas y más Los Amates</title>

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
           CONTENEDOR LOGIN
        ========================= */
        .contenedor {
            width: 90%;
            max-width: 420px;
            background-color: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .logo {
            width: 130px;
            height: 130px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        h1 {
            color: #6a1b9a;
            margin-bottom: 5px;
        }

        .subtitulo {
            color: #666;
            margin-bottom: 30px;
        }

        .campo {
            position: relative;
            margin-bottom: 20px;
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

        /* MENSAJES DE ERROR */
        .error {
            color: #c62828;
            font-size: 14px;
            text-align: left;
            margin-top: -12px;
            margin-bottom: 15px;
        }

        .boton-login {
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

        .boton-login:hover {
            background-color: #4a126d;
        }

        .registro {
            margin-top: 25px;
            color: #666;
        }

        .registro a {
            color: #6a1b9a;
            font-weight: bold;
            text-decoration: none;
        }

        .registro a:hover {
            text-decoration: underline;
        }

        /* =========================
           RESPONSIVO
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

            .contenedor {
                width: 100%;
                padding: 25px 20px;
            }

            body {
                padding-top: 145px;
            }
        }

        .separador {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 20px 0;
    color: #999;
}

.separador::before,
.separador::after {
    content: "";
    flex: 1;
    height: 1px;
    background-color: #ddd;
}

.boton-google {
    width: 100%;
    padding: 13px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: white;
    color: #333;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.boton-google:hover {
    background-color: #f5f5f5;
    border-color: #bbb;
}

.boton-google i {
    color: #4285f4;
    margin-right: 8px;
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


    <!-- LOGIN -->
    <form action="{{ route('login.store') }}" method="POST" class="contenedor">

        @csrf

        <img
            src="{{ asset('images/logo-los-amates.png') }}"
            alt="Logo Los Amates"
            class="logo"
        >

        <h1>Bienvenido</h1>

        <p class="subtitulo">
            Orquídeas y más "Los Amates"
        </p>


        <!-- MENSAJE GENERAL DE ERROR -->
        @if(session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif


        <!-- CORREO -->
        <div class="campo">

            <i class="fa-solid fa-envelope"></i>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Correo electrónico"
                required
            >

        </div>

        @error('email')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


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

        @error('password')
            <div class="error">
                {{ $message }}
            </div>
        @enderror


        <!-- BOTÓN -->
        <button type="submit" class="boton-login">

            <i class="fa-solid fa-right-to-bracket"></i>

            Iniciar sesión

        </button>

        <div class="separador">
    <span>o</span>
</div>

<button type="button" id="google-login" class="boton-google">
    <i class="fa-brands fa-google"></i>
    Continuar con Google
</button>

<div id="google-error" class="error" style="display: none;"></div>


        <!-- ENLACE A REGISTRO -->
        <div class="registro">

            ¿No tienes una cuenta?

            <a href="{{ route('registro') }}">
                Registrarse
            </a>

        </div>

    </form>
    @vite('resources/js/firebase-auth.js')
</body>
</html>