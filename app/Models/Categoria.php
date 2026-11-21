<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    public const TIPOS = [
        'bien'     => ['singular' => 'Bien',     'plural' => 'Bienes'],
        'servicio' => ['singular' => 'Servicio', 'plural' => 'Servicios'],
        'gasto'    => ['singular' => 'Gasto',    'plural' => 'Gastos'],
    ];

    public const MODULOS = [
        'inventarios' => ['registro de inventario', 'registros de inventario'],
        'gastos'      => ['gasto comercial', 'gastos comerciales'],
    ];

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
    ];

    public static function tipoValido(?string $tipo): bool
    {
        return $tipo !== null && array_key_exists($tipo, self::TIPOS);
    }

    public function inventarios(): HasMany
    {
        return $this->hasMany(Inventario::class, 'categoria_id');
    }

    public function gastos(): HasMany
    {
        return $this->hasMany(GastoComercial::class, 'categoria_id');
    }

    public function scopeDeTipo(Builder $query, string $tipo): Builder
    {
        return $query->where('tipo', $tipo);
    }

    public function getTipoEtiquetaAttribute(): string
    {
        return self::TIPOS[$this->tipo]['singular'] ?? ucfirst((string) $this->tipo);
    }

    public function usos(): array
    {
        $usos = [];

        foreach (array_keys(self::MODULOS) as $relacion) {
            $clave = $relacion . '_count';

            $total = array_key_exists($clave, $this->attributes)
                ? (int) $this->attributes[$clave]
                : $this->{$relacion}()->count();

            if ($total > 0) {
                $usos[$relacion] = $total;
            }
        }

        return $usos;
    }

    public function estaEnUso(): bool
    {
        return array_sum($this->usos()) > 0;
    }

    public function descripcionDeUsos(): string
    {
        return collect($this->usos())
            ->map(fn ($total, $relacion) => $total . ' ' . self::MODULOS[$relacion][$total === 1 ? 0 : 1])
            ->values()
            ->join(', ', ' y ');
    }
}