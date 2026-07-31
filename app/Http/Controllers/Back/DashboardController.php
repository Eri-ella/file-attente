<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class DashboardController extends Controller
{
    // administrateur

    public function listClient () {
        return view('admin.listeclient.liste');
    }

    public function droiteClient () {
        return view('admin.listeclient.droitecli');
    }

    public function droiteManager () {
        return view('admin.listeclient.droitema');
    }

    public function droiteProfilAdmin () {
        return view('admin.listeclient.droitepro');
    }

    // manager

    public function connexionManager () {
        return view('manager.connexionmanager.connexionManager');
    }

    public function droiteTableau () {
        return view('manager.connexionmanager.droitetableau');
    }

    public function droiteProfil () {
        
        return view('manager.connexionmanager.droiteprofil');
    }

    public function droiteService () { 
        $services= Service::all();
        return view('manager.connexionmanager.droiteservice',['services'=>$services]);
    }

    public function droiteModifierService () {
        return view('manager.connexionmanager.modifierservice');
    }

    public function droiteFile () {
        return view('manager.connexionmanager.droitefile');
    }

    public function droiteUsager () {
        return view('manager.connexionmanager.droiteusager');
    }

    public function droiteCategorie () {
        return view('manager.connexionmanager.droitecategorie');
    }

    public function droiteHistorique () {
        return view('manager.connexionmanager.droitehistorique');
    }

    public function droiteConnexion () {
        return view('manager.connexionmanager.droiteconnexion');
    }
}
