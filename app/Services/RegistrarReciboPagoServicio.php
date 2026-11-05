<?php

namespace App\Services;

use App\Models\PagoServicio;
use App\Models\ReciboPagoServicio;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrarReciboPagoServicio
{
    public const PERIODICIDADES = [
        'unico' => 'Único (no se repite)',
        'semanal' => 'Semanal',
        'quincenal' => 'Quincenal',
        'mensual' => 'Mensual',
        'bimestral' => 'Bimestral',
        'trimestral' => 'Trimestral',
        'semestral' => 'Semestral',
        'anual' => 'Anual',
    ];

    public function ejecutar(int $pagoServicioId, array $datos, ?int $userId = null): ReciboPagoServicio
    {
        return DB::transaction(function () use ($pagoServicioId, $datos, $userId) {
            $pago = PagoServicio::lockForUpdate()->findOrFail($pagoServicioId);

            if ($pago->estado !== 'Pendiente') {
                throw ValidationException::withMessages([
                    'pago_servicio_id' => 'Este servicio ya fue marcado como pagado.',
                ]);
            }

            $periodicidad = $pago->periodicidad ?: ($datos['periodicidad'] ?? null);

            if (! $periodicidad || ! isset(self::PERIODICIDADES[$periodicidad])) {
                throw ValidationException::withMessages([
                    'periodicidad' => 'Indica la periodicidad del servicio.',
                ]);
            }

            $programada = $pago->fecha_pago->copy()->startOfDay();
            $siguiente = $periodicidad === 'unico'
                ? null
                : $this->calcularSiguiente($programada, $periodicidad);

            $centavosAgenda = (int) round(((float) $pago->monto) * 100);
            $centavosPagado = (int) round(((float) $datos['monto_pagado']) * 100);
            $montoAgenda = $centavosAgenda / 100;
            $montoPagado = $centavosPagado / 100;

            $recibo = ReciboPagoServicio::create([
                'pago_servicio_id' => $pago->id,
                'user_id' => $userId,
                'servicio' => $pago->servicio,
                'monto_agenda' => $montoAgenda,
                'monto_pagado' => $montoPagado,
                'fecha_pago' => $datos['fecha_pago'],
                'fecha_recibo' => $datos['fecha_recibo'],
                'periodo_inicio' => $programada->toDateString(),
                'periodo_fin' => ($siguiente ? $siguiente->copy()->subDay() : $programada)->toDateString(),
                'folio_recibo' => $datos['folio_recibo'] ?? null,
                'informacion_recibo' => $datos['informacion_recibo'] ?? null,
                'estado' => 'Pagado',
                'fecha_siguiente_pago' => $siguiente?->toDateString(),
            ]);

            $pago->monto = $montoPagado;
            $pago->estado = 'Pagado';
            $pago->periodicidad = $periodicidad;
            $pago->save();

            if ($siguiente) {
                $vencimiento = $pago->fecha_vencimiento
                    ? $this->calcularSiguiente($pago->fecha_vencimiento->copy()->startOfDay(), $periodicidad)
                    : null;

                $yaExiste = PagoServicio::where('servicio', $pago->servicio)
                    ->where('estado', 'Pendiente')
                    ->whereDate('fecha_pago', $siguiente->toDateString())
                    ->exists();

                if (! $yaExiste) {
                    (new PagoServicio)->forceFill([
                        'servicio' => $pago->servicio,
                        'descripcion' => $pago->descripcion,
                        'fecha_pago' => $siguiente->toDateString(),
                        'monto' => $montoPagado,
                        'estado' => 'Pendiente',
                        'periodicidad' => $periodicidad,
                        'fecha_vencimiento' => $vencimiento?->toDateString(),
                    ])->save();
                }
            }

            return $recibo;
        });
    }

    public function calcularSiguiente(Carbon $desde, string $periodicidad): Carbon
    {
        $fecha = $desde->copy();

        return match ($periodicidad) {
            'semanal' => $fecha->addWeek(),
            'quincenal' => $fecha->addDays(15),
            'mensual' => $fecha->addMonthsNoOverflow(1),
            'bimestral' => $fecha->addMonthsNoOverflow(2),
            'trimestral' => $fecha->addMonthsNoOverflow(3),
            'semestral' => $fecha->addMonthsNoOverflow(6),
            'anual' => $fecha->addYearsNoOverflow(1),
            default => throw new \InvalidArgumentException("Periodicidad no soportada: {$periodicidad}"),
        };
    }
}