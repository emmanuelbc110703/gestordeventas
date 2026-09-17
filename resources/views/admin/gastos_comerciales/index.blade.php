<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gastos comerciales - Gestor de Ventas Los Amates</title>

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
            width: 94%;
            max-width: 1200px;
            margin: 40px auto;
        }

        .tarjeta {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        /* =========================
           ENCABEZADO TARJETA
        ========================== */

        .encabezado-tarjeta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .titulo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icono-titulo {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background-color: #ede0f5;
            color: #6a1b9a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .titulo h2 {
            margin: 0 0 5px;
            color: #333;
        }

        .titulo p {
            margin: 0;
            color: #777;
            font-size: 14px;
        }

        /* =========================
           BOTÓN REGISTRAR
        ========================== */

        .boton-agregar {
            background-color: #6a1b9a;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
            white-space: nowrap;
        }

        .boton-agregar:hover {
            background-color: #4a126d;
            transform: translateY(-2px);
        }

        .boton-agregar i {
            margin-right: 7px;
        }

        /* =========================
           BUSCADOR
        ========================== */

        .buscador {
            position: relative;
            margin-bottom: 20px;
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
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.08);
        }

        /* =========================
           FILTROS
        ========================== */

        .filtros {
            background-color: #f8f0fb;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filtros-titulo {
            color: #555;
            font-weight: bold;
            margin-right: 5px;
        }

        .boton-filtro {
            text-decoration: none;
            padding: 9px 16px;
            border-radius: 7px;
            background-color: white;
            color: #555;
            border: 1px solid #ccc;
            transition: 0.3s;
            font-size: 14px;
        }

        .boton-filtro:hover {
            border-color: #6a1b9a;
            color: #6a1b9a;
        }

        .boton-filtro.activo {
            background-color: #6a1b9a;
            color: white;
            border-color: #6a1b9a;
        }

        /* =========================
           MENSAJE ÉXITO
        ========================== */

        .mensaje-exito {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
            padding: 14px 16px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .mensaje-exito i {
            margin-right: 7px;
        }

        /* =========================
           TABLA
        ========================== */

        .tabla-contenedor {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        thead {
            background-color: #6a1b9a;
            color: white;
        }

        th {
            padding: 14px 12px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #eee;
            color: #555;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr:hover {
            background-color: #faf7fc;
        }

        .monto {
            color: #6a1b9a;
            font-weight: bold;
            white-space: nowrap;
        }

        .categoria {
            display: inline-block;
            background-color: #ede0f5;
            color: #6a1b9a;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .sin-datos {
            text-align: center;
            padding: 40px 20px;
            color: #777;
        }

        .sin-datos i {
            font-size: 40px;
            color: #bbb;
            margin-bottom: 12px;
        }

        /* =========================
           BOTONES ACCIONES
        ========================== */

        .acciones {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .acciones form {
            margin: 0;
        }

        .boton-editar,
        .boton-eliminar {
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 7px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            text-decoration: none;
        }

        .boton-editar {
            background-color: #e8f1ff;
            color: #0d6efd;
        }

        .boton-editar:hover {
            background-color: #0d6efd;
            color: white;
        }

        .boton-eliminar {
            background-color: #fde8e8;
            color: #dc3545;
        }

        .boton-eliminar:hover {
            background-color: #dc3545;
            color: white;
        }

        /* =========================
           TOTAL
        ========================== */

        .total {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .total-caja {
            background-color: #f8f0fb;
            border-left: 4px solid #6a1b9a;
            padding: 15px 20px;
            border-radius: 7px;
            min-width: 230px;
        }

        .total-caja span {
            color: #666;
            font-size: 14px;
        }

        .total-caja strong {
            display: block;
            color: #6a1b9a;
            font-size: 22px;
            margin-top: 5px;
        }

        /* =========================
           MODAL ELIMINAR
        ========================== */

        .modal-eliminar {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.55);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-eliminar.activo {
            display: flex;
        }

        .contenido-modal {
            background-color: white;
            width: 100%;
            max-width: 450px;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .icono-modal {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background-color: #fde8e8;
            color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .contenido-modal h2 {
            margin: 10px 0;
            color: #333;
        }

        .contenido-modal p {
            color: #666;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .botones-modal {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .botones-modal button {
            border: none;
            padding: 11px 18px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .boton-cancelar {
            background-color: #eee;
            color: #555;
        }

        .boton-cancelar:hover {
            background-color: #ddd;
        }

        .boton-confirmar {
            background-color: #dc3545;
            color: white;
        }

        .boton-confirmar:hover {
            background-color: #b02a37;
        }

        .boton-confirmar i {
            margin-right: 6px;
        }

        /* =========================
           RESPONSIVO
        ========================== */

        @media (max-width: 700px) {

            .boton-regresar {
                position: static;
                display: inline-block;
                margin-bottom: 15px;
            }

            .encabezado {
                padding: 20px;
            }

            .contenedor {
                width: 95%;
                margin: 25px auto;
            }

            .tarjeta {
                padding: 20px 15px;
            }

            .encabezado-tarjeta {
                flex-direction: column;
                align-items: flex-start;
            }

            .boton-agregar {
                width: 100%;
                text-align: center;
            }

            .filtros {
                align-items: stretch;
                flex-direction: column;
            }

            .boton-filtro {
                text-align: center;
            }

            .total {
                justify-content: stretch;
            }

            .total-caja {
                width: 100%;
            }

            .contenido-modal {
                padding: 25px 20px;
            }

            .botones-modal {
                flex-direction: column;
            }

            .botones-modal button {
                width: 100%;
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

        <h1>Gastos comerciales</h1>

        <p>
            Administra y consulta los gastos comerciales
        </p>

    </div>


    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">

        <div class="tarjeta">

            <!-- ENCABEZADO DE TARJETA -->

            <div class="encabezado-tarjeta">

                <div class="titulo">

                    <div class="icono-titulo">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>

                    <div>

                        <h2>Registro de gastos</h2>

                        <p>
                            Consulta y administra los gastos comerciales
                        </p>

                    </div>

                </div>


                <a href="{{ route('admin.gastos_comerciales.create') }}"
                   class="boton-agregar">

                    <i class="fa-solid fa-plus"></i>
                    Registrar gasto

                </a>

            </div>


            <!-- MENSAJE DE ÉXITO -->

            @if(session('success'))

                <div class="mensaje-exito">

                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}

                </div>

            @endif


            <!-- =========================
                 BUSCADOR
            ========================== -->

            <div class="buscador">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    id="buscadorGastos"
                    placeholder="Buscar gasto por concepto, categoría o descripción..."
                >

            </div>


            <!-- =========================
                 FILTROS
            ========================== -->

            <div class="filtros">

                <span class="filtros-titulo">

                    <i class="fa-solid fa-filter"></i>
                    Filtrar:

                </span>


                <!-- TODOS -->

                <a href="{{ route('admin.gastos_comerciales', ['filtro' => 'todos']) }}"
                   class="boton-filtro {{ ($filtro ?? 'todos') === 'todos' ? 'activo' : '' }}">

                    <i class="fa-solid fa-list"></i>
                    Todos

                </a>


                <!-- ESTA SEMANA -->

                <a href="{{ route('admin.gastos_comerciales', ['filtro' => 'semana']) }}"
                   class="boton-filtro {{ ($filtro ?? '') === 'semana' ? 'activo' : '' }}">

                    <i class="fa-solid fa-calendar-week"></i>
                    Esta semana

                </a>


                <!-- ESTE MES -->

                <a href="{{ route('admin.gastos_comerciales', ['filtro' => 'mes']) }}"
                   class="boton-filtro {{ ($filtro ?? '') === 'mes' ? 'activo' : '' }}">

                    <i class="fa-solid fa-calendar-days"></i>
                    Este mes

                </a>

            </div>


            <!-- =========================
                 TABLA
            ========================== -->

            <div class="tabla-contenedor">

                <table id="tablaGastos">

                    <thead>

                        <tr>

                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Acciones</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($gastos as $gasto)

                            <tr>

                                <!-- FECHA -->

                                <td>
                                    {{ $gasto->fecha->format('d/m/Y') }}
                                </td>


                                <!-- CONCEPTO -->

                                <td>

                                    <strong>
                                        {{ $gasto->concepto }}
                                    </strong>

                                </td>


                                <!-- CATEGORÍA -->

                                <td>

                                    <span class="categoria">
                                        {{ $gasto->categoria }}
                                    </span>

                                </td>


                                <!-- DESCRIPCIÓN -->

                                <td>
                                    {{ $gasto->descripcion ?: 'Sin descripción' }}
                                </td>


                                <!-- MONTO -->

                                <td class="monto">
                                    ${{ number_format($gasto->monto, 2) }}
                                </td>


                                <!-- ACCIONES -->

                                <td>

                                    <div class="acciones">

                                        <!-- EDITAR -->

                                        <a href="{{ route('admin.gastos_comerciales.edit', $gasto->id) }}"
                                           class="boton-editar"
                                           title="Editar gasto">

                                            <i class="fa-solid fa-pen-to-square"></i>

                                        </a>


                                        <!-- ELIMINAR -->

                                        <button
                                            type="button"
                                            class="boton-eliminar"
                                            title="Eliminar gasto"
                                            onclick="abrirModalEliminar(
                                                {{ $gasto->id }},
                                                '{{ addslashes($gasto->concepto) }}'
                                            )"
                                        >

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="sin-datos">

                                    <i class="fa-solid fa-receipt"></i>

                                    <br>

                                    No hay gastos comerciales registrados
                                    para este período.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <!-- =========================
                 TOTAL
            ========================== -->

            @if($gastos->count() > 0)

                <div class="total">

                    <div class="total-caja">

                        <span>
                            Total de gastos mostrados
                        </span>

                        <strong>
                            ${{ number_format($gastos->sum('monto'), 2) }}
                        </strong>

                    </div>

                </div>

            @endif

        </div>

    </div>


    <!-- =========================
         MODAL ELIMINAR
    ========================== -->

    <div id="modalEliminar" class="modal-eliminar">

        <div class="contenido-modal">

            <div class="icono-modal">

                <i class="fa-solid fa-triangle-exclamation"></i>

            </div>

            <h2>
                ¿Eliminar gasto?
            </h2>

            <p id="mensajeEliminar">
                ¿Estás seguro de que deseas eliminar este gasto?
            </p>


            <div class="botones-modal">

                <button
                    type="button"
                    class="boton-cancelar"
                    onclick="cerrarModalEliminar()"
                >
                    Cancelar
                </button>


                <form
                    id="formEliminar"
                    method="POST"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="boton-confirmar"
                    >

                        <i class="fa-solid fa-trash"></i>
                        Eliminar

                    </button>

                </form>

            </div>

        </div>

    </div>


    <!-- =========================
         JAVASCRIPT
    ========================== -->

    <script>

        /* =========================
           BUSCADOR
        ========================== */

        const buscador =
            document.getElementById('buscadorGastos');

        if (buscador) {

            buscador.addEventListener('input', function () {

                const texto =
                    this.value.toLowerCase().trim();

                const filas =
                    document.querySelectorAll(
                        '#tablaGastos tbody tr'
                    );

                filas.forEach(function (fila) {

                    const contenido =
                        fila.textContent.toLowerCase();

                    if (contenido.includes(texto)) {

                        fila.style.display = '';

                    } else {

                        fila.style.display = 'none';

                    }

                });

            });

        }


        /* =========================
           ABRIR MODAL ELIMINAR
        ========================== */

        function abrirModalEliminar(id, concepto) {

            const modal =
                document.getElementById('modalEliminar');

            const formulario =
                document.getElementById('formEliminar');

            const mensaje =
                document.getElementById('mensajeEliminar');


            mensaje.innerHTML =
                '¿Estás seguro de que deseas eliminar el gasto ' +
                '<strong>"' +
                concepto +
                '"</strong>? Esta acción no se puede deshacer.';


            formulario.action =
                "{{ url('/admin/gastos-comerciales') }}/" + id;


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
           CERRAR AL HACER CLIC AFUERA
        ========================== */

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

