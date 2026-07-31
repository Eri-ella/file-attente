<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    // CORRECTION : On accepte le modèle Service en paramètre pour recevoir le bon élément cliqué
    public function show(Service $service) 
    {
        // On envoie la variable spécifique '$service' à la vue
        return view('client.service', compact('service'));
    }
}



