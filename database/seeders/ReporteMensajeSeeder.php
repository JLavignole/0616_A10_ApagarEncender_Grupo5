<?php

namespace Database\Seeders;

use App\Models\MensajeIncidencia;
use App\Models\ReporteMensaje;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReporteMensajeSeeder extends Seeder
{
    public function run(): void
    {
        $motivos = ['lenguaje_inapropiado', 'spam', 'informacion_falsa', 'acoso', 'contenido_ofensivo'];
        $estadosReporte = ['pendiente', 'en_revision', 'resuelto', 'rechazado'];

        $detalles = [
            'Se solicita revisar tono y cumplimiento de normas de comunicación interna.',
            'El mensaje contiene información que parece ser incorrecta.',
            'Lenguaje poco profesional inaceptable en un entorno corporativo.',
            'Posible contenido spam o publicidad no solicitada.',
            'El mensaje incluye datos sensibles que no deberían compartirse.',
            'Tono amenazante hacia un compañero.',
            'Información desactualizada que puede llevar a error.',
            'Mensaje duplicado enviado múltiples veces.',
            'Incluye enlaces externos sospechosos.',
            'Comentario fuera de contexto y poco constructivo.',
        ];

        $notasRevision = [
            'Revisado sin infracción grave. Se recuerda guía de comunicación al autor.',
            'Se confirma la infracción. Se ha notificado al usuario.',
            'Rechazado: el reporte no tiene fundamento suficiente.',
            'Se ha aplicado una advertencia al autor del mensaje.',
            'Caso derivado a RRHH para revisión adicional.',
            null,
        ];

        $admins = User::whereHas('rol', fn ($q) => $q->where('nombre', 'admin'))->pluck('id')->toArray();
        $gestores = User::whereHas('rol', fn ($q) => $q->where('nombre', 'gestor'))->pluck('id')->toArray();
        $allReportadores = array_merge($admins, $gestores);

        $mensajes = MensajeIncidencia::inRandomOrder()->limit(50)->get();

        foreach ($mensajes as $mensaje) {
            $estado = $estadosReporte[array_rand($estadosReporte)];
            $revisorId = null;
            $nota = null;

            if (in_array($estado, ['resuelto', 'rechazado'])) {
                $revisorId = $admins[array_rand($admins)];
                $nota = $notasRevision[array_rand($notasRevision)];
            } elseif ($estado === 'en_revision') {
                $revisorId = $admins[array_rand($admins)];
            }

            ReporteMensaje::create([
                'mensaje_id'    => $mensaje->id,
                'reportador_id' => $allReportadores[array_rand($allReportadores)],
                'motivo'        => $motivos[array_rand($motivos)],
                'detalles'      => $detalles[array_rand($detalles)],
                'estado'        => $estado,
                'revisor_id'    => $revisorId,
                'nota_revision' => $nota,
            ]);
        }
    }
}
