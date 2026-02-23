<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sede extends Model
{
    protected $table = 'sedes';

    protected $fillable = [
        'codigo',
        'nombre',
        'zona_horaria',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    // ── Relaciones ─────────────────────────────────────

    /** Usuarios de esta sede */
    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'sede_id');
    }
}
