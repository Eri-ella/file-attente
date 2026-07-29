<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        CategorieSeeder::class,
        ProfilUsagerSeeder::class,
        MairieSeeder::class,
        AdministrateurSeeder::class,
        ManagerSeeder::class,
        ClientSeeder::class,
        SuperclientSeeder::class,
        NotificationSeeder::class,
        ServiceSeeder::class,
        TicketSeeder::class,
        ReservationSeeder::class,
        ]);
    }
}
