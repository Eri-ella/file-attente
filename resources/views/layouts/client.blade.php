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

    @yield('client-content')

    <footer class="bg-linear-to-t from-(--primary-color) to-(--blue-gradient-color) rounded-t-[100px] text-(--white-color) px-10 py-20">
        <div class="flex items-start justify-evenly">
            <div>
                <a href="{{  route('acceuil') }}"><img class="w-40" src="{{ asset('assets/smart-queue-light.png') }}" alt="smart queue logo"><a>
                <p class="max-w-100 mb-5">Prenez votre ticket où que vous soyez, et laissez l'algorithme gérer votre place dans la file.</p>
                <div class="flex gap-5 text-2xl">
                    <a href="#"><iconify-icon icon="ion:logo-facebook"></iconify-icon><a>
                    <a href="#"><iconify-icon icon="ion:social-github"></iconify-icon><a>
                    <a href="#"><iconify-icon icon="ion:social-whatsapp"></iconify-icon><a>
                    <a href="#"><iconify-icon icon="ion:mail-sharp"></iconify-icon><a>
                </div>
            </div>
            <div>
                <h4 class="text-xl font-medium mb-5">SERVICES</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="#">Passeport</a></li>
                    <li><a href="#">Etat civil</a></li>
                    <li><a href="#">Urbanisme</a></li>
                    <li><a href="#">Aide sociale</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-medium mb-5">COMPTE</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="{{ route('connexion') }}">Se connecter</a></li>
                    <li><a href="/inscription.html">Créer un compte</a></li>
                    <li><a href="/mdpOublie.html">Mot de passe oublié ?</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-medium mb-5">AIDE</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="{{ route('information') }}">Comment ça marche ?</a></li>
                    <li><a href="{{ route('information') }}">Contacts</a></li>
                    <li><a href="#">Mentions légales</a></li>
                </ul>
            </div>
        </div>
        <span class="flex w-[80%] h-px bg-gray-100 place-self-center my-10"></span>
        <p class="place-self-end">© 2026 Smart queue</p>
    </footer>
    @vite(['public/js/client.js'])
</body>
</html> 