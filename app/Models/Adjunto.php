<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adjunto extends Model
{
    protected $table = 'adjuntos';

    protected $fillable = [
        'disco',
        'ruta',
        'nombre_original',
        'tipo_mime',
        'tamano',
        'subido_por',
        'incidencia_id',
        'mensaje_id',
    ];

    // ── Relaciones ───────────────────────────────────

    /** Usuario que subió el archivo */
    public function subidoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'subido_por');
    }

    /** Incidencia a la que pertenece (nullable) */
    public function incidencia(): BelongsTo
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_id');
    }

    /** Mensaje al que pertenece (nullable) */
    public function mensaje(): BelongsTo
    {
        return $this->belongsTo(MensajeIncidencia::class, 'mensaje_id');
    }
}
