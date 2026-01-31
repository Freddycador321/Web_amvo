<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('torneo_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipo_a_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('equipo_b_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            $table->foreignId('rama_id')->constrained()->onDelete('cascade');
            $table->date('fecha')->nullable();
            $table->integer('marcador_a')->default(0);
            $table->integer('marcador_b')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};
