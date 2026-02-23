<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SancionUsuario extends Model
{
    protected $table = 'sanciones_usuario';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'motivo',
        'inicio_en',
        'fin_en',
        'creado_por',
    ];

    protected function casts(): array
    {
        return [
            'inicio_en' => 'datetime',
            'fin_en'    => 'datetime',
        ];
    }

    // ── Relaciones ─────────────────────────────────────

    /** Usuario sancionado */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /** Administrador que aplicó la sanción */
    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por');
    }
}
