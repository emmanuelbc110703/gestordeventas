<?php
namespace App\Services;

use App\Models\AgendaPagoServicio;
use App\Models\PagoServicio;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrarPagoServicio
{
    public function ejecutar(
        int $agendaId,
        string|float $montoPagado,
        string $fechaPago,
        string $fechaRecibo,
        ?string $folioRecibo = null,
        ?string $informacionRecibo = null,
        ?int $userId = null,
    ): PagoServicio {
        return DB::transaction(function () use (
            $agendaId, $montoPagado, $fechaPago, $fechaRecibo,
            $folioRecibo, $informacionRecibo, $userId
        ) {
            $agenda = AgendaPagoServicio::query()->lockForUpdate()->findOrFail($agendaId);

            if ($agenda->estado !== 'pendiente') {
                throw ValidationException::withMessages([
                    'agendaId' => 'Este servicio no tiene un pago pendiente.',
                ]);
            }

            $programada = Carbon::parse($agenda->fecha_pago)->startOfDay();
            $siguiente = $this->calcularSiguiente($programada, $agenda->periodicidad);

            $centavosPagados = (int) round(((float) $montoPagado) * 100);
            $centavosAgenda = (int) round(((float) $agenda->monto) * 100);

            $pago = PagoServicio::create([
                'agenda_pago_servicio_id' => $agenda->id,
                'user_id' => $userId,
                'monto_agenda' => $centavosAgenda / 100,
                'monto_pagado' => $centavosPagados / 100,
                'fecha_pago' => $fechaPago,
                'fecha_recibo' => $fechaRecibo,
                'periodo_inicio' => $programada->toDateString(),
                'periodo_fin' => $siguiente->copy()->subDay()->toDateString(),
                'folio_recibo' => $folioRecibo,
                'informacion_recibo' => $informacionRecibo,
                'estado' => 'pagado',
                'fecha_siguiente_pago' => $siguiente->toDateString(),
            ]);

            if ($centavosPagados !== $centavosAgenda) {
                $agenda->monto = $centavosPagados / 100;
            }

            $agenda->estado = 'pagado';
            $agenda->fecha_pago = $siguiente->toDateString();
            $agenda->save();

            return $pago;
        });
    }

    public function calcularSiguiente(Carbon $desde, string $periodicidad): Carbon
    {
        $fecha = $desde->copy();

        return match (mb_strtolower(trim($periodicidad))) {
            'semanal' => $fecha->addWeek(),
            'quincenal' => $fecha->addDays(15),
            'mensual' => $fecha->addMonthNoOverflow(),
            'bimestral' => $fecha->addMonthsNoOverflow(2),
            'trimestral' => $fecha->addMonthsNoOverflow(3),
            'semestral' => $fecha->addMonthsNoOverflow(6),
            'anual' => $fecha->addYearNoOverflow(),
            default => throw new \InvalidArgumentException("Periodicidad no soportada: {$periodicidad}"),
        };
    }
}