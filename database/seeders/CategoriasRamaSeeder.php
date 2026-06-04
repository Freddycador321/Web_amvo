<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasRamaSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Marcar categorías existentes como MASCULINO (rama_id = 2) ──────
        DB::table('categorias')->whereNull('rama_id')->update(['rama_id' => 2]);
        $this->command->info('✓ Categorías existentes asignadas a MASCULINO.');

        // ── 2. Crear categorías FEMENINO (rama_id = 3) ───────────────────────
        //    Mismos rangos de edad que los varones (el admin ajusta manualmente)
        //    El usuario indicó que Juvenil F es 15-18 (diferente a M 14-18 actual)
        $masculinas = DB::table('categorias')->where('rama_id', 2)->orderBy('id')->get();

        $now = now();
        $mapaFemenino = []; // nombre → id nuevo

        foreach ($masculinas as $cat) {
            // Ajuste conocido: Juvenil femenino tiene edad_max 18 (varones 18 actual → queda igual de momento)
            // El admin puede modificar manualmente cada rango desde la pantalla de Categorías
            $nuevoId = DB::table('categorias')->insertGetId([
                'nombre'      => $cat->nombre,
                'descripcion' => $cat->descripcion,
                'edad_min'    => $cat->edad_min,
                'edad_max'    => $cat->edad_max,
                'rama_id'     => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
            $mapaFemenino[$cat->id] = $nuevoId;
        }

        $this->command->info('✓ ' . count($mapaFemenino) . ' categorías FEMENINO creadas.');
        foreach ($mapaFemenino as $viejoId => $nuevoId) {
            $nombre = $masculinas->firstWhere('id', $viejoId)->nombre;
            $this->command->line("   M id={$viejoId} → F id={$nuevoId}  ({$nombre})");
        }

        // ── 3. Actualizar equipos FEMENINO (rama_id = 3) al nueva categoria F ──
        $equiposFemeninos = DB::table('equipos')->where('rama_id', 3)->get();
        $actualizados = 0;

        foreach ($equiposFemeninos as $equipo) {
            if (isset($mapaFemenino[$equipo->categoria_id])) {
                DB::table('equipos')
                    ->where('id', $equipo->id)
                    ->update(['categoria_id' => $mapaFemenino[$equipo->categoria_id]]);
                $actualizados++;
            }
        }

        $this->command->info("✓ {$actualizados} equipos femeninos reasignados a categoría F.");
    }
}
