<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Controlador del inventario: administra bienes y servicios,
 * sus categorías y sus fotos.
 */
class InventarioController extends Controller
{
    // Devuelve las categorías de tipo "bien" ordenadas por nombre.
    private function categoriasDeBien()
    {
        return Categoria::where('tipo', 'bien')->orderBy('nombre')->get();
    }

    // Devuelve las categorías de tipo "servicio" ordenadas por nombre.
    private function categoriasDeServicio()
    {
        return Categoria::where('tipo', 'servicio')->orderBy('nombre')->get();
    }

    // Mensajes de error personalizados en español para las validaciones.
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

    // Reglas de categoría: se elige una existente o se escribe una nueva (al menos una).
    private function reglasCategoria(string $tipo): array
    {
        return [
            'categoria_id'    => ['nullable', 'required_without:categoria_nueva', Rule::exists('categorias', 'id')->where('tipo', $tipo)],
            'categoria_nueva' => ['nullable', 'required_without:categoria_id', 'string', 'min:2', 'max:255'],
        ];
    }

    // Reglas exclusivas de los servicios (costo, referencia, disponibilidad) más las de categoría.
    private function reglasServicio(): array
    {
        return [
            'costo'                  => ['nullable', 'numeric', 'min:0'],
            'referencia'             => ['nullable', 'string', 'max:100'],
            'disponible_punto_venta' => ['nullable', 'boolean'],
        ] + $this->reglasCategoria('servicio');
    }

    // Obtiene el id de la categoría: crea la nueva (evitando duplicados) o usa la seleccionada.
    private function resolverCategoriaId(Request $request, string $tipo): ?int
    {
        if ($request->filled('categoria_nueva')) {
            // Limpia espacios repetidos del nombre.
            $nombre = trim(preg_replace('/\s+/', ' ', $request->input('categoria_nueva')));

            // Busca una categoría igual sin distinguir mayúsculas/minúsculas.
            $existente = Categoria::where('tipo', $tipo)->get()
                ->first(fn ($c) => mb_strtolower($c->nombre) === mb_strtolower($nombre));

            // Si no existe, la crea.
            return ($existente ?? Categoria::create(['nombre' => $nombre, 'tipo' => $tipo]))->id;
        }

        return $request->filled('categoria_id') ? (int) $request->input('categoria_id') : null;
    }

    // Lista todo el inventario con su categoría.
    public function index()
    {
        $inventarios = Inventario::with('categoria')->orderBy('nombre', 'asc')->get();

        return view('admin.inventario', compact('inventarios'));
    }

    // Muestra el formulario para agregar un bien.
    public function createBien()
    {
        $categorias = $this->categoriasDeBien();

        return view('admin.agregar_bien', compact('categorias'));
    }

    // Valida y guarda un nuevo bien.
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

        // "categoria_nueva" no es columna de la tabla, solo se usa para resolver la categoría.
        unset($datos['categoria_nueva']);

        $datos['categoria_id'] = $this->resolverCategoriaId($request, 'bien');
        $datos['tipo'] = 'bien';

        // Guarda la foto en storage/app/public/inventario.
        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('inventario', 'public');
        }

        Inventario::create($datos);

        return redirect()->route('admin.inventario', ['tipo' => 'bien'])->with('success', 'Bien registrado correctamente.');
    }

    // Muestra el formulario para agregar un servicio.
    public function createServicio()
    {
        $categorias = $this->categoriasDeServicio();

        return view('admin.agregar_servicio', compact('categorias'));
    }

    // Valida y guarda un nuevo servicio.
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
        // Convierte el checkbox a true/false.
        $datos['disponible_punto_venta'] = $request->boolean('disponible_punto_venta');
        $datos['tipo'] = 'servicio';

        if ($request->hasFile('foto')) {
            $datos['foto'] = $request->file('foto')->store('inventario', 'public');
        }

        Inventario::create($datos);

        return redirect()->route('admin.servicios')->with('success', 'Servicio registrado correctamente.');
    }

    // Lista solo los servicios, junto con sus categorías.
    public function servicios()
    {
        $servicios = Inventario::with('categoria')
            ->where('tipo', 'servicio')
            ->orderBy('nombre', 'asc')
            ->get();

        $categorias = $this->categoriasDeServicio();

        return view('admin.servicios', compact('servicios', 'categorias'));
    }

    // Alta genérica de un registro (bien o servicio) sin manejo de categorías.
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

    // Muestra el detalle de un registro.
    public function show($id)
    {
        $inventario = Inventario::findOrFail($id);

        return view('admin.inventario.detalle', compact('inventario'));
    }

    // Muestra el formulario de edición según el tipo (servicio o bien).
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

    // Valida y actualiza un registro; las reglas cambian según sea bien o servicio.
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

        // Registros antiguos sin categoría: no se les obliga a tener una.
        $esAntiguo = $inventario->categoria_id === null;

        if ($inventario->tipo === 'bien') {
            // La fecha solo es obligatoria si el bien ya tenía una registrada.
            $reglas['fecha_adquisicion'] = [$inventario->fecha_adquisicion ? 'required' : 'nullable', 'date', 'before_or_equal:today'];
            $reglas += $this->reglasCategoria('bien');
        } else {
            $reglas += $this->reglasServicio();
        }

        // Para registros antiguos, la categoría pasa a ser opcional.
        if ($esAntiguo) {
            $reglas['categoria_id']    = ['nullable', Rule::exists('categorias', 'id')->where('tipo', $inventario->tipo)];
            $reglas['categoria_nueva'] = ['nullable', 'string', 'min:2', 'max:255'];
        }

        $datos = $request->validate($reglas, $this->mensajes());

        unset($datos['categoria_nueva']);

        $datos['categoria_id'] = $this->resolverCategoriaId($request, $inventario->tipo);

        if ($inventario->tipo === 'servicio') {
            $datos['disponible_punto_venta'] = $request->boolean('disponible_punto_venta');
        }

        // El tipo no se puede cambiar al editar.
        $datos['tipo'] = $inventario->tipo;

        // Si se sube una foto nueva, borra la anterior y guarda la nueva.
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

    // Elimina un registro y su foto del almacenamiento.
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