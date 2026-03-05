<?php

namespace Database\Seeders;

use App\Models\Incidencia;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class NotificacionSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'incidencia_creada',
            'incidencia_asignada',
            'incidencia_actualizada',
            'incidencia_resuelta',
            'incidencia_cerrada',
            'incidencia_reabierta',
            'nuevo_mensaje',
        ];

        $acciones = [
            'incidencia_creada'      => 'creada',
            'incidencia_asignada'    => 'asignada',
            'incidencia_actualizada' => 'en_progreso',
            'incidencia_resuelta'    => 'resuelta',
            'incidencia_cerrada'     => 'cerrada',
            'incidencia_reabierta'   => 'reabierta',
            'nuevo_mensaje'          => 'mensaje_nuevo',
        ];

        $incidencias = Incidencia::all();

        foreach ($incidencias as $inc) {
            // Notificación al cliente (siempre)
            $tipo = $tipos[array_rand($tipos)];
            $fecha = $inc->reportado_en ? (clone $inc->reportado_en)->addHours(rand(1, 12)) : Carbon::now()->subDays(rand(1, 15));
            $leido = rand(0, 1) ? (clone $fecha)->addHours(rand(1, 24)) : null;

            $notif = new Notificacion();
            $notif->id = (string) Str::uuid();
            $notif->usuario_id = $inc->cliente_id;
            $notif->tipo = $tipo;
            $notif->datos = [
                'incidencia_codigo' => $inc->codigo,
                'titulo'            => $inc->titulo,
                'accion'            => $acciones[$tipo],
            ];
            $notif->leido_en = $leido;
            $notif->created_at = $fecha;
            $notif->updated_at = $fecha;
            $notif->save();
        }

        // Notificaciones extra para gestores y técnicos
        $gestores = User::whereHas('rol', fn ($q) => $q->where('nombre', 'gestor'))->pluck('id')->toArray();
        $tecnicos = User::whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))->pluck('id')->toArray();
        $staffIds = array_merge($gestores, $tecnicos);

        $incidenciasAsignadas = Incidencia::whereNotNull('gestor_id')->get();
        foreach ($incidenciasAsignadas as $inc) {
            $tipo = $tipos[array_rand($tipos)];
            $fecha = $inc->asignado_en ? (clone $inc->asignado_en)->addHours(rand(0, 6)) : Carbon::now()->subDays(rand(1, 10));
            $leido = rand(0, 1) ? (clone $fecha)->addHours(rand(1, 48)) : null;

            $destinatario = rand(0, 1) && $inc->tecnico_id ? $inc->tecnico_id : $inc->gestor_id;

            $notif = new Notificacion();
            $notif->id = (string) Str::uuid();
            $notif->usuario_id = $destinatario;
            $notif->tipo = $tipo;
            $notif->datos = [
                'incidencia_codigo' => $inc->codigo,
                'titulo'            => $inc->titulo,
                'accion'            => $acciones[$tipo],
            ];
            $notif->leido_en = $leido;
            $notif->created_at = $fecha;
            $notif->updated_at = $fecha;
            $notif->save();
        }
    }
}
