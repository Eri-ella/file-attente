<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mairie;
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
            'nom' => $this->faker->name(),
            'categorie' => $this->faker->randomElement(['État Civil & Citoyenneté', 'Foncier & Urbanisme', 'Économie & Commerce']),
            'profil_usager' => $this->faker->randomElement(['Particuliers', 'Entreprises']),
            'critere_technique' => $this->faker->randomElement(['Gratuit', 'Payant']),
            'duree' => $this->faker->numberbetween(10, 45),
            'cout' => $this->faker->numberbetween(500, 2000),
            
            'mairie_id' => Mairie::first()?->id ?? Mairie::factory(),
        ];
    }
}
