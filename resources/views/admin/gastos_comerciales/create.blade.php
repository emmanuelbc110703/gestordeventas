<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar gasto - Gestor de Ventas Los Amates</title>

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
            background-color: #f4f4f4;
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
            max-width: 700px;
            margin: 40px auto;
        }

        .tarjeta {
            background-color: white;
            border-radius: 15px;
            padding: 35px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        /* =========================
           FILAS
        ========================== */

        .fila {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        /* =========================
           CAMPOS
        ========================== */

        .campo {
            margin-bottom: 18px;
        }

        .campo label {
            display: block;
            color: #555;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .campo label i {
            color: #6a1b9a;
            margin-right: 6px;
        }

        .campo input,
        .campo select,
        .campo textarea {
            width: 100%;
            padding: 13px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            background-color: white;
            font-family: Arial, sans-serif;
        }

        .campo textarea {
            min-height: 120px;
            resize: vertical;
        }

        .campo input:focus,
        .campo select:focus,
        .campo textarea:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.08);
        }

        /* =========================
           ERRORES
        ========================== */

        .error {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
        }

        /* =========================
           MONTO
        ========================== */

        .monto-contenedor {
            position: relative;
        }

        .monto-contenedor .simbolo {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #6a1b9a;
            font-weight: bold;
            pointer-events: none;
        }

        .monto-contenedor input {
            padding-left: 30px;
        }

        /* =========================
           BOTÓN
        ========================== */

        .contenedor-boton {
            text-align: center;
            margin-top: 15px;
        }

        .boton-guardar {
            background-color: #6a1b9a;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 13px 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .boton-guardar:hover {
            background-color: #4a126d;
            transform: translateY(-2px);
        }

        .boton-guardar i {
            margin-right: 8px;
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

            .fila {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .tarjeta {
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>

    <!-- =========================
         ENCABEZADO
    ========================== -->

    <div class="encabezado">

        <a
            href="{{ route('admin.gastos_comerciales') }}"
            class="boton-regresar"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>

        <h1>
            Registrar gasto comercial
        </h1>

        <p>
            Registra un nuevo gasto comercial de la empresa
        </p>

    </div>


    <!-- =========================
         CONTENIDO
    ========================== -->

    <div class="contenedor">

        <div class="tarjeta">

            <!-- FORMULARIO -->

            <form
                action="{{ route('admin.gastos_comerciales.store') }}"
                method="POST"
            >

                @csrf


                <!-- FECHA Y MONTO -->

                <div class="fila">

                    <div class="campo">

                        <label for="fecha">
                            <i class="fa-solid fa-calendar-days"></i>
                            Fecha
                        </label>

                        <input
                            type="date"
                            id="fecha"
                            name="fecha"
                            value="{{ old('fecha', date('Y-m-d')) }}"
                            required
                        >

                        @error('fecha')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <div class="campo">

                        <label for="monto">
                            <i class="fa-solid fa-dollar-sign"></i>
                            Monto
                        </label>

                        <div class="monto-contenedor">

                            <span class="simbolo">
                                $
                            </span>

                            <input
                                type="number"
                                id="monto"
                                name="monto"
                                value="{{ old('monto') }}"
                                min="0.01"
                                step="0.01"
                                placeholder="0.00"
                                required
                            >

                        </div>

                        @error('monto')
                            <span class="error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>


                <!-- CONCEPTO -->

                <div class="campo">

                    <label for="concepto">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        Concepto
                    </label>

                    <input
                        type="text"
                        id="concepto"
                        name="concepto"
                        value="{{ old('concepto') }}"
                        placeholder="Ej. Publicidad en redes sociales"
                        maxlength="255"
                        required
                    >

                    @error('concepto')
                        <span class="error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <!-- CATEGORÍA -->

                <div class="campo">

                    <label for="categoria">
                        <i class="fa-solid fa-tags"></i>
                        Categoría
                    </label>

                    <select
                        id="categoria"
                        name="categoria"
                        required
                    >

                        <option value="">
                            Selecciona una categoría
                        </option>

                        <option
                            value="publicidad"
                            {{ old('categoria') === 'publicidad' ? 'selected' : '' }}
                        >
                            Publicidad
                        </option>

                        <option
                            value="transporte"
                            {{ old('categoria') === 'transporte' ? 'selected' : '' }}
                        >
                            Transporte
                        </option>

                        <option
                            value="papeleria"
                            {{ old('categoria') === 'papeleria' ? 'selected' : '' }}
                        >
                            Papelería
                        </option>

                        <option
                            value="servicios"
                            {{ old('categoria') === 'servicios' ? 'selected' : '' }}
                        >
                            Servicios
                        </option>

                        <option
                            value="mantenimiento"
                            {{ old('categoria') === 'mantenimiento' ? 'selected' : '' }}
                        >
                            Mantenimiento
                        </option>

                        <option
                            value="compras"
                            {{ old('categoria') === 'compras' ? 'selected' : '' }}
                        >
                            Compras
                        </option>

                        <option
                            value="otros"
                            {{ old('categoria') === 'otros' ? 'selected' : '' }}
                        >
                            Otros
                        </option>

                    </select>

                    @error('categoria')
                        <span class="error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <!-- DESCRIPCIÓN -->

                <div class="campo">

                    <label for="descripcion">
                        <i class="fa-solid fa-align-left"></i>
                        Descripción
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        maxlength="1000"
                        placeholder="Escribe una descripción del gasto..."
                    >{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <span class="error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <!-- BOTÓN -->

                <div class="contenedor-boton">

                    <button
                        type="submit"
                        class="boton-guardar"
                    >
                        <i class="fa-solid fa-save"></i>
                        Registrar gasto
                    </button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>

