<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CotizacionDetalle extends Model
{
    protected $table = 'cotizacion_detalles';

    protected $fillable = [
        'cotizacion_id',
        'inventario_id',
        'nombre',
        'cantidad',
        'precio',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Cotización a la que pertenece.
     */
    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(
            Cotizacion::class,
            'cotizacion_id'
        );
    }

    /**
     * Servicio original del inventario.
     */
    public function inventario(): BelongsTo
    {
        return $this->belongsTo(
            Inventario::class,
            'inventario_id'
        );
    }
}