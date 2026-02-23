<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        // ── 1️⃣ Sedes ──────────────────────────────────────
        Schema::create('sedes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();       // BCN, BER, YUL
            $table->string('nombre');                      // Barcelona, Berlín, Montreal
            $table->string('zona_horaria')->nullable();    // Zona horaria (opcional)
            $table->boolean('activo')->default(true);      // Sede activa
            $table->timestamps();
        });

        // ── Roles (relación 1:1 con usuarios) ──────────────
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // admin, cliente, gestor, tecnico
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        // ── Usuarios (solo autenticación) ──────────────────
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained('sedes')->cascadeOnDelete();
            $table->foreignId('rol_id')->nullable()->constrained('roles')->nullOnDelete(); // Rol del usuario (1:1)
            $table->string('nombre');
            $table->string('correo')->unique();
            $table->string('contrasena');
            $table->boolean('activo')->default(true);
            $table->timestamp('ultimo_acceso')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('sedes');
    }
};
