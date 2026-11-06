<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PagoServicio extends Model
{
    protected $table = 'pagos_servicios';

    public const TIPOS_MOVIMIENTO = [
        'egreso' => 'Pago (sale dinero)',
        'ingreso' => 'Ingreso (entra dinero)',
    ];

    protected $fillable = [
        'servicio',
        'descripcion',
        'fecha_pago',
        'monto',
        'estado',
        'periodicidad',
        'tipo_movimiento',
        'cuenta_financiera_id',
        'fecha_vencimiento',
        'observaciones',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'fecha_vencimiento' => 'date',
        'monto' => 'decimal:2',
    ];

    public function cuenta(): BelongsTo
    {
        return $this->belongsTo(CuentaFinanciera::class, 'cuenta_financiera_id');
    }

    public function recibos(): HasMany
    {
        return $this->hasMany(ReciboPagoServicio::class, 'pago_servicio_id');
    }

    public function esIngreso(): bool
    {
        return $this->tipo_movimiento === 'ingreso';
    }
}