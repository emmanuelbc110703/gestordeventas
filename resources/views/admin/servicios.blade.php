<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventario de Servicios - Orquídeas y más Los Amates</title>

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
           CONTENEDOR
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
           BUSCADOR
        ========================= */

        .buscador-contenedor {
            background: white;
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07);
            margin-bottom: 30px;
        }

        .buscador {
            position: relative;
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
           TARJETAS
        ========================= */

        .servicios-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .servicio-card {
            background: white;
            border-radius: 14px;
            overflow: visible;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .servicio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.13);
        }


        /* =========================
           IMAGEN
        ========================= */

        .servicio-imagen {
            width: 100%;
            height: 210px;
            background: #eee;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-radius: 14px 14px 0 0;
        }

        .servicio-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sin-imagen-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            height: 100%;
            color: #888;
        }

        .sin-imagen-card i {
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

        .servicio-contenido {
            padding: 20px;
        }

        .servicio-nombre {
            margin: 0 0 10px;
            color: #6a1b9a;
            font-size: 20px;
        }

        .servicio-descripcion {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            min-height: 42px;
            margin-bottom: 18px;
        }

        .servicio-datos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .servicio-precio {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .servicio-cantidad {
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
            display: none;
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
           MENSAJE DE ÉXITO
        ========================= */

        .mensaje-exito {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
            padding: 14px 18px;
            border-radius: 9px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: bold;
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

            .servicios-grid {
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

            .servicios-grid {
                grid-template-columns: 1fr;
            }

            .servicio-imagen {
                height: 230px;
            }

            .btn-agregar {
                width: 100%;
                justify-content: center;
            }

            .sin-resultados {
                grid-column: auto;
            }

        }

        @media (max-width: 400px) {

            .encabezado h1 {
                font-size: 26px;
            }

            .encabezado p {
                font-size: 14px;
            }

            .servicio-contenido {
                padding: 17px;
            }

            .servicio-nombre {
                font-size: 18px;
            }

            .servicio-datos {
                flex-direction: column;
                align-items: flex-start;
            }

            .modal-botones {
                flex-direction: column;
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

            <i class="fa-solid fa-screwdriver-wrench"></i>

            Inventario de Servicios

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


        <!-- ENCABEZADO -->

        <div class="encabezado">

            <h1>

                <i class="fa-solid fa-screwdriver-wrench"></i>

                Inventario de Servicios

            </h1>


            <p>

                Consulta y administra los servicios registrados.

            </p>

        </div>



        <!-- MENSAJE DE ÉXITO -->

        @if(session('success'))

            <div class="mensaje-exito">

                <i class="fa-solid fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif



        <!-- AGREGAR SERVICIO -->

        <div class="zona-agregar">

            <a
                href="{{ route('admin.agregar_servicio') }}"
                class="btn-agregar"
            >

                <i class="fa-solid fa-plus"></i>

                Agregar

            </a>

        </div>



        <!-- =========================
             BUSCADOR
        ========================= -->

        <div class="buscador-contenedor">

            <div class="buscador">

                <i class="fa-solid fa-magnifying-glass"></i>


                <input
                    type="text"
                    id="buscadorServicios"
                    placeholder="Buscar servicio por nombre..."
                    autocomplete="off"
                >

            </div>

        </div>



        <!-- =========================
             SERVICIOS
        ========================= -->

        <div
            class="servicios-grid"
            id="listaServicios"
        >


            @forelse($servicios as $servicio)


                <article
                    class="servicio-card"
                    data-nombre="{{ strtolower($servicio->nombre) }}"
                >


                    <!-- =========================
                         IMAGEN
                    ========================= -->

                    <div class="servicio-imagen">


                        @if($servicio->foto)

                            <img
                                src="{{ asset('storage/' . $servicio->foto) }}"
                                alt="{{ $servicio->nombre }}"
                            >

                        @else

                            <div class="sin-imagen-card">

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
                                    href="{{ route('admin.inventario.editar', $servicio->id) }}"
                                >

                                    <i class="fa-solid fa-pen"></i>

                                    Editar

                                </a>



                                <!-- ELIMINAR -->

                                <button
                                    type="button"
                                    class="btn-eliminar"
                                    onclick="abrirModalEliminar(
                                        {{ $servicio->id }},
                                        @js($servicio->nombre)
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

                    <div class="servicio-contenido">


                        <h2 class="servicio-nombre">

                            {{ $servicio->nombre }}

                        </h2>



                        <p class="servicio-descripcion">

                            @if($servicio->descripcion)

                                {{ $servicio->descripcion }}

                            @else

                                Sin descripción disponible.

                            @endif

                        </p>



                        <div class="servicio-datos">


                            <!-- PRECIO -->

                            <span class="servicio-precio">

                                <i class="fa-solid fa-dollar-sign"></i>

                                {{ number_format($servicio->precio, 2) }}

                            </span>



                            <!-- CANTIDAD -->

                            <span class="servicio-cantidad">

                                <i class="fa-solid fa-boxes-stacked"></i>

                                Cantidad: {{ $servicio->cantidad }}

                            </span>


                        </div>


                    </div>


                </article>


            @empty


                <!-- NO EXISTEN SERVICIOS -->

                <div
                    class="sin-resultados"
                    id="sinServicios"
                    style="display: block;"
                >

                    <i class="fa-solid fa-screwdriver-wrench"></i>


                    <h3>

                        No existen servicios registrados

                    </h3>


                    <p>

                        Agrega un servicio para comenzar a llenar el inventario.

                    </p>

                </div>


            @endforelse



            <!-- =========================
                 SIN RESULTADOS DE BÚSQUEDA
            ========================= -->

            @if($servicios->count() > 0)

                <div
                    class="sin-resultados"
                    id="sinResultados"
                >

                    <i class="fa-solid fa-magnifying-glass"></i>


                    <h3>

                        No se encontraron servicios

                    </h3>


                    <p>

                        Intenta buscar utilizando otro nombre.

                    </p>

                </div>

            @endif


        </div>

    </main>



    <!-- =========================
         MODAL ELIMINAR SERVICIO
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

                Eliminar servicio

            </h2>



            <p id="mensajeEliminar">

                ¿Estás seguro de que deseas eliminar este servicio?

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
            document.getElementById('buscadorServicios');


        const listaServicios =
            document.getElementById('listaServicios');


        const sinResultados =
            document.getElementById('sinResultados');



        /* =========================
           MENÚ DE TRES PUNTOS
        ========================= */

        const botonesAcciones =
            document.querySelectorAll('.boton-acciones');


        botonesAcciones.forEach(function (boton) {


            boton.addEventListener(
                'click',
                function (event) {


                    event.stopPropagation();


                    const menu =
                        this.parentElement.querySelector(
                            '.menu-acciones-contenido'
                        );



                    /* CERRAR LOS DEMÁS MENÚS */

                    document
                        .querySelectorAll('.menu-acciones-contenido')
                        .forEach(function (otroMenu) {


                            if (otroMenu !== menu) {

                                otroMenu.classList.remove('activo');

                            }

                        });



                    /* ABRIR / CERRAR ESTE MENÚ */

                    menu.classList.toggle('activo');


                }
            );


        });



        /* =========================
           CERRAR MENÚ AL HACER
           CLIC AFUERA
        ========================= */

        document.addEventListener(
            'click',
            function () {


                document
                    .querySelectorAll('.menu-acciones-contenido')
                    .forEach(function (menu) {

                        menu.classList.remove('activo');

                    });


            }
        );



        /* =========================
           BUSCADOR
        ========================= */

        if (buscador) {


            buscador.addEventListener(
                'input',
                function () {

                    filtrarServicios();

                }
            );


        }



        function filtrarServicios() {


            const texto =
                buscador.value
                    .toLowerCase()
                    .trim();



            const servicios =
                listaServicios.querySelectorAll(
                    '.servicio-card'
                );



            let encontrados = 0;



            servicios.forEach(function (servicio) {


                const nombre =
                    servicio.dataset.nombre
                        .toLowerCase();



                if (nombre.includes(texto)) {


                    servicio.style.display = '';

                    encontrados++;


                } else {


                    servicio.style.display = 'none';


                }


            });



            /* MOSTRAR MENSAJE */

            if (sinResultados) {


                if (
                    encontrados === 0 &&
                    texto !== '' &&
                    servicios.length > 0
                ) {

                    sinResultados.style.display = 'block';

                } else {

                    sinResultados.style.display = 'none';

                }


            }


        }



        /* =========================
           ABRIR MODAL ELIMINAR
        ========================= */

        function abrirModalEliminar(id, nombre) {


            const modal =
                document.getElementById('modalEliminar');


            const formulario =
                document.getElementById('formEliminar');


            const mensaje =
                document.getElementById('mensajeEliminar');



            /* MENSAJE */

            mensaje.innerHTML =
                '¿Estás seguro de que deseas eliminar el servicio <strong>' +
                nombre +
                '</strong>?';



            /* RUTA PARA ELIMINAR */

            formulario.action =
                "{{ url('/admin/inventario') }}/" + id;



            /* CERRAR MENÚ DE TRES PUNTOS */

            document
                .querySelectorAll('.menu-acciones-contenido')
                .forEach(function (menu) {

                    menu.classList.remove('activo');

                });



            /* MOSTRAR MODAL */

            modal.classList.add('activo');


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


    </script>

</body>

</html>