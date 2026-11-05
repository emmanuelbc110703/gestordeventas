<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoServicio extends Model
{
    protected $table = 'pagos_servicios';

    protected $fillable = [
        'servicio',
        'descripcion',
        'fecha_pago',
        'monto',
        'estado',
        'fecha_vencimiento',
        'observaciones',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'fecha_vencimiento' => 'date',
        'monto' => 'decimal:2',
    ];
}