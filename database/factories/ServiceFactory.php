<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mairie;
use App\Models\Categorie;
use App\Models\ProfilUsager;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->sentence(),
            'description' => $this->faker->text(300),
            'critere_technique' => $this->faker->randomElement(['Gratuit', 'Payant']),
            'duree' => $this->faker->numberbetween(10, 45),
            'cout' => $this->faker->numberbetween(500, 2000),
            
            'profil_id' => ProfilUsager::first()?->id ?? ProfilUsager::factory(),
            'categorie_id' => Categorie::first()?->id ?? Categorie::factory(),
            'mairie_id' => Mairie::first()?->id ?? Mairie::factory(),
        ];
    }
}
