<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller{
   
    public function afficherColocationsUtilisateur(){
        $utilisateurConnecte = Auth::user();

        if (!$utilisateurConnecte) {
            return redirect()->route('login');
        }

        $idsColocationsMembre = DB::table('memberships')
            ->where('user_id', $utilisateurConnecte->id)
            ->whereNull('left_at')
            ->pluck('colocation_id');

        $colocationsMembre = Colocation::whereIn('id', $idsColocationsMembre)
            ->where('status', 'active')
            ->get();

        $colocationsProprietaire = Colocation::where('owner_id', $utilisateurConnecte->id)
            ->where('status', 'active')
            ->get();

        return view('colocations.index', [
            'colocations' => $colocationsMembre,
            'ownedColocations' => $colocationsProprietaire
        ]);
    }

  
    public function afficherFormulaireCreation(){
        $utilisateurConnecte = Auth::user();

        if (!$utilisateurConnecte) {
            return redirect()->route('login');
        }

        $aUneColocationActive = DB::table('memberships')
            ->where('user_id', $utilisateurConnecte->id)
            ->whereNull('left_at')
            ->exists();

        if ($aUneColocationActive) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous avez déjà une colocation active.');
        }

        return view('colocations.create');
    }

  
    public function enregistrerColocation(Request $requete){
        $utilisateurConnecte = Auth::user();

        if (!$utilisateurConnecte) {
            return redirect()->route('login');
        }

        $requete->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $aUneColocationActive = DB::table('memberships')
            ->where('user_id', $utilisateurConnecte->id)
            ->whereNull('left_at')
            ->exists();

        if ($aUneColocationActive) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous avez déjà une colocation active.');
        }

        $colocation = Colocation::create([
            'name' => $requete->name,
            'description' => $requete->description,
            'owner_id' => $utilisateurConnecte->id,
            'status' => 'active'
        ]);

        DB::table('memberships')->insert([
            'user_id' => $utilisateurConnecte->id,
            'colocation_id' => $colocation->id,
            'role' => 'owner',
            'joined_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation->id)
            ->with('success', 'Colocation créée avec succès.');
    }

  
    public function afficherColocation($idColocation){
        $utilisateurConnecte = Auth::user();

        if (!$utilisateurConnecte) {
            return redirect()->route('login');
        }

        $colocation = Colocation::find($idColocation);

        if (!$colocation) {
            return redirect()->route('colocations.index')
                ->with('error', 'Colocation introuvable.');
        }

        $estMembreActif = DB::table('memberships')
            ->where('colocation_id', $idColocation)
            ->where('user_id', $utilisateurConnecte->id)
            ->whereNull('left_at')
            ->exists();

        if (!$estMembreActif) {
            abort(403, 'Vous n\'êtes pas membre de cette colocation.');
        }

        $listeMembres = DB::table('memberships')
            ->join('users', 'users.id', '=', 'memberships.user_id')
            ->where('memberships.colocation_id', $idColocation)
            ->whereNull('memberships.left_at')
            ->select('users.*', 'memberships.role', 'memberships.joined_at')
            ->get();

        $invitationsEnAttente = DB::table('invitations')
            ->where('colocation_id', $idColocation)
            ->where('status', 'pending')
            ->get();

        $estProprietaire = $colocation->owner_id === $utilisateurConnecte->id;

        return view('colocations.show', compact(
            'colocation',
            'listeMembres',
            'invitationsEnAttente',
            'estProprietaire'
        ));
    }

    /**
     * Afficher formulaire d'édition
     */
    public function afficherFormulaireEdition($idColocation)
    {
        $utilisateurConnecte = Auth::user();

        if (!$utilisateurConnecte) {
            return redirect()->route('login');
        }

        $colocation = Colocation::find($idColocation);

        if (!$colocation) {
            return redirect()->route('colocations.index')
                ->with('error', 'Colocation introuvable.');
        }

        if ($colocation->owner_id !== $utilisateurConnecte->id) {
            abort(403, 'Seul le propriétaire peut modifier la colocation.');
        }

        if ($colocation->status !== 'active') {
            return redirect()->route('colocations.show', $idColocation)
                ->with('error', 'Impossible de modifier une colocation annulée.');
        }

        return view('colocations.edit', compact('colocation'));
    }

    /**
     * Mettre à jour colocation
     */
    public function mettreAJourColocation(Request $requete, $idColocation)
    {
        $utilisateurConnecte = Auth::user();
        $colocation = Colocation::find($idColocation);

        if (!$colocation) {
            return redirect()->route('colocations.index')
                ->with('error', 'Colocation introuvable.');
        }

        if ($colocation->owner_id !== $utilisateurConnecte->id) {
            abort(403, 'Seul le propriétaire peut modifier la colocation.');
        }

        $requete->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $colocation->update($requete->only('name', 'description'));

        return redirect()->route('colocations.show', $idColocation)
            ->with('success', 'Colocation mise à jour.');
    }

    /**
     * Annuler colocation - Seulement si l'owner et colocation vide
     */
   /**
 * Annuler colocation - Version avec requête directe
 */
    public function annulerColocation($idColocation)
{
    $utilisateurConnecte = Auth::user();
    $colocation = Colocation::find($idColocation);

    if (!$colocation) {
        return redirect()->route('colocations.index')
            ->with('error', 'Colocation introuvable.');
    }

    if ($colocation->owner_id !== $utilisateurConnecte->id) {
        abort(403);
    }

    if (!$colocation->estActive()) {
        return redirect()->route('colocations.show', $idColocation)
            ->with('error', 'Colocation déjà annulée.');
    }

    // Vérifier qu'il n'y a pas d'autres membres
    $autresMembres = DB::table('memberships')
        ->where('colocation_id', $idColocation)
        ->whereNull('left_at')
        ->where('user_id', '!=', $utilisateurConnecte->id)
        ->count();

    if ($autresMembres > 0) {
        return redirect()->route('colocations.show', $idColocation)
            ->with('error', 'Impossible d\'annuler : il reste des membres.');
    }

  
    $colocation->annuler();

    // Retirer le propriétaire
    DB::table('memberships')
        ->where('colocation_id', $idColocation)
        ->where('user_id', $utilisateurConnecte->id)
        ->update(['left_at' => now()]);

    return redirect()->route('dashboard')
        ->with('success', 'Colocation annulée avec succès.');
}

    /**
     * Quitter colocation (pour les membres)
     */
    public function quitterColocation($idColocation)
    {
        $utilisateurConnecte = Auth::user();
        $colocation = Colocation::find($idColocation);

        $adhesion = DB::table('memberships')
            ->where('colocation_id', $idColocation)
            ->where('user_id', $utilisateurConnecte->id)
            ->whereNull('left_at')
            ->first();

        if (!$adhesion) {
            abort(403, 'Vous n\'êtes pas membre de cette colocation.');
        }

        if ($colocation->owner_id === $utilisateurConnecte->id) {
            return back()->with('error', 'Le propriétaire ne peut pas quitter. Vous devez annuler la colocation ou transférer la propriété.');
        }

        DB::table('memberships')
            ->where('id', $adhesion->id)
            ->update(['left_at' => now()]);

        return redirect()->route('dashboard')
            ->with('success', 'Vous avez quitté la colocation.');
    }

    /**
     * Transférer propriété
     */
    public function transfererPropriete($idColocation, $nouveauProprietaireId)
    {
        $utilisateurConnecte = Auth::user();
        $colocation = Colocation::find($idColocation);

        if (!$colocation) {
            return redirect()->route('colocations.index')
                ->with('error', 'Colocation introuvable.');
        }

        if ($colocation->owner_id !== $utilisateurConnecte->id) {
            abort(403, 'Seul le propriétaire peut transférer la propriété.');
        }

        // Vérifier que le nouveau propriétaire est membre
        $nouveauMembre = DB::table('memberships')
            ->where('colocation_id', $idColocation)
            ->where('user_id', $nouveauProprietaireId)
            ->whereNull('left_at')
            ->first();

        if (!$nouveauMembre) {
            return redirect()->route('colocations.show', $idColocation)
                ->with('error', 'Le nouveau propriétaire doit être membre de la colocation.');
        }

        DB::table('memberships')
            ->where('colocation_id', $idColocation)
            ->where('user_id', $utilisateurConnecte->id)
            ->update(['role' => 'member']);

        DB::table('memberships')
            ->where('colocation_id', $idColocation)
            ->where('user_id', $nouveauProprietaireId)
            ->update(['role' => 'owner']);

        $colocation->update(['owner_id' => $nouveauProprietaireId]);

        return redirect()->route('colocations.show', $idColocation)
            ->with('success', 'Propriété transférée.');
    }

    /**
     * Retirer un membre (pour le propriétaire)
     */
    public function retirerMembre($idColocation, $membreId)
    {
        $utilisateurConnecte = Auth::user();
        $colocation = Colocation::find($idColocation);

        if (!$colocation) {
            return redirect()->route('colocations.index')
                ->with('error', 'Colocation introuvable.');
        }

        if ($colocation->owner_id !== $utilisateurConnecte->id) {
            abort(403, 'Seul le propriétaire peut retirer des membres.');
        }

        // Empêcher de retirer le propriétaire
        if ($membreId == $colocation->owner_id) {
            return redirect()->route('colocations.show', $idColocation)
                ->with('error', 'Vous ne pouvez pas retirer le propriétaire.');
        }

        DB::table('memberships')
            ->where('colocation_id', $idColocation)
            ->where('user_id', $membreId)
            ->update(['left_at' => now()]);

        return redirect()->route('colocations.show', $idColocation)
            ->with('success', 'Membre retiré.');
    }
}