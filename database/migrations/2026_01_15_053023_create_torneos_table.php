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
    Schema::create('torneos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('descripcion')->nullable();
        $table->date('fecha_inicio');
        $table->date('fecha_fin');
        $table->string('lugar')->nullable();
        $table->enum('estado', ['ACTIVO','FINALIZADO','CANCELADO'])->default('ACTIVO');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('torneos');
    }
};
