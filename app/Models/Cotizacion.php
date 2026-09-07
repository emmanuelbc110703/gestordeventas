<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';

    protected $fillable = [
        'user_id',
        'folio',
        'estado',
        'forma_pago',
        'subtotal',
        'descuento',
        'descuento_porcentaje',
        'impuesto',
        'impuesto_porcentaje',
        'total',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'descuento_porcentaje' => 'decimal:2',
        'impuesto' => 'decimal:2',
        'impuesto_porcentaje' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Cliente que realizó la cotización.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Servicios de la cotización.
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(
            CotizacionDetalle::class,
            'cotizacion_id'
        );
    }
}