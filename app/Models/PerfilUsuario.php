<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerfilUsuario extends Model
{
    protected $table = 'perfiles_usuario';

    protected $fillable = [
        'usuario_id',
        'nombre',
        'apellidos',
        'telefono',
        'ruta_avatar',
        'cargo',
        'departamento',
        'biografia',
        'preferencias',
    ];

    protected function casts(): array
    {
        return [
            'preferencias' => 'array',
        ];
    }

    // ── Relaciones ─────────────────────────────────────

    /** Usuario dueño del perfil */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
