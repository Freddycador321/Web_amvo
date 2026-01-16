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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();

            // FK a jugador_equipo_categoria
            $table->foreignId('jugador_equipo_categoria_id')
                  ->constrained('jugador_equipo_categoria')
                  ->cascadeOnDelete();

            // FK a torneos
            $table->foreignId('torneo_id')
                  ->constrained('torneos')
                  ->cascadeOnDelete();

            $table->timestamp('fecha_inscripcion')->useCurrent();

            $table->enum('estado', [
                'PENDIENTE',
                'CONFIRMADA',
                'CANCELADA'
            ])->default('PENDIENTE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
