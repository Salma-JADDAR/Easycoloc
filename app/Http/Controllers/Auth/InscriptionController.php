<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class InscriptionController extends Controller
{
    public function afficherFormulaire(): View
    {
        return view('auth.register');
    }

 
    public function traiter(Request $requete): RedirectResponse
    {
        $donneesValidees = $this->validerDonnees($requete);

        $utilisateur = $this->creerUtilisateur($donneesValidees);

        $this->connecterUtilisateur($utilisateur);

       
        if (User::count() === 1) {
            session()->flash('success', 'Bienvenue ! Vous êtes le premier administrateur.');
        }

        return $this->redirigerApresConnexion();
    }

    private function validerDonnees(Request $requete): array
    {
        return $requete->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

   
    private function creerUtilisateur(array $donnees): User
    {
        $estPremierUtilisateur = User::count() === 0;

        return User::create([
            'name' => $donnees['name'],
            'email' => $donnees['email'],
            'password' => Hash::make($donnees['password']),
            'role' => $estPremierUtilisateur ? 'admin' : 'user',
            'reputation' => 0,
            'banned_at' => null,
        ]);
    }

    private function connecterUtilisateur(User $utilisateur): void
    {
        Auth::login($utilisateur);
    }

 
    private function redirigerApresConnexion(): RedirectResponse
    {
        return redirect()->route('dashboard');
    }
}