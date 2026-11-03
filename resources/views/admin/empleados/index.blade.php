<x-layouts.panel
    titulo="Empleados"
    :regresar="route('admin.dashboard')"
    :migas="[
        ['texto' => 'Empleados', 'url' => route('admin.empleados')],
    ]"
>

<x-lista-estilos />

@push('estilos')
<style>
    .emp-persona {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }
    .emp-avatar {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
    }
    .emp-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .emp-nombre {
        font-weight: 600;
    }
    .emp-rol {
        display: inline-block;
        padding: 3px 10px;
        border: 1px solid var(--borde);
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    .emp-rol.admin {
        background: var(--primario-suave);
        border-color: #ddd6fe;
        color: var(--primario);
    }
    .emp-rol.vendedor {
        background: #ecfdf3;
        border-color: #bbf7d0;
        color: #15803d;
    }

    @media (max-width: 800px) {
        .emp-persona { justify-content: flex-end; }
    }
</style>
@endpush

<x-sidebar activo="empleados" />

<div class="lst-pagina">
    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Empleados</h1>
            </div>
            <p>Administra los usuarios con perfil de administrador y vendedor.</p>
        </div>

        <a href="{{ route('admin.empleados.agregar') }}" class="lst-btn-principal">
            Agregar empleado
        </a>
    </div>
    @if(session('success'))
        <div class="lst-mensaje exito">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="lst-mensaje error">{{ session('error') }}</div>
    @endif

    @if($empleados->count() > 0)

        <div class="lst-herramientas">
            <div class="lst-tabs">
                <button type="button" class="lst-tab activo" data-rol="todos">Todos</button>
                <button type="button" class="lst-tab" data-rol="admin">Administradores</button>
                <button type="button" class="lst-tab" data-rol="vendedor">Vendedores</button>
            </div>
            <div class="lst-controles">
                <div class="lst-buscador">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="buscadorEmpleados" placeholder="Buscar por nombre, correo o teléfono..." autocomplete="off">
                    <button type="button" class="lst-btn-limpiar" id="btnLimpiar" aria-label="Limpiar búsqueda">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="lst-selector">
                    <select id="ordenEmpleados">
                        <option value="az">Orden: Nombre (A – Z)</option>
                        <option value="za">Orden: Nombre (Z – A)</option>
                        <option value="correo">Orden: Correo (A – Z)</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <span class="lst-contador" id="contadorEmpleados">
                    <strong>{{ $empleados->count() }}</strong>
                    {{ $empleados->count() === 1 ? 'registro' : 'registros' }}
                </span>

            </div>
        </div>
        <div class="lst-tabla-wrap" id="tablaEmpleados">
            <table class="lst-tabla">
                <thead>
                    <tr>
                        <th>Empleado</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th class="lst-col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaEmpleados">
                    @foreach($empleados as $empleado)
                        @php
                            $nombreCompleto = trim($empleado->name . ' ' . $empleado->apellido);
                            $iniciales = mb_strtoupper(
                                mb_substr($empleado->name, 0, 1) . mb_substr($empleado->apellido ?? '', 0, 1)
                            );
                            $rolTexto = $empleado->rol === 'admin' ? 'Administrador' : 'Vendedor';
                        @endphp

                        <tr
                            class="lst-fila"
                            data-url="{{ route('admin.empleados.editar', $empleado->id) }}"
                            data-nombre="{{ $nombreCompleto }}"
                            data-correo="{{ $empleado->email }}"
                            data-telefono="{{ $empleado->telefono }}"
                            data-rol="{{ $empleado->rol }}"
                            data-rol-texto="{{ $rolTexto }}"
                        >
                            <td data-label="Empleado">
                                <div class="emp-persona">
                                    <span class="emp-avatar" style="background: {{ $empleado->color_perfil ?: '#6d28d9' }};">
                                        @if($empleado->foto_perfil)
                                            <img src="{{ asset('storage/' . $empleado->foto_perfil) }}" alt="{{ $nombreCompleto }}">
                                        @else
                                            {{ $iniciales }}
                                        @endif
                                    </span>
                                    <span class="emp-nombre">{{ $nombreCompleto }}</span>
                                </div>
                            </td>
                            <td data-label="Correo">{{ $empleado->email }}</td>
                            <td data-label="Teléfono">
                                @if($empleado->telefono)
                                    {{ $empleado->telefono }}
                                @else
                                    <span class="lst-sin-dato">No registrado</span>
                                @endif
                            </td>
                            <td data-label="Rol">
                                <span class="emp-rol {{ $empleado->rol }}">{{ $rolTexto }}</span>
                            </td>
                            <td class="lst-col-acciones">
                                <div class="lst-acciones">
                                    <a
                                        href="{{ route('admin.empleados.editar', $empleado->id) }}"
                                        class="lst-btn-editar"
                                        title="Editar"
                                        aria-label="Editar empleado"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="lst-btn-eliminar"
                                        title="Eliminar"
                                        aria-label="Eliminar empleado"
                                        data-eliminar
                                        data-id="{{ $empleado->id }}"
                                        data-nombre="{{ $nombreCompleto }}"
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

        <div class="lst-vacio" id="sinResultados">
            <h3>No se encontraron resultados</h3>
            <p>Intenta cambiar el filtro o realizar otra búsqueda.</p>
        </div>

    @else

        <div class="lst-vacio visible">
            <h3>No hay empleados registrados</h3>
            <p>Actualmente no existen administradores ni vendedores registrados.</p>
        </div>

    @endif

</div>

<div class="lst-modal" id="modalEliminar" role="dialog" aria-modal="true" aria-labelledby="tituloModalEliminar">
    <div class="lst-modal-caja">

        <h2 id="tituloModalEliminar">Eliminar empleado</h2>
        <p id="mensajeEliminar"></p>

        <form id="formEliminar" method="POST">
            @csrf
            @method('DELETE')

            <div class="lst-modal-botones">
                <button type="button" class="lst-btn-cancelar" id="btnCancelarEliminar">
                    Cancelar
                </button>
                <button type="submit" class="lst-btn-confirmar">
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
        const urlEliminar = @js(route('admin.empleados.eliminar', '__ID__'));

        function abrirModal(id, nombre) {
            const fuerte = document.createElement('strong');
            fuerte.textContent = nombre;

            mensaje.textContent = '';
            mensaje.append(
                '¿Seguro que deseas eliminar a ',
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

        const cuerpo = document.getElementById('listaEmpleados');
        if (!cuerpo) return;

        cuerpo.addEventListener('click', function (evento) {
            if (evento.target.closest('a, button')) return;
            if (window.getSelection().toString()) return;

            const fila = evento.target.closest('.lst-fila');
            if (fila) window.location.href = fila.dataset.url;
        });

        const tabla = document.getElementById('tablaEmpleados');
        const buscador = document.getElementById('buscadorEmpleados');
        const btnLimpiar = document.getElementById('btnLimpiar');
        const orden = document.getElementById('ordenEmpleados');
        const tabs = document.querySelectorAll('.lst-tab');
        const sinResultados = document.getElementById('sinResultados');
        const contador = document.getElementById('contadorEmpleados');

        let rolActual = 'todos';

        function normalizar(texto) {
            return (texto || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
        }

        function comparar(a, b) {
            return a.localeCompare(b, 'es', { sensitivity: 'base' });
        }

        function aplicar() {
            const texto = normalizar(buscador.value);
            btnLimpiar.style.display = buscador.value ? 'flex' : 'none';

            const filas = Array.from(cuerpo.querySelectorAll('.lst-fila'));

            filas.sort(function (a, b) {
                switch (orden.value) {
                    case 'za':     return comparar(b.dataset.nombre, a.dataset.nombre);
                    case 'correo': return comparar(a.dataset.correo, b.dataset.correo);
                    default:       return comparar(a.dataset.nombre, b.dataset.nombre);
                }
            });

            let visibles = 0;
            filas.forEach(function (fila) {
                cuerpo.appendChild(fila);

                const coincideRol = rolActual === 'todos' || fila.dataset.rol === rolActual;
                const contenido = normalizar(
                    fila.dataset.nombre + ' ' +
                    fila.dataset.correo + ' ' +
                    fila.dataset.telefono + ' ' +
                    fila.dataset.rolTexto
                );
                const mostrar = coincideRol && contenido.includes(texto);

                fila.style.display = mostrar ? '' : 'none';
                if (mostrar) visibles++;
            });

            tabla.style.display = visibles === 0 ? 'none' : '';
            sinResultados.classList.toggle('visible', visibles === 0);
            contador.innerHTML = '<strong>' + visibles + '</strong> ' + (visibles === 1 ? 'registro' : 'registros');
        }

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('activo'); });
                this.classList.add('activo');
                rolActual = this.dataset.rol;
                aplicar();
            });
        });

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