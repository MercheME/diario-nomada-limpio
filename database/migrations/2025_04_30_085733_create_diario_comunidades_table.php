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
        Schema::create('diario_comunidades', function (Blueprint $table) {
            $table->foreignId('diario_id')->constrained('diarios')->onDelete('cascade');
            $table->foreignId('communidad_id')->constrained('comunidades')->onDelete('cascade');
            $table->unique(['diario_id', 'comunidad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diario_comunidades');
    }
};
