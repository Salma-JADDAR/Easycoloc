<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Invitation à rejoindre une colocation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #064e3b, #10b981);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px;
        }
        .info-box {
            background: #f9fafb;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #064e3b, #10b981);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin: 20px 0;
        }
        .btn:hover {
            background: linear-gradient(135deg, #10b981, #064e3b);
        }
        .footer {
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .details {
            margin: 10px 0;
        }
        .details strong {
            color: #064e3b;
            width: 120px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>EasyColoc</h1>
            <p>Invitation à rejoindre une colocation</p>
        </div>
        
        <div class="content">
            <h2>Bonjour !</h2>
            
            <!-- Ici on affiche qui a envoyé l'invitation -->
            <p><strong>{{ $invitation->inviteur->name ?? 'Un utilisateur' }}</strong> vous invite à rejoindre la colocation <strong>{{ $invitation->colocation->name }}</strong> sur EasyColoc.</p>
            
            <div class="info-box">
                <h3>Détails de la colocation :</h3>
                <div class="details">
                    <strong>Nom :</strong> {{ $invitation->colocation->name }}
                </div>
                <div class="details">
                    <strong>Description :</strong> {{ $invitation->colocation->description ?: 'Aucune description' }}
                </div>
                <div class="details">
                    <strong>Invitation envoyée par :</strong> {{ $invitation->inviteur->name ?? 'Utilisateur inconnu' }}
                </div>
                <div class="details">
                    <strong>Date d'expiration :</strong> {{ $invitation->expires_at->format('d/m/Y à H:i') }}
                </div>
            </div>
            
            <p>Pour accepter cette invitation, cliquez sur le bouton ci-dessous :</p>
            
            <!-- Le lien pour accepter l'invitation -->
            <a href="{{ route('invitations.show', $invitation->token) }}" class="btn">
                Voir l'invitation
            </a>
            
            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                Si le bouton ne fonctionne pas, copiez et collez ce lien :<br>
                <span style="color: #064e3b;">{{ route('invitations.show', $invitation->token) }}</span>
            </p>
            
            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                Cette invitation expirera le {{ $invitation->expires_at->format('d/m/Y à H:i') }}.
            </p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} EasyColoc. Tous droits réservés.</p>
            <p>Cet email a été envoyé à {{ $invitation->email }}</p>
        </div>
    </div>
</body>
</html>