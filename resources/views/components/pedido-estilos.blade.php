@push('estilos')
<style>
    .ped-estado {
        display: inline-block;
        padding: 3px 10px;
        border: 1px solid var(--borde);
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    .ped-estado.enviado {
        background: #fffbeb;
        border-color: #fde68a;
        color: #b45309;
    }
    .ped-estado.procesando {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1d4ed8;
    }
    .ped-estado.finalizado {
        background: var(--primario-suave);
        border-color: #ddd6fe;
        color: var(--primario);
    }
    .ped-estado.terminado {
        background: #ecfdf3;
        border-color: #bbf7d0;
        color: #15803d;
    }

    .ped-folio {
        font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        font-size: 13px;
        font-weight: 600;
    }
    .frm-encabezado .ped-estado {
        margin-left: 10px;
    }
    .ped-exito {
        margin-bottom: 24px;
        padding: 14px 18px;
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        font-size: 14px;
        font-weight: 600;
        color: #15803d;
    }
    .ped-form-accion {
        display: flex;
        margin: 0;
    }
    .ped-form-accion button {
        flex: 1;
    }
    .ped-card-plana {
        padding: 0;
    }
    .ped-card-plana .frm-card-titulo {
        margin: 0;
        padding: 20px 24px;
        border-bottom: none;
    }
    .ped-tabla-wrap {
        overflow-x: auto;
    }
    .ped-tabla {
        width: 100%;
        border-collapse: collapse;
    }
    .ped-tabla th {
        padding: 12px 16px;
        background: #fafafb;
        border-top: 1px solid var(--borde);
        border-bottom: 1px solid var(--borde);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-align: left;
        text-transform: uppercase;
        color: var(--texto-suave);
        white-space: nowrap;
    }
    .ped-tabla td {
        padding: 14px 16px;
        border-bottom: 1px solid #f0f0f3;
        font-size: 14px;
        color: var(--texto);
        vertical-align: middle;
    }
    .ped-tabla tbody tr:last-child td {
        border-bottom: none;
    }
    .ped-tabla th:first-child,
    .ped-tabla td:first-child {
        padding-left: 24px;
    }
    .ped-tabla th:last-child,
    .ped-tabla td:last-child {
        padding-right: 24px;
    }
    .ped-tabla .num {
        text-align: right;
        font-variant-numeric: tabular-nums;
    }
    .ped-nombre {
        font-weight: 600;
    }
    .ped-vacio-fila {
        padding: 28px 24px;
        text-align: center;
        color: #9ca3af;
    }
    .ped-cantidad {
        width: 96px;
        height: 38px;
        padding: 0 10px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        text-align: right;
        color: var(--texto);
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .ped-cantidad:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .ped-cantidad.invalido {
        border-color: #dc2626;
    }
    .ped-totales {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
        padding: 20px 24px 24px;
        border-top: 1px solid var(--borde);
    }
    .ped-resumen {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .ped-linea {
        display: flex;
        justify-content: space-between;
        gap: 40px;
        min-width: 300px;
        font-size: 14px;
        color: var(--texto-suave);
    }
    .ped-linea span:last-child {
        color: var(--texto);
        font-variant-numeric: tabular-nums;
    }
    .ped-resumen .ped-linea {
        min-width: 0;
        width: 100%;
    }
    .ped-linea.total {
        margin-top: 6px;
        padding-top: 12px;
        border-top: 1px solid var(--borde);
        font-size: 17px;
        font-weight: 700;
        color: var(--texto);
    }
    .ped-info {
        margin: 0;
    }
    .ped-info > div {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f3;
        font-size: 14px;
    }
    .ped-info > div:first-child {
        padding-top: 0;
    }
    .ped-info > div:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }
    .ped-info dt {
        color: var(--texto-suave);
    }
    .ped-info dd {
        margin: 0;
        font-weight: 600;
        text-align: right;
        word-break: break-word;
    }
    .ped-info dd.vacio {
        font-weight: 400;
        color: #9ca3af;
    }

    .ped-columna {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    @media (max-width: 650px) {
        .frm-acciones .ped-form-accion {
            flex: 1;
        }
        .ped-linea {
            min-width: 0;
            width: 100%;
        }
        .ped-totales {
            align-items: stretch;
        }
        .ped-card-plana .frm-card-titulo {
            padding: 18px 20px;
        }
        .ped-tabla th:first-child,
        .ped-tabla td:first-child {
            padding-left: 20px;
        }
        .ped-tabla th:last-child,
        .ped-tabla td:last-child {
            padding-right: 20px;
        }
        .ped-cantidad {
            width: 80px;
        }
    }
</style>
@endpush