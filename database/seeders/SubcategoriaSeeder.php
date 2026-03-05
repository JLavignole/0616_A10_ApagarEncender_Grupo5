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
            'Hardware' => ['Portátil', 'Monitor', 'Impresora', 'Docking station', 'Teclado y ratón', 'Auriculares'],
            'Software' => ['Sistema operativo', 'ERP', 'Suite ofimática', 'Correo corporativo', 'CRM', 'Herramientas de diseño'],
            'Redes y conectividad' => ['VPN', 'Wi-Fi', 'Red cableada', 'DNS', 'Proxy'],
            'Seguridad' => ['Antivirus', 'EDR', 'Cifrado de disco', 'Phishing', 'Actualizaciones críticas'],
            'Accesos y permisos' => ['Carpetas compartidas', 'Aplicaciones internas', 'Alta de usuario', 'Baja de usuario', 'Privilegios temporales'],
            'Telefonía y colaboración' => ['Microsoft Teams', 'Telefonía IP', 'Videoconferencia', 'Calendario compartido'],
            'Impresión y escaneado' => ['Impresora de red', 'Escáner', 'Plóter', 'Cartuchos y tóner', 'Cola de impresión'],
            'Almacenamiento y backup' => ['NAS', 'SAN', 'Copias de seguridad', 'Cuota de disco', 'Recuperación de archivos'],
            'Bases de datos' => ['MySQL', 'PostgreSQL', 'SQL Server', 'MongoDB', 'Rendimiento de consultas'],
            'Infraestructura cloud' => ['AWS', 'Azure', 'Google Cloud', 'Docker y Kubernetes', 'Servidor VPS'],
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
