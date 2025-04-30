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
            $table->string('destino');
            $table->text('contenido');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->boolean('is_public')->default(true);
            $table->text('impacto_ambiental')->nullable();
            $table->text('impacto_cultural')->nullable();
            $table->text('aprendizajes')->nullable();
            $table->text('compromisos')->nullable();
            $table->integer('calificacion_sostenibilidad')->nullable();
            $table->text('libros')->nullable();
            $table->text('musica')->nullable();
            $table->text('peliculas')->nullable();
            $table->text('documentales')->nullable();
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
