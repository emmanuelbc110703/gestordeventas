<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Activar cuenta - Gestor de Ventas Los Amates</title>

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
            align-items: center;
            justify-content: center;

            padding: 20px;
        }


        /* =========================
           CONTENEDOR
        ========================= */

        .contenedor {
            width: 100%;
            max-width: 500px;
        }


        /* =========================
           TARJETA
        ========================= */

        .tarjeta {
            background-color: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        }


        /* =========================
           ENCABEZADO
        ========================= */

        .encabezado {
            text-align: center;
            margin-bottom: 30px;
        }

        .icono {
            width: 80px;
            height: 80px;

            margin: 0 auto 20px;

            border-radius: 50%;

            background-color: #6a1b9a;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 32px;
        }

        .encabezado h1 {
            margin: 0 0 10px;
            color: #333;
            font-size: 26px;
        }

        .encabezado p {
            margin: 0;
            color: #666;
            line-height: 1.5;
        }


        /* =========================
           BIENVENIDA
        ========================= */

        .bienvenida {
            background-color: #f3e5f5;
            border-left: 4px solid #6a1b9a;

            padding: 15px;
            border-radius: 8px;

            margin-bottom: 25px;

            color: #4a126d;
            line-height: 1.5;
        }

        .bienvenida strong {
            color: #6a1b9a;
        }


        /* =========================
           CAMPOS
        ========================= */

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

            padding: 13px 45px;

            border: 1px solid #ccc;
            border-radius: 8px;

            font-size: 15px;

            outline: none;

            transition: 0.3s;
        }

        .campo input:focus {
            border-color: #6a1b9a;

            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.1);
        }


        /* =========================
           ERRORES
        ========================= */

        .error {
            display: block;

            color: #dc3545;

            font-size: 13px;

            margin-top: 5px;
        }


        /* =========================
           INFORMACIÓN
        ========================= */

        .seguridad {
            display: flex;
            align-items: flex-start;
            gap: 10px;

            background-color: #f8f9fa;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 25px;

            color: #666;

            font-size: 13px;

            line-height: 1.5;
        }

        .seguridad i {
            color: #6a1b9a;
            margin-top: 2px;
        }


        /* =========================
           BOTÓN
        ========================= */

        .boton {
            width: 100%;

            border: none;

            background-color: #6a1b9a;
            color: white;

            padding: 14px;

            border-radius: 8px;

            font-size: 15px;
            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .boton:hover {
            background-color: #4a126d;
        }


        /* =========================
           REGRESAR
        ========================= */

        .regresar {
            display: block;

            text-align: center;

            margin-top: 20px;

            color: #6a1b9a;

            text-decoration: none;

            font-size: 14px;

            font-weight: bold;
        }

        .regresar:hover {
            text-decoration: underline;
        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 600px) {

            .tarjeta {
                padding: 30px 20px;
            }

            .encabezado h1 {
                font-size: 23px;
            }

        }

    </style>

</head>


<body>

<div class="contenedor">

    <div class="tarjeta">


        <!-- =========================
             ENCABEZADO
        ========================== -->

        <div class="encabezado">

            <div class="icono">
                <i class="fa-solid fa-user-check"></i>
            </div>

            <h1>Activa tu cuenta</h1>

            <p>
                Tu cuenta ya fue registrada por el administrador.
                Solo falta crear tu contraseña.
            </p>

        </div>


        <!-- =========================
             BIENVENIDA
        ========================== -->

        <div class="bienvenida">

            <strong>
                Hola, {{ $usuario->name }} {{ $usuario->apellido }}
            </strong>

            <br>

            Completa este último paso para activar tu cuenta
            y poder acceder a tu panel de cliente.

        </div>


        <!-- =========================
             FORMULARIO
        ========================== -->

        <form
            action="{{ route('cuenta.activar.guardar') }}"
            method="POST"
        >

            @csrf


            <!-- CORREO -->

            <div class="campo">

                <i class="fa-solid fa-envelope"></i>

                <input
                    type="email"
                    name="email"
                    value="{{ $usuario->email }}"
                    readonly
                >

                @error('email')
                    <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <!-- CONTRASEÑA -->

            <div class="campo">

                <i class="fa-solid fa-lock"></i>

                <input
                    type="password"
                    name="password"
                    placeholder="Nueva contraseña"
                    minlength="8"
                    required
                >

                @error('password')
                    <span class="error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            <!-- CONFIRMAR CONTRASEÑA -->

            <div class="campo">

                <i class="fa-solid fa-lock"></i>

                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirmar contraseña"
                    minlength="8"
                    required
                >

            </div>


            <!-- SEGURIDAD -->

            <div class="seguridad">

                <i class="fa-solid fa-shield-halved"></i>

                <span>
                    Tu contraseña debe tener al menos
                    <strong>8 caracteres</strong>.
                    No compartas tu contraseña con otras personas.
                </span>

            </div>


            <!-- BOTÓN -->

            <button
                type="submit"
                class="boton"
            >

                <i class="fa-solid fa-key"></i>

                Crear contraseña y activar cuenta

            </button>

        </form>


        <!-- REGRESAR -->

        <a
            href="{{ route('login') }}"
            class="regresar"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Regresar al inicio de sesión

        </a>


    </div>

</div>

</body>

</html>