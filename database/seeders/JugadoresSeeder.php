<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JugadoresSeeder extends Seeder
{
    public function run(): void
    {
        // Posiciones de voleibol
        $posM = ['Armador', 'Opuesto', 'Punta', 'Central', 'Líbero', 'Receptor'];
        $posF = ['Armadora', 'Opuesta', 'Punta', 'Central', 'Líbero', 'Receptora'];

        /*
         * Equipos usados (id | club | cat | rama):
         *  15 San Martin        | 11 | 5  | 2  MASC
         *  16 Can Azul          | 27 | 6  | 2  MASC
         *  17 Can               | 27 | 2  | 2  MASC
         *  18 Sajama Primero    |  4 | 3  | 2  MASC
         *  19 Sajama Femenino   |  4 | 3  | 3  FEM
         *  20 Fénix A           |  5 | 2  | 2  MASC
         *  21 Fénix Juvenil     |  5 | 6  | 2  MASC
         *  22 Fénix Femenino    |  5 | 2  | 3  FEM
         *  23 Central Masculino |  6 | 4  | 2  MASC
         *  24 Central Femenino  |  6 | 4  | 3  FEM
         *  25 Cóndor            |  7 | 3  | 2  MASC
         *  26 Cóndor Femenino   |  7 | 3  | 3  FEM
         *  27 Juventud A        |  8 | 5  | 2  MASC
         *  28 Juventud Femenino |  8 | 5  | 3  FEM
         *  29 San José          |  9 | 4  | 2  MASC
         *  30 San José Femenino |  9 | 4  | 3  FEM
         *  31 Altiplano         | 10 | 3  | 2  MASC
         *  32 Altiplano F       | 10 | 3  | 3  FEM
         *  33 Estudiantes A     | 11 | 2  | 2  MASC
         *  34 Estudiantes F     | 11 | 2  | 3  FEM
         *  35 Municipal         | 12 | 3  | 2  MASC
         *  36 Municipal F       | 12 | 3  | 3  FEM
         *  37 Bolívar Andino    | 13 | 2  | 2  MASC
         *  38 Bolívar F         | 13 | 2  | 3  FEM
         *  39 Ferro             | 14 | 4  | 2  MASC
         *  40 Ferro Femenino    | 14 | 4  | 3  FEM
         *  41 Libertad          | 15 | 3  | 2  MASC
         *  42 Libertad F        | 15 | 3  | 3  FEM
         *  43 Aurora            | 16 | 5  | 2  MASC
         *  44 Aurora Femenino   | 16 | 5  | 3  FEM
         *  45 AVO Femenino      | 17 | 2  | 3  FEM
         *  46 AVO Masculino     | 17 | 2  | 2  MASC
         *  47 Titanes           | 18 | 4  | 2  MASC
         *  48 Titanes F         | 18 | 4  | 3  FEM
         *  49 UD Central        | 19 | 3  | 2  MASC
         *  50 UD Central F      | 19 | 3  | 3  FEM
         *  51 Nueva Gen         | 20 | 6  | 2  MASC
         *  52 Nueva Gen F       | 20 | 6  | 3  FEM
         *  53 Halcones          | 21 | 5  | 2  MASC
         *  54 Halcones F        | 21 | 5  | 3  FEM
         *  55 Nacional Senior   | 27 | 10 | 2  MASC
         *  56 Nacional Femenino | 27 | 2  | 3  FEM
         *
         * Formato: [nombre, apellido, ci, nacimiento, posicion, estado, equipo_id, club_id, cat_id, rama_id]
         */
        $jugadores = [
            // San Martin (15 | 11 | 5 | MASC)
            ['Carlos',    'Mamani Quispe',    '8542301', '2002-03-14', 'Armador',  'activo',    15, 11, 5, 2],
            ['Diego',     'Condori Flores',   '7831204', '2001-07-22', 'Central',  'activo',    15, 11, 5, 2],
            ['Roberto',   'Apaza Vargas',     '9014567', '2003-11-05', 'Punta',    'activo',    15, 11, 5, 2],
            ['Marcos',    'Huanca Choque',    '6723890', '2000-05-18', 'Líbero',   'activo',    15, 11, 5, 2],
            ['Luis',      'Tito García',      '8190234', '2002-09-30', 'Opuesto',  'activo',    15, 11, 5, 2],
            ['Juan',      'Poma Laime',       '7654321', '2001-01-12', 'Receptor', 'activo',    15, 11, 5, 2],

            // Can Azul (16 | 27 | 6 | MASC - Juvenil)
            ['Miguel',    'Villca Arce',      '9876543', '2007-04-20', 'Punta',    'activo',    16, 27, 6, 2],
            ['Rodrigo',   'Calla Nina',       '9234567', '2008-02-11', 'Central',  'activo',    16, 27, 6, 2],
            ['Gabriel',   'Ticona Ramos',     '9345678', '2007-09-03', 'Armador',  'activo',    16, 27, 6, 2],
            ['Alejandro', 'Machaca Limachi',  '9456789', '2008-06-25', 'Líbero',   'activo',    16, 27, 6, 2],
            ['Sebastián', 'Catari Mita',      '9567890', '2007-12-08', 'Opuesto',  'activo',    16, 27, 6, 2],

            // Can (17 | 27 | 2 | MASC - 1ra Honor)
            ['Fernando',  'Morales Cruz',     '5234789', '1995-06-17', 'Armador',  'activo',    17, 27, 2, 2],
            ['Gonzalo',   'Soria Álvarez',    '4987654', '1993-10-29', 'Central',  'activo',    17, 27, 2, 2],
            ['Álvaro',    'Romero Torres',    '5678901', '1996-03-07', 'Opuesto',  'activo',    17, 27, 2, 2],
            ['Ricardo',   'Gutiérrez Vega',   '4321098', '1991-08-14', 'Punta',    'activo',    17, 27, 2, 2],
            ['Eduardo',   'Castro Aguilar',   '5890123', '1997-01-23', 'Líbero',   'activo',    17, 27, 2, 2],

            // Sajama Primero (18 | 4 | 3 | MASC)
            ['Mauricio',  'Zenteno Bernal',   '7123456', '1999-05-04', 'Central',  'activo',    18, 4,  3, 2],
            ['Christian', 'Claros Delgado',   '7890123', '2000-11-16', 'Punta',    'activo',    18, 4,  3, 2],
            ['Pablo',     'Escobar Copa',     '6543210', '1998-07-28', 'Armador',  'activo',    18, 4,  3, 2],
            ['Andrés',    'Fernández Jiménez','7234567', '1999-02-09', '—',        'activo',    18, 4,  3, 2],
            ['Nicolás',   'Gómez Herrera',    '6890123', '1997-09-21', 'Opuesto',  'activo',    18, 4,  3, 2],

            // Sajama Femenino (19 | 4 | 3 | FEM)
            ['María',     'Mamani Flores',    '8001234', '2000-04-15', 'Armadora', 'activo',    19, 4,  3, 3],
            ['Lucía',     'Quispe Condori',   '8112345', '2001-08-27', 'Punta',    'activo',    19, 4,  3, 3],
            ['Valeria',   'García López',     '8223456', '2000-12-03', 'Central',  'activo',    19, 4,  3, 3],
            ['Patricia',  'Cruz Vargas',      '7789012', '1999-06-19', 'Líbero',   'activo',    19, 4,  3, 3],
            ['Carla',     'Morales Soria',    '8334567', '2001-03-11', 'Opuesta',  'activo',    19, 4,  3, 3],

            // Fénix A (20 | 5 | 2 | MASC - 1ra Honor)
            ['Victor',    'Callisaya Marca',  '4654321', '1990-02-14', 'Opuesto',  'activo',    20, 5,  2, 2],
            ['Ramiro',    'Aruquipa Paco',    '5098765', '1994-07-06', 'Central',  'activo',    20, 5,  2, 2],
            ['Wilson',    'Huanca Tito',      '5432109', '1996-11-18', 'Armador',  'activo',    20, 5,  2, 2],
            ['Efraín',    'Laime Calla',      '4876543', '1992-04-30', 'Punta',    'activo',    20, 5,  2, 2],

            // Fénix Femenino (22 | 5 | 2 | FEM)
            ['Sandra',    'Choque Álvarez',   '8445678', '2000-10-22', 'Punta',    'activo',    22, 5,  2, 3],
            ['Sofía',     'Ramos Romero',     '8556789', '2001-05-07', 'Central',  'activo',    22, 5,  2, 3],
            ['Daniela',   'Torres Gutiérrez', '7901234', '1999-01-14', 'Líbero',   'activo',    22, 5,  2, 3],
            ['Andrea',    'Vega Castro',      '8667890', '2002-07-26', 'Armadora', 'activo',    22, 5,  2, 3],

            // Central Masculino (23 | 6 | 4 | MASC)
            ['Iván',      'Aguilar Apaza',    '6987654', '1998-08-09', 'Punta',    'activo',    23, 6,  4, 2],
            ['Fidel',     'Nina Poma',        '7111234', '1999-12-21', 'Central',  'activo',    23, 6,  4, 2],
            ['Lenin',     'Villca Limachi',   '7222345', '2000-04-05', 'Armador',  'activo',    23, 6,  4, 2],
            ['Walter',    'Machaca Catari',   '6777888', '1997-09-17', 'Opuesto',  'activo',    23, 6,  4, 2],

            // Central Femenino (24 | 6 | 4 | FEM)
            ['Camila',    'López García',     '8778901', '2001-11-08', 'Punta',    'activo',    24, 6,  4, 3],
            ['Rosa',      'Pérez Cruz',       '8889012', '2002-03-20', 'Armadora', 'activo',    24, 6,  4, 3],
            ['Carmen',    'Vargas Morales',   '8090123', '2000-07-01', 'Central',  'activo',    24, 6,  4, 3],
            ['Elena',     'Soria Choque',     '8201234', '2001-10-13', 'Líbero',   'activo',    24, 6,  4, 3],

            // Cóndor (25 | 7 | 3 | MASC)
            ['Ángel',     'Mita Ticona',      '7333456', '1999-06-28', 'Opuesto',  'activo',    25, 7,  3, 2],
            ['Héctor',    'Zenteno Claros',   '7444567', '2000-01-15', 'Central',  'activo',    25, 7,  3, 2],
            ['Ronal',     'Bernal Copa',      '7555678', '2001-08-27', 'Armador',  'activo',    25, 7,  3, 2],
            ['Erwin',     'Delgado Escobar',  '6666789', '1997-03-09', 'Punta',    'activo',    25, 7,  3, 2],

            // Cóndor Femenino (26 | 7 | 3 | FEM)
            ['Natalia',   'Álvarez Ramos',    '8312345', '2001-05-14', 'Receptora','activo',    26, 7,  3, 3],
            ['Fernanda',  'Romero Torres',    '8423456', '2002-09-26', 'Punta',    'activo',    26, 7,  3, 3],
            ['Vanessa',   'Gutiérrez Vega',   '7988765', '1999-02-07', 'Central',  'activo',    26, 7,  3, 3],

            // Juventud A (27 | 8 | 5 | MASC)
            ['Franz',     'Fernández Gómez',  '7666789', '2001-11-19', 'Armador',  'activo',    27, 8,  5, 2],
            ['Jhonny',    'Herrera Jiménez',  '7777890', '2002-06-01', 'Opuesto',  'activo',    27, 8,  5, 2],
            ['Edwin',     'Marca Callisaya',  '6888901', '1998-10-13', 'Punta',    'activo',    27, 8,  5, 2],

            // Juventud Femenino (28 | 8 | 5 | FEM)
            ['Paola',     'Aruquipa Huanca',  '8534567', '2002-04-24', 'Armadora', 'activo',    28, 8,  5, 3],
            ['Verónica',  'Tito Laime',       '8645678', '2001-12-06', 'Punta',    'activo',    28, 8,  5, 3],
            ['Laura',     'Paco Calla',       '8756789', '2003-07-18', 'Líbero',   'activo',    28, 8,  5, 3],

            // San José (29 | 9 | 4 | MASC)
            ['Roger',     'Nina Villca',      '6999012', '1997-01-30', 'Central',  'activo',    29, 9,  4, 2],
            ['Bladimir',  'Machaca Limachi',  '7010123', '1999-08-11', 'Opuesto',  'activo',    29, 9,  4, 2],
            ['Saúl',      'Catari Mita',      '7121234', '2000-04-23', 'Armador',  'activo',    29, 9,  4, 2],

            // San José Femenino (30 | 9 | 4 | FEM)
            ['Gabriela',  'Cruz Vargas',      '8867890', '2002-02-14', 'Punta',    'activo',    30, 9,  4, 3],
            ['Claudia',   'Morales Soria',    '8978901', '2001-06-26', 'Central',  'activo',    30, 9,  4, 3],

            // Estudiantes A (33 | 11 | 2 | MASC - 1ra Honor)
            ['Nelson',    'Flores García',    '4567890', '1989-09-05', 'Central',  'activo',    33, 11, 2, 2],
            ['Emilio',    'López Pérez',      '4123456', '1988-04-17', 'Opuesto',  'activo',    33, 11, 2, 2],
            ['César',     'Choque Álvarez',   '4234567', '1990-11-29', 'Armador',  'activo',    33, 11, 2, 2],
            ['José',      'Ramos Romero',     '4345678', '1991-06-10', 'Punta',    'activo',    33, 11, 2, 2],

            // Estudiantes F (34 | 11 | 2 | FEM)
            ['Beatriz',   'Torres Gutiérrez', '5989012', '1994-03-22', 'Armadora', 'activo',    34, 11, 2, 3],
            ['Sonia',     'Vega Castro',      '6090123', '1995-10-04', 'Punta',    'activo',    34, 11, 2, 3],
            ['Rebeca',    'Aguilar Apaza',    '6201234', '1996-07-16', 'Central',  'activo',    34, 11, 2, 3],

            // Municipal (35 | 12 | 3 | MASC)
            ['Daniel',    'Nina Poma',        '7232345', '1999-05-07', 'Opuesto',  'activo',    35, 12, 3, 2],
            ['Mario',     'Villca Limachi',   '7343456', '2000-09-19', 'Armador',  'activo',    35, 12, 3, 2],
            ['Hugo',      'Machaca Catari',   '7454567', '2001-02-28', 'Central',  'activo',    35, 12, 3, 2],

            // Bolívar Andino (37 | 13 | 2 | MASC - 1ra Honor)
            ['Oscar',     'Ticona Zenteno',   '4456789', '1990-07-12', 'Punta',    'activo',    37, 13, 2, 2],
            ['Claudio',   'Bernal Claros',    '4567890', '1992-01-24', 'Líbero',   'activo',    37, 13, 2, 2],
            ['Antonio',   'Copa Delgado',     '4678901', '1993-08-05', 'Central',  'activo',    37, 13, 2, 2],

            // Bolívar F (38 | 13 | 2 | FEM)
            ['Nohely',    'Escobar Fernández','5690123', '1993-05-17', 'Receptora','activo',    38, 13, 2, 3],
            ['Shirley',   'Gómez Herrera',    '5801234', '1994-12-29', 'Punta',    'activo',    38, 13, 2, 3],
            ['Karol',     'Jiménez Marca',    '5912345', '1995-04-10', 'Armadora', 'activo',    38, 13, 2, 3],

            // Aurora (43 | 16 | 5 | MASC)
            ['Jorge',     'Callisaya Aruquipa','7565678','2002-10-02', 'Punta',    'activo',    43, 16, 5, 2],
            ['David',     'Paco Tito',        '7676789', '2001-03-14', 'Armador',  'activo',    43, 16, 5, 2],

            // Aurora Femenino (44 | 16 | 5 | FEM)
            ['Jenny',     'Calla Nina',       '8234567', '2001-08-26', 'Opuesta',  'activo',    44, 16, 5, 3],
            ['Yessica',   'Laime Poma',       '8345678', '2002-12-08', 'Punta',    'activo',    44, 16, 5, 3],

            // AVO Femenino (45 | 17 | 2 | FEM - 1ra Honor)
            ['Alejandra', 'Villca Arce',      '5543210', '1992-06-20', 'Central',  'activo',    45, 17, 2, 3],
            ['Nadia',     'Machaca Limachi',  '5654321', '1994-02-01', 'Armadora', 'activo',    45, 17, 2, 3],
            ['Karina',    'Catari Mita',      '5765432', '1995-09-13', 'Punta',    'activo',    45, 17, 2, 3],
            ['Tania',     'Ticona Zenteno',   '5876543', '1996-04-25', 'Líbero',   'activo',    45, 17, 2, 3],

            // AVO Masculino (46 | 17 | 2 | MASC - 1ra Honor)
            ['Jorge',     'Callisaya Marca',  '4789012', '1991-11-07', 'Opuesto',  'activo',    46, 17, 2, 2],
            ['Nelson',    'Aruquipa Paco',    '4890123', '1993-05-19', 'Central',  'activo',    46, 17, 2, 2],

            // Halcones (53 | 21 | 5 | MASC)
            ['Emilio',    'Huanca Tito',      '7787890', '2002-07-31', 'Armador',  'activo',    53, 21, 5, 2],
            ['César',     'Laime Calla',      '7898901', '2001-01-12', 'Punta',    'activo',    53, 21, 5, 2],

            // Nacional Senior (55 | 27 | 10 | MASC)
            ['Ramiro',    'Quispe Mamani',    '3210987', '1980-03-08', 'Central',  'activo',    55, 27, 10, 2],
            ['Fidel',     'Condori Flores',   '3456789', '1982-10-20', 'Opuesto',  'activo',    55, 27, 10, 2],
            ['Walter',    'García López',     '3567890', '1981-06-01', 'Armador',  'activo',    55, 27, 10, 2],

            // Nacional Femenino (56 | 27 | 2 | FEM)
            ['Ingrid',    'Pérez Cruz',       '6312345', '1996-08-12', 'Punta',    'activo',    56, 27, 2, 3],
            ['Viviana',   'Vargas Morales',   '6423456', '1997-03-24', 'Armadora', 'activo',    56, 27, 2, 3],
            ['Roxana',    'Soria Choque',     '6534567', '1995-11-05', 'Central',  'activo',    56, 27, 2, 3],
            ['Lorena',    'Álvarez Ramos',    '6645678', '1996-05-17', 'Líbero',   'activo',    56, 27, 2, 3],
            ['Susana',    'Romero Torres',    '6756789', '1997-12-29', 'Opuesta',  'activo',    56, 27, 2, 3],
        ];

        $now = now();
        $rows = [];
        foreach ($jugadores as [$nombre, $apellido, $ci, $nac, $pos, $estado, $eqId, $clubId, $catId, $ramaId]) {
            $rows[] = [
                'nombre'           => $nombre,
                'apellido'         => $apellido,
                'ci'               => $ci,
                'fecha_nacimiento' => $nac,
                'posicion'         => $pos === '—' ? null : $pos,
                'estado'           => $estado,
                'equipo_id'        => $eqId,
                'club_id'          => $clubId,
                'categoria_id'     => $catId,
                'rama_id'          => $ramaId,
                'foto'             => null,
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }

        DB::table('jugadores')->insert($rows);

        $this->command->info('✓ ' . count($rows) . ' jugadores insertados.');
    }
}
