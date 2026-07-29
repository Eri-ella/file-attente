<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SuperClient;
use App\Models\Client;
use App\Models\Service;
/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero' => $this->faker->bothify('??-####'),
            'statut' => $this->faker->randomElement(['en_attente', 'en_cours', 'termine', 'annule']),
            
            'service_id' => Service::first()?->id ?? Service::factory(),

        ];
    }
}
