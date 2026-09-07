<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoVenta extends Model
{
    protected $table = 'puntos_venta';

    protected $fillable = [
        'nombre_caja',
        'numero_caja',
        'sucursal',
        'empleado_id',
    ];

    public function empleado()
    {
        return $this->belongsTo(
            User::class,
            'empleado_id'
        );
    }

    public function ventas()
    {
        return $this->hasMany(
            Venta::class,
            'punto_venta_id'
        );
    }
}