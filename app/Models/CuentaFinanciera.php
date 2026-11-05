<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function getSaldoActualAttribute(): string
    {
        return $this->saldo_inicial;
    }
}