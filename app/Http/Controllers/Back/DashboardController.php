<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorie;
use App\Models\ProfilUsager;
use App\Models\Ticket;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // ========== ADMINISTRATEUR ==========

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

    // ========== MANAGER ==========

    public function connexionManager () {
        return view('manager.connexionmanager.connexionManager');
    }

    // --- TABLEAU DE BORD ---

    public function droiteTableau ()
    {
        $today = today();

        $ticketsAujourdhui = Ticket::whereDate('date_file', $today)->count();

        $ticketsEnAttenteCount = Ticket::whereDate('date_file', $today)
            ->where('statut', 'en_attente')
            ->count();

        $ticketsActifs = Ticket::whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'appele', 'en_cours'])
            ->with('service')
            ->get();

        $totalMinutes = 0;
        foreach ($ticketsActifs as $t) {
            $totalMinutes += $this->timeToMinutes($t->service->duree ?? '00:00:00');
        }
        $attenteMoyenne = $ticketsActifs->count() > 0
            ? round($totalMinutes / $ticketsActifs->count()) . ' min'
            : '0 min';

        $file = Ticket::with('service', 'reservation')
            ->whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'appele', 'en_cours'])
            ->orderBy('position')
            ->get();

        $clientsEnAttente = Ticket::with('service', 'reservation')
            ->whereDate('date_file', $today)
            ->where('statut', 'en_attente')
            ->orderBy('created_at')
            ->get();

        $decalages = 0;

        return view('manager.connexionmanager.droitetableau', compact(
            'ticketsAujourdhui', 'attenteMoyenne', 'ticketsEnAttenteCount', 'decalages',
            'file', 'clientsEnAttente'
        ));
    }

    // --- PROFIL ---

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
        $manager->delete();
        Auth::guard('manager')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pageManager')->with('success', 'Votre compte a été supprimé');
    }

    // --- SERVICES ---

    public function droiteService () { 
        $services = Service::with(['categorie', 'profil_usager'])->get();
        return view('manager.connexionmanager.droiteservice',['services'=>$services]);
    } 

    public function droiteModifierService($id = null)
    {
        $categories = Categorie::orderBy('nom')->get();
        $profilUsagers = ProfilUsager::orderBy('nom')->get();
        $service = null;
        if ($id) {
            $service = Service::with(['categorie', 'profil_usager'])->findOrFail($id);
            $service->duree = $this->timeToMinutes($service->duree);
        }
        return view('manager.connexionmanager.modifierservice', compact('categories', 'profilUsagers', 'service'));
    }

    public function storeService(Request $request)
    {
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
        Service::create($validated);

        return redirect()->route('manager.connexionmanager.droiteservice')
            ->with('success', 'Service ajouté avec succès.');
    }

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

    public function destroyService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('manager.connexionmanager.droiteservice')
            ->with('success', 'Service supprimé avec succès.');
    }

    // --- FILE D'ATTENTE ---

    public function droiteFile ()
    {
        $today = today();

        $ticketEnCours = Ticket::with('service', 'reservation')
            ->whereDate('date_file', $today)
            ->where('statut', 'en_cours')
            ->first();

        $file = Ticket::with('service', 'reservation')
            ->whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'appele', 'en_cours'])
            ->orderBy('position')
            ->get();

        $tempsRestantSecondes = 0;
        if ($ticketEnCours) {
            $debut = Carbon::parse($ticketEnCours->heure_passage);
            $dureeMinutes = $this->timeToMinutes($ticketEnCours->service->duree ?? '00:00:00');
            $finEstimee = $debut->copy()->addMinutes($dureeMinutes);
            $tempsRestantSecondes = max(0, now()->diffInSeconds($finEstimee, false));
        }

        return view('manager.connexionmanager.droitefile', compact(
            'ticketEnCours', 'file', 'tempsRestantSecondes'
        ));
    }

    // --- ACTIONS SUR LA FILE ---

    public function ajouterAFile(Request $request, Ticket $ticket)
    {
        if ($ticket->statut !== 'en_attente') {
            return back()->with('erreur', 'Ce ticket ne peut pas être ajouté à la file.');
        }

        $today = today();
        $dernierePosition = Ticket::whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'appele', 'en_cours'])
            ->max('position') ?? 0;

        $nouvellePosition = $dernierePosition + 1;
        $heureEstimee = now();

        $enCours = Ticket::whereDate('date_file', $today)
            ->where('statut', 'en_cours')
            ->first();

        if ($enCours) {
            $dureeEnCours = $this->timeToMinutes($enCours->service->duree ?? '00:00:00');
            $debutEnCours = Carbon::parse($enCours->heure_passage);
            $tempsEcoule = now()->diffInMinutes($debutEnCours);
            $tempsRestant = max(0, $dureeEnCours - $tempsEcoule);
            $heureEstimee->addMinutes($tempsRestant);
        }

        $ticketsEnFile = Ticket::whereDate('date_file', $today)
            ->where('statut', 'en_file')
            ->orderBy('position')
            ->get();

        foreach ($ticketsEnFile as $t) {
            $heureEstimee->addMinutes($this->timeToMinutes($t->service->duree ?? '00:00:00'));
        }

        $ticket->update([
            'statut' => 'en_file',
            'position' => $nouvellePosition,
            'heure_estimee' => $heureEstimee->format('H:i:s'),
        ]);

        return back()->with('succes', 'Ticket ' . $ticket->numero . ' ajouté à la file.');
    }

    public function appelerSuivant(Request $request)
    {
        $today = today();

        $enCours = Ticket::whereDate('date_file', $today)
            ->where('statut', 'en_cours')
            ->first();

        if ($enCours) {
            $enCours->update([
                'statut' => 'termine',
                'heure_passage' => now()->format('H:i:s'),
            ]);
        }

        $suivant = Ticket::whereDate('date_file', $today)
            ->where('statut', 'en_file')
            ->orderBy('position')
            ->first();

        if (!$suivant) {
            return back()->with('erreur', 'Aucun ticket en file d\'attente.');
        }

        $suivant->update([
            'statut' => 'en_cours',
            'heure_passage' => now()->format('H:i:s'),
        ]);

        return back()->with('succes', 'Ticket ' . $suivant->numero . ' appelé au guichet.');
    }

    public function terminerTicket(Request $request, Ticket $ticket)
    {
        if ($ticket->statut !== 'en_cours') {
            return back()->with('erreur', 'Ce ticket n\'est pas en cours de traitement.');
        }

        $ticket->update([
            'statut' => 'termine',
            'heure_passage' => now()->format('H:i:s'),
        ]);

        return back()->with('succes', 'Ticket ' . $ticket->numero . ' terminé.');
    }

    public function noShow(Request $request, Ticket $ticket)
    {
        if (!in_array($ticket->statut, ['en_file', 'appele', 'en_cours'])) {
            return back()->with('erreur', 'Action impossible sur ce ticket.');
        }

        $ticket->update(['statut' => 'no_show']);

        return back()->with('succes', 'Ticket ' . $ticket->numero . ' marqué comme absent.');
    }

    public function retirerDeFile(Request $request, Ticket $ticket)
    {
        if ($ticket->statut !== 'en_file') {
            return back()->with('erreur', 'Ce ticket n\'est pas en file.');
        }

        $ticket->update([
            'statut' => 'en_attente',
            'position' => null,
            'heure_estimee' => null,
        ]);

        return back()->with('succes', 'Ticket retiré de la file.');
    }

    // --- AUTRES VUES MANAGER ---

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

    // --- HELPERS ---

    private function minutesToTime(int $minutes): string
    {
        $h = intdiv($minutes, 60);
        $m = $minutes % 60;
        return sprintf('%02d:%02d:00', $h, $m);
    }

    private function timeToMinutes(string $time): int
    {
        list($h, $m) = explode(':', $time);
        return ((int) $h * 60) + (int) $m;
    }
}