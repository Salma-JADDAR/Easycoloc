<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'cancelled_at',
        'owner_id',
    ];

    protected $casts = [
        'cancelled_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function membreships()
    {
        return $this->hasMany(Membership::class);
    }

    public function membreshipsActifs()
    {
        return $this->hasMany(Membership::class)->whereNull('left_at');
    }

    public function membres()
    {
        return $this->belongsToMany(User::class, 'memberships')
                    ->withPivot('role', 'joined_at', 'left_at')
                    ->withTimestamps();
    }

    public function membresActifs()
    {
        return $this->belongsToMany(User::class, 'memberships')
                    ->wherePivotNull('left_at')
                    ->withPivot('role', 'joined_at');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function invitationsEnAttente()
    {
        return $this->hasMany(Invitation::class)->where('statut', 'pending');
    }

    /**
     * Vérifications
     */
    public function estActive(): bool
    {
        return $this->status === 'active';
    }

    public function estAnnulee(): bool
    {
        return $this->status === 'cancelled';
    }

    public function aMembre(User $user): bool
    {
        return $this->membresActifs()
                    ->where('user_id', $user->id)
                    ->exists();
    }

    public function estProprietaire(User $user): bool
    {
        return $this->owner_id === $user->id; // ✅ CORRIGÉ : owner_id au lieu de proprietaire_id
    }

    /**
     * Actions
     */
    public function ajouterMembre(User $user, string $role = 'member'): Membership
    {
        return $this->membreships()->create([
            'user_id' => $user->id,
            'role' => $role,
            'joined_at' => now(),
            'left_at' => null,
        ]);
    }

    public function retirerMembre(User $user): bool
    {
        $membership = $this->membreships()
                           ->where('user_id', $user->id)
                           ->whereNull('left_at')
                           ->first();

        if ($membership) {
            $membership->left_at = now();
            return $membership->save();
        }

        return false;
    }

    /**
     * ✅ MÉTHODE POUR ANNULER LA COLOCATION
     */
    public function annuler()
    {
        $this->status = 'cancelled';
        $this->cancelled_at = now();
        return $this->save();
    }

    /**
     * Scopes
     */
    public function scopeActives($query)
    {
        return $query->where('status', 'active'); // ✅ CORRIGÉ : status au lieu de statut
    }

    public function scopeAnnulees($query)
    {
        return $query->where('status', 'cancelled'); // ✅ CORRIGÉ : status au lieu de statut
    }
}