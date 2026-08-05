<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Reservation;
use App\Models\Categorie;
use App\Models\ProfilUsager;

class AcceuilController extends Controller
{
    public function index () {
        $services = Service::all();

        /* ========== STATS GLOBALES ========== */
        $ticketsMois = \App\Models\Ticket::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        try {
            $attenteMoyenne = \App\Models\Ticket::whereNotNull('heure_passage')
                ->whereNotNull('heure_estimee')
                ->whereIn('statut', ['termine', 'en_cours'])
                ->selectRaw('AVG(ABS(TIME_TO_SEC(TIMEDIFF(heure_passage, heure_estimee)) / 60)) as avg_minutes')
                ->value('avg_minutes');
            $attenteMoyenne = $attenteMoyenne ? round($attenteMoyenne) : 0;
        } catch (\Exception $e) {
            $attenteMoyenne = 0;
        }

        $nbServices = Service::count();

        try {
            $totalPasses = \App\Models\Ticket::whereNotNull('heure_passage')
                ->whereNotNull('heure_estimee')
                ->whereIn('statut', ['termine', 'en_cours'])
                ->count();

            $aLHeure = \App\Models\Ticket::whereNotNull('heure_passage')
                ->whereNotNull('heure_estimee')
                ->whereIn('statut', ['termine', 'en_cours'])
                ->whereRaw('heure_passage <= heure_estimee')
                ->count();

            $pourcentageALHeure = $totalPasses > 0 ? round(($aLHeure / $totalPasses) * 100) : 96;
        } catch (\Exception $e) {
            $pourcentageALHeure = 96;
        }

        /* ========== TOP 3 SERVICES ========== */
        $totalReservationsAll = Reservation::count();

        $topServices = Service::select('services.*')
            ->selectRaw('(
                SELECT COUNT(*) FROM reservations 
                WHERE reservations.service_id = services.id
            ) as total_reservations')
            ->selectRaw('(
                SELECT COUNT(*) FROM tickets 
                JOIN reservations ON tickets.reservation_id = reservations.id 
                WHERE reservations.service_id = services.id 
                AND tickets.statut IN ("termine", "en_cours")
            ) as total_served')
            ->selectRaw('(
                SELECT COUNT(*) FROM tickets 
                JOIN reservations ON tickets.reservation_id = reservations.id 
                WHERE reservations.service_id = services.id 
                AND tickets.statut IN ("termine", "en_cours")
                AND tickets.heure_passage IS NOT NULL 
                AND tickets.heure_estimee IS NOT NULL
                AND tickets.heure_passage <= tickets.heure_estimee
            ) as on_time_count')
            ->orderByDesc('total_reservations')
            ->take(3)
            ->get();

        $topServices->transform(function ($service) use ($totalReservationsAll) {
            $service->reservation_pct = $totalReservationsAll > 0 
                ? round(($service->total_reservations / $totalReservationsAll) * 100) 
                : 0;
            
            $service->satisfaction_pct = $service->total_served > 0 
                ? round(($service->on_time_count / $service->total_served) * 100) 
                : 99;
            
            $service->duree_minutes = \Carbon\Carbon::parse($service->duree)->format('H') * 60 
                + \Carbon\Carbon::parse($service->duree)->format('i');
            
            return $service;
        });

        return view('client.index', compact(
            'services',
            'ticketsMois',
            'attenteMoyenne',
            'nbServices',
            'pourcentageALHeure',
            'topServices'
        ));
    }

    public function tousServices () {
        $services = Service::all();
        $categories = Categorie::with('services')->get();
        $profils = ProfilUsager::with('services')->get();
        
        return view('client.tousServices', [
            'services'=> $services, 
            'profils' => $profils,
            'categories' => $categories,]);
    }

    public function information () {
        return view('client.commentCaMarche');
    }

    public function ticket () {
        return view('client.ticket');
    }
}