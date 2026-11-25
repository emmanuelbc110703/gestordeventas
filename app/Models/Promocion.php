<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocion extends Model
{
    use SoftDeletes;

    protected $table = 'promociones';

    protected $fillable = [
        'nombre', 'descripcion', 'tipo_descuento', 'valor',
        'fecha_inicio', 'fecha_fin', 'activa',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'activa'       => 'boolean',
        'valor'        => 'decimal:2',
    ];

    public function inventarios(): BelongsToMany
    {
        return $this->belongsToMany(Inventario::class, 'inventario_promocion', 'promocion_id', 'inventario_id');
    }

    public function scopeVigentes($query)
    {
        $hoy = today();

        return $query->where('activa', true)
            ->whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy);
    }

    public function estaVigente(): bool
    {
        return $this->activa
            && $this->fecha_inicio->lte(today())
            && $this->fecha_fin->gte(today());
    }

    public function getEstadoAttribute(): string
    {
        if (! $this->activa) return 'Inactiva';
        if ($this->fecha_inicio->gt(today())) return 'Programada';
        if ($this->fecha_fin->lt(today())) return 'Vencida';
        return 'Vigente';
    }

    public function calcularDescuento(float $precio): float
    {
        $descuento = $this->tipo_descuento === 'porcentaje'
            ? $precio * ((float) $this->valor / 100)
            : (float) $this->valor;

        return round(min($descuento, $precio), 2);
    }
}