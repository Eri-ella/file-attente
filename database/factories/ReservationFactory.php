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
            $estSuperClient = $this->faker->boolean();

            return [
                'date' => $this->faker->date(),
                'heure_souhaite' => $this->faker->time(),
                'superclient_id' => $estSuperClient ? (\App\Models\Superclient::inRandomOrder()->first()?->id ?? \App\Models\Superclient::factory()) : null,
                'client_mail' => !$estSuperClient ? (\App\Models\Client::inRandomOrder()->first()?->mail ?? \App\Models\Client::factory()) : null,
            ];
        }

}
