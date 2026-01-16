<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'ci' => $this->faker->unique()->numberBetween(1000000, 99999999),
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // contraseña por defecto
            'rol' => $this->faker->randomElement(['ADMIN','SECRETARIA','USER']),
            'telefono' => $this->faker->phoneNumber,
            'estado' => $this->faker->randomElement(['ACTIVO','INACTIVO']),
            'remember_token' => Str::random(10),
        ];
    }

    // Para usuarios sin verificar email
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
