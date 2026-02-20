<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incidencia extends Model
{
    protected $table = 'incidencias';

    protected $fillable = [
        'codigo',
        'sede_id',
        'cliente_id',
        'gestor_id',
        'tecnico_id',
        'categoria_id',
        'subcategoria_id',
        'titulo',
        'descripcion',
        'comentario_cliente',
        'prioridad',
        'estado',
        'reportado_en',
        'asignado_en',
        'resuelto_en',
        'cerrado_en',
    ];

    protected function casts(): array
    {
        return [
            'reportado_en' => 'datetime',
            'asignado_en'  => 'datetime',
            'resuelto_en'  => 'datetime',
            'cerrado_en'   => 'datetime',
        ];
    }

    // ── Relaciones ─────────────────────────────────────

    /** Sede de la incidencia */
    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class, 'sede_id');
    }

    /** Cliente que reportó */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    /** Gestor asignado */
    public function gestor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestor_id');
    }

    /** Técnico asignado */
    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    /** Categoría */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /** Subcategoría */
    public function subcategoria(): BelongsTo
    {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id');
    }

    /** Mensajes de la incidencia */
    public function mensajes(): HasMany
    {
        return $this->hasMany(MensajeIncidencia::class, 'incidencia_id');
    }

    /** Adjuntos de la incidencia */
    public function adjuntos(): HasMany
    {
        return $this->hasMany(Adjunto::class, 'incidencia_id');
    }
}
