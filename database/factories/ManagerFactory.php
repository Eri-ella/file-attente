<?php

namespace Database\Factories;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Manager>
 */
class ManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'age' => fake()->numberBetween(25, 60),
            'date_de_naissance' => fake()->date(),
            'sexe' => fake()->randomElement(['M', 'F']),
            'email' => fake()->unique()->safeEmail(),
            'mot_de_passe' => Hash::make('password'), 
            'numero' => fake()->numerify('01########'),
        ];
    }
}
