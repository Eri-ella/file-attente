<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AcceuilController;
use App\Http\Controllers\Front\ServiceController;
use App\Http\Controllers\Front\ProfilController;

// Client

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


// Administrateur
Route::get('/admin', function () {
    return view('admin.connexionAdmin');
})->name('connexionAdmin');
 
// Client côté administrateur
Route::get('/listeclient', function () {
    return view('admin.listeclient.liste');
});
 

Route::get('/admin/listeclient/droitecli', function () {
    return view('admin.listeclient.droitecli');
})->name('admin.listeclient.droitecli');
 
Route::get('/admin/listeclient/droitema', function () {
    return view('admin.listeclient.droitema');
})->name('admin.listeclient.droitema');


// Manager
Route::get('/connexionmanager', function () {
    return view('manager.connexionmanager.connexionManager'); 
});

Route::get('/manager/connexionmanager/droitetableau', function () {
    return view('manager.connexionmanager.droitetableau');
})->name('manager.connexionmanager.droitetableau');

Route::get('/manager/connexionmanager/droiteprofil', function () {
    return view('manager.connexionmanager.droiteprofil');
})->name('manager.connexionmanager.droiteprofil');

Route::get('/manager/connexionmanager/droiteservice', function () {
    return view('manager.connexionmanager.droiteservice');
})->name('manager.connexionmanager.droiteservice');

Route::get('/manager/connexionmanager/droitefile', function () {
    return view('manager.connexionmanager.droitefile');
})->name('manager.connexionmanager.droitefile');

Route::get('/manager/connexionmanager/droiteusager', function () {
    return view('manager.connexionmanager.droiteusager');
})->name('manager.connexionmanager.droiteusager');

Route::get('/manager/connexionmanager/droitecategorie', function () {
    return view('manager.connexionmanager.droitecategorie');
})->name('manager.connexionmanager.droitecategorie');

Route::get('/manager/connexionmanager/droitehistorique', function () {
    return view('manager.connexionmanager.droitehistorique');
})->name('manager.connexionmanager.droitehistorique');

Route::get('/manager/connexionmanager/droiteconnexion', function () {
    return view('manager.connexionmanager.droiteconnexion');
})->name('manager.connexionmanager.droiteconnexion');

Route::get('/manager', function () {
    return view('manager.pageManager'); 
})->name('pageManager');

Route::get('/pageManager', function () {
    return view('pageManager');
})->name('pageManager');

Route::get('/manager/connexionmanager/service/modifier', function () {
    return view('manager.connexionmanager.modifierservice');
})->name('manager.connexionmanager.modifierservice');

