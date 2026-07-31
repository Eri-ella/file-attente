<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['public/js/manager.js'])
</head>
<body>
    @include('manager.entete')

    <main class="flex w-full h-screen">
        @include('manager.gauche')
        @include('manager.droite')
    </main>
</body>
</html>