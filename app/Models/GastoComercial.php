<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GastoComercial extends Model
{
    use HasFactory;

    protected $table = 'gastos_comerciales';

    protected $fillable = [
        'fecha',
        'concepto',
        'descripcion',
        'categoria',
        'monto',
        'user_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}