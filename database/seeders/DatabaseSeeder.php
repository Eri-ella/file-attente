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
<<<<<<< HEAD
=======
        ManagerSeeder::class,
>>>>>>> 5c540678827b9ce02e7fa85008a4dc2e1573d8f3
        ClientSeeder::class,
        SuperclientSeeder::class,
        NotificationSeeder::class,
        ServiceSeeder::class,
        TicketSeeder::class,
        NotificationSeeder::class,
        ReservationSeeder::class,
        ]);
    }
}
