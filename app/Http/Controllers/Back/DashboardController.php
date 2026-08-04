<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Manager;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // administrateur

    public function listClient(): View
    {
        return view('admin.listeclient.liste');
    }

    public function droiteClient(): View
    {
        return view('admin.listeclient.droitecli');
    }

    public function droiteManager(): View
    {
        return view('admin.listeclient.droitema');
    }

    public function droiteProfilAdmin(): View
    {
        return view('admin.listeclient.droitepro');
    }

    // manager

    public function connexionManager(): View
    {
        return view('manager.connexionmanager.connexionManager');
    }

        /**
     * Chargement dynamique du tableau de bord manager avec persistance et compteurs exacts
     */
    public function droiteTableau(): \Illuminate\View\View
    {
        // 1. TABLEAU DU HAUT : On récupère tous les TICKETS actifs (statut = 'en_cours')
        $ticketsEnCours = \App\Models\Ticket::where('statut', 'en_cours')
            ->with(['service', 'superClient'])
            ->orderBy('debut')
            ->orderBy('created_at')
            ->get();

        $fileEnCours = $ticketsEnCours->map(function ($ticket) {
            $res = new \stdClass();
            // ATTENTION : On stocke l'id du TICKET ici pour que le bouton Retirer puisse le supprimer
            $res->id = $ticket->id; 
            
            $res->ticket = new \stdClass();
            $res->ticket->numero = $ticket->numero;
            $res->ticket->debut = $ticket->debut ?? \Carbon\Carbon::parse($ticket->created_at)->format('H:i');
            $res->ticket->fin = $ticket->fin ?? (isset($ticket->debut)
                ? Ticket::calculerFin($ticket->debut, $ticket->service->duree ?? 0)
                : (isset($ticket->created_at)
                    ? Ticket::calculerFin(\Carbon\Carbon::parse($ticket->created_at)->format('H:i'), $ticket->service->duree ?? 0)
                    : '—'));
            
            $res->categorie = new \stdClass();
            $res->categorie->nom = $ticket->service->categorie->nom ?? 'Général';
            
            $res->user = new \stdClass();
            if ($ticket->superclient_id) {
                $res->user->name = $ticket->superClient->nom ?? 'Superclient';
                $res->user->role = 'superclient';
            } else {
                $res->user->name = $ticket->client_mail ?? 'Client Anonyme';
                $res->user->role = 'standard';
            }
            return $res;
        });

        // 2. TABLEAU DU BAS : Toutes les réservations sans ticket encore généré
        $clientsEnAttente = \App\Models\Reservation::with(['service', 'categorie', 'superClient', 'ticket'])
            ->whereDoesntHave('ticket')
            ->orderBy('date')
            ->orderBy('heure_souhaite')
            ->get();

                // 3. STATISTIQUES SYNCHRONISÉES AVEC L'AFFICHAGE REEL
        // CORRECTION : Compte le nombre exact de tickets actuellement "en_cours" (Tableau du HAUT)
        $ticketsEnCoursCount = \App\Models\Ticket::where('statut', 'en_cours')->count();
        
        // Compte le nombre exact de réservations en attente (Tableau du BAS)
        $ticketsEnAttenteCount = count($clientsEnAttente); 

        $statistiques = [
            ['valeur' => (string) $ticketsEnCoursCount, 'label' => "Tickets dans la file"], // Première case corrigée !
            ['valeur' => '—', 'label' => 'Attente moyenne'],
            ['valeur' => (string) $ticketsEnAttenteCount, 'label' => 'Tickets en attente'],
            ['valeur' => '—', 'label' => 'Décalages'], 
        ];


        return view('manager.connexionmanager.droitetableau', compact('fileEnCours', 'clientsEnAttente', 'statistiques'));
    }

    public function droiteProfil(): View
    {
        /** @var Manager $manager */
        $manager = Auth::guard('manager')->user();
        $mairie = $manager->mairie;

        if (!$mairie) {
            abort(404, 'Mairie introuvable.');
        }

        return view('manager.connexionmanager.droiteprofil', compact('mairie'));
    }

    public function updateProfil(Request $request): RedirectResponse
    {
        /** @var Manager $manager */
        $manager = Auth::guard('manager')->user();
        $mairie = $manager->mairie;

        if (!$mairie) {
            abort(404, 'Mairie introuvable.');
        }

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:50'],
            'mail' => ['required', 'email'],
            'heure_ouvert_matin' => ['required', 'date_format:H:i'],
            'heure_ouvert_soir' => ['required', 'date_format:H:i'],
            'heure_ferme_matin' => ['required', 'date_format:H:i'],
            'heure_ferme_soir' => ['required', 'date_format:H:i'],
        ]);

        $mairie->update($data);

        return redirect()->route('manager.connexionmanager.droiteprofil')->with('success', 'Profil de la mairie mis à jour avec succès');
    }

    public function deleteProfil(Request $request): RedirectResponse
    {
        /** @var Manager $manager */
        $manager = Auth::guard('manager')->user();

        // Supprimer le compte
        $manager->delete();

        // Déconnecter l'utilisateur
        Auth::guard('manager')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pageManager')->with('success', 'Votre compte a été supprimé');
    }

    public function droiteService(): View
    {
        $services = Service::with(['categorie', 'profil_usager'])->get();

        return view('manager.connexionmanager.droiteservice', ['services' => $services]);
    }

    public function droiteModifierService(): View
    {
        return view('manager.connexionmanager.modifierservice');
    }

    public function droiteFile(): View
    {
        return view('manager.connexionmanager.droitefile');
    }

        /**
     * Afficher la page avec les vrais profils usagers de la base de données
     */
    public function droiteUsager(): \Illuminate\View\View
    {
        // CORRECTION : On ajoute le 's' pour cibler la vraie table 'profil_usagers'
        $profils = \Illuminate\Support\Facades\DB::table('profil_usagers')->get();

        return view('manager.connexionmanager.droiteusager', compact('profils'));
    }

    public function droiteHistorique(): \Illuminate\View\View
    {
        $tickets = Ticket::with(['service', 'reservation.superClient', 'reservation.client', 'superClient'])
            ->orderByDesc('created_at')
            ->get();

        return view('manager.connexionmanager.droitehistorique', compact('tickets'));
    }

    public function droiteConnexion(): View
    {
        return view('manager.connexionmanager.droiteconnexion');
    }

    /**
     * Action AJAX : Créer un nouveau profil usager
     */
    public function storeUsager(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        $nomProfil = $request->json('nom') ?? $request->nom;

        // CORRECTION : On ajoute le 's' à la table
        $idGenere = \Illuminate\Support\Facades\DB::table('profil_usagers')->insertGetId([
            'nom'        => $nomProfil,
            'statut'     => 'actif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'profil'  => [
                'id'     => $idGenere,
                'nom'    => $nomProfil,
                'statut' => 'actif'
            ]
        ]);
    }

    /**
     * Action AJAX : Modifier le nom d'un profil usager existant
     */
    public function modifierNomUsager(\Illuminate\Http\Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        // CORRECTION : On ajoute le 's' à la table
        \Illuminate\Support\Facades\DB::table('profil_usagers')
            ->where('id', $id)
            ->update([
                'nom'        => $request->nom,
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Action AJAX : Basculer le statut entre actif et inactif
     */
    public function basculerStatutUsager(int $id): \Illuminate\Http\JsonResponse
    {
        // CORRECTION : On ajoute le 's' à la table
        $profil = \Illuminate\Support\Facades\DB::table('profil_usagers')->where('id', $id)->first();
        
        if (!$profil) {
            return response()->json(['success' => false, 'message' => 'Profil introuvable.'], 404);
        }

        $nouveauStatut = (strtolower($profil->statut) === 'actif') ? 'inactif' : 'actif';
        
        // CORRECTION : On ajoute le 's' à la table
        \Illuminate\Support\Facades\DB::table('profil_usagers')
            ->where('id', $id)
            ->update([
                'statut'     => $nouveauStatut,
                'updated_at' => now()
            ]);

        return response()->json([
            'success'        => true,
            'nouveau_statut' => $nouveauStatut
        ]);
    }
        /**
     * Traitement AJAX : Générer le ticket de réservation en arrière-plan (Ajouter à la file)
     */
    public function genererTicket(Request $request, int $id): JsonResponse
    {
        // 1. Trouver la réservation correspondante et charger le service
        $reservation = Reservation::with(['ticket', 'service'])->findOrFail($id);

        if ($reservation->ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Cette réservation est déjà dans la file.'
            ], 400);
        }

        $debut = $reservation->heure_souhaite
            ? \Carbon\Carbon::parse($reservation->heure_souhaite)
            : now();

        $fin = Ticket::calculerFin($debut->format('H:i'), $reservation->service->duree ?? 0);

        // 2. Création stricte avec les colonnes réelles de la table tickets
        $ticket = Ticket::create([
            'statut'         => 'en_cours',
            'superclient_id' => $reservation->superclient_id,
            'client_mail'    => $reservation->client_mail,
            'service_id'     => $reservation->service_id,
            'reservation_id' => $reservation->id,
            'debut'          => $debut->format('H:i'),
            'fin'            => $fin,
        ]);

        return response()->json([
            'success'       => true,
            'ticket_id'     => $ticket->id,
            'numero_ticket' => $ticket->numero,
        ]);
    }

    public function insererAuDessus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'client_mail' => ['required', 'email'],
            'date' => ['required', 'date'],
            'heure_souhaite' => ['required', 'date_format:H:i'],
        ]);

        $ticket = Ticket::with('service')->findOrFail($id);
        $service = $ticket->service;

        if (! $service) {
            return response()->json([
                'success' => false,
                'message' => 'Service introuvable pour ce ticket.'
            ], 404);
        }

        $date = $request->input('date');
        $heure = \Carbon\Carbon::parse($request->input('heure_souhaite'));
        $clientMail = $request->input('client_mail');

        if (Reservation::where('service_id', $service->id)
            ->where('date', $date)
            ->where('heure_souhaite', $heure->format('H:i'))
            ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Un client a déjà réservé ce créneau pour ce service.'
            ], 400);
        }

        $client = Client::firstOrCreate(['mail' => $clientMail]);

        $reservation = Reservation::create([
            'service_id' => $service->id,
            'date' => $date,
            'heure_souhaite' => $heure->format('H:i'),
            'superclient_id' => null,
            'client_mail' => $client->mail,
        ]);

        $fin = Ticket::calculerFin($heure->format('H:i'), $service->duree ?? 0);

        Ticket::create([
            'statut' => 'en_cours',
            'superclient_id' => null,
            'client_mail' => $client->mail,
            'service_id' => $service->id,
            'reservation_id' => $reservation->id,
            'debut' => $heure->format('H:i'),
            'fin' => $fin,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Le client a bien été inséré dans la file et enregistré en base.'
        ]);
    }

    /**
     * Traitement AJAX : Supprime le ticket pour faire redescendre le client en liste d'attente (Retirer de la file)
     */
    public function annulerTicket(int $id): JsonResponse
    {
        // 1. Trouver le ticket actif dans la file en cours
        $ticket = Ticket::findOrFail($id);
        
        // 2. Supprimer la ligne de la table 'tickets' pour libérer la réservation
        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Le client est retourné dans la liste d\'attente.'
        ]);
    }

    public function supprimerReservation(int $id): JsonResponse
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer une réservation qui est déjà en file.'
            ], 400);
        }

        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Réservation supprimée avec succès.'
        ]);
    }

    public function droiteCategorie(): \Illuminate\View\View
    {
        $categories = \Illuminate\Support\Facades\DB::table('categories')->get();

        return view('manager.connexionmanager.droitecategorie', compact('categories'));
    }

    public function storeCategorie(Request $request): JsonResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        $nomCategorie = $request->json('nom') ?? $request->nom;

        $idGenere = \Illuminate\Support\Facades\DB::table('categories')->insertGetId([
            'nom'        => $nomCategorie,
            'statut'     => 'actif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'categorie'  => [
                'id'     => $idGenere,
                'nom'    => $nomCategorie,
                'statut' => 'actif'
            ]
        ]);
    }

    public function modifierNomCategorie(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
        ]);

        \Illuminate\Support\Facades\DB::table('categories')
            ->where('id', $id)
            ->update([
                'nom'        => $request->nom,
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function basculerStatutCategorie(int $id): JsonResponse
    {
        $categorie = \Illuminate\Support\Facades\DB::table('categories')->where('id', $id)->first();
        
        if (!$categorie) {
            return response()->json(['success' => false, 'message' => 'Catégorie introuvable.'], 404);
        }

        $nouveauStatut = (strtolower($categorie->statut) === 'actif') ? 'inactif' : 'actif';

        \Illuminate\Support\Facades\DB::table('categories')
            ->where('id', $id)
            ->update([
                'statut'     => $nouveauStatut,
                'updated_at' => now()
            ]);

        return response()->json([
            'success'        => true,
            'nouveau_statut' => $nouveauStatut
        ]);
    }
} 

    

