<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 8️⃣ Reporte de mensajes (moderación).
 *    Un mismo usuario no puede reportar el mismo mensaje más de una vez.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes_mensaje', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mensaje_id')->constrained('mensajes_incidencia')->cascadeOnDelete();
            $table->foreignId('reportador_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('motivo');                       // spam, abuso, acoso, otro
            $table->text('detalles')->nullable();
            $table->enum('estado', [
                'pendiente',
                'en_revision',
                'resuelto',
                'rechazado',
            ])->default('pendiente');
            $table->foreignId('revisor_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->text('nota_revision')->nullable();
            $table->timestamps();

            // Un usuario solo puede reportar un mensaje una vez
            $table->unique(['mensaje_id', 'reportador_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes_mensaje');
    }
};
