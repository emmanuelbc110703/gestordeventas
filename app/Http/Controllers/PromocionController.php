<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    public function index()
    {
        $promociones = Promocion::withCount('inventarios')->orderByDesc('fecha_inicio')->get();

        return view('admin.promociones.index', compact('promociones'));
    }

    public function create()
    {
        $inventarios = Inventario::orderBy('nombre')->get();

        return view('admin.promociones.crear', compact('inventarios'));
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);

        $promocion = Promocion::create($datos);
        $promocion->inventarios()->sync($request->input('inventarios', []));

        return redirect()->route('admin.promociones')
            ->with('success', 'Promoción registrada correctamente.');
    }

    public function edit($id)
    {
        $promocion = Promocion::with('inventarios')->findOrFail($id);
        $inventarios = Inventario::orderBy('nombre')->get();

        return view('admin.promociones.editar', compact('promocion', 'inventarios'));
    }

    public function update(Request $request, $id)
    {
        $promocion = Promocion::findOrFail($id);
        $datos = $this->validar($request);

        $promocion->update($datos);
        $promocion->inventarios()->sync($request->input('inventarios', []));

        return redirect()->route('admin.promociones')
            ->with('success', 'Promoción actualizada correctamente.');
    }

    public function destroy($id)
    {
        Promocion::findOrFail($id)->delete();

        return redirect()->route('admin.promociones')
            ->with('success', 'Promoción eliminada correctamente.');
    }

    private function validar(Request $request): array
    {
        $reglasValor = $request->input('tipo_descuento') === 'porcentaje'
            ? ['required', 'numeric', 'min:0.01', 'max:100']
            : ['required', 'numeric', 'min:0.01'];

        $datos = $request->validate([
            'nombre'         => ['required', 'string', 'max:120'],
            'descripcion'    => ['nullable', 'string', 'max:1000'],
            'tipo_descuento' => ['required', 'in:porcentaje,monto_fijo'],
            'valor'          => $reglasValor,
            'fecha_inicio'   => ['required', 'date'],
            'fecha_fin'      => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'inventarios'    => ['nullable', 'array'],
            'inventarios.*'  => ['integer', 'exists:inventarios,id'],
        ], [
            'valor.max'                => 'El porcentaje no puede ser mayor a 100.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la de inicio.',
        ]);

        $datos['activa'] = $request->boolean('activa');
        unset($datos['inventarios']);

        return $datos;
    }
}