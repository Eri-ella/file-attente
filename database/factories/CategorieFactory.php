<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;

/**
 * @extends Factory<Model>
 */
class CategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->randomElement(['Foncier & Urbanisme', 'Économie & Commerce', 'État Civil & Citoyenneté']),
            'statut' => fake()->randomElement(['actif', 'inactif']),

        ];
    }
}
