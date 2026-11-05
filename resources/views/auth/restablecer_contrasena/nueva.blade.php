<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-los-amates.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva contraseña - Orquídeas y más Los Amates</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @include('auth.restablecer_contrasena._estilos')
</head>

<body>
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
        </div>
    </nav>
    <form action="{{ route('contrasena.actualizar') }}" method="POST" class="contenedor">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <img src="{{ asset('images/logo-los-amates.png') }}" alt="Logo Los Amates" class="logo">
        <h1>Nueva contraseña</h1>
        <p class="subtitulo">Escribe y confirma tu nueva contraseña.</p>
        @error('email')
            <div class="error">
                {{ $message }}
                <a href="{{ route('contrasena.solicitar') }}">Solicitar un enlace nuevo</a>
            </div>
        @enderror
        <div class="campo">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="email" value="{{ old('email', $email) }}"
                   placeholder="Correo electrónico" readonly required>
        </div>
        <div class="campo">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Nueva contraseña"
                   autocomplete="new-password" required autofocus>
        </div>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror
        <div class="ayuda-password">Mínimo 8 caracteres, con letras y números.</div>
        <div class="campo">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña"
                   autocomplete="new-password" required>
        </div>
        <button type="submit" class="boton-login">
            <i class="fa-solid fa-key"></i>
            Guardar contraseña
        </button>
        <div class="registro">
            <a href="{{ route('login') }}">Volver a iniciar sesión</a>
        </div>
    </form>
</body>
</html>