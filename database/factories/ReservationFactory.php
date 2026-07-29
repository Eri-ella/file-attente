<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Superclient;
use App\Models\Client;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'heure_souhaite' => $this->faker->time(),

            'superclient_id' => Superclient::factory(),
            'client_id' => Client::factory(),
        ];
    }
}
