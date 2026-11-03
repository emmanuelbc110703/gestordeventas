<x-layouts.panel
    titulo="Puntos de venta"
    :regresar="route('admin.dashboard')"
    :migas="[
        ['texto' => 'Puntos de venta', 'url' => route('admin.puntos_venta')],
    ]"
>

@push('estilos')
<style>
    :root {
        --pv-rojo: #dc2626;
        --pv-rojo-oscuro: #b91c1c;
        --pv-rojo-suave: #fef2f2;
    }

    .pagina-pv {
        padding: 48px 0 56px;
    }

    .pv-encabezado {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        padding-bottom: 24px;
        margin-bottom: 28px;
        border-bottom: 1px solid var(--borde);
    }
    .pv-titulo-fila {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 6px;
    }
    .pv-encabezado h1 {
        margin: 0;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--texto);
    }
    .pv-encabezado p {
        margin: 0;
        font-size: 15px;
        color: var(--texto-suave);
    }
    .pv-btn-crear {
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
    .pv-btn-crear:hover {
        background: var(--primario-oscuro);
        border-color: var(--primario-oscuro);
    }

    .pv-mensaje {
        margin-bottom: 24px;
        padding: 14px 18px;
        font-size: 14px;
        font-weight: 600;
    }
    .pv-mensaje.exito {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #15803d;
    }
    .pv-mensaje.error {
        background: var(--pv-rojo-suave);
        border: 1px solid #fecaca;
        color: var(--pv-rojo-oscuro);
    }

    .pv-herramientas {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }
    .pv-controles {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .pv-buscador {
        position: relative;
        width: 340px;
    }
    .pv-buscador > i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 13px;
        pointer-events: none;
    }
    .pv-buscador input {
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
    .pv-buscador input::placeholder { color: #9ca3af; }
    .pv-buscador input:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .pv-btn-limpiar {
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
    .pv-btn-limpiar:hover {
        color: var(--primario);
        background: var(--primario-suave);
    }

    .pv-selector {
        position: relative;
    }
    .pv-selector select {
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
    .pv-selector select:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .pv-selector i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 11px;
        color: var(--texto-suave);
        pointer-events: none;
    }

    .pv-contador {
        font-size: 14px;
        color: var(--texto-suave);
        white-space: nowrap;
    }
    .pv-contador strong {
        color: var(--texto);
        font-weight: 700;
    }

    /* ===== TABLA ===== */
    .pv-tabla-wrap {
        background: #fff;
        border: 1px solid var(--borde);
        overflow-x: auto;
    }
    .pv-tabla {
        width: 100%;
        border-collapse: collapse;
    }
    .pv-tabla th {
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
    .pv-tabla td {
        padding: 16px 20px;
        border-bottom: 1px solid #f0f0f3;
        font-size: 14px;
        color: var(--texto);
        vertical-align: middle;
    }
    .pv-tabla tbody tr:last-child td {
        border-bottom: none;
    }
    .pv-tabla tbody tr {
        transition: background 0.15s ease;
        cursor: pointer;
    }
    .pv-tabla tbody tr:hover {
        background: #fcfbff;
    }
    .pv-nombre {
        font-weight: 600;
    }
    .pv-sin-asignar {
        color: #9ca3af;
    }
    .pv-col-acciones {
        width: 1%;
        white-space: nowrap;
        text-align: right;
    }
    .pv-tabla th.pv-col-acciones {
        text-align: right;
    }

    .pv-acciones {
        display: inline-flex;
        gap: 8px;
    }
    .pv-btn-editar,
    .pv-btn-eliminar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        padding: 0;
        border-radius: 0;
        font-family: inherit;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
    }
    .pv-btn-editar {
        background: var(--primario-suave);
        border: 1px solid #ddd6fe;
        color: var(--primario);
    }
    .pv-btn-editar:hover {
        background: var(--primario);
        border-color: var(--primario);
        color: #fff;
    }
    .pv-btn-eliminar {
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--texto-suave);
    }
    .pv-btn-eliminar:hover {
        background: var(--pv-rojo);
        border-color: var(--pv-rojo);
        color: #fff;
    }

    /* ===== SIN RESULTADOS ===== */
    .pv-vacio {
        display: none;
        padding: 56px 20px;
        background: #fff;
        border: 1px solid var(--borde);
        text-align: center;
        color: var(--texto-suave);
    }
    .pv-vacio.visible { display: block; }
    .pv-vacio h3 {
        margin: 0 0 4px;
        font-size: 17px;
        color: var(--texto);
    }
    .pv-vacio p {
        margin: 0;
        font-size: 14px;
    }
    .pv-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(17, 24, 39, 0.55);
    }
    .pv-modal.activo { display: flex; }
    .pv-modal-caja {
        width: 100%;
        max-width: 420px;
        padding: 28px;
        background: #fff;
        border: 1px solid var(--borde);
        border-top: 3px solid var(--pv-rojo);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }
    .pv-modal h2 {
        margin: 0 0 8px;
        font-size: 19px;
        font-weight: 700;
        color: var(--texto);
    }
    .pv-modal p {
        margin: 0 0 24px;
        font-size: 14px;
        line-height: 1.5;
        color: var(--texto-suave);
    }
    .pv-modal p strong { color: var(--texto); }
    .pv-modal-botones {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    .pv-btn-cancelar,
    .pv-btn-confirmar {
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
    .pv-btn-cancelar {
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--texto);
    }
    .pv-btn-cancelar:hover {
        border-color: #c4b5fd;
        background: #fcfbff;
    }
    .pv-btn-confirmar {
        background: var(--pv-rojo);
        border: 1px solid var(--pv-rojo);
        color: #fff;
    }
    .pv-btn-confirmar:hover {
        background: var(--pv-rojo-oscuro);
        border-color: var(--pv-rojo-oscuro);
    }

    @media (max-width: 1100px) {
        .pv-herramientas { flex-direction: column; align-items: stretch; }
        .pv-controles { flex-wrap: wrap; }
        .pv-buscador { width: 100%; }
    }

    @media (max-width: 800px) {
        .pv-tabla thead { display: none; }
        .pv-tabla,
        .pv-tabla tbody,
        .pv-tabla tr,
        .pv-tabla td {
            display: block;
            width: 100%;
        }
        .pv-tabla tbody tr {
        transition: background 0.15s ease;
        cursor: pointer;
     }
        .pv-tabla tbody tr:last-child { border-bottom: none; }
        .pv-tabla td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 8px 18px;
            border: none;
            text-align: right;
        }
        .pv-tabla td::before {
            content: attr(data-label);
            flex-shrink: 0;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-align: left;
            color: var(--texto-suave);
        }
        .pv-tabla td.pv-col-acciones {
            width: 100%;
            justify-content: flex-end;
            padding-top: 12px;
        }
        .pv-tabla td.pv-col-acciones::before { display: none; }
    }

    @media (max-width: 650px) {
        .pagina-pv { padding: 28px 0 40px; }
        .pv-encabezado { flex-direction: column; align-items: stretch; }
        .pv-encabezado h1 { font-size: 26px; }
        .pv-btn-crear { width: 100%; }
        .pv-controles { flex-direction: column; align-items: stretch; }
        .pv-selector select { width: 100%; }
        .pv-modal-botones { flex-direction: column-reverse; }
        .pv-btn-cancelar, .pv-btn-confirmar { width: 100%; }
    }
</style>
@endpush

<x-sidebar activo="puntos_venta" />

<div class="pagina-pv">
    <div class="pv-encabezado">
        <div>
            <div class="pv-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Puntos de venta</h1>
            </div>
            <p>Administra las cajas disponibles y los empleados asignados.</p>
        </div>

        <a href="{{ route('admin.puntos_venta.create') }}" class="pv-btn-crear">
            Crear punto de venta
        </a>
    </div>

    @if(session('success'))
        <div class="pv-mensaje exito">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="pv-mensaje error">{{ session('error') }}</div>
    @endif

    @if($puntosVenta->count() > 0)

        <!--Controles de busqueda y filtros-->
        <div class="pv-herramientas">
            <div class="pv-buscador">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorPuntos" placeholder="Buscar por caja, sucursal o empleado..." autocomplete="off">
                <button type="button" class="pv-btn-limpiar" id="btnLimpiar" aria-label="Limpiar búsqueda">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="pv-controles">

                <div class="pv-selector">
                    <select id="ordenPuntos">
                        <option value="az">Orden: Nombre (A – Z)</option>
                        <option value="za">Orden: Nombre (Z – A)</option>
                        <option value="sucursal">Orden: Sucursal (A – Z)</option>
                        <option value="caja">Orden: N.º de caja</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <span class="pv-contador" id="contadorPuntos">
                    <strong>{{ $puntosVenta->count() }}</strong>
                    {{ $puntosVenta->count() === 1 ? 'registro' : 'registros' }}
                </span>

            </div>
        </div>

        <div class="pv-tabla-wrap" id="tablaPuntos">
            <table class="pv-tabla">
                <thead>
                    <tr>
                        <th>Punto de venta</th>
                        <th>N.º de caja</th>
                        <th>Sucursal</th>
                        <th>Empleado</th>
                        <th class="pv-col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaPuntos">
                    @foreach($puntosVenta as $punto)
                        @php
                            $nombreEmpleado = $punto->empleado
                                ? trim($punto->empleado->name . ' ' . $punto->empleado->apellido)
                                : null;
                        @endphp

                        <tr
                            class="pv-fila"
                            data-url="{{ route('admin.puntos_venta.edit', $punto->id) }}"
                            data-nombre="{{ $punto->nombre_caja }}"
                            data-sucursal="{{ $punto->sucursal }}"
                            data-caja="{{ $punto->numero_caja }}"
                            data-empleado="{{ $nombreEmpleado }}"
                        >
                            <td data-label="Punto de venta" class="pv-nombre">{{ $punto->nombre_caja }}</td>
                            <td data-label="N.º de caja">{{ $punto->numero_caja }}</td>
                            <td data-label="Sucursal">{{ $punto->sucursal }}</td>
                            <td data-label="Empleado">
                                @if($nombreEmpleado)
                                    {{ $nombreEmpleado }}
                                @else
                                    <span class="pv-sin-asignar">Sin asignar</span>
                                @endif
                            </td>
                            <td class="pv-col-acciones">
                                <div class="pv-acciones">
                                    <a
                                        href="{{ route('admin.puntos_venta.edit', $punto->id) }}"
                                        class="pv-btn-editar"
                                        title="Editar"
                                        aria-label="Editar punto de venta"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="pv-btn-eliminar"
                                        title="Eliminar"
                                        aria-label="Eliminar punto de venta"
                                        data-eliminar
                                        data-id="{{ $punto->id }}"
                                        data-nombre="{{ $punto->nombre_caja }}"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pv-vacio" id="sinResultados">
            <h3>No se encontraron resultados</h3>
            <p>Intenta realizar otra búsqueda.</p>
        </div>
    @else
        <div class="pv-vacio visible">
            <h3>No hay puntos de venta</h3>
            <p>Todavía no has creado ningún punto de venta.</p>
        </div>

    @endif

</div>
<div class="pv-modal" id="modalEliminar" role="dialog" aria-modal="true" aria-labelledby="tituloModalEliminar">
    <div class="pv-modal-caja">

        <h2 id="tituloModalEliminar">Eliminar punto de venta</h2>
        <p id="mensajeEliminar"></p>

        <form id="formEliminar" method="POST">
            @csrf
            @method('DELETE')

            <div class="pv-modal-botones">
                <button type="button" class="pv-btn-cancelar" id="btnCancelarEliminar">
                    Cancelar
                </button>
                <button type="submit" class="pv-btn-confirmar">
                    Sí, eliminar
                </button>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    (function () {
        const modal = document.getElementById('modalEliminar');
        const formulario = document.getElementById('formEliminar');
        const mensaje = document.getElementById('mensajeEliminar');
        const urlEliminar = @js(route('admin.puntos_venta.destroy', '__ID__'));

        function abrirModal(id, nombre) {
            const fuerte = document.createElement('strong');
            fuerte.textContent = nombre;

            mensaje.textContent = '';
            mensaje.append(
                '¿Seguro que deseas eliminar el punto de venta ',
                fuerte,
                '? Esta acción no se puede deshacer.'
            );

            formulario.action = urlEliminar.replace('__ID__', id);
            modal.classList.add('activo');
        }

        function cerrarModal() {
            modal.classList.remove('activo');
        }

        document.querySelectorAll('[data-eliminar]').forEach(function (boton) {
            boton.addEventListener('click', function () {
                abrirModal(this.dataset.id, this.dataset.nombre);
            });
        });

        document.getElementById('btnCancelarEliminar').addEventListener('click', cerrarModal);

        modal.addEventListener('click', function (evento) {
            if (evento.target === modal) cerrarModal();
        });

        document.addEventListener('keydown', function (evento) {
            if (evento.key === 'Escape') cerrarModal();
        });

        const cuerpo = document.getElementById('listaPuntos');
        if (!cuerpo) return;


        cuerpo.addEventListener('click', function (evento) {
            if (evento.target.closest('a, button')) return;
            if (window.getSelection().toString()) return;

            const fila = evento.target.closest('.pv-fila');
            if (fila) window.location.href = fila.dataset.url;
        });

        const tabla = document.getElementById('tablaPuntos');
        const buscador = document.getElementById('buscadorPuntos');
        const btnLimpiar = document.getElementById('btnLimpiar');
        const orden = document.getElementById('ordenPuntos');
        const sinResultados = document.getElementById('sinResultados');
        const contador = document.getElementById('contadorPuntos');

        function normalizar(texto) {
            return (texto || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
        }

        function comparar(a, b) {
            return a.localeCompare(b, 'es', { sensitivity: 'base', numeric: true });
        }

        function aplicar() {
            const texto = normalizar(buscador.value);
            btnLimpiar.style.display = buscador.value ? 'flex' : 'none';

            const filas = Array.from(cuerpo.querySelectorAll('.pv-fila'));

            filas.sort(function (a, b) {
                switch (orden.value) {
                    case 'za':       return comparar(b.dataset.nombre, a.dataset.nombre);
                    case 'sucursal': return comparar(a.dataset.sucursal, b.dataset.sucursal);
                    case 'caja':     return comparar(a.dataset.caja, b.dataset.caja);
                    default:         return comparar(a.dataset.nombre, b.dataset.nombre);
                }
            });

            let visibles = 0;
            filas.forEach(function (fila) {
                cuerpo.appendChild(fila);

                const contenido = normalizar(
                    fila.dataset.nombre + ' ' +
                    fila.dataset.sucursal + ' ' +
                    fila.dataset.caja + ' ' +
                    fila.dataset.empleado
                );
                const mostrar = contenido.includes(texto);

                fila.style.display = mostrar ? '' : 'none';
                if (mostrar) visibles++;
            });

            tabla.style.display = visibles === 0 ? 'none' : '';
            sinResultados.classList.toggle('visible', visibles === 0);
            contador.innerHTML = '<strong>' + visibles + '</strong> ' + (visibles === 1 ? 'registro' : 'registros');
        }

        buscador.addEventListener('input', aplicar);
        orden.addEventListener('change', aplicar);

        btnLimpiar.addEventListener('click', function () {
            buscador.value = '';
            aplicar();
            buscador.focus();
        });

        aplicar();
    })();
</script>
@endpush

</x-layouts.panel>