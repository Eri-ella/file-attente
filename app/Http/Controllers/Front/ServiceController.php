<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Categorie;
use App\Models\ProfilUsager;


class ServiceController extends Controller
{
    public function show(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $categories = Categorie::with('services')->get();
        $profils = ProfilUsager::with('services')->get();

        if ($request->ajax()) {
            return view('client.service-content', compact('service'));
        }

        $services = Service::all(); // ← ajouté : nécessaire pour le menu latéral (services-shell)

        return view('client.service', compact('service', 'services', 'categories', 'profils'));
    }
}



