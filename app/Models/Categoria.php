<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    // ── Relaciones ─────────────────────────────────────

    /** Subcategorías de esta categoría */
    public function subcategorias(): HasMany
    {
        return $this->hasMany(Subcategoria::class, 'categoria_id');
    }
}
