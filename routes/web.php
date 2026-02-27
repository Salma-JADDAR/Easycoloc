<?php

use App\Http\Controllers\Auth\InscriptionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\GestionInvitationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});




Route::get('/register', [InscriptionController::class, 'afficherFormulaire'])->name('register');
Route::post('/register', [InscriptionController::class, 'traiter'])->name('register.store');


Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// =============================================
// ROUTES PROTÉGÉES (nécessitent authentification)
// =============================================

// Routes admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/users/{user}/ban', [App\Http\Controllers\AdminController::class, 'banUser'])->name('users.ban');
    Route::post('/users/{user}/unban', [App\Http\Controllers\AdminController::class, 'unbanUser'])->name('users.unban');
});
// Routes protégées
Route::middleware('auth')->group(function () {
    // Profil
    
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update');

    
    // Colocations
    Route::get('/mes-colocations', [ColocationController::class, 'afficherColocationsUtilisateur'])->name('colocations.index');
    Route::get('/colocations/creer', [ColocationController::class, 'afficherFormulaireCreation'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'enregistrerColocation'])->name('colocations.store');
    Route::get('/colocations/{idColocation}', [ColocationController::class, 'afficherColocation'])->name('colocations.show');
    Route::get('/colocations/{idColocation}/modifier', [ColocationController::class, 'afficherFormulaireEdition'])->name('colocations.edit');
    Route::put('/colocations/{idColocation}', [ColocationController::class, 'mettreAJourColocation'])->name('colocations.update');
    Route::delete('/colocations/{idColocation}', [ColocationController::class, 'annulerColocation'])->name('colocations.destroy');
    Route::delete('/colocations/{idColocation}/quitter', [ColocationController::class, 'quitterColocation'])->name('colocations.leave');
    Route::delete('/colocations/{idColocation}/membres/{membreId}', [ColocationController::class, 'retirerMembre'])->name('colocations.members.remove');
    Route::post('/colocations/{idColocation}/transferer/{nouveauProprietaireId}', [ColocationController::class, 'transfererPropriete'])->name('colocations.transfer');
    
    // Invitations
    Route::post('/colocations/{idColoc}/invitations', [GestionInvitationController::class, 'creerInvitation'])->name('invitations.store');
    Route::delete('/invitations/{idInvitation}', [GestionInvitationController::class, 'supprimerInvitation'])->name('invitations.destroy');
});

// Routes publiques pour les invitations
Route::get('/invitations/{token}', [GestionInvitationController::class, 'afficherInvitation'])->name('invitations.show');
Route::post('/invitations/{token}/accepter', [GestionInvitationController::class, 'accepterInvitation'])->name('invitations.accept');
Route::delete('/invitations/{token}/refuser', [GestionInvitationController::class, 'refuserInvitation'])->name('invitations.decline');