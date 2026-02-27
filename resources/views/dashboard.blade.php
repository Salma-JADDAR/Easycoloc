@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Blobs d'arrière-plan animés -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>
<div class="blob blob-3"></div>

<div class="dashboard-container">
    <!-- ===== EN-TÊTE AVEC STATISTIQUES ===== -->
    <div class="dashboard-header">
        <div class="header-main">
            <div class="header-greeting">
                <h1 class="greeting-title">
                    Bonjour, <span class="greeting-name">{{ auth()->user()->name }}</span>
                </h1>
                <p class="greeting-date">
                    <svg class="date-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ now()->format('l d F Y') }}
                </p>
            </div>
            
            {{-- ===== NOTIFICATION D'INVITATION ===== --}}
            @php
                use App\Models\Invitation;
                $invitationsEnAttente = Invitation::with(['colocation', 'inviteur'])
                    ->where('email', auth()->user()->email)
                    ->where('status', 'pending')
                    ->where('expires_at', '>', now())
                    ->get();
                $nombreInvitations = $invitationsEnAttente->count();
            @endphp

            <div class="notification-wrapper">
                <div class="notification-icon" onclick="toggleNotificationDropdown()">
                    <svg class="bell-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @if($nombreInvitations > 0)
                        <span class="notification-badge">{{ $nombreInvitations }}</span>
                    @endif
                </div>

                {{-- Dropdown des invitations --}}
                @if($nombreInvitations > 0)
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="dropdown-header">
                            <h3>Invitations en attente</h3>
                            <span class="header-count">{{ $nombreInvitations }}</span>
                        </div>
                        <div class="dropdown-list">
                            @foreach($invitationsEnAttente as $invitation)
                                <div class="dropdown-item">
                                    <div class="item-icon">
                                        <svg class="item-icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-title">{{ $invitation->colocation->name }}</div>
                                        <div class="item-subtitle">de {{ $invitation->inviteur->name ?? 'Utilisateur inconnu' }}</div>
                                        <div class="item-expire">Expire le {{ $invitation->expires_at->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="item-actions">
                                        <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}">
                                            @csrf
                                            <button type="submit" class="action-btn accept-btn" title="Accepter">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('invitations.decline', $invitation->token) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn decline-btn" title="Refuser">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="dropdown-footer">
                            <a href="#" class="view-all-link">Voir toutes les invitations</a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="header-avatar">
                <div class="avatar-circle">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="avatar-status {{ auth()->user()->estBanni() ? 'status-banned' : 'status-online' }}"></div>
            </div>
        </div>

        <!-- Mini statistiques -->
        <div class="header-stats">
            <div class="header-stat">
                <span class="header-stat-value">{{ auth()->user()->reputation }}</span>
                <span class="header-stat-label">Points XP</span>
            </div>
            <div class="header-stat">
                @php
                    $colocationsCount = DB::table('memberships')
                        ->where('user_id', auth()->id())
                        ->whereNull('left_at')
                        ->count();
                @endphp
                <span class="header-stat-value">{{ $colocationsCount }}</span>
                <span class="header-stat-label">Colocations</span>
            </div>
            <div class="header-stat">
                <span class="header-stat-value">{{ now()->format('d') }}</span>
                <span class="header-stat-label">{{ now()->format('M') }}</span>
            </div>
        </div>
    </div>

    <!-- ===== STATISTIQUES PRINCIPALES ===== -->
    <div class="stats-grid">
        <!-- Role Card -->
        <div class="stat-card stat-card-role">
            <div class="stat-card-inner">
                <div class="stat-icon-wrapper">
                    <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Rôle</span>
                    <span class="stat-value stat-value-role {{ auth()->user()->role === 'admin' ? 'text-admin' : 'text-member' }}">
                        {{ auth()->user()->role === 'admin' ? 'Administrateur' : 'Membre' }}
                    </span>
                </div>
                <div class="stat-badge {{ auth()->user()->role === 'admin' ? 'badge-admin' : 'badge-member' }}">
                    {{ auth()->user()->role === 'admin' ? 'ADMIN' : 'USER' }}
                </div>
            </div>
        </div>

        <!-- Reputation Card -->
        <div class="stat-card stat-card-reputation">
            <div class="stat-card-inner">
                <div class="stat-icon-wrapper">
                    <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <span class="stat-label">Réputation</span>
                    <span class="stat-value">{{ auth()->user()->reputation }}</span>
                </div>
                <div class="stat-progress">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ min(100, auth()->user()->reputation) }}%"></div>
                    </div>
                    <span class="progress-text">{{ auth()->user()->reputation }}/1000 XP</span>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="stat-card stat-card-status">
            <div class="stat-card-inner">
                <div class="stat-icon-wrapper {{ auth()->user()->estBanni() ? 'icon-banned' : 'icon-active' }}">
                    @if(auth()->user()->estBanni())
                        <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                    @else
                        <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
                <div class="stat-content">
                    <span class="stat-label">Statut</span>
                    <span class="stat-value {{ auth()->user()->estBanni() ? 'text-banned' : 'text-active' }}">
                        {{ auth()->user()->estBanni() ? 'Compte suspendu' : 'Compte actif' }}
                    </span>
                </div>
                <div class="status-indicator {{ auth()->user()->estBanni() ? 'indicator-banned' : 'indicator-active' }}">
                    <span class="status-dot"></span>
                    <span>{{ auth()->user()->estBanni() ? 'Banni' : 'En ligne' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ACTIONS RAPIDES ===== -->
    <div class="quick-actions-section">
        <div class="section-header">
            <h2 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Actions rapides
            </h2>
        </div>

        <div class="quick-actions-grid">
            <!-- Mes colocations -->
            <a href="{{ route('colocations.index') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="quick-action-content">
                    <h3 class="quick-action-title">Mes colocations</h3>
                    <p class="quick-action-description">Gérer mes espaces de vie</p>
                </div>
                <div class="quick-action-arrow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            <!-- Mon profil -->
            <a href="{{ route('profile.edit') }}" class="quick-action-card">
                <div class="quick-action-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="quick-action-content">
                    <h3 class="quick-action-title">Mon profil</h3>
                    <p class="quick-action-description">Modifier mes informations</p>
                </div>
                <div class="quick-action-arrow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            @php
                $aUneColocationActive = DB::table('memberships')
                    ->where('user_id', auth()->id())
                    ->whereNull('left_at')
                    ->exists();
            @endphp

            @if(!$aUneColocationActive && !auth()->user()->estBanni())
                <!-- Nouvelle colocation -->
                <a href="{{ route('colocations.create') }}" class="quick-action-card quick-action-create">
                    <div class="quick-action-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--accent-green);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div class="quick-action-content">
                        <h3 class="quick-action-title">Nouvelle colocation</h3>
                        <p class="quick-action-description">Créer un espace partagé</p>
                    </div>
                    <div class="quick-action-arrow">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            @endif

            <!-- Support (toujours visible) -->
            <a href="#" class="quick-action-card">
                <div class="quick-action-icon" style="background: rgba(236, 72, 153, 0.1); color: #ec4899;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="quick-action-content">
                    <h3 class="quick-action-title">Support</h3>
                    <p class="quick-action-description">Obtenir de l'aide</p>
                </div>
                <div class="quick-action-arrow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
        </div>
    </div>
</div>

<script>
    function toggleNotificationDropdown() {
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown) {
            dropdown.classList.toggle('show');
        }
    }

    // Fermer le dropdown quand on clique ailleurs
    window.onclick = function(event) {
        if (!event.target.closest('.notification-wrapper')) {
            const dropdown = document.getElementById('notificationDropdown');
            if (dropdown && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        }
    }
</script>

<style>
    /* ===== STYLES AMÉLIORÉS ===== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-green: #064e3b;
        --accent-green: #10b981;
        --bg-light: #f9fafb;
        --glow-green: rgba(16, 185, 129, 0.1);
        --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        --card-shadow-hover: 0 20px 30px -10px rgba(6, 78, 59, 0.15);
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

    .blob-3 {
        width: 300px;
        height: 300px;
        background: rgba(16, 185, 129, 0.08);
        top: 40%;
        left: 60%;
        animation-delay: -10s;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(50px, -50px) scale(1.1); }
        66% { transform: translate(-30px, 30px) scale(0.95); }
    }

    /* Container principal */
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        z-index: 10;
    }

    /* ===== EN-TÊTE ===== */
    .dashboard-header {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(229, 231, 235, 0.5);
    }

    .header-main {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .greeting-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }

    .greeting-name {
        background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .greeting-wave {
        display: inline-block;
        animation: wave 2s infinite;
        transform-origin: 70% 70%;
    }

    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(20deg); }
        75% { transform: rotate(-10deg); }
    }

    .greeting-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.95rem;
    }

    .date-icon {
        width: 1.2rem;
        height: 1.2rem;
        color: var(--accent-green);
    }

    /* ===== NOTIFICATION ===== */
    .notification-wrapper {
        position: relative;
        margin-right: 1rem;
    }

    .notification-icon {
        position: relative;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 50%;
        transition: background 0.3s;
    }

    .notification-icon:hover {
        background: rgba(16, 185, 129, 0.1);
    }

    .bell-icon {
        width: 1.8rem;
        height: 1.8rem;
        color: #4b5563;
    }

    .notification-badge {
        position: absolute;
        top: 0;
        right: 0;
        background: #ef4444;
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        min-width: 1.2rem;
        height: 1.2rem;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.2rem;
        animation: pulse 2s infinite;
        border: 2px solid white;
    }

    .notification-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 380px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid #e5e7eb;
        margin-top: 0.5rem;
        display: none;
        z-index: 1000;
    }

    .notification-dropdown.show {
        display: block;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-header {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dropdown-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary-green);
    }

    .header-count {
        background: #f3f4f6;
        color: #4b5563;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .dropdown-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .dropdown-item {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: background 0.2s;
    }

    .dropdown-item:hover {
        background: #f9fafb;
    }

    .item-icon {
        background: rgba(245, 158, 11, 0.1);
        border-radius: 10px;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .item-icon-svg {
        width: 1.2rem;
        height: 1.2rem;
        color: #f59e0b;
    }

    .item-content {
        flex: 1;
    }

    .item-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.2rem;
    }

    .item-subtitle {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: 0.2rem;
    }

    .item-expire {
        font-size: 0.7rem;
        color: #9ca3af;
    }

    .item-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 2rem;
        height: 2rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .action-btn svg {
        width: 1.2rem;
        height: 1.2rem;
    }

    .accept-btn {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .accept-btn:hover {
        background: #10b981;
        color: white;
    }

    .decline-btn {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .decline-btn:hover {
        background: #ef4444;
        color: white;
    }

    .dropdown-footer {
        padding: 1rem;
        border-top: 1px solid #e5e7eb;
        text-align: center;
    }

    .view-all-link {
        color: var(--accent-green);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .view-all-link:hover {
        color: var(--primary-green);
    }

    .header-avatar {
        position: relative;
    }

    .avatar-circle {
        width: 4rem;
        height: 4rem;
        background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        font-weight: 600;
        box-shadow: 0 10px 20px rgba(6, 78, 59, 0.2);
    }

    .avatar-status {
        position: absolute;
        bottom: 0.2rem;
        right: 0.2rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        border: 2px solid white;
    }

    .status-online {
        background: var(--accent-green);
        animation: pulse 2s infinite;
    }

    .status-banned {
        background: #ef4444;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .header-stats {
        display: flex;
        gap: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .header-stat {
        display: flex;
        flex-direction: column;
    }

    .header-stat-value {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-green);
    }

    .header-stat-label {
        font-size: 0.8rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* ===== STATISTIQUES ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(229, 231, 235, 0.5);
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--accent-green);
    }

    .stat-card-inner {
        padding: 1.5rem;
        position: relative;
    }

    .stat-icon-wrapper {
        width: 3rem;
        height: 3rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .stat-card-role .stat-icon-wrapper {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-green);
    }

    .stat-card-reputation .stat-icon-wrapper {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .stat-card-status .stat-icon-wrapper {
        transition: all 0.3s;
    }

    .icon-active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-green);
    }

    .icon-banned {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .stat-icon {
        width: 1.5rem;
        height: 1.5rem;
    }

    .stat-content {
        margin-bottom: 1rem;
    }

    .stat-label {
        display: block;
        font-size: 0.8rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-green);
    }

    .stat-value-role {
        font-size: 1.2rem;
    }

    .stat-badge {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-admin {
        background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
        color: white;
    }

    .badge-member {
        background: #e5e7eb;
        color: #4b5563;
    }

    .stat-progress {
        margin-top: 0.5rem;
    }

    .progress-bar {
        width: 100%;
        height: 0.375rem;
        background: #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
        margin-bottom: 0.25rem;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #fbbf24, #f59e0b);
        border-radius: 999px;
        transition: width 0.5s;
    }

    .progress-text {
        font-size: 0.7rem;
        color: #9ca3af;
    }

    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .indicator-active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-green);
    }

    .indicator-banned {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .status-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
    }

    .indicator-active .status-dot {
        background: var(--accent-green);
        animation: pulse 2s infinite;
    }

    .indicator-banned .status-dot {
        background: #ef4444;
    }

    /* ===== SECTIONS ===== */
    .activities-section,
    .quick-actions-section {
        margin-top: 2rem;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-green);
    }

    .section-icon {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--accent-green);
    }

    .section-link {
        color: var(--accent-green);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .section-link:hover {
        color: var(--primary-green);
    }

    /* ===== ACTIONS RAPIDES ===== */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }

    .quick-action-card {
        background: white;
        border-radius: 20px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid rgba(229, 231, 235, 0.5);
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: var(--card-shadow);
    }

    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--accent-green);
    }

    .quick-action-create {
        background: linear-gradient(135deg, #ffffff, #f9fafb);
    }

    .quick-action-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s;
    }

    .quick-action-card:hover .quick-action-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .quick-action-content {
        flex: 1;
    }

    .quick-action-title {
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: 0.25rem;
    }

    .quick-action-description {
        font-size: 0.85rem;
        color: #6b7280;
    }

    .quick-action-arrow {
        color: #9ca3af;
        transition: all 0.3s;
    }

    .quick-action-card:hover .quick-action-arrow {
        color: var(--accent-green);
        transform: translateX(5px);
    }

    /* ===== TEXTES SPÉCIFIQUES ===== */
    .text-admin {
        color: #8b5cf6;
    }

    .text-member {
        color: #3b82f6;
    }

    .text-active {
        color: var(--accent-green);
    }

    .text-banned {
        color: #ef4444;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .header-main {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .greeting-date {
            justify-content: center;
        }

        .header-stats {
            justify-content: center;
        }

        .notification-dropdown {
            width: 300px;
            right: -50px;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection