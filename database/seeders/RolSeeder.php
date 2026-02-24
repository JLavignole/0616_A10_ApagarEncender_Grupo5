<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'admin', 'descripcion' => 'Administración global de la plataforma'],
            ['nombre' => 'gestor', 'descripcion' => 'Gestión y coordinación de incidencias'],
            ['nombre' => 'tecnico', 'descripcion' => 'Resolución técnica y seguimiento'],
            ['nombre' => 'cliente', 'descripcion' => 'Reporte y consulta de incidencias'],
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}
