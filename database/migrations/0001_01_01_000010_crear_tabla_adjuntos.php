<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 9️⃣ Adjuntos (tabla única con FK directas).
 *    Cada adjunto pertenece a una incidencia O a un mensaje (uno de los dos).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adjuntos', function (Blueprint $table) {
            $table->id();
            $table->string('disco')->default('public');        // Disco de almacenamiento
            $table->string('ruta');                             // Ruta del archivo
            $table->string('nombre_original');                  // Nombre original del archivo
            $table->string('tipo_mime')->nullable();            // Tipo MIME
            $table->unsignedBigInteger('tamano')->default(0);  // Tamaño en bytes
            $table->foreignId('subido_por')->constrained('usuarios')->cascadeOnDelete();

            // FK directas (nullable): el adjunto pertenece a una incidencia o a un mensaje
            $table->foreignId('incidencia_id')->nullable()->constrained('incidencias')->cascadeOnDelete();
            $table->foreignId('mensaje_id')->nullable()->constrained('mensajes_incidencia')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adjuntos');
    }
};
