<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Categoria;
use Illuminate\Validation\Rule;

class InventarioController extends Controller
{
    private function categoriasDeBien()
    {
        return Categoria::where('tipo', 'bien')->orderBy('nombre')->get();
    }

    private function mensajesBien(): array
    {
        return [
            'categoria_id.required'             => 'Selecciona una categoría.',
            'categoria_id.exists'               => 'La categoría seleccionada no es válida.',
            'fecha_adquisicion.required'        => 'La fecha de adquisición es obligatoria.',
            'fecha_adquisicion.date'            => 'La fecha de adquisición no es válida.',
            'fecha_adquisicion.before_or_equal' => 'La fecha de adquisición no puede ser futura.',
        ];
    }

    public function index()
    {
        $inventarios = Inventario::with('categoria')->orderBy('nombre', 'asc')->get();

        return view('admin.inventario', compact('inventarios'));
    }


    public function createBien()
    {
        $categorias = $this->categoriasDeBien();

        return view('admin.agregar_bien', compact('categorias'));
    }


    /**
     * Mostrar formulario para agregar un servicio.
     */
    public function createServicio()
    {
        return view('admin.agregar_servicio');
    }


    public function storeBien(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'categoria_id' => ['required', Rule::exists('categorias', 'id')->where('tipo', 'bien')],
            'fecha_adquisicion' => ['required', 'date', 'before_or_equal:today'],
        ], $this->mensajesBien());

        $datos['tipo'] = 'bien';

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('inventario', 'public');
        }

        Inventario::create($datos);

        return redirect()->route('admin.inventario', ['tipo' => 'bien'])->with('success', 'Bien registrado correctamente.');
    }


    /**
     * Guardar un nuevo servicio.
     */
    public function storeServicio(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
        ]);

        $datos['tipo'] = 'servicio';

        if ($request->hasFile('foto')) {

            $datos['foto'] = $request
                ->file('foto')
                ->store('inventario', 'public');
        }

        Inventario::create($datos);

        return redirect()->route('admin.servicios');
    }


    /**
     * Mostrar todos los servicios.
     */
    public function servicios()
    {
        $servicios = Inventario::where('tipo', 'servicio')
            ->orderBy('nombre', 'asc')
            ->get();

        return view('admin.servicios', compact('servicios'));
    }


    /**
     * Guardar un registro general de inventario.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'tipo' => 'required|in:bien,servicio',
            'cantidad' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('foto')) {

            $datos['foto'] = $request
                ->file('foto')
                ->store('inventario', 'public');
        }

        Inventario::create($datos);

        return redirect()->route('admin.inventario');
    }


    /**
     * Mostrar un registro específico.
     */
    public function show($id)
    {
        $inventario = Inventario::findOrFail($id);

        return view(
            'admin.inventario.detalle',
            compact('inventario')
        );
    }


    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);

        if ($inventario->tipo === 'servicio') {
            return view('admin.inventario.editar_servicio', compact('inventario'));
        }

        $categorias = $this->categoriasDeBien();

        return view('admin.inventario.editar', compact('inventario', 'categorias'));
    }


    public function update(Request $request, $id)
    {
        $inventario = Inventario::findOrFail($id);

        $reglas = [
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
        ];

        if ($inventario->tipo === 'bien') {
            $reglas['categoria_id'] = ['required', Rule::exists('categorias', 'id')->where('tipo', 'bien')];
            $reglas['fecha_adquisicion'] = ['required', 'date', 'before_or_equal:today'];
        }

        $datos = $request->validate($reglas, $this->mensajesBien());

        $datos['tipo'] = $inventario->tipo;

        if ($request->hasFile('foto')) {
            if ($inventario->foto) {
                Storage::disk('public')->delete($inventario->foto);
            }

            $datos['foto'] = $request->file('foto')->store('inventario', 'public');
        }

        $inventario->update($datos);

        if ($inventario->tipo === 'servicio') {
            return redirect()->route('admin.servicios');
        }

        return redirect()->route('admin.inventario', ['tipo' => 'bien'])->with('success', 'Bien actualizado correctamente.');
    }


    /**
     * Eliminar un bien o servicio.
     */
    public function destroy($id)
    {
        $inventario = Inventario::findOrFail($id);

        // Guardar el tipo antes de eliminar.
        $tipo = $inventario->tipo;

        // Eliminar fotografía.
        if ($inventario->foto) {

            Storage::disk('public')->delete(
                $inventario->foto
            );
        }

        // Eliminar registro.
        $inventario->delete();

        // Regresar a la lista correspondiente.
        if ($tipo === 'servicio') {

            return redirect()->route('admin.servicios');
        }

        return redirect()->route('admin.inventario', ['tipo' => 'bien'])->with('success', 'Bien eliminado correctamente.');
    }
}