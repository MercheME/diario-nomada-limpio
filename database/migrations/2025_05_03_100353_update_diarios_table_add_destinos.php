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
        Schema::table('diarios', function (Blueprint $table) {
            $table->dropColumn(['latitud', 'longitud']);
            $table->json('destinos')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diarios', function (Blueprint $table) {
            // Si revertimos la migración, debemos restaurar las columnas 'latitud' y 'longitud'
            $table->decimal('latitud', 10, 8)->nullable()->after('descripcion');
            $table->decimal('longitud', 11, 8)->nullable()->after('latitud');

            // Restaurar la columna 'destinos' a su tipo original
            $table->string('destino')->nullable()->change();
        });
    }
};
