<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();

        if ($services->isEmpty()) {
            $this->command->warn('Aucun service trouvé, création de services via ServiceSeeder...');
            $this->call(ServiceSeeder::class);
            $services = Service::all();
        }

        // Créer 15 réservations
        Reservation::factory()->count(15)->create();
    }
}