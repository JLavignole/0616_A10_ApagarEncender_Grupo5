<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MensajeIncidencia extends Model
{
    protected $table = 'mensajes_incidencia';

    protected $fillable = [
        'incidencia_id',
        'usuario_id',
        'cuerpo',
        'eliminado',
    ];

    protected function casts(): array
    {
        return [
            'eliminado' => 'boolean',
        ];
    }

    // ── Relaciones ─────────────────────────────────────

    /** Incidencia del mensaje */
    public function incidencia(): BelongsTo
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_id');
    }

    /** Autor del mensaje */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /** Reportes sobre este mensaje */
    public function reportes(): HasMany
    {
        return $this->hasMany(ReporteMensaje::class, 'mensaje_id');
    }

    /** Adjuntos del mensaje */
    public function adjuntos(): HasMany
    {
        return $this->hasMany(Adjunto::class, 'mensaje_id');
    }
}
