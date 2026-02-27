@extends('layouts.app')

@section('title', 'Mes colocations')

@section('content')

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>
<div class="blob blob-3"></div>

<div class="colocations-container">
   
    <div class="page-header">
        <div class="header-main">
            <div class="header-left">
                <div class="header-icon-wrapper">
                    <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="header-text">
                    <h1 class="header-title">Mes colocations</h1>
                    <p class="header-subtitle">Gérez vos espaces de vie partagés</p>
                </div>
            </div>
            
            @php
                $user = auth()->user();
                $aUneColocationActive = DB::table('memberships')
                    ->where('user_id', $user->id)
                    ->whereNull('left_at')
                    ->exists();
                $peutCreerColocation = !$aUneColocationActive && !$user->estBanni();
            @endphp
            
            @if($peutCreerColocation)
                <a href="{{ route('colocations.create') }}" class="btn-create">
                    <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span class="btn-text">Nouvelle colocation</span>
                </a>
            @endif
        </div>

    
        <div class="header-stats">
            <div class="header-stat">
                <span class="header-stat-value">{{ $colocations->count() + $ownedColocations->count() }}</span>
                <span class="header-stat-label">Total</span>
            </div>
            <div class="header-stat">
                <span class="header-stat-value">{{ $colocations->count() }}</span>
                <span class="header-stat-label">Membre</span>
            </div>
            <div class="header-stat">
                <span class="header-stat-value">{{ $ownedColocations->count() }}</span>
                <span class="header-stat-label">Propriétaire</span>
            </div>
        </div>
    </div>

   
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

   
    @if($colocations->isNotEmpty())
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">
                    <span class="title-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                    Colocations actives
                </h2>
                <span class="section-count">{{ $colocations->count() }}</span>
            </div>
            
            <div class="cards-grid">
                @foreach($colocations as $colocation)
                    <div class="card" data-aos="fade-up">
                        <div class="card-header">
                            <div class="card-title-wrapper">
                                <h3 class="card-title">{{ $colocation->nom ?? $colocation->name }}</h3>
                                <span class="card-badge badge-member">Membre</span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <p class="card-description">{{ $colocation->description ?: 'Aucune description' }}</p>
                            
                            <div class="card-meta">
                                <div class="meta-item">
                                    <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span>{{ $colocation->membresActifs()->count() }} membre(s)</span>
                                </div>
                                <div class="meta-item">
                                    <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($colocation->created_at)->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('colocations.show', $colocation->id) }}" class="card-link">
                                <span>Voir les détails</span>
                                <svg class="link-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

   
    @if($ownedColocations->isNotEmpty())
        <section class="section">
            <div class="section-header">
                <h2 class="section-title">
                    <span class="title-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </span>
                    Colocations que je possède
                </h2>
                <span class="section-count">{{ $ownedColocations->count() }}</span>
            </div>
            
            <div class="cards-grid">
                @foreach($ownedColocations as $colocation)
                    <div class="card card-owned" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-header">
                            <div class="card-title-wrapper">
                                <h3 class="card-title">{{ $colocation->nom ?? $colocation->name }}</h3>
                                <span class="card-badge badge-owner">Propriétaire</span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <p class="card-description">{{ $colocation->description ?: 'Aucune description' }}</p>
                            
                            <div class="card-meta">
                                <div class="meta-item">
                                    <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span>{{ $colocation->membresActifs()->count() }} membre(s)</span>
                                </div>
                                <div class="meta-item">
                                    <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <span>{{ $colocation->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('colocations.show', $colocation->id) }}" class="card-link">
                                <span>Gérer la colocation</span>
                                <svg class="link-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif


    @if($colocations->isEmpty() && $ownedColocations->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="empty-title">Aucune colocation</h3>
            <p class="empty-text">Vous n'avez pas encore rejoint de colocation.</p>
            
            @if($peutCreerColocation)
                <a href="{{ route('colocations.create') }}" class="btn-empty">
                    <svg class="btn-empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Créer une colocation
                </a>
            @endif
        </div>
    @endif
</div>

<style>
  
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-green: #064e3b;
        --accent-green: #10b981;
        --bg-light: #f9fafb;
        --glow-green: rgba(16, 185, 129, 0.1);
        --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        --card-shadow-hover: 0 20px 30px -10px rgba(6, 78, 59, 0.15);
    }

   
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


    .colocations-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        z-index: 10;
    }

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

  
    .btn-create {
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

    .btn-create:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 20px rgba(6, 78, 59, 0.3);
    }

    .btn-icon {
        width: 1.25rem;
        height: 1.25rem;
        transition: transform 0.3s;
    }

    .btn-create:hover .btn-icon {
        transform: rotate(90deg);
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
        border-left: 4px solid #ef4444;
    }

    .alert-error .alert-icon {
        color: #ef4444;
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


    .section {
        margin-bottom: 3rem;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--primary-green);
    }

    .title-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: var(--glow-green);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent-green);
    }

    .section-count {
        background: var(--primary-green);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 999px;
        font-size: 1rem;
        font-weight: 600;
    }

  
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }


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

    .card-owned {
        border-left: 4px solid var(--accent-green);
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

    .card-body {
        padding: 0.5rem 1.5rem 1rem;
        flex: 1;
    }

    .card-description {
        color: #6b7280;
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        min-height: 2.8rem;
    }

    .card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 0.75rem 0;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.85rem;
    }

    .meta-icon {
        width: 1rem;
        height: 1rem;
        color: var(--accent-green);
        flex-shrink: 0;
    }

    .card-footer {
        padding: 1rem 1.5rem 1.5rem;
    }

    .card-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--accent-green);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .card-link:hover {
        gap: 0.75rem;
        color: var(--primary-green);
    }

    .link-icon {
        width: 1.2rem;
        height: 1.2rem;
        transition: transform 0.2s;
    }

    .card-link:hover .link-icon {
        transform: translateX(4px);
    }

   
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: var(--card-shadow);
    }

    .empty-icon {
        width: 5rem;
        height: 5rem;
        margin: 0 auto 1.5rem;
        color: #d1d5db;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: #6b7280;
        margin-bottom: 2rem;
    }

    .btn-empty {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
        color: white;
        text-decoration: none;
        border-radius: 14px;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(6, 78, 59, 0.2);
    }

    .btn-empty:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 20px rgba(6, 78, 59, 0.3);
    }

    .btn-empty-icon {
        width: 1.25rem;
        height: 1.25rem;
        transition: transform 0.3s;
    }

    .btn-empty:hover .btn-empty-icon {
        transform: rotate(90deg);
    }

 
    @media (max-width: 768px) {
        .colocations-container {
            padding: 1rem;
        }

        .header-main {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-left {
            width: 100%;
        }

        .btn-create {
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

        .card-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>


<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 600,
        once: true,
        offset: 50
    });

    
    document.querySelectorAll('.card').forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
</script>
@endsection