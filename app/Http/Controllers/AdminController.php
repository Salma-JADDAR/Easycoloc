<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Vérifier que l'utilisateur est admin
        if ($user->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        $stats = [
            'users_total' => User::count(),
            'users_active' => User::whereNull('banned_at')->count(),
            'users_banned' => User::whereNotNull('banned_at')->count(),
            'colocations_total' => Colocation::count(),
            'colocations_active' => Colocation::where('status', 'active')->count(),
            'colocations_cancelled' => Colocation::where('status', 'cancelled')->count(),
        ];

        $users = User::withCount(['colocationsPossedees', 'membreships'])->paginate(10);

        return view('admin.dashboard', compact('stats', 'users'));
    }

    /**
     * Bannir un utilisateur
     */
    public function banUser(User $user)
    {
        // Vérifier que l'utilisateur est connecté et admin
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $currentUser = Auth::user();
        
        if ($currentUser->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        // Vérifier qu'on ne bannit pas un autre admin
        if ($user->role === 'admin' && $user->id !== $currentUser->id) {
            return back()->with('error', 'Vous ne pouvez pas bannir un autre administrateur.');
        }

        $user->ban();
        return back()->with('success', "L'utilisateur {$user->name} a été banni.");
    }

    /**
     * Débannir un utilisateur
     */
    public function unbanUser(User $user)
    {
        // Vérifier que l'utilisateur est connecté et admin
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $currentUser = Auth::user();
        
        if ($currentUser->role !== 'admin') {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        $user->unban();
        return back()->with('success', "L'utilisateur {$user->name} a été débanni.");
    }
}