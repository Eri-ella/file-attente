<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AcceuilController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\Front\ProfilController;


use  App\Http\Controllers\Back\ConnexionController;
use  App\Http\Controllers\Back\DashboardController;

// ***
// Client
// ***

// Client -> acceuil

Route::get('/', [AcceuilController::class, 'index'])->name('acceuil');
 
Route::get('/tousServices', [AcceuilController::class, 'tousServices'])->name('tousServices');

Route::get('/information', [AcceuilController::class, 'information'])->name('information');

Route::get('/connexion', [AcceuilController::class , 'connexion'])->name('connexion');
 
Route::get('/ticket', [AcceuilController::class, 'ticket'])->name('ticket');

Route::get('/inscription', [AcceuilController::class, 'inscription'])->name('inscription');

Route::get('/passe', [AcceuilController::class, 'passe'])->name('passe');

// Client -> service

Route::get('/service', [ServiceController::class, 'show'])->name('service');

Route::get('/reservation', [ServiceController::class, 'reservation'])->name('reservation');

// Client -> profil

Route::get('/profil', [ProfilController::class, 'profil'])->name('profil');

Route::get('/profiInfos', [ProfilController::class, 'profil_infos'])->name('profil_infos');

Route::get('/historique', [ProfilController::class, 'historique'])->name('historique');


// ***
// Administrateur 
// ***


Route::get('/admin', [ConnexionController::class, 'connexionAdmin'])->name('connexionAdmin');
 
// Client côté administrateur
Route::get('/listeclient', [DashboardController::class, 'listClient']);
 

Route::get('/admin/listeclient/droitecli', [DashboardController::class, 'droiteClient'])->name('admin.listeclient.droitecli');
 
Route::get('/admin/listeclient/droitema', [DashboardController::class, 'droiteManager'])->name('admin.listeclient.droitema');

// ***
// Manager
// ***

Route::get('/manager', [ConnexionController::class, 'connexionManager'])->name('pageManager');



Route::get('/manager/connexionmanager/service/modifier', [DashboardController::class, 'droiteModifierService'])->name('manager.connexionmanager.modifierservice');

Route::get('/connexionmanager', [DashboardController::class, 'connexionManager']);

Route::get('/manager/connexionmanager/droitetableau', [DashboardController::class, 'droiteTableau'])->name('manager.connexionmanager.droitetableau');

Route::get('/manager/connexionmanager/droiteprofil', [DashboardController::class, 'droiteProfil'])->name('manager.connexionmanager.droiteprofil');

Route::get('/manager/connexionmanager/droiteservice', [DashboardController::class, 'droiteService'])->name('manager.connexionmanager.droiteservice');

Route::get('/manager/connexionmanager/droitefile', [DashboardController::class, 'droiteFile'])->name('manager.connexionmanager.droitefile');

Route::get('/manager/connexionmanager/droiteusager', [DashboardController::class, 'droiteUsager'])->name('manager.connexionmanager.droiteusager');

Route::get('/manager/connexionmanager/droitecategorie', [DashboardController::class, 'droiteCategorie'])->name('manager.connexionmanager.droitecategorie');

Route::get('/manager/connexionmanager/droitehistorique', [DashboardController::class, 'droiteHistorique'])->name('manager.connexionmanager.droitehistorique');

Route::get('/manager/connexionmanager/droiteconnexion', [DashboardController::class, 'droiteConnexion'])->name('manager.connexionmanager.droiteconnexion');


