<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Caja extends Model
{
    protected $table = 'cajas';

    protected $fillable = [
        'punto_venta_id',
        'empleado_id',
        'fecha',
        'hora_apertura',
        'monto_inicial',
        'estado',
        'hora_cierre',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_apertura' => 'datetime',
        'hora_cierre' => 'datetime',
        'monto_inicial' => 'decimal:2',
    ];


    /**
     * Punto de venta de esta caja.
     */
    public function puntoVenta(): BelongsTo
    {
        return $this->belongsTo(
            PuntoVenta::class,
            'punto_venta_id'
        );
    }


    /**
     * Empleado que abrió la caja.
     */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'empleado_id'
        );
    }
}