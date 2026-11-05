<x-layouts.panel
    titulo="Cuenta del negocio"
    :regresar="route('admin.dashboard')"
    :migas="[
        ['texto' => 'Cuenta del negocio', 'url' => route('admin.cuentas.index')],
    ]"
>

<x-lista-estilos />

@php
    $tipos = \App\Models\CuentaFinanciera::TIPOS;
    $tiposPasivo = \App\Models\CuentaFinanciera::TIPOS_PASIVO;
    $direcciones = \App\Models\CuentaFinanciera::DIRECCIONES_PASIVO;
    $periodos = \App\Models\CuentaFinanciera::PERIODOS_INTERES;
@endphp

@push('estilos')
<style>
    .cta-nombre {
        font-weight: 600;
    }
    .cta-sub {
        display: block;
        margin-top: 2px;
        font-size: 12px;
        color: var(--texto-suave);
    }
    .cta-numero {
        font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
        font-size: 13px;
    }
    .cta-saldo {
        font-weight: 700;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }
    .cta-tipo,
    .cta-estado {
        display: inline-block;
        padding: 3px 10px;
        border: 1px solid var(--borde);
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    .cta-tipo.activo {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1d4ed8;
    }
    .cta-tipo.pasivo {
        background: #fffbeb;
        border-color: #fde68a;
        color: #b45309;
    }
    .cta-estado.activa {
        background: #ecfdf3;
        border-color: #bbf7d0;
        color: #15803d;
    }
    .cta-estado.inactiva {
        background: #f3f4f6;
        border-color: #e5e7eb;
        color: #6b7280;
    }
    .cta-fila-inactiva .cta-nombre,
    .cta-fila-inactiva .cta-saldo {
        color: #9ca3af;
    }
    .cta-form-inline {
        margin: 0;
        display: inline-flex;
    }
    .lst-btn-estado {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        padding: 0;
        background: #fff;
        border: 1px solid var(--borde);
        border-radius: 0;
        font-size: 15px;
        color: var(--texto-suave);
        cursor: pointer;
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
    }
    .lst-btn-estado:hover {
        background: var(--primario);
        border-color: var(--primario);
        color: #fff;
    }
    .lst-btn-estado.encendido { color: #15803d; }
    .lst-btn-estado.encendido:hover { color: #fff; }
    .lst-tabla th.num,
    .lst-tabla td.num {
        text-align: right;
    }

    @media (max-width: 800px) {
        .cta-sub { display: inline; margin-left: 6px; }
    }
</style>
@endpush

<x-sidebar activo="cuenta" />

<div class="lst-pagina">
    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Cuenta del negocio</h1>
            </div>
            <p>Administra las tarjetas y cuentas financieras del negocio.</p>
        </div>
        <a href="{{ route('admin.cuentas.create') }}" class="lst-btn-principal">
            Agregar cuenta
        </a>
    </div>

    @if(session('success'))
        <div class="lst-mensaje exito">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="lst-mensaje error">{{ session('error') }}</div>
    @endif

    @if($cuentas->count() > 0)
        <div class="lst-herramientas">
            <div class="lst-buscador">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="buscadorCuentas" placeholder="Buscar por nombre o número de cuenta..." autocomplete="off">
                <button type="button" class="lst-btn-limpiar" id="btnLimpiar" aria-label="Limpiar búsqueda">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="lst-controles">
                <div class="lst-selector">
                    <select id="filtroTipo" aria-label="Filtrar por tipo">
                        <option value="">Tipo: Todos</option>
                        <option value="activo">Tipo: Activos</option>
                        <option value="pasivo">Tipo: Pasivos</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
                <div class="lst-selector">
                    <select id="filtroEstado" aria-label="Filtrar por estado">
                        <option value="">Estado: Todos</option>
                        <option value="activa">Estado: Activas</option>
                        <option value="inactiva">Estado: Inactivas</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <span class="lst-contador" id="contadorCuentas">
                    <strong>{{ $cuentas->count() }}</strong>
                    {{ $cuentas->count() === 1 ? 'registro' : 'registros' }}
                </span>
            </div>
        </div>

        <div class="lst-tabla-wrap" id="tablaCuentas">
            <table class="lst-tabla">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Número de cuenta</th>
                        <th>Moneda</th>
                        <th class="num">Saldo actual</th>
                        <th>Estado</th>
                        <th class="lst-col-acciones">Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaCuentas">
                    @foreach($cuentas as $cuenta)
                        @php
                            $estado = $cuenta->activa ? 'activa' : 'inactiva';

                            $detallePasivo = null;
                            if ($cuenta->esPasivo()) {
                                $partes = array_filter([
                                    $tiposPasivo[$cuenta->tipo_pasivo] ?? null,
                                    $direcciones[$cuenta->direccion_pasivo] ?? null,
                                    $cuenta->tasa_interes !== null
                                        ? rtrim(rtrim(number_format($cuenta->tasa_interes, 2), '0'), '.') . '% ' . strtolower($periodos[$cuenta->periodo_interes] ?? '')
                                        : null,
                                ]);
                                $detallePasivo = implode(' · ', $partes);
                            }
                        @endphp

                        <tr
                            class="lst-fila {{ $cuenta->activa ? '' : 'cta-fila-inactiva' }}"
                            data-url="{{ route('admin.cuentas.edit', $cuenta->id) }}"
                            data-nombre="{{ $cuenta->nombre }}"
                            data-numero="{{ $cuenta->numero_cuenta }}"
                            data-tipo="{{ $cuenta->tipo }}"
                            data-estado="{{ $estado }}"
                        >
                            <td data-label="Nombre">
                                <span class="cta-nombre">{{ $cuenta->nombre }}</span>
                                @if($detallePasivo)
                                    <span class="cta-sub">{{ $detallePasivo }}</span>
                                @endif
                            </td>
                            <td data-label="Tipo">
                                <span class="cta-tipo {{ $cuenta->tipo }}">{{ $tipos[$cuenta->tipo] ?? ucfirst($cuenta->tipo) }}</span>
                            </td>
                            <td data-label="Número de cuenta">
                                @if($cuenta->numero_cuenta)
                                    <span class="cta-numero">{{ $cuenta->numero_cuenta }}</span>
                                @else
                                    <span class="lst-sin-dato">No registrado</span>
                                @endif
                            </td>
                            <td data-label="Moneda">{{ $cuenta->moneda }}</td>
                            <td data-label="Saldo actual" class="num cta-saldo">${{ number_format($cuenta->saldo_actual, 2) }}</td>
                            <td data-label="Estado">
                                <span class="cta-estado {{ $estado }}">{{ $cuenta->activa ? 'Activa' : 'Inactiva' }}</span>
                            </td>
                            <td class="lst-col-acciones">
                                <div class="lst-acciones">
                                    <a
                                        href="{{ route('admin.cuentas.edit', $cuenta->id) }}"
                                        class="lst-btn-editar"
                                        title="Editar"
                                        aria-label="Editar cuenta"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.cuentas.estado', $cuenta->id) }}" class="cta-form-inline">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="lst-btn-estado {{ $cuenta->activa ? 'encendido' : '' }}"
                                            title="{{ $cuenta->activa ? 'Desactivar' : 'Activar' }}"
                                            aria-label="{{ $cuenta->activa ? 'Desactivar cuenta' : 'Activar cuenta' }}"
                                        >
                                            <i class="fa-solid {{ $cuenta->activa ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                        </button>
                                    </form>
                                    <button
                                        type="button"
                                        class="lst-btn-eliminar"
                                        title="Eliminar"
                                        aria-label="Eliminar cuenta"
                                        data-eliminar
                                        data-id="{{ $cuenta->id }}"
                                        data-nombre="{{ $cuenta->nombre }}"
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
            <h3>No se encontró ninguna cuenta</h3>
            <p>Intenta cambiar la búsqueda o los filtros.</p>
        </div>

    @else
        <div class="lst-vacio visible">
            <h3>No hay cuentas registradas</h3>
            <p>Agrega la primera tarjeta o cuenta financiera del negocio.</p>
        </div>
    @endif

</div>

<div class="lst-modal" id="modalEliminar" role="dialog" aria-modal="true" aria-labelledby="tituloModalEliminar">
    <div class="lst-modal-caja">

        <h2 id="tituloModalEliminar">Eliminar cuenta</h2>
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
        const urlEliminar = @js(route('admin.cuentas.destroy', '__ID__'));

        function abrirModal(id, nombre) {
            const fuerte = document.createElement('strong');
            fuerte.textContent = nombre;

            mensaje.textContent = '';
            mensaje.append(
                '¿Seguro que deseas eliminar la cuenta ',
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

        const cuerpo = document.getElementById('listaCuentas');
        if (!cuerpo) return;

        cuerpo.addEventListener('click', function (evento) {
            if (evento.target.closest('a, button')) return;
            if (window.getSelection().toString()) return;

            const fila = evento.target.closest('.lst-fila');
            if (fila) window.location.href = fila.dataset.url;
        });

        const tabla = document.getElementById('tablaCuentas');
        const buscador = document.getElementById('buscadorCuentas');
        const btnLimpiar = document.getElementById('btnLimpiar');
        const filtroTipo = document.getElementById('filtroTipo');
        const filtroEstado = document.getElementById('filtroEstado');
        const sinResultados = document.getElementById('sinResultados');
        const contador = document.getElementById('contadorCuentas');

        function normalizar(texto) {
            return (texto || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
        }

        function aplicar() {
            const texto = normalizar(buscador.value);
            btnLimpiar.style.display = buscador.value ? 'flex' : 'none';

            let visibles = 0;
            cuerpo.querySelectorAll('.lst-fila').forEach(function (fila) {
                const contenido = normalizar(fila.dataset.nombre + ' ' + fila.dataset.numero);

                const mostrar =
                    contenido.includes(texto) &&
                    (filtroTipo.value === '' || fila.dataset.tipo === filtroTipo.value) &&
                    (filtroEstado.value === '' || fila.dataset.estado === filtroEstado.value);

                fila.style.display = mostrar ? '' : 'none';
                if (mostrar) visibles++;
            });

            tabla.style.display = visibles === 0 ? 'none' : '';
            sinResultados.classList.toggle('visible', visibles === 0);
            contador.innerHTML = '<strong>' + visibles + '</strong> ' + (visibles === 1 ? 'registro' : 'registros');
        }

        buscador.addEventListener('input', aplicar);
        filtroTipo.addEventListener('change', aplicar);
        filtroEstado.addEventListener('change', aplicar);

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