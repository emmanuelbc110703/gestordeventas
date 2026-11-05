<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PagoServicio extends Model
{
    protected $table = 'pagos_servicios';

    protected $fillable = [
        'agenda_pago_servicio_id',
        'user_id',
        'monto_agenda',
        'monto_pagado',
        'fecha_pago',
        'fecha_recibo',
        'periodo_inicio',
        'periodo_fin',
        'folio_recibo',
        'informacion_recibo',
        'estado',
        'fecha_siguiente_pago',
    ];

    protected function casts(): array
    {
        return [
            'monto_agenda' => 'decimal:2',
            'monto_pagado' => 'decimal:2',
            'fecha_pago' => 'date',
            'fecha_recibo' => 'date',
            'periodo_inicio' => 'date',
            'periodo_fin' => 'date',
            'fecha_siguiente_pago' => 'date',
        ];
    }

    public function agenda(): BelongsTo
    {
        return $this->belongsTo(AgendaPagoServicio::class, 'agenda_pago_servicio_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getPeriodoAttribute(): string
    {
        return $this->periodo_inicio->format('d/m/Y').' al '.$this->periodo_fin->format('d/m/Y');
    }

    public function getMontoDiferenteAttribute(): bool
    {
        return (int) round($this->monto_pagado * 100) !== (int) round($this->monto_agenda * 100);
    }
}