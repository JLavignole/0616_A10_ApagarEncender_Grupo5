<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    // UUID como clave primaria
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'usuario_id',
        'tipo',
        'datos',
        'leido_en',
    ];

    protected function casts(): array
    {
        return [
            'datos'    => 'array',
            'leido_en' => 'datetime',
        ];
    }

    // ── Relaciones ─────────────────────────────────────

    /** Usuario que recibe la notificación */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
