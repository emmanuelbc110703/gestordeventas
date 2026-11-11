<x-layouts.panel
    titulo="Punto de venta"
    :regresar="(auth()->user()->rol === 'admin' || auth()->user()->rol === 'administrador')
        ? route('admin.dashboard')
        : route('vendedor.dashboard')"
    :migas="[
        ['texto' => 'Punto de venta', 'url' => route('empleado.punto_venta')],
    ]"
>

<x-lista-estilos />

@push('estilos')
<style>
    .pv-cabecera {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 22px;
    }
    .pv-icono {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--primario);
        font-size: 22px;
    }
    .pv-cabecera h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 600;
        color: var(--texto);
    }
    .pv-cabecera span {
        display: block;
        margin-top: 3px;
        font-size: 13px;
        color: var(--texto-suave);
    }

    .pv-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(300px, 1fr);
        gap: 20px;
    }
    .pv-tarjeta {
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        padding: 24px;
    }
    .pv-tarjeta-titulo {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }
    .pv-tarjeta-titulo h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--texto);
    }

    .pv-estado {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        font-size: 11px;
        font-weight: 600;
        color: #047857;
    }
    .pv-estado i { font-size: 7px; }

    .pv-datos {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    .pv-dato {
        padding: 16px;
        background: #fff;
        border: 1px solid var(--borde);
    }
    .pv-etiqueta {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 8px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: var(--texto-suave);
    }
    .pv-etiqueta i { color: var(--primario); font-size: 12px; }
    .pv-valor {
        display: block;
        font-size: 15px;
        font-weight: 600;
        color: var(--texto);
        word-break: break-word;
    }

    .pv-reloj {
        margin-top: 18px;
        padding: 24px;
        border: 1px solid var(--borde);
        text-align: center;
    }
    .pv-fecha {
        margin-bottom: 6px;
        font-size: 14px;
        color: var(--texto-suave);
    }
    .pv-hora {
        font-size: 44px;
        font-weight: 700;
        letter-spacing: 1px;
        color: var(--primario);
        font-variant-numeric: tabular-nums;
    }

    .pv-apertura {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .pv-apertura-icono {
        width: 58px;
        height: 58px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primario);
        color: #fff;
        font-size: 24px;
    }
    .pv-apertura h3 {
        margin: 0 0 8px;
        font-size: 19px;
        font-weight: 600;
    }
    .pv-apertura p {
        margin: 0 0 20px;
        font-size: 13px;
        line-height: 1.5;
        color: var(--texto-suave);
    }

    .pv-btn-principal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 44px;
        padding: 0 18px;
        background: var(--primario);
        border: 1px solid var(--primario);
        border-radius: 0;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        transition: opacity 0.2s ease;
    }
    .pv-btn-principal:hover { opacity: 0.88; }
    .pv-btn-advertencia {
        background: #ea580c;
        border-color: #ea580c;
    }

    .pv-regresar {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 18px;
        font-size: 13px;
        color: var(--texto-suave);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .pv-regresar:hover { color: var(--primario); }

    .pv-modal-centro { text-align: center; }
    .pv-modal-icono {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 28px;
    }
    .pv-icono-info   { background: #f5f3ff; color: var(--primario); }
    .pv-icono-exito  { background: #ecfdf5; color: #047857; }
    .pv-icono-alerta { background: #fffbeb; color: #d97706; }
    .pv-icono-error  { background: #fef2f2; color: #b91c1c; }

    .pv-mensaje {
        margin: 0 0 18px;
        font-size: 14px;
        line-height: 1.5;
        color: var(--texto-suave);
    }
    .pv-info {
        margin-bottom: 16px;
        padding: 6px 16px;
        border: 1px solid var(--borde);
        text-align: left;
    }
    .pv-info .fila {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding: 9px 0;
        border-bottom: 1px solid var(--borde);
    }
    .pv-info .fila:last-child { border-bottom: none; }
    .pv-info span { font-size: 13px; color: var(--texto-suave); }
    .pv-info strong { font-size: 14px; text-align: right; color: var(--texto); }

    .pv-aviso {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        margin-bottom: 16px;
        padding: 12px;
        text-align: left;
        font-size: 13px;
        line-height: 1.45;
    }
    .pv-aviso-amarillo { background: #fffbeb; border: 1px solid #fde68a; color: #78350f; }
    .pv-aviso-amarillo i { color: #d97706; margin-top: 2px; }
    .pv-aviso-naranja { background: #fff7ed; border: 1px solid #fdba74; color: #7c2d12; }
    .pv-aviso-naranja i { color: #ea580c; margin-top: 2px; }

    .pv-grupo-dinero { text-align: left; margin-bottom: 16px; }
    .pv-grupo-dinero label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--texto);
    }
    .pv-campo-dinero { position: relative; }
    .pv-campo-dinero span {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        font-weight: 700;
        color: var(--primario);
    }
    .pv-campo-dinero input {
        width: 100%;
        height: 48px;
        padding: 0 14px 0 34px;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-family: inherit;
        font-size: 18px;
        outline: none;
        transition: border-color 0.2s ease;
    }
    .pv-campo-dinero input:focus { border-color: var(--primario); }

    .pv-dinero-inicial {
        margin-bottom: 16px;
        padding: 16px;
        border: 1px solid var(--borde);
    }
    .pv-dinero-inicial span {
        display: block;
        margin-bottom: 4px;
        font-size: 13px;
        color: var(--texto-suave);
    }
    .pv-dinero-inicial strong {
        font-size: 28px;
        color: var(--primario);
    }

    .pv-continuar {
        margin-top: 18px;
        font-size: 13px;
        color: var(--texto-suave);
    }
    .pv-barra {
        width: 100%;
        height: 4px;
        margin-top: 10px;
        background: #eee;
        overflow: hidden;
    }
    #progresoCaja {
        width: 100%;
        height: 100%;
        background: var(--primario);
        animation: pvDisminuir 5s linear forwards;
    }
    @keyframes pvDisminuir {
        from { width: 100%; }
        to   { width: 0%; }
    }

    .pv-form-botones { display: flex; flex-direction: column; gap: 8px; }
    .pv-form-botones .lst-btn-cancelar { width: 100%; }

    @media (max-width: 1200px) {
        .pv-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 800px) {
        .pv-datos { grid-template-columns: 1fr; }
        .pv-hora { font-size: 36px; }
    }
</style>
@endpush

<x-sidebar activo="punto_venta" />

<div class="lst-pagina">
    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Punto de venta</h1>
            </div>
            <p>Verifica los datos de tu punto de venta antes de comenzar operaciones.</p>
        </div>
    </div>

    <div class="pv-cabecera">
        <div class="pv-icono">
            <i class="fa-solid fa-cash-register"></i>
        </div>
        <div>
            <h3>{{ $puntoVenta->nombre_caja }}</h3>
            <span>Punto de venta asignado</span>
        </div>
    </div>

    <div class="pv-grid">
        <div class="pv-tarjeta">
            <div class="pv-tarjeta-titulo">
                <h3>Información del punto</h3>

                @if(session('caja_abierta') && session('punto_venta_id') == $puntoVenta->id)
                    <span class="pv-estado">
                        <i class="fa-solid fa-circle"></i>
                        Caja abierta
                    </span>
                @else
                    <span class="pv-estado">
                        <i class="fa-solid fa-circle"></i>
                        Disponible
                    </span>
                @endif
            </div>

            <div class="pv-datos">
                <div class="pv-dato">
                    <span class="pv-etiqueta">
                        <i class="fa-solid fa-store"></i>
                        Sucursal
                    </span>
                    <span class="pv-valor">{{ $puntoVenta->sucursal }}</span>
                </div>

                <div class="pv-dato">
                    <span class="pv-etiqueta">
                        <i class="fa-solid fa-hashtag"></i>
                        Número de caja
                    </span>
                    <span class="pv-valor">{{ $puntoVenta->numero_caja }}</span>
                </div>

                <div class="pv-dato">
                    <span class="pv-etiqueta">
                        <i class="fa-solid fa-cash-register"></i>
                        Nombre de caja
                    </span>
                    <span class="pv-valor">{{ $puntoVenta->nombre_caja }}</span>
                </div>
            </div>

            <div class="pv-reloj">
                <div class="pv-fecha" id="fecha">Cargando fecha...</div>
                <div class="pv-hora" id="hora">00:00:00</div>
            </div>
        </div>

        <div class="pv-tarjeta pv-apertura">
            <div class="pv-apertura-icono">
                <i class="fa-solid fa-lock-open"></i>
            </div>

            <h3>Abrir caja</h3>

            <p>
                Registra el dinero inicial de cambio
                para comenzar las operaciones de esta caja.
            </p>

            @if(!session('caja_abierta') || session('punto_venta_id') != $puntoVenta->id)
                <button type="button" class="pv-btn-principal" onclick="mostrarFormularioCaja()">
                    <i class="fa-solid fa-lock-open"></i>
                    Abrir caja
                </button>
            @else
                <a href="{{ route('punto_venta.caja', $puntoVenta->id) }}" class="pv-btn-principal">
                    <i class="fa-solid fa-cash-register"></i>
                    Entrar a caja
                </a>
            @endif

            @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'administrador')
                <a href="{{ route('admin.dashboard') }}" class="pv-regresar">
                    <i class="fa-solid fa-arrow-left"></i>
                    Regresar al dashboard
                </a>
            @else
                <a href="{{ route('vendedor.dashboard') }}" class="pv-regresar">
                    <i class="fa-solid fa-arrow-left"></i>
                    Regresar
                </a>
            @endif
        </div>
    </div>
</div>

<div class="lst-modal" id="modalApertura" role="dialog" aria-modal="true" aria-labelledby="tituloApertura">
    <div class="lst-modal-caja pv-modal-centro">
        <div class="pv-modal-icono pv-icono-info">
            <i class="fa-solid fa-cash-register"></i>
        </div>

        <h2 id="tituloApertura">Apertura de caja</h2>

        <p class="pv-mensaje">
            Antes de comenzar las operaciones,
            registra el dinero inicial de la caja.
        </p>

        <div class="pv-info">
            <div class="fila">
                <span>Sucursal</span>
                <strong>{{ $puntoVenta->sucursal }}</strong>
            </div>
            <div class="fila">
                <span>Caja</span>
                <strong>{{ $puntoVenta->nombre_caja }}</strong>
            </div>
            <div class="fila">
                <span>Fecha de apertura</span>
                <strong id="fechaApertura">—</strong>
            </div>
            <div class="fila">
                <span>Hora de apertura</span>
                <strong id="horaApertura">—</strong>
            </div>
        </div>

        <div class="pv-aviso pv-aviso-amarillo">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>
                Verifica cuidadosamente el dinero de cambio
                antes de abrir la caja. Esta cantidad será
                registrada como dinero inicial.
            </span>
        </div>

        <form action="{{ route('punto_venta.abrir', $puntoVenta->id) }}" method="POST">
            @csrf

            <div class="pv-grupo-dinero">
                <label for="dinero_inicial">Dinero inicial / Cambio</label>

                <div class="pv-campo-dinero">
                    <span>$</span>
                    <input
                        type="number"
                        name="dinero_inicial"
                        id="dinero_inicial"
                        min="0"
                        step="0.01"
                        placeholder="0.00"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="pv-form-botones">
                <button type="submit" class="pv-btn-principal">
                    <i class="fa-solid fa-check"></i>
                    Confirmar apertura
                </button>

                <button type="button" class="lst-btn-cancelar" onclick="cerrarFormularioCaja()">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
<div class="lst-modal" id="modalFueraHorario" role="dialog" aria-modal="true" aria-labelledby="tituloFueraHorario">
    <div class="lst-modal-caja pv-modal-centro">
        <div class="pv-modal-icono pv-icono-alerta">
            <i class="fa-solid fa-clock"></i>
        </div>

        <h2 id="tituloFueraHorario">Apertura fuera de horario</h2>

        <p class="pv-mensaje">
            Actualmente estás intentando abrir la caja
            fuera del horario normal de trabajo.
        </p>

        <div class="pv-info">
            <div class="fila">
                <span>Horario de trabajo</span>
                <strong>08:00 - 20:00</strong>
            </div>
            <div class="fila">
                <span>Hora actual</span>
                <strong id="horaFueraHorario">—</strong>
            </div>
        </div>

        <div class="pv-aviso pv-aviso-naranja">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span>
                <strong>Importante:</strong>
                no se solicitará dinero inicial.
                <br><br>
                Las ventas realizadas fuera del horario
                de trabajo se considerarán para el
                <strong>día siguiente</strong>.
            </span>
        </div>

        <form action="{{ route('punto_venta.abrir', $puntoVenta->id) }}" method="POST">
            @csrf

            <div class="pv-form-botones">
                <button type="submit" class="pv-btn-principal pv-btn-advertencia">
                    <i class="fa-solid fa-arrow-right"></i>
                    Continuar sin dinero inicial
                </button>

                <button type="button" class="lst-btn-cancelar" onclick="cerrarFueraHorario()">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('error'))
    <div class="lst-modal activo" id="modalError" role="dialog" aria-modal="true">
        <div class="lst-modal-caja pv-modal-centro">
            <div class="pv-modal-icono pv-icono-error">
                <i class="fa-solid fa-xmark"></i>
            </div>

            <h2>No se pudo abrir</h2>

            <p class="pv-mensaje">{{ session('error') }}</p>

            <button
                type="button"
                class="pv-btn-principal"
                onclick="document.getElementById('modalError').classList.remove('activo')"
            >
                Entendido
            </button>
        </div>
    </div>
@endif

@if(session('mostrar_apertura'))
    <div class="lst-modal activo" id="overlayCaja" role="dialog" aria-modal="true">
        <div class="lst-modal-caja pv-modal-centro">
            <div class="pv-modal-icono pv-icono-exito">
                <i class="fa-solid fa-check"></i>
            </div>

            <h2>¡Caja abierta!</h2>

            <p class="pv-mensaje">La caja está lista para comenzar operaciones.</p>

            <div class="pv-dinero-inicial">
                <span>Dinero inicial / Cambio</span>
                <strong>${{ number_format(session('dinero_inicial', 0), 2) }}</strong>
            </div>

            <div class="pv-info">
                <div class="fila">
                    <span>Fecha de apertura</span>
                    <strong>{{ session('fecha_apertura') }}</strong>
                </div>
                <div class="fila">
                    <span>Hora de apertura</span>
                    <strong>{{ session('hora_apertura') }}</strong>
                </div>
            </div>

            @if(session('caja_fuera_horario'))
                <div class="pv-aviso pv-aviso-naranja">
                    <i class="fa-solid fa-clock"></i>
                    <span>
                        La caja fue abierta
                        <strong>fuera del horario normal.</strong>
                        Las ventas realizadas fuera del horario
                        se considerarán para el día siguiente.
                    </span>
                </div>
            @else
                <div class="pv-aviso pv-aviso-amarillo">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>
                        El dinero inicial quedó registrado.
                        Revisa que la cantidad mostrada sea correcta
                        antes de comenzar a realizar operaciones.
                    </span>
                </div>
            @endif

            <div class="pv-continuar">Entrando a la caja registradora...</div>

            <div class="pv-barra">
                <div id="progresoCaja"></div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = "{{ route('punto_venta.caja', $puntoVenta->id) }}";
        }, 5000);
    </script>
@endif

@push('scripts')
<script>
    (function () {
        const modalApertura = document.getElementById('modalApertura');
        const modalFueraHorario = document.getElementById('modalFueraHorario');

        function actualizarFechaHora() {
            const ahora = new Date();

            let fecha = ahora.toLocaleDateString('es-MX', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            fecha = fecha.charAt(0).toUpperCase() + fecha.slice(1);

            document.getElementById('fecha').textContent = fecha;

            const horas = String(ahora.getHours()).padStart(2, '0');
            const minutos = String(ahora.getMinutes()).padStart(2, '0');
            const segundos = String(ahora.getSeconds()).padStart(2, '0');

            document.getElementById('hora').textContent = `${horas}:${minutos}:${segundos}`;
        }

        actualizarFechaHora();
        setInterval(actualizarFechaHora, 1000);

        function actualizarDatosApertura() {
            const ahora = new Date();

            document.getElementById('fechaApertura').textContent = ahora.toLocaleDateString('es-MX', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            document.getElementById('horaApertura').textContent = ahora.toLocaleTimeString('es-MX', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        function actualizarHoraFueraHorario() {
            const elemento = document.getElementById('horaFueraHorario');

            if (elemento) {
                elemento.textContent = new Date().toLocaleTimeString('es-MX', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }
        }

        window.mostrarFormularioCaja = function () {
            const hora = new Date().getHours();
            const dentroHorario = hora >= 8 && hora < 20;

            if (dentroHorario) {
                modalApertura.classList.add('activo');
                actualizarDatosApertura();

                setTimeout(function () {
                    const input = document.getElementById('dinero_inicial');
                    if (input) input.focus();
                }, 100);
            } else {
                modalFueraHorario.classList.add('activo');
                actualizarHoraFueraHorario();
            }
        };

        window.cerrarFormularioCaja = function () {
            modalApertura.classList.remove('activo');
        };

        window.cerrarFueraHorario = function () {
            modalFueraHorario.classList.remove('activo');
        };

        document.addEventListener('keydown', function (evento) {
            if (evento.key === 'Escape') {
                cerrarFormularioCaja();
                cerrarFueraHorario();
            }
        });
    })();
</script>
@endpush

</x-layouts.panel>
