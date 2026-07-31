<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SuperClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ConnexionClientController extends Controller
{
    // ================= CONNEXION =================

    public function connexion()
    {
        return view('client.connexion');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'pass' => ['required'],
        ]);

        $attempt = [
            'email' => $credentials['email'],
            'password' => $credentials['pass'],
        ];

        if (Auth::guard('superclient')->attempt($attempt)) {
            $request->session()->regenerate();
            return redirect()->intended(route('profil'));
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('superclient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('connexion');
    }

    // ================= INSCRIPTION =================

    public function inscription()
    {
        return view('client.inscription');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:superclients,email'],
            'telephone' => ['required', 'string'],
            'pass' => ['required', 'min:8'],
        ]);

        $superclient = SuperClient::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'age' => 0,
            'date_de_naissance' => now(),
            'sexe' => 'M',
            'email' => $data['email'],
            'mot_de_passe' => Hash::make($data['pass']),
            'numero' => $data['telephone'],
        ]);

        Auth::guard('superclient')->login($superclient);
        $request->session()->regenerate();

        return redirect()->route('profil');
    }

    // ================= MOT DE PASSE OUBLIÉ =================

    public function passe()
    {
        return view('client.mdpOublie');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::broker('superclients')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Un lien de réinitialisation a été envoyé à cette adresse.')
            : back()->withErrors(['email' => 'Aucun compte trouvé avec cet email.']);
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('client.resetPassword', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $status = Password::broker('superclients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (SuperClient $superclient, string $password) {
                $superclient->forceFill([
                    'mot_de_passe' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('connexion')->with('status', 'Mot de passe réinitialisé, vous pouvez vous connecter.')
            : back()->withErrors(['email' => __($status)]);
    }

    public function updateProfil(Request $request)
{
    $client = Auth::guard('superclient')->user();

    $data = $request->validate([
        'nom' => ['required', 'string', 'max:255'],
        'prenom' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:superclients,email,' . $client->id],
        'telephone' => ['required', 'string', 'max:20'],
        'pass' => ['nullable', 'min:8', 'confirmed'],
    ]);

    $client->fill([
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'email' => $data['email'],
        'numero' => $data['telephone'],
    ]);

    if (!empty($data['pass'])) {
        $client->mot_de_passe = Hash::make($data['pass']);
    }

    $client->save();

    return back()->with('status', 'Profil mis à jour avec succès.');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate(['pass' => ['required']]);

        $client = Auth::guard('superclient')->user();

        if (!Hash::check($request->pass, $client->getAuthPassword())) {
            return back()->withErrors(['pass' => 'Mot de passe incorrect.']);
        }

        Auth::guard('superclient')->logout();
        $client->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('connexion')->with('status', 'Votre compte a été supprimé.');
    }
}