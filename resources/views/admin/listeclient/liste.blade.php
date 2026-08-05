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

    @include('admin.listeclient.entete')
    <main class="flex size-full md:flex-row  ">

        <div class="flex w-1/6">
            @include('admin.listeclient.gauche')
        </div>
        <div  class="flex w-5/6">
            <iframe class="w-full" src="{{ route('admin.listeclient.droitecli') }}" name="tableau" title="Tableau"  class="w-full h-full border-0"></iframe>
        
        </div>
    </main>
    </body>
</html>
