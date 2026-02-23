<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 5️⃣ Incidencias — tabla principal del sistema.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // Ej: BCN-2026-000001

            // ── Relaciones ─────────────────────────────────
            $table->foreignId('sede_id')->constrained('sedes')->cascadeOnDelete();
            $table->foreignId('cliente_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('gestor_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->foreignId('tecnico_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
            $table->foreignId('subcategoria_id')->constrained('subcategorias')->cascadeOnDelete();

            // ── Datos de la incidencia ─────────────────────
            $table->string('titulo');
            $table->text('descripcion');
            $table->text('comentario_cliente')->nullable();
            $table->enum('prioridad', ['alta', 'media', 'baja'])->nullable();
            $table->enum('estado', [
                'sin_asignar',
                'asignada',
                'en_progreso',
                'resuelta',
                'cerrada',
            ])->default('sin_asignar');

            // ── Fechas clave ───────────────────────────────
            $table->timestamp('reportado_en')->nullable();
            $table->timestamp('asignado_en')->nullable();
            $table->timestamp('resuelto_en')->nullable();
            $table->timestamp('cerrado_en')->nullable();
            $table->timestamps();

            // ── Índices recomendados ────────────────────────
            $table->index(['sede_id', 'estado']);
            $table->index(['tecnico_id', 'estado']);
            $table->index(['cliente_id', 'estado']);
            $table->index(['prioridad', 'reportado_en']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
