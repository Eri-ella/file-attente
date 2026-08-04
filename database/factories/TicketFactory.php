<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Service;
use App\Models\Superclient;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        $service = Service::inRandomOrder()->first() ?? Service::factory()->create();

        $superclientId = null;
        $clientMail = null;

        if ($estSuperClient) {
            $superclient = Superclient::inRandomOrder()->first() ?? Superclient::factory()->create();
            $superclientId = $superclient->id;
        } else {
            $client = Client::inRandomOrder()->first() ?? Client::factory()->create();
            $clientMail = $client->mail;
        }

        $lettre = chr(64 + ($service->id % 26 ?: 26));

        return [
            'numero' => $lettre . '-' . $this->faker->unique()->numerify('###'),
            'statut' => $this->faker->randomElement([
                'en_attente',
                'en_cours',
                'termine',
                'annule',
            ]),
            'service_id' => $service->id,
            'superclient_id' => $superclientId,
            'client_mail' => $clientMail,
        ];
    }
}