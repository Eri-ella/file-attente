<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pageManager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex flex-col">

    @include('manager.entete')

    <div class="flex flex-1 flex-col md:flex-row">
        @include('manager.gauche')
        @include('manager.droite')
    </div>
    
</body>
</html>