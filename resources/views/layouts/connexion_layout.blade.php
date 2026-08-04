<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    @vite(['public/js/client.js'])
</head>
<body>
    <header class="flex items-center justify-between bg-(--white-color) border-b-1 border-(--primary-color) w-full px-10">
        <a href="{{  route('acceuil') }}"><img class="w-35" src="{{ asset('assets/smart-queue-dark.png') }}" alt="smart queue logo"><a>
        <ul class="flex justify-between gap-5 text-(--primary-color)">
            <li><a href="{{ route('acceuil') }}">Acceuil</a></li>
            <li><a href="{{ route('tousServices') }}">Services</a></li>
            <li><a href="{{ route('information') }}">Contacts</a></li>
        </ul>
        <form action=""  class="flex items-center justify-center">
            <div class="flex bg-(--white-color) py-1 px-2 rounded-tl-lg rounded-br-lg top-5 hover:bg-gray-100 shadow-lg">
                <input class="outline-none placeholder-gray-400" type="text" name="" id="" placeholder="ex : carte biométrique">
                <iconify-icon icon="boxicons:search" class="mt-1 text-gray-400 cursor-pointer"></iconify-icon>
            </div>
        </form>
        <div>
            <button class="btn-secondary"><a href="{{ route('connexion') }}">Se connecter</a></button>
        </div>
    </header>

    @yield('connexion-content')

    @vite(['public/js/client.js'])
</body>
</html> 