<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket annulé définitivement</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #c53030;">❌ Ticket annulé définitivement</h2>
        <p>Bonjour,</p>
        <p>Votre ticket <strong>{{ $ticket->numero }}</strong> a été annulé suite à <strong>3 absences</strong> au guichet.</p>
        <p>Si vous souhaitez obtenir un nouveau ticket, vous devez effectuer une nouvelle réservation.</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #666;">Ceci est un message automatique, merci de ne pas y répondre.</p>
    </div>
</body>
</html>