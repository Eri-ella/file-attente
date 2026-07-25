<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>listeClient</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/listeClient.css') }}">
</head>
<body class="h-full flex flex-col">

    @include('manager.connexionmanager.entete')

    <div class="flex flex-1 flex-col md:flex-row">
        @include('manager.connexionmanager.gauche')
       
        <main class="flex-1">
            <iframe src="{{ route('manager.connexionmanager.droitetableau') }}" name="tableau" title="Tableau"  class="w-full h-full border-0"></iframe>
        </main>
    </div>
    
</body>
</html>