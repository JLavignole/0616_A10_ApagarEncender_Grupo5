<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReporteMensaje extends Model
{
    protected $table = 'reportes_mensaje';

    protected $fillable = [
        'mensaje_id',
        'reportador_id',
        'motivo',
        'detalles',
        'estado',
        'revisor_id',
        'nota_revision',
    ];

    // ── Relaciones ─────────────────────────────────────

    /** Mensaje reportado */
    public function mensaje(): BelongsTo
    {
        return $this->belongsTo(MensajeIncidencia::class, 'mensaje_id');
    }

    /** Usuario que creó el reporte */
    public function reportador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reportador_id');
    }

    /** Moderador que revisó el reporte */
    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisor_id');
    }
}
