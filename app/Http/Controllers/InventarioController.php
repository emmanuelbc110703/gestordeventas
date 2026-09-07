<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventarioController extends Controller
{
    /**
     * Mostrar todo el inventario.
     */
    public function index()
    {
        $inventarios = Inventario::orderBy('nombre', 'asc')->get();

        return view('admin.inventario', compact('inventarios'));
    }


    /**
     * Mostrar formulario para agregar un bien.
     */
    public function createBien()
    {
        return view('admin.agregar_bien');
    }


    /**
     * Mostrar formulario para agregar un servicio.
     */
    public function createServicio()
    {
        return view('admin.agregar_servicio');
    }


    /**
     * Guardar un nuevo bien.
     */
    public function storeBien(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
        ]);

        $datos['tipo'] = 'bien';

        if ($request->hasFile('foto')) {

            $datos['foto'] = $request
                ->file('foto')
                ->store('inventario', 'public');
        }

        Inventario::create($datos);

        return redirect()->route('admin.bienes');
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


    /**
     * Mostrar formulario para editar un bien o servicio.
     *
     * Cada uno utiliza su propio Blade.
     */
    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);

        // Si es servicio, abrir editar_servicio.blade.php
        if ($inventario->tipo === 'servicio') {

            return view(
                'admin.inventario.editar_servicio',
                compact('inventario')
            );
        }

        // Si es bien, abrir editar.blade.php
        return view(
            'admin.inventario.editar',
            compact('inventario')
        );
    }


    /**
     * Actualizar un bien o servicio.
     */
    public function update(Request $request, $id)
    {
        $inventario = Inventario::findOrFail($id);

        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
        ]);

        // Mantener el tipo original.
        $datos['tipo'] = $inventario->tipo;

        // Cambiar fotografía solamente si se seleccionó otra.
        if ($request->hasFile('foto')) {

            // Eliminar fotografía anterior.
            if ($inventario->foto) {

                Storage::disk('public')->delete(
                    $inventario->foto
                );
            }

            // Guardar nueva fotografía.
            $datos['foto'] = $request
                ->file('foto')
                ->store('inventario', 'public');
        }

        // Actualizar registro.
        $inventario->update($datos);

        // Regresar a la lista correspondiente.
        if ($inventario->tipo === 'servicio') {

            return redirect()->route('admin.servicios');
        }

        return redirect()->route('admin.bienes');
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

        return redirect()->route('admin.bienes');
    }


    /**
     * Mostrar todos los bienes.
     */
    public function bienes()
    {
        $bienes = Inventario::where('tipo', 'bien')
            ->orderBy('nombre', 'asc')
            ->get();

        return view('admin.bienes', compact('bienes'));
    }
}