<style>
    .pagina-promo { padding: 40px 0 56px; }
    .promo-encabezado { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; padding-bottom: 24px; margin-bottom: 28px; border-bottom: 1px solid var(--borde); }
    .promo-encabezado h1 { margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -0.02em; color: var(--texto); }
    .promo-encabezado p { margin: 6px 0 0; font-size: 15px; color: var(--texto-suave); }
    .btn-p, .btn-p-sec, .btn-p-peligro { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 44px; padding: 0 20px; border-radius: 0; font-family: inherit; font-size: 15px; font-weight: 600; text-decoration: none; white-space: nowrap; cursor: pointer; }
    .btn-p { background: var(--primario); border: 1px solid var(--primario); color: #fff; }
    .btn-p:hover { background: var(--primario-oscuro); border-color: var(--primario-oscuro); }
    .btn-p-sec { background: #fff; border: 1px solid var(--borde); color: var(--texto); }
    .btn-p-sec:hover { border-color: #c4b5fd; background: #fcfbff; }
    .btn-p-peligro { background: #fff; border: 1px solid #fecaca; color: #b42318; }
    .btn-p-peligro:hover { background: #b42318; color: #fff; }
    .btn-p-chico { height: 34px; padding: 0 12px; font-size: 13px; }

    .mensaje-exito { display: flex; align-items: center; gap: 10px; margin-bottom: 24px; padding: 14px 18px; background: #ecfdf3; border: 1px solid #bbf7d0; color: #15803d; font-size: 14px; font-weight: 600; }
    .errores { margin-bottom: 24px; padding: 16px 20px; background: #fef2f2; border: 1px solid #fecaca; color: #b42318; font-size: 14px; }
    .errores ul { margin: 8px 0 0; padding-left: 20px; }

    .tabla-wrap { background: #fff; border: 1px solid var(--borde); overflow-x: auto; }
    .tabla-promo { width: 100%; border-collapse: collapse; font-size: 14px; }
    .tabla-promo th { text-align: left; padding: 14px 18px; background: #f9fafb; border-bottom: 1px solid var(--borde); font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--texto-suave); }
    .tabla-promo td { padding: 14px 18px; border-bottom: 1px solid #f0f0f3; color: var(--texto); vertical-align: middle; }
    .tabla-promo tr:last-child td { border-bottom: none; }
    .tabla-promo .nombre-promo { font-weight: 600; }
    .tabla-promo .desc-promo { display: block; margin-top: 2px; font-size: 12px; color: var(--texto-suave); }
    .acciones-fila { display: flex; gap: 8px; justify-content: flex-end; }
    .acciones-fila form { margin: 0; }

    .estado { display: inline-block; padding: 3px 10px; font-size: 12px; font-weight: 600; border: 1px solid var(--borde); }
    .estado.vigente { background: #ecfdf3; border-color: #bbf7d0; color: #15803d; }
    .estado.programada { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
    .estado.vencida, .estado.inactiva { background: #f3f4f6; color: #6b7280; }

    .vacio { padding: 56px 20px; text-align: center; color: var(--texto-suave); }
    .vacio i { margin-bottom: 12px; font-size: 36px; color: #c4b5fd; }

    .tarjeta { background: #fff; border: 1px solid var(--borde); padding: 36px; }
    .campo { margin-bottom: 24px; }
    .campo label.etiqueta { display: block; margin-bottom: 8px; font-size: 15px; font-weight: 600; color: #1f2937; }
    .campo input[type=text], .campo input[type=number], .campo input[type=date], .campo select, .campo textarea { width: 100%; height: 48px; padding: 0 14px; background: #fff; border: 1px solid var(--borde); border-radius: 0; font-family: inherit; font-size: 15px; color: var(--texto); outline: none; }
    .campo textarea { height: auto; min-height: 110px; padding: 12px 14px; resize: vertical; }
    .campo input:focus, .campo select:focus, .campo textarea:focus { border-color: var(--primario); box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1); }
    .fila-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    .valor-wrap { position: relative; }
    .valor-wrap .simbolo { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none; }
    .valor-wrap input { padding-left: 34px !important; }
    .check-linea { display: flex; align-items: center; gap: 10px; }
    .check-linea input { width: 18px; height: 18px; margin: 0; accent-color: var(--primario); }

    .lista-productos { max-height: 280px; overflow-y: auto; border: 1px solid var(--borde); }
    .lista-productos label { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-bottom: 1px solid #f0f0f3; font-size: 14px; cursor: pointer; }
    .lista-productos label:last-child { border-bottom: none; }
    .lista-productos label:hover { background: var(--primario-suave); }
    .lista-productos input { accent-color: var(--primario); }
    .lista-productos small { margin-left: auto; color: var(--texto-suave); }
    .ayuda { margin: 6px 0 0; font-size: 13px; color: #9ca3af; }

    .acciones-pie { display: flex; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 24px; border-top: 1px solid var(--borde); }

    @media (max-width: 650px) {
        .promo-encabezado { flex-direction: column; align-items: stretch; }
        .fila-2 { grid-template-columns: 1fr; gap: 0; }
        .tarjeta { padding: 22px; }
    }
</style>