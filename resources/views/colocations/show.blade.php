@extends('layouts.app')

@section('title', $colocation->nom ?? $colocation->name)

@section('content')
<div class="dashboard">
    <!-- Blobs d'arrière-plan -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-title-section">
                <div class="header-badge">
                    <h1 class="header-title">
                        {{ $colocation->nom ?? $colocation->name }}
                    </h1>
                    @if($estProprietaire)
                        <span class="badge-owner-large">PROPRIÉTAIRE</span>
                    @endif
                </div>
                <p class="header-subtitle">{{ $colocation->description ?: 'Aucune description' }}</p>
            </div>
            
            <div class="header-actions">
               
                <a href="{{ route('colocations.index') }}" class="btn-back">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="container">
        <div class="grid-2cols">
            <!-- Colonne principale -->
            <div class="main-column">
                <!-- Membres -->
                <div class="section-card">
                    <h2 class="section-title">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Membres ({{ $listeMembres->count() }})
                    </h2>

                    <div class="members-list">
                        @foreach($listeMembres as $membre)
                            <div class="member-item">
                                <div class="member-info">
                                    <div class="member-avatar">
                                        {{ strtoupper(substr($membre->name, 0, 1)) }}
                                    </div>
                                    <div class="member-details">
                                        <div class="member-name-wrapper">
                                            <span class="member-name">{{ $membre->name }}</span>
                                            @if($membre->role === 'owner')
                                                <span class="badge-owner-small">Propriétaire</span>
                                            @endif
                                        </div>
                                        <p class="member-date">
                                            Membre depuis {{ \Carbon\Carbon::parse($membre->joined_at)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>

                                @if($estProprietaire && $membre->id != $colocation->proprietaire_id)
                                    <form method="POST" action="{{ route('colocations.members.remove', [$colocation->id, $membre->id]) }}" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir retirer ce membre ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if(!$estProprietaire)
                        <div class="leave-section">
                            <form method="POST" action="{{ route('colocations.leave', $colocation->id) }}"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir quitter cette colocation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-leave">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Quitter la colocation
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Invitations en attente (Owner only) -->
                @if($estProprietaire && $invitationsEnAttente->isNotEmpty())
                    <div class="section-card">
                        <h2 class="section-title">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Invitations en attente
                        </h2>

                        <div class="invitations-list">
                            @foreach($invitationsEnAttente as $invitation)
                                <div class="invitation-item">
                                    <div>
                                        <p class="invitation-email">{{ $invitation->email }}</p>
                                        <p class="invitation-date">
                                            Envoyée le {{ \Carbon\Carbon::parse($invitation->created_at)->format('d/m/Y') }}
                                            @if($invitation->expires_at)
                                                · Expire le {{ \Carbon\Carbon::parse($invitation->expires_at)->format('d/m/Y') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="invitation-actions">
                                        <form method="POST" action="{{ route('invitations.destroy', $invitation->id) }}"
                                              onsubmit="return confirm('Annuler cette invitation ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-cancel-invitation">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="sidebar-column">
                <!-- Informations -->
                <div class="section-card">
                    <h3 class="sidebar-title">Informations</h3>
                    
                    <div class="info-list">
                        <div class="info-row">
                            <span class="info-label">Créée le</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($colocation->created_at)->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Statut</span>
                            @if($colocation->estActive())
                                <span class="badge-status badge-active">Active</span>
                            @else
                                <span class="badge-status badge-cancelled">Annulée</span>
                            @endif
                        </div>
                        <div class="info-row">
                            <span class="info-label">Membres</span>
                            <span class="info-value">{{ $listeMembres->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Inviter des membres (Owner only) -->
                @if($estProprietaire)
                    <div class="section-card">
                        <h3 class="sidebar-title">Inviter des membres</h3>
                        
                        <form method="POST" action="{{ route('invitations.store', $colocation->id) }}" class="invite-form">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required
                                       class="form-input"
                                       placeholder="colocataire@email.com">
                            </div>
                            
                            <button type="submit" class="btn-invite">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Envoyer l'invitation
                            </button>
                        </form>

                        <p class="invite-note">
                            L'invitation expirera dans 7 jours.
                        </p>
                    </div>
                @endif

                <!-- Zone dangereuse (Owner only) -->
                @if($estProprietaire)
                    <div class="section-card danger-zone">
                        <h3 class="sidebar-title danger-title">Zone dangereuse</h3>
                        
                        <form method="POST" action="{{ route('colocations.destroy', $colocation->id) }}"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette colocation ? Cette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Annuler la colocation
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Variables du thème */
    :root {
        --primary-green: #064e3b;
        --accent-green: #10b981;
        --bg-light: #f9fafb;
        --glow-green: rgba(16, 185, 129, 0.15);
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }

    .dashboard {
        min-height: 100vh;
        position: relative;
        padding: 2rem;
        font-family: 'DM Sans', sans-serif;
        background: var(--bg-light);
        background-image: 
            radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(6, 78, 59, 0.05) 0px, transparent 50%);
    }

    /* Blobs animés */
    .blob {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        animation: float 20s infinite alternate;
        pointer-events: none;
    }
    
    .blob-1 { 
        width: 500px; 
        height: 500px; 
        background: var(--glow-green); 
        top: -10%; 
        right: -5%; 
    }
    
    .blob-2 { 
        width: 400px; 
        height: 400px; 
        background: rgba(6, 78, 59, 0.05); 
        bottom: -10%; 
        left: -5%; 
        animation-delay: -5s; 
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
    }

    /* Page Header */
    .page-header {
        position: relative;
        max-width: 1200px;
        margin: 0 auto 2rem;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(6, 78, 59, 0.1);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(6, 78, 59, 0.05);
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-green), var(--primary-green));
        animation: gradientShift 3s ease infinite;
    }

    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .header-title-section {
        flex: 1;
    }

    .header-badge {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 0.5rem;
    }

    .header-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.5rem;
        font-weight: 300;
        color: var(--primary-green);
        margin: 0;
    }

    .badge-owner-large {
        padding: 0.5rem 1rem;
        background: var(--glow-green);
        color: var(--primary-green);
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        border-radius: 100px;
        text-transform: uppercase;
    }

    .header-subtitle {
        color: var(--gray-500);
        font-size: 1rem;
        font-weight: 300;
        line-height: 1.6;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-edit,
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-edit {
        background: var(--primary-green);
        color: white;
    }

    .btn-edit:hover {
        background: #08634c;
    }

    .btn-back {
        background: var(--gray-100);
        color: var(--gray-700);
    }

    .btn-back:hover {
        background: var(--gray-200);
    }

    /* Alertes */
    .alert-success,
    .alert-error {
        max-width: 1200px;
        margin: 1rem auto;
        padding: 1rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideIn 0.3s ease;
    }

    .alert-success {
        background: var(--glow-green);
        border: 1px solid var(--accent-green);
        color: var(--primary-green);
    }

    .alert-error {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Container */
    .container {
        max-width: 1200px;
        margin: 2rem auto;
        position: relative;
        z-index: 1;
    }

    /* Grid */
    .grid-2cols {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 768px) {
        .grid-2cols {
            grid-template-columns: 1fr;
        }
    }

    /* Sections */
    .section-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(6, 78, 59, 0.1);
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 20px 40px rgba(6, 78, 59, 0.05);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 300;
        color: var(--primary-green);
        margin-bottom: 1.5rem;
    }

    .section-title svg {
        color: var(--accent-green);
    }

    /* Membres */
    .members-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .member-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: 12px;
        transition: background 0.2s;
    }

    .member-item:hover {
        background: var(--gray-100);
    }

    .member-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .member-avatar {
        width: 2.5rem;
        height: 2.5rem;
        background: linear-gradient(135deg, var(--accent-green), var(--primary-green));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1rem;
    }

    .member-details {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .member-name-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .member-name {
        font-weight: 500;
        color: var(--primary-green);
    }

    .badge-owner-small {
        padding: 0.15rem 0.5rem;
        background: var(--glow-green);
        color: var(--primary-green);
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        border-radius: 100px;
        text-transform: uppercase;
    }

    .member-date {
        font-size: 0.75rem;
        color: var(--gray-500);
        font-weight: 300;
    }

    .btn-remove {
        padding: 0.5rem;
        background: none;
        border: none;
        color: var(--gray-400);
        cursor: pointer;
        transition: color 0.2s;
    }

    .btn-remove:hover {
        color: #dc2626;
    }

    /* Leave section */
    .leave-section {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
    }

    .btn-leave {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: none;
        border: 1px solid #dc2626;
        border-radius: 8px;
        color: #dc2626;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-leave:hover {
        background: #fee2e2;
    }

    /* Invitations */
    .invitations-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .invitation-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem;
        background: var(--gray-50);
        border-radius: 8px;
    }

    .invitation-email {
        font-weight: 500;
        color: var(--primary-green);
        margin-bottom: 0.25rem;
    }

    .invitation-date {
        font-size: 0.7rem;
        color: var(--gray-500);
        font-weight: 300;
    }

    .invitation-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-cancel-invitation {
        padding: 0.25rem;
        background: none;
        border: none;
        color: var(--gray-400);
        cursor: pointer;
        transition: color 0.2s;
    }

    .btn-cancel-invitation:hover {
        color: #dc2626;
    }

    /* Sidebar */
    .sidebar-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        font-weight: 300;
        color: var(--primary-green);
        margin-bottom: 1rem;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--gray-100);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--gray-500);
        font-size: 0.85rem;
        font-weight: 300;
    }

    .info-value {
        color: var(--primary-green);
        font-weight: 500;
        font-size: 0.9rem;
    }

    .badge-status {
        padding: 0.25rem 0.75rem;
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-active {
        background: var(--glow-green);
        color: var(--primary-green);
    }

    .badge-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* Formulaire d'invitation */
    .invite-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--primary-green);
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        color: var(--primary-green);
        transition: all 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent-green);
        box-shadow: 0 0 0 3px var(--glow-green);
    }

    .btn-invite {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: var(--primary-green);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-invite:hover {
        background: #08634c;
    }

    .invite-note {
        font-size: 0.7rem;
        color: var(--gray-400);
        font-weight: 300;
        margin-top: 0.5rem;
    }

    /* Zone dangereuse */
    .danger-zone {
        border: 2px solid #fee2e2;
    }

    .danger-title {
        color: #b91c1c;
    }

    .btn-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.75rem;
        background: #dc2626;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-danger:hover {
        background: #b91c1c;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard {
            padding: 1rem;
        }

        .header-badge {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
            justify-content: flex-end;
        }

        .header-title {
            font-size: 2rem;
        }

        .member-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .btn-remove {
            align-self: flex-end;
        }
    }
</style>
@endsection