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
Schema::create('jugador_equipo_categoria', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('jugador_id');
    $table->unsignedBigInteger('equipo_id');
    $table->unsignedBigInteger('categoria_id');
    $table->date('fecha_inicio');
    $table->date('fecha_fin')->nullable();
    $table->timestamps();

    // Índice único con nombre corto
    $table->unique(
        ['jugador_id', 'equipo_id', 'categoria_id', 'fecha_inicio'],
        'jugador_equipo_cat_unique'
    );

    // Llaves foráneas
    $table->foreign('jugador_id')->references('id')->on('jugadores')->onDelete('cascade');
    $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
    $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugador_equipo_categoria');
    }
};
