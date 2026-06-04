<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquiposSeeder extends Seeder
{
    public function run(): void
    {
        // cat: 2=1ra Honor, 3=1ra Ascenso, 4=2da Ascenso, 5=3ra Ascenso, 6=Juvenil, 10=Senior
        // rama: 2=MASCULINO, 3=FEMENINO
        // Clubes disponibles: 4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,27

        $equipos = [
            // Real Sajama (4)
            ['nombre' => 'Sajama Primero',    'club_id' => 4,  'categoria_id' => 3,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Sajama Femenino',   'club_id' => 4,  'categoria_id' => 3,  'rama_id' => 3, 'estado' => 'activo'],

            // Club Deportivo Fénix (5)
            ['nombre' => 'Fénix A',           'club_id' => 5,  'categoria_id' => 2,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Fénix Juvenil',     'club_id' => 5,  'categoria_id' => 6,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Fénix Femenino',    'club_id' => 5,  'categoria_id' => 2,  'rama_id' => 3, 'estado' => 'activo'],

            // Unión Central (6)
            ['nombre' => 'Central Masculino', 'club_id' => 6,  'categoria_id' => 4,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Central Femenino',  'club_id' => 6,  'categoria_id' => 4,  'rama_id' => 3, 'estado' => 'activo'],

            // Deportivo Cóndor (7)
            ['nombre' => 'Cóndor',            'club_id' => 7,  'categoria_id' => 3,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Cóndor Femenino',   'club_id' => 7,  'categoria_id' => 3,  'rama_id' => 3, 'estado' => 'activo'],

            // Sport Juventud (8)
            ['nombre' => 'Juventud A',        'club_id' => 8,  'categoria_id' => 5,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Juventud Femenino', 'club_id' => 8,  'categoria_id' => 5,  'rama_id' => 3, 'estado' => 'activo'],

            // Club San José Junior (9)
            ['nombre' => 'San José',          'club_id' => 9,  'categoria_id' => 4,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'San José Femenino', 'club_id' => 9,  'categoria_id' => 4,  'rama_id' => 3, 'estado' => 'activo'],

            // Academia Deportiva Altiplano (10)
            ['nombre' => 'Altiplano',         'club_id' => 10, 'categoria_id' => 3,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Altiplano F',       'club_id' => 10, 'categoria_id' => 3,  'rama_id' => 3, 'estado' => 'activo'],

            // Club Estudiantes Oruro (11) — ya tiene San Martin
            ['nombre' => 'Estudiantes A',     'club_id' => 11, 'categoria_id' => 2,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Estudiantes F',     'club_id' => 11, 'categoria_id' => 2,  'rama_id' => 3, 'estado' => 'activo'],

            // Deportivo Municipal (12)
            ['nombre' => 'Municipal',         'club_id' => 12, 'categoria_id' => 3,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Municipal F',       'club_id' => 12, 'categoria_id' => 3,  'rama_id' => 3, 'estado' => 'activo'],

            // Club Bolívar Andino (13)
            ['nombre' => 'Bolívar Andino',    'club_id' => 13, 'categoria_id' => 2,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Bolívar F',         'club_id' => 13, 'categoria_id' => 2,  'rama_id' => 3, 'estado' => 'activo'],

            // Unión Ferroviaria (14)
            ['nombre' => 'Ferro',             'club_id' => 14, 'categoria_id' => 4,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Ferro Femenino',    'club_id' => 14, 'categoria_id' => 4,  'rama_id' => 3, 'estado' => 'activo'],

            // Club Deportivo Libertad (15)
            ['nombre' => 'Libertad',          'club_id' => 15, 'categoria_id' => 3,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Libertad F',        'club_id' => 15, 'categoria_id' => 3,  'rama_id' => 3, 'estado' => 'activo'],

            // Sport Aurora (16)
            ['nombre' => 'Aurora',            'club_id' => 16, 'categoria_id' => 5,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Aurora Femenino',   'club_id' => 16, 'categoria_id' => 5,  'rama_id' => 3, 'estado' => 'activo'],

            // Academia Voleibol Oruro (17)
            ['nombre' => 'AVO Femenino',      'club_id' => 17, 'categoria_id' => 2,  'rama_id' => 3, 'estado' => 'activo'],
            ['nombre' => 'AVO Masculino',     'club_id' => 17, 'categoria_id' => 2,  'rama_id' => 2, 'estado' => 'activo'],

            // Club Deportivo Titanes (18)
            ['nombre' => 'Titanes',           'club_id' => 18, 'categoria_id' => 4,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Titanes F',         'club_id' => 18, 'categoria_id' => 4,  'rama_id' => 3, 'estado' => 'activo'],

            // Unión Deportiva Central (19)
            ['nombre' => 'UD Central',        'club_id' => 19, 'categoria_id' => 3,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'UD Central F',      'club_id' => 19, 'categoria_id' => 3,  'rama_id' => 3, 'estado' => 'activo'],

            // Club Nueva Generación (20)
            ['nombre' => 'Nueva Gen',         'club_id' => 20, 'categoria_id' => 6,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Nueva Gen F',       'club_id' => 20, 'categoria_id' => 6,  'rama_id' => 3, 'estado' => 'activo'],

            // Deportivo Halcones (21)
            ['nombre' => 'Halcones',          'club_id' => 21, 'categoria_id' => 5,  'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Halcones F',        'club_id' => 21, 'categoria_id' => 5,  'rama_id' => 3, 'estado' => 'activo'],

            // Club Atlético Nacional (27) — ya tiene Can Azul y Can
            ['nombre' => 'Nacional Senior',   'club_id' => 27, 'categoria_id' => 10, 'rama_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Nacional Femenino', 'club_id' => 27, 'categoria_id' => 2,  'rama_id' => 3, 'estado' => 'activo'],
        ];

        $now = now();
        foreach ($equipos as &$e) {
            $e['entrenador_id'] = null;
            $e['created_at']    = $now;
            $e['updated_at']    = $now;
        }

        DB::table('equipos')->insert($equipos);

        $this->command->info('✓ ' . count($equipos) . ' equipos insertados.');
    }
}
