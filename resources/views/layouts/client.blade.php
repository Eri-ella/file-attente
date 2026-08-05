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
    {{-- ✅ HEADER RESPONSIVE --}}
    <header class="bg-(--white-color) border-b-1 border-(--primary-color) w-full">
        <div class="flex items-center justify-between px-4 md:px-10 py-3">
            {{-- Logo --}}
            <a href="{{ route('acceuil') }}">
                <img class="w-25 md:w-35" src="{{ asset('assets/smart-queue-dark.png') }}" alt="smart queue logo">
            </a>

            {{-- ✅ MENU PC (visible uniquement sur md et plus) --}}
            <ul class="hidden md:flex justify-between gap-5 text-(--primary-color)">
                <li><a href="{{ route('acceuil') }}">Acceuil</a></li>
                <li><a href="{{ route('tousServices') }}">Services</a></li>
                <li><a href="{{ route('information') }}#contacts">Contacts</a></li>
            </ul>

            {{-- ✅ BARRE DE RECHERCHE (visible uniquement sur md et plus) --}}
            <form action="{{ route('tousServices') }}" method="GET" class="hidden md:flex items-center">
                <div class="flex items-center bg-(--white-color) rounded-full pl-3 pr-1 h-11 w-80 shadow-lg transition overflow-hidden">
                    <iconify-icon icon="boxicons:search" class="text-gray-500"></iconify-icon>
                    <input 
                        name="recherche"
                        class="outline-none placeholder-gray-400 text-black bg-transparent flex-1 px-2 text-sm" 
                        type="text" 
                        placeholder="ex : carte biométrique"
                    >
                    <button type="submit" class="self-stretch my-1 px-4 bg-[#222d52] hover:opacity-50 text-white text-sm font-semibold rounded-full whitespace-nowrap transition">
                        Rechercher
                    </button>
                </div>
            </form>

            {{-- Bouton Se connecter (visible sur PC) --}}
            <div class="hidden md:block">
                <button class="btn-secondary"><a href="{{ route('connexion') }}">Se connecter</a></button>
            </div>

            {{-- ✅ BOUTON HAMBURGER (visible uniquement sur mobile) --}}
            <button id="mobile-menu-btn" class="md:hidden text-(--primary-color) text-3xl">
                <iconify-icon icon="mdi:menu"></iconify-icon>
            </button>
        </div>

        {{-- ✅ MENU MOBILE (déroulant, caché par défaut) --}}
        <div id="mobile-menu" class="hidden md:hidden flex-col bg-(--white-color) border-t border-(--primary-color)/20 px-4 py-4 gap-4 text-(--primary-color)">
            <ul class="flex flex-col gap-3">
                <li><a href="{{ route('acceuil') }}" class="block py-2">Acceuil</a></li>
                <li><a href="{{ route('tousServices') }}" class="block py-2">Services</a></li>
                <li><a href="{{ route('information') }}#contacts" class="block py-2">Contacts</a></li>
            </ul>

            {{-- Barre de recherche mobile --}}
            <form action="{{ route('tousServices') }}" method="GET" class="flex items-center">
                <div class="flex items-center bg-(--white-color) rounded-full pl-3 pr-1 h-11 w-full shadow-lg transition overflow-hidden">
                    <iconify-icon icon="boxicons:search" class="text-gray-500"></iconify-icon>
                    <input 
                        name="recherche"
                        class="outline-none placeholder-gray-400 text-black bg-transparent flex-1 px-2 text-sm" 
                        type="text" 
                        placeholder="ex : carte biométrique"
                    >
                    <button type="submit" class="self-stretch my-1 px-4 bg-[#222d52] hover:opacity-50 text-white text-sm font-semibold rounded-full whitespace-nowrap transition">
                        Rechercher
                    </button>
                </div>
            </form>

            <button class="btn-secondary w-full"><a href="{{ route('connexion') }}" class="block w-full text-center">Se connecter</a></button>
        </div>
    </header>

    @yield('client-content')

    {{-- ✅ FOOTER RESPONSIVE --}}
    <footer class="bg-linear-to-t from-(--primary-color) to-(--blue-gradient-color) rounded-t-[50px] md:rounded-t-[100px] text-(--white-color) px-5 md:px-10 py-10 md:py-20">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-4">
            <div class="flex flex-col items-center md:items-start">
                <a href="{{ route('acceuil') }}">
                    <img class="w-32 md:w-40 mb-4" src="{{ asset('assets/smart-queue-light.png') }}" alt="smart queue logo">
                </a>
                <p class="text-center md:text-left mb-5">Prenez votre ticket où que vous soyez, et laissez l'algorithme gérer votre place dans la file.</p>
                <div class="flex gap-5 text-2xl">
                    <a href="#"><iconify-icon icon="ion:logo-facebook"></iconify-icon></a>
                    <a href="#"><iconify-icon icon="ion:social-github"></iconify-icon></a>
                    <a href="#"><iconify-icon icon="ion:social-whatsapp"></iconify-icon></a>
                    <a href="#"><iconify-icon icon="ion:mail-sharp"></iconify-icon></a>
                </div>
            </div>
            <div class="text-center md:text-left">
                <h4 class="text-xl font-medium mb-5">SERVICES</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="#">Passeport</a></li>
                    <li><a href="#">Etat civil</a></li>
                    <li><a href="#">Urbanisme</a></li>
                    <li><a href="#">Aide sociale</a></li>
                </ul>
            </div>
            <div class="text-center md:text-left">
                <h4 class="text-xl font-medium mb-5">COMPTE</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="{{ route('connexion') }}">Se connecter</a></li>
                    <li><a href="/inscription.html">Créer un compte</a></li>
                    <li><a href="/mdpOublie.html">Mot de passe oublié ?</a></li>
                </ul>
            </div>
            <div class="text-center md:text-left">
                <h4 class="text-xl font-medium mb-5">AIDE</h4>
                <ul class="flex flex-col gap-3">
                    <li><a href="{{ route('information') }}">Comment ça marche ?</a></li>
                    <li><a href="{{ route('information') }}#contacts">Contacts</a></li>
                    <li><a href="#">Mentions légales</a></li>
                </ul>
            </div>
        </div>
        <span class="flex w-[80%] h-px bg-gray-100 place-self-center my-10"></span>
        <p class="text-center md:text-right">© 2026 Smart queue</p>
    </footer>

    {{-- ✅ SCRIPT POUR LE MENU MOBILE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            
            if (btn && menu) {
                btn.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                    menu.classList.toggle('flex');
                });
            }
        });
    </script>

    @vite(['public/js/client.js'])
</body>
</html>