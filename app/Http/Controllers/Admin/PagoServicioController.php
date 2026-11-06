<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuentaFinanciera;
use App\Models\PagoServicio;
use App\Services\RegistrarReciboPagoServicio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PagoServicioController extends Controller
{
    public function index()
    {
        $servicios = PagoServicio::with('cuenta')->orderBy('fecha_pago', 'asc')->get();

        return view(
            'admin.pago_servicios.pago_de_servicios',
            [
                'servicios' => $servicios,
                'periodicidades' => RegistrarReciboPagoServicio::PERIODICIDADES,
            ]
        );
    }

    public function create()
    {
        return view('admin.pago_servicios.create', $this->datosFormulario());
    }

    public function store(Request $request)
    {
        PagoServicio::create($this->validar($request) + ['estado' => 'Pendiente']);

        return redirect()
            ->route('admin.pago_servicios.index')
            ->with('success', 'Servicio agregado correctamente.');
    }

    public function edit(PagoServicio $pagoServicio)
    {
        if ($pagoServicio->estado === 'Pagado') {
            return redirect()
                ->route('admin.pago_servicios.index')
                ->withErrors(['estado' => 'Un servicio ya pagado no se puede editar; edita el siguiente pago pendiente.']);
        }

        return view('admin.pago_servicios.edit', $this->datosFormulario() + compact('pagoServicio'));
    }

    public function update(Request $request, PagoServicio $pagoServicio)
    {
        if ($pagoServicio->estado === 'Pagado') {
            return redirect()
                ->route('admin.pago_servicios.index')
                ->withErrors(['estado' => 'Un servicio ya pagado no se puede editar.']);
        }

        $pagoServicio->update($this->validar($request));

        return redirect()
            ->route('admin.pago_servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(PagoServicio $pagoServicio)
    {
        $pagoServicio->delete();

        return redirect()
            ->route('admin.pago_servicios.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }

    private function datosFormulario(): array
    {
        return [
            'cuentas' => CuentaFinanciera::paraMovimientos()->get(),
            'periodicidades' => RegistrarReciboPagoServicio::PERIODICIDADES,
            'tiposMovimiento' => PagoServicio::TIPOS_MOVIMIENTO,
        ];
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'tipo_movimiento' => ['required', Rule::in(array_keys(PagoServicio::TIPOS_MOVIMIENTO))],
            'servicio' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'cuenta_financiera_id' => [
                'required',
                Rule::exists('cuentas_financieras', 'id')->where(fn ($q) => $q->where('tipo', 'activo')->where('activa', true)),
            ],
            'periodicidad' => ['required', Rule::in(array_keys(RegistrarReciboPagoServicio::PERIODICIDADES))],
            'fecha_pago' => ['required', 'date'],
            'fecha_vencimiento' => ['nullable', 'date', 'after_or_equal:fecha_pago'],
            'monto' => ['required', 'numeric', 'gt:0', 'max:99999999.99'],
            'observaciones' => ['nullable', 'string', 'max:1000'],
        ], [
            'tipo_movimiento.required' => 'Indica si es un pago o un ingreso.',
            'servicio.required' => 'El nombre del servicio es obligatorio.',
            'cuenta_financiera_id.required' => 'Selecciona la cuenta del negocio.',
            'cuenta_financiera_id.exists' => 'La cuenta seleccionada no está disponible (debe ser un activo y estar activa).',
            'periodicidad.required' => 'Selecciona la periodicidad.',
            'fecha_pago.required' => 'La fecha del próximo pago es obligatoria.',
            'fecha_vencimiento.after_or_equal' => 'El vencimiento no puede ser anterior a la fecha de pago.',
            'monto.required' => 'El monto esperado es obligatorio.',
            'monto.gt' => 'El monto debe ser mayor a cero.',
        ]);
    }
}