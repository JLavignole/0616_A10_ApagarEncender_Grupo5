<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 3️⃣ Perfiles de usuario (datos ampliables).
 *    Aquí se podrán añadir más campos en el futuro sin tocar la tabla usuarios.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfiles_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->unique()->constrained('usuarios')->cascadeOnDelete();
            $table->string('nombre')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('ruta_avatar')->nullable();
            $table->string('cargo')->nullable();
            $table->string('departamento')->nullable();
            $table->text('biografia')->nullable();
            $table->json('preferencias')->nullable(); // Configuraciones futuras (JSON)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfiles_usuario');
    }
};
