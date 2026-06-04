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
        \Illuminate\Support\Facades\DB::statement(
            'ALTER TABLE `clubes` CHANGE `ciudad` `municipio` VARCHAR(100) NULL'
        );
    }

    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement(
            'ALTER TABLE `clubes` CHANGE `municipio` `ciudad` VARCHAR(100) NULL'
        );
    }
};
