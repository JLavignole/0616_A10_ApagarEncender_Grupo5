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
        $cuerposTecnico = [
            'Estoy revisando los logs del servicio para detectar la causa.',
            'He identificado el origen del problema; preparo un parche.',
            'Se ha aplicado la corrección. Por favor, valida cuando puedas.',
            'He actualizado los drivers y reiniciado el servicio.',
            'El componente defectuoso ha sido sustituido.',
            'Se ha reconfigurado el servicio y comprobado el funcionamiento.',
            'He escalado el caso al proveedor; esperamos respuesta en 24 h.',
            'Comprobado el cableado y reenrutado la conexión.',
            'Parche desplegado en el entorno de producción.',
            'Restaurada la copia de seguridad correspondiente.',
        ];

        $cuerposCliente = [
            'Gracias, quedo a la espera.',
            'He probado y el problema persiste.',
            'Confirmado, ya funciona correctamente.',
            'El error ha vuelto a aparecer esta mañana.',
            'Necesito resolverlo hoy, tengo una presentación.',
            'He reiniciado el equipo y sigue igual.',
            'Perfecto, muchas gracias por la rapidez.',
            '¿Hay alguna novedad sobre el caso?',
            'Adjunto captura del error actualizado.',
            'Puedo confirmar que la solución funciona.',
        ];

        $cuerposGestor = [
            'Asignada al técnico correspondiente de la sede.',
            'He priorizado este caso por impacto en producción.',
            'Revisaré con el equipo en la daily de mañana.',
            'Escalada al proveedor por superar el SLA interno.',
            'Cerrada tras confirmación del usuario.',
        ];

        $incidencias = Incidencia::with(['cliente', 'gestor', 'tecnico'])->get();

        foreach ($incidencias as $inc) {
            $base = $inc->reportado_en ?? Carbon::now()->subDays(5);
            $horasOffset = 2;

            // Mensaje del cliente (siempre)
            MensajeIncidencia::create([
                'incidencia_id' => $inc->id,
                'usuario_id'    => $inc->cliente_id,
                'cuerpo'        => $cuerposCliente[array_rand($cuerposCliente)],
                'eliminado'     => false,
                'created_at'    => (clone $base)->addHours($horasOffset),
                'updated_at'    => (clone $base)->addHours($horasOffset),
            ]);
            $horasOffset += rand(1, 4);

            // Mensaje del gestor (si existe)
            if ($inc->gestor_id) {
                MensajeIncidencia::create([
                    'incidencia_id' => $inc->id,
                    'usuario_id'    => $inc->gestor_id,
                    'cuerpo'        => $cuerposGestor[array_rand($cuerposGestor)],
                    'eliminado'     => false,
                    'created_at'    => (clone $base)->addHours($horasOffset),
                    'updated_at'    => (clone $base)->addHours($horasOffset),
                ]);
                $horasOffset += rand(1, 3);
            }

            // Mensaje del técnico (si existe)
            if ($inc->tecnico_id) {
                MensajeIncidencia::create([
                    'incidencia_id' => $inc->id,
                    'usuario_id'    => $inc->tecnico_id,
                    'cuerpo'        => $cuerposTecnico[array_rand($cuerposTecnico)],
                    'eliminado'     => false,
                    'created_at'    => (clone $base)->addHours($horasOffset),
                    'updated_at'    => (clone $base)->addHours($horasOffset),
                ]);
            }
        }

        // Marcar algunos mensajes como eliminados para probar esa funcionalidad
        MensajeIncidencia::inRandomOrder()->limit(5)->update(['eliminado' => true]);
    }
}
