<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnexionController extends Controller
{
    // ==========================
    // ADMINISTRATEUR
    // ==========================

    public function connexionAdmin()
    {
        return view('admin.connexionAdmin');
    }
    public function mdpAdmin()
    {
        return view('admin.mdpOublieAdmin');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Rappel : Laravel exige la clé 'password' ici pour faire sa magie
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/listeclient');
        }

        return back()->withErrors([
        'login_error' => 'Identifiant ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('connexionAdmin');
    }


    // ==========================
    // MANAGER
    // ==========================

       public function connexionManager()
    {
        return view('manager.pageManager');
    }
    public function mdpManager()
    {
        return view('manager.mdpOublieManager');
    }

    public function loginManager(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // CORRECTION 1 : Utilisation obligatoire de la clé anglaise 'password' pour Laravel
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('manager')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/connexionmanager');
        }

        return back()->withErrors([
            'login_error' => 'Identifiant ou mot de passe incorrect.',
        ]);
    }

    public function logoutManager(Request $request)
    {
        Auth::guard('manager')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('pageManager');
    }

}