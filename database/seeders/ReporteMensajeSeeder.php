<?php

namespace Database\Seeders;

use App\Models\Incidencia;
use App\Models\MensajeIncidencia;
use App\Models\ReporteMensaje;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReporteMensajeSeeder extends Seeder
{
    public function run(): void
    {
        $reportador = User::where('correo', 'n.gonzalez@incitech.com')->firstOrFail();
        $revisor = User::where('correo', 'l.martinez@incitech.com')->firstOrFail();

        $incidencia = Incidencia::where('codigo', 'YUL-2026-000103')->firstOrFail();
        $mensaje = MensajeIncidencia::where('incidencia_id', $incidencia->id)->firstOrFail();

        ReporteMensaje::create([
            'mensaje_id' => $mensaje->id,
            'reportador_id' => $reportador->id,
            'motivo' => 'lenguaje_inapropiado',
            'detalles' => 'Se solicita revisar tono y cumplimiento de normas de comunicación interna.',
            'estado' => 'resuelto',
            'revisor_id' => $revisor->id,
            'nota_revision' => 'Revisado sin infracción grave. Se recuerda guía de comunicación al autor.',
        ]);
    }
}
