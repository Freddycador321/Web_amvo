<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE `clubes`
            MODIFY `sigla`             VARCHAR(255) NULL DEFAULT NULL,
            MODIFY `direccion`         VARCHAR(255) NULL DEFAULT NULL,
            MODIFY `telefono`          VARCHAR(255) NULL DEFAULT NULL,
            MODIFY `email`             VARCHAR(255) NULL DEFAULT NULL,
            MODIFY `presidente`        VARCHAR(255) NULL DEFAULT NULL,
            MODIFY `fecha_fundacion`   VARCHAR(255) NULL DEFAULT NULL,
            MODIFY `colores_oficiales` VARCHAR(255) NULL DEFAULT NULL,
            MODIFY `departamento`      VARCHAR(255) NULL DEFAULT NULL
        ');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `clubes`
            MODIFY `sigla`             VARCHAR(255) NOT NULL,
            MODIFY `direccion`         VARCHAR(255) NOT NULL,
            MODIFY `telefono`          VARCHAR(255) NOT NULL,
            MODIFY `email`             VARCHAR(255) NOT NULL,
            MODIFY `presidente`        VARCHAR(255) NOT NULL,
            MODIFY `fecha_fundacion`   VARCHAR(255) NOT NULL,
            MODIFY `colores_oficiales` VARCHAR(255) NOT NULL,
            MODIFY `departamento`      VARCHAR(255) NOT NULL
        ');
    }
};
