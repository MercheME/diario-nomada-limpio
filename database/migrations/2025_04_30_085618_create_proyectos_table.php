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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion');
            $table->boolean('is_public')->default(true);
            $table->string('lugar');

            // Contacto
            $table->string('url_web')->nullable();
            $table->string('contacto_email')->nullable();
            $table->string('contacto_telefono')->nullable();
            $table->string('redes_sociales')->nullable();
            $table->json('etiquetas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
