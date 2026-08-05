<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MairieSeeder::class,
            CategorieSeeder::class,        // avec lettre
            ProfilUsagerSeeder::class,
            ServiceSeeder::class,          // 15 services
            SuperclientSeeder::class,
            ReservationSeeder::class,      // 15 réservations
            TicketSeeder::class,           // Crée des tickets liés aux réservations
        ]);
    }
}