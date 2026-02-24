<?php

namespace Database\Seeders;

use App\Models\SancionUsuario;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SancionUsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('correo', 'n.gonzalez@incitech.com')->firstOrFail();
        $usuario = User::where('correo', 'm.dupont@incitech.com')->firstOrFail();

        SancionUsuario::create([
            'usuario_id' => $usuario->id,
            'tipo' => 'advertencia',
            'motivo' => 'Uso reiterado de formato inadecuado en mensajes de incidencia.',
            'inicio_en' => Carbon::now()->subDays(2),
            'fin_en' => Carbon::now()->addDays(5),
            'creado_por' => $admin->id,
        ]);
    }
}
