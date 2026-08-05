<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Service;
use App\Models\Superclient;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        $service = Service::inRandomOrder()->first() ?? Service::factory()->create();
        $superclient = Superclient::inRandomOrder()->first() ?? Superclient::factory()->create();

        return [
            'service_id' => $service->id,
            'superclient_id' => $this->faker->boolean(70) ? $superclient->id : null,
            'client_mail' => $this->faker->optional(0.3)->email(),
            'date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'heure_souhaite' => $this->faker->optional()->time('H:i:s'),
            'nombre_tickets' => $this->faker->numberBetween(1, 3),
            'commentaire' => $this->faker->optional()->sentence(),
            'statut' => $this->faker->randomElement(['en_attente', 'confirmée', 'annulée']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}