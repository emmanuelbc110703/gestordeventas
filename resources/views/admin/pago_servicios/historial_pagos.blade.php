@php
    $input = 'w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900';
@endphp

<x-layouts.panel
    titulo="Pagos de servicios realizados"
    :migas="[
        ['texto' => 'Pago de servicios', 'url' => url('/admin/pago-servicios')],
        ['texto' => 'Pagos realizados', 'url' => null],
    ]"
>
    <div class="space-y-6">

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-zinc-500">Historial de recibos pagados.</p>
            <a href="{{ route('admin.pago_servicios.registrar') }}"
               class="rounded-lg bg-zinc-900 px-3 py-2 text-sm font-medium text-white hover:bg-zinc-700">
                Registrar pago
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-300 bg-green-50 p-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
        <form method="GET" action="{{ route('admin.pago_servicios.historial') }}"
              class="grid gap-4 sm:grid-cols-4">
            <div>
                <label for="servicio" class="mb-1 block text-sm font-medium">Servicio</label>
                <input id="servicio" name="servicio" type="text" value="{{ request('servicio') }}"
                       placeholder="Buscar por nombre…" class="{{ $input }}">
            </div>
            <div>
                <label for="desde" class="mb-1 block text-sm font-medium">Pagado desde</label>
                <input id="desde" name="desde" type="date" value="{{ request('desde') }}" class="{{ $input }}">
            </div>
            <div>
                <label for="hasta" class="mb-1 block text-sm font-medium">Pagado hasta</label>
                <input id="hasta" name="hasta" type="date" value="{{ request('hasta') }}" class="{{ $input }}">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit"
                        class="rounded-lg border border-zinc-300 px-4 py-2 text-sm font-medium hover:bg-zinc-50">
                    Filtrar
                </button>
                <a href="{{ route('admin.pago_servicios.historial') }}"
                   class="px-2 py-2 text-sm text-zinc-500 hover:underline">Limpiar</a>
            </div>
        </form>

        <div class="overflow-x-auto rounded-lg border border-zinc-200">
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50 text-left text-zinc-500">
                    <tr>
                        <th class="px-3 py-2">Servicio</th>
                        <th class="px-3 py-2">Periodo</th>
                        <th class="px-3 py-2">Fecha recibo</th>
                        <th class="px-3 py-2">Fecha pago</th>
                        <th class="px-3 py-2 text-right">Monto agenda</th>
                        <th class="px-3 py-2 text-right">Monto pagado</th>
                        <th class="px-3 py-2">Folio</th>
                        <th class="px-3 py-2">Estado</th>
                        <th class="px-3 py-2">Siguiente pago</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200">
                    @forelse ($recibos as $recibo)
                        <tr>
                            <td class="px-3 py-2 font-medium">{{ $recibo->servicio }}</td>
                            <td class="px-3 py-2">{{ $recibo->periodo }}</td>
                            <td class="px-3 py-2">{{ $recibo->fecha_recibo->format('d/m/Y') }}</td>
                            <td class="px-3 py-2">{{ $recibo->fecha_pago->format('d/m/Y') }}</td>
                            <td class="px-3 py-2 text-right">${{ number_format((float) $recibo->monto_agenda, 2) }}</td>
                            <td class="px-3 py-2 text-right font-medium {{ $recibo->monto_diferente ? 'text-amber-600' : '' }}">
                                ${{ number_format((float) $recibo->monto_pagado, 2) }}
                            </td>
                            <td class="px-3 py-2">{{ $recibo->folio_recibo ?? '—' }}</td>
                            <td class="px-3 py-2">
                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">
                                    {{ $recibo->estado }}
                                </span>
                            </td>
                            <td class="px-3 py-2">{{ $recibo->fecha_siguiente_pago?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-3 py-6 text-center text-zinc-500">
                                No hay pagos registrados con esos filtros.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>{{ $recibos->links() }}</div>
            <div class="text-sm">
                Total pagado (filtro actual):
                <span class="font-semibold">${{ number_format((float) $total, 2) }}</span>
            </div>
        </div>
    </div>
</x-layouts.panel>