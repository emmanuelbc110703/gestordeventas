<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GastoComercial;
use Illuminate\Http\Request;

class GastoComercialController extends Controller
{
    /**
     * Mostrar los gastos comerciales.
     */
    public function index(Request $request)
    {
        $filtro = $request->get('filtro', 'todos');

        $query = GastoComercial::query();

        if ($filtro === 'semana') {
            $query->whereBetween('fecha', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]);
        }

        if ($filtro === 'mes') {
            $query->whereBetween('fecha', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ]);
        }

        $gastos = $query
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.gastos_comerciales.index', compact('gastos', 'filtro'));
    }

    /**
     * Mostrar formulario para registrar un gasto.
     */
    public function create()
    {
        return view('admin.gastos_comerciales.create');
    }

    /**
     * Guardar un nuevo gasto comercial.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'fecha' => ['required', 'date'],
            'concepto' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'categoria' => ['required', 'string', 'max:100'],
            'monto' => ['required', 'numeric', 'min:0.01'],
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'concepto.required' => 'El concepto es obligatorio.',
            'concepto.max' => 'El concepto no puede superar los 255 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 1000 caracteres.',
            'categoria.required' => 'Debes seleccionar una categoría.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser numérico.',
            'monto.min' => 'El monto debe ser mayor a $0.00.',
        ]);

        $datos['user_id'] = auth()->id();

        GastoComercial::create($datos);

        return redirect()
            ->route('admin.gastos_comerciales')
            ->with('success', 'El gasto comercial se registró correctamente.');
    }

    /**
     * Mostrar formulario para editar un gasto.
     */
    public function edit($id)
    {
        $gasto = GastoComercial::findOrFail($id);

        return view('admin.gastos_comerciales.edit', compact('gasto'));
    }

    /**
     * Actualizar un gasto comercial.
     */
    public function update(Request $request, $id)
    {
        $gasto = GastoComercial::findOrFail($id);

        $datos = $request->validate([
            'fecha' => ['required', 'date'],
            'concepto' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'categoria' => ['required', 'string', 'max:100'],
            'monto' => ['required', 'numeric', 'min:0.01'],
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
            'concepto.required' => 'El concepto es obligatorio.',
            'concepto.max' => 'El concepto no puede superar los 255 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 1000 caracteres.',
            'categoria.required' => 'Debes seleccionar una categoría.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser numérico.',
            'monto.min' => 'El monto debe ser mayor a $0.00.',
        ]);

        $gasto->update($datos);

        return redirect()
            ->route('admin.gastos_comerciales')
            ->with('success', 'El gasto comercial se actualizó correctamente.');
    }

    /**
     * Eliminar un gasto comercial.
     */
    public function destroy($id)
    {
        $gasto = GastoComercial::findOrFail($id);

        $gasto->delete();

        return redirect()
            ->route('admin.gastos_comerciales')
            ->with('success', 'El gasto comercial se eliminó correctamente.');
    }
}