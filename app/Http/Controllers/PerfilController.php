<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePerfilRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PerfilController extends Controller
{
    // Mostrar formulario de perfil
    public function show(): View
    {
        $usuario = Auth::user()->load('perfil');

        return view('perfil.editar', compact('usuario'));
    }

    // Guardar cambios
    public function update(UpdatePerfilRequest $request): RedirectResponse
    {
        $usuario = Auth::user();

        // Datos de cuenta básicos
        $datosUsuario = [
            'nombre' => $request->nombre,
            'correo' => $request->correo,
        ];

        if ($request->filled('contrasena')) {
            $datosUsuario['contrasena'] = $request->contrasena;
        }

        $usuario->update($datosUsuario);

        // Foto de perfil
        if ($request->hasFile('ruta_avatar')) {
            $archivo       = $request->file('ruta_avatar');
            $extension     = $archivo->getClientOriginalExtension();
            $nombreArchivo = 'usuario-' . $usuario->id . '-' . time() . '.' . $extension;
            $archivo->move(public_path('img/perfiles/usuarios'), $nombreArchivo);

            if ($usuario->perfil) {
                $usuario->perfil->update(['ruta_avatar' => $nombreArchivo]);
            } else {
                $usuario->perfil()->create([
                    'nombre'      => $usuario->nombre,
                    'ruta_avatar' => $nombreArchivo,
                ]);
            }

            // Recargar para reflejar el avatar nuevo en el resto del método
            $usuario->load('perfil');
        }

        // Datos de perfil extendido
        $datosPerfil = [
            'apellidos'    => $request->apellidos,
            'telefono'     => $request->telefono,
            'cargo'        => $request->cargo,
            'departamento' => $request->departamento,
            'biografia'    => $request->biografia,
        ];

        if ($usuario->perfil) {
            $usuario->perfil->update($datosPerfil);
        } else {
            $usuario->perfil()->create(array_merge($datosPerfil, ['nombre' => $usuario->nombre]));
        }

        return redirect()
            ->route('perfil.show')
            ->with('exito', 'Perfil actualizado correctamente.');
    }
}
