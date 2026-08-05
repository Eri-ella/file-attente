<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorie;
use App\Models\ProfilUsager;
use App\Models\Ticket;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // ================================================================
    //  ADMINISTRATEUR
    // ================================================================

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

    // ================================================================
    //  MANAGER — CONNEXION
    // ================================================================

    public function connexionManager () {
        return view('manager.connexionmanager.connexionManager');
    }

    // ================================================================
    //  TABLEAU DE BORD  (refait : tout passe par ->reservation)
    // ================================================================

    public function droiteTableau ()
    {
        $today = today();

        $ticketsAujourdhui = Ticket::whereDate('date_file', $today)->count();

        $ticketsEnAttenteCount = Ticket::whereDate('date_file', $today)
            ->where('statut', 'en_attente')
            ->count();

        $ticketsActifs = Ticket::whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'appele', 'en_cours', 'retard_decale'])
            ->with(['reservation.service.categorie', 'reservation.client', 'reservation.superClient'])
            ->get();

        $totalMinutes = 0;
        foreach ($ticketsActifs as $t) {
            $totalMinutes += $this->timeToMinutes($t->reservation->service->duree ?? '00:00:00');
        }
        $attenteMoyenne = $ticketsActifs->count() > 0
            ? round($totalMinutes / $ticketsActifs->count()) . ' min'
            : '0 min';

        $file = Ticket::with(['reservation.service.categorie', 'reservation.client', 'reservation.superClient'])
            ->whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'appele', 'en_cours', 'retard_decale'])
            ->orderBy('position')
            ->get();

        $clientsEnAttente = Ticket::with(['reservation.service.categorie', 'reservation.client', 'reservation.superClient'])
            ->whereDate('date_file', $today)
            ->where('statut', 'en_attente')
            ->orderBy('created_at')
            ->get();

        $decalages = Ticket::whereDate('date_file', $today)
            ->where('statut', 'retard_decale')
            ->sum('nombre_retards');

        return view('manager.connexionmanager.droitetableau', compact(
            'ticketsAujourdhui', 'attenteMoyenne', 'ticketsEnAttenteCount', 'decalages',
            'file', 'clientsEnAttente'
        ));
    }

    // ================================================================
    //  PROFIL MANAGER
    // ================================================================

    public function droiteProfil () {
        $manager = Auth::guard('manager')->user();
        $mairie = $manager?->mairie;

        if (!$mairie) {
            abort(404, 'Mairie introuvable pour ce manager.');
        }

        return view('manager.connexionmanager.droiteprofil', compact('mairie'));
    }

    public function updateProfil(Request $request)
    {
        $manager = Auth::guard('manager')->user();
        $mairie = $manager?->mairie;

        if (!$mairie) {
            abort(404, 'Mairie introuvable pour ce manager.');
        }

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

    // ================================================================
    //  SERVICES
    // ================================================================

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

    // ================================================================
    //  FILE D'ATTENTE (VUE DÉDIÉE)  —  refait via ->reservation
    // ================================================================

    public function droiteFile ()
    {
        $today = today();

        $ticketEnCours = Ticket::with(['reservation.service.categorie', 'reservation.client', 'reservation.superClient'])
            ->whereDate('date_file', $today)
            ->where('statut', 'en_cours')
            ->first();

        $tempsRestantSecondes = 0;
        if ($ticketEnCours) {
            $debut = Carbon::parse($ticketEnCours->heure_passage);
            $dureeMinutes = $this->timeToMinutes($ticketEnCours->reservation->service->duree ?? '00:00:00');
            $finEstimee = $debut->copy()->addMinutes($dureeMinutes);
            $tempsRestantSecondes = max(0, now()->diffInSeconds($finEstimee, false));
        }

        $ticketAppele = Ticket::with(['reservation.service.categorie', 'reservation.client', 'reservation.superClient'])
            ->whereDate('date_file', $today)
            ->where('statut', 'appele')
            ->first();

        $tempsRestantAppel = 0;
        if ($ticketAppele) {
            $debutAppel = Carbon::parse($ticketAppele->heure_passage);
            $finAppel = $debutAppel->copy()->addMinutes(5);
            $tempsRestantAppel = max(0, now()->diffInSeconds($finAppel, false));
        }

        $file = Ticket::with(['reservation.service.categorie', 'reservation.client', 'reservation.superClient'])
            ->whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'appele', 'en_cours', 'retard_decale'])
            ->orderBy('position')
            ->get();

        return view('manager.connexionmanager.droitefile', compact(
            'ticketEnCours', 'ticketAppele', 'file', 'tempsRestantSecondes', 'tempsRestantAppel'
        ));
    }

    // ================================================================
    //  AUTRES VUES MANAGER
    // ================================================================

    public function droiteUsager(): View
    {
        $profils = ProfilUsager::orderBy('nom')->get();
        return view('manager.connexionmanager.droiteusager', compact('profils'));
    }

    public function droiteCategorie(): View
    {
        $categories = Categorie::orderBy('nom')->get();
        return view('manager.connexionmanager.droitecategorie', compact('categories'));
    }

    public function droiteHistorique(): View
    {
        $tickets = Ticket::with(['reservation.service.categorie', 'reservation.client', 'reservation.superClient'])
            ->orderByDesc('created_at')
            ->get();

        return view('manager.connexionmanager.droitehistorique', compact('tickets'));
    }

    public function droiteConnexion(): View
    {
        return view('manager.connexionmanager.droiteconnexion');
    }

    // ================================================================
    //  HELPERS
    // ================================================================

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

    // ================================================================
    //  ACTIONS SUR LA FILE  —  refaites via ->reservation
    // ================================================================

    public function ajouterAFile(Request $request, Ticket $ticket)
    {
        if ($ticket->statut !== 'en_attente') {
            return back()->with('erreur', 'Ce ticket ne peut pas être ajouté à la file.');
        }

        $today = today();
        $dernierePosition = Ticket::whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'appele', 'en_cours', 'retard_decale'])
            ->max('position') ?? 0;

        $nouvellePosition = $dernierePosition + 1;
        $heureEstimee = now();

        $enCours = Ticket::with(['reservation.service'])
            ->whereDate('date_file', $today)
            ->where('statut', 'en_cours')
            ->first();

        if ($enCours) {
            $dureeEnCours = $this->timeToMinutes($enCours->reservation->service->duree ?? '00:00:00');
            $debutEnCours = Carbon::parse($enCours->heure_passage);
            $tempsEcoule = now()->diffInMinutes($debutEnCours);
            $tempsRestant = max(0, $dureeEnCours - $tempsEcoule);
            $heureEstimee->addMinutes($tempsRestant);
        }

        $ticketsEnFile = Ticket::with(['reservation.service'])
            ->whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'retard_decale'])
            ->orderBy('position')
            ->get();

        foreach ($ticketsEnFile as $t) {
            $heureEstimee->addMinutes($this->timeToMinutes($t->reservation->service->duree ?? '00:00:00'));
        }

        $ticket->update([
            'statut' => 'en_file',
            'position' => $nouvellePosition,
            'heure_estimee' => $heureEstimee->format('H:i:s'),
        ]);

        // NOTIFICATION : ticket validé et ajouté à la file
        if ($ticket->emailDestinataire) {
            $ticket->notify(new \App\Notifications\TicketValideNotification($ticket));
        }

        return back()->with('succes', 'Ticket ' . $ticket->numero . ' ajouté à la file.');
    }

    private function appelerAutomatiquement(): ?Ticket
    {
        $today = today();

        $suivant = Ticket::whereDate('date_file', $today)
            ->whereIn('statut', ['en_file', 'retard_decale'])
            ->orderBy('position')
            ->first();

        if ($suivant) {
            $suivant->update([
                'statut' => 'appele',
                'heure_passage' => now()->format('H:i:s'),
            ]);
            return $suivant;
        }

        return null;
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

        $suivant = $this->appelerAutomatiquement();

        if (!$suivant) {
            return back()->with('erreur', 'Aucun ticket en file d\'attente.');
        }

        return back()->with('succes', 'Ticket ' . $suivant->numero . ' appelé au guichet.');
    }

    public function demarrerTraitement(Request $request, Ticket $ticket)
    {
        if ($ticket->statut !== 'appele') {
            return back()->with('erreur', 'Ce ticket n\'est pas en attente d\'appel.');
        }

        $ticket->update([
            'statut' => 'en_cours',
            'heure_passage' => now()->format('H:i:s'),
        ]);

        return back()->with('succes', 'Traitement démarré pour ' . $ticket->numero);
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

        $suivant = $this->appelerAutomatiquement();

        if ($suivant) {
            return back()->with('succes', 'Ticket ' . $ticket->numero . ' terminé. ' . $suivant->numero . ' appelé automatiquement.');
        }

        return back()->with('succes', 'Ticket ' . $ticket->numero . ' terminé. File vide.');
    }

    public function noShow(Request $request, Ticket $ticket)
    {
        if ($ticket->statut !== 'appele') {
            return back()->with('erreur', 'Action impossible : ce ticket n\'est pas en attente de présentation.');
        }

        $today = today();

        if ($ticket->nombre_retards < 3) {
            $ticket->increment('nombre_retards');
            $ticket->update(['statut' => 'retard_decale']);

            // NOTIFICATION : avertissement de retard
            if ($ticket->emailDestinataire) {
                $ticket->notify(new \App\Notifications\TicketRetardeNotification($ticket));
            }

            $suivant = Ticket::whereDate('date_file', $today)
                ->whereIn('statut', ['en_file', 'retard_decale'])
                ->where('id', '!=', $ticket->id)
                ->orderBy('position')
                ->first();

            if ($suivant) {
                $tempPosition = $ticket->position;
                $ticket->update(['position' => $suivant->position]);
                $suivant->update(['position' => $tempPosition]);

                $suivant->update([
                    'statut' => 'appele',
                    'heure_passage' => now()->format('H:i:s'),
                ]);

                return back()->with('succes', 'Ticket ' . $ticket->numero . ' décalé (' . $ticket->nombre_retards . '/3). ' . $suivant->numero . ' appelé.');
            }

            return back()->with('succes', 'Ticket ' . $ticket->numero . ' décalé. Aucun suivant.');
        }

        $ticket->update(['statut' => 'annule']);

        // NOTIFICATION : exclusion définitive
        if ($ticket->emailDestinataire) {
            $ticket->notify(new \App\Notifications\TicketAnnuleNotification($ticket));
        }

        $suivant = $this->appelerAutomatiquement();

        if ($suivant) {
            return back()->with('succes', 'Ticket ' . $ticket->numero . ' annulé (3 absences). ' . $suivant->numero . ' appelé.');
        }

        return back()->with('succes', 'Ticket ' . $ticket->numero . ' annulé. File vide.');
    }

    public function retirerDeFile(Request $request, Ticket $ticket)
    {
        if (!in_array($ticket->statut, ['en_file', 'retard_decale'])) {
            return back()->with('erreur', 'Ce ticket ne peut pas être retiré de la file.');
        }

        $ticket->update([
            'statut' => 'en_attente',
            'position' => null,
            'heure_estimee' => null,
        ]);

        return back()->with('succes', 'Ticket retiré de la file.');
    }
}