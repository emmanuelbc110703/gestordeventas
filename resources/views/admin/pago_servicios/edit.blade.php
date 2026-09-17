<!DOCTYPE html>

<html lang="es">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar servicio</title>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
>

<style>

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: #f5f5f5;
        font-family: Arial, Helvetica, sans-serif;
        color: #333;
    }

    .contenedor {
        width: 95%;
        max-width: 900px;
        margin: 40px auto;
    }

    .encabezado {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .titulo h1 {
        margin: 0;
        color: #5b21b6;
        font-size: 28px;
    }

    .titulo p {
        margin: 7px 0 0;
        color: #777;
    }

    .btn-regresar {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 7px;
        font-weight: bold;
    }

    .btn-regresar:hover {
        background: #5c636a;
    }

    .panel {
        background: white;
        border-radius: 13px;
        padding: 25px;
        box-shadow: 0 3px 15px rgba(0,0,0,.08);
    }

    .panel-titulo {
        margin: 0 0 25px;
        color: #444;
        font-size: 21px;
    }

    .panel-titulo i {
        color: #6f42c1;
        margin-right: 7px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .campo {
        display: flex;
        flex-direction: column;
    }

    .campo-completo {
        grid-column: 1 / -1;
    }

    .campo label {
        font-size: 13px;
        font-weight: bold;
        color: #444;
        margin-bottom: 7px;
    }

    .campo input,
    .campo select,
    .campo textarea {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #ccc;
        border-radius: 7px;
        outline: none;
        font-family: inherit;
        background: white;
    }

    .campo input:focus,
    .campo select:focus,
    .campo textarea:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 2px rgba(111,66,193,.12);
    }

    .campo textarea {
        min-height: 110px;
        resize: vertical;
    }

    .errores {
        background: #f8d7da;
        color: #842029;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .acciones {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-cancelar,
    .btn-guardar {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: none;
        padding: 11px 18px;
        border-radius: 7px;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-cancelar {
        background: #6c757d;
        color: white;
    }

    .btn-guardar {
        background: #6f42c1;
        color: white;
    }

    .btn-guardar:hover {
        background: #59339d;
    }

    @media(max-width: 650px) {

        .encabezado {
            flex-direction: column;
            align-items: stretch;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .campo-completo {
            grid-column: auto;
        }

    }

</style>


</head>

<body>

<div class="contenedor">


<!-- ENCABEZADO -->

<div class="encabezado">

    <div class="titulo">

        <h1>

            <i class="fa-solid fa-pen-to-square"></i>

            Editar servicio

        </h1>

        <p>
            Modifica la información del servicio.
        </p>

    </div>


    <a
        href="{{ route('admin.pago_servicios.index') }}"
        class="btn-regresar"
    >

        <i class="fa-solid fa-arrow-left"></i>

        Regresar

    </a>

</div>


<!-- ERRORES -->

@if($errors->any())

    <div class="errores">

        <strong>
            Revisa los siguientes errores:
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


<!-- FORMULARIO -->

<div class="panel">

    <h2 class="panel-titulo">

        <i class="fa-solid fa-file-invoice-dollar"></i>

        Información del servicio

    </h2>


    <form
        action="{{ route(
            'admin.pago_servicios.update',
            $pagoServicio
        ) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        <div class="form-grid">


            <!-- SERVICIO -->

            <div class="campo">

                <label>
                    Tipo de servicio *
                </label>

                <select
                    name="servicio"
                    required
                >

                    <option value="">
                        Seleccionar servicio
                    </option>

                    <option
                        value="Luz"
                        {{ old(
                            'servicio',
                            $pagoServicio->servicio
                        ) == 'Luz'
                            ? 'selected'
                            : '' }}
                    >
                        💡 Luz
                    </option>

                    <option
                        value="Agua"
                        {{ old(
                            'servicio',
                            $pagoServicio->servicio
                        ) == 'Agua'
                            ? 'selected'
                            : '' }}
                    >
                        💧 Agua
                    </option>

                    <option
                        value="Internet"
                        {{ old(
                            'servicio',
                            $pagoServicio->servicio
                        ) == 'Internet'
                            ? 'selected'
                            : '' }}
                    >
                        🌐 Internet
                    </option>

                    <option
                        value="Permiso"
                        {{ old(
                            'servicio',
                            $pagoServicio->servicio
                        ) == 'Permiso'
                            ? 'selected'
                            : '' }}
                    >
                        📄 Permiso
                    </option>

                    <option
                        value="Otro"
                        {{ old(
                            'servicio',
                            $pagoServicio->servicio
                        ) == 'Otro'
                            ? 'selected'
                            : '' }}
                    >
                        📌 Otro
                    </option>

                </select>

            </div>


            <!-- DESCRIPCIÓN -->

            <div class="campo">

                <label>
                    Descripción
                </label>

                <input
                    type="text"
                    name="descripcion"
                    value="{{ old(
                        'descripcion',
                        $pagoServicio->descripcion
                    ) }}"
                    placeholder="Ej. Recibo CFE"
                >

            </div>


            <!-- FECHA DE PAGO -->

            <div class="campo">

                <label>
                    Fecha de pago *
                </label>

                <input
                    type="date"
                    name="fecha_pago"
                    value="{{ old(
                        'fecha_pago',
                        optional(
                            $pagoServicio->fecha_pago
                        )->format('Y-m-d')
                    ) }}"
                    required
                >

            </div>


            <!-- FECHA DE VENCIMIENTO -->

            <div class="campo">

                <label>
                    Fecha de vencimiento
                </label>

                <input
                    type="date"
                    name="fecha_vencimiento"
                    value="{{ old(
                        'fecha_vencimiento',
                        optional(
                            $pagoServicio->fecha_vencimiento
                        )->format('Y-m-d')
                    ) }}"
                >

            </div>


            <!-- MONTO -->

            <div class="campo">

                <label>
                    Monto
                </label>

                <input
                    type="number"
                    name="monto"
                    value="{{ old(
                        'monto',
                        $pagoServicio->monto
                    ) }}"
                    min="0"
                    step="0.01"
                    placeholder="0.00"
                >

            </div>


            <!-- ESTADO -->

            <div class="campo">

                <label>
                    Estado *
                </label>

                <select
                    name="estado"
                    required
                >

                    <option
                        value="Pendiente"
                        {{ old(
                            'estado',
                            $pagoServicio->estado
                        ) == 'Pendiente'
                            ? 'selected'
                            : '' }}
                    >
                        Pendiente
                    </option>

                    <option
                        value="Pagado"
                        {{ old(
                            'estado',
                            $pagoServicio->estado
                        ) == 'Pagado'
                            ? 'selected'
                            : '' }}
                    >
                        Pagado
                    </option>

                </select>

            </div>


            <!-- OBSERVACIONES -->

            <div class="campo campo-completo">

                <label>
                    Observaciones
                </label>

                <textarea
                    name="observaciones"
                    placeholder="Información adicional..."
                >{{ old(
                    'observaciones',
                    $pagoServicio->observaciones
                ) }}</textarea>

            </div>


        </div>


        <!-- ACCIONES -->

        <div class="acciones">

            <a
                href="{{ route('admin.pago_servicios.index') }}"
                class="btn-cancelar"
            >

                <i class="fa-solid fa-xmark"></i>

                Cancelar

            </a>


            <button
                type="submit"
                class="btn-guardar"
            >

                <i class="fa-solid fa-floppy-disk"></i>

                Guardar cambios

            </button>

        </div>


    </form>

</div>


</div>

</body>

</html>
