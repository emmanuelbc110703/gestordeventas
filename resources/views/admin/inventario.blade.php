<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventario - Orquídeas y más Los Amates</title>

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
            background: #f4f4f4;
            color: #333;
        }

        /* =========================
           BARRA SUPERIOR
        ========================== */

        .barra-superior {
            width: 100%;
            background: #6a1b9a;
            color: white;
            padding: 18px 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .titulo-barra {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 22px;
            font-weight: bold;
        }

        .titulo-barra i {
            font-size: 25px;
        }

        .btn-regresar {
            background: white;
            color: #6a1b9a;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-regresar:hover {
            background: #eee;
            transform: translateY(-2px);
        }

        /* =========================
           CONTENEDOR
        ========================== */

        .contenedor {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }

        /* =========================
           ENCABEZADO
        ========================== */

        .encabezado {
            text-align: center;
            margin-bottom: 35px;
        }

        .encabezado h1 {
            color: #6a1b9a;
            margin-bottom: 8px;
            font-size: 35px;
        }

        .encabezado p {
            color: #666;
            font-size: 17px;
        }

        /* =========================
           MENSAJE DE ÉXITO
        ========================== */

        .mensaje-exito {
            background: #d7f0e1;
            color: #187a45;
            border: 1px solid #b8dfc8;
            padding: 14px 18px;
            border-radius: 9px;
            margin-bottom: 25px;
            font-weight: bold;
        }

        /* =========================
           BOTONES PRINCIPALES
        ========================== */

        .opciones-inventario {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .btn-inventario {
            border: 2px solid #6a1b9a;
            padding: 16px 35px;
            border-radius: 10px;
            font-size: 17px;
            font-weight: bold;
            cursor: pointer;
            background: white;
            color: #6a1b9a;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-inventario i {
            margin-right: 8px;
        }

        .btn-inventario:hover,
        .btn-inventario.activo {
            background: #6a1b9a;
            color: white;
            transform: translateY(-3px);
        }

        /* =========================
           FILTROS
        ========================== */

        .filtros-contenedor {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .titulo-filtros {
            color: #6a1b9a;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .titulo-filtros i {
            margin-right: 7px;
        }

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-filtro {
            border: 1px solid #ccc;
            background: white;
            color: #555;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.25s;
        }

        .btn-filtro i {
            margin-right: 6px;
        }

        .btn-filtro:hover {
            border-color: #6a1b9a;
            color: #6a1b9a;
        }

        .btn-filtro.activo {
            background: #6a1b9a;
            color: white;
            border-color: #6a1b9a;
        }

        /* =========================
           BUSCADOR
        ========================== */

        .buscador-contenedor {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
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
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
        }

        .buscador input:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.08);
        }

        /* =========================
           TABLA
        ========================== */

        .tabla-contenedor {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        thead {
            background: #6a1b9a;
            color: white;
        }

        th {
            padding: 16px;
            text-align: left;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        tbody tr {
            transition: 0.2s;
        }

        tbody tr:hover {
            background: #f8f1fb;
        }

        /* =========================
           FOTO
        ========================== */

        .foto-producto {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            background: #eee;
            display: block;
        }

        .foto-sin-imagen {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            background: #eee;
            color: #999;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        /* =========================
           NOMBRE
        ========================== */

        .nombre-producto {
            color: #6a1b9a;
            font-weight: bold;
        }

        /* =========================
           PRECIO
        ========================== */

        .precio {
            font-weight: bold;
            color: #333;
        }

        /* =========================
           CANTIDAD
        ========================== */

        .cantidad {
            font-weight: bold;
            color: #555;
        }

        /* =========================
           TIPO
        ========================== */

        .tipo {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            display: inline-block;
        }

        .bien {
            background: #e8d5f5;
            color: #6a1b9a;
        }

        .servicio {
            background: #d7f0e1;
            color: #187a45;
        }

        /* =========================
           SIN REGISTROS
        ========================== */

        .sin-registros {
            text-align: center;
            padding: 50px 20px;
            color: #777;
        }

        .sin-registros i {
            font-size: 45px;
            color: #6a1b9a;
            margin-bottom: 15px;
        }

        .sin-registros h3 {
            margin: 5px 0 8px;
            color: #555;
        }

        .sin-registros p {
            margin: 0;
        }

        /* =========================
           SIN RESULTADOS
        ========================== */

        .sin-resultados {
            display: none;
            background: white;
            padding: 40px 20px;
            border-radius: 12px;
            text-align: center;
            color: #777;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
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

        .sin-resultados p {
            margin: 5px 0 0;
        }

        /* =========================
           RESPONSIVO
        ========================== */

        @media (max-width: 700px) {

            .barra-superior {
                padding: 15px 5%;
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .titulo-barra {
                font-size: 19px;
            }

            .btn-regresar {
                width: 100%;
                text-align: center;
            }

            .contenedor {
                width: 94%;
                margin: 30px auto;
            }

            .encabezado h1 {
                font-size: 30px;
            }

            .encabezado p {
                font-size: 15px;
            }

            .opciones-inventario {
                flex-direction: column;
                gap: 12px;
            }

            .btn-inventario {
                width: 100%;
            }

            .filtros {
                flex-direction: column;
            }

            .btn-filtro {
                width: 100%;
            }

            .buscador-contenedor {
                padding: 15px;
            }
        }

        @media (max-width: 400px) {

            .encabezado h1 {
                font-size: 26px;
            }

            .btn-inventario {
                padding: 14px 15px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- =========================
         BARRA SUPERIOR
    ========================== -->

    <div class="barra-superior">

        <div class="titulo-barra">
            <i class="fa-solid fa-boxes-stacked"></i>
            Gestión de Inventario
        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="btn-regresar"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>

    </div>


    <!-- =========================
         CONTENIDO
    ========================== -->

    <main class="contenedor">

        <!-- ENCABEZADO -->

        <div class="encabezado">

            <h1>
                <i class="fa-solid fa-boxes-stacked"></i>
                Inventario
            </h1>

            <p>
                Administra y consulta los bienes y servicios disponibles.
            </p>

        </div>


        <!-- =========================
             MENSAJE DE ÉXITO
        ========================== -->

        @if(session('success'))

            <div class="mensaje-exito">

                <i class="fa-solid fa-circle-check"></i>

                {{ session('success') }}

            </div>

        @endif


        <!-- =========================
             BOTONES
        ========================== -->

        <div class="opciones-inventario">

            <a
                href="{{ route('admin.bienes') }}"
                class="btn-inventario"
            >
                <i class="fa-solid fa-box"></i>
                Bienes
            </a>

            <a
                href="{{ route('admin.servicios') }}"
                class="btn-inventario"
            >
                <i class="fa-solid fa-screwdriver-wrench"></i>
                Servicios
            </a>

        </div>


        <!-- =========================
             FILTROS
        ========================== -->

        <div class="filtros-contenedor">

            <div class="titulo-filtros">

                <i class="fa-solid fa-filter"></i>

                Filtrar inventario

            </div>

            <div class="filtros">

                <!-- TODOS -->

                <button
                    type="button"
                    class="btn-filtro activo"
                    data-tipo="todos"
                    id="filtroTodos"
                >
                    <i class="fa-solid fa-list"></i>
                    Todos
                </button>


                <!-- BIENES -->

                <button
                    type="button"
                    class="btn-filtro"
                    data-tipo="bien"
                >
                    <i class="fa-solid fa-box"></i>
                    Solo bienes
                </button>


                <!-- SERVICIOS -->

                <button
                    type="button"
                    class="btn-filtro"
                    data-tipo="servicio"
                >
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Solo servicios
                </button>


                <!-- A-Z -->

                <button
                    type="button"
                    class="btn-filtro activo"
                    id="ordenAZ"
                >
                    <i class="fa-solid fa-arrow-down-a-z"></i>
                    A → Z
                </button>


                <!-- Z-A -->

                <button
                    type="button"
                    class="btn-filtro"
                    id="ordenZA"
                >
                    <i class="fa-solid fa-arrow-down-z-a"></i>
                    Z → A
                </button>

            </div>

        </div>


        <!-- =========================
             BUSCADOR
        ========================== -->

        <div class="buscador-contenedor">

            <div class="buscador">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    id="buscadorInventario"
                    placeholder="Buscar en el inventario por nombre..."
                    autocomplete="off"
                >

            </div>

        </div>


        <!-- =========================
             TABLA
        ========================== -->

        <div class="tabla-contenedor">

            <table>

                <thead>

                    <tr>

                        <th>Foto</th>

                        <th>Nombre</th>

                        <th>Descripción</th>

                        <th>Precio</th>

                        <th>Cantidad</th>

                        <th>Tipo de inventario</th>

                    </tr>

                </thead>


                <tbody id="tablaInventario">

                    @forelse($inventarios as $inventario)

                        <tr
                            class="fila-inventario"
                            data-nombre="{{ strtolower($inventario->nombre) }}"
                            data-tipo="{{ $inventario->tipo }}"
                        >

                            <!-- FOTO -->

                            <td>

                                @if($inventario->foto)

                                    <img
                                        src="{{ asset('storage/' . $inventario->foto) }}"
                                        alt="{{ $inventario->nombre }}"
                                        class="foto-producto"
                                    >

                                @else

                                    <div class="foto-sin-imagen">

                                        <i class="fa-solid fa-image"></i>

                                    </div>

                                @endif

                            </td>


                            <!-- NOMBRE -->

                            <td>

                                <span class="nombre-producto">

                                    {{ $inventario->nombre }}

                                </span>

                            </td>


                            <!-- DESCRIPCIÓN -->

                            <td>

                                {{ $inventario->descripcion ?: 'Sin descripción' }}

                            </td>


                            <!-- PRECIO -->

                            <td>

                                <span class="precio">

                                    ${{ number_format($inventario->precio, 2) }}

                                </span>

                            </td>


                            <!-- CANTIDAD -->

                            <td>

                                <span class="cantidad">

                                    {{ $inventario->cantidad }}

                                </span>

                            </td>


                            <!-- TIPO -->

                            <td>

                                @if($inventario->tipo === 'bien')

                                    <span class="tipo bien">

                                        <i class="fa-solid fa-box"></i>

                                        Bien

                                    </span>

                                @elseif($inventario->tipo === 'servicio')

                                    <span class="tipo servicio">

                                        <i class="fa-solid fa-screwdriver-wrench"></i>

                                        Servicio

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr id="filaSinRegistros">

                            <td colspan="6">

                                <div class="sin-registros">

                                    <i class="fa-solid fa-box-open"></i>

                                    <h3>
                                        No hay registros en el inventario
                                    </h3>

                                    <p>
                                        Agrega un bien o servicio para que aparezca aquí.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- =========================
             SIN RESULTADOS
        ========================== -->

        <div
            class="sin-resultados"
            id="sinResultados"
        >

            <i class="fa-solid fa-box-open"></i>

            <h3>
                No se encontraron resultados
            </h3>

            <p>
                Intenta cambiar el filtro o realizar otra búsqueda.
            </p>

        </div>

    </main>


    <!-- =========================
         FILTROS + BUSCADOR + ORDEN
    ========================== -->

    <script>

        const buscador = document.getElementById('buscadorInventario');

        const tabla = document.getElementById('tablaInventario');

        const sinResultados = document.getElementById('sinResultados');

        const botonesTipo = document.querySelectorAll('[data-tipo]');

        const botonAZ = document.getElementById('ordenAZ');

        const botonZA = document.getElementById('ordenZA');


        /*
        |--------------------------------------------------------------------------
        | VARIABLES DE FILTRO
        |--------------------------------------------------------------------------
        */

        let tipoSeleccionado = 'todos';

        let ordenSeleccionado = 'az';


        /*
        |--------------------------------------------------------------------------
        | OBTENER FILAS
        |--------------------------------------------------------------------------
        */

        function obtenerFilas() {

            return Array.from(
                document.querySelectorAll('.fila-inventario')
            );

        }


        /*
        |--------------------------------------------------------------------------
        | APLICAR TODOS LOS FILTROS
        |--------------------------------------------------------------------------
        */

        function aplicarFiltros() {

            const filas = obtenerFilas();

            const texto = buscador.value
                .toLowerCase()
                .trim();


            /*
            |--------------------------------------------------------------------------
            | ORDENAR
            |--------------------------------------------------------------------------
            */

            filas.sort(function(a, b) {

                const nombreA = a.dataset.nombre;

                const nombreB = b.dataset.nombre;


                if (ordenSeleccionado === 'az') {

                    return nombreA.localeCompare(
                        nombreB,
                        'es',
                        {
                            sensitivity: 'base'
                        }
                    );

                } else {

                    return nombreB.localeCompare(
                        nombreA,
                        'es',
                        {
                            sensitivity: 'base'
                        }
                    );

                }

            });


            /*
            |--------------------------------------------------------------------------
            | VOLVER A INSERTAR LAS FILAS ORDENADAS
            |--------------------------------------------------------------------------
            */

            filas.forEach(function(fila) {

                tabla.appendChild(fila);

            });


            /*
            |--------------------------------------------------------------------------
            | FILTRAR
            |--------------------------------------------------------------------------
            */

            let encontrados = 0;


            filas.forEach(function(fila) {

                const nombre = fila.dataset.nombre;

                const tipo = fila.dataset.tipo;


                /*
                | Comprobar tipo
                */

                const coincideTipo =
                    tipoSeleccionado === 'todos' ||
                    tipo === tipoSeleccionado;


                /*
                | Comprobar búsqueda
                */

                const coincideBusqueda =
                    nombre.includes(texto);


                /*
                | Mostrar u ocultar
                */

                if (coincideTipo && coincideBusqueda) {

                    fila.style.display = '';

                    encontrados++;

                } else {

                    fila.style.display = 'none';

                }

            });


            /*
            |--------------------------------------------------------------------------
            | MENSAJE SIN RESULTADOS
            |--------------------------------------------------------------------------
            */

            if (encontrados === 0 && filas.length > 0) {

                sinResultados.style.display = 'block';

            } else {

                sinResultados.style.display = 'none';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | FILTROS DE TIPO
        |--------------------------------------------------------------------------
        */

        botonesTipo.forEach(function(boton) {

            boton.addEventListener('click', function() {

                tipoSeleccionado = this.dataset.tipo;


                /*
                | Quitar activo de todos los filtros de tipo
                */

                botonesTipo.forEach(function(btn) {

                    btn.classList.remove('activo');

                });


                /*
                | Activar botón seleccionado
                */

                this.classList.add('activo');


                aplicarFiltros();

            });

        });


        /*
        |--------------------------------------------------------------------------
        | A → Z
        |--------------------------------------------------------------------------
        */

        botonAZ.addEventListener('click', function() {

            ordenSeleccionado = 'az';

            botonAZ.classList.add('activo');

            botonZA.classList.remove('activo');

            aplicarFiltros();

        });


        /*
        |--------------------------------------------------------------------------
        | Z → A
        |--------------------------------------------------------------------------
        */

        botonZA.addEventListener('click', function() {

            ordenSeleccionado = 'za';

            botonZA.classList.add('activo');

            botonAZ.classList.remove('activo');

            aplicarFiltros();

        });


        /*
        |--------------------------------------------------------------------------
        | BUSCADOR
        |--------------------------------------------------------------------------
        */

        buscador.addEventListener('input', function() {

            aplicarFiltros();

        });


        /*
        |--------------------------------------------------------------------------
        | INICIAR
        |--------------------------------------------------------------------------
        */

        aplicarFiltros();

    </script>

</body>

</html>