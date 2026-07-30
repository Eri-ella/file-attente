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
        $categories = Categorie::all();
        $profils = ProfilUsager::all();
        
        return view('client.tousServices', ['services' => $services], ['categories' => $categories], ['profils' => $profils]);
    }

    public function information () {
        return view('client.commentCaMarche');
    }

    public function connexion () {
        return view('client.connexion');
    }
    public function connexion_success(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'pass' => 'required|min:8',
        ]);

        return view('client.profil');
    }

    public function ticket () {
        return view('client.ticket');
    }

    public function inscription () {
        return view('client.inscription');
    }

    public function inscription_success(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required',
            'pass' => 'required|min:8',
        ]);

        return view('client.profil');
    }


    public function passe () {
        return view('client.mdpOublie');
    }
}
