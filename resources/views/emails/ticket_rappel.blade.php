<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel : votre passage approche</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #d69e2e;">⏰ Rappel : votre passage dans 10 minutes</h2>
        <p>Bonjour,</p>
        <p>Votre ticket <strong>{{ $ticket->numero }}</strong> pour le service <strong>{{ $ticket->reservation->service->nom }}</strong> est estimé à <strong>{{ $ticket->heure_estimee->format('H:i') }}</strong>.</p>
        <p>Veuillez vous préparer à vous présenter à l'accueil.</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #666;">Ceci est un message automatique, merci de ne pas y répondre.</p>
    </div>
</body>
</html>