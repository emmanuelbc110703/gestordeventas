<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use SoftDeletes;

    protected $table = 'inventarios';

    protected $fillable = [
        'nombre',
        'foto',
        'descripcion',
        'precio',
        'costo',
        'referencia',
        'tipo',
        'categoria_id',
        'fecha_adquisicion',
        'cantidad',
        'disponible_punto_venta',
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
        'disponible_punto_venta' => 'boolean',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function cotizacionDetalles(): HasMany
    {
        return $this->hasMany(
            CotizacionDetalle::class,
            'inventario_id'
        );
    }
}