<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;
/**
 * @extends Factory<Categorie>
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
          
    
        
            'nom' => $this->faker->sentence(),
            'statut' => $this->faker->randomElement(['Actif', 'Inactif']),
    
            'service_id' => Service::first()?->id ?? Service::factory(),
        ];
    }
        
    
}
