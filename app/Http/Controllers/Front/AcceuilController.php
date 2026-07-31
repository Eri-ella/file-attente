<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Categorie;
use App\Models\ProfilUsager;

class AcceuilController extends Controller
{
    public function index () {
        $services = Service::all();

        return view('client.index', ['services' => $services]);
    }

    public function tousServices () {
        $services = Service::all();
        $categories = Categorie::with('services')->get();
        $profils = ProfilUsager::with('services')->get();
        
        return view('client.tousServices', [
            'services'=> $services, 
            'profils' => $profils,
            'categories' => $categories,]);
    }

    public function information () {
        return view('client.commentCaMarche');
    }

    public function ticket () {
        return view('client.ticket');
    }
}
