<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    private function reglas(?string $tipo, ?int $ignorarId = null): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('categorias', 'nombre')->where('tipo', $tipo)->ignore($ignorarId),
            ],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'tipo'        => ['required', Rule::in(array_keys(Categoria::TIPOS))],
        ];
    }

    private function mensajes(): array
    {
        return [
            'nombre.required'   => 'El nombre de la categoría es obligatorio.',
            'nombre.min'        => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.max'        => 'El nombre no puede superar los 255 caracteres.',
            'nombre.unique'     => 'Ya existe una categoría con ese nombre en este tipo.',
            'descripcion.max'   => 'La descripción no puede superar los 1000 caracteres.',
            'tipo.required'     => 'Selecciona el tipo de categoría.',
            'tipo.in'           => 'El tipo de categoría no es válido.',
        ];
    }

    private function normalizarNombre(Request $request): void
    {
        $nombre = preg_replace('/\s+/u', ' ', trim((string) $request->input('nombre'))) ?? '';

        $request->merge(['nombre' => $nombre]);
    }

    public function index(Request $request)
    {
        $tipo = $request->query('tipo');
        $tipo = Categoria::tipoValido($tipo) ? $tipo : null;

        $categorias = Categoria::query()
            ->withCount(array_keys(Categoria::MODULOS))
            ->when($tipo, fn ($q) => $q->where('tipo', $tipo))
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->get();

        return view('admin.categorias.index', compact('categorias', 'tipo'));
    }

    public function create(Request $request)
    {
        $tipoInicial = $request->query('tipo');
        $tipoInicial = Categoria::tipoValido($tipoInicial) ? $tipoInicial : '';

        return view('admin.categorias.create', compact('tipoInicial'));
    }

    public function store(Request $request)
    {
        $this->normalizarNombre($request);

        $datos = $request->validate(
            $this->reglas($request->input('tipo')),
            $this->mensajes()
        );

        Categoria::create($datos);

        return redirect()
            ->route('admin.categorias.index', ['tipo' => $datos['tipo']])
            ->with('success', 'La categoría se registró correctamente.');
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);

        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->estaEnUso()) {
            $request->merge(['tipo' => $categoria->tipo]);
        }

        $this->normalizarNombre($request);

        $datos = $request->validate(
            $this->reglas($request->input('tipo'), $categoria->id),
            $this->mensajes()
        );

        $categoria->update($datos);

        return redirect()
            ->route('admin.categorias.index', ['tipo' => $categoria->tipo])
            ->with('success', 'La categoría se actualizó correctamente.');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        $redirigir = redirect()->route('admin.categorias.index', ['tipo' => $categoria->tipo]);

        if ($categoria->estaEnUso()) {
            return $redirigir->with(
                'error',
                'No se puede eliminar «' . $categoria->nombre . '» porque está en uso en '
                . $categoria->descripcionDeUsos()
                . '. Reasígnalos a otra categoría y vuelve a intentarlo.'
            );
        }

        try {
            $categoria->delete();
        } catch (QueryException $e) {
            return $redirigir->with(
                'error',
                'No se puede eliminar «' . $categoria->nombre . '» porque otros registros la utilizan.'
            );
        }

        return $redirigir->with('success', 'La categoría se eliminó correctamente.');
    }
}