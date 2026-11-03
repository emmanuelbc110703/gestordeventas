@php
    $puntoVenta = $puntoVenta ?? null;
    $esEdicion = $puntoVenta !== null;

    $accion = $esEdicion
        ? route('admin.puntos_venta.update', $puntoVenta->id)
        : route('admin.puntos_venta.store');

    $etiquetasRol = [
        'admin' => 'Administrador',
        'administrador' => 'Administrador',
        'vendedor' => 'Vendedor',
    ];

    $empleadoActual = old('empleado_id', $puntoVenta?->empleado_id);
@endphp

@push('estilos')
<style>
    .pvf-pagina {
        padding: 48px 0 56px;
    }
    .pvf-encabezado {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        padding-bottom: 24px;
        margin-bottom: 28px;
        border-bottom: 1px solid var(--borde);
    }
    .pvf-encabezado h1 {
        margin: 0 0 6px;
        font-size: 32px;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--texto);
    }
    .pvf-encabezado p {
        margin: 0;
        font-size: 15px;
        color: var(--texto-suave);
    }
    .pvf-acciones {
        display: flex;
        gap: 12px;
    }
    .pvf-btn-cancelar,
    .pvf-btn-guardar {
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
    .pvf-btn-cancelar {
        background: #fff;
        border: 1px solid var(--borde);
        color: var(--texto);
    }
    .pvf-btn-cancelar:hover {
        border-color: #c4b5fd;
        background: #fcfbff;
    }
    .pvf-btn-guardar {
        background: var(--primario);
        border: 1px solid var(--primario);
        color: #fff;
    }
    .pvf-btn-guardar:hover {
        background: var(--primario-oscuro);
        border-color: var(--primario-oscuro);
    }
    .pvf-btn-guardar:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .pvf-alerta {
        margin-bottom: 24px;
        padding: 14px 18px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        font-size: 14px;
        font-weight: 600;
        color: #b42318;
    }

    .pvf-grid {
        display: grid;
        grid-template-columns: 3fr 2fr;
        gap: 32px;
        align-items: start;
    }
    .pvf-card {
        padding: 32px;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
    }
    .pvf-card-titulo {
        margin: 0 0 24px;
        padding-bottom: 14px;
        border-bottom: 1px solid #f0f0f3;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--texto-suave);
    }

    .pvf-campo {
        margin-bottom: 24px;
    }
    .pvf-campo:last-child {
        margin-bottom: 0;
    }
    .pvf-fila {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }
    .pvf-fila .pvf-campo {
        margin-bottom: 0;
    }
    .pvf-campo label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
    }
    .pvf-req {
        color: #dc2626;
    }
    .pvf-control {
        position: relative;
    }
    .pvf-control input,
    .pvf-control select {
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
    .pvf-control input::placeholder {
        color: #9ca3af;
    }
    .pvf-control input:focus,
    .pvf-control select:focus {
        border-color: var(--primario);
        box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1);
    }
    .pvf-control .invalido {
        border-color: #dc2626;
    }
    .pvf-control select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 40px;
        cursor: pointer;
    }
    .pvf-icono-select {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 11px;
        color: var(--texto-suave);
        pointer-events: none;
    }
    .pvf-error {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: #b42318;
    }
    .pvf-ayuda {
        margin: 10px 0 0;
        font-size: 13px;
        line-height: 1.5;
        color: var(--texto-suave);
    }

    @media (max-width: 950px) {
        .pvf-grid { grid-template-columns: 1fr; gap: 24px; }
    }
    @media (max-width: 650px) {
        .pvf-pagina { padding: 28px 0 40px; }
        .pvf-encabezado { flex-direction: column; align-items: stretch; }
        .pvf-encabezado h1 { font-size: 26px; }
        .pvf-acciones { width: 100%; }
        .pvf-btn-cancelar,
        .pvf-btn-guardar { flex: 1; }
        .pvf-card { padding: 22px; }
        .pvf-fila { grid-template-columns: 1fr; gap: 24px; }
    }
</style>
@endpush

<div class="pvf-pagina">
    <div class="pvf-encabezado">
        <div>
            <h1>{{ $esEdicion ? 'Editar punto de venta' : 'Nuevo punto de venta' }}</h1>
            <p>
                {{ $esEdicion
                    ? 'Modifica los datos de la caja y el empleado asignado.'
                    : 'Registra una nueva caja y asígnala a un empleado.' }}
            </p>
        </div>

        <div class="pvf-acciones">
            <a href="{{ route('admin.puntos_venta') }}" class="pvf-btn-cancelar">Cancelar</a>
            <button type="submit" form="formPuntoVenta" class="pvf-btn-guardar" id="btnGuardar">
                {{ $esEdicion ? 'Guardar cambios' : 'Crear punto de venta' }}
            </button>
        </div>
    </div>

    @if(session('error'))
        <div class="pvf-alerta">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="pvf-alerta">Revisa los campos marcados e inténtalo de nuevo.</div>
    @endif

    <form id="formPuntoVenta" action="{{ $accion }}" method="POST">
        @csrf
        @if($esEdicion)
            @method('PUT')
        @endif

        <div class="pvf-grid">
            <section class="pvf-card">
                <h2 class="pvf-card-titulo">Información de la caja</h2>
                <div class="pvf-campo">
                    <label for="nombre_caja">Nombre de la caja <span class="pvf-req">*</span></label>
                    <div class="pvf-control">
                        <input
                            type="text"
                            id="nombre_caja"
                            name="nombre_caja"
                            value="{{ old('nombre_caja', $puntoVenta?->nombre_caja) }}"
                            placeholder="Ej. Caja principal"
                            maxlength="255"
                            class="{{ $errors->has('nombre_caja') ? 'invalido' : '' }}"
                            required
                            {{ $esEdicion ? '' : 'autofocus' }}
                        >
                    </div>
                    @error('nombre_caja')
                        <span class="pvf-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pvf-fila">
                    <div class="pvf-campo">
                        <label for="numero_caja">Número de caja <span class="pvf-req">*</span></label>
                        <div class="pvf-control">
                            <input
                                type="text"
                                id="numero_caja"
                                name="numero_caja"
                                value="{{ old('numero_caja', $puntoVenta?->numero_caja) }}"
                                placeholder="Ej. 1"
                                maxlength="50"
                                class="{{ $errors->has('numero_caja') ? 'invalido' : '' }}"
                                required
                            >
                        </div>
                        @error('numero_caja')
                            <span class="pvf-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="pvf-campo">
                        <label for="sucursal">Sucursal <span class="pvf-req">*</span></label>
                        <div class="pvf-control">
                            <input
                                type="text"
                                id="sucursal"
                                name="sucursal"
                                value="{{ old('sucursal', $puntoVenta?->sucursal) }}"
                                placeholder="Ej. Sucursal centro"
                                maxlength="255"
                                class="{{ $errors->has('sucursal') ? 'invalido' : '' }}"
                                required
                            >
                        </div>
                        @error('sucursal')
                            <span class="pvf-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </section>
            <section class="pvf-card">
                <h2 class="pvf-card-titulo">Asignación</h2>

                <div class="pvf-campo">
                    <label for="empleado_id">Empleado <span class="pvf-req">*</span></label>
                    <div class="pvf-control">
                        <select
                            id="empleado_id"
                            name="empleado_id"
                            class="{{ $errors->has('empleado_id') ? 'invalido' : '' }}"
                            required
                        >
                            <option value="" disabled {{ $empleadoActual ? '' : 'selected' }}>
                                Selecciona un empleado
                            </option>

                            @foreach($empleados as $empleado)
                                <option
                                    value="{{ $empleado->id }}"
                                    {{ (string) $empleadoActual === (string) $empleado->id ? 'selected' : '' }}
                                >
                                    {{ trim($empleado->name . ' ' . $empleado->apellido) }}
                                    ({{ $etiquetasRol[$empleado->rol] ?? $empleado->rol }})
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down pvf-icono-select"></i>
                    </div>
                    @error('empleado_id')
                        <span class="pvf-error">{{ $message }}</span>
                    @enderror
                    <p class="pvf-ayuda">Cada empleado solo puede tener un punto de venta asignado.</p>
                </div>
            </section>

        </div>
    </form>

</div>

@push('scripts')
<script>
    (function () {
        const formulario = document.getElementById('formPuntoVenta');
        const boton = document.getElementById('btnGuardar');

        formulario.addEventListener('submit', function () {
            boton.disabled = true;
        });

        window.addEventListener('pageshow', function () {
            boton.disabled = false;
        });
    })();
</script>
@endpush