<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class AcceuilController extends Controller
{
    public function index () {
        $services = Service::all();

        return view('client.index', ['services' => $services]);
    }

    public function tousServices () {
        return view('client.tousServices');
    }

    public function information () {
        return view('client.commentCaMarche');
    }

    public function connexion () {
        return view('client.connexion');
    }

    public function ticket () {
        return view('client.ticket');
    }

    public function inscription () {
        return view('client.inscription');
    }

    public function passe () {
        return view('client.mdpOublie');
    }
}
