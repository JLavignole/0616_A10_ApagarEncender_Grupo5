<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
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
        return view('autenticacion.login');
    }

    // ── Procesar login ─────────────────────────────────

    public function login(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Intentar autenticación con campos personalizados
        if (!Auth::attempt(['correo' => $validated['correo'], 'password' => $validated['contrasena']])) {
            return back()
                ->withInput($request->only('correo'))
                ->with('error', 'Las credenciales proporcionadas no son correctas. Por favor, inténtalo de nuevo.');
        }

        /** @var User $user */
        $user = Auth::user();

        // Cuenta desactivada
        if (!$user->activo) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('correo'))
                ->with('error', 'Tu cuenta ha sido desactivada. Contacta con el administrador.');
        }

        $request->session()->regenerate();
        $user->update(['ultimo_acceso' => now()]);

        // Redirección según rol
        $rol = $user->rol?->nombre ?? 'cliente';

        return match (true) {
            in_array($rol, ['admin', 'administrador']) => redirect()->route('administrador.dashboard'),
            $rol === 'gestor'                          => redirect()->route('gestor.dashboard'),
            $rol === 'tecnico'                         => redirect()->route('tecnico.dashboard'),
            default                                    => redirect()->route('cliente.dashboard'),
        };
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
