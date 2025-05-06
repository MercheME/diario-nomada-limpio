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
        Schema::create('destinos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diario_id')->constrained()->onDelete('cascade');
            $table->string('nombre_destino');
            $table->string('ubicacion');
            $table->string('slug')->unique();

            // Fechas dentro del viaje
            $table->date('fecha_inicio_destino')->nullable();
            $table->date('fecha_final_destino')->nullable();

            // Información concreta del destino
            $table->string('alojamiento')->nullable();
            $table->text('personas_conocidas')->nullable();
            $table->text('relato')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinos');
    }
};
