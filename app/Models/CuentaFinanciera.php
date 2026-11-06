<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CuentaFinanciera extends Model
{
    protected $table = 'cuentas_financieras';

    public const TIPOS = [
        'activo' => 'Activo',
        'pasivo' => 'Pasivo',
    ];

    public const MONEDAS = [
        'MXN' => 'Peso mexicano (MXN)',
        'USD' => 'Dólar estadounidense (USD)',
        'EUR' => 'Euro (EUR)',
    ];

    public const TIPOS_PASIVO = [
        'prestamo' => 'Préstamo',
        'deuda'    => 'Deuda',
        'hipoteca' => 'Hipoteca',
        'otro'     => 'Otro',
    ];

    public const DIRECCIONES_PASIVO = [
        'debo'     => 'Yo debo',
        'me_deben' => 'Me deben',
    ];

    public const PERIODOS_INTERES = [
        'diario'     => 'Diario',
        'semanal'    => 'Semanal',
        'quincenal'  => 'Quincenal',
        'mensual'    => 'Mensual',
        'bimestral'  => 'Bimestral',
        'trimestral' => 'Trimestral',
        'semestral'  => 'Semestral',
        'anual'      => 'Anual',
    ];

    protected $fillable = [
        'nombre',
        'tipo',
        'moneda',
        'numero_cuenta',
        'saldo_inicial',
        'fecha_saldo_inicial',
        'activa',
        'notas',
        'tipo_pasivo',
        'direccion_pasivo',
        'tasa_interes',
        'periodo_interes',
    ];

    protected $casts = [
        'saldo_inicial' => 'decimal:2',
        'fecha_saldo_inicial' => 'date',
        'activa' => 'boolean',
        'tasa_interes' => 'decimal:2',
    ];

    public function esPasivo(): bool
    {
        return $this->tipo === 'pasivo';
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoCuenta::class, 'cuenta_financiera_id');
    }

    public function scopeParaMovimientos(Builder $query): Builder
    {
        return $query->where('tipo', 'activo')->where('activa', true)->orderBy('nombre');
    }

    public function getSaldoActualAttribute(): string
    {
        $ingresos = array_key_exists('ingresos_total', $this->attributes)
            ? (float) $this->attributes['ingresos_total']
            : (float) $this->movimientos()->where('tipo', 'ingreso')->sum('monto');

        $egresos = array_key_exists('egresos_total', $this->attributes)
            ? (float) $this->attributes['egresos_total']
            : (float) $this->movimientos()->where('tipo', 'egreso')->sum('monto');

        return number_format((float) $this->saldo_inicial + $ingresos - $egresos, 2, '.', '');
    }

    public function scopeConSaldos(Builder $query): Builder
    {
        return $query->withSum(['movimientos as ingresos_total' => fn ($q) => $q->where('tipo', 'ingreso')], 'monto')
            ->withSum(['movimientos as egresos_total' => fn ($q) => $q->where('tipo', 'egreso')], 'monto');
    }
}