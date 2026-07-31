<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Manager;
use App\Models\Administrateur;
use App\Models\SuperClient;
use Illuminate\Support\Facades\Hash;

class HashExistingPasswordsSeeder extends Seeder
{
    public function run(): void
    {
        // Managers
        $managers = Manager::whereRaw('LENGTH(mot_de_passe) < 60 OR mot_de_passe NOT LIKE "$2y$%"')->get();
        foreach ($managers as $m) {
            $m->mot_de_passe = Hash::make($m->mot_de_passe);
            $m->save();
        }

        // Admins
        $admins = Administrateur::whereRaw('LENGTH(mot_de_passe) < 60 OR mot_de_passe NOT LIKE "$2y$%"')->get();
        foreach ($admins as $a) {
            $a->mot_de_passe = Hash::make($a->mot_de_passe);
            $a->save();
        }

        // SuperClients
        $clients = SuperClient::whereRaw('LENGTH(mot_de_passe) < 60 OR mot_de_passe NOT LIKE "$2y$%"')->get();
        foreach ($clients as $c) {
            $c->mot_de_passe = Hash::make($c->mot_de_passe);
            $c->save();
        }

        $this->command->info('Tous les mots de passe ont été hachés avec Bcrypt.');
    }
}