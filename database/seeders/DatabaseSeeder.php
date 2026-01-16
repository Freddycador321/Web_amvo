<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Arbitro;
use App\Models\Categoria;
use App\Models\Club;
use App\Models\Equipo;
use App\Models\Inscripcion;
use App\Models\Jugador;
use App\Models\JugadorEquipoCategoria;
use App\Models\NivelArbitro;
use App\Models\Torneo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    //     NivelArbitro::factory(5)->create();
    //     Arbitro::factory(20)->create();
    //    Jugador::factory(20)->create();    
       
    // // Usuario admin
    //     User::firstOrCreate(
    //         ['email' => 'admin@example.com'],
    //         [
    //             'nombre' => 'Freddy',
    //             'apellido' => 'Ahu',
    //             'ci' => '0000003',
    //             'password' => Hash::make('admin'),
    //             'rol' => 'ADMIN',
    //             'estado' => 'ACTIVO'
    //         ]
    //     );

        // // Jugador 1
        // Jugador::firstOrCreate(
        //     ['ci'=>'12837080'],
        //     [
        //         'nombre'=> 'Freddy',
        //         'apellido'=> 'Achu',
        //         'fecha_naci'=> '1995-07-19',
        //         'rama' => 'MASCULINO',
        //         'nacionalidad'=>'Boliviano',
        //         'direccion'=>'C Taboada N 832',
        //         'telefono'=>'65422832',
        //         'email'=>'freddycador321@example.com',
        //         'altura_cm'=>'170',
        //         'peso_kg'=>'70',
        //         'posicion'=>'punta-nexo',
        //         'estado'=>'ACTIVO',
        //         'contacto_emergencia'=>'25245689',
        //         'telefono_emergencia'=>'25247185',
        //         'foto'=>'foto.jpg'
        //     ]
        // );

        // // Jugador 2
        // Jugador::firstOrCreate(
        //     ['ci'=>'12837'],
        //     [
        //         'nombre'=> 'Juan',
        //         'apellido'=> 'Pepito',
        //         'fecha_naci'=> '1995-07-19',
        //         'rama' => 'MASCULINO',
        //         'nacionalidad'=>'Boliviano',
        //         'direccion'=>'C Taboada N 832',
        //         'telefono'=>'65422833',
        //         'email'=>'juan@example.com',
        //         'altura_cm'=>'170',
        //         'peso_kg'=>'70',
        //         'posicion'=>'punta-nexo',
        //         'estado'=>'ACTIVO',
        //         'contacto_emergencia'=>'25245689',
        //         'telefono_emergencia'=>'25247185',
        //         'foto'=>'foto.jpg'
        //     ]
        // );
    }
}