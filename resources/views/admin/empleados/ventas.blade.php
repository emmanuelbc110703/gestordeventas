@php
    $m = fn ($n) => '$' . number_format((float) $n, 2);
    $etiquetasPago = ['efectivo' => 'Efectivo', 'tarjeta' => 'Tarjeta', 'transferencia' => 'Transferencia'];
    $iniciales = mb_strtoupper(
        mb_substr($empleado->name, 0, 1) . mb_substr($empleado->apellido ?? '', 0, 1)
    );
    $rolTexto = $empleado->rol === 'admin' ? 'Administrador' : 'Vendedor';
    $filtrado = $desde || $hasta || $formaPago || $busqueda !== '';
@endphp

<x-layouts.panel
    :titulo="$nombreCompleto"
    :regresar="route('admin.empleados')"
    :migas="[
        ['texto' => 'Empleados', 'url' => route('admin.empleados')],
        ['texto' => $nombreCompleto],
    ]"
>

<x-lista-estilos />
<x-formulario-estilos />
<x-pedido-estilos />

@push('estilos')
<style>
    .emp-cabecera {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
    }
    .emp-avatar-grande {
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
    .emp-avatar-grande img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .emp-rol {
        display: inline-block;
        margin-left: 10px;
        padding: 3px 10px;
        border: 1px solid var(--borde);
        font-size: 12px;
        font-weight: 600;
        vertical-align: middle;
        white-space: nowrap;
    }
    .emp-rol.admin { background: var(--primario-suave); border-color: #ddd6fe; color: var(--primario); }
    .emp-rol.vendedor { background: #ecfdf3; border-color: #bbf7d0; color: #15803d; }

    .emp-resumen {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 16px;
    }
    .emp-resumen.pagos {
        grid-template-columns: repeat(3, 1fr);
        margin-bottom: 32px;
    }
    .emp-dato {
        padding: 18px 20px;
        background: #fff;
        border: 1px solid var(--borde);
    }
    .emp-dato span {
        display: block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--texto-suave);
    }
    .emp-dato strong {
        display: block;
        margin-top: 6px;
        font-size: 24px;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
        color: var(--texto);
    }
    .emp-dato small {
        display: block;
        margin-top: 2px;
        font-size: 12px;
        color: var(--texto-suave);
    }
    .emp-resumen.pagos .emp-dato strong { font-size: 20px; }

    .emp-historial { margin-top: 32px; }
    .emp-enlace {
        font-weight: 600;
        color: var(--primario);
        text-decoration: none;
    }
    .emp-enlace:hover { text-decoration: underline; }

    /* Filtros */
    .emp-filtros {
        padding: 16px 20px 20px;
        border-bottom: 1px solid var(--borde);
    }
    .emp-filtros .lst-tabs { margin-bottom: 14px; flex-wrap: wrap; }
    .emp-campos {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: flex-end;
    }
    .emp-campo { display: flex; flex-direction: column; gap: 4px; min-width: 150px; }
    .emp-campo.ancho { flex: 1; min-width: 200px; }
    .emp-campo label {
        font-size: 12px;
        font-weight: 600;
        color: var(--texto-suave);
    }
    .emp-campo input,
    .emp-campo select {
        height: 44px;
        padding: 0 12px;
        border: 1px solid var(--borde);
        border-radius: 0;
        background: #fff;
        font: inherit;
        font-size: 15px;
        width: 100%;
    }
    .emp-campo input:focus,
    .emp-campo select:focus { outline: 2px solid var(--primario-suave); border-color: var(--primario); }
    .emp-btn {
        height: 44px;
        padding: 0 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--borde);
        border-radius: 0;
        background: #fff;
        font: inherit;
        font-size: 15px;
        font-weight: 600;
        color: inherit;
        text-decoration: none;
        cursor: pointer;
    }
    .emp-btn.primario { background: var(--primario); border-color: var(--primario); color: #fff; }
    .emp-btn.deshabilitado { opacity: .45; pointer-events: none; }
    .emp-periodo {
        padding: 12px 20px 0;
        font-size: 13px;
        font-weight: 600;
        color: var(--texto-suave);
    }

    .emp-publico { color: var(--texto-suave); font-style: italic; }
    .emp-sub { display: block; font-size: 12px; color: var(--texto-suave); }

    .emp-paginacion {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 14px 20px;
        border-top: 1px solid var(--borde);
        font-size: 13px;
        color: var(--texto-suave);
    }
    .emp-paginacion-botones { display: flex; gap: 8px; align-items: center; }

    @media (max-width: 900px) {
        .emp-resumen { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 650px) {
        .emp-resumen,
        .emp-resumen.pagos { grid-template-columns: 1fr; }
    }
</style>
@endpush

<div class="frm-pagina">
    <div class="frm-encabezado">
        <div class="emp-cabecera">
            <span class="emp-avatar-grande" style="background: {{ $empleado->color_perfil ?: '#6d28d9' }};">
                @if($empleado->foto_perfil)
                    <img src="{{ asset('storage/' . $empleado->foto_perfil) }}" alt="{{ $nombreCompleto }}">
                @else
                    {{ $iniciales }}
                @endif
            </span>
            <div>
                <h1>
                    {{ $nombreCompleto }}
                    <span class="emp-rol {{ $empleado->rol }}">{{ $rolTexto }}</span>
                </h1>
                <p>Información del empleado e historial de ventas realizadas en el punto de venta.</p>
            </div>
        </div>

        <div class="frm-acciones">
            <a href="{{ route('admin.empleados') }}" class="frm-btn-cancelar">Volver</a>
            <a href="{{ route('admin.empleados.editar', $empleado->id) }}" class="frm-btn-guardar" style="text-decoration:none;">Editar empleado</a>
        </div>
    </div>

    @if(session('success'))
        <div class="ped-exito">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="frm-alerta">{{ session('error') }}</div>
    @endif
    @if($errorFiltro)
        <div class="frm-alerta">{{ $errorFiltro }} Se muestran todas las ventas.</div>
    @endif
    <div class="emp-resumen">
        <div class="emp-dato"><span>Ventas</span><strong>{{ number_format($resumen['ventas']) }}</strong></div>
        <div class="emp-dato"><span>Total vendido</span><strong>{{ $m($resumen['total']) }}</strong></div>
        <div class="emp-dato"><span>Ticket promedio</span><strong>{{ $m($resumen['ticket']) }}</strong></div>
        <div class="emp-dato"><span>Artículos vendidos</span><strong>{{ number_format($resumen['productos']) }}</strong></div>
    </div>

    <div class="emp-resumen pagos">
        @foreach($etiquetasPago as $clave => $texto)
            <div class="emp-dato">
                <span>{{ $texto }}</span>
                <strong>{{ $m($porPago[$clave]['total']) }}</strong>
                <small>{{ $porPago[$clave]['ventas'] }} {{ $porPago[$clave]['ventas'] === 1 ? 'venta' : 'ventas' }}</small>
            </div>
        @endforeach
    </div>

    <div class="frm-grid">
        <section class="frm-card">
            <h2 class="frm-card-titulo">Información personal</h2>
            <dl class="ped-info">
                <div>
                    <dt>Nombre</dt>
                    <dd>{{ $empleado->name }}</dd>
                </div>
                <div>
                    <dt>Apellidos</dt>
                    @if($empleado->apellido)
                        <dd>{{ $empleado->apellido }}</dd>
                    @else
                        <dd class="vacio">No registrados</dd>
                    @endif
                </div>
                <div>
                    <dt>Correo electrónico</dt>
                    @if($empleado->email)
                        <dd>{{ $empleado->email }}</dd>
                    @else
                        <dd class="vacio">No registrado</dd>
                    @endif
                </div>
                <div>
                    <dt>Teléfono</dt>
                    @if($empleado->telefono)
                        <dd>{{ $empleado->telefono }}</dd>
                    @else
                        <dd class="vacio">No registrado</dd>
                    @endif
                </div>
            </dl>
        </section>

        <section class="frm-card">
            <h2 class="frm-card-titulo">Datos laborales</h2>
            <dl class="ped-info">
                <div>
                    <dt>Rol</dt>
                    <dd>{{ $rolTexto }}</dd>
                </div>
                <div>
                    <dt>Caja asignada</dt>
                    @if($caja)
                        <dd>{{ $caja->nombre_caja }} · Caja {{ $caja->numero_caja }} · {{ $caja->sucursal }}</dd>
                    @else
                        <dd class="vacio">Sin caja asignada</dd>
                    @endif
                </div>
                <div>
                    <dt>Dirección</dt>
                    @if($empleado->direccion)
                        <dd>{{ $empleado->direccion }}</dd>
                    @else
                        <dd class="vacio">No registrada</dd>
                    @endif
                </div>
                <div>
                    <dt>Empleado desde</dt>
                    <dd>{{ $empleado->created_at?->format('d/m/Y') }}</dd>
                </div>
            </dl>
        </section>
    </div>

    <div class="emp-historial">
        <section class="frm-card ped-card-plana">
            <h2 class="frm-card-titulo">Historial de ventas</h2>

            {{-- Filtros --}}
            <form method="GET" action="{{ route('admin.empleados.ventas', $empleado->id) }}" class="emp-filtros" id="formFiltros">
                <div class="lst-tabs">
                    @foreach($atajos as $atajo)
                        <button
                            type="button"
                            class="lst-tab {{ $atajo['activo'] ? 'activo' : '' }}"
                            data-atajo
                            data-desde="{{ $atajo['desde'] }}"
                            data-hasta="{{ $atajo['hasta'] }}"
                        >{{ $atajo['etiqueta'] }}</button>
                    @endforeach
                </div>

                <div class="emp-campos">
                    <div class="emp-campo">
                        <label for="filtroDesde">Desde</label>
                        <input type="date" id="filtroDesde" name="desde" value="{{ $desde }}">
                    </div>
                    <div class="emp-campo">
                        <label for="filtroHasta">Hasta</label>
                        <input type="date" id="filtroHasta" name="hasta" value="{{ $hasta }}">
                    </div>
                    <div class="emp-campo">
                        <label for="filtroPago">Forma de pago</label>
                        <select id="filtroPago" name="forma_pago">
                            <option value="">Todas</option>
                            @foreach($etiquetasPago as $valor => $texto)
                                <option value="{{ $valor }}" @selected($formaPago === $valor)>{{ $texto }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="emp-campo ancho">
                        <label for="filtroFolio">Folio</label>
                        <input type="text" id="filtroFolio" name="q" value="{{ $busqueda }}" placeholder="Buscar por folio..." autocomplete="off">
                    </div>
                    <button type="submit" class="emp-btn primario">Filtrar</button>
                    @if($filtrado)
                        <a href="{{ route('admin.empleados.ventas', $empleado->id) }}" class="emp-btn">Limpiar</a>
                    @endif
                </div>
            </form>

            <div class="emp-periodo">{{ $periodoTexto }}</div>

            <div class="ped-tabla-wrap">
                <table class="ped-tabla">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Fecha</th>
                            <th>Caja</th>
                            <th>Cliente</th>
                            <th class="num">Artículos</th>
                            <th>Forma de pago</th>
                            <th class="num">Total</th>
                            <th class="num">Ticket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                            @php
                                $cliente = trim(($venta->cliente_nombre ?? '') . ' ' . ($venta->cliente_apellido ?? ''));
                            @endphp
                            <tr>
                                <td><span class="ped-folio">{{ $venta->folio }}</span></td>
                                <td>{{ $venta->fecha->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($venta->nombre_caja)
                                        {{ $venta->nombre_caja }}
                                        <span class="emp-sub">{{ $venta->sucursal }}</span>
                                    @else
                                        <span class="emp-publico">No disponible</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cliente !== '')
                                        {{ $cliente }}
                                    @else
                                        <span class="emp-publico">Público general</span>
                                    @endif
                                </td>
                                <td class="num">{{ (int) $venta->articulos }}</td>
                                <td>{{ $etiquetasPago[$venta->forma_pago] ?? ucfirst($venta->forma_pago) }}</td>
                                <td class="num ped-nombre">{{ $m($venta->total) }}</td>
                                <td class="num">
                                    <a href="{{ route('venta.ticket', $venta->id) }}" target="_blank" rel="noopener" class="emp-enlace">Ver ticket</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="ped-vacio-fila">
                                    {{ $filtrado ? 'No hay ventas que coincidan con los filtros.' : 'Este empleado aún no tiene ventas registradas.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($ventas->count() > 0)
                <div class="emp-paginacion">
                    <span>
                        Mostrando <strong>{{ $ventas->firstItem() }}–{{ $ventas->lastItem() }}</strong>
                        de <strong>{{ $ventas->total() }}</strong> {{ $ventas->total() === 1 ? 'venta' : 'ventas' }}
                    </span>

                    @if($ventas->hasPages())
                        <div class="emp-paginacion-botones">
                            <a href="{{ $ventas->previousPageUrl() ?? '#' }}" class="emp-btn {{ $ventas->onFirstPage() ? 'deshabilitado' : '' }}">Anterior</a>
                            <span>Página {{ $ventas->currentPage() }} de {{ $ventas->lastPage() }}</span>
                            <a href="{{ $ventas->nextPageUrl() ?? '#' }}" class="emp-btn {{ $ventas->hasMorePages() ? '' : 'deshabilitado' }}">Siguiente</a>
                        </div>
                    @endif
                </div>
            @endif
        </section>
    </div>

    <div class="frm-acciones" style="justify-content:flex-end; margin-top:32px; padding-top:24px; border-top:1px solid var(--borde);">
        <a href="{{ route('admin.empleados') }}" class="frm-btn-cancelar">Volver</a>
        <a href="{{ route('admin.empleados.editar', $empleado->id) }}" class="frm-btn-guardar" style="text-decoration:none;">Editar empleado</a>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const formulario = document.getElementById('formFiltros');
        const desde = document.getElementById('filtroDesde');
        const hasta = document.getElementById('filtroHasta');
        document.querySelectorAll('[data-atajo]').forEach(function (boton) {
            boton.addEventListener('click', function () {
                desde.value = this.dataset.desde || '';
                hasta.value = this.dataset.hasta || '';
                formulario.submit();
            });
        });
        desde.addEventListener('change', function () {
            if (!hasta.value || hasta.value < desde.value) hasta.value = desde.value;
            hasta.min = desde.value;
        });
        hasta.min = desde.value || '';
    })();
</script>
@endpush

</x-layouts.panel>