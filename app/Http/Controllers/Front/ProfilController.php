<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function profil () {
        $superclient = Auth::guard('superclient')->user();
        return view('client.profil', compact('superclient'));
    }

    public function profil_infos () {
        $superclient = Auth::guard('superclient')->user();
        return view('client.profilInfos', compact('superclient'));
    }

    public function historique () {
        $superclient = Auth::guard('superclient')->user();
        return view('client.historique', compact('superclient'));
    }
}
