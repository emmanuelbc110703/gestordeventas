<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Puntos de venta - Gestor de Ventas Los Amates</title>

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
            padding-bottom: 40px;
        }

        /* =========================
           ENCABEZADO
        ========================== */

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
        ========================== */

        .contenedor {
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
        }

        /* =========================
           BARRA SUPERIOR
        ========================== */

        .barra-superior {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        .barra-superior h2 {
            margin: 0;
            color: #333;
        }

        .boton-crear {
            background-color: #6a1b9a;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }

        .boton-crear:hover {
            background-color: #4a126d;
            transform: translateY(-2px);
        }

        /* =========================
           GRID
        ========================== */

        .lista-puntos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        /* =========================
           TARJETA
        ========================== */

        .tarjeta {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
            transition: 0.3s;
        }

        .tarjeta:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.16);
        }

        /* =========================
           ICONO
        ========================== */

        .icono-punto {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background-color: #ede0f5;
            color: #6a1b9a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
        }

        .tarjeta h3 {
            text-align: center;
            margin: 0 0 20px;
            color: #333;
        }

        /* =========================
           INFORMACIÓN
        ========================== */

        .dato {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            color: #555;
            font-size: 14px;
        }

        .dato:last-child {
            border-bottom: none;
        }

        .dato i {
            width: 20px;
            color: #6a1b9a;
            text-align: center;
        }

        .dato strong {
            color: #333;
        }

        /* =========================
           BOTONES
        ========================== */

        .acciones {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .boton-editar,
        .boton-eliminar {
            flex: 1;
            border: none;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .boton-editar {
            background-color: #ede0f5;
            color: #6a1b9a;
        }

        .boton-editar:hover {
            background-color: #d8bfe5;
        }

        .boton-eliminar {
            background-color: #fdecec;
            color: #dc3545;
        }

        .boton-eliminar:hover {
            background-color: #f8d0d0;
        }

        /* =========================
           SIN PUNTOS DE VENTA
        ========================== */

        .sin-puntos {
            background-color: white;
            border-radius: 15px;
            padding: 50px 25px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
        }

        .sin-puntos i {
            font-size: 55px;
            color: #6a1b9a;
            margin-bottom: 15px;
        }

        .sin-puntos h3 {
            color: #333;
            margin-bottom: 8px;
        }

        .sin-puntos p {
            color: #777;
            margin: 0;
        }

        /* =========================
           MODAL ELIMINAR
        ========================== */

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
        ========================== */

        @media (max-width: 900px) {

            .lista-puntos {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media (max-width: 600px) {

            .encabezado {
                padding: 20px;
            }

            .boton-regresar {
                position: static;
                display: inline-block;
                margin-bottom: 15px;
            }

            .barra-superior {
                flex-direction: column;
                align-items: stretch;
            }

            .barra-superior h2 {
                text-align: center;
            }

            .boton-crear {
                text-align: center;
            }

            .lista-puntos {
                grid-template-columns: 1fr;
            }

            .contenedor {
                width: 92%;
            }

            .modal-botones {
                flex-direction: column;
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

        <h1>Puntos de venta</h1>

        <p>
            Administración de cajas y empleados asignados
        </p>

    </div>


    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">

        <!-- BARRA SUPERIOR -->

        <div class="barra-superior">

            <h2>

                <i class="fa-solid fa-store"></i>

                Mis puntos de venta

            </h2>

            <a href="{{ route('admin.puntos_venta.create') }}"
               class="boton-crear">

                <i class="fa-solid fa-plus"></i>

                Crear punto de venta

            </a>

        </div>


        <!-- =========================
             LISTA DE PUNTOS
        ========================== -->

        @if($puntosVenta->count() > 0)

            <div class="lista-puntos">

                @foreach($puntosVenta as $punto)

                    <div class="tarjeta">

                        <!-- ICONO -->

                        <div class="icono-punto">

                            <i class="fa-solid fa-cash-register"></i>

                        </div>


                        <!-- NOMBRE -->

                        <h3>

                            {{ $punto->nombre_caja }}

                        </h3>


                        <!-- NÚMERO DE CAJA -->

                        <div class="dato">

                            <i class="fa-solid fa-hashtag"></i>

                            <span>

                                <strong>Caja:</strong>

                                {{ $punto->numero_caja }}

                            </span>

                        </div>


                        <!-- SUCURSAL -->

                        <div class="dato">

                            <i class="fa-solid fa-location-dot"></i>

                            <span>

                                <strong>Sucursal:</strong>

                                {{ $punto->sucursal }}

                            </span>

                        </div>


                        <!-- EMPLEADO -->

                        <div class="dato">

                            <i class="fa-solid fa-user"></i>

                            <span>

                                <strong>Empleado:</strong>

                                @if($punto->empleado)

                                    {{ $punto->empleado->name }}
                                    {{ $punto->empleado->apellido }}

                                @else

                                    Sin asignar

                                @endif

                            </span>

                        </div>


                        <!-- =========================
                             ACCIONES
                        ========================== -->

                        <div class="acciones">

                            <!-- EDITAR -->

                            <a href="{{ route('admin.puntos_venta.edit', $punto->id) }}"
                               class="boton-editar">

                                <i class="fa-solid fa-pen"></i>

                                Editar

                            </a>


                            <!-- ELIMINAR -->

                            <button
                                type="button"
                                class="boton-eliminar"
                                onclick="abrirModalEliminar(
                                    {{ $punto->id }},
                                    @js($punto->nombre_caja)
                                )"
                            >

                                <i class="fa-solid fa-trash"></i>

                                Eliminar

                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <!-- =========================
                 SIN PUNTOS DE VENTA
            ========================== -->

            <div class="sin-puntos">

                <i class="fa-solid fa-store"></i>

                <h3>
                    No hay puntos de venta
                </h3>

                <p>
                    Todavía no has creado ningún punto de venta.
                </p>

            </div>

        @endif

    </div>


    <!-- =========================
         MODAL ELIMINAR
    ========================== -->

    <div id="modalEliminar" class="modal">

        <div class="modal-contenido">

            <div class="modal-icono">

                <i class="fa-solid fa-trash"></i>

            </div>


            <h2>
                Eliminar punto de venta
            </h2>


            <p id="mensajeEliminar">

                ¿Estás seguro de que deseas eliminar este punto de venta?

            </p>


            <!-- FORMULARIO ELIMINAR -->

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
           ABRIR MODAL
        ========================== */

        function abrirModalEliminar(id, nombre) {

            const modal =
                document.getElementById('modalEliminar');

            const formulario =
                document.getElementById('formEliminar');

            const mensaje =
                document.getElementById('mensajeEliminar');


            mensaje.innerHTML =
                '¿Estás seguro de que deseas eliminar el punto de venta <strong>' +
                nombre +
                '</strong>?';


            /*
             * Ruta que recibirá el DELETE.
             */

            formulario.action =
                "{{ url('/admin/puntos-venta') }}/" + id;


            modal.classList.add('activo');

        }


        /* =========================
           CERRAR MODAL
        ========================== */

        function cerrarModalEliminar() {

            const modal =
                document.getElementById('modalEliminar');

            modal.classList.remove('activo');

        }


        /* =========================
           CERRAR AL HACER CLIC FUERA
        ========================== */

        window.addEventListener('click', function(event) {

            const modal =
                document.getElementById('modalEliminar');


            if (event.target === modal) {

                cerrarModalEliminar();

            }

        });

    </script>

</body>

</html>