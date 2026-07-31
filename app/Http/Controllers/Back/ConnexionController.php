<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Administrateur;
use App\Models\Manager;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

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

    public function sendResetLinkAdmin(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::broker('admins')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Un lien de réinitialisation a été envoyé à cette adresse.')
            : back()->withErrors(['email' => 'Aucun compte administrateur trouvé avec cet email.']);
    }

    public function showResetFormAdmin(Request $request, string $token)
    {
        return view('admin.resetPassword', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPasswordAdmin(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Administrateur $admin, string $password) {
                $admin->forceFill(['mot_de_passe' => $password])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('connexionAdmin')->with('status', 'Mot de passe réinitialisé, vous pouvez vous connecter.')
            : back()->withErrors(['email' => __($status)]);
    }
    
    public function updateProfilAdmin(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:administrateurs,email,' . $admin->id],
            'numero' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $admin->fill([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'numero' => $data['numero'],
        ]);

        if (!empty($data['password'])) {
            $admin->mot_de_passe = Hash::make($data['password']);
        }

        $admin->save();

        return back()->with('status', 'Profil mis à jour avec succès.');
    }

    public function deleteAccountAdmin(Request $request)
    {
        $request->validate(['password' => ['required']]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->password, $admin->getAuthPassword())) {
            return back()->withErrors(['password' => 'Mot de passe incorrect.']);
        }

        Auth::guard('admin')->logout();
        $admin->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('connexionAdmin')->with('status', 'Votre compte a été supprimé.');
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
        return redirect()->to('/manager'); // ou route('pageManager')
    }

    public function sendResetLinkManager(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::broker('managers')->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Un lien de réinitialisation a été envoyé à cette adresse.')
            : back()->withErrors(['email' => 'Aucun compte manager trouvé avec cet email.']);
    }

    public function showResetFormManager(Request $request, string $token)
    {
        return view('manager.resetPassword', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPasswordManager(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $status = Password::broker('managers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Manager $manager, string $password) {
                // Pas de Hash::make ici, le mutateur s'en charge
                $manager->forceFill(['mot_de_passe' => $password])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('pageManager')->with('status', 'Mot de passe réinitialisé, vous pouvez vous connecter.')
            : back()->withErrors(['email' => __($status)]);
    }
    
    public function updateProfilManager(Request $request)
    {
        $manager = Auth::guard('manager')->user();

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:managers,email,' . $manager->id],
            'numero' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $manager->fill([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'numero' => $data['numero'],
        ]);

        if (!empty($data['password'])) {
            $manager->mot_de_passe = Hash::make($data['password']);
        }

        $manager->save();

        return back()->with('status', 'Profil mis à jour avec succès.');
    }

    public function deleteAccountManager(Request $request)
    {
        $request->validate(['password' => ['required']]);

        $manager = Auth::guard('manager')->user();

        if (!Hash::check($request->password, $manager->getAuthPassword())) {
            return response()->json(['errors' => ['password' => 'Mot de passe incorrect.']], 422);
        }

        Auth::guard('manager')->logout();
        $manager->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'redirect' => route('pageManager')
        ]);
    }
}