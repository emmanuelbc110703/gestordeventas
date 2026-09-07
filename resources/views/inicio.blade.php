<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-los-amates.png') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Orquídeas y más | Los Amates</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #faf7fb;
            color: #333;
        }

        /* =========================
           MENÚ SUPERIOR
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

        .btn-login {
            background-color: #6a1b9a;
            color: white !important;
            padding: 10px 18px;
            border-radius: 8px;
        }

        .btn-login:hover {
            background-color: #4a126d;
            color: white !important;
        }

        /* =========================
           PORTADA
        ========================= */
        .portada {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 20px 50px;
            position: relative;
            overflow: hidden;

            background:
                linear-gradient(
                    rgba(63, 15, 90, 0.75),
                    rgba(106, 27, 154, 0.70)
                ),
                url('{{ asset('images/portada.jpg') }}');

            background-size: cover;
            background-position: center;
        }

        .portada-contenido {
            color: white;
            max-width: 850px;
            animation: aparecer 1.2s ease;
        }

        .portada-logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            background-color: white;
            border-radius: 20px;
            padding: 10px;
            margin-bottom: 25px;
        }

        .portada h1 {
            font-size: 60px;
            margin-bottom: 15px;
        }

        .portada p {
            font-size: 22px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .botones-portada {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 14px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-principal {
            background-color: white;
            color: #6a1b9a;
        }

        .btn-principal:hover {
            transform: translateY(-4px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
        }

        .btn-secundario {
            border: 2px solid white;
            color: white;
        }

        .btn-secundario:hover {
            background-color: white;
            color: #6a1b9a;
        }

        /* =========================
           SECCIONES GENERALES
        ========================= */
        section {
            padding: 90px 8%;
        }

        .titulo-seccion {
            text-align: center;
            margin-bottom: 50px;
        }

        .titulo-seccion h2 {
            color: #6a1b9a;
            font-size: 36px;
            margin-bottom: 10px;
        }

        .titulo-seccion p {
            color: #666;
            font-size: 17px;
        }

        /* =========================
           NOSOTROS
        ========================= */
        .nosotros {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .nosotros-imagen img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .nosotros-texto h2 {
            color: #6a1b9a;
            font-size: 35px;
            margin-bottom: 20px;
        }

        .nosotros-texto p {
            color: #555;
            line-height: 1.8;
            margin-bottom: 15px;
            font-size: 17px;
        }

        .datos-local {
            margin-top: 25px;
            display: grid;
            gap: 15px;
        }

        .dato {
            display: flex;
            align-items: center;
            gap: 15px;
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .dato i {
            color: #6a1b9a;
            font-size: 22px;
        }

        /* =========================
           PRODUCTOS
        ========================= */
        .productos {
            background-color: #f3e8f7;
        }

        .productos-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 1100px;
            margin: auto;
        }

        .producto {
            background-color: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.10);
            transition: 0.3s;
        }

        .producto:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.18);
        }

        .producto img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .producto-info {
            padding: 25px;
            text-align: center;
        }

        .producto-info i {
            color: #6a1b9a;
            font-size: 35px;
            margin-bottom: 12px;
        }

        .producto-info h3 {
            color: #333;
            font-size: 23px;
            margin-bottom: 10px;
        }

        .producto-info p {
            color: #666;
            line-height: 1.6;
        }

        /* =========================
           LLAMADO A LA ACCIÓN
        ========================= */
        .registro-seccion {
            text-align: center;
            background:
                linear-gradient(
                    rgba(74, 18, 109, 0.92),
                    rgba(106, 27, 154, 0.92)
                ),
                url('{{ asset('images/fondo-registro.jpg') }}');

            background-size: cover;
            background-position: center;
            color: white;
        }

        .registro-seccion h2 {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .registro-seccion p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        /* =========================
           PIE DE PÁGINA
        ========================= */
        footer {
            background-color: #3b104f;
            color: white;
            text-align: center;
            padding: 30px;
        }

        footer h3 {
            margin-bottom: 10px;
        }

        footer p {
            color: #ddd;
        }

        /* =========================
           ANIMACIÓN
        ========================= */
        @keyframes aparecer {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

       /* =========================
   RESPONSIVO
========================= */

/* TABLETS */
@media (max-width: 900px) {

    /* La barra se adapta y NO oculta ninguna opción */
    nav {
        padding: 12px 5%;
        flex-direction: column;
        gap: 12px;
    }

    .marca {
        font-size: 18px;
    }

    .marca i {
        font-size: 23px;
    }

    .menu {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px 15px;
    }

    .menu a {
        font-size: 14px;
    }

    .btn-login {
        padding: 9px 15px;
    }

    /* Portada */
    .portada {
        padding: 170px 20px 60px;
    }

    .portada h1 {
        font-size: 42px;
    }

    .portada p {
        font-size: 18px;
    }

    .portada-logo {
        width: 130px;
        height: 130px;
    }

    /* Nosotros */
    .nosotros {
        grid-template-columns: 1fr;
        gap: 35px;
    }

    .nosotros-imagen img {
        height: 350px;
    }

    /* Productos */
    .productos-grid {
        grid-template-columns: repeat(2, 1fr);
        max-width: 800px;
    }

    .producto:last-child {
        grid-column: 1 / -1;
        max-width: 380px;
        width: 100%;
        margin: auto;
    }
}


/* CELULARES */
@media (max-width: 600px) {

    nav {
        padding: 10px 4%;
        gap: 10px;
    }

    .marca {
        font-size: 17px;
    }

    .marca i {
        font-size: 21px;
    }

    .menu {
        gap: 8px 12px;
    }

    .menu a {
        font-size: 13px;
    }

    .btn-login {
        padding: 8px 12px;
    }

    /* Portada */
    .portada {
        min-height: 100vh;
        padding: 165px 15px 50px;
    }

    .portada-logo {
        width: 110px;
        height: 110px;
        margin-bottom: 20px;
    }

    .portada h1 {
        font-size: 34px;
        line-height: 1.2;
    }

    .portada p {
        font-size: 17px;
        line-height: 1.5;
    }

    .botones-portada {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
    }

    .btn {
        width: 100%;
        padding: 13px 15px;
    }

    /* Secciones */
    section {
        padding: 70px 5%;
    }

    .titulo-seccion {
        margin-bottom: 35px;
    }

    .titulo-seccion h2 {
        font-size: 30px;
    }

    .titulo-seccion p {
        font-size: 16px;
    }

    /* Nosotros */
    .nosotros {
        gap: 25px;
    }

    .nosotros-imagen img {
        height: 260px;
    }

    .nosotros-texto h2 {
        font-size: 29px;
    }

    .nosotros-texto p {
        font-size: 16px;
        line-height: 1.6;
    }

    .dato {
        padding: 13px;
        gap: 12px;
    }

    .dato i {
        font-size: 20px;
    }

    /* Productos */
    .productos-grid {
        grid-template-columns: 1fr;
        max-width: 450px;
    }

    .producto:last-child {
        grid-column: auto;
        max-width: none;
    }

    .producto img {
        height: 240px;
    }

    /* Registro */
    .registro-seccion h2 {
        font-size: 30px;
    }

    .registro-seccion p {
        font-size: 16px;
        line-height: 1.6;
    }

    /* Footer */
    footer {
        padding: 25px 15px;
    }
}


/* CELULARES MUY PEQUEÑOS */
@media (max-width: 380px) {

    .marca {
        font-size: 15px;
    }

    .marca i {
        font-size: 19px;
    }

    .menu {
        gap: 6px 8px;
    }

    .menu a {
        font-size: 12px;
    }

    .btn-login {
        padding: 7px 10px;
    }

    .portada {
        padding-top: 155px;
    }

    .portada h1 {
        font-size: 29px;
    }

    .portada p {
        font-size: 15px;
    }

    .portada-logo {
        width: 95px;
        height: 95px;
    }
}

        @media (max-width: 500px) {

            nav {
                padding: 15px 5%;
            }

            .marca {
                font-size: 15px;
            }

            .portada h1 {
                font-size: 34px;
            }

            section {
                padding: 70px 5%;
            }

            .titulo-seccion h2 {
                font-size: 30px;
            }
        }
    </style>
</head>

<body>

    <!-- MENÚ -->
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

        <a href="{{ route('login') }}" class="btn-login">
            <i class="fa-solid fa-right-to-bracket"></i>
            Iniciar sesión
        </a>

    </div>

</nav>


    <!-- PORTADA -->
    <section class="portada" id="inicio">

        <div class="portada-contenido">

            <img
                src="{{ asset('images/logo-los-amates.png') }}"
                alt="Logo Los Amates"
                class="portada-logo"
            >

            <h1>Orquídeas y más Los Amates</h1>

            <p>
                Naturaleza, color y vida para transformar
                cada uno de tus espacios.
            </p>

            <div class="botones-portada">

                <a href="#productos" class="btn btn-principal">
                    <i class="fa-solid fa-leaf"></i>
                    Conoce nuestros productos
                </a>

                <a href="{{ route('registro') }}" class="btn btn-secundario">
                    <i class="fa-solid fa-user-plus"></i>
                    Crear una cuenta
                </a>

            </div>

        </div>

    </section>


    <!-- INFORMACIÓN DEL LOCAL -->
    <section id="nosotros">

        <div class="nosotros">

            <div class="nosotros-imagen">

                <!-- AQUÍ COLOCARÁS LA IMAGEN DEL LOCAL -->
                <img
                    src="{{ asset('images/local.jpg') }}"
                    alt="Orquídeas y más Los Amates"
                >

            </div>

            <div class="nosotros-texto">

                <h2>Conoce nuestro local</h2>

                <p>
                    En Orquídeas y más Los Amates encontrarás
                    una variedad de plantas y productos pensados
                    para darle vida, color y naturaleza a tus espacios.
                </p>

                <p>
                    Nos especializamos en ofrecer hermosas orquídeas,
                    anturios y macetas para diferentes gustos y ocasiones.
                </p>

                <div class="datos-local">

                    <div class="dato">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Información de ubicación del local</span>
                    </div>

                    <div class="dato">
                        <i class="fa-solid fa-clock"></i>
                        <span>Horario de atención</span>
                    </div>

                    <div class="dato">
                        <i class="fa-solid fa-phone"></i>
                        <span>Información de contacto</span>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- PRODUCTOS -->
    <section class="productos" id="productos">

        <div class="titulo-seccion">

            <h2>Nuestros productos enviados desde la casa de jorsh</h2>

            <p>
                Conoce algunos de los productos que puedes encontrar con nosotros.
            </p>

        </div>


        <div class="productos-grid">

            <!-- ORQUÍDEAS -->
            <div class="producto">

                <!-- AQUÍ COLOCARÁS LA IMAGEN -->
                <img
                    src="{{ asset('images/orquideas.jpg') }}"
                    alt="Orquídeas"
                >

                <div class="producto-info">

                    <i class="fa-solid fa-spa"></i>

                    <h3>Orquídeas</h3>

                    <p>
                        Hermosas orquídeas para decorar, regalar
                        o disfrutar de la belleza de la naturaleza.
                    </p>

                </div>

            </div>


            <!-- ANTURIOS -->
            <div class="producto">

                <!-- AQUÍ COLOCARÁS LA IMAGEN -->
                <img
                    src="{{ asset('images/anturios.jpg') }}"
                    alt="Anturios"
                >

                <div class="producto-info">

                    <i class="fa-solid fa-heart"></i>

                    <h3>Anturios</h3>

                    <p>
                        Plantas llenas de color y elegancia,
                        ideales para darle un toque especial a cualquier espacio.
                    </p>

                </div>

            </div>


            <!-- MACETAS -->
            <div class="producto">

                <!-- AQUÍ COLOCARÁS LA IMAGEN -->
                <img
                    src="{{ asset('images/macetas.jpg') }}"
                    alt="Macetas"
                >

                <div class="producto-info">

                    <i class="fa-solid fa-seedling"></i>

                    <h3>Macetas</h3>

                    <p>
                        Diferentes estilos de macetas para acompañar
                        y complementar tus plantas favoritas.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- CREAR CUENTA -->
    <section class="registro-seccion">

        <h2>¿Quieres formar parte de nuestros clientes?</h2>

        <p>
            Crea una cuenta y conoce mejor nuestros productos y servicios.
        </p>

        <a href="{{ route('registro') }}" class="btn btn-principal">
            <i class="fa-solid fa-user-plus"></i>
            Registrarme ahora
        </a>

    </section>


    <!-- FOOTER -->
    <footer>

        <h3>Orquídeas y más "Los Amates"</h3>

        <p>
            <i class="fa-solid fa-leaf"></i>
            Naturaleza, color y vida
        </p>

    </footer>

</body>
</html>