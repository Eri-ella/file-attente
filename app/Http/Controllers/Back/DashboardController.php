<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorie;
use App\Models\ProfilUsager;
use Carbon\Carbon;

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

/**
 * Formulaire Ajouter / Modifier un service
 */
public function droiteModifierService($id = null)
{
    $categories = Categorie::orderBy('nom')->get();
    $profilUsagers = ProfilUsager::orderBy('nom')->get();

    $service = null;
    if ($id) {
        $service = Service::with(['categorie', 'profil_usager'])->findOrFail($id);
        // Convertir le time BDD en minutes pour le formulaire
        $service->duree = $this->timeToMinutes($service->duree);
    }

    return view('manager.connexionmanager.modifierservice', compact('categories', 'profilUsagers', 'service'));
}

/**
 * Traitement : AJOUT d'un service
 */
public function storeService(Request $request)
{
    $manager = Auth::guard('manager')->user();

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'critere_technique' => 'required|in:Gratuit,Payant',
        'duree' => 'required|integer|min:1', // ← minutes entières
        'cout' => 'required|integer|min:0',
        'categorie_id' => 'required|exists:categories,id',
        'profil_usager_id' => 'required|exists:profil_usagers,id',
    ]);

    $validated['duree'] = $this->minutesToTime($request->duree); // ← conversion
    $validated['mairie_id'] = $manager->mairie_id;

    Service::create($validated);

    return redirect()->route('manager.connexionmanager.droiteservice')
        ->with('success', 'Service ajouté avec succès.');
}

/**
 * Traitement : MODIFICATION d'un service
 */
public function updateService(Request $request, $id)
{
    $service = Service::findOrFail($id);
    $manager = Auth::guard('manager')->user();

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string',
        'critere_technique' => 'required|in:Gratuit,Payant',
        'duree' => 'required|integer|min:1',
        'cout' => 'required|integer|min:0',
        'categorie_id' => 'required|exists:categories,id',
        'profil_usager_id' => 'required|exists:profil_usagers,id',
    ]);

    $validated['duree'] = $this->minutesToTime($request->duree);
    $validated['mairie_id'] = $manager->mairie_id;

    $service->update($validated);

    return redirect()->route('manager.connexionmanager.droiteservice')
        ->with('success', 'Service modifié avec succès.');
}
/**
 * Traitement : SUPPRESSION d'un service
 */
public function destroyService($id)
{
    $service = Service::findOrFail($id);
    $service->delete();

    return redirect()->route('manager.connexionmanager.droiteservice')
        ->with('success', 'Service supprimé avec succès.');
}

/**
 * Convertit un nombre de minutes en format TIME pour la BDD
 * Ex: 15 → "00:15:00", 90 → "01:30:00"
 */
private function minutesToTime(int $minutes): string
{
    $h = intdiv($minutes, 60);
    $m = $minutes % 60;
    return sprintf('%02d:%02d:00', $h, $m);
}

/**
 * Convertit un format TIME de la BDD en nombre de minutes
 * Ex: "00:15:00" → 15, "01:30:00" → 90
 */
private function timeToMinutes(string $time): int
{
    list($h, $m) = explode(':', $time);
    return ((int) $h * 60) + (int) $m;
}
}
