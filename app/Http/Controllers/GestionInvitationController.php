<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;

class GestionInvitationController extends Controller{
   
    public function creerInvitation(Request $requete, $idColoc){
        $utilisateurConnecte = Auth::user();

        if (!$utilisateurConnecte) {
            return redirect()->route('login');
        }

        $colocation = Colocation::find($idColoc);

        if (!$colocation) {
            return redirect()->route('colocations.index')
                ->with('error', 'Colocation introuvable.');
        }

       
        if ($colocation->owner_id != $utilisateurConnecte->id) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Action non autorisée.');
        }

        if (!$colocation->estActive()) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Impossible d\'inviter dans une colocation annulée.');
        }

     
        $requete->validate([
            'email' => 'required|email|max:255',
        ]);

        $emailInvite = $requete->email;

       
        $utilisateurExistant = User::where('email', $emailInvite)->first();

        if ($utilisateurExistant) {
            $dejaMembre = DB::table('memberships')
                ->where('colocation_id', $colocation->id)
                ->where('user_id', $utilisateurExistant->id)
                ->whereNull('left_at')
                ->exists();

            if ($dejaMembre) {
                return redirect()->route('colocations.show', $colocation)
                    ->with('error', 'Cet utilisateur est déjà membre de la colocation.');
            }
        }

     
        $invitationExistante = Invitation::where('colocation_id', $colocation->id)
            ->where('email', $emailInvite)
            ->where('status', 'pending')
            ->first();

        if ($invitationExistante) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Une invitation est déjà en attente pour cet email.');
        }

  
        $nouvelleInvitation = new Invitation();
        $nouvelleInvitation->email = $emailInvite;
        $nouvelleInvitation->token = md5(uniqid() . $emailInvite . time());
        $nouvelleInvitation->status = 'pending';
        $nouvelleInvitation->expires_at = now()->addDays(7);
        $nouvelleInvitation->colocation_id = $colocation->id;
        $nouvelleInvitation->invited_by_id = $utilisateurConnecte->id;
        $nouvelleInvitation->save();

       
        try {
           
            $nouvelleInvitation->load(['inviteur', 'colocation']);
        
            Mail::to($emailInvite)->send(new InvitationMail($nouvelleInvitation));
            
            $message = "Invitation envoyée avec succès à $emailInvite. Un email a été envoyé.";
        } catch (\Exception $e) {
         
            $urlInvitation = route('invitations.show', $nouvelleInvitation->token);
            $message = "Invitation créée mais l'envoi de l'email a échoué. Lien : $urlInvitation";
        }

        return redirect()->route('colocations.show', $colocation)
            ->with('success', $message);
    }

   
    public function afficherInvitation($token){
      
        $invitation = Invitation::with(['inviteur', 'colocation'])
            ->where('token', $token)
            ->first();

        if (!$invitation) {
            return redirect()->route('login')
                ->with('error', 'Invitation introuvable.');
        }

        return view('invitations.show', compact('invitation'));
    }

  
    public function accepterInvitation(Request $requete, $token){
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation) {
            return redirect()->route('login')
                ->with('error', 'Invitation introuvable.');
        }

        if ($invitation->status !== 'pending') {
            return redirect()->route('login')
                ->with('error', 'Cette invitation a déjà été traitée.');
        }

        if ($invitation->expires_at < now()) {
            return redirect()->route('login')
                ->with('error', 'Cette invitation a expiré.');
        }

      
        if (!Auth::check()) {
            session(['invitation_token' => $token]);
            return redirect()->route('register', ['email' => $invitation->email]);
        }

        $utilisateur = Auth::user();
        if ($utilisateur->email !== $invitation->email) {
            return redirect()->route('dashboard')
                ->with('error', 'Cette invitation ne correspond pas à votre compte.');
        }

        
        if (!is_null($utilisateur->banned_at)) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous ne pouvez pas rejoindre une colocation car vous êtes banni.');
        }

      
        $estDejaMembre = DB::table('memberships')
            ->where('colocation_id', $invitation->colocation_id)
            ->where('user_id', $utilisateur->id)
            ->whereNull('left_at')
            ->exists();

        if ($estDejaMembre) {
           
            $invitation->status = 'accepted';
            $invitation->save();
            
            return redirect()->route('colocations.show', $invitation->colocation_id)
                ->with('info', 'Vous êtes déjà membre de cette colocation. L\'invitation a été marquée comme acceptée.');
        }

        $aUneAutreColocationActive = DB::table('memberships')
            ->where('user_id', $utilisateur->id)
            ->whereNull('left_at')
            ->where('colocation_id', '!=', $invitation->colocation_id)
            ->exists();

        if ($aUneAutreColocationActive) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous avez déjà une colocation active. Vous devez la quitter avant d\'en rejoindre une autre.');
        }

     
        $colocation = Colocation::find($invitation->colocation_id);
        if (!$colocation || !$colocation->estActive()) {
            return redirect()->route('dashboard')
                ->with('error', 'Cette colocation n\'est plus active.');
        }

    
        DB::table('memberships')->insert([
            'user_id' => $utilisateur->id,
            'colocation_id' => $invitation->colocation_id,
            'role' => 'member',
            'joined_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    
        $invitation->status = 'accepted';
        $invitation->save();

        return redirect()->route('colocations.show', $invitation->colocation_id)
            ->with('success', 'Vous avez rejoint la colocation avec succès.');
    }

  
    public function refuserInvitation($token){
        $invitation = Invitation::where('token', $token)->first();

        if (!$invitation) {
            return redirect()->route('login')
                ->with('error', 'Invitation introuvable.');
        }

        if ($invitation->status !== 'pending') {
            return redirect()->route('login')
                ->with('error', 'Cette invitation a déjà été traitée.');
        }

        $invitation->status = 'declined';
        $invitation->save();

        return redirect()->route('login')
            ->with('info', 'Invitation refusée.');
    }

   
    public function supprimerInvitation($idInvitation){
        $utilisateur = Auth::user();

        if (!$utilisateur) {
            return redirect()->route('login');
        }

        $invitation = Invitation::find($idInvitation);

        if (!$invitation) {
            return redirect()->route('colocations.index')
                ->with('error', 'Invitation introuvable.');
        }

        $colocation = Colocation::find($invitation->colocation_id);

        // Vérifier que l'utilisateur est le propriétaire
        if ($colocation->owner_id != $utilisateur->id) {
            return redirect()->route('colocations.show', $colocation)
                ->with('error', 'Action non autorisée.');
        }

        $invitation->delete();

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Invitation supprimée.');
    }
}