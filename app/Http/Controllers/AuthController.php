<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // ========================================
    // REGISTRO
    // ========================================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $usuario = User::create([
            'name' => $datos['name'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            'foto_perfil' => null,
            'rol' => 'cliente',
            'password' => Hash::make($datos['password']),
        ]);

        Auth::login($usuario);

        return redirect()->route('cliente.dashboard');
    }


    // ========================================
    // LOGIN
    // ========================================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credenciales = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Buscar primero si existe el usuario
    $usuario = User::where('email', $credenciales['email'])->first();

    // ========================================
    // CUENTA EXISTE PERO NO TIENE CONTRASEÑA
    // ========================================

    if ($usuario && is_null($usuario->password)) {

        return redirect()
            ->route('cuenta.activar', ['email' => $usuario->email])
            ->with('info', 'Tu cuenta existe, pero todavía necesitas crear una contraseña.');
    }

    // ========================================
    // LOGIN NORMAL
    // ========================================

    if (Auth::attempt($credenciales)) {

        $request->session()->regenerate();

        $usuario = Auth::user();

        // ADMIN
        if ($usuario->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // VENDEDOR
        if ($usuario->rol === 'vendedor') {
            return redirect()->route('vendedor.dashboard');
        }

        // CLIENTE
        return redirect()->route('cliente.dashboard');
    }

    // ========================================
    // CREDENCIALES INCORRECTAS
    // ========================================

    return back()
        ->withInput($request->only('email'))
        ->with('error', 'Correo o contraseña incorrectos.');
}


    // ========================================
    // CERRAR SESIÓN
    // ========================================

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }


    // ========================================
    // INFORMACIÓN DEL CLIENTE
    // ========================================

    public function editProfile()
    {
        return view('cliente.editar_informacion');
    }

    public function updateProfile(Request $request)
    {
        $usuario = Auth::user();

        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $usuario->update([
            'name' => $datos['name'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
        ]);

        return redirect()->route('cliente.informacion');
    }


    // ========================================
    // FOTO DE PERFIL DEL CLIENTE
    // ========================================

    public function actualizarFotoPerfil(Request $request)
    {
        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $usuario = Auth::user();

        $rutaFoto = $request
            ->file('foto_perfil')
            ->store('perfiles', 'public');

        $usuario->foto_perfil = $rutaFoto;
        $usuario->save();

        return redirect()->route('cliente.informacion');
    }


    // ========================================
    // COLOR DE PERFIL DEL CLIENTE
    // ========================================

    public function actualizarColorPerfil(Request $request)
    {
        $datos = $request->validate([
            'color_perfil' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],
        ]);

        $usuario = Auth::user();

        $usuario->color_perfil = $datos['color_perfil'];
        $usuario->save();

        return redirect()->route('cliente.informacion');
    }


    // ========================================
    // ELIMINAR FOTO DEL CLIENTE
    // ========================================

    public function eliminarFotoPerfil()
    {
        $usuario = Auth::user();

        if ($usuario->foto_perfil) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        $usuario->foto_perfil = null;
        $usuario->save();

        return redirect()->route('cliente.informacion');
    }


    // ========================================
    // CLIENTES - ADMIN
    // ========================================

    public function clientes()
    {
        $clientes = User::where('rol', 'cliente')->get();

        return view('admin.clientes', compact('clientes'));
    }


    // ========================================
    // AGREGAR CLIENTE DESDE ADMIN
    // ========================================

    public function showRegisterAdmin()
    {
        return view('admin.clientes.agregar');
    }

    public function registerAdmin(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        User::create([
            'name' => $datos['name'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            'foto_perfil' => null,
            'rol' => 'cliente',

            // El cliente creará su contraseña posteriormente
            'password' => null,
        ]);

        return redirect()
            ->route('admin.clientes')
            ->with('success', 'Cliente agregado correctamente.');
    }


    // ========================================
    // ELIMINAR CLIENTE
    // ========================================

    public function destroyCliente($id)
    {
        $cliente = User::where('rol', 'cliente')->findOrFail($id);

        $cliente->delete();

        return redirect()
            ->route('admin.clientes')
            ->with('success', 'Cliente eliminado correctamente.');
    }


    // ========================================
    // EDITAR CLIENTE
    // ========================================

    public function editarCliente($id)
    {
        $cliente = User::where('rol', 'cliente')->findOrFail($id);

        return view(
            'admin.clientes.editar',
            compact('cliente')
        );
    }


    // ========================================
    // ACTUALIZAR CLIENTE
    // ========================================

    public function actualizarCliente(Request $request, $id)
    {
        $cliente = User::where('rol', 'cliente')->findOrFail($id);

        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $cliente->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $cliente->update($datos);

        return redirect()
            ->route('admin.clientes')
            ->with('success', 'Cliente actualizado correctamente.');
    }


    // ========================================
    // INFORMACIÓN DEL VENDEDOR
    // ========================================

    public function vendedorInformacion()
    {
        return view('vendedor.informacion');
    }


    // ========================================
    // EDITAR INFORMACIÓN DEL VENDEDOR
    // ========================================

    public function vendedorEditarInformacion()
    {
        return view('vendedor.editar_informacion');
    }


    // ========================================
    // ACTUALIZAR INFORMACIÓN DEL VENDEDOR
    // ========================================

    public function vendedorActualizarInformacion(Request $request)
    {
        $usuario = Auth::user();

        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $usuario->update([
            'name' => $datos['name'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
        ]);

        return redirect()->route('vendedor.informacion');
    }


    // ========================================
    // ACTUALIZAR FOTO DEL VENDEDOR
    // ========================================

    public function actualizarFotoVendedor(Request $request)
    {
        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $usuario = Auth::user();

        if ($usuario->foto_perfil) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        $rutaFoto = $request
            ->file('foto_perfil')
            ->store('perfiles', 'public');

        $usuario->foto_perfil = $rutaFoto;
        $usuario->save();

        return redirect()->route('vendedor.informacion');
    }


    // ========================================
    // ACTUALIZAR COLOR DEL VENDEDOR
    // ========================================

    public function actualizarColorVendedor(Request $request)
    {
        $datos = $request->validate([
            'color_perfil' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],
        ]);

        $usuario = Auth::user();

        $usuario->color_perfil = $datos['color_perfil'];
        $usuario->save();

        return redirect()->route('vendedor.informacion');
    }


    // ========================================
    // ELIMINAR FOTO DEL VENDEDOR
    // ========================================

    public function eliminarFotoVendedor()
    {
        $usuario = Auth::user();

        if ($usuario->foto_perfil) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        $usuario->foto_perfil = null;
        $usuario->save();

        return redirect()->route('vendedor.informacion');
    }


    // ========================================
    // INFORMACIÓN DEL ADMINISTRADOR
    // ========================================

    public function adminInformacion()
    {
        return view('admin.informacion');
    }


    // ========================================
    // EDITAR INFORMACIÓN DEL ADMINISTRADOR
    // ========================================

    public function adminEditarInformacion()
    {
        return view('admin.editar_informacion');
    }


    // ========================================
    // ACTUALIZAR INFORMACIÓN DEL ADMINISTRADOR
    // ========================================

    public function adminActualizarInformacion(Request $request)
    {
        $usuario = Auth::user();

        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $usuario->update([
            'name' => $datos['name'],
            'apellido' => $datos['apellido'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
        ]);

        return redirect()->route('admin.informacion');
    }


    // ========================================
    // ACTUALIZAR FOTO DEL ADMINISTRADOR
    // ========================================

    public function actualizarFotoAdmin(Request $request)
    {
        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $usuario = Auth::user();

        if ($usuario->foto_perfil) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        $rutaFoto = $request
            ->file('foto_perfil')
            ->store('perfiles', 'public');

        $usuario->foto_perfil = $rutaFoto;
        $usuario->save();

        return redirect()->route('admin.informacion');
    }


    // ========================================
    // ACTUALIZAR COLOR DEL ADMINISTRADOR
    // ========================================

    public function actualizarColorAdmin(Request $request)
    {
        $datos = $request->validate([
            'color_perfil' => [
                'required',
                'regex:/^#[0-9A-Fa-f]{6}$/'
            ],
        ]);

        $usuario = Auth::user();

        $usuario->color_perfil = $datos['color_perfil'];
        $usuario->save();

        return redirect()->route('admin.informacion');
    }


    // ========================================
    // ELIMINAR FOTO DEL ADMINISTRADOR
    // ========================================

    public function eliminarFotoAdmin()
    {
        $usuario = Auth::user();

        if ($usuario->foto_perfil) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        $usuario->foto_perfil = null;
        $usuario->save();

        return redirect()->route('admin.informacion');
    }

    // ========================================
// ACTIVAR CUENTA DEL CLIENTE
// ========================================

public function mostrarActivarCuenta(Request $request)
{
    $email = $request->query('email');

    if (!$email) {
        return redirect()
            ->route('login')
            ->with('error', 'Debes proporcionar un correo electrónico.');
    }

    $usuario = User::where('email', $email)
        ->where('rol', 'cliente')
        ->first();

    if (!$usuario) {
        return redirect()
            ->route('login')
            ->with('error', 'No encontramos una cuenta con ese correo.');
    }

    // Si ya tiene contraseña, no necesita activar nada
    if (!is_null($usuario->password)) {
        return redirect()
            ->route('login')
            ->with('info', 'Esta cuenta ya tiene una contraseña. Puedes iniciar sesión.');
    }

    return view('auth.crear_password', compact('usuario'));
}


// ========================================
// GUARDAR CONTRASEÑA Y ACTIVAR CUENTA
// ========================================

public function activarCuenta(Request $request)
{
    $datos = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $usuario = User::where('email', $datos['email'])
        ->where('rol', 'cliente')
        ->first();

    if (!$usuario) {
        return back()
            ->with('error', 'No encontramos una cuenta con ese correo.');
    }

    // Verificar que realmente sea una cuenta pendiente de activar
    if (!is_null($usuario->password)) {
        return redirect()
            ->route('login')
            ->with('info', 'Esta cuenta ya tiene una contraseña.');
    }

    // Crear contraseña
    $usuario->password = Hash::make($datos['password']);
    $usuario->save();

    // Iniciar sesión automáticamente
    Auth::login($usuario);

    $request->session()->regenerate();

    return redirect()
        ->route('cliente.dashboard')
        ->with('success', 'Tu cuenta fue activada correctamente.');
}

// ========================================
// LOGIN CON GOOGLE
// ========================================

public function googleLogin(Request $request)
{
    $datos = $request->validate([
        'idToken' => 'required|string',
    ]);

    try {

        // Crear conexión con Firebase
        $factory = (new Factory)
            ->withServiceAccount(
                base_path(env('FIREBASE_CREDENTIALS'))
            );

        $authFirebase = $factory->createAuth();

        // Verificar el token enviado por Firebase
        $tokenVerificado = $authFirebase
            ->verifyIdToken($datos['idToken']);

        // Obtener información del usuario de Google
        $firebaseUser = $authFirebase
            ->getUser($tokenVerificado->claims()->get('sub'));

        $email = $firebaseUser->email;

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Google no proporcionó un correo electrónico.'
            ], 422);
        }

        // Buscar usuario por correo
        $usuario = User::where('email', $email)->first();

        // ========================================
        // SI EL USUARIO NO EXISTE
        // ========================================

        if (!$usuario) {

            $nombre = $firebaseUser->displayName ?? 'Cliente';

            $partesNombre = explode(' ', trim($nombre));

            $nombreUsuario = $partesNombre[0] ?? 'Cliente';

            $apellidoUsuario = count($partesNombre) > 1
                ? implode(' ', array_slice($partesNombre, 1))
                : '';

            $usuario = User::create([
                'name' => $nombreUsuario,
                'apellido' => $apellidoUsuario,
                'email' => $email,
                'telefono' => null,
                'direccion' => null,
                'fecha_nacimiento' => null,
                'foto_perfil' => null,
                'rol' => 'cliente',

                // Google será el método de acceso
                'password' => null,
            ]);
        }

        // ========================================
        // VERIFICAR ROL
        // ========================================

        if ($usuario->rol !== 'cliente') {

            return response()->json([
                'success' => false,
                'message' => 'Esta cuenta no corresponde a un cliente.'
            ], 403);
        }

        // ========================================
        // INICIAR SESIÓN EN LARAVEL
        // ========================================

        Auth::login($usuario);

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'redirect' => route('cliente.dashboard')
        ]);

    } catch (\Throwable $e) {

    \Log::error('ERROR LOGIN GOOGLE', [
        'mensaje' => $e->getMessage(),
        'archivo' => $e->getFile(),
        'linea' => $e->getLine(),
    ]);

    return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
    ], 401);
}
}
}