<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InventarioController extends Controller
{
    private function categoriasDeBien()
    {
        return Categoria::where('tipo', 'bien')->orderBy('nombre')->get();
    }

    private function categoriasDeServicio()
    {
        return Categoria::where('tipo', 'servicio')->orderBy('nombre')->get();
    }

    private function mensajes(): array
    {
        return [
            'categoria_id.required_without'     => 'Selecciona una categoría o crea una nueva.',
            'categoria_id.exists'               => 'La categoría seleccionada no es válida.',
            'categoria_nueva.required_without'  => 'Selecciona una categoría o crea una nueva.',
            'categoria_nueva.min'               => 'El nombre de la categoría debe tener al menos 2 caracteres.',
            'categoria_nueva.max'               => 'El nombre de la categoría no puede superar los 255 caracteres.',
            'fecha_adquisicion.required'        => 'La fecha de adquisición es obligatoria.',
            'fecha_adquisicion.date'            => 'La fecha de adquisición no es válida.',
            'fecha_adquisicion.before_or_equal' => 'La fecha de adquisición no puede ser futura.',
            'costo.numeric'                     => 'El costo debe ser un número.',
            'costo.min'                         => 'El costo no puede ser negativo.',
            'referencia.max'                    => 'La referencia no puede superar los 100 caracteres.',
        ];
    }

    private function reglasCategoria(string $tipo): array
    {
        return [
            'categoria_id'    => ['nullable', 'required_without:categoria_nueva', Rule::exists('categorias', 'id')->where('tipo', $tipo)],
            'categoria_nueva' => ['nullable', 'required_without:categoria_id', 'string', 'min:2', 'max:255'],
        ];
    }

    private function reglasServicio(): array
    {
        return [
            'costo'                  => ['nullable', 'numeric', 'min:0'],
            'referencia'             => ['nullable', 'string', 'max:100'],
            'disponible_punto_venta' => ['nullable', 'boolean'],
        ] + $this->reglasCategoria('servicio');
    }

    private function resolverCategoriaId(Request $request, string $tipo): int
    {
        if ($request->filled('categoria_nueva')) {
            $nombre = trim(preg_replace('/\s+/', ' ', $request->input('categoria_nueva')));

            $existente = Categoria::where('tipo', $tipo)->get()
                ->first(fn ($c) => mb_strtolower($c->nombre) === mb_strtolower($nombre));

            return ($existente ?? Categoria::create(['nombre' => $nombre, 'tipo' => $tipo]))->id;
        }

        return (int) $request->input('categoria_id');
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

    public function storeBien(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'fecha_adquisicion' => ['required', 'date', 'before_or_equal:today'],
        ] + $this->reglasCategoria('bien'), $this->mensajes());

        unset($datos['categoria_nueva']);

        $datos['categoria_id'] = $this->resolverCategoriaId($request, 'bien');
        $datos['tipo'] = 'bien';

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('inventario', 'public');
        }

        Inventario::create($datos);

        return redirect()->route('admin.inventario', ['tipo' => 'bien'])->with('success', 'Bien registrado correctamente.');
    }

    public function createServicio()
    {
        $categorias = $this->categoriasDeServicio();

        return view('admin.agregar_servicio', compact('categorias'));
    }

    public function storeServicio(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
        ] + $this->reglasServicio(), $this->mensajes());

        unset($datos['categoria_nueva']);

        $datos['categoria_id'] = $this->resolverCategoriaId($request, 'servicio');
        $datos['disponible_punto_venta'] = $request->boolean('disponible_punto_venta');
        $datos['tipo'] = 'servicio';

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('inventario', 'public');
        }

        Inventario::create($datos);

        return redirect()->route('admin.servicios')->with('success', 'Servicio registrado correctamente.');
    }

    public function servicios()
    {
        $servicios = Inventario::with('categoria')
            ->where('tipo', 'servicio')
            ->orderBy('nombre', 'asc')
            ->get();

        $categorias = $this->categoriasDeServicio();

        return view('admin.servicios', compact('servicios', 'categorias'));
    }

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
            $datos['foto'] = $request->file('foto')->store('inventario', 'public');
        }

        Inventario::create($datos);

        return redirect()->route('admin.inventario');
    }

    public function show($id)
    {
        $inventario = Inventario::findOrFail($id);

        return view('admin.inventario.detalle', compact('inventario'));
    }

    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);

        if ($inventario->tipo === 'servicio') {
            $categorias = $this->categoriasDeServicio();

            return view('admin.inventario.editar_servicio', compact('inventario', 'categorias'));
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
            $reglas['fecha_adquisicion'] = ['required', 'date', 'before_or_equal:today'];
            $reglas += $this->reglasCategoria('bien');
        } else {
            $reglas += $this->reglasServicio();
        }

        $datos = $request->validate($reglas, $this->mensajes());

        unset($datos['categoria_nueva']);

        $datos['categoria_id'] = $this->resolverCategoriaId($request, $inventario->tipo);

        if ($inventario->tipo === 'servicio') {
            $datos['disponible_punto_venta'] = $request->boolean('disponible_punto_venta');
        }

        $datos['tipo'] = $inventario->tipo;

        if ($request->hasFile('foto')) {
            if ($inventario->foto) {
                Storage::disk('public')->delete($inventario->foto);
            }

            $datos['foto'] = $request->file('foto')->store('inventario', 'public');
        }

        $inventario->update($datos);

        if ($inventario->tipo === 'servicio') {
            return redirect()->route('admin.servicios')->with('success', 'Servicio actualizado correctamente.');
        }

        return redirect()->route('admin.inventario', ['tipo' => 'bien'])->with('success', 'Bien actualizado correctamente.');
    }

    public function destroy($id)
    {
        $inventario = Inventario::findOrFail($id);

        $tipo = $inventario->tipo;

        if ($inventario->foto) {
            Storage::disk('public')->delete($inventario->foto);
        }

        $inventario->delete();

        if ($tipo === 'servicio') {
            return redirect()->route('admin.servicios')->with('success', 'Servicio eliminado correctamente.');
        }

        return redirect()->route('admin.inventario', ['tipo' => 'bien'])->with('success', 'Bien eliminado correctamente.');
    }
}