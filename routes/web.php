<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AcceuilController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\Front\ProfilController;
use App\Http\Controllers\Front\ConnexionClientController;
use App\Http\Controllers\Front\TicketController;

// CORRECTION : Importation du bon chemin pour le contrôleur de réservation
use App\Http\Controllers\Front\ReservationController;

use App\Http\Controllers\Back\ConnexionController;
use App\Http\Controllers\Back\DashboardController;

// ***
// Client
// ***

// Client -> acceuil
Route::get('/', [AcceuilController::class, 'index'])->name('acceuil');
Route::get('/tousServices', [AcceuilController::class, 'tousServices'])->name('tousServices');
Route::get('/information', [AcceuilController::class, 'information'])->name('information');

Route::get('/ticket', [TicketController::class, 'index'])->name('ticket');
Route::post('/ticket/rechercher', [TicketController::class, 'rechercher'])->name('ticket.rechercher');
Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('ticket.show');
Route::patch('/ticket/{ticket}/annuler', [TicketController::class, 'annuler'])->name('ticket.annuler');

Route::get('/connexion', [ConnexionClientController::class, 'connexion'])->name('connexion');
Route::post('/connexion', [ConnexionClientController::class, 'login'])->name('connexion.store');
Route::post('/deconnexion', [ConnexionClientController::class, 'logout'])->name('logout');

Route::get('/inscription', [ConnexionClientController::class, 'inscription'])->name('inscription');
Route::post('/inscription', [ConnexionClientController::class, 'register'])->name('inscription.store');

Route::get('/passe', [ConnexionClientController::class, 'passe'])->name('passe');
Route::post('/passe', [ConnexionClientController::class, 'sendResetLink'])->name('passe.send');

Route::get('/reinitialiser-mot-de-passe/{token}', [ConnexionClientController::class, 'showResetForm'])->name('password.reset');
Route::post('/reinitialiser-mot-de-passe', [ConnexionClientController::class, 'resetPassword'])->name('password.update');

Route::post('/logout-client', [ConnexionClientController::class, 'logout'])
    ->middleware('auth:superclient')
    ->name('client.logout');

Route::middleware('auth:superclient')->group(function () {
    Route::get('/profil', [ProfilController::class, 'profil'])->name('profil');
    Route::get('/profiInfos', [ProfilController::class, 'profil_infos'])->name('profil_infos');
    Route::get('/historique', [ProfilController::class, 'historique'])->name('historique');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/delete', [ProfilController::class, 'delete'])->name('profil.delete');
});

// Client -> service
Route::get('/service/{service}', [ServiceController::class, 'show'])->name('service.show');

// Reservation
Route::get('/reservation/{service}', [ReservationController::class, 'create'])->name('reservation.create');
Route::post('/reservation/{service}', [ReservationController::class, 'store'])->name('reservation.store');

// ***
// Administrateur 
// ***
Route::get('/admin', [ConnexionController::class, 'connexionAdmin'])->name('connexionAdmin');
Route::post('/admin/login', [ConnexionController::class, 'loginAdmin'])->name('admin.login');
Route::get('/admin/motdepasse', [ConnexionController::class, 'mdpAdmin'])->name('admin.motdepasse');
 
Route::middleware('auth:admin')->group(function () {
    Route::post('/admin/logout', [ConnexionController::class, 'logoutAdmin'])->name('admin.logout');

    // ✅ PAGE PRINCIPALE APRÈS CONNEXION ADMIN (entête + menu + iframe)
    Route::get('/listeclient', [DashboardController::class, 'listClient'])->name('admin.listeclient');

    // ✅ CONTENU DE L'IFRAME (tableau des superclients)
    Route::get('/admin/listeclient/droitecli', [DashboardController::class, 'droiteClient'])->name('admin.listeclient.droitecli');

    // ✅ BOUTON SUSPENDRE / ACTIVER SUPERCLIENT (AJAX)
    Route::post('/admin/superclient/{id}/basculer-statut', [DashboardController::class, 'basculerStatutClient'])
        ->name('admin.superclient.basculerStatut');

    // ✅ CONTENU DE L'IFRAME (tableau des managers)
    Route::get('/admin/listeclient/droitema', [DashboardController::class, 'droiteManager'])->name('admin.listeclient.droitema');

    // ✅ BOUTON SUSPENDRE / ACTIVER MANAGER (AJAX)
    Route::post('/admin/manager/{id}/basculer-statut', [DashboardController::class, 'basculerStatutManager'])
        ->name('admin.manager.basculerStatut');

    Route::get('/admin/listeclient/droitepro', [DashboardController::class, 'droiteProfilAdmin'])->name('admin.listeclient.droitepro');

    Route::put('/admin/profil', [ConnexionController::class, 'updateProfilAdmin'])->name('admin.profil.update');
    Route::delete('/admin/profil', [ConnexionController::class, 'deleteAccountAdmin'])->name('admin.profil.delete');
});

Route::post('/admin/motdepasse', [ConnexionController::class, 'sendResetLinkAdmin'])->name('admin.motdepasse.send');
Route::get('/admin/reinitialiser-mot-de-passe/{token}', [ConnexionController::class, 'showResetFormAdmin'])->name('admin.password.reset');
Route::post('/admin/reinitialiser-mot-de-passe', [ConnexionController::class, 'resetPasswordAdmin'])->name('admin.password.update');


// ***
// Manager
// ***
Route::get('/manager', [ConnexionController::class, 'connexionManager'])->name('pageManager');
Route::post('/manager/login', [ConnexionController::class, 'loginManager'])->name('manager.login');
Route::get('/manager/motdepasse', [ConnexionController::class, 'mdpManager'])->name('manager.motdepasse');


Route::middleware('auth:manager')->group(function () {
    // Formulaire ajout (vide) / modification (pré-rempli)
    Route::get('/manager/connexionmanager/service/modifier/{id?}', [DashboardController::class, 'droiteModifierService'])
        ->name('manager.connexionmanager.modifierservice');

    // Traitement ajout
    Route::post('/manager/connexionmanager/service/store', [DashboardController::class, 'storeService'])
        ->name('manager.connexionmanager.service.store');

    // Traitement modification
    Route::put('/manager/connexionmanager/service/update/{id}', [DashboardController::class, 'updateService'])
        ->name('manager.connexionmanager.service.update');

    // Suppression
    Route::delete('/manager/connexionmanager/service/destroy/{id}', [DashboardController::class, 'destroyService'])
        ->name('manager.connexionmanager.service.destroy');

    Route::post('/manager/logout', [ConnexionController::class, 'logoutManager'])->name('manager.logout');

    // Route AJOUTÉE pour gérer la création du ticket (Tableau de Bord principal)
    Route::post('/manager/reservation/{id}/generer-ticket', [DashboardController::class, 'genererTicket']);

    Route::get('/connexionmanager', [DashboardController::class, 'connexionManager']);

    Route::get('/manager/connexionmanager/droitetableau', [DashboardController::class, 'droiteTableau'])->name('manager.connexionmanager.droitetableau');

    Route::get('/manager/connexionmanager/droiteprofil', [DashboardController::class, 'droiteProfil'])->name('manager.connexionmanager.droiteprofil');
    Route::post('/manager/profil/update', [DashboardController::class, 'updateProfil'])->name('manager.profil.update');
    Route::post('/manager/profil/delete', [DashboardController::class, 'deleteProfil'])->name('manager.profil.delete');

    Route::get('/manager/connexionmanager/droiteservice', [DashboardController::class, 'droiteService'])->name('manager.connexionmanager.droiteservice');

    Route::get('/manager/connexionmanager/droitefile', [DashboardController::class, 'droiteFile'])->name('manager.connexionmanager.droitefile');

    Route::get('/manager/connexionmanager/droiteusager', [DashboardController::class, 'droiteUsager'])->name('manager.connexionmanager.droiteusager');

    // CORRECTION : Routes indispensables ajoutées pour l'enregistrement, la modif et les statuts des usagers
    Route::post('/manager/profil-usager/store', [DashboardController::class, 'storeUsager']);
    Route::post('/manager/profil-usager/{id}/modifier', [DashboardController::class, 'modifierNomUsager']);
    Route::post('/manager/profil-usager/{id}/statut', [DashboardController::class, 'basculerStatutUsager']);

    Route::get('/manager/connexionmanager/droitecategorie', [DashboardController::class, 'droiteCategorie'])->name('manager.connexionmanager.droitecategorie');
    Route::post('/manager/categorie/store', [DashboardController::class, 'storeCategorie'])->name('manager.categorie.store');
    Route::post('/manager/categorie/{id}/modifier', [DashboardController::class, 'modifierNomCategorie'])->name('manager.categorie.modifier');
    Route::post('/manager/categorie/{id}/statut', [DashboardController::class, 'basculerStatutCategorie'])->name('manager.categorie.statut');

    Route::get('/manager/connexionmanager/droitehistorique', [DashboardController::class, 'droiteHistorique'])->name('manager.connexionmanager.droitehistorique');

    Route::get('/manager/connexionmanager/droiteconnexion', [DashboardController::class, 'droiteConnexion'])->name('manager.connexionmanager.droiteconnexion');

    Route::get('/manager/profil', function () {
        return view('manager.profil');
    })->name('manager.profil');

    Route::put('/manager/profil', [ConnexionController::class, 'updateProfilManager'])->name('manager.profil.update');
    Route::delete('/manager/profil', [ConnexionController::class, 'deleteAccountManager'])->name('manager.profil.delete');

    // Actions file d'attente
    Route::post('/manager/ticket/{ticket}/ajouter-file', [DashboardController::class, 'ajouterAFile'])->name('manager.ticket.ajouterFile');
    Route::post('/manager/ticket/appeler-suivant', [DashboardController::class, 'appelerSuivant'])->name('manager.ticket.appelerSuivant');
    Route::post('/manager/ticket/{ticket}/terminer', [DashboardController::class, 'terminerTicket'])->name('manager.ticket.terminer');
    Route::post('/manager/ticket/{ticket}/no-show', [DashboardController::class, 'noShow'])->name('manager.ticket.noShow');
    Route::post('/manager/ticket/{ticket}/retirer', [DashboardController::class, 'retirerDeFile'])->name('manager.ticket.retirer');

    Route::post('/manager/ticket/{ticket}/ajouter-file', [DashboardController::class, 'ajouterAFile'])->name('manager.ticket.ajouterFile');
    Route::post('/manager/ticket/appeler-suivant', [DashboardController::class, 'appelerSuivant'])->name('manager.ticket.appelerSuivant');
    Route::post('/manager/ticket/{ticket}/demarrer', [DashboardController::class, 'demarrerTraitement'])->name('manager.ticket.demarrer');
    Route::post('/manager/ticket/{ticket}/terminer', [DashboardController::class, 'terminerTicket'])->name('manager.ticket.terminer');
    Route::post('/manager/ticket/{ticket}/no-show', [DashboardController::class, 'noShow'])->name('manager.ticket.noShow');
    Route::post('/manager/ticket/{ticket}/retirer', [DashboardController::class, 'retirerDeFile'])->name('manager.ticket.retirer');
});

// Manager — mot de passe oublié
Route::post('/manager/motdepasse', [ConnexionController::class, 'sendResetLinkManager'])->name('manager.motdepasse.send');
Route::get('/manager/reinitialiser-mot-de-passe/{token}', [ConnexionController::class, 'showResetFormManager'])->name('manager.password.reset');
Route::post('/manager/reinitialiser-mot-de-passe', [ConnexionController::class, 'resetPasswordManager'])->name('manager.password.update');