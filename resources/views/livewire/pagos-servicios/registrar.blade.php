<?php

use App\Models\AgendaPagoServicio;
use App\Services\RegistrarPagoServicio;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    public $agendaId = null;
    public string $montoPagado = '';
    public string $fechaPago = '';
    public string $fechaRecibo = '';
    public string $folioRecibo = '';
    public string $informacionRecibo = '';

    public function mount(): void
    {
        Gate::authorize('administrar-pagos-servicios');

        $this->fechaPago = today()->toDateString();
        $this->fechaRecibo = today()->toDateString();
    }

    #[Computed]
    public function pendientes()
    {
        return AgendaPagoServicio::query()
            ->where('estado', 'pendiente')
            ->orderBy('fecha_pago')
            ->get();
    }

    #[Computed]
    public function agenda(): ?AgendaPagoServicio
    {
        return $this->agendaId
            ? $this->pendientes->firstWhere('id', (int) $this->agendaId)
            : null;
    }

    #[Computed]
    public function diferencia(): ?float
    {
        if (! $this->agenda || ! is_numeric($this->montoPagado)) {
            return null;
        }

        return round((float) $this->montoPagado - (float) $this->agenda->monto, 2);
    }

    public function updatedAgendaId(): void
    {
        $this->montoPagado = $this->agenda
            ? number_format((float) $this->agenda->monto, 2, '.', '')
            : '';
        $this->resetValidation();
    }

    public function guardar(RegistrarPagoServicio $registrar): void
    {
        Gate::authorize('administrar-pagos-servicios');

        $this->validate([
            'agendaId' => ['required', 'integer', 'exists:agenda_pagos_servicios,id'],
            'montoPagado' => ['required', 'numeric', 'gt:0', 'max:9999999999.99'],
            'fechaPago' => ['required', 'date', 'before_or_equal:today'],
            'fechaRecibo' => ['required', 'date', 'before_or_equal:fechaPago'],
            'folioRecibo' => ['nullable', 'string', 'max:100'],
            'informacionRecibo' => ['nullable', 'string', 'max:1000'],
        ], [
            'agendaId.required' => 'Selecciona el servicio del recibo.',
            'montoPagado.required' => 'Captura el monto que aparece en el recibo.',
            'montoPagado.gt' => 'El monto debe ser mayor a cero.',
            'fechaPago.before_or_equal' => 'La fecha de pago no puede ser futura.',
            'fechaRecibo.before_or_equal' => 'La fecha del recibo no puede ser posterior a la fecha de pago.',
        ]);

        $pago = $registrar->ejecutar(
            agendaId: (int) $this->agendaId,
            montoPagado: $this->montoPagado,
            fechaPago: $this->fechaPago,
            fechaRecibo: $this->fechaRecibo,
            folioRecibo: $this->folioRecibo ?: null,
            informacionRecibo: $this->informacionRecibo ?: null,
            userId: Auth::id(),
        );

        $nombre = $pago->agenda->nombre_servicio;
        $siguiente = $pago->fecha_siguiente_pago->format('d/m/Y');

        $this->reset(['agendaId', 'montoPagado', 'folioRecibo', 'informacionRecibo']);
        $this->fechaPago = today()->toDateString();
        $this->fechaRecibo = today()->toDateString();
        unset($this->pendientes, $this->agenda, $this->diferencia);

        session()->flash('ok', "Pago de {$nombre} registrado. Siguiente pago: {$siguiente}.");
    }
}; ?>

<div class="mx-auto w-full max-w-3xl space-y-6">
    <div>
        <flux:heading size="xl">Registrar pago de servicio</flux:heading>
        <flux:subheading>Selecciona el servicio del recibo que recibiste y captura lo que realmente pagaste.</flux:subheading>
    </div>

    @if (session('ok'))
        <div class="rounded-lg border border-green-300 bg-green-50 p-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-950 dark:text-green-200">
            {{ session('ok') }}
        </div>
    @endif

    @if ($this->pendientes->isEmpty())
        <div class="rounded-lg border border-zinc-200 p-6 text-center text-sm text-zinc-500 dark:border-zinc-700">
            No hay servicios con pago pendiente.
        </div>
    @else
        <flux:select wire:model.live="agendaId" label="Servicio con pago pendiente" placeholder="Selecciona un servicio…">
            @foreach ($this->pendientes as $p)
                <flux:select.option value="{{ $p->id }}">
                    {{ $p->nombre_servicio }} · vence {{ Carbon::parse($p->fecha_pago)->format('d/m/Y') }} · ${{ number_format($p->monto, 2) }}
                </flux:select.option>
            @endforeach
        </flux:select>

        @if ($this->agenda)
            {{-- Datos registrados en la Agenda de Pagos de Servicios --}}
            <div class="grid grid-cols-2 gap-4 rounded-lg border border-zinc-200 p-4 text-sm dark:border-zinc-700 sm:grid-cols-4">
                <div>
                    <div class="text-zinc-500">Servicio</div>
                    <div class="font-medium">{{ $this->agenda->nombre_servicio }}</div>
                </div>
                <div>
                    <div class="text-zinc-500">Monto en agenda</div>
                    <div class="font-medium">${{ number_format($this->agenda->monto, 2) }}</div>
                </div>
                <div>
                    <div class="text-zinc-500">Fecha programada</div>
                    <div class="font-medium">{{ Carbon::parse($this->agenda->fecha_pago)->format('d/m/Y') }}</div>
                </div>
                <div>
                    <div class="text-zinc-500">Periodicidad</div>
                    <div class="font-medium">{{ ucfirst($this->agenda->periodicidad) }}</div>
                </div>
            </div>

            <form wire:submit="guardar" class="space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <flux:input wire:model.live.debounce.400ms="montoPagado" type="number" step="0.01" min="0.01"
                                label="Monto pagado (según recibo)" />
                    <flux:input wire:model="folioRecibo" label="Folio / número de recibo (opcional)" />
                    <flux:input wire:model="fechaRecibo" type="date" label="Fecha del recibo" />
                    <flux:input wire:model="fechaPago" type="date" label="Fecha en que se pagó" />
                </div>

                @if (! is_null($this->diferencia))
                    @if ($this->diferencia == 0)
                        <p class="text-sm text-green-700 dark:text-green-300">El monto coincide con la agenda; se conservará.</p>
                    @else
                        <p class="text-sm text-amber-700 dark:text-amber-300">
                            El monto es {{ $this->diferencia > 0 ? 'mayor' : 'menor' }} por
                            ${{ number_format(abs($this->diferencia), 2) }} que el de la agenda;
                            se actualizará con la cantidad pagada.
                        </p>
                    @endif
                @endif

                <flux:textarea wire:model="informacionRecibo" label="Información del recibo (opcional)"
                               placeholder="Número de contrato, referencia, observaciones…" rows="3" />

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary"
                                 wire:confirm="¿Confirmas que este servicio ya fue pagado?">
                        Confirmar pago
                    </flux:button>
                </div>
            </form>
        @endif
    @endif
</div>