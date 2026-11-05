<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    public function cotizaciones(): HasMany
    {
        return $this->hasMany(Cotizacion::class, 'user_id');
    }

    public function puntoVenta(): HasOne
    {
        return $this->hasOne(PuntoVenta::class, 'empleado_id');
    }

    /**
     * Campos que se pueden guardar masivamente.
     */
    protected $fillable = [

        'name',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'foto_perfil',
        'color_perfil',
        'password',
        'rol',

    ];


    /**
     * Campos ocultos.
     */
    protected $hidden = [

        'password',
        'remember_token',

    ];


    /**
     * Conversiones de datos.
     */
    protected function casts(): array
    {
        return [

            'email_verified_at' => 'datetime',
            'password' => 'hashed',

        ];
    }
    
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\RestablecerContrasena($token));
    }
}
