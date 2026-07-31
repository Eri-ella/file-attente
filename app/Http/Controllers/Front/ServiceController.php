<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Categorie;
use App\Models\ProfilUsager;


class ServiceController extends Controller
{
    // CORRECTION : Ajout du paramètre $id pour récupérer le service sélectionné
    public function show ($id) {
        // Récupère le service unique correspondant à l'URL ou renvoie une erreur 404 si introuvable
        $service = Service::findOrFail($id);
        
        $categories = Categorie::with('services')->get();
        $profils = ProfilUsager::with('services')->get();

        // CORRECTION : Transmission de la variable '$service' au singulier à la vue
        return view('client.service', [
            'service'    => $service, 
            'profils'    => $profils,
            'categories' => $categories,
        ]);
    }
}



