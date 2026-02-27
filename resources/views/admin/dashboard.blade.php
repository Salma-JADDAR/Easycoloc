@extends('layouts.app')

@section('title', 'Administration')

@section('content')

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="space-y-6 relative z-10">
    
    <div class="header-simple">
        <div class="header-content">
            <div class="header-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="header-title">Administration</h1>
                <p class="header-subtitle">Gérez les utilisateurs et les statistiques</p>
            </div>
        </div>
    </div>

 
    <div class="stats-grid-simple">
   
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--accent-green);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Utilisateurs</p>
                <p class="stat-number">{{ $stats['users_total'] }}</p>
                <span class="stat-badge stat-badge-up">+12%</span>
            </div>
        </div>

        <!-- Utilisateurs Actifs -->
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--accent-green);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Actifs</p>
                <p class="stat-number">{{ $stats['users_active'] }}</p>
                <span class="stat-badge stat-badge-up">+8%</span>
            </div>
        </div>

        <!-- Utilisateurs Bannis -->
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Bannis</p>
                <p class="stat-number">{{ $stats['users_banned'] }}</p>
                <span class="stat-badge stat-badge-down">-3%</span>
            </div>
        </div>

        <!-- Total Colocations -->
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--accent-green);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Colocations</p>
                <p class="stat-number">{{ $stats['colocations_total'] }}</p>
                <span class="stat-badge stat-badge-up">+15%</span>
            </div>
        </div>

        <!-- Colocations Actives -->
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--accent-green);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Actives</p>
                <p class="stat-number">{{ $stats['colocations_active'] }}</p>
                <span class="stat-badge stat-badge-up">+10%</span>
            </div>
        </div>

        <!-- Colocations Annulées -->
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-label">Annulées</p>
                <p class="stat-number">{{ $stats['colocations_cancelled'] }}</p>
                <span class="stat-badge stat-badge-down">-5%</span>
            </div>
        </div>
    </div>

    <!-- ===== GESTION DES UTILISATEURS ===== -->
    <div class="users-card">
        <div class="users-header">
            <div class="users-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h2>Gestion des utilisateurs</h2>
            </div>
            <span class="users-count">{{ $users->total() }} total</span>
        </div>

        <!-- Tableau -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th>Réputation</th>
                        <th>Statut</th>
                        <th>Inscrit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge badge-admin">Admin</span>
                            @else
                                <span class="badge badge-user">Membre</span>
                            @endif
                        </td>
                        <td>{{ $user->reputation }}</td>
                        <td>
                            @if($user->estBanni())
                                <span class="badge badge-banned">Banni</span>
                            @else
                                <span class="badge badge-active">Actif</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($user->estBanni())
                                <form method="POST" action="{{ route('admin.users.unban', $user) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-unban">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                @if(!($user->role === 'admin') || $user->id === auth()->id())
                                    <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-action btn-ban" onclick="return confirm('Bannir cet utilisateur ?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="btn-disabled">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination simple -->
        <div class="pagination-simple">
            <span>Page {{ $users->currentPage() }} sur {{ $users->lastPage() }}</span>
            <div>
                @if($users->onFirstPage())
                    <span class="disabled">←</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="pagination-link">←</a>
                @endif
                
                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="pagination-link">→</a>
                @else
                    <span class="disabled">→</span>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== STYLES SIMPLES ===== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

    :root {
        --primary-green: #064e3b;
        --accent-green: #10b981;
        --bg-light: #f9fafb;
        --glow-green: rgba(16, 185, 129, 0.1);
    }

    /* Blobs animés (optionnels - vous pouvez les supprimer si vous voulez encore plus simple) */
    .blob {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        animation: move 20s infinite alternate;
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

    @keyframes move {
        from { transform: translate(0, 0) scale(1); }
        to { transform: translate(50px, 100px) scale(1.1); }
    }

    /* En-tête simple */
    .header-simple {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon {
        width: 3rem;
        height: 3rem;
        background: var(--glow-green);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent-green);
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: 0.25rem;
    }

    .header-subtitle {
        font-size: 0.9rem;
        color: #6b7280;
    }

    /* Grille des statistiques */
    .stats-grid-simple {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 1px solid #e5e7eb;
        transition: all 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(6, 78, 59, 0.1);
        border-color: var(--accent-green);
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-content {
        flex: 1;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: 0.25rem;
    }

    .stat-badge {
        display: inline-block;
        padding: 0.2rem 0.5rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 500;
    }

    .stat-badge-up {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-green);
    }

    .stat-badge-down {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    /* Carte des utilisateurs */
    .users-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .users-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f9fafb;
    }

    .users-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-green);
        font-weight: 500;
    }

    .users-count {
        background: white;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.8rem;
        border: 1px solid #e5e7eb;
    }

    /* Tableau */
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        text-align: left;
        padding: 1rem 1.5rem;
        font-size: 0.8rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .table tr:hover td {
        background: #f9fafb;
    }

    /* Infos utilisateur */
    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 500;
    }

    .user-name {
        font-weight: 500;
        color: var(--primary-green);
    }

    .user-email {
        font-size: 0.8rem;
        color: #6b7280;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-admin {
        background: var(--primary-green);
        color: white;
    }

    .badge-user {
        background: #e5e7eb;
        color: #374151;
    }

    .badge-active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-green);
    }

    .badge-banned {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    /* Boutons d'action */
    .btn-action {
        width: 2rem;
        height: 2rem;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-unban {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-green);
    }

    .btn-unban:hover {
        background: var(--accent-green);
        color: white;
    }

    .btn-ban {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .btn-ban:hover {
        background: #ef4444;
        color: white;
    }

    .btn-disabled {
        width: 2rem;
        height: 2rem;
        border-radius: 8px;
        background: #e5e7eb;
        color: #9ca3af;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: not-allowed;
    }

    /* Pagination simple */
    .pagination-simple {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f9fafb;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .pagination-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 8px;
        background: white;
        border: 1px solid #e5e7eb;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
    }

    .pagination-link:hover {
        background: var(--glow-green);
        border-color: var(--accent-green);
        color: var(--primary-green);
    }

    .disabled {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 8px;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid-simple {
            grid-template-columns: 1fr;
        }
        
        .table td, .table th {
            padding: 0.75rem;
        }
        
        .user-info {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection