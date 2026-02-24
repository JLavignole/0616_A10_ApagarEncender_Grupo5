<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Database\Seeder;

class SubcategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $subcategorias = [
            'Hardware' => ['Portátil', 'Monitor', 'Impresora', 'Docking station', 'Teclado y ratón'],
            'Software' => ['Sistema operativo', 'ERP', 'Suite ofimática', 'Correo corporativo', 'CRM'],
            'Redes y conectividad' => ['VPN', 'Wi-Fi', 'Red cableada', 'DNS', 'Proxy'],
            'Seguridad' => ['Antivirus', 'EDR', 'Cifrado de disco', 'Phishing', 'Actualizaciones críticas'],
            'Accesos y permisos' => ['Carpetas compartidas', 'Aplicaciones internas', 'Alta de usuario', 'Baja de usuario', 'Privilegios temporales'],
            'Telefonía y colaboración' => ['Microsoft Teams', 'Telefonía IP', 'Videoconferencia', 'Calendario compartido'],
        ];

        foreach ($subcategorias as $nombreCategoria => $items) {
            $categoria = Categoria::where('nombre', $nombreCategoria)->firstOrFail();

            foreach ($items as $nombreSubcategoria) {
                Subcategoria::create([
                    'categoria_id' => $categoria->id,
                    'nombre' => $nombreSubcategoria,
                    'activo' => true,
                ]);
            }
        }
    }
}
