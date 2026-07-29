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
        
        // On décide aléatoirement si la réservation appartient à un client classique ou un superclient
        $estSuperClient = $this->faker->boolean();

        return [
            'date' => $this->faker->date(),
            'heure_souhaite' => $this->faker->time(),

            // Si c'est un superclient, on crée un superclient_id, sinon on laisse NULL
            'superclient_id' => $estSuperClient ? Superclient::first()?->id ?? Superclient::factory() : null,

            // CORRECTION : Remplacement de client_id par client_mail
            // Si ce n'est pas un superclient, on lui attribue le mail d'un client classique, sinon NULL
            'client_mail' => !$estSuperClient ? Client::first()?->mail ?? Client::factory() : null,
        ];
    

        
    }
}
