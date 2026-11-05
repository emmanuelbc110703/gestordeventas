<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'categoria_id',
        'fecha_adquisicion',
        'cantidad',
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
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