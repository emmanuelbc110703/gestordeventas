<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as ReglaPassword;

class RestablecerContrasenaController extends Controller
{
    /**
     * Formulario para pedir el enlace.
     */
    public function solicitar()
    {
        return view('auth.restablecer_contrasena.solicitar');
    }

    /**
     * Enviar el enlace al correo.
     */
    public function enviarEnlace(Request $request)
    {
        $datos = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'Escribe tu correo electrónico.',
            'email.email'    => 'Escribe un correo electrónico válido.',
        ]);

        $estado = Password::sendResetLink(['email' => $datos['email']]);

        if ($estado === Password::RESET_THROTTLED) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Ya te enviamos un enlace hace un momento. Espera un minuto para pedir otro.',
                ]);
        }

        $minutos = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        // Respuesta igual exista o no el correo, para no revelar qué cuentas están registradas.
        return back()->with(
            'status',
            "Si el correo está registrado, te enviamos un enlace para restablecer tu contraseña. Es válido por {$minutos} minutos."
        );
    }

    /**
     * Formulario para escribir la nueva contraseña.
     */
    public function formulario(Request $request, string $token)
    {
        return view('auth.restablecer_contrasena.nueva', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Guardar la nueva contraseña.
     */
    public function actualizar(Request $request)
    {
        $datos = $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', ReglaPassword::min(8)->letters()->numbers()],
        ], [
            'password.required'  => 'Escribe tu nueva contraseña.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.letters'   => 'La contraseña debe incluir al menos una letra.',
            'password.numbers'   => 'La contraseña debe incluir al menos un número.',
        ]);

        $estado = Password::reset(
            [
                'email'                 => $datos['email'],
                'password'              => $datos['password'],
                'password_confirmation' => $request->input('password_confirmation'),
                'token'                 => $datos['token'],
            ],
            function ($usuario, $password) {
                $usuario->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($usuario));
            }
        );

        if ($estado === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('status', 'Tu contraseña se actualizó correctamente. Ya puedes iniciar sesión.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'El enlace no es válido o ya venció. Solicita uno nuevo.',
            ]);
    }
}