<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 1️⃣1️⃣ Control de sanciones o bloqueos (opcional).
 *    Advertencias, silencios y bloqueos temporales de usuarios.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sanciones_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('tipo');                         // advertencia, silencio, bloqueo
            $table->text('motivo')->nullable();              // Motivo de la sanción
            $table->timestamp('inicio_en')->nullable();      // Inicio de la sanción
            $table->timestamp('fin_en')->nullable();         // Fin de la sanción
            $table->foreignId('creado_por')->constrained('usuarios')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanciones_usuario');
    }
};
