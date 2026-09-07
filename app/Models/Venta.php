<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'folio',
        'punto_venta_id',
        'empleado_id',
        'cliente_id',

        'subtotal',

        'descuento_porcentaje',
        'descuento',

        'impuesto_porcentaje',
        'impuesto',

        'total',

        'forma_pago',

        'efectivo_recibido',
        'cambio',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',

        'descuento_porcentaje' => 'decimal:2',
        'descuento' => 'decimal:2',

        'impuesto_porcentaje' => 'decimal:2',
        'impuesto' => 'decimal:2',

        'total' => 'decimal:2',

        'efectivo_recibido' => 'decimal:2',
        'cambio' => 'decimal:2',
    ];

    // ========================================
    // PUNTO DE VENTA
    // ========================================

    public function puntoVenta()
    {
        return $this->belongsTo(
            PuntoVenta::class,
            'punto_venta_id'
        );
    }

    // ========================================
    // EMPLEADO
    // ========================================

    public function empleado()
    {
        return $this->belongsTo(
            User::class,
            'empleado_id'
        );
    }

    // ========================================
    // CLIENTE
    // ========================================

    public function cliente()
    {
        return $this->belongsTo(
            User::class,
            'cliente_id'
        );
    }

    // ========================================
    // DETALLES
    // ========================================

    public function detalles()
    {
        return $this->hasMany(
            DetalleVenta::class,
            'venta_id'
        );
    }
}