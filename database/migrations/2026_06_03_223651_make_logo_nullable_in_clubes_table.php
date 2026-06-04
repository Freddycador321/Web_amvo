<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Usar SQL directo para máxima compatibilidad con MariaDB
        DB::statement('ALTER TABLE `clubes` MODIFY `logo` VARCHAR(255) NULL DEFAULT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `clubes` MODIFY `logo` VARCHAR(255) NOT NULL');
    }
};
