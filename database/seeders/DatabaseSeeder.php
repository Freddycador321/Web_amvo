<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Club;
use App\Models\Categoria;
use App\Models\Rama;
use App\Models\Entrenador;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Torneo;
use App\Models\TorneoEquipo;
use App\Models\Partido;
use App\Models\HistorialJugador;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------
        // USUARIOS
        // ---------------------------
        // User::firstOrCreate(
        //     ['email' => 'admin@example.com'],
        //     [
        //         'nombre' => 'Freddy',
        //         'apellido' => 'Achu',
        //         'ci' => '0000003',
        //         'password' => Hash::make('admin'),
        //         'rol' => 'ADMIN',
        //         'estado' => 'ACTIVO'
        //     ]
        // );
        
        // Jugador::firstOrCreate(
        //     [
        //         'nombre' => 'Juan',
        //         'apellido' => 'Pepito',
        //         'fecha_nacimiento' => Carbon::create(2008, 1, 15),
        //         'club_id' => 'SAN MARTIN',
        //         'equipo_id' => 'SAN MARTIN',
        //         'categoria_id' => '1ra HONOR',
        //         'rama_id' => 'MASCULINO',
        //         'posicion' => 'central',
        //         'foto' => 'juan.jpg',
        //         'estado' => 'activo'
        //     ]
        // );
            //  Club::firstOrCreate(
            //      [
            //         'nombre' => 'SAN MARTIN',
            //         'nombre' => 'CAN'
            //      ]
            //  );
            //  Rama::firstOrCreate(['nombre' => 'MASCULINO']);
        // Categoria::firstOrCreate([
        //     'nombre' => '1ra HONOR',
        //     'edad_min' => 16,
        //     'edad_max' => 18,
        // ]);

       
        // $club = Club::firstOrCreate(['nombre' => 'SAN TO', 'sigla' => 'STO', 'logo'=>'logo.jpg']);
        // $rama = Rama::firstOrCreate(['nombre' => 'BOLI', 'sigla' => 'STO','logo'=>'logo1.jpg']);
        // $categoria = Categoria::firstOrCreate([
        //     'nombre' => '1ra ASCENSO',
        //     'edad_min' => 16,
        //     'edad_max' => 28,
        // ]);
        //         Equipo::firstOrCreate([
        //     'nombre' => 'SAN MARTIN',
        //     'club_id' => $club->id,
        //     'categoria_id' => $categoria->id,
        //     'rama_id' => $rama->id,
        // ]);
    }
}
