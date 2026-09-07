<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Editar cotización - Los Amates</title>

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
            max-width: 1100px;
            margin: 35px auto;
        }


        /* ========================================
           CABECERA
        ======================================== */

        .cabecera-pagina {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .cabecera-pagina h2 {
            margin: 0;
        }

        .folio {
            color: #6a1b9a;
            font-weight: bold;
        }


        /* ========================================
           MENSAJES
        ======================================== */

        .mensaje {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .mensaje-error {
            background: #f8d7da;
            color: #842029;
        }


        /* ========================================
           TARJETAS
        ======================================== */

        .tarjeta {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;

            box-shadow:
                0 3px 10px rgba(0,0,0,.12);
        }

        .tarjeta h3 {
            margin-top: 0;
            color: #6a1b9a;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
        }


        /* ========================================
           TABLA
        ======================================== */

        .tabla-contenedor {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th {
            background: #6a1b9a;
            color: white;
            padding: 13px;
            text-align: left;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #faf7fc;
        }


        /* ========================================
           CANTIDAD
        ======================================== */

        .cantidad {
            width: 80px;
            padding: 9px;

            border: 1px solid #ccc;
            border-radius: 6px;

            text-align: center;
            font-size: 15px;
        }

        .cantidad:focus {
            outline: none;
            border-color: #6a1b9a;
        }


        /* ========================================
           PRECIO
        ======================================== */

        .precio {
            font-weight: bold;
        }


        /* ========================================
           IMPORTE
        ======================================== */

        .importe {
            color: #6a1b9a;
            font-weight: bold;
        }


        /* ========================================
           FORMULARIO DE PORCENTAJES
        ======================================== */

        .fila-formulario {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .campo label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .campo input {
            width: 100%;
            padding: 11px;

            border: 1px solid #ccc;
            border-radius: 7px;

            font-size: 15px;
        }

        .campo input:focus {
            outline: none;
            border-color: #6a1b9a;
        }


        /* ========================================
           RESUMEN
        ======================================== */

        .resumen {
            max-width: 500px;
            margin-left: auto;
        }

        .resumen-fila {
            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 10px 0;

            border-bottom: 1px solid #eee;
        }

        .resumen-fila strong {
            color: #333;
        }

        .total-final {
            display: flex;
            justify-content: space-between;

            margin-top: 10px;
            padding-top: 15px;

            border-top: 2px solid #6a1b9a;

            font-size: 22px;
            font-weight: bold;

            color: #6a1b9a;
        }


        /* ========================================
           BOTONES
        ======================================== */

        .acciones {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
        }

        .boton {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 12px 18px;

            border-radius: 8px;

            text-decoration: none;

            font-weight: bold;

            border: none;

            cursor: pointer;

            font-size: 14px;
        }

        .boton-guardar {
            background: #198754;
            color: white;
        }

        .boton-guardar:hover {
            background: #146c43;
        }

        .boton-cancelar {
            background: #6c757d;
            color: white;
        }

        .boton-cancelar:hover {
            background: #565e64;
        }


        /* ========================================
           RESPONSIVO
        ======================================== */

        @media (max-width: 700px) {

            .cabecera-pagina {
                flex-direction: column;
                align-items: flex-start;
            }

            .fila-formulario {
                grid-template-columns: 1fr;
            }

            .acciones {
                flex-direction: column;
            }

            .boton {
                width: 100%;
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
            Editar cotización
        </h1>

        <p>
            Orquídeas y más "Los Amates"
        </p>

    </div>


    <div class="contenedor">


        {{-- ========================================
             CABECERA
        ======================================== --}}

        <div class="cabecera-pagina">

            <h2>
                Modificar pedido
            </h2>

            <div class="folio">

                {{ $cotizacion->folio }}

            </div>

        </div>


        {{-- ========================================
             ERRORES
        ======================================== --}}

        @if($errors->any())

            <div class="mensaje mensaje-error">

                <strong>
                    No se pudo actualizar la cotización:
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


        <form
            method="POST"
            action="{{ route(
                'admin.cotizaciones.actualizar',
                $cotizacion->id
            ) }}"
            id="formEditar"
        >

            @csrf

            @method('PUT')


            {{-- ========================================
                 SERVICIOS
            ======================================== --}}

            <div class="tarjeta">

                <h3>

                    <i class="fa-solid fa-list-check"></i>

                    Servicios del pedido

                </h3>


                <div class="tabla-contenedor">

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    Servicio
                                </th>

                                <th>
                                    Precio
                                </th>

                                <th>
                                    Cantidad
                                </th>

                                <th>
                                    Importe
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($cotizacion->detalles as $detalle)

                                <tr>

                                    <td>

                                        <strong>
                                            {{ $detalle->nombre }}
                                        </strong>

                                    </td>


                                    <td>

                                        <span class="precio">

                                            ${{ number_format(
                                                $detalle->precio,
                                                2
                                            ) }}

                                        </span>

                                    </td>


                                    <td>

                                        <input
                                            type="number"
                                            name="cantidades[{{ $detalle->id }}]"
                                            value="{{ $detalle->cantidad }}"
                                            min="1"
                                            class="cantidad"
                                            data-precio="{{ $detalle->precio }}"
                                        >

                                    </td>


                                    <td>

                                        <span class="importe importe-detalle">

                                            ${{ number_format(
                                                $detalle->subtotal,
                                                2
                                            ) }}

                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- ========================================
                 DESCUENTO E IMPUESTO
            ======================================== --}}

            <div class="tarjeta">

                <h3>

                    <i class="fa-solid fa-percent"></i>

                    Descuentos e impuestos

                </h3>


                <div class="fila-formulario">


                    <div class="campo">

                        <label for="descuento_porcentaje">

                            Descuento (%)

                        </label>

                        <input
                            type="number"
                            id="descuento_porcentaje"
                            name="descuento_porcentaje"
                            value="{{ old(
                                'descuento_porcentaje',
                                $cotizacion->descuento_porcentaje
                            ) }}"
                            min="0"
                            max="100"
                            step="0.01"
                            required
                        >

                    </div>


                    <div class="campo">

                        <label for="impuesto_porcentaje">

                            Impuesto (%)

                        </label>

                        <input
                            type="number"
                            id="impuesto_porcentaje"
                            name="impuesto_porcentaje"
                            value="{{ old(
                                'impuesto_porcentaje',
                                $cotizacion->impuesto_porcentaje
                            ) }}"
                            min="0"
                            max="100"
                            step="0.01"
                            required
                        >

                    </div>


                </div>

            </div>


            {{-- ========================================
                 RESUMEN
            ======================================== --}}

            <div class="tarjeta">

                <h3>

                    <i class="fa-solid fa-calculator"></i>

                    Resumen

                </h3>


                <div class="resumen">


                    <div class="resumen-fila">

                        <strong>
                            Subtotal:
                        </strong>

                        <span id="subtotal">
                            $0.00
                        </span>

                    </div>


                    <div class="resumen-fila">

                        <strong>
                            Descuento:
                        </strong>

                        <span id="descuento">
                            $0.00
                        </span>

                    </div>


                    <div class="resumen-fila">

                        <strong>
                            Base:
                        </strong>

                        <span id="base">
                            $0.00
                        </span>

                    </div>


                    <div class="resumen-fila">

                        <strong>
                            Impuesto:
                        </strong>

                        <span id="impuesto">
                            $0.00
                        </span>

                    </div>


                    <div class="total-final">

                        <span>
                            Total:
                        </span>

                        <span id="total">
                            $0.00
                        </span>

                    </div>

                </div>


                {{-- ========================================
                     ACCIONES
                ======================================== --}}

                <div class="acciones">

                    <a
                        href="{{ route(
                            'admin.cotizaciones.mostrar',
                            $cotizacion->id
                        ) }}"
                        class="boton boton-cancelar"
                    >

                        <i class="fa-solid fa-arrow-left"></i>

                        Cancelar

                    </a>


                    <button
                        type="submit"
                        class="boton boton-guardar"
                    >

                        <i class="fa-solid fa-save"></i>

                        Guardar cambios

                    </button>

                </div>

            </div>


        </form>

    </div>


    {{-- ========================================
         JAVASCRIPT
    ======================================== --}}

    <script>

        function numero(valor) {

            const resultado = parseFloat(valor);

            return isNaN(resultado)
                ? 0
                : resultado;

        }


        function dinero(valor) {

            return '$' + valor.toFixed(2);

        }


        function calcular() {

            let subtotal = 0;


            /*
             * Calcular subtotal según
             * cantidades actuales.
             */
            document
                .querySelectorAll('.cantidad')
                .forEach(function(input) {

                    let cantidad =
                        parseInt(input.value);

                    if (!cantidad || cantidad < 1) {

                        cantidad = 1;

                    }

                    const precio =
                        numero(
                            input.dataset.precio
                        );


                    const importe =
                        precio * cantidad;


                    subtotal += importe;


                    const fila =
                        input.closest('tr');


                    const importeElemento =
                        fila.querySelector(
                            '.importe-detalle'
                        );


                    importeElemento.textContent =
                        dinero(importe);

                });


            /*
             * Descuento.
             */
            const descuentoPorcentaje =
                numero(
                    document.getElementById(
                        'descuento_porcentaje'
                    ).value
                );


            const descuento =
                subtotal *
                (descuentoPorcentaje / 100);


            /*
             * Base.
             */
            const base =
                subtotal - descuento;


            /*
             * Impuesto.
             */
            const impuestoPorcentaje =
                numero(
                    document.getElementById(
                        'impuesto_porcentaje'
                    ).value
                );


            const impuesto =
                base *
                (impuestoPorcentaje / 100);


            /*
             * Total.
             */
            const total =
                base + impuesto;


            /*
             * Mostrar resultados.
             */
            document.getElementById(
                'subtotal'
            ).textContent =
                dinero(subtotal);


            document.getElementById(
                'descuento'
            ).textContent =
                dinero(descuento);


            document.getElementById(
                'base'
            ).textContent =
                dinero(base);


            document.getElementById(
                'impuesto'
            ).textContent =
                dinero(impuesto);


            document.getElementById(
                'total'
            ).textContent =
                dinero(total);

        }


        /*
         * Recalcular al cambiar
         * una cantidad.
         */
        document
            .querySelectorAll('.cantidad')
            .forEach(function(input) {

                input.addEventListener(
                    'input',
                    calcular
                );

            });


        /*
         * Recalcular descuento.
         */
        document
            .getElementById(
                'descuento_porcentaje'
            )
            .addEventListener(
                'input',
                calcular
            );


        /*
         * Recalcular impuesto.
         */
        document
            .getElementById(
                'impuesto_porcentaje'
            )
            .addEventListener(
                'input',
                calcular
            );


        /*
         * Cálculo inicial.
         */
        calcular();

    </script>


</body>

</html>