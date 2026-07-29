<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Superclient;
use App\Models\Client;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
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
                'heure' => $this->faker->time(),
                'superclient_id' => $estSuperClient ? (\App\Models\Superclient::inRandomOrder()->first()?->id ?? \App\Models\Superclient::factory()) : null,
                'client_mail' => !$estSuperClient ? (\App\Models\Client::inRandomOrder()->first()?->mail ?? \App\Models\Client::factory()) : null,
            ];
        }

}
