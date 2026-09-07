<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Empleados - Gestor de Ventas Los Amates</title>

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
           BUSCADOR
        ========================= */

        .buscador {
            position: relative;
            margin-bottom: 25px;
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
            outline: none;
            font-size: 15px;
        }

        .buscador input:focus {
            border-color: #6a1b9a;
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
            min-width: 850px;
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
           ROL
        ========================= */

        .rol {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .rol-admin {
            background-color: #ede0f5;
            color: #6a1b9a;
        }

        .rol-vendedor {
            background-color: #e1f5e8;
            color: #218838;
        }


        /* =========================
           ACCIONES
        ========================= */

        .acciones {
            display: flex;
            align-items: center;
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
           SIN EMPLEADOS
        ========================= */

        .sin-empleados {
            text-align: center;
            padding: 40px;
            color: #777;
        }

        .sin-empleados i {
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

        <h1>Empleados</h1>

        <p>Administración de administradores y vendedores</p>

    </div>


    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">


        <!-- AGREGAR EMPLEADO -->

        <div class="contenedor-agregar">

            <a href="{{ route('admin.empleados.agregar') }}"
               class="boton-agregar">

                <i class="fa-solid fa-user-plus"></i>
                Agregar empleado

            </a>

        </div>


        <!-- BUSCADOR -->

        <div class="buscador">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="buscadorEmpleados"
                placeholder="Buscar empleado por nombre, apellido o correo..."
            >

        </div>


        <!-- TABLA -->

        <div class="tabla-contenedor">

            @if($empleados->count() > 0)

                <table id="tablaEmpleados">

                    <thead>

                        <tr>

                            <th>Perfil</th>
                            <th>Nombre completo</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($empleados as $empleado)

                            <tr>


                                <!-- PERFIL -->

                                <td>

                                    <div
                                        class="avatar-tabla"
                                        style="background-color: {{ $empleado->color_perfil ?? '#6a1b9a' }};"
                                    >

                                        @if($empleado->foto_perfil)

                                            <img
                                                src="{{ asset('storage/' . $empleado->foto_perfil) }}"
                                                alt="Foto de {{ $empleado->name }}"
                                            >

                                        @else

                                            {{ strtoupper(substr($empleado->name, 0, 1)) }}

                                        @endif

                                    </div>

                                </td>


                                <!-- NOMBRE -->

                                <td>

                                    {{ $empleado->name }}
                                    {{ $empleado->apellido }}

                                </td>


                                <!-- CORREO -->

                                <td>

                                    {{ $empleado->email }}

                                </td>


                                <!-- TELÉFONO -->

                                <td>

                                    {{ $empleado->telefono ?? 'No registrado' }}

                                </td>


                                <!-- ROL -->

                                <td>

                                    @if($empleado->rol === 'admin')

                                        <span class="rol rol-admin">

                                            <i class="fa-solid fa-user-shield"></i>
                                            Administrador

                                        </span>

                                    @elseif($empleado->rol === 'vendedor')

                                        <span class="rol rol-vendedor">

                                            <i class="fa-solid fa-user-tie"></i>
                                            Vendedor

                                        </span>

                                    @endif

                                </td>


                                <!-- ACCIONES -->

                                <td>

                                    <div class="acciones">


                                        <!-- EDITAR -->

                                        <a
    href="{{ route('admin.empleados.editar', $empleado->id) }}"
    class="boton-editar"
    title="Editar empleado"
>
    <i class="fa-solid fa-pen-to-square"></i>
</a>


                                        <!-- ELIMINAR -->

                                        <button
                                            type="button"
                                            class="boton-eliminar"
                                            title="Eliminar empleado"
                                            onclick="abrirModalEliminar(
                                                {{ $empleado->id }},
                                                @js($empleado->name . ' ' . $empleado->apellido)
                                            )"
                                        >

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </div>

                                </td>


                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="sin-empleados">

                    <i class="fa-solid fa-users"></i>

                    <h3>No hay empleados registrados</h3>

                    <p>
                        Actualmente no existen administradores ni vendedores registrados.
                    </p>

                </div>

            @endif

        </div>


    </div>


    <!-- =========================
         MODAL ELIMINAR EMPLEADO
    ========================== -->

    <div id="modalEliminar" class="modal">

        <div class="modal-contenido">

            <div class="modal-icono">

                <i class="fa-solid fa-trash"></i>

            </div>


            <h2>Eliminar empleado</h2>


            <p id="mensajeEliminar">

                ¿Estás seguro de que deseas eliminar este empleado?

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

        const buscador =
            document.getElementById('buscadorEmpleados');


        if (buscador) {

            buscador.addEventListener('input', function () {

                const texto =
                    this.value.toLowerCase().trim();


                const filas =
                    document.querySelectorAll(
                        '#tablaEmpleados tbody tr'
                    );


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

                    } else {

                        fila.style.display = 'none';

                    }

                });

            });

        }


        /* =========================
           ABRIR MODAL
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


            /*
             * La ruta que recibirá el DELETE.
             */

            formulario.action =
                "{{ url('/admin/empleados') }}/" + id;


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
           CERRAR AL HACER CLIC FUERA
        ========================= */

        window.addEventListener('click', function (event) {

            const modal =
                document.getElementById('modalEliminar');


            if (event.target === modal) {

                cerrarModalEliminar();

            }

        });

    </script>


</body>

</html>