<?php

namespace Database\Factories;

use App\Models\Mairie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mairie>
 */
class MairieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => 'Mairie de ' . fake()->city(),
            'adresse' => fake()->address(),
            'telephone' => fake()->numerify('01########'),
            'mail' => fake()->unique()->companyEmail(),
            'heure_ouvert_matin' => '08:30:00',
            'heure_ouvert_soir' => '14:00:00',
            'heure_ferme_matin' => '12:30:00',
            'heure_ferme_soir' => '17:00:00',

            
        ];
        
    }
}
