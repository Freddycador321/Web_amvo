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
    Schema::create('clubes', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('logo');
    $table->string('sigla');
    $table->string('direccion');
    $table->string('telefono');
    $table->string('email');
    $table->string('presidente');
    $table->string('fecha_fundacion');
    $table->string('colores_oficiales');
    $table->string('ciudad');
    $table->string('departamento');
    $table->enum('estado',['activo','inactivo'])->default('activo');
    $table->timestamps();
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubes');
    }
};
