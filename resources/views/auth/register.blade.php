<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-los-amates.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Orquídeas y más Los Amates</title>

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
            padding: 112px 20px 48px;
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

        .registro {
            width: 100%;
            max-width: 580px;
            background: #fff;
            border: 1px solid rgba(109, 40, 217, 0.12);
            box-shadow:
                0 4px 12px rgba(109, 40, 217, 0.10),
                0 18px 50px rgba(109, 40, 217, 0.22);
            animation: aparecer 0.5s ease;
        }
        .registro-cabecera {
            padding: 32px 40px 26px;
            text-align: center;
            border-bottom: 1px solid var(--borde);
        }
        .logo {
            width: 76px;
            height: 76px;
            margin: 0 auto 18px;
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
        .registro-cabecera h1 {
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

        .registro-cuerpo { padding: 32px 40px 36px; }

        .fila {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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
        .error-campo {
            margin-top: 8px;
            font-size: 13px;
            color: #b42318;
        }
        .opcional {
            font-weight: 400;
            font-size: 13px;
            color: #9ca3af;
        }

        .terminos {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 4px 0 24px;
            font-size: 14px;
            color: var(--texto-suave);
        }
        .terminos input {
            width: 18px;
            height: 18px;
            margin: 0;
            accent-color: var(--primario);
            cursor: pointer;
        }
        .terminos label { cursor: pointer; }
        .terminos a {
            font-weight: 600;
            color: var(--primario);
            text-decoration: none;
        }
        .terminos a:hover { text-decoration: underline; }

        .boton-registro {
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
        .boton-registro:hover {
            background: var(--primario-oscuro);
            border-color: var(--primario-oscuro);
        }

        .registro-pie {
            padding: 20px 40px;
            text-align: center;
            font-size: 15px;
            color: var(--texto-suave);
            background: var(--fondo);
            border-top: 1px solid var(--borde);
        }
        .registro-pie a {
            font-weight: 600;
            color: var(--primario);
            text-decoration: none;
        }
        .registro-pie a:hover { text-decoration: underline; }

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
        @media (max-width: 600px) {
            .fila { grid-template-columns: 1fr; gap: 0; }
        }
        @media (max-width: 500px) {
            body { padding-left: 14px; padding-right: 14px; }
            .registro-cabecera { padding: 26px 22px 20px; }
            .registro-cuerpo { padding: 26px 22px 30px; }
            .registro-pie { padding: 18px 22px; }
            .registro-cabecera h1 { font-size: 24px; }
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
    @php
        $edadMinima = 18;
    @endphp
    <form action="{{ route('register.store') }}" method="POST" class="registro">
        @csrf

        <div class="registro-cabecera">
            <img
                src="{{ asset('images/logo-los-amates.png') }}"
                alt="Logo Los Amates"
                class="logo"
            >
            <span class="etiqueta">Registro</span>
            <h1>Crear cuenta</h1>
            <p class="subtitulo">Orquídeas y más "Los Amates"</p>
        </div>
        <div class="registro-cuerpo">
            <div class="fila">
                <div class="campo">
                    <label for="name">Nombre</label>
                    <div class="campo-control">
                        <i class="fa-solid fa-user"></i>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Tu nombre"
                            required
                        >
                    </div>
                    @error('name')
                        <div class="error-campo">{{ $message }}</div>
                    @enderror
                </div>
                <div class="campo">
                    <label for="apellido">Apellidos</label>
                    <div class="campo-control">
                        <i class="fa-solid fa-user"></i>
                        <input
                            type="text"
                            id="apellido"
                            name="apellido"
                            value="{{ old('apellido') }}"
                            placeholder="Tus apellidos"
                            required
                        >
                    </div>
                    @error('apellido')
                        <div class="error-campo">{{ $message }}</div>
                    @enderror
                </div>
            </div>
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
            <div class="fila">
                <div class="campo">
                    <label for="telefono">Teléfono <span class="opcional">(opcional)</span></label>
                    <div class="campo-control">
                        <i class="fa-solid fa-phone"></i>
                        <input
                            type="tel"
                            id="telefono"
                            name="telefono"
                            value="{{ old('telefono') }}"
                            placeholder="Tu teléfono"
                        >
                    </div>
                    @error('telefono')
                        <div class="error-campo">{{ $message }}</div>
                    @enderror
                </div>
                <div class="campo">
                    <label for="fecha_nacimiento">Fecha de nacimiento <span class="opcional">(opcional)</span></label>
                    <div class="campo-control">
                        <i class="fa-solid fa-calendar"></i>
                        <input
                            type="date"
                            id="fecha_nacimiento"
                            name="fecha_nacimiento"
                            min="{{ now()->subYears(120)->toDateString() }}"
                            max="{{ now()->subYears($edadMinima)->toDateString() }}"
                            value="{{ old('fecha_nacimiento') }}"
                        >
                    </div>
                    @error('fecha_nacimiento')
                        <div class="error-campo">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="campo">
                <label for="direccion">Dirección <span class="opcional">(opcional)</span></label>
                <div class="campo-control">
                    <i class="fa-solid fa-location-dot"></i>
                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        value="{{ old('direccion') }}"
                        placeholder="Calle, número y colonia"
                    >
                </div>
                @error('direccion')
                    <div class="error-campo">{{ $message }}</div>
                @enderror
            </div>
            <div class="fila">
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
                <div class="campo">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <div class="campo-control">
                        <i class="fa-solid fa-lock"></i>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Repite tu contraseña"
                            required
                        >
                    </div>
                </div>
            </div>
            <button type="submit" class="boton-registro">
                <i class="fa-solid fa-user-plus"></i>
                Crear cuenta
            </button>
        </div>
        <div class="registro-pie">
            ¿Ya tienes una cuenta?
            <a href="{{ route('login') }}">Iniciar sesión</a>
        </div>
    </form>

    <script>
        const fechaNacimiento = document.getElementById('fecha_nacimiento');

        function validarFechaNacimiento() {
            fechaNacimiento.setCustomValidity('');
            if (!fechaNacimiento.value) return;

            if (fechaNacimiento.validity.rangeOverflow) {
                fechaNacimiento.setCustomValidity('Debes tener al menos {{ $edadMinima }} años para registrarte.');
            } else if (fechaNacimiento.validity.rangeUnderflow) {
                fechaNacimiento.setCustomValidity('Ingresa una fecha de nacimiento válida.');
            } else if (fechaNacimiento.validity.badInput) {
                fechaNacimiento.setCustomValidity('La fecha ingresada no es válida.');
            }
        }

        fechaNacimiento.addEventListener('input', validarFechaNacimiento);
        fechaNacimiento.addEventListener('change', validarFechaNacimiento);
        validarFechaNacimiento();
    </script>

</body>
</html>