<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PagoServicio;
use App\Models\ReciboPagoServicio;
use App\Services\RegistrarReciboPagoServicio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistroPagoServicioController extends Controller
{
    public function create(Request $request)
    {
        $pendientes = PagoServicio::where('estado', 'Pendiente')
            ->orderBy('fecha_pago')
            ->get();

        $seleccionado = $request->filled('servicio')
            ? $pendientes->firstWhere('id', (int) $request->input('servicio'))
            : null;

        return view('admin.pago_servicios.registrar_pago', [
            'pendientes' => $pendientes,
            'seleccionado' => $seleccionado,
            'periodicidades' => RegistrarReciboPagoServicio::PERIODICIDADES,
        ]);
    }

    public function store(Request $request, RegistrarReciboPagoServicio $registrar)
    {
        $pago = PagoServicio::findOrFail((int) $request->input('pago_servicio_id'));

        $datos = $request->validate([
            'pago_servicio_id' => ['required', 'integer'],
            'monto_pagado' => ['required', 'numeric', 'gt:0', 'max:99999999.99'],
            'fecha_pago' => ['required', 'date', 'before_or_equal:today'],
            'fecha_recibo' => ['required', 'date', 'before_or_equal:fecha_pago'],
            'folio_recibo' => ['nullable', 'string', 'max:100'],
            'informacion_recibo' => ['nullable', 'string', 'max:1000'],
            'periodicidad' => [
                Rule::requiredIf(blank($pago->periodicidad)),
                'nullable',
                Rule::in(array_keys(RegistrarReciboPagoServicio::PERIODICIDADES)),
            ],
        ], [
            'monto_pagado.required' => 'Captura el monto que aparece en el recibo.',
            'monto_pagado.gt' => 'El monto debe ser mayor a cero.',
            'fecha_pago.before_or_equal' => 'La fecha de pago no puede ser futura.',
            'fecha_recibo.before_or_equal' => 'La fecha del recibo no puede ser posterior a la fecha de pago.',
            'periodicidad.required' => 'Indica la periodicidad del servicio.',
        ]);

        $recibo = $registrar->ejecutar($pago->id, $datos, $request->user()?->id);

        $mensaje = "Pago de {$recibo->servicio} registrado.";
        if ($recibo->fecha_siguiente_pago) {
            $mensaje .= ' Siguiente pago: '.$recibo->fecha_siguiente_pago->format('d/m/Y').'.';
        }

        return redirect()->route('admin.pago_servicios.historial')->with('success', $mensaje);
    }

    public function historial(Request $request)
    {
        $request->validate([
            'desde' => ['nullable', 'date'],
            'hasta' => ['nullable', 'date'],
        ]);

        $consulta = ReciboPagoServicio::query()
            ->when($request->filled('servicio'), fn ($q) => $q->where('servicio', 'like', '%'.$request->input('servicio').'%'))
            ->when($request->filled('desde'), fn ($q) => $q->whereDate('fecha_pago', '>=', $request->input('desde')))
            ->when($request->filled('hasta'), fn ($q) => $q->whereDate('fecha_pago', '<=', $request->input('hasta')));

        $total = (clone $consulta)->sum('monto_pagado');

        $recibos = $consulta
            ->orderByDesc('fecha_pago')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pago_servicios.historial_pagos', compact('recibos', 'total'));
    }
}