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
    Schema::create('jugadores', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('apellido');
        $table->string('ci')->unique();
        $table->date('fecha_naci');
        $table->enum('rama', ['MASCULINO', 'FEMENINO']);
        $table->string('nacionalidad')->nullable();
        $table->string('direccion')->nullable();
        $table->string('telefono', 20)->nullable();
        $table->string('email')->nullable();
        $table->integer('altura_cm')->nullable();
        $table->integer('peso_kg')->nullable();
        $table->string('posicion')->nullable();
        $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
        $table->string('contacto_emergencia')->nullable();
        $table->string('telefono_emergencia', 20)->nullable();
        $table->string('foto')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugadores');
    }
};
