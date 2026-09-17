<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar gasto - Gestor de Ventas Los Amates</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f4f4;
            font-family: Arial, sans-serif;
            color: #333;
        }

        header {
            background: #6a1b9a;
            color: white;
            padding: 20px 30px;
        }

        header h1 {
            margin: 0;
            font-size: 26px;
        }

        .contenedor {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .encabezado {
            margin-bottom: 20px;
        }

        .encabezado a {
            display: inline-block;
            color: #6a1b9a;
            text-decoration: none;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .encabezado a:hover {
            color: #4a126d;
        }

        .encabezado h1 {
            margin: 0;
            font-size: 28px;
        }

        .encabezado p {
            margin-top: 8px;
            color: #666;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .card h2 {
            margin-top: 0;
            color: #6a1b9a;
            margin-bottom: 25px;
        }

        .fila {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .campo input,
        .campo select,
        .campo textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            font-family: Arial, sans-serif;
        }

        .campo input:focus,
        .campo select:focus,
        .campo textarea:focus {
            outline: none;
            border-color: #6a1b9a;
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.1);
        }

        .campo textarea {
            resize: vertical;
            min-height: 120px;
        }

        .monto-contenedor {
            position: relative;
        }

        .monto-contenedor span {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #666;
        }

        .monto-contenedor input {
            padding-left: 28px;
        }

        .error {
            color: #d32f2f;
            font-size: 13px;
            margin-top: 5px;
        }

        .botones {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-cancelar {
            background: #e0e0e0;
            color: #333;
        }

        .btn-cancelar:hover {
            background: #ccc;
        }

        .btn-actualizar {
            background: #6a1b9a;
            color: white;
        }

        .btn-actualizar:hover {
            background: #4a126d;
        }

        @media (max-width: 600px) {
            .fila {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .card {
                padding: 20px;
            }

            .botones {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>Gestor de Ventas Los Amates</h1>
    </header>

    <div class="contenedor">

        <div class="encabezado">

            <a href="{{ route('admin.gastos_comerciales') }}">
                <i class="fa-solid fa-arrow-left"></i>
                Volver a gastos comerciales
            </a>

            <h1>Editar gasto comercial</h1>

            <p>
                Actualiza la información del gasto comercial
            </p>

        </div>

        <div class="card">

            <h2>
                <i class="fa-solid fa-pen-to-square"></i>
                Editar gasto
            </h2>

            <form action="{{ route('admin.gastos_comerciales.update', $gasto->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="fila">

                    {{-- Fecha --}}
                    <div class="campo">

                        <label for="fecha">
                            Fecha
                        </label>

                        <input
                            type="date"
                            id="fecha"
                            name="fecha"
                            value="{{ old('fecha', $gasto->fecha->format('Y-m-d')) }}"
                            required
                        >

                        @error('fecha')
                            <div class="error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Monto --}}
                    <div class="campo">

                        <label for="monto">
                            Monto
                        </label>

                        <div class="monto-contenedor">

                            <span>$</span>

                            <input
                                type="number"
                                id="monto"
                                name="monto"
                                value="{{ old('monto', $gasto->monto) }}"
                                min="0.01"
                                step="0.01"
                                placeholder="0.00"
                                required
                            >

                        </div>

                        @error('monto')
                            <div class="error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                {{-- Concepto --}}
                <div class="campo">

                    <label for="concepto">
                        Concepto
                    </label>

                    <input
                        type="text"
                        id="concepto"
                        name="concepto"
                        value="{{ old('concepto', $gasto->concepto) }}"
                        maxlength="255"
                        placeholder="Ej. Compra de material de oficina"
                        required
                    >

                    @error('concepto')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Categoría --}}
                <div class="campo">

                    <label for="categoria">
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

                        <option value="publicidad"
                            {{ old('categoria', $gasto->categoria) == 'publicidad' ? 'selected' : '' }}>
                            Publicidad
                        </option>

                        <option value="transporte"
                            {{ old('categoria', $gasto->categoria) == 'transporte' ? 'selected' : '' }}>
                            Transporte
                        </option>

                        <option value="papeleria"
                            {{ old('categoria', $gasto->categoria) == 'papeleria' ? 'selected' : '' }}>
                            Papelería
                        </option>

                        <option value="servicios"
                            {{ old('categoria', $gasto->categoria) == 'servicios' ? 'selected' : '' }}>
                            Servicios
                        </option>

                        <option value="mantenimiento"
                            {{ old('categoria', $gasto->categoria) == 'mantenimiento' ? 'selected' : '' }}>
                            Mantenimiento
                        </option>

                        <option value="compras"
                            {{ old('categoria', $gasto->categoria) == 'compras' ? 'selected' : '' }}>
                            Compras
                        </option>

                        <option value="otros"
                            {{ old('categoria', $gasto->categoria) == 'otros' ? 'selected' : '' }}>
                            Otros
                        </option>

                    </select>

                    @error('categoria')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Descripción --}}
                <div class="campo">

                    <label for="descripcion">
                        Descripción
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        maxlength="1000"
                        placeholder="Agrega una descripción del gasto..."
                    >{{ old('descripcion', $gasto->descripcion) }}</textarea>

                    @error('descripcion')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Botones --}}
                <div class="botones">

                    <a
                        href="{{ route('admin.gastos_comerciales') }}"
                        class="btn btn-cancelar"
                    >
                        <i class="fa-solid fa-xmark"></i>
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-actualizar"
                    >
                        <i class="fa-solid fa-pen-to-square"></i>
                        Actualizar gasto
                    </button>

                </div>

            </form>

        </div>

    </div>

</body>
</html>
