<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation à rejoindre une colocation</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0a1f0e 0%, #1a4a22 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: 32px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2d8a3e, #3dba55);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .info-box {
            background: #f0faf2;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            margin-bottom: 15px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            width: 100px;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .info-value {
            flex: 1;
            font-weight: 500;
            color: #1f2937;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #e5e7eb;
            border-radius: 20px;
            font-size: 0.8rem;
            color: #4b5563;
        }

        .badge-success {
            background: #2d8a3e;
            color: white;
        }

        .badge-warning {
            background: #fbbf24;
            color: #92400e;
        }

        .badge-danger {
            background: #ef4444;
            color: white;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-success {
            background: #2d8a3e;
            color: white;
        }

        .btn-success:hover {
            background: #1a4a22;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(45,138,62,0.3);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #4b5563;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: rgba(255,255,255,0.7);
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>EasyColoc</h1>
                <p>Invitation à rejoindre une colocation</p>
            </div>

            <div class="content">
                @if($invitation->status === 'accepted')
                    <div class="text-center">
                        <svg class="w-16 h-16 text-green-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Invitation déjà acceptée</h2>
                        <p class="text-gray-600 mb-6">Cette invitation a déjà été utilisée.</p>
                        <a href="{{ route('login') }}" class="btn btn-success">Se connecter</a>
                    </div>
                @elseif($invitation->status === 'declined')
                    <div class="text-center">
                        <svg class="w-16 h-16 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Invitation refusée</h2>
                        <p class="text-gray-600 mb-6">Vous avez refusé cette invitation.</p>
                        <a href="{{ route('login') }}" class="btn btn-success">Se connecter</a>
                    </div>
                @elseif($invitation->estExpiree())
                    <div class="text-center">
                        <svg class="w-16 h-16 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Invitation expirée</h2>
                        <p class="text-gray-600 mb-6">Cette invitation a expiré le {{ $invitation->expires_at->format('d/m/Y à H:i') }}.</p>
                        <p class="text-sm text-gray-500 mb-6">Contactez le propriétaire pour une nouvelle invitation.</p>
                        <a href="{{ route('login') }}" class="btn btn-success">Se connecter</a>
                    </div>
                @else
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Vous êtes invité !</h2>
                    
                    <div class="info-box">
                        <div class="info-item">
                            <span class="info-label">Colocation</span>
                            <span class="info-value">{{ $invitation->colocation->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Description</span>
                            <span class="info-value">{{ $invitation->colocation->description ?: 'Aucune description' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Invité par</span>
                            
                            <span class="info-value">{{ $invitation->inviteur->name ?? 'Utilisateur inconnu' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date d'envoi</span>
                            <span class="info-value">{{ $invitation->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Expire le</span>
                            <span class="info-value">
                                {{ $invitation->expires_at->format('d/m/Y à H:i') }}
                                <span class="badge badge-warning ml-2">7 jours</span>
                            </span>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Note :</strong> Vous devez avoir un compte avec l'email <strong>{{ $invitation->email }}</strong> pour accepter cette invitation.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="actions">
                        <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Accepter l'invitation
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('invitations.decline', $invitation->token) }}" style="flex: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Refuser
                            </button>
                        </form>
                    </div>

                    <p class="text-center text-sm text-gray-500 mt-4">
                        En acceptant, vous rejoindrez la colocation et pourrez commencer à gérer les dépenses.
                    </p>
                @endif
            </div>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} EasyColoc. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>