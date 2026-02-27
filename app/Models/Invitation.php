<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'status',
        'expires_at',
        'colocation_id',
        'invited_by_id',        // CHANGÉ: invite_par_id -> invited_by_id
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            $invitation->token = $invitation->token ?? Str::random(64);
            $invitation->expires_at = $invitation->expires_at ?? now()->addDays(7);
        });
    }

    // Relations
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function inviteur()
    {
        return $this->belongsTo(User::class, 'invited_by_id');    
    }

    // Vérifications
    public function estValide(): bool
    {
        return $this->status === 'pending' && 
               $this->expires_at && 
               $this->expires_at->isFuture();
    }

    public function estExpiree(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function peutEtreAccepteePar(User $user): bool
    {
        return $this->estValide() && 
               $this->email === $user->email &&
               !$user->aUneColocationActive();
    }

    // Actions
    public function accepter(User $user): bool
    {
        if (!$this->peutEtreAccepteePar($user)) {
            return false;
        }

        $this->colocation->ajouterMembre($user);
        $this->status = 'accepted';
        
        return $this->save();
    }

    public function refuser(): bool
    {
        $this->status = 'declined';
        return $this->save();
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeValides($query)
    {
        return $query->where('status', 'pending')
                     ->where('expires_at', '>', now());
    }

    public function scopePourEmail($query, string $email)
    {
        return $query->where('email', $email);
    }
}