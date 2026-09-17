<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Agregar servicio</title>

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
        max-width: 1450px;
        margin: 30px auto;
    }

    /* =========================
       ENCABEZADO
    ========================= */

    .encabezado {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .titulo h1 {
        margin: 0;
        color: #5b21b6;
        font-size: 28px;
    }

    .titulo p {
        margin-top: 7px;
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
        color: white;
    }


    /* =========================
       CONTENIDO
    ========================= */

    .contenido {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 22px;
        align-items: start;
    }

    .panel {
        background: white;
        border-radius: 13px;
        padding: 22px;
        box-shadow: 0 3px 15px rgba(0,0,0,.08);
    }

    .panel-titulo {
        margin: 0 0 20px;
        color: #444;
        font-size: 20px;
    }

    .panel-titulo i {
        color: #6f42c1;
        margin-right: 7px;
    }


    /* =========================
       FORMULARIO
    ========================= */

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 17px;
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
        margin-bottom: 7px;
        color: #444;
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
        min-height: 100px;
        resize: vertical;
    }

    .ayuda {
        font-size: 11px;
        color: #888;
        margin-top: 5px;
    }


    /* =========================
       BOTONES
    ========================= */

    .acciones {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-cancelar,
    .btn-guardar {
        border: none;
        padding: 11px 18px;
        border-radius: 7px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
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


    /* =========================
       ERRORES
    ========================= */

    .errores {
        background: #f8d7da;
        color: #842029;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media(max-width: 950px) {

        .contenido {
            grid-template-columns: 1fr;
        }

    }

    @media(max-width: 600px) {

        .encabezado {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
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


<!-- =========================
     ENCABEZADO
========================= -->

<div class="encabezado">

    <div class="titulo">

        <h1>

            <i class="fa-solid fa-file-invoice-dollar"></i>

            Agregar servicio

        </h1>

        <p>
            Registra un nuevo servicio del negocio.
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


<!-- =========================
     ERRORES
========================= -->

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


<!-- =========================
     CONTENIDO
========================= -->

<div class="contenido">


    <!-- =========================
         INFORMACIÓN
    ========================= -->

    <div class="panel">

        <h2 class="panel-titulo">

            <i class="fa-regular fa-calendar-days"></i>

            Información del servicio

        </h2>


        <form
            action="{{ route('admin.pago_servicios.store') }}"
            method="POST"
        >

            @csrf


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
                            {{ old('servicio') == 'Luz' ? 'selected' : '' }}
                        >
                            💡 Luz
                        </option>

                        <option
                            value="Agua"
                            {{ old('servicio') == 'Agua' ? 'selected' : '' }}
                        >
                            💧 Agua
                        </option>

                        <option
                            value="Internet"
                            {{ old('servicio') == 'Internet' ? 'selected' : '' }}
                        >
                            🌐 Internet
                        </option>

                        <option
                            value="Permiso"
                            {{ old('servicio') == 'Permiso' ? 'selected' : '' }}
                        >
                            📄 Permiso
                        </option>

                        <option
                            value="Otro"
                            {{ old('servicio') == 'Otro' ? 'selected' : '' }}
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
                        value="{{ old('descripcion') }}"
                        placeholder="Ej. Recibo CFE"
                    >

                </div>


                <!-- FECHA -->

                <div class="campo">

                    <label>
                        Fecha de pago *
                    </label>

                    <input
                        type="date"
                        name="fecha_pago"
                        value="{{ old('fecha_pago') }}"
                        required
                    >

                    <span class="ayuda">
                        Esta fecha aparecerá en el calendario.
                    </span>

                </div>


                <!-- VENCIMIENTO -->

                <div class="campo">

                    <label>
                        Fecha de vencimiento
                    </label>

                    <input
                        type="date"
                        name="fecha_vencimiento"
                        value="{{ old('fecha_vencimiento') }}"
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
                        value="{{ old('monto') }}"
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
                            {{ old('estado', 'Pendiente') == 'Pendiente'
                                ? 'selected'
                                : '' }}
                        >
                            Pendiente
                        </option>

                        <option
                            value="Pagado"
                            {{ old('estado') == 'Pagado'
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
                        placeholder="Agrega cualquier información adicional..."
                    >{{ old('observaciones') }}</textarea>

                </div>


            </div>


            <!-- BOTONES -->

            <div class="acciones">

                <a
                    href="{{ route('admin.pago_servicios.index') }}"
                    class="btn-cancelar"
                >

                    Cancelar

                </a>


                <button
                    type="submit"
                    class="btn-guardar"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    Guardar servicio

                </button>

            </div>


        </form>

    </div>


    <!-- =========================
         AYUDA
    ========================= -->

    <div class="panel">

        <h2 class="panel-titulo">

            <i class="fa-solid fa-circle-info"></i>

            Información

        </h2>


        <p>
            Registra aquí los servicios que tenga que pagar
            el negocio.
        </p>


        <div style="
            background:#f4efff;
            padding:15px;
            border-radius:8px;
            margin-top:15px;
        ">

            <strong>
                <i class="fa-solid fa-lightbulb"></i>
                Consejo
            </strong>

            <p style="margin-bottom:0; color:#666;">

                La fecha de pago que selecciones será utilizada
                para mostrar el servicio dentro del calendario.

            </p>

        </div>


        <div style="margin-top:25px;">

            <strong>
                Servicios disponibles:
            </strong>


            <ul style="line-height:2; color:#666;">

                <li>
                    💡 Luz
                </li>

                <li>
                    💧 Agua
                </li>

                <li>
                    🌐 Internet
                </li>

                <li>
                    📄 Permisos
                </li>

                <li>
                    📌 Otros servicios
                </li>

            </ul>

        </div>

    </div>


</div>


</div>

</body>

</html>
