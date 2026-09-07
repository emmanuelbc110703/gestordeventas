<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AperturaCaja extends Model
{
    protected $table = 'aperturas_caja';

    protected $fillable = [
        'punto_venta_id',
        'empleado_id',
        'fecha',
        'hora_apertura',
        'dinero_inicial',
    ];

    public function puntoVenta(): BelongsTo
    {
        return $this->belongsTo(
            PuntoVenta::class,
            'punto_venta_id'
        );
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'empleado_id'
        );
    }
}