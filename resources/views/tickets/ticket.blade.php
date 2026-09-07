<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ticket {{ $venta->folio }}</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            background: #f3f4f6;
            font-family: Arial, sans-serif;
            color: #111827;
        }

        .ticket {
            width: 80mm;
            max-width: 100%;
            margin: auto;
            background: white;
            padding: 15px;
        }

        .center {
            text-align: center;
        }

        .empresa {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .titulo {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }

        .linea {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .datos {
            font-size: 12px;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th {
            border-bottom: 1px solid #000;
            padding: 5px 2px;
        }

        td {
            padding: 5px 2px;
            vertical-align: top;
        }

        .derecha {
            text-align: right;
        }

        .totales {
            font-size: 13px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
        }

        .gracias {
            margin-top: 20px;
            font-size: 12px;
        }

        .botones {
            width: 80mm;
            max-width: 100%;
            margin: 15px auto 0;
            display: flex;
            gap: 8px;
        }

        .botones button {
            width: 100%;
            padding: 10px;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        .imprimir {
            background: #2563eb;
        }

        .imprimir:hover {
            background: #1d4ed8;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .ticket {
                width: 80mm;
                padding: 5px;
            }

            .botones {
                display: none;
            }

        }

    </style>

</head>

<body>


    {{-- ==========================================================
         TICKET
    ========================================================== --}}

    <div class="ticket">


        {{-- ======================================================
             ENCABEZADO
        ====================================================== --}}

        <div class="center">

            <div class="empresa">
                GESTOR DE VENTAS
            </div>

            <div class="titulo">
                TICKET DE VENTA
            </div>

        </div>


        <div class="linea"></div>


        {{-- ======================================================
             DATOS DE LA VENTA
        ====================================================== --}}

        <div class="datos">

            <strong>Folio:</strong>

            {{ $venta->folio }}

            <br>


            <strong>Fecha:</strong>

            {{ $venta->created_at?->timezone('America/Mexico_City')->format('d/m/Y H:i') }}

            <br>


            <strong>Caja:</strong>

            @if($venta->puntoVenta)

                {{ $venta->puntoVenta->nombre_caja }}

            @else

                N/A

            @endif

            <br>


            <strong>Empleado:</strong>

            @if($venta->empleado)

                {{ $venta->empleado->name }}

                {{ $venta->empleado->apellido ?? '' }}

            @else

                N/A

            @endif


            @if($venta->cliente)

                <br>

                <strong>Cliente:</strong>

                {{ $venta->cliente->name }}

                {{ $venta->cliente->apellido ?? '' }}

            @endif

        </div>


        <div class="linea"></div>


        {{-- ======================================================
             PRODUCTOS
        ====================================================== --}}

        <table>

            <thead>

                <tr>

                    <th>
                        Producto
                    </th>

                    <th>
                        Cant.
                    </th>

                    <th class="derecha">
                        Importe
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($venta->detalles as $detalle)

                    <tr>

                        <td>
                            {{ $detalle->inventario->nombre ?? 'Producto' }}
                        </td>

                        <td>
                            {{ $detalle->cantidad }}
                        </td>

                        <td class="derecha">

                            ${{ number_format($detalle->subtotal, 2) }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="center"
                        >

                            No hay productos registrados.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


        <div class="linea"></div>


        {{-- ======================================================
             TOTALES
        ====================================================== --}}

        <table class="totales">

            <tr>

                <td>
                    Subtotal:
                </td>

                <td class="derecha">

                    ${{ number_format($venta->subtotal, 2) }}

                </td>

            </tr>


            @if($venta->descuento > 0)

                <tr>

                    <td>

                        Descuento
                        ({{ number_format($venta->descuento_porcentaje, 2) }}%):

                    </td>

                    <td class="derecha">

                        -${{ number_format($venta->descuento, 2) }}

                    </td>

                </tr>

            @endif


            @if($venta->impuesto > 0)

                <tr>

                    <td>

                        Impuesto
                        ({{ number_format($venta->impuesto_porcentaje, 2) }}%):

                    </td>

                    <td class="derecha">

                        ${{ number_format($venta->impuesto, 2) }}

                    </td>

                </tr>

            @endif


            <tr>

                <td class="total">
                    TOTAL:
                </td>

                <td class="derecha total">

                    ${{ number_format($venta->total, 2) }}

                </td>

            </tr>

        </table>


        <div class="linea"></div>


        {{-- ======================================================
             PAGO
        ====================================================== --}}

        <div class="datos">

            <strong>
                Forma de pago:
            </strong>

            {{ ucfirst($venta->forma_pago) }}


            @if($venta->forma_pago === 'efectivo')

                <br>

                <strong>
                    Efectivo recibido:
                </strong>

                ${{ number_format($venta->efectivo_recibido, 2) }}


                <br>

                <strong>
                    Cambio:
                </strong>

                ${{ number_format($venta->cambio, 2) }}

            @endif

        </div>


        <div class="linea"></div>


        {{-- ======================================================
             MENSAJE FINAL
        ====================================================== --}}

        <div class="center gracias">

            <strong>
                ¡Gracias por su compra!
            </strong>

            <br>

            Conserve este ticket.

        </div>

    </div>


    {{-- ==========================================================
         BOTÓN IMPRIMIR
    ========================================================== --}}

    <div class="botones">

        <button
            type="button"
            class="imprimir"
            onclick="window.print()"
        >

            <i class="fa-solid fa-print"></i>

            Imprimir

        </button>

    </div>


    {{-- ==========================================================
         FONT AWESOME
    ========================================================== --}}

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js">
    </script>

</body>

</html>