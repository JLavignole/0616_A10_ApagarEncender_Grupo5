<?php

namespace Database\Seeders;

use App\Models\Incidencia;
use App\Models\MensajeIncidencia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MensajeIncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        $mensajes = [
            ['codigo' => 'BCN-2026-000101', 'correo' => 'c.ruiz@techtrack.com', 'cuerpo' => 'Estoy revisando los logs del gateway VPN para detectar la causa de la desconexión.', 'fecha' => Carbon::now()->subDays(2)->addHours(2)],
            ['codigo' => 'BCN-2026-000101', 'correo' => 'j.perez@techtrack.com', 'cuerpo' => 'Gracias, estaré disponible esta tarde para hacer pruebas.', 'fecha' => Carbon::now()->subDays(2)->addHours(3)],
            ['codigo' => 'MAD-2026-000102', 'correo' => 'd.ortega@techtrack.com', 'cuerpo' => 'Asignada a soporte de aplicaciones para revisión funcional del flujo de facturación.', 'fecha' => Carbon::now()->subDay()->addHours(3)],
            ['codigo' => 'MAD-2026-000102', 'correo' => 'g.bianchi@techtrack.com', 'cuerpo' => 'He identificado un cambio en validaciones de impuestos; preparo parche para hoy.', 'fecha' => Carbon::now()->subDay()->addHours(5)],
            ['codigo' => 'YUL-2026-000103', 'correo' => 'm.dupont@techtrack.com', 'cuerpo' => 'Necesito acceso para editar materiales de campaña de marzo.', 'fecha' => Carbon::now()->subHours(5)],
            ['codigo' => 'LIS-2026-000104', 'correo' => 'j.ferreira@techtrack.com', 'cuerpo' => 'Se ha bloqueado el dominio fraudulento y enviado aviso preventivo al departamento.', 'fecha' => Carbon::now()->subDays(5)->addHours(2)],
            ['codigo' => 'LIS-2026-000104', 'correo' => 'h.costa@techtrack.com', 'cuerpo' => 'Confirmo recepción. Gracias por la rapidez.', 'fecha' => Carbon::now()->subDays(5)->addHours(3)],
            ['codigo' => 'ROM-2026-000105', 'correo' => 'g.bianchi@techtrack.com', 'cuerpo' => 'Actualizados drivers de audio y firmware del docking. ¿Puedes validar en la próxima reunión?', 'fecha' => Carbon::now()->subDays(8)],
            ['codigo' => 'ROM-2026-000105', 'correo' => 'l.moretti@techtrack.com', 'cuerpo' => 'Probado esta mañana y el audio funciona correctamente.', 'fecha' => Carbon::now()->subDays(8)->addHours(2)],
            ['codigo' => 'BCN-2026-000106', 'correo' => 'a.schmidt@techtrack.com', 'cuerpo' => 'He solicitado cable DisplayPort certificado y monitor de sustitución para pruebas.', 'fecha' => Carbon::now()->subDays(3)->addHours(4)],
            ['codigo' => 'MAD-2026-000107', 'correo' => 'm.lopez@techtrack.com', 'cuerpo' => 'El problema persiste en dos equipos del departamento.', 'fecha' => Carbon::now()->subHours(3)],
            ['codigo' => 'LIS-2026-000108', 'correo' => 'd.ortega@techtrack.com', 'cuerpo' => 'Aprobada la solicitud y aplicado rol de compras en producción.', 'fecha' => Carbon::now()->subDays(5)->addHours(1)],
        ];

        foreach ($mensajes as $mensaje) {
            $incidencia = Incidencia::where('codigo', $mensaje['codigo'])->firstOrFail();
            $usuario = User::where('correo', $mensaje['correo'])->firstOrFail();

            MensajeIncidencia::create([
                'incidencia_id' => $incidencia->id,
                'usuario_id' => $usuario->id,
                'cuerpo' => $mensaje['cuerpo'],
                'eliminado' => false,
                'created_at' => $mensaje['fecha'],
                'updated_at' => $mensaje['fecha'],
            ]);
        }
    }
}
