<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User::create([
        //     'nombre' => 'Admin',
        //     'apellido' => 'Sis',
        //     'ci' => '0000001',
        //     'email' => 'admin123',
        //     'password' => Hash::make('admin123'),
        //     'rol' => 'ADMIN',
        //     'estado' => 'ACTIVO'
        // ]);
    }
}
