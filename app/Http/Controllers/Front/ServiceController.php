<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Categorie;
use App\Models\ProfilUsager;


class ServiceController extends Controller
{
    public function show () {
        $services = Service::all();
        $categories = Categorie::with('services')->get();
        $profils = ProfilUsager::with('services')->get();

        return view('client.service', [
            'services'=> $services, 
            'profils' => $profils,
            'categories' => $categories,]);
    }

    public function reservation () {
        return view('client.reservation');
    }

}
