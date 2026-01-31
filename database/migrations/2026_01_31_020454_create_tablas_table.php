<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tablas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('torneo_id');
            $table->unsignedBigInteger('equipo_id');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('rama_id');

            $table->integer('puntos')->default(0);
            $table->integer('partidos_jugados')->default(0);
            $table->integer('ganados')->default(0);
            $table->integer('perdidos')->default(0);
            $table->integer('sets_favor')->default(0);
            $table->integer('sets_contra')->default(0);

            $table->timestamps();

            $table->foreign('torneo_id')->references('id')->on('torneos')->onDelete('cascade');
            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('rama_id')->references('id')->on('ramas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablas');
    }
};
