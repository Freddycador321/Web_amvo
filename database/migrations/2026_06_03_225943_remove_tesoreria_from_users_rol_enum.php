<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Reasignar usuarios con rol TESORERIA a SECRETARIA antes de quitar el valor del enum
        DB::table('users')->where('rol', 'TESORERIA')->update(['rol' => 'SECRETARIA']);

        DB::statement("ALTER TABLE `users` MODIFY `rol` ENUM('ADMIN','SECRETARIA','ARBITRO') NOT NULL DEFAULT 'SECRETARIA'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `users` MODIFY `rol` ENUM('ADMIN','SECRETARIA','TESORERIA','ARBITRO') NOT NULL DEFAULT 'SECRETARIA'");
    }
};
