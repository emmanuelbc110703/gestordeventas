<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-los-amates.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orquídeas y más | Los Amates</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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

        html { scroll-behavior: smooth; scroll-padding-top: 80px; }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            background: #fff;
            color: var(--texto);
            line-height: 1.6;
        }

        img { display: block; max-width: 100%; }

        .contenedor {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* ===== BOTONES ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            height: 44px;
            padding: 0 24px;
            border-radius: 0;
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }
        .btn-primario {
            background: var(--primario);
            border: 1px solid var(--primario);
            color: #fff;
        }
        .btn-primario:hover {
            background: var(--primario-oscuro);
            border-color: var(--primario-oscuro);
        }
        .btn-claro {
            background: #fff;
            border: 1px solid #fff;
            color: var(--primario);
        }
        .btn-claro:hover {
            background: #f5f3ff;
            border-color: #f5f3ff;
        }
        .btn-borde {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.55);
            color: #fff;
        }
        .btn-borde:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: #fff;
        }

        /* ===== MENÚ ===== */
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
        .menu a.btn {
            height: 40px;
            padding: 0 20px;
            color: #fff;
            font-size: 13px;
        }
        .menu a.btn:hover { color: #fff; }

        /* ===== PORTADA ===== */
        .portada {
            position: relative;
            display: flex;
            align-items: center;
            min-height: 100vh;
            padding: 140px 0 90px;
            background:
                linear-gradient(105deg, rgba(36, 10, 64, 0.92) 0%, rgba(36, 10, 64, 0.72) 55%, rgba(36, 10, 64, 0.45) 100%),
                url('{{ asset('images/portada.jpg') }}');
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .portada-contenido {
            max-width: 680px;
            animation: aparecer 0.9s ease;
        }
        .etiqueta {
            display: inline-block;
            margin-bottom: 18px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #c4b5fd;
        }
        .portada h1 {
            margin-bottom: 20px;
            font-size: 56px;
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.03em;
        }
        .portada p {
            max-width: 520px;
            margin-bottom: 36px;
            font-size: 18px;
            color: rgba(255, 255, 255, 0.82);
        }
        .botones-portada {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        /* ===== SECCIONES ===== */
        section.bloque { padding: 100px 0; }

        .encabezado-seccion {
            max-width: 560px;
            margin-bottom: 56px;
            padding-bottom: 28px;
            border-bottom: 1px solid var(--borde);
        }
        .encabezado-seccion .etiqueta { color: var(--primario); margin-bottom: 12px; }
        .encabezado-seccion h2 {
            font-size: 36px;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        .encabezado-seccion p {
            margin-top: 12px;
            font-size: 16px;
            color: var(--texto-suave);
        }

        /* ===== NOSOTROS ===== */
        .nosotros {
            display: grid;
            grid-template-columns: 5fr 6fr;
            gap: 64px;
            align-items: center;
        }
        .nosotros-imagen {
            padding: 14px;
            background: #fff;
            border: 1px solid var(--borde);
        }
        .nosotros-imagen img {
            width: 100%;
            height: 440px;
            object-fit: cover;
            background: var(--fondo-suave);
        }
        .nosotros-texto h2 {
            margin-bottom: 20px;
            font-size: 36px;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        .nosotros-texto > p {
            margin-bottom: 14px;
            font-size: 16px;
            color: var(--texto-suave);
        }
        .datos-local {
            margin-top: 32px;
            border: 1px solid var(--borde);
        }
        .dato {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            font-size: 15px;
            color: var(--texto);
        }
        .dato + .dato { border-top: 1px solid var(--borde); }
        .dato i {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            background: #f5f3ff;
            border: 1px solid #ddd6fe;
            font-size: 16px;
            color: var(--primario);
        }

        /* ===== PRODUCTOS ===== */
        .productos {
            background: var(--fondo);
            border-top: 1px solid var(--borde);
            border-bottom: 1px solid var(--borde);
        }
        .productos-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }
        .producto {
            background: #fff;
            border: 1px solid var(--borde);
            transition: border-color 0.2s ease;
        }
        .producto:hover { border-color: #c4b5fd; }
        .producto-foto {
            position: relative;
            height: 270px;
            background: var(--fondo-suave);
            border-bottom: 1px solid var(--borde);
            overflow: hidden;
        }
        .producto-foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .producto:hover .producto-foto img { transform: scale(1.04); }
        .badge-numero {
            position: absolute;
            top: 16px;
            left: 16px;
            padding: 4px 12px;
            background: #fff;
            border: 1px solid var(--borde);
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 13px;
            color: var(--texto-suave);
        }
        .producto-info { padding: 28px; }
        .producto-info h3 {
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--texto);
        }
        .producto-info p {
            font-size: 15px;
            color: var(--texto-suave);
        }

        /* ===== LLAMADO A LA ACCIÓN ===== */
        .registro-seccion {
            padding: 90px 0;
            background:
                linear-gradient(rgba(36, 10, 64, 0.93), rgba(36, 10, 64, 0.93)),
                url('{{ asset('images/fondo-registro.jpg') }}');
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .registro-interior {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 40px;
            padding: 48px;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }
        .registro-interior h2 {
            margin-bottom: 8px;
            font-size: 30px;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }
        .registro-interior p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.78);
        }

        /* ===== FOOTER ===== */
        footer {
            padding: 32px 0;
            background: #fff;
            border-top: 1px solid var(--borde);
        }
        .footer-interior {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        footer h3 {
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--texto);
        }
        footer p {
            font-size: 14px;
            color: var(--texto-suave);
        }
        footer p i { color: var(--primario); margin-right: 6px; }

        @keyframes aparecer {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: none; }
        }

        /* ===== RESPONSIVO ===== */
        @media (max-width: 950px) {
            .contenedor { padding: 0 24px; }
            .nosotros { grid-template-columns: 1fr; gap: 40px; }
            .nosotros-imagen img { height: 340px; }
            .productos-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
            .producto:last-child { grid-column: 1 / -1; }
            .registro-interior { flex-direction: column; align-items: flex-start; padding: 36px; }
        }

        @media (max-width: 700px) {
            .nav-interior { flex-direction: column; justify-content: center; height: auto; padding: 12px 0; gap: 10px; }
            .menu { width: 100%; justify-content: center; flex-wrap: wrap; gap: 8px 18px; }
            .menu a { font-size: 12px; }
            .menu a.btn { height: 36px; padding: 0 14px; font-size: 12px; }

            .portada { padding: 190px 0 60px; min-height: auto; }
            .portada h1 { font-size: 36px; }
            .portada p { font-size: 16px; }
            .botones-portada { flex-direction: column; }
            .botones-portada .btn { width: 100%; }

            section.bloque { padding: 64px 0; }
            .encabezado-seccion { margin-bottom: 36px; }
            .encabezado-seccion h2,
            .nosotros-texto h2 { font-size: 28px; }
            .nosotros-imagen { padding: 10px; }
            .nosotros-imagen img { height: 260px; }

            .productos-grid { grid-template-columns: 1fr; }
            .producto:last-child { grid-column: auto; }
            .producto-foto { height: 240px; }

            .registro-seccion { padding: 56px 0; }
            .registro-interior { padding: 28px 22px; }
            .registro-interior h2 { font-size: 24px; }
            .registro-interior .btn { width: 100%; }

            .footer-interior { flex-direction: column; text-align: center; }
        }
    </style>
</head>

<body>

    <!-- MENÚ -->
    <nav>
        <div class="contenedor nav-interior">
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
                <a href="{{ route('login') }}" class="btn btn-primario">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Iniciar sesión
                </a>
            </div>
        </div>
    </nav>


    <!-- PORTADA -->
    <header class="portada" id="inicio">
        <div class="contenedor">
            <div class="portada-contenido">
                <span class="etiqueta">Naturaleza, color y vida</span>
                <h1>Orquídeas y más<br>Los Amates</h1>

                <p>
                    Plantas y productos pensados para transformar
                    cada uno de tus espacios.
                </p>

                <div class="botones-portada">
                    <a href="#productos" class="btn btn-claro">
                        <i class="fa-solid fa-leaf"></i>
                        Conoce nuestros productos
                    </a>
                    <a href="{{ route('registro') }}" class="btn btn-borde">
                        <i class="fa-solid fa-user-plus"></i>
                        Crear una cuenta
                    </a>
                </div>
            </div>
        </div>
    </header>


    <!-- INFORMACIÓN DEL LOCAL -->
    <section class="bloque" id="nosotros">
        <div class="contenedor">
            <div class="nosotros">

                <div class="nosotros-imagen">
                    <img
                        src="{{ asset('images/local.jpg') }}"
                        alt="Orquídeas y más Los Amates"
                    >
                </div>

                <div class="nosotros-texto">
                    <span class="etiqueta" style="color: var(--primario);">Nosotros</span>
                    <h2>Conoce nuestro local</h2>

                    <p>
                        En Orquídeas y más Los Amates encontrarás una variedad de
                        plantas y productos pensados para darle vida, color y
                        naturaleza a tus espacios.
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
        </div>
    </section>


    <!-- PRODUCTOS -->
    <section class="bloque productos" id="productos">
        <div class="contenedor">

            <div class="encabezado-seccion">
                <span class="etiqueta">Catálogo</span>
                <h2>Nuestros productos</h2>
                <p>Conoce algunos de los productos que puedes encontrar con nosotros.</p>
            </div>

            <div class="productos-grid">

                <div class="producto">
                    <div class="producto-foto">
                        <img src="{{ asset('images/orquideas.jpg') }}" alt="Orquídeas">
                        <span class="badge-numero">01</span>
                    </div>
                    <div class="producto-info">
                        <h3>Orquídeas</h3>
                        <p>
                            Hermosas orquídeas para decorar, regalar
                            o disfrutar de la belleza de la naturaleza.
                        </p>
                    </div>
                </div>

                <div class="producto">
                    <div class="producto-foto">
                        <img src="{{ asset('images/anturios.jpg') }}" alt="Anturios">
                        <span class="badge-numero">02</span>
                    </div>
                    <div class="producto-info">
                        <h3>Anturios</h3>
                        <p>
                            Plantas llenas de color y elegancia, ideales
                            para darle un toque especial a cualquier espacio.
                        </p>
                    </div>
                </div>

                <div class="producto">
                    <div class="producto-foto">
                        <img src="{{ asset('images/macetas.jpg') }}" alt="Macetas">
                        <span class="badge-numero">03</span>
                    </div>
                    <div class="producto-info">
                        <h3>Macetas</h3>
                        <p>
                            Diferentes estilos de macetas para acompañar
                            y complementar tus plantas favoritas.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- CREAR CUENTA -->
    <section class="registro-seccion">
        <div class="contenedor">
            <div class="registro-interior">
                <div>
                    <h2>¿Quieres formar parte de nuestros clientes?</h2>
                    <p>Crea una cuenta y conoce mejor nuestros productos y servicios.</p>
                </div>
                <a href="{{ route('registro') }}" class="btn btn-claro">
                    <i class="fa-solid fa-user-plus"></i>
                    Registrarme ahora
                </a>
            </div>
        </div>
    </section>


    <!-- FOOTER -->
    <footer>
        <div class="contenedor footer-interior">
            <h3>Orquídeas y más "Los Amates"</h3>
            <p><i class="fa-solid fa-leaf"></i>Naturaleza, color y vida</p>
        </div>
    </footer>

</body>
</html>