<x-layouts.panel
    titulo="Pagos realizados"
    :regresar="route('admin.pago_servicios.index')"
    :migas="[
        ['texto' => 'Pago de servicios', 'url' => route('admin.pago_servicios.index')],
        ['texto' => 'Pagos realizados', 'url' => null],
    ]"
>

<x-lista-estilos />

@push('estilos')
<style>
    .hs-resumen { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); background: #fff;
        border: 1px solid var(--borde); margin-bottom: 20px; }
    .hs-resumen > div { padding: 16px 20px; border-right: 1px solid var(--borde); }
    .hs-resumen > div:last-child { border-right: none; }
    .hs-resumen small { display: block; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .04em;
        color: var(--texto-suave); margin-bottom: 6px; }
    .hs-resumen strong { font-size: 22px; font-weight: 700; color: var(--texto); }
    .hs-filtros { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 12px 16px; margin-bottom: 20px; }
    .hs-filtros label { display: block; font-size: 12px; font-weight: 600; letter-spacing: .05em; text-transform: uppercase;
        color: var(--texto-suave); margin-bottom: 6px; }
    .hs-filtros input { height: 44px; padding: 0 14px; background: #fff; border: 1px solid var(--borde); border-radius: 0;
        font-family: inherit; font-size: 14px; color: var(--texto); outline: none; }
    .hs-filtros input:focus { border-color: var(--primario); box-shadow: 0 0 0 3px rgba(109, 40, 217, 0.1); }
    .hs-limpiar { font-size: 14px; color: var(--texto-suave); text-decoration: none; padding: 0 6px; height: 44px; display: inline-flex; align-items: center; }
    .hs-limpiar:hover { color: var(--primario); }
    .hs-nombre { font-weight: 600; color: var(--texto); }
    .hs-sub { font-size: 12px; color: var(--texto-suave); margin-top: 2px; }
    .hs-num { white-space: nowrap; font-variant-numeric: tabular-nums; text-align: right; }
    .hs-diferente { color: #b54708; font-weight: 600; }
    .hs-ingreso { color: #067647; }
    .hs-badge { display: inline-block; padding: 3px 10px; font-size: 12px; font-weight: 600; border: 1px solid;
        background: #ecfdf3; color: #067647; border-color: #abefc6; }
    .hs-pager { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 16px; font-size: 14px; color: var(--texto-suave); }
    .hs-pager a, .hs-pager span.hs-off { display: inline-flex; align-items: center; height: 38px; padding: 0 16px; background: #fff;
        border: 1px solid var(--borde); color: var(--texto); text-decoration: none; font-weight: 600; font-size: 14px; }
    .hs-pager a:hover { border-color: #c4b5fd; background: #fcfbff; }
    .hs-pager span.hs-off { color: #9ca3af; }
</style>
@endpush

<x-sidebar activo="pagos" />

<div class="lst-pagina">

    <div class="lst-encabezado">
        <div>
            <div class="lst-titulo-fila">
                <button type="button" class="btn-menu-lateral" data-abrir-sidebar aria-label="Mostrar menú lateral">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1>Pagos realizados</h1>
            </div>
            <p>Historial de recibos registrados de los servicios del negocio.</p>
        </div>
        <a href="{{ route('admin.pago_servicios.registrar') }}" class="lst-btn-principal">Registrar pago</a>
    </div>

    @if(session('success'))
        <div class="lst-mensaje exito">{{ session('success') }}</div>
    @endif

    <div class="hs-resumen">
        <div>
            <small>Total pagado</small>
            <strong>${{ number_format((float) $totalPagos, 2) }}</strong>
        </div>
        <div>
            <small>Total cobrado</small>
            <strong>${{ number_format((float) $totalIngresos, 2) }}</strong>
        </div>
        <div>
            <small>Recibos</small>
            <strong>{{ number_format($recibos->total()) }}</strong>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.pago_servicios.historial') }}" class="hs-filtros">
        <div>
            <label for="servicio">Servicio</label>
            <input type="text" id="servicio" name="servicio" value="{{ request('servicio') }}" placeholder="Buscar servicio...">
        </div>
        <div>
            <label for="desde">Desde</label>
            <input type="date" id="desde" name="desde" value="{{ request('desde') }}">
        </div>
        <div>
            <label for="hasta">Hasta</label>
            <input type="date" id="hasta" name="hasta" value="{{ request('hasta') }}">
        </div>
        <button type="submit" class="lst-btn-principal">Filtrar</button>
        @if(request()->hasAny(['servicio', 'desde', 'hasta']))
            <a href="{{ route('admin.pago_servicios.historial') }}" class="hs-limpiar">Limpiar</a>
        @endif
    </form>

    @if($recibos->isNotEmpty())
        <div class="lst-tabla-wrap">
            <table class="lst-tabla">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Periodo</th>
                        <th>Fecha del recibo</th>
                        <th>Fecha de pago</th>
                        <th>Cuenta</th>
                        <th style="text-align:right;">Monto agenda</th>
                        <th style="text-align:right;">Monto real</th>
                        <th>Siguiente pago</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recibos as $r)
                        @php $ingreso = $r->tipo_movimiento === 'ingreso'; @endphp
                        <tr style="cursor: default;">
                            <td data-label="Servicio">
                                <div class="hs-nombre">{{ $r->servicio }}</div>
                                <div class="hs-sub">{{ $ingreso ? 'Ingreso' : 'Pago' }}{{ $r->folio_recibo ? ' · Folio '.$r->folio_recibo : '' }}</div>
                            </td>
                            <td data-label="Periodo">{{ $r->periodo }}</td>
                            <td data-label="Fecha del recibo">{{ $r->fecha_recibo->format('d/m/Y') }}</td>
                            <td data-label="Fecha de pago">{{ $r->fecha_pago->format('d/m/Y') }}</td>
                            <td data-label="Cuenta">{{ $r->cuenta?->nombre ?? '—' }}</td>
                            <td data-label="Monto agenda" class="hs-num">${{ number_format((float) $r->monto_agenda, 2) }}</td>
                            <td data-label="Monto real" class="hs-num {{ $r->monto_diferente ? 'hs-diferente' : '' }} {{ $ingreso ? 'hs-ingreso' : '' }}">
                                ${{ number_format((float) $r->monto_pagado, 2) }}
                            </td>
                            <td data-label="Siguiente pago">{{ $r->fecha_siguiente_pago?->format('d/m/Y') ?? '—' }}</td>
                            <td data-label="Estado"><span class="hs-badge">{{ $r->estado }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($recibos->hasPages())
            <div class="hs-pager">
                @if($recibos->onFirstPage())
                    <span class="hs-off">Anterior</span>
                @else
                    <a href="{{ $recibos->previousPageUrl() }}">Anterior</a>
                @endif
                <span>Página {{ $recibos->currentPage() }} de {{ $recibos->lastPage() }}</span>
                @if($recibos->hasMorePages())
                    <a href="{{ $recibos->nextPageUrl() }}">Siguiente</a>
                @else
                    <span class="hs-off">Siguiente</span>
                @endif
            </div>
        @endif
    @else
        <div class="lst-vacio" style="display:block;">
            Aún no hay pagos registrados con esos filtros.
        </div>
    @endif
</div>

</x-layouts.panel>