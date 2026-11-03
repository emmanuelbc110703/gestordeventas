@push('estilos')
<style>
    .frm-pagina {
        padding: 48px 0 56px;
    }
    .frm-encabezado {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        padding-bottom: 24px;
        margin-bottom: 28px;
        border-bottom: 1px solid var(--borde);
    }
    .frm-encabezado h1 {
        margin: 0 0 6px;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--texto);
    }
    .frm-encabezado p {
        margin: 0;
        font-size: 15px;
        color: var(--texto-suave);
    }
    .frm-acciones {
        display: flex;
        gap: 12px;
    }
    .frm-btn-cancelar,
    .frm-btn-guardar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        padding: 0 22px;
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .frm-btn-cancelar {
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--texto);
    }
    .frm-btn-cancelar:hover {
        border-color: #c4b5fd;
        background: #fcfbff;
    }
    .frm-btn-guardar {
        background: var(--primario);
        border: 1px solid var(--primario);
        color: #fff;
    }
    .frm-btn-guardar:hover {
        background: var(--primario-oscuro);
        border-color: var(--primario-oscuro);
    }
    .frm-btn-guardar:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .frm-alerta {
        margin-bottom: 24px;
        padding: 14px 18px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        font-size: 14px;
        font-weight: 600;
        color: #b42318;
    }
    .frm-grid {
        display: grid;
        grid-template-columns: 3fr 2fr;
        gap: 32px;
        align-items: start;
    }
    .frm-card {
        padding: 32px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
    }
    .frm-card-titulo {
        margin: 0 0 24px;
        padding-bottom: 14px;
        border-bottom: 1px solid #f0f0f3;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--texto-suave);
    }
    .frm-campo {
        margin-bottom: 24px;
    }
    .frm-campo:last-child {
        margin-bottom: 0;
    }
    .frm-fila {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    .frm-fila.una-columna {
        grid-template-columns: 1fr;
    }
    .frm-fila:last-child {
        margin-bottom: 0;
    }
    .frm-fila .frm-campo {
        margin-bottom: 0;
    }
    .frm-campo label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
    }
    .frm-req {
        color: #dc2626;
    }
    .frm-control {
        position: relative;
    }
    .frm-control input,
    .frm-control select {
        width: 100%;
        height: 44px;
        padding: 0 14px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        color: var(--texto);
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .frm-control input::placeholder {
        color: #9ca3af;
    }
    .frm-control input:focus,
    .frm-control select:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .frm-control .invalido {
        border-color: #dc2626;
    }
    .frm-control select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 40px;
        cursor: pointer;
    }
    .frm-icono-select {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 11px;
        color: var(--texto-suave);
        pointer-events: none;
    }
    .frm-error {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: #b42318;
    }
    .frm-ayuda {
        margin: 8px 0 0;
        font-size: 13px;
        line-height: 1.5;
        color: var(--texto-suave);
    }

    @media (max-width: 950px) {
        .frm-grid { grid-template-columns: 1fr; gap: 24px; }
    }
    @media (max-width: 650px) {
        .frm-pagina { padding: 28px 0 40px; }
        .frm-encabezado { flex-direction: column; align-items: stretch; }
        .frm-encabezado h1 { font-size: 26px; }
        .frm-acciones { width: 100%; }
        .frm-btn-cancelar,
        .frm-btn-guardar { flex: 1; }
        .frm-card { padding: 22px; }
        .frm-fila { grid-template-columns: 1fr; gap: 24px; }
    }
</style>
@endpush