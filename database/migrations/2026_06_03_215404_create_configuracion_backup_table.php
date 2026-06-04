<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_backup', function (Blueprint $table) {
            $table->id();
            $table->enum('frecuencia', ['DESACTIVADO', 'SEMANAL', 'MENSUAL'])->default('DESACTIVADO');
            $table->tinyInteger('dia_semana')->nullable()->comment('0=Domingo,1=Lunes,...,6=Sabado');
            $table->tinyInteger('dia_mes')->nullable()->comment('1-31');
            $table->string('hora', 5)->default('02:00')->comment('HH:MM');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Fila singleton inicial
        DB::table('configuracion_backup')->insert([
            'frecuencia' => 'DESACTIVADO',
            'dia_semana' => null,
            'dia_mes'    => null,
            'hora'       => '02:00',
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_backup');
    }
};
