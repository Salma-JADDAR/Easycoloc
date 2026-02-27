<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Invitation;

class DashboardController extends Controller{
    public function index(){
        $utilisateur = Auth::user();
        
        
        $invitationsEnAttente = Invitation::with(['colocation', 'inviteur'])
            ->where('email', $utilisateur->email)
            ->where('status', 'pending')
            ->where('expires_at', '>', now())
            ->get();

        return view('dashboard', compact('invitationsEnAttente'));
    }
}