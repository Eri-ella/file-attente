<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SuperClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function profil(): View
    {
        /** @var SuperClient $superclient */
        $superclient = Auth::guard('superclient')->user();

        return view('client.profil', compact('superclient'));
    }

    public function profil_infos(): View
    {
        /** @var SuperClient $superclient */
        $superclient = Auth::guard('superclient')->user();

        return view('client.profilInfos', compact('superclient'));
    }

    public function historique(): View
    {
        /** @var SuperClient $superclient */
        $superclient = Auth::guard('superclient')->user();

        return view('client.historique', compact('superclient'));
    }

    public function update(Request $request): RedirectResponse
    {
        /** @var SuperClient $superclient */
        $superclient = Auth::guard('superclient')->user();

        $data = $request->validate([
            'nom_complet' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $nomParts = explode(' ', trim($data['nom_complet']), 2);
        $prenom = $nomParts[0] ?? '';
        $nom = $nomParts[1] ?? $prenom;

        $superclient->update([
            'nom' => $nom,
            'prenom' => $prenom,
            'numero' => $data['telephone'],
            'email' => $data['email'],
        ]);

        return redirect()->route('profil')->with('success', 'Profil mis à jour avec succès');
    }

    public function delete(Request $request): RedirectResponse
    {
        /** @var SuperClient $superclient */
        $superclient = Auth::guard('superclient')->user();

        $superclient->delete();

        Auth::guard('superclient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inscription')->with('success', 'Votre compte a été supprimé');
    }
}

