<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function profil () {
        return view('client.profil');
    }

    public function profil_infos () {
        return view('client.profilInfos');
    }

    public function historique () {
        return view('client.historique');
    }
}
