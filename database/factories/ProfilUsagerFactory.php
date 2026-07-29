<?php

namespace Database\Factories;

use App\Models\ProfilUsager;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

/**
 * @extends Factory<Model>
 */
class ProfilUsagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->randomElement(['tout public', 'entreprise']),
            'statut' => fake()->randomElement(['actif', 'inactif']),

        ];
    }
}
