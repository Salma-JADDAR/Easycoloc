<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'memberships';

    protected $fillable = [
        'role',
        'joined_at',
        'left_at',
        'user_id',
        'colocation_id',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    // Vérifications
    public function estActif(): bool
    {
        return $this->left_at === null;
    }

    public function estProprietaire(): bool
    {
        return $this->role === 'owner';
    }

    public function estMembre(): bool
    {
        return $this->role === 'member';
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->whereNull('left_at');
    }

    public function scopeProprietaires($query)
    {
        return $query->where('role', 'owner');
    }

    public function scopeMembres($query)
    {
        return $query->where('role', 'member');
    }
}