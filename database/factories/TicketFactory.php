<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;
use App\Models\Superclient;
use App\Models\Client;

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
            $estSuperClient = $this->faker->boolean();

            return [
                'numero' => $this->faker->unique()->bothify('??-####'),
                'statut' => $this->faker->randomElement(['en_attente', 'en_cours', 'termine', 'annule']),
                'service_id' => \App\Models\Service::inRandomOrder()->first()?->id ?? \App\Models\Service::factory(),
                'superclient_id' => $estSuperClient ? (\App\Models\Superclient::inRandomOrder()->first()?->id ?? \App\Models\Superclient::factory()) : null,
                'client_mail' => !$estSuperClient ? (\App\Models\Client::inRandomOrder()->first()?->mail ?? \App\Models\Client::factory()) : null,
            ];
        }

}

