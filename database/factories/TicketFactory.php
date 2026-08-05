<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        $reservation = Reservation::inRandomOrder()->first() ?? Reservation::factory()->create();
        $service = $reservation->service;
        
        // Générer une date aléatoire pour le ticket
        $dateFile = $this->faker->dateTimeBetween('-1 month', 'now');
        
        return [
            'reservation_id' => $reservation->id,
            'numero' => $this->generateTicketNumber($service, $dateFile),
            'statut' => $this->faker->randomElement([
                'en_attente', 'en_file', 'appele', 'en_cours',
                'termine', 'annule', 'no_show', 'retard_decale'
            ]),
            'position' => $this->faker->optional()->numberBetween(1, 30),
            'nombre_retards' => $this->faker->numberBetween(0, 3),
            'heure_estimee' => $this->faker->optional()->time('H:i:s'),
            'heure_passage' => $this->faker->optional()->time('H:i:s'),
            'date_file' => $dateFile,
            'created_at' => $dateFile,
            'updated_at' => $dateFile,
        ];
    }

    private function generateTicketNumber($service, $date): string
    {
        $lettre = $service->categorie->lettre ?? 'X';
        
        // Compter les tickets existants pour ce service et cette date
        $count = Ticket::whereHas('reservation', function($q) use ($service) {
            $q->where('service_id', $service->id);
        })->whereDate('date_file', $date)->count() + 1;
        
        return $lettre . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}