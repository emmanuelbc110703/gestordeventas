<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PagoServicio;
use Illuminate\Http\Request;

class PagoServicioController extends Controller
{
    public function index()
    {
        $servicios = PagoServicio::orderBy('fecha_pago', 'asc')->get();

        return view(
            'admin.pago_servicios.pago_de_servicios',
            compact('servicios')
        );
    }

    public function create()
    {
        return view('admin.pago_servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'servicio' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'fecha_pago' => 'required|date',
            'monto' => 'nullable|numeric|min:0',
            'estado' => 'required|in:Pendiente,Pagado',
            'fecha_vencimiento' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        PagoServicio::create([
            'servicio' => $request->servicio,
            'descripcion' => $request->descripcion,
            'fecha_pago' => $request->fecha_pago,
            'monto' => $request->monto,
            'estado' => $request->estado,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('admin.pago_servicios.index')
            ->with('success', 'Servicio agregado correctamente.');
    }

    public function edit(PagoServicio $pagoServicio)
    {
        return view(
            'admin.pago_servicios.edit',
            compact('pagoServicio')
        );
    }

    public function update(
        Request $request,
        PagoServicio $pagoServicio
    ) {
        $request->validate([
            'servicio' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'fecha_pago' => 'required|date',
            'monto' => 'nullable|numeric|min:0',
            'estado' => 'required|in:Pendiente,Pagado',
            'fecha_vencimiento' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);

        $pagoServicio->update([
            'servicio' => $request->servicio,
            'descripcion' => $request->descripcion,
            'fecha_pago' => $request->fecha_pago,
            'monto' => $request->monto,
            'estado' => $request->estado,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'observaciones' => $request->observaciones,
        ]);

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
}
