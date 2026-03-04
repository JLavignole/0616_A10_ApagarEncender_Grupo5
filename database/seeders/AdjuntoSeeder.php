<?php

namespace Database\Seeders;

use App\Models\Adjunto;
use App\Models\Incidencia;
use App\Models\MensajeIncidencia;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdjuntoSeeder extends Seeder
{
    public function run(): void
    {
        $archivosIncidencia = [
            ['nombre' => 'captura_error.png',        'tipo' => 'image/png',  'tamano' => 428197],
            ['nombre' => 'pantalla_azul.jpg',        'tipo' => 'image/jpeg', 'tamano' => 315880],
            ['nombre' => 'log_sistema.txt',          'tipo' => 'text/plain', 'tamano' => 98221],
            ['nombre' => 'video_problema.mp4',       'tipo' => 'video/mp4',  'tamano' => 5242880],
            ['nombre' => 'informe_diagnostico.pdf',  'tipo' => 'application/pdf', 'tamano' => 204800],
            ['nombre' => 'error_vpn.png',            'tipo' => 'image/png',  'tamano' => 187432],
            ['nombre' => 'config_red.txt',           'tipo' => 'text/plain', 'tamano' => 12045],
            ['nombre' => 'captura_bsod.jpg',         'tipo' => 'image/jpeg', 'tamano' => 445120],
            ['nombre' => 'resultado_antivirus.pdf',  'tipo' => 'application/pdf', 'tamano' => 156000],
            ['nombre' => 'foto_equipo.jpg',          'tipo' => 'image/jpeg', 'tamano' => 892344],
        ];

        $archivosMensaje = [
            ['nombre' => 'diagnostico_tecnico.log',  'tipo' => 'text/plain', 'tamano' => 74500],
            ['nombre' => 'parche_aplicado.zip',      'tipo' => 'application/zip', 'tamano' => 1048576],
            ['nombre' => 'captura_solucion.png',     'tipo' => 'image/png',  'tamano' => 231400],
            ['nombre' => 'script_correccion.ps1',    'tipo' => 'text/plain', 'tamano' => 4521],
            ['nombre' => 'manual_procedimiento.pdf', 'tipo' => 'application/pdf', 'tamano' => 512000],
            ['nombre' => 'logs_servidor.txt',        'tipo' => 'text/plain', 'tamano' => 88900],
            ['nombre' => 'evidencia_resolucion.png', 'tipo' => 'image/png',  'tamano' => 345200],
            ['nombre' => 'backup_config.xml',        'tipo' => 'text/xml',   'tamano' => 15600],
            ['nombre' => 'test_resultado.pdf',       'tipo' => 'application/pdf', 'tamano' => 178000],
            ['nombre' => 'nota_tecnica.docx',        'tipo' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'tamano' => 67800],
        ];

        // Adjuntos vinculados a incidencias (30)
        $incidencias = Incidencia::inRandomOrder()->limit(30)->get();
        foreach ($incidencias as $inc) {
            $archivo = $archivosIncidencia[array_rand($archivosIncidencia)];
            Adjunto::create([
                'disco'           => 'public',
                'ruta'            => 'incidencias/' . $inc->codigo . '/' . $archivo['nombre'],
                'nombre_original' => $archivo['nombre'],
                'tipo_mime'       => $archivo['tipo'],
                'tamano'          => $archivo['tamano'],
                'subido_por'      => $inc->cliente_id,
                'incidencia_id'   => $inc->id,
                'mensaje_id'      => null,
            ]);
        }

        // Adjuntos vinculados a mensajes (25)
        $mensajes = MensajeIncidencia::inRandomOrder()->limit(25)->get();
        foreach ($mensajes as $msg) {
            $archivo = $archivosMensaje[array_rand($archivosMensaje)];
            Adjunto::create([
                'disco'           => 'public',
                'ruta'            => 'mensajes/' . $msg->id . '/' . $archivo['nombre'],
                'nombre_original' => $archivo['nombre'],
                'tipo_mime'       => $archivo['tipo'],
                'tamano'          => $archivo['tamano'],
                'subido_por'      => $msg->usuario_id,
                'incidencia_id'   => null,
                'mensaje_id'      => $msg->id,
            ]);
        }
    }
}
