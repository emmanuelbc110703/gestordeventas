<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventario de Bienes - Orquídeas y más Los Amates</title>

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
            background: #f5f5f5;
            color: #333;
        }

        /* =========================
           BARRA SUPERIOR
        ========================= */

        .barra-superior {
            width: 100%;
            background: #6a1b9a;
            color: white;
            padding: 17px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);
        }

        .titulo-barra {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 21px;
            font-weight: bold;
        }

        .titulo-barra i {
            font-size: 25px;
        }

        .btn-regresar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 17px;
            background: white;
            color: #6a1b9a;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-regresar:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        /* =========================
           CONTENEDOR PRINCIPAL
        ========================= */

        .contenedor {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 30px;
        }

        .encabezado h1 {
            margin: 0 0 8px;
            color: #6a1b9a;
            font-size: 36px;
        }

        .encabezado p {
            margin: 0;
            color: #777;
            font-size: 16px;
        }

        /* =========================
           BOTÓN AGREGAR
        ========================= */

        .zona-agregar {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }

        .btn-agregar {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 13px 24px;
            background: #6a1b9a;
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(106, 27, 154, 0.25);
        }

        .btn-agregar:hover {
            background: #4a126d;
            transform: translateY(-2px);
        }

        /* =========================
           BUSCADOR Y FILTRO
        ========================= */

        .contenedor-busqueda {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 30px;
        }

        .buscador {
            position: relative;
            flex: 1;
        }

        .buscador i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6a1b9a;
        }

        .buscador input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #d2d2d2;
            border-radius: 8px;
            outline: none;
            font-size: 16px;
        }

        .buscador input:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.08);
        }

        /* =========================
           FILTRO
        ========================= */

        .filtro {
            position: relative;
        }

        .boton-filtro {
            background-color: #6a1b9a;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px 18px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            white-space: nowrap;
            transition: 0.3s;
        }

        .boton-filtro:hover {
            background-color: #4a126d;
        }

        .boton-filtro i {
            margin-right: 6px;
        }

        .menu-filtro {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 200px;
            background-color: white;
            border-radius: 10px;
            padding: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.18);
            z-index: 1000;
        }

        .menu-filtro.activo {
            display: block;
        }

        .menu-filtro button {
            width: 100%;
            background: none;
            border: none;
            padding: 12px;
            text-align: left;
            color: #444;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .menu-filtro button:hover {
            background-color: #f8f0fb;
            color: #6a1b9a;
        }

        .menu-filtro i {
            margin-right: 8px;
            color: #6a1b9a;
        }

        /* =========================
           TARJETAS
        ========================= */

        .bienes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .bien-card {
            background: white;
            border-radius: 14px;
            overflow: visible;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .bien-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.13);
        }

        /* =========================
           IMAGEN
        ========================= */

        .bien-imagen {
            width: 100%;
            height: 210px;
            background: #eee;
            overflow: hidden;
            position: relative;
            border-radius: 14px 14px 0 0;
        }

        .bien-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .imagen-sin-foto {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
            color: #999;
        }

        .imagen-sin-foto i {
            font-size: 50px;
            color: #6a1b9a;
        }

        /* =========================
           BOTÓN TRES PUNTOS
        ========================= */

        .menu-acciones {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 20;
        }

        .boton-acciones {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            color: #555;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        .boton-acciones:hover {
            background: white;
            color: #6a1b9a;
            transform: scale(1.05);
        }

        /* =========================
           MENÚ EDITAR / ELIMINAR
        ========================= */

        .menu-acciones-contenido {
            display: none;
            position: absolute;
            top: 46px;
            right: 0;
            width: 155px;
            background: white;
            border-radius: 10px;
            padding: 7px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            z-index: 100;
        }

        .menu-acciones-contenido.activo {
            display: block;
        }

        .menu-acciones-contenido a,
        .menu-acciones-contenido button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 11px 12px;
            border: none;
            background: transparent;
            border-radius: 7px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            text-align: left;
            font-family: Arial, sans-serif;
        }

        .menu-acciones-contenido a {
            color: #555;
        }

        .menu-acciones-contenido a:hover {
            background: #f3e5f5;
            color: #6a1b9a;
        }

        .btn-eliminar {
            color: #d32f2f;
        }

        .btn-eliminar:hover {
            background: #ffebee !important;
            color: #b71c1c !important;
        }

        .btn-eliminar i {
            color: #d32f2f;
        }

        /* =========================
           CONTENIDO
        ========================= */

        .bien-contenido {
            padding: 20px;
        }

        .bien-nombre {
            margin: 0 0 10px;
            color: #6a1b9a;
            font-size: 20px;
        }

        .bien-descripcion {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            min-height: 42px;
            margin-bottom: 18px;
        }

        .bien-datos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .bien-precio {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .bien-cantidad {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #6a1b9a;
            font-weight: bold;
            font-size: 14px;
        }

        /* =========================
           SIN RESULTADOS
        ========================= */

        .sin-resultados {
            background: white;
            padding: 40px 20px;
            border-radius: 12px;
            text-align: center;
            color: #777;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07);
            grid-column: 1 / -1;
        }

        .sin-resultados i {
            font-size: 40px;
            color: #6a1b9a;
            margin-bottom: 12px;
        }

        .sin-resultados h3 {
            margin: 5px 0;
            color: #555;
        }

        /* =========================
           MODAL ELIMINAR
        ========================= */

        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.55);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.activo {
            display: flex;
        }

        .modal-contenido {
            width: 100%;
            max-width: 400px;
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            animation: aparecerModal 0.25s ease;
        }

        .modal-icono {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background-color: #f8d7da;
            color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .modal-contenido h2 {
            color: #333;
            margin: 10px 0;
        }

        .modal-contenido p {
            color: #666;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .modal-botones {
            display: flex;
            gap: 12px;
        }

        .boton-cancelar,
        .boton-confirmar {
            flex: 1;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .boton-cancelar {
            background-color: #e9e9e9;
            color: #555;
        }

        .boton-cancelar:hover {
            background-color: #d5d5d5;
        }

        .boton-confirmar {
            background-color: #dc3545;
            color: white;
        }

        .boton-confirmar:hover {
            background-color: #b02a37;
        }

        @keyframes aparecerModal {

            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }

        }

        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 950px) {

            .bienes-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .barra-superior {
                padding: 15px 5%;
            }
        }

        @media (max-width: 650px) {

            .barra-superior {
                flex-direction: column;
                gap: 13px;
                text-align: center;
            }

            .titulo-barra {
                font-size: 19px;
            }

            .btn-regresar {
                width: 100%;
                justify-content: center;
            }

            .contenedor {
                width: 94%;
                margin: 30px auto;
            }

            .encabezado h1 {
                font-size: 30px;
            }

            .bienes-grid {
                grid-template-columns: 1fr;
            }

            .bien-imagen {
                height: 230px;
            }

            .btn-agregar {
                width: 100%;
                justify-content: center;
            }

            .contenedor-busqueda {
                flex-direction: column;
                align-items: stretch;
            }

            .boton-filtro {
                width: 100%;
            }

            .menu-filtro {
                width: 100%;
                right: auto;
                left: 0;
            }

            .modal-botones {
                flex-direction: column;
            }

        }

        @media (max-width: 400px) {

            .encabezado h1 {
                font-size: 26px;
            }

            .encabezado p {
                font-size: 14px;
            }

            .bien-contenido {
                padding: 17px;
            }

            .bien-nombre {
                font-size: 18px;
            }

            .bien-datos {
                flex-direction: column;
                align-items: flex-start;
            }
        }

    </style>

</head>

<body>

    <!-- =========================
         BARRA SUPERIOR
    ========================= -->

    <header class="barra-superior">

        <div class="titulo-barra">

            <i class="fa-solid fa-box"></i>

            Inventario de Bienes

        </div>

        <a
            href="{{ route('admin.inventario') }}"
            class="btn-regresar"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Regresar

        </a>

    </header>


    <!-- =========================
         CONTENIDO
    ========================= -->

    <main class="contenedor">

        <div class="encabezado">

            <h1>
                Inventario de Bienes
            </h1>

            <p>
                Consulta y administra los bienes registrados.
            </p>

        </div>


        <!-- =========================
             AGREGAR
        ========================= -->

        <div class="zona-agregar">

            <a
                href="{{ route('admin.agregar_bien') }}"
                class="btn-agregar"
            >

                <i class="fa-solid fa-plus"></i>

                Agregar

            </a>

        </div>


        <!-- =========================
             BUSCADOR Y FILTRO
        ========================= -->

        <div class="contenedor-busqueda">

            <div class="buscador">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    id="buscadorBienes"
                    placeholder="Buscar bien por nombre..."
                    autocomplete="off"
                >

            </div>


            <div class="filtro">

                <button
                    type="button"
                    class="boton-filtro"
                    id="botonFiltro"
                >

                    <i class="fa-solid fa-arrow-down-a-z"></i>

                    Ordenar

                </button>


                <div
                    class="menu-filtro"
                    id="menuFiltro"
                >

                    <button
                        type="button"
                        id="ordenAscendente"
                    >

                        <i class="fa-solid fa-arrow-down-a-z"></i>

                        Nombre: A → Z

                    </button>


                    <button
                        type="button"
                        id="ordenDescendente"
                    >

                        <i class="fa-solid fa-arrow-up-z-a"></i>

                        Nombre: Z → A

                    </button>

                </div>

            </div>

        </div>


        <!-- =========================
             BIENES
        ========================= -->

        <div
            class="bienes-grid"
            id="listaBienes"
        >

            @forelse($bienes as $bien)

                <article
                    class="bien-card"
                    data-nombre="{{ strtolower($bien->nombre) }}"
                >

                    <!-- =========================
                         FOTO
                    ========================= -->

                    <div class="bien-imagen">

                        @if($bien->foto)

                            <img
                                src="{{ asset('storage/' . $bien->foto) }}"
                                alt="{{ $bien->nombre }}"
                            >

                        @else

                            <div class="imagen-sin-foto">

                                <i class="fa-regular fa-image"></i>

                                <span>
                                    Sin imagen
                                </span>

                            </div>

                        @endif


                        <!-- =========================
                             TRES PUNTOS
                        ========================= -->

                        <div class="menu-acciones">

                            <button
                                type="button"
                                class="boton-acciones"
                                title="Opciones"
                            >

                                <i class="fa-solid fa-ellipsis-vertical"></i>

                            </button>


                            <div class="menu-acciones-contenido">

                                <!-- EDITAR -->

                                <a
                                    href="{{ route('admin.inventario.editar', $bien->id) }}"
                                >

                                    <i class="fa-solid fa-pen"></i>

                                    Editar

                                </a>


                                <!-- ELIMINAR -->

                                <button
                                    type="button"
                                    class="btn-eliminar"
                                    onclick="abrirModalEliminar(
                                        {{ $bien->id }},
                                        @js($bien->nombre)
                                    )"
                                >

                                    <i class="fa-solid fa-trash"></i>

                                    Eliminar

                                </button>

                            </div>

                        </div>

                    </div>


                    <!-- =========================
                         INFORMACIÓN
                    ========================= -->

                    <div class="bien-contenido">

                        <h2 class="bien-nombre">

                            {{ $bien->nombre }}

                        </h2>


                        <p class="bien-descripcion">

                            {{ $bien->descripcion ?: 'Sin descripción disponible.' }}

                        </p>


                        <div class="bien-datos">

                            <span class="bien-precio">

                                <i class="fa-solid fa-dollar-sign"></i>

                                {{ number_format($bien->precio, 2) }}

                            </span>


                            <span class="bien-cantidad">

                                <i class="fa-solid fa-boxes-stacked"></i>

                                Cantidad: {{ $bien->cantidad }}

                            </span>

                        </div>

                    </div>

                </article>

            @empty

                <div
                    class="sin-resultados"
                    id="sinBienes"
                >

                    <i class="fa-solid fa-box-open"></i>

                    <h3>
                        No hay bienes registrados
                    </h3>

                    <p>
                        Todavía no has agregado ningún bien al inventario.
                    </p>

                </div>

            @endforelse


            <!-- =========================
                 SIN RESULTADOS DE BÚSQUEDA
            ========================= -->

            <div
                class="sin-resultados"
                id="sinResultados"
                style="display: none;"
            >

                <i class="fa-solid fa-box-open"></i>

                <h3>
                    No se encontraron bienes
                </h3>

                <p>
                    Intenta buscar utilizando otro nombre.
                </p>

            </div>

        </div>

    </main>


    <!-- =========================
         MODAL ELIMINAR BIEN
    ========================= -->

    <div
        id="modalEliminar"
        class="modal"
    >

        <div class="modal-contenido">

            <div class="modal-icono">

                <i class="fa-solid fa-trash"></i>

            </div>


            <h2>
                Eliminar bien
            </h2>


            <p id="mensajeEliminar">

                ¿Estás seguro de que deseas eliminar este bien?

            </p>


            <form
                id="formEliminar"
                method="POST"
            >

                @csrf

                @method('DELETE')


                <div class="modal-botones">

                    <!-- CANCELAR -->

                    <button
                        type="button"
                        class="boton-cancelar"
                        onclick="cerrarModalEliminar()"
                    >

                        Cancelar

                    </button>


                    <!-- CONFIRMAR -->

                    <button
                        type="submit"
                        class="boton-confirmar"
                    >

                        <i class="fa-solid fa-trash"></i>

                        Sí, eliminar

                    </button>

                </div>

            </form>

        </div>

    </div>


    <!-- =========================
         JAVASCRIPT
    ========================= -->

    <script>

        /* =========================
           ELEMENTOS
        ========================= */

        const buscador =
            document.getElementById('buscadorBienes');

        const listaBienes =
            document.getElementById('listaBienes');

        const sinResultados =
            document.getElementById('sinResultados');

        const botonFiltro =
            document.getElementById('botonFiltro');

        const menuFiltro =
            document.getElementById('menuFiltro');

        const ordenAscendente =
            document.getElementById('ordenAscendente');

        const ordenDescendente =
            document.getElementById('ordenDescendente');


        /* =========================
           MENÚ DE TRES PUNTOS
        ========================= */

        const botonesAcciones =
            document.querySelectorAll('.boton-acciones');


        botonesAcciones.forEach(function (boton) {

            boton.addEventListener('click', function (event) {

                event.stopPropagation();

                const menu =
                    this.parentElement.querySelector(
                        '.menu-acciones-contenido'
                    );


                document
                    .querySelectorAll('.menu-acciones-contenido')
                    .forEach(function (otroMenu) {

                        if (otroMenu !== menu) {

                            otroMenu.classList.remove('activo');

                        }

                    });


                menu.classList.toggle('activo');

            });

        });


        /* =========================
           CERRAR MENÚ DE ACCIONES
        ========================= */

        document.addEventListener('click', function () {

            document
                .querySelectorAll('.menu-acciones-contenido')
                .forEach(function (menu) {

                    menu.classList.remove('activo');

                });

        });


        /* =========================
           BUSCADOR
        ========================= */

        if (buscador) {

            buscador.addEventListener(
                'input',
                function () {

                    filtrarBienes();

                }
            );

        }


        function filtrarBienes() {

            const texto =
                buscador.value
                    .toLowerCase()
                    .trim();


            const bienes =
                listaBienes.querySelectorAll('.bien-card');


            let encontrados = 0;


            bienes.forEach(function (bien) {

                const nombre =
                    bien.dataset.nombre
                        .toLowerCase();


                if (nombre.includes(texto)) {

                    bien.style.display = '';

                    encontrados++;

                } else {

                    bien.style.display = 'none';

                }

            });


            if (
                encontrados === 0 &&
                texto !== '' &&
                bienes.length > 0
            ) {

                sinResultados.style.display = 'block';

            } else {

                sinResultados.style.display = 'none';

            }

        }


        /* =========================
           ABRIR FILTRO
        ========================= */

        if (botonFiltro) {

            botonFiltro.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    menuFiltro.classList.toggle('activo');

                }
            );

        }


        /* =========================
           A → Z
        ========================= */

        if (ordenAscendente) {

            ordenAscendente.addEventListener(
                'click',
                function () {

                    ordenarBienes('asc');

                    menuFiltro.classList.remove('activo');

                }
            );

        }


        /* =========================
           Z → A
        ========================= */

        if (ordenDescendente) {

            ordenDescendente.addEventListener(
                'click',
                function () {

                    ordenarBienes('desc');

                    menuFiltro.classList.remove('activo');

                }
            );

        }


        /* =========================
           ORDENAR BIENES
        ========================= */

        function ordenarBienes(tipo) {

            const bienes =
                Array.from(
                    listaBienes.querySelectorAll('.bien-card')
                );


            bienes.sort(function (a, b) {

                const nombreA =
                    a.dataset.nombre
                        .trim()
                        .toLowerCase();

                const nombreB =
                    b.dataset.nombre
                        .trim()
                        .toLowerCase();


                if (tipo === 'asc') {

                    return nombreA.localeCompare(
                        nombreB,
                        'es',
                        {
                            sensitivity: 'base'
                        }
                    );

                }


                return nombreB.localeCompare(
                    nombreA,
                    'es',
                    {
                        sensitivity: 'base'
                    }
                );

            });


            bienes.forEach(function (bien) {

                listaBienes.appendChild(bien);

            });


            filtrarBienes();

        }


        /* =========================
           CERRAR FILTRO AL HACER
           CLIC FUERA
        ========================= */

        document.addEventListener(
            'click',
            function (event) {

                const filtro =
                    document.querySelector('.filtro');


                if (
                    filtro &&
                    !filtro.contains(event.target)
                ) {

                    menuFiltro.classList.remove('activo');

                }

            }
        );


        /* =========================
           MODAL ELIMINAR
        ========================= */

        function abrirModalEliminar(id, nombre) {

            const modal =
                document.getElementById('modalEliminar');

            const formulario =
                document.getElementById('formEliminar');

            const mensaje =
                document.getElementById('mensajeEliminar');


            mensaje.innerHTML =
                '¿Estás seguro de que deseas eliminar el bien <strong>' +
                escapeHtml(nombre) +
                '</strong>?';


            formulario.action =
                "{{ url('/admin/inventario') }}/" + id;


            modal.classList.add('activo');


            /* Cerrar menú de tres puntos */

            document
                .querySelectorAll('.menu-acciones-contenido')
                .forEach(function (menu) {

                    menu.classList.remove('activo');

                });

        }


        /* =========================
           CERRAR MODAL
        ========================= */

        function cerrarModalEliminar() {

            const modal =
                document.getElementById('modalEliminar');


            modal.classList.remove('activo');

        }


        /* =========================
           CERRAR MODAL AL HACER
           CLIC FUERA
        ========================= */

        window.addEventListener(
            'click',
            function (event) {

                const modal =
                    document.getElementById('modalEliminar');


                if (event.target === modal) {

                    cerrarModalEliminar();

                }

            }
        );


        /* =========================
           ESCAPE PARA CERRAR MODAL
        ========================= */

        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {

                    cerrarModalEliminar();

                }

            }
        );


        /* =========================
           SEGURIDAD PARA EL NOMBRE
        ========================= */

        function escapeHtml(text) {

            const div =
                document.createElement('div');

            div.textContent = text;

            return div.innerHTML;

        }

    </script>

</body>

</html>