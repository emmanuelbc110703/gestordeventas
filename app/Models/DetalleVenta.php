<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';

    protected $fillable = [
        'venta_id',
        'inventario_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Venta a la que pertenece este detalle.
     */
    public function venta(): BelongsTo
    {
        return $this->belongsTo(
            Venta::class,
            'venta_id'
        );
    }

    /**
     * Servicio/producto vendido.
     */
    public function inventario(): BelongsTo
    {
        return $this->belongsTo(
            Inventario::class,
            'inventario_id'
        );
    }
}