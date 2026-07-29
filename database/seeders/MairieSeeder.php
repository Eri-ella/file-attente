<?php

namespace Database\Seeders;

use App\Models\Mairie;
use Illuminate\Database\Seeder;

class MairieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mairie::factory()->count(0)->create();
    }
}
