@php
    $empleado = $empleado ?? null;
    $esEdicion = $empleado !== null;

    $accion = $esEdicion
        ? route('admin.empleados.actualizar', $empleado->id)
        : route('admin.empleados.guardar');

    $rolActual = old('rol', $empleado?->rol);
@endphp

<x-formulario-estilos />

<div class="frm-pagina">
    <div class="frm-encabezado">
        <div>
            <h1>{{ $esEdicion ? 'Editar empleado' : 'Nuevo empleado' }}</h1>
            <p>
                {{ $esEdicion
                    ? 'Modifica los datos de ' . trim($empleado->name . ' ' . $empleado->apellido) . '.'
                    : 'Registra un nuevo administrador o vendedor.' }}
            </p>
        </div>

        <div class="frm-acciones">
            <a href="{{ route('admin.empleados') }}" class="frm-btn-cancelar">Cancelar</a>
            <button type="submit" form="formEmpleado" class="frm-btn-guardar" id="btnGuardar">
                {{ $esEdicion ? 'Guardar cambios' : 'Registrar empleado' }}
            </button>
        </div>
    </div>

    @if(session('error'))
        <div class="frm-alerta">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="frm-alerta">Revisa los campos marcados e inténtalo de nuevo.</div>
    @endif

    <form id="formEmpleado" action="{{ $accion }}" method="POST">
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
                                value="{{ old('name', $empleado?->name) }}"
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
                                value="{{ old('apellido', $empleado?->apellido) }}"
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

                <div class="frm-campo">
                    <label for="email">Correo electrónico <span class="frm-req">*</span></label>
                    <div class="frm-control">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $empleado?->email) }}"
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

                <div class="frm-fila {{ $esEdicion ? 'una-columna' : '' }}">
                    <div class="frm-campo">
                        <label for="telefono">Teléfono</label>
                        <div class="frm-control">
                            <input
                                type="tel"
                                id="telefono"
                                name="telefono"
                                value="{{ old('telefono', $empleado?->telefono) }}"
                                maxlength="20"
                                class="{{ $errors->has('telefono') ? 'invalido' : '' }}"
                            >
                        </div>
                        @error('telefono')
                            <span class="frm-error">{{ $message }}</span>
                        @enderror
                    </div>

                    @unless($esEdicion)
                        <div class="frm-campo">
                            <label for="fecha_nacimiento">Fecha de nacimiento</label>
                            <div class="frm-control">
                                <input
                                    type="date"
                                    id="fecha_nacimiento"
                                    name="fecha_nacimiento"
                                    value="{{ old('fecha_nacimiento') }}"
                                    class="{{ $errors->has('fecha_nacimiento') ? 'invalido' : '' }}"
                                >
                            </div>
                            @error('fecha_nacimiento')
                                <span class="frm-error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endunless
                </div>

                @unless($esEdicion)
                    <div class="frm-campo" style="margin-top: 24px;">
                        <label for="direccion">Dirección</label>
                        <div class="frm-control">
                            <input
                                type="text"
                                id="direccion"
                                name="direccion"
                                value="{{ old('direccion') }}"
                                maxlength="255"
                                class="{{ $errors->has('direccion') ? 'invalido' : '' }}"
                            >
                        </div>
                        @error('direccion')
                            <span class="frm-error">{{ $message }}</span>
                        @enderror
                    </div>
                @endunless
            </section>

            <section class="frm-card">
                <h2 class="frm-card-titulo">Cuenta de acceso</h2>

                <div class="frm-campo">
                    <label for="rol">Rol <span class="frm-req">*</span></label>
                    <div class="frm-control">
                        <select
                            id="rol"
                            name="rol"
                            class="{{ $errors->has('rol') ? 'invalido' : '' }}"
                            required
                        >
                            <option value="" disabled {{ $rolActual ? '' : 'selected' }}>Selecciona un rol</option>
                            <option value="admin" {{ $rolActual === 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="vendedor" {{ $rolActual === 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                        </select>
                        <i class="fa-solid fa-chevron-down frm-icono-select"></i>
                    </div>
                    @error('rol')
                        <span class="frm-error">{{ $message }}</span>
                    @enderror
                </div>

                @unless($esEdicion)
                    <div class="frm-campo">
                        <label for="password">Contraseña <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                autocomplete="new-password"
                                class="{{ $errors->has('password') ? 'invalido' : '' }}"
                                required
                            >
                        </div>
                        @error('password')
                            <span class="frm-error">{{ $message }}</span>
                        @enderror
                        <p class="frm-ayuda">Mínimo 8 caracteres.</p>
                    </div>

                    <div class="frm-campo">
                        <label for="password_confirmation">Confirmar contraseña <span class="frm-req">*</span></label>
                        <div class="frm-control">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                autocomplete="new-password"
                                required
                            >
                        </div>
                    </div>
                @else
                    <p class="frm-ayuda">La contraseña del empleado no se modifica desde esta pantalla.</p>
                @endunless
            </section>
        </div>
    </form>
</div>

@push('scripts')
<script>
    (function () {
        const formulario = document.getElementById('formEmpleado');
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