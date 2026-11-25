<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-los-amates.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activar cuenta - Gestor de Ventas Los Amates</title>

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
            padding: 40px 20px;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--fondo-suave);
            color: var(--texto);
            line-height: 1.6;
        }
        img { display: block; max-width: 100%; }
        .tarjeta {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border: 1px solid rgba(109, 40, 217, 0.12);
            box-shadow:
                0 4px 12px rgba(109, 40, 217, 0.10),
                0 18px 50px rgba(109, 40, 217, 0.22);
            animation: aparecer 0.5s ease;
        }
        .tarjeta-cabecera {
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
        .tarjeta-cabecera h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .subtitulo {
            margin-top: 10px;
            font-size: 15px;
            color: var(--texto-suave);
        }
        .tarjeta-cuerpo { padding: 32px 40px 36px; }
        .bienvenida {
            margin-bottom: 28px;
            padding: 16px 20px;
            background: #f5f3ff;
            border: 1px solid #ddd6fe;
            font-size: 14px;
            line-height: 1.6;
            color: #4c1d95;
        }
        .bienvenida strong {
            display: block;
            margin-bottom: 2px;
            font-size: 15px;
            color: var(--texto);
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
        .campo-control input[readonly] {
            background: var(--fondo-suave);
            color: var(--texto-suave);
            cursor: not-allowed;
        }
        .campo-control input[readonly]:focus {
            border-color: var(--borde);
            box-shadow: none;
        }
        .error-campo {
            display: block;
            margin-top: 8px;
            font-size: 13px;
            color: #b42318;
        }
        .seguridad {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 24px;
            padding: 14px 16px;
            background: var(--fondo);
            border: 1px solid var(--borde);
            font-size: 13px;
            line-height: 1.6;
            color: var(--texto-suave);
        }
        .seguridad i {
            margin-top: 3px;
            color: var(--primario);
        }
        .seguridad strong { color: var(--texto); }
        .boton {
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
        .boton:hover {
            background: var(--primario-oscuro);
            border-color: var(--primario-oscuro);
        }
        .tarjeta-pie {
            padding: 20px 40px;
            text-align: center;
            font-size: 15px;
            background: var(--fondo);
            border-top: 1px solid var(--borde);
        }
        .regresar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--primario);
            text-decoration: none;
        }
        .regresar:hover { text-decoration: underline; }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: none; }
        }
        @media (max-width: 500px) {
            body { padding: 24px 14px; }
            .tarjeta-cabecera { padding: 28px 22px 22px; }
            .tarjeta-cuerpo { padding: 26px 22px 30px; }
            .tarjeta-pie { padding: 18px 22px; }
            .tarjeta-cabecera h1 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <div class="tarjeta">
        <div class="tarjeta-cabecera">
            <img
                src="{{ asset('images/logo-los-amates.png') }}"
                alt="Logo Los Amates"
                class="logo"
            >
            <span class="etiqueta">Activación</span>
            <h1>Activa tu cuenta</h1>
            <p class="subtitulo">
                Tu cuenta ya fue registrada por el administrador.
                Solo falta crear tu contraseña.
            </p>
        </div>
        <div class="tarjeta-cuerpo">
            <div class="bienvenida">
                <strong>Hola, {{ $usuario->name }} {{ $usuario->apellido }}</strong>
                Completa este último paso para activar tu cuenta
                y poder acceder a tu panel de cliente.
            </div>
            <form action="{{ route('cuenta.activar.guardar') }}" method="POST">
                @csrf
                <div class="campo">
                    <label for="email">Correo electrónico</label>
                    <div class="campo-control">
                        <i class="fa-solid fa-envelope"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ $usuario->email }}"
                            readonly
                        >
                    </div>
                    @error('email')
                        <span class="error-campo">{{ $message }}</span>
                    @enderror
                </div>
                <div class="campo">
                    <label for="password">Nueva contraseña</label>
                    <div class="campo-control">
                        <i class="fa-solid fa-lock"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Mínimo 8 caracteres"
                            minlength="8"
                            required
                        >
                    </div>
                    @error('password')
                        <span class="error-campo">{{ $message }}</span>
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
                            minlength="8"
                            required
                        >
                    </div>
                </div>
                <div class="seguridad">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>
                        Tu contraseña debe tener al menos <strong>8 caracteres</strong>.
                        No compartas tu contraseña con otras personas.
                    </span>
                </div>
                <button type="submit" class="boton">
                    <i class="fa-solid fa-key"></i>
                    Crear contraseña y activar cuenta
                </button>
            </form>
        </div>
        <div class="tarjeta-pie">
            <a href="{{ route('login') }}" class="regresar">
                <i class="fa-solid fa-arrow-left"></i>
                Regresar al inicio de sesión
            </a>
        </div>

    </div>

</body>
</html>