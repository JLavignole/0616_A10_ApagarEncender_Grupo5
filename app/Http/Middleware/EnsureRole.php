<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de control de acceso por rol.
 *
 * Uso en rutas:
 *   ->middleware('role:administrador')
 *   ->middleware('role:gestor,tecnico')
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Usuario no autenticado → login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $usuario */
        $usuario    = Auth::user();
        $rolUsuario = $usuario->rol?->nombre ?? '';

        // Normalización: 'admin' se trata igual que 'administrador'
        $rolNormalizado = ($rolUsuario === 'admin') ? 'administrador' : $rolUsuario;

        foreach ($roles as $rolRequerido) {
            if ($rolNormalizado === $rolRequerido) {
                return $next($request);
            }
        }

        // Sin permiso → 403
        abort(403, 'Acceso no autorizado. No tienes el rol necesario para esta sección.');
    }
}
