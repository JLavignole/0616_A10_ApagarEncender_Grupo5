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
        $notificaciones = [
            ['correo' => 'j.perez@incitech.com', 'tipo' => 'incidencia_actualizada', 'codigo' => 'BCN-2026-000101', 'accion' => 'en_progreso', 'leido_en' => null, 'fecha' => Carbon::now()->subHours(10)],
            ['correo' => 'm.lopez@incitech.com', 'tipo' => 'incidencia_asignada', 'codigo' => 'MAD-2026-000102', 'accion' => 'asignada', 'leido_en' => Carbon::now()->subHours(5), 'fecha' => Carbon::now()->subHours(7)],
            ['correo' => 'm.dupont@incitech.com', 'tipo' => 'nuevo_mensaje', 'codigo' => 'YUL-2026-000103', 'accion' => 'mensaje_tecnico', 'leido_en' => null, 'fecha' => Carbon::now()->subHours(3)],
            ['correo' => 'h.costa@incitech.com', 'tipo' => 'incidencia_resuelta', 'codigo' => 'LIS-2026-000108', 'accion' => 'resuelta', 'leido_en' => Carbon::now()->subDays(1), 'fecha' => Carbon::now()->subDays(1)->subHours(1)],
        ];

        foreach ($notificaciones as $item) {
            $usuario = User::where('correo', $item['correo'])->firstOrFail();
            $incidencia = Incidencia::where('codigo', $item['codigo'])->firstOrFail();

            $notificacion = new Notificacion();
            $notificacion->id = (string) Str::uuid();
            $notificacion->usuario_id = $usuario->id;
            $notificacion->tipo = $item['tipo'];
            $notificacion->datos = [
                'incidencia_codigo' => $incidencia->codigo,
                'titulo' => $incidencia->titulo,
                'accion' => $item['accion'],
            ];
            $notificacion->leido_en = $item['leido_en'];
            $notificacion->created_at = $item['fecha'];
            $notificacion->updated_at = $item['fecha'];
            $notificacion->save();
        }
    }
}
