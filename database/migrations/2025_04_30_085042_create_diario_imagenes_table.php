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
        Schema::create('diario_imagenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diario_id')->constrained()->onDelete('cascade');
            $table->string('url_imagen');
            $table->text('descripcion')->nullable();
            $table->boolean('is_principal')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diario_imagenes');
    }
};
