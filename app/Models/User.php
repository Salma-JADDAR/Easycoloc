<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'reputation',
        'banned_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'banned_at' => 'datetime',
        'reputation' => 'integer',
    ];

    // =============================================
    // BANNISSEMENT
    // =============================================
    
    /**
     * Vérifier si l'utilisateur est banni (français)
     */
    public function estBanni(): bool
    {
        return $this->banned_at !== null;
    }

    /**
     * Vérifier si l'utilisateur est banni (anglais) - pour compatibilité
     */
    public function isBanned(): bool
    {
        return $this->estBanni();
    }

    /**
     * Bannir l'utilisateur (français)
     */
    public function bannir(): void
    {
        $this->banned_at = now();
        $this->save();
    }

    /**
     * Bannir l'utilisateur (anglais) - pour compatibilité avec AdminController
     */
    public function ban(): void
    {
        $this->bannir();
    }

    /**
     * Débannir l'utilisateur (français)
     */
    public function debannir(): void
    {
        $this->banned_at = null;
        $this->save();
    }

    /**
     * Débannir l'utilisateur (anglais) - pour compatibilité avec AdminController
     */
    public function unban(): void
    {
        $this->debannir();
    }

    // =============================================
    // RÔLES
    // =============================================
    
    /**
     * Vérifier si l'utilisateur est admin (français)
     */
    public function estAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifier si l'utilisateur est admin (anglais) - pour compatibilité
     */
    public function isAdmin(): bool
    {
        return $this->estAdmin();
    }

    /**
     * Promouvoir en admin
     */
    public function promouvoirAdmin(): void
    {
        $this->role = 'admin';
        $this->save();
    }

    // =============================================
    // RELATIONS
    // =============================================
    
    /**
     * Colocations où l'utilisateur est propriétaire
     */
    public function colocationsPossedees()
    {
        return $this->hasMany(Colocation::class, 'owner_id');
    }

    /**
     * Tous les membreships de l'utilisateur
     */
    public function membreships()
    {
        return $this->hasMany(Membership::class);
    }

    /**
     * Membership actif (sans date de départ)
     */
    public function membreshipActif()
    {
        return $this->hasOne(Membership::class)->whereNull('left_at');
    }

    /**
     * Toutes les colocations (via memberships)
     */
    public function colocations()
    {
        return $this->belongsToMany(Colocation::class, 'memberships')
                    ->withPivot('role', 'joined_at', 'left_at')
                    ->withTimestamps();
    }

    /**
     * Colocations actives uniquement
     */
    public function colocationsActives()
    {
        return $this->belongsToMany(Colocation::class, 'memberships')
                    ->wherePivotNull('left_at')
                    ->where('colocations.status', 'active')
                    ->withPivot('role', 'joined_at');
    }

    /**
     * Invitations envoyées
     */
    public function invitationsEnvoyees()
    {
        return $this->hasMany(Invitation::class, 'invited_by_id');
    }

    /**
     * Invitations reçues
     */
    public function invitationsRecues()
    {
        return $this->hasMany(Invitation::class, 'email', 'email')
                    ->where('status', 'pending');
    }

    // =============================================
    // VÉRIFICATIONS
    // =============================================
    
    /**
     * Vérifier si l'utilisateur a une colocation active
     */
    public function aUneColocationActive(): bool
    {
        return $this->membreshipActif()->exists();
    }

    /**
     * Vérifier si l'utilisateur peut créer une colocation
     */
    public function peutCreerColocation(): bool
    {
        return !$this->aUneColocationActive() && !$this->estBanni();
    }

    /**
     * Vérifier si l'utilisateur peut rejoindre une colocation
     */
    public function peutRejoindreColocation(): bool
    {
        return !$this->aUneColocationActive() && !$this->estBanni();
    }

    /**
     * Vérifier si l'utilisateur est propriétaire d'une colocation
     */
    public function estProprietaireDe(Colocation $colocation): bool
    {
        return $this->id === $colocation->owner_id;
    }

    /**
     * Vérifier si l'utilisateur est membre d'une colocation
     */
    public function estMembreDe(Colocation $colocation): bool
    {
        return $this->membreships()
                    ->where('colocation_id', $colocation->id)
                    ->whereNull('left_at')
                    ->exists();
    }
}