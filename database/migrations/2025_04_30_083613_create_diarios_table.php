<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('contenido')->nullable();

            // Privacidad
            $table->boolean('is_public')->default(false);

            // Fechas del viaje
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();

            // Reflexiones globales del viaje
            $table->text('impacto_ambiental')->nullable();
            $table->text('impacto_cultural')->nullable();

            // Medios inspiradores
            $table->text('libros')->nullable();
            $table->text('musica')->nullable();
            $table->text('peliculas')->nullable();
            $table->text('documentales')->nullable();

            // Etiquetas del diario
            $table->json('etiquetas')->nullable();

            // Estado del diario
            $table->enum('estado', ['planificado', 'en_curso', 'realizado'])->default('planificado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diarios');
    }
};
