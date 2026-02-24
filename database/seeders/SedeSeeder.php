<?php

namespace Database\Seeders;

use App\Models\Sede;
use Illuminate\Database\Seeder;

class SedeSeeder extends Seeder
{
    public function run(): void
    {
        $sedes = [
            ['codigo' => 'BCN', 'nombre' => 'Barcelona', 'zona_horaria' => 'Europe/Madrid', 'activo' => true],
            ['codigo' => 'MAD', 'nombre' => 'Madrid', 'zona_horaria' => 'Europe/Madrid', 'activo' => true],
            ['codigo' => 'BER', 'nombre' => 'Berlín', 'zona_horaria' => 'Europe/Berlin', 'activo' => true],
            ['codigo' => 'YUL', 'nombre' => 'Montreal', 'zona_horaria' => 'America/Montreal', 'activo' => true],
            ['codigo' => 'LIS', 'nombre' => 'Lisboa', 'zona_horaria' => 'Europe/Lisbon', 'activo' => true],
            ['codigo' => 'ROM', 'nombre' => 'Roma', 'zona_horaria' => 'Europe/Rome', 'activo' => true],
        ];

        foreach ($sedes as $sede) {
            Sede::create($sede);
        }
    }
}
