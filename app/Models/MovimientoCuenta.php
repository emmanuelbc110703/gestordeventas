<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoCuenta extends Model
{
    protected $table = 'movimientos_cuentas';

    protected $fillable = [
        'cuenta_financiera_id',
        'tipo',
        'monto',
        'fecha',
        'concepto',
        'recibo_pago_servicio_id',
        'user_id',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'date',
    ];

    public function cuenta(): BelongsTo
    {
        return $this->belongsTo(CuentaFinanciera::class, 'cuenta_financiera_id');
    }
}