<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Crear cotización - Los Amates</title>

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

        /* ========================================
           ENCABEZADO
        ======================================== */

        .encabezado {
            background: #6a1b9a;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .encabezado h1 {
            margin: 0;
            font-size: 28px;
        }

        .encabezado p {
            margin: 8px 0 0;
        }


        /* ========================================
           CONTENEDOR
        ======================================== */

        .contenedor {
            width: 92%;
            max-width: 1200px;
            margin: 30px auto;
        }


        /* ========================================
           TITULO
        ======================================== */

        .titulo-pagina {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .titulo-pagina h2 {
            margin: 0;
        }


        /* ========================================
           BOTÓN VOLVER
        ======================================== */

        .volver {
            color: #6a1b9a;
            text-decoration: none;
            font-weight: bold;
        }

        .volver:hover {
            text-decoration: underline;
        }


        /* ========================================
           DISTRIBUCIÓN
        ======================================== */

        .contenido {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            align-items: start;
        }


        /* ========================================
           CATÁLOGO
        ======================================== */

        .catalogo {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }


        /* ========================================
           TARJETA SERVICIO
        ======================================== */

        .servicio {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,.12);
        }

        .servicio-imagen {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #eee;
        }

        .sin-imagen {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eee;
            color: #999;
            font-size: 45px;
        }

        .servicio-contenido {
            padding: 18px;
        }

        .servicio h3 {
            margin: 0 0 8px;
            color: #6a1b9a;
        }

        .descripcion {
            color: #666;
            font-size: 14px;
            min-height: 42px;
            margin-bottom: 12px;
        }

        .precio {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }


        /* ========================================
           CANTIDAD
        ======================================== */

        .cantidad {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .cantidad label {
            font-weight: bold;
        }

        .cantidad input {
            width: 70px;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 6px;
            text-align: center;
        }


        /* ========================================
           BOTÓN AGREGAR
        ======================================== */

        .agregar {
            width: 100%;
            border: none;
            padding: 11px;
            border-radius: 7px;
            background: #6a1b9a;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .agregar:hover {
            background: #4a116d;
        }


        /* ========================================
           CARRITO
        ======================================== */

        .carrito {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,.12);
            position: sticky;
            top: 20px;
        }

        .carrito h2 {
            margin-top: 0;
            color: #6a1b9a;
        }


        /* ========================================
           ITEMS CARRITO
        ======================================== */

        .carrito-vacio {
            color: #777;
            text-align: center;
            padding: 25px 10px;
        }

        .item-carrito {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
        }

        .item-nombre {
            font-weight: bold;
        }

        .item-info {
            display: flex;
            justify-content: space-between;
            margin-top: 6px;
            font-size: 14px;
        }


        /* ========================================
           BOTÓN QUITAR
        ======================================== */

        .quitar {
            border: none;
            background: #dc3545;
            color: white;
            border-radius: 5px;
            padding: 5px 8px;
            cursor: pointer;
            margin-top: 8px;
        }


        /* ========================================
           TOTAL
        ======================================== */

        .subtotal {
            display: flex;
            justify-content: space-between;
            margin-top: 18px;
            padding-top: 15px;
            border-top: 2px solid #eee;
            font-size: 18px;
            font-weight: bold;
        }


        /* ========================================
           FORMA DE PAGO
        ======================================== */

        .pago {
            margin-top: 20px;
        }

        .pago h3 {
            margin-bottom: 12px;
        }

        .opcion-pago {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 7px;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .opcion-pago:hover {
            background: #f5eff8;
        }


        /* ========================================
           SOLICITAR
        ======================================== */

        .solicitar {
            width: 100%;
            margin-top: 20px;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #198754;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .solicitar:hover {
            background: #146c43;
        }

        .solicitar:disabled {
            background: #aaa;
            cursor: not-allowed;
        }


        /* ========================================
           ERRORES
        ======================================== */

        .errores {
            background: #f8d7da;
            color: #842029;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }


        /* ========================================
           RESPONSIVO
        ======================================== */

        @media (max-width: 850px) {

            .contenido {
                grid-template-columns: 1fr;
            }

            .carrito {
                position: static;
            }

        }

        @media (max-width: 600px) {

            .catalogo {
                grid-template-columns: 1fr;
            }

            .titulo-pagina {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

        }

    </style>

</head>


<body>


    {{-- ========================================
         ENCABEZADO
    ======================================== --}}

    <div class="encabezado">

        <h1>
            Crear cotización
        </h1>

        <p>
            Orquídeas y más "Los Amates"
        </p>

    </div>


    <div class="contenedor">


        <div class="titulo-pagina">

            <h2>
                Selecciona los servicios
            </h2>

            <a
                href="{{ route('cliente.cotizaciones') }}"
                class="volver"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Volver a cotizaciones
            </a>

        </div>


        {{-- ========================================
             ERRORES
        ======================================== --}}

        @if($errors->any())

            <div class="errores">

                <strong>
                    No se pudo enviar la cotización:
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ========================================
             FORMULARIO
        ======================================== --}}

        <form
            method="POST"
            action="{{ route('cliente.cotizaciones.store') }}"
            id="formCotizacion"
        >

            @csrf


            <div class="contenido">


                {{-- ====================================
                     CATÁLOGO
                ==================================== --}}

                <div class="catalogo">

                    @forelse($servicios as $servicio)

                        <div class="servicio">

                            @if($servicio->foto)

                                <img
                                    src="{{ asset('storage/' . $servicio->foto) }}"
                                    alt="{{ $servicio->nombre }}"
                                    class="servicio-imagen"
                                >

                            @else

                                <div class="sin-imagen">

                                    <i class="fa-solid fa-image"></i>

                                </div>

                            @endif


                            <div class="servicio-contenido">

                                <h3>
                                    {{ $servicio->nombre }}
                                </h3>


                                <div class="descripcion">

                                    {{ $servicio->descripcion ?: 'Sin descripción disponible.' }}

                                </div>


                                <div class="precio">

                                    ${{ number_format($servicio->precio, 2) }}

                                </div>


                                <div class="cantidad">

                                    <label>
                                        Cantidad:
                                    </label>

                                    <input
                                        type="number"
                                        min="1"
                                        value="1"
                                        id="cantidad-{{ $servicio->id }}"
                                    >

                                </div>


                                <button
                                    type="button"
                                    class="agregar"
                                    onclick="agregarServicio(
                                        {{ $servicio->id }},
                                        @js($servicio->nombre),
                                        {{ $servicio->precio }}
                                    )"
                                >

                                    <i class="fa-solid fa-cart-plus"></i>

                                    Agregar al pedido

                                </button>

                            </div>

                        </div>

                    @empty

                        <div class="carrito-vacio">

                            <i class="fa-solid fa-box-open"></i>

                            <p>
                                Actualmente no hay servicios disponibles.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- ====================================
                     CARRITO
                ==================================== --}}

                <div class="carrito">

                    <h2>

                        <i class="fa-solid fa-cart-shopping"></i>

                        Mi pedido

                    </h2>


                    <div id="listaCarrito">

                        <div class="carrito-vacio">

                            No has agregado servicios.

                        </div>

                    </div>


                    <div class="subtotal">

                        <span>
                            Subtotal:
                        </span>

                        <span id="subtotalTexto">
                            $0.00
                        </span>

                    </div>


                    {{-- ====================================
                         FORMA DE PAGO
                    ==================================== --}}

                    <div class="pago">

                        <h3>
                            Forma de pago
                        </h3>


                        <label class="opcion-pago">

                            <input
                                type="radio"
                                name="forma_pago"
                                value="efectivo"
                            >

                            <i class="fa-solid fa-money-bill-wave"></i>

                            Efectivo

                        </label>


                        <label class="opcion-pago">

                            <input
                                type="radio"
                                name="forma_pago"
                                value="transferencia"
                            >

                            <i class="fa-solid fa-building-columns"></i>

                            Transferencia

                        </label>

                    </div>


                    <button
                        type="submit"
                        class="solicitar"
                        id="botonSolicitar"
                        disabled
                    >

                        <i class="fa-solid fa-paper-plane"></i>

                        Solicitar cotización

                    </button>

                </div>

            </div>


        </form>

    </div>


    {{-- ========================================
         JAVASCRIPT
    ======================================== --}}

    <script>

        let carrito = [];


        /*
         * Agregar servicio
         */
        function agregarServicio(id, nombre, precio) {

            const input =
                document.getElementById(
                    'cantidad-' + id
                );

            const cantidad =
                parseInt(input.value);


            if (!cantidad || cantidad < 1) {

                alert('La cantidad debe ser mayor a 0.');

                return;
            }


            const existente =
                carrito.find(
                    item => item.id === id
                );


            if (existente) {

                existente.cantidad += cantidad;

            } else {

                carrito.push({

                    id: id,

                    nombre: nombre,

                    precio: parseFloat(precio),

                    cantidad: cantidad

                });

            }


            renderizarCarrito();

        }


        /*
         * Quitar servicio
         */
        function quitarServicio(id) {

            carrito =
                carrito.filter(
                    item => item.id !== id
                );

            renderizarCarrito();

        }


        /*
         * Renderizar carrito
         */
        function renderizarCarrito() {

            const lista =
                document.getElementById(
                    'listaCarrito'
                );

            const subtotalTexto =
                document.getElementById(
                    'subtotalTexto'
                );

            const boton =
                document.getElementById(
                    'botonSolicitar'
                );


            if (carrito.length === 0) {

                lista.innerHTML = `
                    <div class="carrito-vacio">
                        No has agregado servicios.
                    </div>
                `;

                subtotalTexto.textContent =
                    '$0.00';

                boton.disabled = true;

                actualizarInputs();

                return;
            }


            let subtotal = 0;

            let html = '';


            carrito.forEach(item => {

                const importe =
                    item.precio *
                    item.cantidad;

                subtotal += importe;


                html += `

                    <div class="item-carrito">

                        <div class="item-nombre">
                            ${escapeHtml(item.nombre)}
                        </div>

                        <div class="item-info">

                            <span>
                                ${item.cantidad}
                                x
                                $${item.precio.toFixed(2)}
                            </span>

                            <strong>
                                $${importe.toFixed(2)}
                            </strong>

                        </div>

                        <button
                            type="button"
                            class="quitar"
                            onclick="quitarServicio(${item.id})"
                        >

                            <i class="fa-solid fa-trash"></i>

                            Quitar

                        </button>

                    </div>

                `;

            });


            lista.innerHTML = html;


            subtotalTexto.textContent =
                '$' + subtotal.toFixed(2);


            boton.disabled = false;


            actualizarInputs();

        }


        /*
         * Crear inputs ocultos para enviar
         * el carrito al controlador.
         */
        function actualizarInputs() {

            const form =
                document.getElementById(
                    'formCotizacion'
                );


            document
                .querySelectorAll(
                    '.input-carrito'
                )
                .forEach(
                    input => input.remove()
                );


            carrito.forEach((item, index) => {

                const inputId =
                    document.createElement('input');

                inputId.type = 'hidden';

                inputId.name =
                    `productos[${index}][id]`;

                inputId.value =
                    item.id;

                inputId.className =
                    'input-carrito';


                const inputCantidad =
                    document.createElement('input');

                inputCantidad.type =
                    'hidden';

                inputCantidad.name =
                    `productos[${index}][cantidad]`;

                inputCantidad.value =
                    item.cantidad;

                inputCantidad.className =
                    'input-carrito';


                form.appendChild(inputId);

                form.appendChild(inputCantidad);

            });

        }


        /*
         * Evitar insertar HTML
         * proveniente de nombres.
         */
        function escapeHtml(text) {

            const div =
                document.createElement('div');

            div.textContent = text;

            return div.innerHTML;

        }


        /*
         * Validar antes de enviar.
         */
        document
            .getElementById('formCotizacion')
            .addEventListener(
                'submit',
                function(event) {

                    if (carrito.length === 0) {

                        event.preventDefault();

                        alert(
                            'Agrega al menos un servicio.'
                        );

                        return;
                    }


                    const pago =
                        document.querySelector(
                            'input[name="forma_pago"]:checked'
                        );


                    if (!pago) {

                        event.preventDefault();

                        alert(
                            'Selecciona una forma de pago.'
                        );

                        return;
                    }


                    actualizarInputs();

                }
            );

    </script>


</body>

</html>