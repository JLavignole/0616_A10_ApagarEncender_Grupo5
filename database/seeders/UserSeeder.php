<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            ['nombre' => 'Nuria González', 'correo' => 'n.gonzalez@techtrack.com', 'sede' => 'BCN', 'rol' => 'admin'],
            ['nombre' => 'Laura Martínez', 'correo' => 'l.martinez@techtrack.com', 'sede' => 'BCN', 'rol' => 'gestor'],
            ['nombre' => 'David Ortega', 'correo' => 'd.ortega@techtrack.com', 'sede' => 'MAD', 'rol' => 'gestor'],
            ['nombre' => 'Carlos Ruiz', 'correo' => 'c.ruiz@techtrack.com', 'sede' => 'BCN', 'rol' => 'tecnico'],
            ['nombre' => 'Anna Schmidt', 'correo' => 'a.schmidt@techtrack.com', 'sede' => 'BER', 'rol' => 'tecnico'],
            ['nombre' => 'João Ferreira', 'correo' => 'j.ferreira@techtrack.com', 'sede' => 'LIS', 'rol' => 'tecnico'],
            ['nombre' => 'Giulia Bianchi', 'correo' => 'g.bianchi@techtrack.com', 'sede' => 'ROM', 'rol' => 'tecnico'],
            ['nombre' => 'Juan Pérez', 'correo' => 'j.perez@techtrack.com', 'sede' => 'BCN', 'rol' => 'cliente'],
            ['nombre' => 'María López', 'correo' => 'm.lopez@techtrack.com', 'sede' => 'MAD', 'rol' => 'cliente'],
            ['nombre' => 'Marc Dupont', 'correo' => 'm.dupont@techtrack.com', 'sede' => 'YUL', 'rol' => 'cliente'],
            ['nombre' => 'Helena Costa', 'correo' => 'h.costa@techtrack.com', 'sede' => 'LIS', 'rol' => 'cliente'],
            ['nombre' => 'Luca Moretti', 'correo' => 'l.moretti@techtrack.com', 'sede' => 'ROM', 'rol' => 'cliente'],
        ];

        foreach ($usuarios as $usuario) {
            $sede = Sede::where('codigo', $usuario['sede'])->firstOrFail();
            $rol = Rol::where('nombre', $usuario['rol'])->firstOrFail();

            User::create([
                'sede_id' => $sede->id,
                'rol_id' => $rol->id,
                'nombre' => $usuario['nombre'],
                'correo' => $usuario['correo'],
                'contrasena' => 'password',
                'activo' => true,
                'ultimo_acceso' => Carbon::now()->subHours(rand(1, 96)),
            ]);
        }
    }
}
