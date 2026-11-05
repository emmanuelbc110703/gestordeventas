<?php

use App\Models\PagoServicio;
use Illuminate\Support\Facades\Gate;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $servicio = '';
    public string $desde = '';
    public string $hasta = '';

    public function mount(): void
    {
        Gate::authorize('administrar-pagos-servicios');
    }

    public function updated($property): void
    {
        if (in_array($property, ['servicio', 'desde', 'hasta'])) {
            $this->resetPage();
        }
    }

    public function with(): array
    {
        $query = PagoServicio::query()
            ->with('agenda')
            ->when($this->servicio !== '', fn ($q) => $q->whereHas(
                'agenda',
                fn ($a) => $a->where('nombre_servicio', 'like', '%'.$this->servicio.'%')
            ))
            ->when($this->desde !== '', fn ($q) => $q->whereDate('fecha_pago', '>=', $this->desde))
            ->when($this->hasta !== '', fn ($q) => $q->whereDate('fecha_pago', '<=', $this->hasta));

        return [
            'total' => (clone $query)->sum('monto_pagado'),
            'pagos' => $query->latest('fecha_pago')->latest('id')->paginate(10),
        ];
    }
}; ?>

<div class="w-full space-y-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <flux:heading size="xl">Pagos de servicios realizados</flux:heading>
            <flux:subheading>Historial de recibos pagados.</flux:subheading>
        </div>
        <flux:button :href="route('pagos-servicios.registrar')" wire:navigate variant="primary">Registrar pago</flux:button>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <flux:input wire:model.live.debounce.400ms="servicio" label="Servicio" placeholder="Buscar por nombre…" />
        <flux:input wire:model.live="desde" type="date" label="Pagado desde" />
        <flux:input wire:model.live="hasta" type="date" label="Pagado hasta" />
    </div>

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="min-w-full text-sm">
            <thead class="bg-zinc-50 text-left text-zinc-500 dark:bg-zinc-800">
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
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse ($pagos as $pago)
                    <tr wire:key="pago-{{ $pago->id }}">
                        <td class="px-3 py-2 font-medium">{{ $pago->agenda->nombre_servicio }}</td>
                        <td class="px-3 py-2">{{ $pago->periodo }}</td>
                        <td class="px-3 py-2">{{ $pago->fecha_recibo->format('d/m/Y') }}</td>
                        <td class="px-3 py-2">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                        <td class="px-3 py-2 text-right">${{ number_format($pago->monto_agenda, 2) }}</td>
                        <td class="px-3 py-2 text-right font-medium {{ $pago->monto_diferente ? 'text-amber-600 dark:text-amber-400' : '' }}">
                            ${{ number_format($pago->monto_pagado, 2) }}
                        </td>
                        <td class="px-3 py-2">{{ $pago->folio_recibo ?? '—' }}</td>
                        <td class="px-3 py-2"><flux:badge color="green" size="sm">{{ ucfirst($pago->estado) }}</flux:badge></td>
                        <td class="px-3 py-2">{{ $pago->fecha_siguiente_pago->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="px-3 py-6 text-center text-zinc-500">No hay pagos registrados con esos filtros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>{{ $pagos->links() }}</div>
        <div class="text-sm">Total pagado (filtro actual): <span class="font-semibold">${{ number_format($total, 2) }}</span></div>
    </div>
</div>