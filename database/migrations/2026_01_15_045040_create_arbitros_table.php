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
        Schema::create('arbitros', function (Blueprint $table) {
            $table->id();
            
            // Información personal
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('ci')->unique()->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('foto')->nullable(); // Foto del árbitro

            // Nivel de arbitraje (estático)
            $table->enum('nivel', ['NIVEL 1','NIVEL 2','NIVEL 3','NIVEL 4','NIVEL 5'])->default('NIVEL 1');

            // Estado y observaciones
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arbitros');
    }
};
