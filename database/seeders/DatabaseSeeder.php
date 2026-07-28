<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MairieSeeder;
use Database\Seeders\AdministrateurSeeder;
use Database\Seeders\ClientSeeder;
use Database\Seeders\NotificationSeeder;
use Database\Seeders\ManagerSeeder;
use Database\Seeders\SuperclientSeeder;
use Database\Seeders\TicketSeeder;
use Database\Seeders\ServiceSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
          $this->call([
        MairieSeeder::class,
        ManagerSeeder::class,
        AdministrateurSeeder::class,
        NotificationSeeder::class,
        ClientSeeder::class,
        SuperclientSeeder::class,
        ServiceSeeder::class,
        TicketSeeder::class,
        ]);
    }
}
