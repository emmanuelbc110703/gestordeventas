<x-layouts.panel
    titulo="Clientes"
    :regresar="route('admin.dashboard')"
    :migas="[
        ['texto' => 'Clientes', 'url' => route('admin.clientes')],
    ]"
>

<x-lista-estilos />

@push('estilos')
<style>
    .cli-persona {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }
    .cli-avatar {
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
    .cli-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .cli-nombre {
        font-weight: 600;
    }
    .cli-direccion {
        display: block;
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cli-compras {
        font-variant-numeric: tabular-nums;
    }

    @media (max-width: 800px) {
        .cli-persona { justify-content: flex-end; }
        .cli-direccion { max-width: 60vw; }
    }
</style>
@endpush

<x-sidebar activo="clientes" />

<div class="lst-pagina">
    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Clientes</h1>
            </div>
            <p>Administra y consulta los clientes registrados en el sistema.</p>
        </div>
        <a href="{{ route('admin.clientes.agregar') }}" class="lst-btn-principal">
            Agregar cliente
        </a>
    </div>
    @if(session('success'))
        <div class="lst-mensaje exito">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="lst-mensaje error">{{ session('error') }}</div>
    @endif

    @if($clientes->count() > 0)
        <div class="lst-herramientas">
            <div class="lst-buscador">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorClientes" placeholder="Buscar por nombre, correo, teléfono o dirección..." autocomplete="off">
                <button type="button" class="lst-btn-limpiar" id="btnLimpiar" aria-label="Limpiar búsqueda">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="lst-controles">
                <div class="lst-selector">
                    <select id="ordenClientes">
                        <option value="az">Orden: Nombre (A – Z)</option>
                        <option value="za">Orden: Nombre (Z – A)</option>
                        <option value="correo">Orden: Correo (A – Z)</option>
                        <option value="compras">Orden: Compras (mayor a menor)</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <span class="lst-contador" id="contadorClientes">
                    <strong>{{ $clientes->count() }}</strong>
                    {{ $clientes->count() === 1 ? 'registro' : 'registros' }}
                </span>

            </div>
        </div>
        <div class="lst-tabla-wrap" id="tablaClientes">
            <table class="lst-tabla">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Nacimiento</th>
                        <th>Compras</th>
                        <th class="lst-col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaClientes">
                    @foreach($clientes as $cliente)
                        @php
                            $nombreCompleto = trim($cliente->name . ' ' . $cliente->apellido);
                            $iniciales = mb_strtoupper(
                                mb_substr($cliente->name, 0, 1) . mb_substr($cliente->apellido ?? '', 0, 1)
                            );
                            $nacimiento = $cliente->fecha_nacimiento
                                ? \Illuminate\Support\Carbon::parse($cliente->fecha_nacimiento)->format('d/m/Y')
                                : null;
                            $compras = (int) ($cliente->compras_count ?? 0);
                        @endphp

                        <tr
                            class="lst-fila"
                            data-url="{{ route('admin.clientes.editar', $cliente->id) }}"
                            data-nombre="{{ $nombreCompleto }}"
                            data-correo="{{ $cliente->email }}"
                            data-telefono="{{ $cliente->telefono }}"
                            data-direccion="{{ $cliente->direccion }}"
                            data-compras="{{ $compras }}"
                        >
                            <td data-label="Cliente">
                                <div class="cli-persona">
                                    <span class="cli-avatar" style="background: {{ $cliente->color_perfil ?: '#6d28d9' }};">
                                        @if($cliente->foto_perfil)
                                            <img src="{{ asset('storage/' . $cliente->foto_perfil) }}" alt="{{ $nombreCompleto }}">
                                        @else
                                            {{ $iniciales }}
                                        @endif
                                    </span>
                                    <span class="cli-nombre">{{ $nombreCompleto }}</span>
                                </div>
                            </td>
                            <td data-label="Correo">
                                @if($cliente->email)
                                    {{ $cliente->email }}
                                @else
                                    <span class="lst-sin-dato">No registrado</span>
                                @endif
                            </td>
                            <td data-label="Teléfono">
                                @if($cliente->telefono)
                                    {{ $cliente->telefono }}
                                @else
                                    <span class="lst-sin-dato">No registrado</span>
                                @endif
                            </td>
                            <td data-label="Dirección">
                                @if($cliente->direccion)
                                    <span class="cli-direccion" title="{{ $cliente->direccion }}">{{ $cliente->direccion }}</span>
                                @else
                                    <span class="lst-sin-dato">No registrada</span>
                                @endif
                            </td>
                            <td data-label="Nacimiento">
                                @if($nacimiento)
                                    {{ $nacimiento }}
                                @else
                                    <span class="lst-sin-dato">No registrada</span>
                                @endif
                            </td>
                            <td data-label="Compras" class="cli-compras">{{ $compras }}</td>
                            <td class="lst-col-acciones">
                                <div class="lst-acciones">
                                    <a
                                        href="{{ route('admin.clientes.editar', $cliente->id) }}"
                                        class="lst-btn-editar"
                                        title="Editar"
                                        aria-label="Editar cliente"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="lst-btn-eliminar"
                                        title="Eliminar"
                                        aria-label="Eliminar cliente"
                                        data-eliminar
                                        data-id="{{ $cliente->id }}"
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
            <h3>No se encontró ningún cliente</h3>
            <p>Intenta buscar con otro nombre, correo, teléfono o dirección.</p>
        </div>

    @else
        <div class="lst-vacio visible">
            <h3>No hay clientes registrados</h3>
            <p>Aún no existen clientes registrados en el sistema.</p>
        </div>

    @endif

</div>
<div class="lst-modal" id="modalEliminar" role="dialog" aria-modal="true" aria-labelledby="tituloModalEliminar">
    <div class="lst-modal-caja">

        <h2 id="tituloModalEliminar">Eliminar cliente</h2>
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
        const urlEliminar = @js(route('admin.clientes.eliminar', '__ID__'));

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

        const cuerpo = document.getElementById('listaClientes');
        if (!cuerpo) return;

        cuerpo.addEventListener('click', function (evento) {
            if (evento.target.closest('a, button')) return;
            if (window.getSelection().toString()) return;

            const fila = evento.target.closest('.lst-fila');
            if (fila) window.location.href = fila.dataset.url;
        });

        const tabla = document.getElementById('tablaClientes');
        const buscador = document.getElementById('buscadorClientes');
        const btnLimpiar = document.getElementById('btnLimpiar');
        const orden = document.getElementById('ordenClientes');
        const sinResultados = document.getElementById('sinResultados');
        const contador = document.getElementById('contadorClientes');

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
                    case 'za':      return comparar(b.dataset.nombre, a.dataset.nombre);
                    case 'correo':  return comparar(a.dataset.correo, b.dataset.correo);
                    case 'compras': return Number(b.dataset.compras) - Number(a.dataset.compras);
                    default:        return comparar(a.dataset.nombre, b.dataset.nombre);
                }
            });

            let visibles = 0;
            filas.forEach(function (fila) {
                cuerpo.appendChild(fila);

                const contenido = normalizar(
                    fila.dataset.nombre + ' ' +
                    fila.dataset.correo + ' ' +
                    fila.dataset.telefono + ' ' +
                    fila.dataset.direccion
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