@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<!-- Blobs d'arrière-plan animés -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>
<div class="blob blob-3"></div>

<div class="profile-container">
    <!-- ===== EN-TÊTE AVEC STATISTIQUES ===== -->
    <div class="page-header">
        <div class="header-main">
            <div class="header-left">
                <div class="header-icon-wrapper">
                    <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Mon Profil</h1>
                    <p class="header-subtitle">Gérez vos informations personnelles</p>
                </div>
            </div>
            
            <a href="{{ route('dashboard') }}" class="btn-back">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="btn-text">Dashboard</span>
            </a>
        </div>

        <!-- Mini statistiques -->
        @php $user = auth()->user(); @endphp
        <div class="header-stats">
            <div class="header-stat">
                <span class="header-stat-value">{{ $user->reputation }}</span>
                <span class="header-stat-label">XP</span>
            </div>
            <div class="header-stat">
                <span class="header-stat-value">{{ $user->role === 'admin' ? 'Admin' : 'Membre' }}</span>
                <span class="header-stat-label">Rôle</span>
            </div>
            <div class="header-stat">
                <span class="header-stat-value">{{ $user->estBanni() ? 'Banni' : 'Actif' }}</span>
                <span class="header-stat-label">Statut</span>
            </div>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <div class="alert-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="alert-message">{{ session('success') }}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <div class="alert-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="alert-message">{{ session('error') }}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    <!-- ===== CARTES PROFIL ===== -->
    <div class="cards-grid">
        <!-- Carte Informations personnelles -->
        <div class="card" data-aos="fade-up">
            <div class="card-header">
                <div class="card-title-wrapper">
                    <h3 class="card-title">Informations personnelles</h3>
                    <span class="card-badge badge-member">Lecture seule</span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nom</span>
                        <span class="info-value">{{ $user->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Membre depuis</span>
                        <span class="info-value">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Dernière mise à jour</span>
                        <span class="info-value">{{ $user->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Modifier le profil -->
        <div class="card" data-aos="fade-up" data-aos-delay="50">
            <div class="card-header">
                <div class="card-title-wrapper">
                    <h3 class="card-title">Modifier mon profil</h3>
                    <span class="card-badge badge-owner">Édition</span>
                </div>
            </div>
            
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}" class="profile-form">
                    @csrf
                    @method('patch')
                    
                    <div class="form-group">
                        <label class="form-label">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="form-input" required>
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Adresse email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="form-input" required>
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Carte Changer le mot de passe -->
        <div class="card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header">
                <div class="card-title-wrapper">
                    <h3 class="card-title">Changer le mot de passe</h3>
                    <span class="card-badge badge-owner">Sécurité</span>
                </div>
            </div>
            
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}" class="profile-form">
                    @csrf
                    @method('put')
                    
                    <div class="form-group">
                        <label class="form-label">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="form-input" required>
                        @error('current_password', 'updatePassword')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-input" required>
                        @error('password', 'updatePassword')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-input" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Carte Supprimer le compte -->
        <div class="card" data-aos="fade-up" data-aos-delay="150">
            <div class="card-header">
                <div class="card-title-wrapper">
                    <h3 class="card-title text-danger">Supprimer le compte</h3>
                    <span class="card-badge badge-danger">Dangereux</span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="warning-box">
                    <svg class="warning-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <p class="warning-text">
                        Cette action est irréversible. Toutes vos données (colocations, dépenses, invitations) seront définitivement supprimées.
                    </p>
                </div>
                
                <form method="post" action="{{ route('profile.destroy') }}" 
                      onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                    @csrf
                    @method('delete')
                    
                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-input" required>
                        @error('password', 'userDeletion')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-delete">
                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Supprimer mon compte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== STYLES IDENTIQUES À MES COLOCATIONS ===== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-green: #064e3b;
        --accent-green: #10b981;
        --bg-light: #f9fafb;
        --glow-green: rgba(16, 185, 129, 0.1);
        --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        --card-shadow-hover: 0 20px 30px -10px rgba(6, 78, 59, 0.15);
        --danger: #ef4444;
        --danger-light: #fee2e2;
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
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        z-index: 10;
    }

    /* ===== PAGE HEADER ===== */
    .page-header {
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
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon-wrapper {
        width: 3.5rem;
        height: 3.5rem;
        background: var(--glow-green);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent-green);
    }

    .header-icon {
        width: 2rem;
        height: 2rem;
    }

    .header-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.25rem;
        letter-spacing: -0.02em;
    }

    .header-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
    }

    /* Bouton retour */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1.75rem;
        background: white;
        color: var(--primary-green);
        text-decoration: none;
        border-radius: 14px;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s;
        border: 1px solid #e5e7eb;
        cursor: pointer;
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--accent-green);
    }

    .btn-icon {
        width: 1.25rem;
        height: 1.25rem;
        transition: transform 0.3s;
    }

    .btn-back:hover .btn-icon {
        transform: translateX(-4px);
    }

    /* Header stats */
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
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-green);
        line-height: 1;
    }

    .header-stat-label {
        font-size: 0.8rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0.25rem;
    }

    /* ===== ALERTES ===== */
    .alert {
        background: white;
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--card-shadow);
        border: 1px solid #e5e7eb;
        animation: slideDown 0.3s ease;
    }

    .alert-success {
        border-left: 4px solid var(--accent-green);
    }

    .alert-success .alert-icon {
        color: var(--accent-green);
    }

    .alert-error {
        border-left: 4px solid var(--danger);
    }

    .alert-error .alert-icon {
        color: var(--danger);
    }

    .alert-icon {
        width: 2rem;
        height: 2rem;
        flex-shrink: 0;
    }

    .alert-message {
        flex: 1;
        color: #374151;
    }

    .alert-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #9ca3af;
        cursor: pointer;
        padding: 0 0.5rem;
        transition: color 0.2s;
    }

    .alert-close:hover {
        color: #4b5563;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== GRILLE ===== */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    /* ===== CARTES ===== */
    .card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: all 0.3s;
        box-shadow: var(--card-shadow);
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--accent-green);
    }

    .card-header {
        padding: 1.5rem 1.5rem 0.5rem;
    }

    .card-title-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-green);
        line-height: 1.4;
    }

    .card-title.text-danger {
        color: var(--danger);
    }

    .card-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-member {
        background: var(--glow-green);
        color: var(--accent-green);
    }

    .badge-owner {
        background: var(--primary-green);
        color: white;
    }

    .badge-danger {
        background: var(--danger-light);
        color: var(--danger);
    }

    .card-body {
        padding: 1rem 1.5rem 1.5rem;
        flex: 1;
    }

    /* ===== INFORMATIONS ===== */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #6b7280;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .info-value {
        color: var(--primary-green);
        font-weight: 600;
        font-size: 1rem;
    }

    /* ===== FORMULAIRES ===== */
    .profile-form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary-green);
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent-green);
        box-shadow: 0 0 0 4px var(--glow-green);
    }

    .form-error {
        color: var(--danger);
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 0.5rem;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1.75rem;
        background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
        color: white;
        text-decoration: none;
        border-radius: 14px;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 20px rgba(6, 78, 59, 0.3);
    }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1.75rem;
        background: var(--danger);
        color: white;
        text-decoration: none;
        border-radius: 14px;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    .btn-delete:hover {
        transform: translateY(-2px) scale(1.02);
        background: #dc2626;
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    /* ===== WARNING BOX ===== */
    .warning-box {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        background: var(--danger-light);
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .warning-icon {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--danger);
        flex-shrink: 0;
    }

    .warning-text {
        color: #b91c1c;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .profile-container {
            padding: 1rem;
        }

        .header-main {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-left {
            width: 100%;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }

        .header-stats {
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-stat {
            flex: 1;
            min-width: 80px;
        }

        .cards-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            justify-content: stretch;
        }

        .btn-submit, .btn-delete {
            width: 100%;
            justify-content: center;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }
</style>

<!-- AOS pour les animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 600,
        once: true,
        offset: 50
    });
</script>
@endsection