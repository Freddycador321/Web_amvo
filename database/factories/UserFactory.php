<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // contraseña por defecto
            'rol' => $this->faker->randomElement(['ADMIN','SECRETARIA','USER']),
            'estado' => $this->faker->randomElement(['activo','inactivo']),
            'remember_token' => Str::random(10),
        ];
    }
}
