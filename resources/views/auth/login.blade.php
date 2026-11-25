<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-los-amates.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Orquídeas y más Los Amates</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primario: #6d28d9;
            --primario-oscuro: #5b21b6;
            --borde: #e5e7eb;
            --texto: #111827;
            --texto-suave: #6b7280;
            --fondo: #f9fafb;
            --fondo-suave: #f1f4f9;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 112px 20px 40px;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--fondo-suave);
            color: var(--texto);
            line-height: 1.6;
        }

        img { display: block; max-width: 100%; }
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.97);
            border-bottom: 1px solid var(--borde);
        }
        .nav-interior {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            height: 72px;
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 32px;
        }
        .marca {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--texto);
            font-size: 17px;
            font-weight: 700;
            letter-spacing: -0.01em;
            text-decoration: none;
        }
        .marca-logo {
            width: 44px;
            height: 44px;
            padding: 3px;
            object-fit: contain;
            background: #fff;
            border: 1px solid var(--borde);
        }
        .menu {
            display: flex;
            align-items: center;
            gap: 32px;
        }
        .menu a {
            color: var(--texto-suave);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .menu a:hover { color: var(--primario); }

        .login {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border: 1px solid rgba(109, 40, 217, 0.12);
            box-shadow:
                0 4px 12px rgba(109, 40, 217, 0.10),
                0 18px 50px rgba(109, 40, 217, 0.22);
            animation: aparecer 0.5s ease;
        }
        .login-cabecera {
            padding: 36px 40px 28px;
            text-align: center;
            border-bottom: 1px solid var(--borde);
        }
        .logo {
            width: 84px;
            height: 84px;
            margin: 0 auto 20px;
            padding: 6px;
            object-fit: contain;
            background: #fff;
            border: 1px solid var(--borde);
        }
        .etiqueta {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--primario);
        }
        .login-cabecera h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .subtitulo {
            margin-top: 8px;
            font-size: 15px;
            color: var(--texto-suave);
        }

        .login-cuerpo { padding: 32px 40px 36px; }

        .alerta {
            margin-bottom: 20px;
            padding: 12px 16px;
            font-size: 14px;
            text-align: left;
        }
        .alerta-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b42318;
        }
        .alerta-exito {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
        .error-campo {
            margin-top: 8px;
            font-size: 13px;
            color: #b42318;
        }

        .campo { margin-bottom: 22px; }
        .campo label {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
        }
        .campo-control { position: relative; }
        .campo-control i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #9ca3af;
            pointer-events: none;
            transition: color 0.2s ease;
        }
        .campo-control input {
            width: 100%;
            height: 52px;
            padding: 0 16px 0 44px;
            background: #fff;
            border: 1px solid var(--borde);
            border-radius: 0;
            font-family: inherit;
            font-size: 15px;
            color: var(--texto);
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .campo-control input::placeholder { color: #9ca3af; }
        .campo-control input:focus {
            border-color: var(--primario);
            box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
        }
        .campo-control:focus-within i { color: var(--primario); }

        .enlace-olvide {
            display: block;
            margin: -8px 0 24px;
            text-align: right;
            font-size: 14px;
            font-weight: 500;
            color: var(--primario);
            text-decoration: none;
        }
        .enlace-olvide:hover { text-decoration: underline; }

        .boton-login {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            height: 48px;
            background: var(--primario);
            border: 1px solid var(--primario);
            border-radius: 0;
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease;
        }
        .boton-login:hover {
            background: var(--primario-oscuro);
            border-color: var(--primario-oscuro);
        }

        .login-pie {
            padding: 20px 40px;
            text-align: center;
            font-size: 15px;
            color: var(--texto-suave);
            background: var(--fondo);
            border-top: 1px solid var(--borde);
        }
        .login-pie a {
            font-weight: 600;
            color: var(--primario);
            text-decoration: none;
        }
        .login-pie a:hover { text-decoration: underline; }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: none; }
        }

        @media (max-width: 750px) {
            body { padding-top: 150px; }
            .nav-interior {
                flex-direction: column;
                justify-content: center;
                height: auto;
                padding: 12px 24px;
                gap: 10px;
            }
            .menu { width: 100%; justify-content: center; flex-wrap: wrap; gap: 8px 18px; }
            .menu a { font-size: 12px; }
        }
        @media (max-width: 500px) {
            body { padding-left: 14px; padding-right: 14px; }
            .login-cabecera { padding: 28px 22px 22px; }
            .login-cuerpo { padding: 26px 22px 30px; }
            .login-pie { padding: 18px 22px; }
            .login-cabecera h1 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-interior">
            <a href="{{ route('inicio') }}" class="marca">
                <img
                    src="{{ asset('images/logo-los-amates.png') }}"
                    alt="Logo Los Amates"
                    class="marca-logo"
                >
                Orquídeas y más
            </a>
            <div class="menu">
                <a href="{{ route('inicio') }}">Inicio</a>
                <a href="{{ route('inicio') }}#nosotros">Nosotros</a>
                <a href="{{ route('inicio') }}#productos">Productos</a>
            </div>
        </div>
    </nav>
    <form action="{{ route('login.store') }}" method="POST" class="login">
        @csrf
        <div class="login-cabecera">
            <img
                src="{{ asset('images/logo-los-amates.png') }}"
                alt="Logo Los Amates"
                class="logo"
            >
            <span class="etiqueta">Acceso</span>
            <h1>Bienvenido</h1>
            <p class="subtitulo">Orquídeas y más "Los Amates"</p>
        </div>
        <div class="login-cuerpo">
            @if(session('error'))
                <div class="alerta alerta-error">{{ session('error') }}</div>
            @endif
            @if(session('status'))
                <div class="alerta alerta-exito">{{ session('status') }}</div>
            @endif
            <div class="campo">
                <label for="email">Correo electrónico</label>
                <div class="campo-control">
                    <i class="fa-solid fa-envelope"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com"
                        required
                    >
                </div>
                @error('email')
                    <div class="error-campo">{{ $message }}</div>
                @enderror
            </div>
            <div class="campo">
                <label for="password">Contraseña</label>
                <div class="campo-control">
                    <i class="fa-solid fa-lock"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Tu contraseña"
                        required
                    >
                </div>
                @error('password')
                    <div class="error-campo">{{ $message }}</div>
                @enderror
            </div>
            <a href="{{ route('contrasena.solicitar') }}" class="enlace-olvide">¿Olvidaste tu contraseña?</a>
            <button type="submit" class="boton-login">
                <i class="fa-solid fa-right-to-bracket"></i>
                Iniciar sesión
            </button>
        </div>
        <div class="login-pie">
            ¿No tienes una cuenta?
            <a href="{{ route('registro') }}">Registrarse</a>
        </div>
    </form>
</body>
</html>