<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 🔟 Notificaciones (opcional).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('tipo');                        // Tipo de notificación
            $table->json('datos');                         // Datos de la notificación (JSON)
            $table->timestamp('leido_en')->nullable();     // Fecha de lectura
            $table->timestamps();

            $table->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
