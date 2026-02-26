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
        $tecnico = User::where('correo', 'g.bianchi@techtrack.com')->firstOrFail();
        $cliente = User::where('correo', 'm.lopez@techtrack.com')->firstOrFail();

        $incErp = Incidencia::where('codigo', 'MAD-2026-000102')->firstOrFail();
        $incOutlook = Incidencia::where('codigo', 'MAD-2026-000107')->firstOrFail();

        $mensajeErp = MensajeIncidencia::where('incidencia_id', $incErp->id)->firstOrFail();

        Adjunto::create([
            'disco' => 'public',
            'ruta' => 'incidencias/MAD-2026-000102/captura-error-erp.png',
            'nombre_original' => 'captura_error_erp.png',
            'tipo_mime' => 'image/png',
            'tamano' => 428197,
            'subido_por' => $cliente->id,
            'incidencia_id' => $incErp->id,
            'mensaje_id' => null,
        ]);

        Adjunto::create([
            'disco' => 'public',
            'ruta' => 'mensajes/diagnostico-erp-registro.log',
            'nombre_original' => 'diagnostico_erp_2026-02-22.log',
            'tipo_mime' => 'text/plain',
            'tamano' => 98221,
            'subido_por' => $tecnico->id,
            'incidencia_id' => null,
            'mensaje_id' => $mensajeErp->id,
        ]);

        Adjunto::create([
            'disco' => 'public',
            'ruta' => 'incidencias/MAD-2026-000107/outlook-sync-status.jpg',
            'nombre_original' => 'estado_sincronizacion_outlook.jpg',
            'tipo_mime' => 'image/jpeg',
            'tamano' => 315880,
            'subido_por' => $cliente->id,
            'incidencia_id' => $incOutlook->id,
            'mensaje_id' => null,
        ]);
    }
}
