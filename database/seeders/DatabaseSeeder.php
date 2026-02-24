<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SedeSeeder::class,
            RolSeeder::class,
            UserSeeder::class,
            PerfilUsuarioSeeder::class,
            CategoriaSeeder::class,
            SubcategoriaSeeder::class,
            IncidenciaSeeder::class,
            MensajeIncidenciaSeeder::class,
            ReporteMensajeSeeder::class,
            AdjuntoSeeder::class,
            NotificacionSeeder::class,
            SancionUsuarioSeeder::class,
        ]);
    }
}
