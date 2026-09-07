<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    /**
     * Mostrar la lista de empleados.
     */
    public function index()
    {
        $empleados = User::whereIn('rol', [
            'admin',
            'vendedor'
        ])->get();

        return view(
            'admin.empleados.index',
            compact('empleados')
        );
    }


    /**
     * Mostrar el formulario para agregar un empleado.
     */
    public function create()
    {
        return view('admin.empleados.agregar');
    }


    /**
     * Guardar un nuevo empleado.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'rol' => 'required|in:admin,vendedor',
            'password' => 'required|string|min:8|confirmed',
        ]);


        User::create([
            'name' => $datos['name'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            'rol' => $datos['rol'],
            'foto_perfil' => null,
            'color_perfil' => '#6a1b9a',
            'password' => Hash::make($datos['password']),
        ]);


        return redirect()
            ->route('admin.empleados')
            ->with('success', 'Empleado registrado correctamente.');
    }

        public function destroy($id)
{
    $empleado = User::findOrFail($id);

    $empleado->delete();

    return redirect()
        ->route('admin.empleados')
        ->with('success', 'Empleado eliminado correctamente.');
}

/**
 * Mostrar formulario para editar empleado.
 */
public function edit($id)
{
    $empleado = User::whereIn('rol', [
        'admin',
        'vendedor'
    ])->findOrFail($id);

    return view(
        'admin.empleados.editar',
        compact('empleado')
    );
}


/**
 * Actualizar información del empleado.
 */
public function update(Request $request, $id)
{
    $empleado = User::whereIn('rol', [
        'admin',
        'vendedor'
    ])->findOrFail($id);

    $datos = $request->validate([
        'name' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $empleado->id,
        'telefono' => 'nullable|string|max:20',
        'rol' => 'required|in:admin,vendedor',
    ]);

    $empleado->update([
        'name' => $datos['name'],
        'apellido' => $datos['apellido'],
        'email' => $datos['email'],
        'telefono' => $datos['telefono'] ?? null,
        'rol' => $datos['rol'],
    ]);

    return redirect()
        ->route('admin.empleados')
        ->with('success', 'Empleado actualizado correctamente.');
}

}
