<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

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
        $manager = Auth::guard('manager')->user();
        return view('manager.connexionmanager.droiteprofil', compact('manager'));
    }

    public function updateProfil(Request $request)
    {
        $manager = Auth::guard('manager')->user();

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'numero' => ['required', 'string'],
        ]);

        $manager->update($data);

        return redirect()->route('manager.connexionmanager.droiteprofil')->with('success', 'Profil mis à jour avec succès');
    }

    public function deleteProfil(Request $request)
    {
        $manager = Auth::guard('manager')->user();

        // Supprimer le compte
        $manager->delete();

        // Déconnecter l'utilisateur
        Auth::guard('manager')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pageManager')->with('success', 'Votre compte a été supprimé');
    }

    public function droiteService () { 
        $services = Service::with(['categorie', 'profil_usager'])->get();
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
