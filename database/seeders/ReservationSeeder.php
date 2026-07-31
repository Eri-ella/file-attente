<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. On récupère les services créés juste avant par le ServiceSeeder
        $services = Service::all();

        // Sécurité si la table services est vide
        if ($services->isEmpty()) {
            return;
        }

        // 2. On crée 10 fausses réservations en leur donnant un service_id au hasard
        Reservation::factory()->count(10)->create([
            'service_id' => $services->random()->id,
        ]);
    }
}

