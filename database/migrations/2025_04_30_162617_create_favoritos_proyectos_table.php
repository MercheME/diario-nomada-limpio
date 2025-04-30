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
        Schema::create('favoritos_proyectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con el usuario
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade'); // Relación con el proyecto
            $table->timestamps();

            // Aseguramos que un usuario solo pueda marcar un proyecto como favorito una vez
            $table->unique(['user_id', 'proyecto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos_proyectos');
    }
};
