@php
    $cliente = $cliente ?? null;
    $esEdicion = $cliente !== null;

    $accion = $esEdicion
        ? route('admin.clientes.actualizar', $cliente->id)
        : route('admin.clientes.guardar');

    $fechaNacimiento = old(
        'fecha_nacimiento',
        $cliente?->fecha_nacimiento ? substr((string) $cliente->fecha_nacimiento, 0, 10) : null
    );
@endphp

<x-formulario-estilos />

<div class="frm-pagina">
    <div class="frm-encabezado">
        <div>
            <h1>{{ $esEdicion ? 'Editar cliente' : 'Nuevo cliente' }}</h1>
            <p>
                {{ $esEdicion
                    ? 'Modifica los datos de ' . trim($cliente->name . ' ' . $cliente->apellido) . '.'
                    : 'Registra un nuevo cliente en el sistema.' }}
            </p>
        </div>

        <div class="frm-acciones">
            <a href="{{ route('admin.clientes') }}" class="frm-btn-cancelar">Cancelar</a>
            <button type="submit" form="formCliente" class="frm-btn-guardar" id="btnGuardar">
                {{ $esEdicion ? 'Guardar cambios' : 'Registrar cliente' }}
            </button>
        </div>
    </div>

    @if(session('error'))
        <div class="frm-alerta">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="frm-alerta">Revisa los campos marcados e inténtalo de nuevo.</div>
    @endif

    <form id="formCliente" action="{{ $accion }}" method="POST">
        @csrf
        @if($esEdicion)
            @method('PUT')
        @endif

        <div class="frm-grid">
            <section class="frm-card">
                <h2 class="frm-card-titulo">Información personal</h2>
                <div class="frm-fila">
                    <div class="frm-campo">
                        <label for="name">Nombre <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $cliente?->name) }}"
                                maxlength="255"
                                class="{{ $errors->has('name') ? 'invalido' : '' }}"
                                required
                                {{ $esEdicion ? '' : 'autofocus' }}
                            >
                        </div>
                        @error('name')
                            <span class="frm-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="frm-campo">
                        <label for="apellido">Apellidos <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <input
                                type="text"
                                id="apellido"
                                name="apellido"
                                value="{{ old('apellido', $cliente?->apellido) }}"
                                maxlength="255"
                                class="{{ $errors->has('apellido') ? 'invalido' : '' }}"
                                required
                            >
                        </div>
                        @error('apellido')
                            <span class="frm-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="frm-fila">
                    <div class="frm-campo">
                        <label for="email">Correo electrónico <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $cliente?->email) }}"
                                placeholder="correo@ejemplo.com"
                                maxlength="255"
                                class="{{ $errors->has('email') ? 'invalido' : '' }}"
                                required
                            >
                        </div>
                        @error('email')
                            <span class="frm-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="frm-campo">
                        <label for="telefono">Teléfono</label>
                        <div class="frm-control">
                            <input
                                type="tel"
                                id="telefono"
                                name="telefono"
                                value="{{ old('telefono', $cliente?->telefono) }}"
                                maxlength="20"
                                class="{{ $errors->has('telefono') ? 'invalido' : '' }}"
                            >
                        </div>
                        @error('telefono')
                            <span class="frm-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </section>
            <section class="frm-card">
                <h2 class="frm-card-titulo">Datos adicionales</h2>
                <div class="frm-campo">
                    <label for="direccion">Dirección</label>
                    <div class="frm-control">
                        <input
                            type="text"
                            id="direccion"
                            name="direccion"
                            value="{{ old('direccion', $cliente?->direccion) }}"
                            maxlength="255"
                            class="{{ $errors->has('direccion') ? 'invalido' : '' }}"
                        >
                    </div>
                    @error('direccion')
                        <span class="frm-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="frm-campo">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <div class="frm-control">
                        <input
                            type="date"
                            id="fecha_nacimiento"
                            name="fecha_nacimiento"
                            value="{{ $fechaNacimiento }}"
                            class="{{ $errors->has('fecha_nacimiento') ? 'invalido' : '' }}"
                        >
                    </div>
                    @error('fecha_nacimiento')
                        <span class="frm-error">{{ $message }}</span>
                    @enderror
                </div>

                @unless($esEdicion)
                    <p class="frm-ayuda">
                        El cliente se registra sin contraseña. Al intentar iniciar sesión con su correo,
                        el sistema le pedirá crear una.
                    </p>
                @endunless
            </section>

        </div>
    </form>

</div>

@push('scripts')
<script>
    (function () {
        const formulario = document.getElementById('formCliente');
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