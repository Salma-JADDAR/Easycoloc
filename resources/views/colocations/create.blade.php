@extends('layouts.app')

@section('title', 'Créer une colocation')

@section('content')
<div class="dashboard">
 
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container">
       
        <div class="page-header">
            <div class="header-content">
                <div class="header-title-section">
                    <h1 class="header-title">
                        Créer une <span class="header-highlight">colocation</span>
                    </h1>
                    <p class="header-subtitle">Créez votre espace et invitez vos colocataires</p>
                </div>
            </div>
        </div>

     
        <div class="form-card">
            <form method="POST" action="{{ route('colocations.store') }}" class="form-container">
                @csrf

                <!-- Nom de la colocation -->
                <div class="form-group">
                    <label for="name" class="form-label">
                        Nom de la colocation <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           required
                           class="form-input"
                           placeholder="Ex: Appartement des Lilas">
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">
                        Description <span class="optional">(optionnel)</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="5"
                              class="form-textarea"
                              placeholder="Décrivez votre colocation...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informations -->
                <div class="info-box">
                    <div class="info-content">
                        <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="info-text">
                                Vous serez automatiquement désigné comme propriétaire de cette colocation.
                                Vous pourrez ensuite inviter d'autres membres.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="form-actions">
                    <a href="{{ route('colocations.index') }}" class="btn-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Créer la colocation
                    </button>
                </div>
            </form>
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

    /* Container */
    .container {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* Page Header */
    .page-header {
        position: relative;
        margin-bottom: 2rem;
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
        position: relative;
        z-index: 1;
    }

    .header-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.5rem;
        font-weight: 300;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }

    .header-highlight {
        color: var(--accent-green);
        font-style: italic;
    }

    .header-subtitle {
        color: var(--gray-500);
        font-size: 1rem;
        font-weight: 300;
    }

    /* Formulaire */
    .form-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(6, 78, 59, 0.1);
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(6, 78, 59, 0.05);
    }

    .form-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--primary-green);
        letter-spacing: 0.05em;
    }

    .required {
        color: #dc2626;
        margin-left: 0.25rem;
    }

    .optional {
        color: var(--gray-400);
        font-size: 0.8rem;
        font-weight: 300;
        margin-left: 0.25rem;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        color: var(--primary-green);
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--accent-green);
        box-shadow: 0 0 0 4px var(--glow-green);
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-error {
        font-size: 0.8rem;
        color: #dc2626;
        margin-top: 0.25rem;
    }

    /* Info box */
    .info-box {
        background: var(--glow-green);
        border: 1px solid var(--accent-green);
        border-radius: 12px;
        padding: 1rem;
        margin: 0.5rem 0;
    }

    .info-content {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .info-icon {
        width: 1.25rem;
        height: 1.25rem;
        color: var(--accent-green);
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .info-text {
        color: var(--primary-green);
        font-size: 0.9rem;
        font-weight: 300;
        line-height: 1.5;
    }

    /* Boutons */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 1rem;
    }

    .btn-primary,
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: var(--primary-green);
        color: white;
        box-shadow: 0 10px 20px rgba(6, 78, 59, 0.15);
    }

    .btn-primary:hover {
        background: #08634c;
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(6, 78, 59, 0.2);
    }

    .btn-secondary {
        background: var(--gray-100);
        color: var(--gray-700);
    }

    .btn-secondary:hover {
        background: var(--gray-200);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard {
            padding: 1rem;
        }

        .header-title {
            font-size: 2rem;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
        }
    }
</style>
@endsection