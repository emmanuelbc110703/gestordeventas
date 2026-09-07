<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventario extends Model
{
    protected $table = 'inventarios';

    protected $fillable = [
        'nombre',
        'foto',
        'descripcion',
        'precio',
        'tipo',
        'cantidad',
    ];

    /**
     * Detalles de cotizaciones donde aparece este servicio.
     */
    public function cotizacionDetalles(): HasMany
    {
        return $this->hasMany(
            CotizacionDetalle::class,
            'inventario_id'
        );
    }
}