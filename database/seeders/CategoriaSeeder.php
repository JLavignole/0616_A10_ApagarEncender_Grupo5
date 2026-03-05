<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Hardware', 'activo' => true],
            ['nombre' => 'Software', 'activo' => true],
            ['nombre' => 'Redes y conectividad', 'activo' => true],
            ['nombre' => 'Seguridad', 'activo' => true],
            ['nombre' => 'Accesos y permisos', 'activo' => true],
            ['nombre' => 'Telefonía y colaboración', 'activo' => true],
            ['nombre' => 'Impresión y escaneado', 'activo' => true],
            ['nombre' => 'Almacenamiento y backup', 'activo' => true],
            ['nombre' => 'Bases de datos', 'activo' => true],
            ['nombre' => 'Infraestructura cloud', 'activo' => false],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
