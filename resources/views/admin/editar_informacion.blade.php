@php
    $usuario = auth()->user();

    $nacimiento = $usuario->fecha_nacimiento;
    $nacimientoValor = $nacimiento
        ? (method_exists($nacimiento, 'format') ? $nacimiento->format('Y-m-d') : $nacimiento)
        : null;
@endphp

<x-layouts.panel
    titulo="Editar información"
    :regresar="route('admin.informacion')"
    :migas="[
        ['texto' => 'Mi información', 'url' => route('admin.informacion')],
        ['texto' => 'Editar'],
    ]"
>

@push('estilos')
<style>
    .ed-pagina {
        max-width: 820px;
        margin: 0 auto;
        padding: 24px 20px 40px;
    }
    .ed-encabezado { margin-bottom: 20px; }
    .ed-encabezado h1 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
        color: var(--texto, #1f2937);
    }
    .ed-encabezado p {
        margin: 4px 0 0;
        font-size: 14px;
        color: var(--texto-suave, #6b7280);
    }

    .ed-alerta {
        padding: 12px 16px;
        margin-bottom: 16px;
        font-size: 14px;
        border-radius: 6px;
        background: #fef3f2;
        border: 1px solid #fecdca;
        color: #b42318;
    }

    .ed-card {
        background: #fff;
        border: 1px solid var(--borde, #e5e7eb);
        border-radius: 8px;
    }
    .ed-card-head {
        padding: 14px 20px;
        border-bottom: 1px solid var(--borde, #e5e7eb);
    }
    .ed-card-head h2 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        color: var(--texto, #1f2937);
    }

    .ed-campos {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px 24px;
        padding: 20px;
    }
    .ed-campo { min-width: 0; }
    .ed-campo.completo { grid-column: 1 / -1; }

    .ed-campo label {
        display: block;
        margin-bottom: 6px;
        font-size: 12px;
        color: var(--texto-suave, #6b7280);
    }
    .ed-campo label .req { color: #d92d20; margin-left: 2px; }

    .ed-campo input {
        width: 100%;
        height: 36px;
        padding: 0 12px;
        font: inherit;
        font-size: 14px;
        color: var(--texto, #1f2937);
        background: #fff;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .ed-campo input:hover { border-color: #9ca3af; }
    .ed-campo input:focus {
        border-color: var(--primario, #6a1b9a);
        box-shadow: 0 0 0 3px var(--primario-suave, rgba(106, 27, 154, .14));
    }
    .ed-campo.con-error input { border-color: #d92d20; }
    .ed-campo.con-error input:focus { box-shadow: 0 0 0 3px #fee4e2; }

    .ed-error {
        margin-top: 6px;
        font-size: 12px;
        color: #d92d20;
    }

    .ed-acciones {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 14px 20px;
        border-top: 1px solid var(--borde, #e5e7eb);
        background: #f9fafb;
        border-radius: 0 0 8px 8px;
    }
    .ed-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 36px;
        padding: 0 16px;
        font: inherit;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 6px;
        cursor: pointer;
        border: 1px solid transparent;
    }
    .ed-btn-secundario {
        background: #fff;
        color: var(--texto, #1f2937);
        border-color: #d1d5db;
    }
    .ed-btn-secundario:hover { background: #f3f4f6; }
    .ed-btn-principal {
        background: var(--primario, #6a1b9a);
        color: #fff;
    }
    .ed-btn-principal:hover { background: var(--primario-oscuro, #4a126d); }
    .ed-btn:focus-visible {
        outline: 2px solid var(--primario, #6a1b9a);
        outline-offset: 2px;
    }

    @media (max-width: 600px) {
        .ed-campos { grid-template-columns: 1fr; }
        .ed-campo.completo { grid-column: auto; }
        .ed-acciones { flex-direction: column-reverse; }
        .ed-btn { width: 100%; }
    }
</style>
@endpush

<div class="ed-pagina">

    <div class="ed-encabezado">
        <h1>Editar información</h1>
        <p>Actualiza los datos de tu cuenta y guarda los cambios.</p>
    </div>

    @if($errors->any())
        <div class="ed-alerta" role="alert">
            Revisa los campos marcados en rojo antes de guardar.
        </div>
    @endif

    <form action="{{ route('admin.informacion.actualizar') }}" method="POST" class="ed-card" novalidate>
        @csrf
        @method('PUT')

        <div class="ed-card-head">
            <h2>Datos personales</h2>
        </div>

        <div class="ed-campos">

            <div class="ed-campo {{ $errors->has('name') ? 'con-error' : '' }}">
                <label for="name">Nombre<span class="req">*</span></label>
                <input type="text" id="name" name="name" required
                       value="{{ old('name', $usuario->name) }}">
                @error('name')<div class="ed-error">{{ $message }}</div>@enderror
            </div>

            <div class="ed-campo {{ $errors->has('apellido') ? 'con-error' : '' }}">
                <label for="apellido">Apellidos<span class="req">*</span></label>
                <input type="text" id="apellido" name="apellido" required
                       value="{{ old('apellido', $usuario->apellido) }}">
                @error('apellido')<div class="ed-error">{{ $message }}</div>@enderror
            </div>

            <div class="ed-campo completo {{ $errors->has('email') ? 'con-error' : '' }}">
                <label for="email">Correo electrónico<span class="req">*</span></label>
                <input type="email" id="email" name="email" required
                       value="{{ old('email', $usuario->email) }}">
                @error('email')<div class="ed-error">{{ $message }}</div>@enderror
            </div>

            <div class="ed-campo {{ $errors->has('telefono') ? 'con-error' : '' }}">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" inputmode="tel"
                       value="{{ old('telefono', $usuario->telefono) }}">
                @error('telefono')<div class="ed-error">{{ $message }}</div>@enderror
            </div>

            <div class="ed-campo {{ $errors->has('fecha_nacimiento') ? 'con-error' : '' }}">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                       value="{{ old('fecha_nacimiento', $nacimientoValor) }}">
                @error('fecha_nacimiento')<div class="ed-error">{{ $message }}</div>@enderror
            </div>

            <div class="ed-campo completo {{ $errors->has('direccion') ? 'con-error' : '' }}">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion"
                       value="{{ old('direccion', $usuario->direccion) }}">
                @error('direccion')<div class="ed-error">{{ $message }}</div>@enderror
            </div>

        </div>

        <div class="ed-acciones">
            <a href="{{ route('admin.informacion') }}" class="ed-btn ed-btn-secundario">Cancelar</a>
            <button type="submit" class="ed-btn ed-btn-principal">Guardar cambios</button>
        </div>
    </form>

</div>

</x-layouts.panel>