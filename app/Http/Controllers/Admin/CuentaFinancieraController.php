<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuentaFinanciera;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CuentaFinancieraController extends Controller
{
    public function index()
    {
        $cuentas = CuentaFinanciera::orderBy('nombre')->get();

        return view('admin.cuentanegocio.cuenta_de_negocio', compact('cuentas'));
    }

    public function create()
    {
        return view('admin.cuentanegocio.agregar');
    }

    public function store(Request $request)
    {
        CuentaFinanciera::create($this->validar($request));

        return redirect()
            ->route('admin.cuentas.index')
            ->with('success', 'La cuenta se registró correctamente.');
    }

    public function edit(CuentaFinanciera $cuenta)
    {
        return view('admin.cuentanegocio.editar', compact('cuenta'));
    }

    public function update(Request $request, CuentaFinanciera $cuenta)
    {
        $cuenta->update($this->validar($request));

        return redirect()
            ->route('admin.cuentas.index')
            ->with('success', 'La cuenta se actualizó correctamente.');
    }

    public function cambiarEstado(CuentaFinanciera $cuenta)
    {
        $cuenta->update(['activa' => !$cuenta->activa]);

        return redirect()
            ->route('admin.cuentas.index')
            ->with('success', $cuenta->activa
                ? 'La cuenta se activó correctamente.'
                : 'La cuenta se desactivó correctamente.');
    }

    public function destroy(CuentaFinanciera $cuenta)
    {
        $cuenta->delete();

        return redirect()
            ->route('admin.cuentas.index')
            ->with('success', 'La cuenta se eliminó correctamente.');
    }

    private function validar(Request $request): array
    {
        $esPasivo = $request->input('tipo') === 'pasivo';

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'tipo' => ['required', Rule::in(array_keys(CuentaFinanciera::TIPOS))],
            'moneda' => ['required', Rule::in(array_keys(CuentaFinanciera::MONEDAS))],
            'numero_cuenta' => ['nullable', 'string', 'max:50'],
            'saldo_inicial' => ['required', 'numeric', 'min:0', 'max:999999999999.99'],
            'fecha_saldo_inicial' => ['required', 'date'],
            'activa' => ['required', 'boolean'],
            'notas' => ['nullable', 'string', 'max:1000'],

            'tipo_pasivo' => [Rule::requiredIf($esPasivo), 'nullable', Rule::in(array_keys(CuentaFinanciera::TIPOS_PASIVO))],
            'direccion_pasivo' => [Rule::requiredIf($esPasivo), 'nullable', Rule::in(array_keys(CuentaFinanciera::DIRECCIONES_PASIVO))],
            'tasa_interes' => [Rule::requiredIf($esPasivo), 'nullable', 'numeric', 'min:0', 'max:9999.99'],
            'periodo_interes' => [Rule::requiredIf($esPasivo), 'nullable', Rule::in(array_keys(CuentaFinanciera::PERIODOS_INTERES))],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
            'tipo.required' => 'Selecciona el tipo de cuenta.',
            'moneda.required' => 'Selecciona la moneda.',
            'numero_cuenta.max' => 'El número de cuenta no puede superar los 50 caracteres.',
            'saldo_inicial.required' => 'El saldo inicial es obligatorio.',
            'saldo_inicial.numeric' => 'El saldo inicial debe ser numérico.',
            'saldo_inicial.min' => 'El saldo inicial no puede ser negativo.',
            'fecha_saldo_inicial.required' => 'La fecha del saldo inicial es obligatoria.',
            'fecha_saldo_inicial.date' => 'La fecha del saldo inicial no es válida.',
            'notas.max' => 'Las notas no pueden superar los 1000 caracteres.',
            'tipo_pasivo.required' => 'Selecciona el tipo de pasivo.',
            'direccion_pasivo.required' => 'Indica si se debe o se lo deben.',
            'tasa_interes.required' => 'La tasa de interés es obligatoria para un pasivo.',
            'tasa_interes.numeric' => 'La tasa de interés debe ser numérica.',
            'periodo_interes.required' => 'Selecciona el periodo de interés.',
        ]);

        if (!$esPasivo) {
            $datos['tipo_pasivo'] = null;
            $datos['direccion_pasivo'] = null;
            $datos['tasa_interes'] = null;
            $datos['periodo_interes'] = null;
        }

        return $datos;
    }
}