<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Mairie;
use App\Models\Categorie;
use App\Models\ProfilUsager;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'critere_technique' => $this->faker->randomElement(['Gratuit', 'Payant']),
            'duree' => $this->faker->time('H:i:s', '00:30:00'),
            'cout' => $this->faker->numberBetween(0, 10000),
            'mairie_id' => Mairie::inRandomOrder()->first()?->id ?? Mairie::factory()->create()->id,
            'categorie_id' => Categorie::inRandomOrder()->first()?->id ?? Categorie::factory()->create()->id,
            'profil_usager_id' => ProfilUsager::inRandomOrder()->first()?->id ?? ProfilUsager::factory()->create()->id,
        ];
    }
}