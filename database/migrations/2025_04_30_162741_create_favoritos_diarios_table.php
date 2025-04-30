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
        Schema::create('favoritos_diarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con el usuario
            $table->foreignId('diario_id')->constrained('diarios')->onDelete('cascade'); // Relación con el diario
            $table->timestamps();

            // Aseguramos que un usuario solo pueda marcar un diario como favorito una vez
            $table->unique(['user_id', 'diario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos_diarios');
    }
};
