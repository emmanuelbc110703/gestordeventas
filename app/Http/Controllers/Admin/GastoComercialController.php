<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\GastoComercial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GastoComercialController extends Controller
{
    private function categorias()
    {
        return Categoria::deTipo('gasto')->orderBy('nombre')->get();
    }

    private function reglas(): array
    {
        return [
            'fecha'        => ['required', 'date'],
            'concepto'     => ['required', 'string', 'max:255'],
            'descripcion'  => ['nullable', 'string', 'max:1000'],
            'categoria_id' => ['required', Rule::exists('categorias', 'id')->where('tipo', 'gasto')],
            'monto'        => ['required', 'numeric', 'min:0.01'],
        ];
    }

    private function mensajes(): array
    {
        return [
            'fecha.required'        => 'La fecha es obligatoria.',
            'fecha.date'            => 'La fecha no es válida.',
            'concepto.required'     => 'El concepto es obligatorio.',
            'concepto.max'          => 'El concepto no puede superar los 255 caracteres.',
            'descripcion.max'       => 'La descripción no puede superar los 1000 caracteres.',
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists'   => 'La categoría seleccionada no es válida.',
            'monto.required'        => 'El monto es obligatorio.',
            'monto.numeric'         => 'El monto debe ser numérico.',
            'monto.min'             => 'El monto debe ser mayor a $0.00.',
        ];
    }

    /**
     * Mostrar los gastos comerciales.
     */
    public function index(Request $request)
    {
        $filtro = $request->get('filtro', 'todos');

        $query = GastoComercial::with('categoria');

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

        $categorias = $this->categorias();

        return view('admin.gastos_comerciales.index', compact('gastos', 'filtro', 'categorias'));
    }

    /**
     * Mostrar formulario para registrar un gasto.
     */
    public function create()
    {
        $categorias = $this->categorias();

        return view('admin.gastos_comerciales.create', compact('categorias'));
    }

    /**
     * Guardar un nuevo gasto comercial.
     */
    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas(), $this->mensajes());

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
        $categorias = $this->categorias();

        return view('admin.gastos_comerciales.edit', compact('gasto', 'categorias'));
    }

    /**
     * Actualizar un gasto comercial.
     */
    public function update(Request $request, $id)
    {
        $gasto = GastoComercial::findOrFail($id);

        $datos = $request->validate($this->reglas(), $this->mensajes());

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