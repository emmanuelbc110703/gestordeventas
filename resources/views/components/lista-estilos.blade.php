@push('estilos')
<style>
    :root {
        --lst-rojo: #dc2626;
        --lst-rojo-oscuro: #b91c1c;
        --lst-rojo-suave: #fef2f2;
    }

    .lst-pagina {
        padding: 48px 0 56px;
    }

    .lst-encabezado {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        padding-bottom: 24px;
        margin-bottom: 28px;
        border-bottom: 1px solid var(--borde);
    }
    .lst-titulo-fila {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 6px;
    }
    .lst-encabezado h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--texto);
    }
    .lst-encabezado p {
        margin: 0;
        font-size: 15px;
        color: var(--texto-suave);
    }
    .lst-btn-principal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        padding: 0 22px;
        background: var(--primario);
        border: 1px solid var(--primario);
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        white-space: nowrap;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .lst-btn-principal:hover {
        background: var(--primario-oscuro);
        border-color: var(--primario-oscuro);
    }

    .lst-mensaje {
        margin-bottom: 24px;
        padding: 14px 18px;
        font-size: 14px;
        font-weight: 600;
    }
    .lst-mensaje.exito {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #15803d;
    }
    .lst-mensaje.error {
        background: var(--lst-rojo-suave);
        border: 1px solid #fecaca;
        color: var(--lst-rojo-oscuro);
    }

    .lst-herramientas {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px 16px;
        margin-bottom: 20px;
    }
    .lst-controles {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px 14px;
        margin-left: auto;
        min-width: 0;
    }

    .lst-tabs {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 4px;
        padding: 4px;
        min-width: 0;
        background: #f1f2f6;
        border: 1px solid var(--borde);
    }
    .lst-tab {
        height: 36px;
        padding: 0 18px;
        background: transparent;
        border: none;
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        font-weight: 500;
        color: var(--texto-suave);
        white-space: nowrap;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .lst-tab:hover { color: var(--primario); }
    .lst-tab.activo {
        background: #fff;
        color: var(--primario);
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
    }

    .lst-buscador {
        position: relative;
        flex: 1 1 220px;
        width: auto;
        max-width: 320px;
        min-width: 180px;
    }
    .lst-buscador > i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 13px;
        pointer-events: none;
    }
    .lst-buscador input {
        width: 100%;
        height: 44px;
        padding: 0 40px 0 38px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        color: var(--texto);
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .lst-buscador input::placeholder { color: #9ca3af; }
    .lst-buscador input:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .lst-btn-limpiar {
        display: none;
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        width: 28px;
        height: 28px;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        border-radius: 0;
        color: #9ca3af;
        font-size: 13px;
        cursor: pointer;
        transition: color 0.2s ease, background 0.2s ease;
    }
    .lst-btn-limpiar:hover {
        color: var(--primario);
        background: var(--primario-suave);
    }

    .lst-selector {
        position: relative;
    }
    .lst-selector select {
        height: 44px;
        min-width: 220px;
        padding: 0 38px 0 16px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        appearance: none;
        -webkit-appearance: none;
        font-family: inherit;
        font-size: 14px;
        color: var(--texto);
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .lst-selector select:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .lst-selector i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 11px;
        color: var(--texto-suave);
        pointer-events: none;
    }

    .lst-contador {
        font-size: 14px;
        color: var(--texto-suave);
        white-space: nowrap;
    }
    .lst-contador strong {
        color: var(--texto);
        font-weight: 700;
    }

    .lst-tabla-wrap {
        background: #fff;
        border: 1px solid var(--borde);
        overflow-x: auto;
    }
    .lst-tabla {
        width: 100%;
        border-collapse: collapse;
    }
    .lst-tabla th {
        padding: 14px 20px;
        background: #fafafb;
        border-bottom: 1px solid var(--borde);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-align: left;
        text-transform: uppercase;
        color: var(--texto-suave);
        white-space: nowrap;
    }
    .lst-tabla td {
        padding: 16px 20px;
        border-bottom: 1px solid #f0f0f3;
        font-size: 14px;
        color: var(--texto);
        vertical-align: middle;
    }
    .lst-tabla tbody tr:last-child td {
        border-bottom: none;
    }
    .lst-tabla tbody tr {
        transition: background 0.15s ease;
        cursor: pointer;
    }
    .lst-tabla tbody tr:hover {
        background: #fcfbff;
    }
    .lst-sin-dato {
        color: #9ca3af;
    }
    .lst-col-acciones {
        width: 1%;
        white-space: nowrap;
        text-align: right;
    }
    .lst-tabla th.lst-col-acciones {
        text-align: right;
    }
    .lst-acciones {
        display: inline-flex;
        gap: 8px;
    }
    .lst-btn-editar,
    .lst-btn-eliminar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        padding: 0;
        border-radius: 0;
        font-family: inherit;
        font-size: 13px;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
    }
    .lst-btn-editar {
        background: var(--primario-suave);
        border: 1px solid #ddd6fe;
        color: var(--primario);
    }
    .lst-btn-editar:hover {
        background: var(--primario);
        border-color: var(--primario);
        color: #fff;
    }
    .lst-btn-eliminar {
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--texto-suave);
    }
    .lst-btn-eliminar:hover {
        background: var(--lst-rojo);
        border-color: var(--lst-rojo);
        color: #fff;
    }

    .lst-vacio {
        display: none;
        padding: 56px 20px;
        background: #fff;
        border: 1px solid var(--borde);
        text-align: center;
        color: var(--texto-suave);
    }
    .lst-vacio.visible { display: block; }
    .lst-vacio h3 {
        margin: 0 0 4px;
        font-size: 17px;
        color: var(--texto);
    }
    .lst-vacio p {
        margin: 0;
        font-size: 14px;
    }

    .lst-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(17, 24, 39, 0.55);
    }
    .lst-modal.activo { display: flex; }
    .lst-modal-caja {
        width: 100%;
        max-width: 420px;
        padding: 28px;
        background: #fff;
        border: 1px solid var(--borde);
        border-top: 3px solid var(--lst-rojo);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }
    .lst-modal h2 {
        margin: 0 0 8px;
        font-size: 19px;
        font-weight: 700;
        color: var(--texto);
    }
    .lst-modal p {
        margin: 0 0 24px;
        font-size: 14px;
        line-height: 1.5;
        color: var(--texto-suave);
    }
    .lst-modal p strong { color: var(--texto); }
    .lst-modal-botones {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    .lst-btn-cancelar,
    .lst-btn-confirmar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 42px;
        padding: 0 22px;
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .lst-btn-cancelar {
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--texto);
    }
    .lst-btn-cancelar:hover {
        border-color: #c4b5fd;
        background: #fcfbff;
    }
    .lst-btn-confirmar {
        background: var(--lst-rojo);
        border: 1px solid var(--lst-rojo);
        color: #fff;
    }
    .lst-btn-confirmar:hover {
        background: var(--lst-rojo-oscuro);
        border-color: var(--lst-rojo-oscuro);
    }

    @media (max-width: 1100px) {
        .lst-herramientas { flex-direction: column; align-items: stretch; }
        .lst-controles { flex-wrap: wrap; }
        .lst-buscador { width: 100%; }
    }

    @media (max-width: 800px) {
        .lst-tabla thead { display: none; }
        .lst-tabla,
        .lst-tabla tbody,
        .lst-tabla tr,
        .lst-tabla td {
            display: block;
            width: 100%;
        }
        .lst-tabla tbody tr {
            padding: 8px 0;
            border-bottom: 1px solid var(--borde);
        }
        .lst-tabla tbody tr:last-child { border-bottom: none; }
        .lst-tabla td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 8px 18px;
            border: none;
            text-align: right;
        }
        .lst-tabla td::before {
            content: attr(data-label);
            flex-shrink: 0;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-align: left;
            color: var(--texto-suave);
        }
        .lst-tabla td.lst-col-acciones {
            width: 100%;
            justify-content: flex-end;
            padding-top: 12px;
        }
        .lst-tabla td.lst-col-acciones::before { display: none; }
    }

    @media (max-width: 650px) {
        .lst-controles { margin-left: 0; width: 100%; }
        .lst-buscador  { max-width: none; flex-basis: 100%; }
    }
</style>
@endpush