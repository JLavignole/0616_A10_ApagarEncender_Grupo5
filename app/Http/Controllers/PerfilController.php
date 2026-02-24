<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    /**
     * Mostrar formulario de perfil
     */
    public function show()
    {
        /** @var User $usuario */
        $usuario = Auth::user();
        $usuario->load('perfil');

        return view('perfil.editar', compact('usuario'));
    }

    /**
     * Guardar cambios del perfil
     */
    public function update(Request $request)
    {
        /** @var User $usuario */
        $usuario = Auth::user();

        $request->merge(['correo' => strtolower(trim($request->correo))]);

        $request->validate([
            'nombre'       => ['required', 'string', 'min:2', 'max:255'],
            'correo'       => ['required', 'string', 'max:255', Rule::unique('usuarios', 'correo')->ignore($usuario->id)],
            'contrasena'   => ['nullable', 'string', 'min:6'],
            'ruta_avatar'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'apellidos'    => ['nullable', 'string', 'max:255'],
            'telefono'     => ['nullable', 'string', 'max:50'],
            'cargo'        => ['nullable', 'string', 'max:100'],
            'departamento' => ['nullable', 'string', 'max:100'],
            'biografia'    => ['nullable', 'string', 'max:1000'],
        ]);

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