<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'sede_id',
        'rol_id',
        'nombre',
        'correo',
        'contrasena',
        'activo',
        'ultimo_acceso',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
            'activo' => 'boolean',
            'ultimo_acceso' => 'datetime',
        ];
    }

    /**
     * Columna que contiene la contraseña para autenticación.
     */
    public function getAuthPassword(): string
    {
        return $this->contrasena;
    }

    // ── Relaciones ─────────────────────────────────────

    /** Sede del usuario */
    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    /** Rol del usuario (1:1) */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }

    /** Perfil del usuario */
    public function perfil(): HasOne
    {
        return $this->hasOne(PerfilUsuario::class, 'usuario_id');
    }

    /** Incidencias creadas como cliente */
    public function incidenciasCliente(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'cliente_id');
    }

    /** Incidencias asignadas como técnico */
    public function incidenciasTecnico(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'tecnico_id');
    }

    /** Incidencias gestionadas como gestor */
    public function incidenciasGestor(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'gestor_id');
    }

    /** Mensajes escritos en incidencias */
    public function mensajes(): HasMany
    {
        return $this->hasMany(MensajeIncidencia::class, 'usuario_id');
    }

    /** Sanciones / bloqueos del usuario */
    public function sanciones(): HasMany
    {
        return $this->hasMany(SancionUsuario::class, 'usuario_id');
    }
}
