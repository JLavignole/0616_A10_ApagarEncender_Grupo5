<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 7️⃣ Mensajes dentro de incidencias.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes_incidencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incidencia_id')->constrained('incidencias')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->text('cuerpo');                         // Contenido del mensaje
            $table->boolean('eliminado')->default(false);   // Borrado lógico
            $table->timestamps();

            // ── Índices ────────────────────────────────────
            $table->index(['incidencia_id', 'created_at']);
            $table->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes_incidencia');
    }
};
