<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    // ── Mostrar formulario de login ────────────────────

    public function showLogin(): View
    {
        return view('auth.login');
    }

    // ── Procesar login ─────────────────────────────────

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'correo'     => ['required', 'string', 'email', 'max:255'],
            'contrasena' => ['required', 'string', 'min:6'],
        ], [
            'correo.required'     => 'El correo corporativo es obligatorio.',
            'correo.email'        => 'Introduce un correo electrónico válido.',
            'correo.max'          => 'El correo no puede superar los 255 caracteres.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.min'      => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        // Intentar autenticación con campos personalizados
        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['contrasena']])) {
            $request->session()->regenerate();

            // Actualizar último acceso
            /** @var User $user */
            $user = Auth::user();
            $user->update(['ultimo_acceso' => now()]);

            return redirect()->intended('/home');
        }

        return back()
            ->withInput($request->only('correo'))
            ->with('error', 'Las credenciales proporcionadas no coinciden con nuestros registros. Por favor, inténtelo de nuevo.');
    }

    // ── Mostrar formulario de registro ─────────────────

    public function showRegister(): View
    {
        $sedes = Sede::where('activo', true)->orderBy('nombre')->get();

        return view('auth.register', compact('sedes'));
    }

    // ── Procesar registro ──────────────────────────────

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre'     => ['required', 'string', 'min:2', 'max:255'],
            'correo'     => ['required', 'string', 'email', 'max:255', 'unique:usuarios,correo'],
            'sede_id'    => ['required', 'integer', 'exists:sedes,id'],
            'contrasena' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nombre.required'      => 'El nombre es obligatorio.',
            'nombre.min'           => 'El nombre debe tener al menos 2 caracteres.',
            'nombre.max'           => 'El nombre no puede superar los 255 caracteres.',
            'correo.required'      => 'El correo corporativo es obligatorio.',
            'correo.email'         => 'Introduce un correo electrónico válido.',
            'correo.max'           => 'El correo no puede superar los 255 caracteres.',
            'correo.unique'        => 'Este correo ya está registrado en el sistema.',
            'sede_id.required'     => 'Debe seleccionar una sede.',
            'sede_id.exists'       => 'La sede seleccionada no es válida.',
            'contrasena.required'  => 'La contraseña es obligatoria.',
            'contrasena.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create([
            'nombre'     => $validated['nombre'],
            'correo'     => $validated['correo'],
            'sede_id'    => $validated['sede_id'],
            'contrasena' => $validated['contrasena'], // El cast 'hashed' del modelo la hashea automáticamente
        ]);

        // Crear perfil vacío asociado
        $user->perfil()->create([
            'nombre' => $validated['nombre'],
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Cuenta creada correctamente. Ya puede iniciar sesión.');
    }

    // ── Cerrar sesión ──────────────────────────────────

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
