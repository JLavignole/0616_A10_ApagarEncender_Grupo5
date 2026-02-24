<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Incidencia;
use App\Models\Sede;
use App\Models\Subcategoria;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class IncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        $gestorBcn = User::where('correo', 'l.martinez@techtrack.com')->firstOrFail();
        $gestorMad = User::where('correo', 'd.ortega@techtrack.com')->firstOrFail();
        $tecnicoBcn = User::where('correo', 'c.ruiz@techtrack.com')->firstOrFail();
        $tecnicoBer = User::where('correo', 'a.schmidt@techtrack.com')->firstOrFail();
        $tecnicoLis = User::where('correo', 'j.ferreira@techtrack.com')->firstOrFail();
        $tecnicoRom = User::where('correo', 'g.bianchi@techtrack.com')->firstOrFail();

        $clienteJuan = User::where('correo', 'j.perez@techtrack.com')->firstOrFail();
        $clienteMaria = User::where('correo', 'm.lopez@techtrack.com')->firstOrFail();
        $clienteMarc = User::where('correo', 'm.dupont@techtrack.com')->firstOrFail();
        $clienteHelena = User::where('correo', 'h.costa@techtrack.com')->firstOrFail();
        $clienteLuca = User::where('correo', 'l.moretti@techtrack.com')->firstOrFail();

        $incidencias = [
            [
                'codigo' => 'BCN-2026-000101',
                'sede' => 'BCN',
                'cliente_id' => $clienteJuan->id,
                'gestor_id' => $gestorBcn->id,
                'tecnico_id' => $tecnicoBcn->id,
                'categoria' => 'Redes y conectividad',
                'subcategoria' => 'VPN',
                'titulo' => 'La VPN corporativa se desconecta cada 10 minutos',
                'descripcion' => 'Trabajando en remoto, la sesión VPN cae de forma intermitente y obliga a reconectar varias veces por hora.',
                'comentario_cliente' => 'El problema empezó tras la actualización del cliente VPN.',
                'prioridad' => 'alta',
                'estado' => 'en_progreso',
                'reportado_en' => Carbon::now()->subDays(2),
                'asignado_en' => Carbon::now()->subDays(2)->addHour(),
                'resuelto_en' => null,
                'cerrado_en' => null,
            ],
            [
                'codigo' => 'MAD-2026-000102',
                'sede' => 'MAD',
                'cliente_id' => $clienteMaria->id,
                'gestor_id' => $gestorMad->id,
                'tecnico_id' => $tecnicoRom->id,
                'categoria' => 'Software',
                'subcategoria' => 'ERP',
                'titulo' => 'Error al generar facturas en el ERP',
                'descripcion' => 'Al cerrar una factura, el sistema devuelve un mensaje de validación y no permite contabilizar.',
                'comentario_cliente' => null,
                'prioridad' => 'alta',
                'estado' => 'asignada',
                'reportado_en' => Carbon::now()->subDay(),
                'asignado_en' => Carbon::now()->subDay()->addHours(2),
                'resuelto_en' => null,
                'cerrado_en' => null,
            ],
            [
                'codigo' => 'YUL-2026-000103',
                'sede' => 'YUL',
                'cliente_id' => $clienteMarc->id,
                'gestor_id' => null,
                'tecnico_id' => null,
                'categoria' => 'Accesos y permisos',
                'subcategoria' => 'Carpetas compartidas',
                'titulo' => 'Acceso denegado al repositorio de marketing',
                'descripcion' => 'No puedo abrir la carpeta compartida del equipo de marketing en la unidad de red M:.',
                'comentario_cliente' => null,
                'prioridad' => 'media',
                'estado' => 'sin_asignar',
                'reportado_en' => Carbon::now()->subHours(6),
                'asignado_en' => null,
                'resuelto_en' => null,
                'cerrado_en' => null,
            ],
            [
                'codigo' => 'LIS-2026-000104',
                'sede' => 'LIS',
                'cliente_id' => $clienteHelena->id,
                'gestor_id' => $gestorBcn->id,
                'tecnico_id' => $tecnicoLis->id,
                'categoria' => 'Seguridad',
                'subcategoria' => 'Phishing',
                'titulo' => 'Correo sospechoso solicitando cambio de contraseña',
                'descripcion' => 'He recibido un email que simula ser del soporte y pide verificar credenciales en un enlace externo.',
                'comentario_cliente' => 'No he hecho clic en el enlace.',
                'prioridad' => 'alta',
                'estado' => 'resuelta',
                'reportado_en' => Carbon::now()->subDays(5),
                'asignado_en' => Carbon::now()->subDays(5)->addMinutes(40),
                'resuelto_en' => Carbon::now()->subDays(4),
                'cerrado_en' => null,
            ],
            [
                'codigo' => 'ROM-2026-000105',
                'sede' => 'ROM',
                'cliente_id' => $clienteLuca->id,
                'gestor_id' => $gestorMad->id,
                'tecnico_id' => $tecnicoRom->id,
                'categoria' => 'Telefonía y colaboración',
                'subcategoria' => 'Microsoft Teams',
                'titulo' => 'No funciona el audio en llamadas de Teams',
                'descripcion' => 'Durante las videollamadas el micrófono deja de funcionar tras unos minutos de reunión.',
                'comentario_cliente' => null,
                'prioridad' => 'media',
                'estado' => 'cerrada',
                'reportado_en' => Carbon::now()->subDays(9),
                'asignado_en' => Carbon::now()->subDays(9)->addHours(2),
                'resuelto_en' => Carbon::now()->subDays(8),
                'cerrado_en' => Carbon::now()->subDays(7),
            ],
            [
                'codigo' => 'BCN-2026-000106',
                'sede' => 'BCN',
                'cliente_id' => $clienteJuan->id,
                'gestor_id' => $gestorBcn->id,
                'tecnico_id' => $tecnicoBer->id,
                'categoria' => 'Hardware',
                'subcategoria' => 'Monitor',
                'titulo' => 'Monitor externo con parpadeos intermitentes',
                'descripcion' => 'El monitor principal parpadea al abrir aplicaciones con uso intensivo de gráficos.',
                'comentario_cliente' => null,
                'prioridad' => 'baja',
                'estado' => 'en_progreso',
                'reportado_en' => Carbon::now()->subDays(3),
                'asignado_en' => Carbon::now()->subDays(3)->addHours(3),
                'resuelto_en' => null,
                'cerrado_en' => null,
            ],
            [
                'codigo' => 'MAD-2026-000107',
                'sede' => 'MAD',
                'cliente_id' => $clienteMaria->id,
                'gestor_id' => null,
                'tecnico_id' => null,
                'categoria' => 'Software',
                'subcategoria' => 'Correo corporativo',
                'titulo' => 'Outlook no sincroniza la bandeja de entrada',
                'descripcion' => 'No entran correos desde primera hora y la aplicación muestra estado desconectado.',
                'comentario_cliente' => 'Con webmail sí veo mensajes nuevos.',
                'prioridad' => 'alta',
                'estado' => 'sin_asignar',
                'reportado_en' => Carbon::now()->subHours(4),
                'asignado_en' => null,
                'resuelto_en' => null,
                'cerrado_en' => null,
            ],
            [
                'codigo' => 'LIS-2026-000108',
                'sede' => 'LIS',
                'cliente_id' => $clienteHelena->id,
                'gestor_id' => $gestorMad->id,
                'tecnico_id' => $tecnicoLis->id,
                'categoria' => 'Accesos y permisos',
                'subcategoria' => 'Aplicaciones internas',
                'titulo' => 'Sin acceso al módulo de compras en la intranet',
                'descripcion' => 'Después de un cambio de puesto, no puedo acceder al módulo de aprobaciones de compra.',
                'comentario_cliente' => null,
                'prioridad' => 'media',
                'estado' => 'resuelta',
                'reportado_en' => Carbon::now()->subDays(6),
                'asignado_en' => Carbon::now()->subDays(6)->addHour(),
                'resuelto_en' => Carbon::now()->subDays(5),
                'cerrado_en' => null,
            ],
        ];

        foreach ($incidencias as $item) {
            $sede = Sede::where('codigo', $item['sede'])->firstOrFail();
            $categoria = Categoria::where('nombre', $item['categoria'])->firstOrFail();
            $subcategoria = Subcategoria::where('categoria_id', $categoria->id)
                ->where('nombre', $item['subcategoria'])
                ->firstOrFail();

            Incidencia::create([
                'codigo' => $item['codigo'],
                'sede_id' => $sede->id,
                'cliente_id' => $item['cliente_id'],
                'gestor_id' => $item['gestor_id'],
                'tecnico_id' => $item['tecnico_id'],
                'categoria_id' => $categoria->id,
                'subcategoria_id' => $subcategoria->id,
                'titulo' => $item['titulo'],
                'descripcion' => $item['descripcion'],
                'comentario_cliente' => $item['comentario_cliente'],
                'prioridad' => $item['prioridad'],
                'estado' => $item['estado'],
                'reportado_en' => $item['reportado_en'],
                'asignado_en' => $item['asignado_en'],
                'resuelto_en' => $item['resuelto_en'],
                'cerrado_en' => $item['cerrado_en'],
            ]);
        }
    }
}
