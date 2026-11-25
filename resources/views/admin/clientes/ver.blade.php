@php
    $nombreCompleto = trim($cliente->name . ' ' . $cliente->apellido);
    $dadoDeBaja = $cliente->trashed();
    $nacimiento = $cliente->fecha_nacimiento
        ? \Illuminate\Support\Carbon::parse($cliente->fecha_nacimiento)->format('d/m/Y')
        : null;
    $iniciales = mb_strtoupper(
        mb_substr($cliente->name, 0, 1) . mb_substr($cliente->apellido ?? '', 0, 1)
    );
    $totalComprado = $ventas->sum('total');
    $estadosTexto = [
        'enviado' => 'Enviado',
        'procesando' => 'Procesando',
        'finalizado' => 'Finalizado',
        'terminado' => 'Terminado',
    ];
@endphp

<x-layouts.panel
    :titulo="$nombreCompleto"
    :regresar="route('admin.clientes')"
    :migas="[
        ['texto' => 'Clientes', 'url' => route('admin.clientes')],
        ['texto' => $nombreCompleto],
    ]"
>

<x-lista-estilos />
<x-formulario-estilos />
<x-pedido-estilos />

@push('estilos')
<style>
    .cli-cabecera {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
    }
    .cli-avatar-grande {
        width: 56px;
        height: 56px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        font-size: 20px;
        font-weight: 700;
        color: #fff;
    }
    .cli-avatar-grande img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .cli-etiqueta-baja {
        display: inline-block;
        margin-left: 10px;
        padding: 3px 10px;
        background: var(--lst-rojo-suave);
        border: 1px solid #fecaca;
        font-size: 12px;
        font-weight: 600;
        color: var(--lst-rojo-oscuro);
        vertical-align: middle;
    }
    .cli-resumen {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 32px;
    }
    .cli-dato {
        padding: 18px 20px;
        background: #fff;
        border: 1px solid var(--borde);
    }
    .cli-dato span {
        display: block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--texto-suave);
    }
    .cli-dato strong {
        display: block;
        margin-top: 6px;
        font-size: 24px;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
        color: var(--texto);
    }
    .cli-historial {
        display: flex;
        flex-direction: column;
        gap: 32px;
        margin-top: 32px;
    }
    .cli-enlace {
        font-weight: 600;
        color: var(--primario);
        text-decoration: none;
    }
    .cli-enlace:hover { text-decoration: underline; }
    .cli-form-inline { margin: 0; display: flex; }
    .cli-btn-baja {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        padding: 0 22px;
        background: #fff;
        border: 1px solid #fecaca;
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        font-weight: 600;
        color: var(--lst-rojo-oscuro);
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .cli-btn-baja:hover {
        background: var(--lst-rojo);
        border-color: var(--lst-rojo);
        color: #fff;
    }
    .cli-btn-eliminar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 44px;
        padding: 0 22px;
        background: var(--lst-rojo);
        border: 1px solid var(--lst-rojo);
        border-radius: 0;
        font-family: inherit;
        font-size: 15px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .cli-btn-eliminar:hover {
        background: var(--lst-rojo-oscuro);
        border-color: var(--lst-rojo-oscuro);
    }
    .cli-acciones-pie {
        justify-content: flex-end;
        flex-wrap: wrap;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--borde);
    }
    @media (max-width: 650px) {
        .cli-resumen { grid-template-columns: 1fr; }
    }
</style>
@endpush

<div class="frm-pagina">
    <div class="frm-encabezado">
        <div class="cli-cabecera">
            <span class="cli-avatar-grande" style="background: {{ $cliente->color_perfil ?: '#6d28d9' }};">
                @if($cliente->foto_perfil)
                    <img src="{{ asset('storage/' . $cliente->foto_perfil) }}" alt="{{ $nombreCompleto }}">
                @else
                    {{ $iniciales }}
                @endif
            </span>
            <div>
                <h1>
                    {{ $nombreCompleto }}
                    @if($dadoDeBaja)
                        <span class="cli-etiqueta-baja">Dado de baja</span>
                    @endif
                </h1>
                <p>Registro del cliente e historial de sus operaciones.</p>
            </div>
        </div>

        <div class="frm-acciones">
            <a href="{{ route('admin.clientes', $dadoDeBaja ? ['estado' => 'baja'] : []) }}" class="frm-btn-cancelar">Volver</a>

            @if($dadoDeBaja)
                <form action="{{ route('admin.clientes.restaurar', $cliente->id) }}" method="POST" class="cli-form-inline">
                    @csrf
                    <button type="submit" class="frm-btn-guardar">Reactivar cliente</button>
                </form>
            @else
                <a href="{{ route('admin.clientes.editar', $cliente->id) }}" class="frm-btn-guardar" style="text-decoration:none;">Editar cliente</a>
                <button type="button" class="cli-btn-baja" data-abrir-modal="modalBaja">Dar de baja</button>
            @endif
            <button type="button" class="cli-btn-eliminar" data-abrir-modal="modalEliminar">Eliminar</button>
        </div>
    </div>

    @if(session('success'))
        <div class="ped-exito">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="frm-alerta">{{ session('error') }}</div>
    @endif

    <div class="cli-resumen">
        <div class="cli-dato"><span>Compras</span><strong>{{ $ventas->count() }}</strong></div>
        <div class="cli-dato"><span>Total comprado</span><strong>${{ number_format($totalComprado, 2) }}</strong></div>
        <div class="cli-dato"><span>Cotizaciones</span><strong>{{ $cotizaciones->count() }}</strong></div>
    </div>

    <div class="frm-grid">
        <section class="frm-card">
            <h2 class="frm-card-titulo">Información personal</h2>
            <dl class="ped-info">
                <div>
                    <dt>Nombre</dt>
                    <dd>{{ $cliente->name }}</dd>
                </div>
                <div>
                    <dt>Apellidos</dt>
                    @if($cliente->apellido)
                        <dd>{{ $cliente->apellido }}</dd>
                    @else
                        <dd class="vacio">No registrados</dd>
                    @endif
                </div>
                <div>
                    <dt>Correo electrónico</dt>
                    @if($cliente->email)
                        <dd>{{ $cliente->email }}</dd>
                    @else
                        <dd class="vacio">No registrado</dd>
                    @endif
                </div>
                <div>
                    <dt>Teléfono</dt>
                    @if($cliente->telefono)
                        <dd>{{ $cliente->telefono }}</dd>
                    @else
                        <dd class="vacio">No registrado</dd>
                    @endif
                </div>
            </dl>
        </section>

        <section class="frm-card">
            <h2 class="frm-card-titulo">Datos adicionales</h2>
            <dl class="ped-info">
                <div>
                    <dt>Dirección</dt>
                    @if($cliente->direccion)
                        <dd>{{ $cliente->direccion }}</dd>
                    @else
                        <dd class="vacio">No registrada</dd>
                    @endif
                </div>
                <div>
                    <dt>Fecha de nacimiento</dt>
                    @if($nacimiento)
                        <dd>{{ $nacimiento }}</dd>
                    @else
                        <dd class="vacio">No registrada</dd>
                    @endif
                </div>
                <div>
                    <dt>Cliente desde</dt>
                    <dd>{{ $cliente->created_at?->format('d/m/Y') }}</dd>
                </div>
                @if($dadoDeBaja)
                    <div>
                        <dt>Dado de baja el</dt>
                        <dd>{{ $cliente->deleted_at->format('d/m/Y H:i') }}</dd>
                    </div>
                @endif
            </dl>
        </section>
    </div>

    <div class="cli-historial">
        <section class="frm-card ped-card-plana">
            <h2 class="frm-card-titulo">Historial de compras</h2>
            <div class="ped-tabla-wrap">
                <table class="ped-tabla">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th class="num">Artículos</th>
                            <th>Forma de pago</th>
                            <th class="num">Total</th>
                            <th class="num">Ticket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                            <tr>
                                <td><span class="ped-folio">{{ $venta->folio }}</span></td>
                                <td>{{ $venta->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="num">{{ (int) $venta->articulos }}</td>
                                <td>{{ ucfirst($venta->forma_pago) }}</td>
                                <td class="num ped-nombre">${{ number_format($venta->total, 2) }}</td>
                                <td class="num">
                                    <a href="{{ route('venta.ticket', $venta->id) }}" target="_blank" rel="noopener" class="cli-enlace">Ver ticket</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="ped-vacio-fila">Este cliente aún no tiene compras registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="frm-card ped-card-plana">
            <h2 class="frm-card-titulo">Historial de cotizaciones</h2>
            <div class="ped-tabla-wrap">
                <table class="ped-tabla">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th class="num">Servicios</th>
                            <th>Forma de pago</th>
                            <th>Estado</th>
                            <th class="num">Total</th>
                            <th class="num">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cotizaciones as $cotizacion)
                            @php
                                $estadoTexto = $estadosTexto[$cotizacion->estado] ?? ucfirst($cotizacion->estado);
                            @endphp
                            <tr>
                                <td><span class="ped-folio">{{ $cotizacion->folio }}</span></td>
                                <td>{{ $cotizacion->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="num">{{ (int) $cotizacion->servicios }}</td>
                                <td>{{ ucfirst($cotizacion->forma_pago) }}</td>
                                <td><span class="ped-estado {{ $cotizacion->estado }}">{{ $estadoTexto }}</span></td>
                                <td class="num ped-nombre">${{ number_format($cotizacion->total, 2) }}</td>
                                <td class="num">
                                    <a href="{{ route('admin.cotizaciones.mostrar', $cotizacion->id) }}" class="cli-enlace">Ver pedido</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="ped-vacio-fila">Este cliente aún no tiene cotizaciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <div class="frm-acciones cli-acciones-pie">
        <a href="{{ route('admin.clientes', $dadoDeBaja ? ['estado' => 'baja'] : []) }}" class="frm-btn-cancelar">Volver</a>

        @if($dadoDeBaja)
            <form action="{{ route('admin.clientes.restaurar', $cliente->id) }}" method="POST" class="cli-form-inline">
                @csrf
                <button type="submit" class="frm-btn-guardar">Reactivar cliente</button>
            </form>
        @else
            <a href="{{ route('admin.clientes.editar', $cliente->id) }}" class="frm-btn-guardar" style="text-decoration:none;">Editar cliente</a>
            <button type="button" class="cli-btn-baja" data-abrir-modal="modalBaja">Dar de baja</button>
        @endif

        <button type="button" class="cli-btn-eliminar" data-abrir-modal="modalEliminar">Eliminar</button>
    </div>
</div>
@unless($dadoDeBaja)
<div class="lst-modal" id="modalBaja" role="dialog" aria-modal="true" aria-labelledby="tituloModalBaja">
    <div class="lst-modal-caja">
        <h2 id="tituloModalBaja">Dar de baja cliente</h2>
        <p>
            ¿Seguro que deseas dar de baja a <strong>{{ $nombreCompleto }}</strong>?
            Ya no podrá iniciar sesión, pero su historial
            ({{ $ventas->count() }} {{ $ventas->count() === 1 ? 'compra' : 'compras' }} y
            {{ $cotizaciones->count() }} {{ $cotizaciones->count() === 1 ? 'cotización' : 'cotizaciones' }})
            se conserva y podrás reactivarlo cuando quieras.
        </p>

        <form action="{{ route('admin.clientes.eliminar', $cliente->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="lst-modal-botones">
                <button type="button" class="lst-btn-cancelar" data-cerrar-modal>Cancelar</button>
                <button type="submit" class="lst-btn-confirmar">Sí, dar de baja</button>
            </div>
        </form>
    </div>
</div>
@endunless
<div class="lst-modal" id="modalEliminar" role="dialog" aria-modal="true" aria-labelledby="tituloModalEliminar">
    <div class="lst-modal-caja">
        <h2 id="tituloModalEliminar">Eliminar cliente</h2>
        <p>
            ¿Seguro que deseas eliminar definitivamente a <strong>{{ $nombreCompleto }}</strong>?
            Esta acción no se puede deshacer y no podrás reactivarlo después.
            @if($ventas->count() || $cotizaciones->count())
                Tiene {{ $ventas->count() }} {{ $ventas->count() === 1 ? 'compra' : 'compras' }} y
                {{ $cotizaciones->count() }} {{ $cotizaciones->count() === 1 ? 'cotización' : 'cotizaciones' }} registradas.
            @endif
            @unless($dadoDeBaja)
                Si solo quieres que no pueda iniciar sesión, usa mejor <strong>Dar de baja</strong>.
            @endunless
        </p>

        <form action="{{ route('admin.clientes.eliminar_definitivo', $cliente->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="lst-modal-botones">
                <button type="button" class="lst-btn-cancelar" data-cerrar-modal>Cancelar</button>
                <button type="submit" class="lst-btn-confirmar">Sí, eliminar</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        function abrir(id) {
            const modal = document.getElementById(id);
            if (modal) modal.classList.add('activo');
        }
        function cerrarTodos() {
            document.querySelectorAll('.lst-modal.activo').forEach(function (modal) {
                modal.classList.remove('activo');
            });
        }

        document.addEventListener('click', function (e) {
            const abrirBtn = e.target.closest('[data-abrir-modal]');
            if (abrirBtn) {
                abrir(abrirBtn.dataset.abrirModal);
                return;
            }
            if (e.target.closest('[data-cerrar-modal]')) {
                cerrarTodos();
                return;
            }
            if (e.target.classList && e.target.classList.contains('lst-modal')) {
                cerrarTodos();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') cerrarTodos();
        });
    })();
</script>
@endpush

</x-layouts.panel>