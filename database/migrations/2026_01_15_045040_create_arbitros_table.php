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
        $table->string('nombre');
        $table->string('apellido');
        $table->string('ci')->unique();
        $table->string('telefono', 20)->nullable();
        $table->string('email')->nullable();
        $table->foreignId('nivel_id')->constrained('niveles_arbitro')->onDelete('cascade');
        $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
        $table->string('foto');
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
