<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clientes - Gestor de Ventas Los Amates</title>

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
        }


        /* =========================
           ENCABEZADO
        ========================= */

        .encabezado {
            background-color: #6a1b9a;
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
        }

        .encabezado h1 {
            margin: 5px 0;
        }

        .encabezado p {
            margin: 5px 0;
        }

        .boton-regresar {
            position: absolute;
            top: 20px;
            left: 25px;
            background-color: white;
            color: #6a1b9a;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .boton-regresar:hover {
            background-color: #4a126d;
            color: white;
        }


        /* =========================
           CONTENEDOR
        ========================= */

        .contenedor {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }


        /* =========================
           BOTÓN AGREGAR
        ========================= */

        .contenedor-agregar {
            margin-bottom: 25px;
        }

        .boton-agregar {
            display: inline-block;
            background-color: #6a1b9a;
            color: white;
            text-decoration: none;
            padding: 13px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .boton-agregar:hover {
            background-color: #4a126d;
            transform: translateY(-2px);
        }

        .boton-agregar i {
            margin-right: 8px;
        }


        /* =========================
           BUSCADOR Y FILTRO
        ========================= */

        .contenedor-busqueda {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 25px;
        }

        .buscador {
            position: relative;
            flex: 1;
        }

        .buscador > i {
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
            outline: none;
            font-size: 15px;
        }

        .buscador input:focus {
            border-color: #6a1b9a;
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
           TABLA
        ========================= */

        .tabla-contenedor {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        thead {
            background-color: #6a1b9a;
            color: white;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-size: 14px;
        }

        td {
            color: #444;
            font-size: 14px;
        }

        tbody tr:hover {
            background-color: #f8f0fb;
        }


        /* =========================
           AVATAR
        ========================= */

        .avatar-tabla {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            overflow: hidden;
        }

        .avatar-tabla img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        /* =========================
           ACCIONES
        ========================= */

        .acciones {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .boton-editar,
        .boton-eliminar {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
        }

        .boton-editar {
            background-color: #6a1b9a;
            color: white;
        }

        .boton-editar:hover {
            background-color: #4a126d;
            transform: translateY(-2px);
        }

        .boton-eliminar {
            background-color: #dc3545;
            color: white;
        }

        .boton-eliminar:hover {
            background-color: #b02a37;
            transform: translateY(-2px);
        }


        /* =========================
           SIN CLIENTES / SIN RESULTADOS
        ========================= */

        .sin-clientes {
            text-align: center;
            padding: 40px;
            color: #777;
        }

        .sin-clientes i {
            display: block;
            font-size: 50px;
            color: #6a1b9a;
            margin-bottom: 15px;
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

        @media (max-width: 700px) {

            .boton-regresar {
                position: static;
                display: inline-block;
                margin-bottom: 15px;
            }

            .encabezado {
                padding: 20px;
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

        }

    </style>

</head>


<body>


    <!-- =========================
         ENCABEZADO
    ========================== -->

    <div class="encabezado">

        <a href="{{ route('admin.dashboard') }}"
           class="boton-regresar">

            <i class="fa-solid fa-arrow-left"></i>
            Regresar

        </a>

        <h1>Clientes</h1>

        <p>Administración de clientes registrados</p>

    </div>



    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">


        <!-- AGREGAR CLIENTE -->

        <div class="contenedor-agregar">

            <a href="{{ route('admin.clientes.agregar') }}"
               class="boton-agregar">

                <i class="fa-solid fa-user-plus"></i>
                Agregar cliente

            </a>

        </div>



        <!-- =========================
             BUSCADOR Y FILTRO
        ========================== -->

        <div class="contenedor-busqueda">

            <!-- BUSCADOR -->

            <div class="buscador">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    id="buscadorClientes"
                    placeholder="Buscar cliente por nombre, apellido o correo..."
                >

            </div>


            <!-- FILTRO -->

            <div class="filtro">

                <button
                    type="button"
                    class="boton-filtro"
                    id="botonFiltro"
                >

                    <i class="fa-solid fa-arrow-down-a-z"></i>
                    Ordenar

                </button>


                <div class="menu-filtro" id="menuFiltro">

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
             TABLA
        ========================== -->

        <div class="tabla-contenedor">

            @if($clientes->count() > 0)

                <table id="tablaClientes">

                    <thead>

                        <tr>

                            <th>Perfil</th>
                            <th>Nombre completo</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Fecha de nacimiento</th>
                            <th>Compras realizadas</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($clientes as $cliente)

                            <tr>


                                <!-- PERFIL -->

                                <td>

                                    <div
                                        class="avatar-tabla"
                                        style="background-color: {{ $cliente->color_perfil ?? '#6a1b9a' }};"
                                    >

                                        @if($cliente->foto_perfil)

                                            <img
                                                src="{{ asset('storage/' . $cliente->foto_perfil) }}"
                                                alt="Foto de {{ $cliente->name }}"
                                            >

                                        @else

                                            {{ strtoupper(substr($cliente->name, 0, 1)) }}

                                        @endif

                                    </div>

                                </td>



                                <!-- NOMBRE -->

                                <td>

                                    {{ $cliente->name }}
                                    {{ $cliente->apellido }}

                                </td>



                                <!-- CORREO -->

                                <td>

                                    {{ $cliente->email }}

                                </td>



                                <!-- TELÉFONO -->

                                <td>

                                    {{ $cliente->telefono ?? 'No registrado' }}

                                </td>



                                <!-- DIRECCIÓN -->

                                <td>

                                    {{ $cliente->direccion ?? 'No registrada' }}

                                </td>



                                <!-- FECHA DE NACIMIENTO -->

                                <td>

                                    {{ $cliente->fecha_nacimiento ?? 'No registrada' }}

                                </td>



                                <!-- COMPRAS REALIZADAS -->

                                <td>

                                    0

                                </td>



                                <!-- ACCIONES -->

                                <td class="acciones">


                                    <!-- EDITAR -->

                                    <a
                                        href="{{ route('admin.clientes.editar', $cliente->id) }}"
                                        class="boton-editar"
                                    >

                                        <i class="fa-solid fa-pen-to-square"></i>

                                    </a>



                                    <!-- ELIMINAR -->

                                    <button
                                        type="button"
                                        class="boton-eliminar"
                                        onclick="abrirModalEliminar({{ $cliente->id }}, @js($cliente->name))"
                                    >

                                        <i class="fa-solid fa-trash"></i>

                                    </button>


                                </td>


                            </tr>

                        @endforeach

                    </tbody>

                </table>


                <!-- =========================
                     MENSAJE SIN RESULTADOS
                ========================== -->

                <div
                    id="sinResultados"
                    class="sin-clientes"
                    style="display: none;"
                >

                    <i class="fa-solid fa-user-slash"></i>

                    <h3>No se encontró ningún cliente</h3>

                    <p>
                        Intenta buscar con otro nombre, apellido o correo electrónico.
                    </p>

                </div>


            @else

                <!-- SI NO EXISTEN CLIENTES -->

                <div class="sin-clientes">

                    <i class="fa-solid fa-users"></i>

                    <h3>No hay clientes registrados</h3>

                    <p>
                        Aún no existen clientes registrados en el sistema.
                    </p>

                </div>

            @endif

        </div>


    </div>



    <!-- =========================
         MODAL ELIMINAR CLIENTE
    ========================== -->

    <div id="modalEliminar" class="modal">

        <div class="modal-contenido">

            <div class="modal-icono">

                <i class="fa-solid fa-trash"></i>

            </div>


            <h2>Eliminar cliente</h2>


            <p id="mensajeEliminar">

                ¿Estás seguro de que deseas eliminar este cliente?

            </p>


            <form id="formEliminar" method="POST">

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
    ========================== -->

    <script>


        /* =========================
           BUSCADOR
        ========================= */

        const buscador = document.getElementById('buscadorClientes');
        const mensajeSinResultados = document.getElementById('sinResultados');


        if (buscador) {

            buscador.addEventListener('input', function () {

                const texto = this.value.toLowerCase().trim();

                const filas = document.querySelectorAll(
                    '#tablaClientes tbody tr'
                );

                let resultadosEncontrados = 0;


                filas.forEach(function (fila) {

                    const nombre =
                        fila.cells[1].textContent.toLowerCase();

                    const correo =
                        fila.cells[2].textContent.toLowerCase();


                    if (
                        nombre.includes(texto) ||
                        correo.includes(texto)
                    ) {

                        fila.style.display = '';
                        resultadosEncontrados++;

                    } else {

                        fila.style.display = 'none';

                    }

                });


                /* MOSTRAR MENSAJE
                   SI NO EXISTEN RESULTADOS */

                if (
                    resultadosEncontrados === 0 &&
                    texto !== ''
                ) {

                    mensajeSinResultados.style.display = 'block';

                } else {

                    mensajeSinResultados.style.display = 'none';

                }

            });

        }



        /* =========================
           FILTRO
        ========================= */

        const botonFiltro =
            document.getElementById('botonFiltro');

        const menuFiltro =
            document.getElementById('menuFiltro');

        const ordenAscendente =
            document.getElementById('ordenAscendente');

        const ordenDescendente =
            document.getElementById('ordenDescendente');


        if (botonFiltro) {

            botonFiltro.addEventListener(
                'click',
                function () {

                    menuFiltro.classList.toggle('activo');

                }
            );

        }



        /* ORDENAR DE A → Z */

        if (ordenAscendente) {

            ordenAscendente.addEventListener(
                'click',
                function () {

                    ordenarClientes('asc');

                    menuFiltro.classList.remove('activo');

                }
            );

        }



        /* ORDENAR DE Z → A */

        if (ordenDescendente) {

            ordenDescendente.addEventListener(
                'click',
                function () {

                    ordenarClientes('desc');

                    menuFiltro.classList.remove('activo');

                }
            );

        }



        function ordenarClientes(tipo) {

            const tabla =
                document.getElementById('tablaClientes');

            const cuerpo =
                tabla.querySelector('tbody');

            const filas =
                Array.from(
                    cuerpo.querySelectorAll('tr')
                );


            filas.sort(function (a, b) {

                const nombreA =
                    a.cells[1].textContent
                        .trim()
                        .toLowerCase();

                const nombreB =
                    b.cells[1].textContent
                        .trim()
                        .toLowerCase();


                if (tipo === 'asc') {

                    return nombreA.localeCompare(
                        nombreB,
                        'es'
                    );

                } else {

                    return nombreB.localeCompare(
                        nombreA,
                        'es'
                    );

                }

            });


            filas.forEach(function (fila) {

                cuerpo.appendChild(fila);

            });

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
                '¿Estás seguro de que deseas eliminar a <strong>' +
                nombre +
                '</strong>?';


            formulario.action =
                "{{ url('/admin/clientes') }}/" + id;


            modal.classList.add('activo');

        }



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

