<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); padding: 40px 35px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #222D52; font-size: 24px; font-weight: 600; margin: 0; }
        .content { color: #333; font-size: 15px; line-height: 1.6; }
        .content p { margin: 12px 0; }
        .btn { display: inline-block; background: #222D52; color: #ffffff !important; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 500; margin: 20px 0 10px; transition: background 0.2s; }
        .btn:hover { background: #18213f; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #eaeaea; font-size: 13px; color: #888; text-align: center; }
        .subcopy { background: #f9f8f5; padding: 12px 16px; border-radius: 6px; font-size: 13px; color: #555; margin: 20px 0 0; word-break: break-all; }
        .subcopy a { color: #222D52; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div class="content">
            {{-- Greeting --}}
            @if (! empty($greeting))
                <h2 style="color: #222D52; font-weight: 500; margin-top: 0;">{{ $greeting }}</h2>
            @else
                @if ($level === 'error')
                    <h2 style="color: #e74c3c;">Whoops !</h2>
                @else
                    <h2 style="color: #222D52;">Bonjour !</h2>
                @endif
            @endif

            {{-- Intro Lines --}}
            @foreach ($introLines as $line)
                <p>{{ $line }}</p>
            @endforeach

            {{-- Action Button --}}
            @isset($actionText)
                <div style="text-align: center;">
                    <a href="{{ $actionUrl }}" class="btn">{{ $actionText }}</a>
                </div>
            @endisset

            {{-- Outro Lines --}}
            @foreach ($outroLines as $line)
                <p>{{ $line }}</p>
            @endforeach

            {{-- Salutation --}}
            @if (! empty($salutation))
                <p>{{ $salutation }}</p>
            @else
                <p>Cordialement,<br>{{ config('app.name') }}</p>
            @endif

            {{-- Subcopy (lien en texte brut) --}}
            @isset($actionText)
                <div class="subcopy">
                    Si vous avez des difficultés à cliquer sur le bouton "{{ $actionText }}", copiez et collez l'URL ci-dessous dans votre navigateur :<br>
                    <a href="{{ $actionUrl }}">{{ $actionUrl }}</a>
                </div>
            @endisset
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>