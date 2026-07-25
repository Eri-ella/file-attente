<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConnexionAdmin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/connexionAdmin.css') }}">
</head>
<body class="h-screen flex flex-col">

    @include('admin.entete')

    <main class="flex w-full h-screen md:flex-row">
    
             @include('admin.gauche')
        
            @include('admin.droite')
    
        
</main>
    
</body>
</html>