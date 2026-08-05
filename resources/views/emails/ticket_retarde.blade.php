<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avertissement : retard détecté</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #c05621;">⚠️ Avertissement : absence au guichet</h2>
        <p>Bonjour,</p>
        <p>Vous n'étiez pas présent lors de l'appel de votre ticket <strong>{{ $ticket->numero }}</strong>.</p>
        <p>Votre ticket a été décalé en fin de file. C'est votre <strong>{{ $ticket->nombre_retards }}<sup>ème</sup> retard</strong> sur 3 autorisés.</p>
        <p>Au 3<sup>ème</sup> retard, votre ticket sera définitivement annulé.</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #666;">Ceci est un message automatique, merci de ne pas y répondre.</p>
    </div>
</body>
</html>