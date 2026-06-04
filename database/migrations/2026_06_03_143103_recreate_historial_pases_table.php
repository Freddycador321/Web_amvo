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
        Schema::dropIfExists('historial_pases');

        Schema::create('historial_pases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jugador_id')->constrained('jugadores')->onDelete('cascade');

            // Valores anteriores (nullable: null en el primer registro)
            $table->unsignedBigInteger('club_anterior_id')->nullable();
            $table->unsignedBigInteger('equipo_anterior_id')->nullable();
            $table->unsignedBigInteger('categoria_anterior_id')->nullable();
            $table->unsignedBigInteger('rama_anterior_id')->nullable();

            $table->foreign('club_anterior_id')->references('id')->on('clubes')->nullOnDelete();
            $table->foreign('equipo_anterior_id')->references('id')->on('equipos')->nullOnDelete();
            $table->foreign('categoria_anterior_id')->references('id')->on('categorias')->nullOnDelete();
            $table->foreign('rama_anterior_id')->references('id')->on('ramas')->nullOnDelete();

            // Valores nuevos
            $table->foreignId('club_id')->constrained('clubes')->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('rama_id')->constrained('ramas')->onDelete('cascade');

            // Quién y cuándo
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->datetime('fecha_cambio');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_pases');
    }
};
