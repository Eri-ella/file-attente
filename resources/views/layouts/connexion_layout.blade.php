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

            {{-- ✅ BARRE DE RECHERCHE PC (visible sur md et plus) --}}
            <form action="" class="hidden md:flex items-center" onsubmit="event.preventDefault(); if (window.filtrerServices) filtrerServices();">
                <div class="flex items-center bg-(--white-color) rounded-full pl-3 pr-1 h-11 w-80 shadow-lg transition overflow-hidden">
                    <iconify-icon icon="boxicons:search" class="text-gray-500"></iconify-icon>
                    <input 
                        id="recherche-services" 
                        oninput="if (window.filtrerServices) filtrerServices();" 
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
            <form action="" class="flex items-center" onsubmit="event.preventDefault(); if (window.filtrerServicesMobile) filtrerServicesMobile();">
                <div class="flex items-center bg-(--white-color) rounded-full pl-3 pr-1 h-11 w-full shadow-lg transition overflow-hidden">
                    <iconify-icon icon="boxicons:search" class="text-gray-500"></iconify-icon>
                    <input 
                        id="recherche-services-mobile" 
                        oninput="if (window.filtrerServicesMobile) filtrerServicesMobile();" 
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

    @yield('connexion-content')

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

            // ✅ Fonction de filtrage pour la barre mobile
            window.filtrerServicesMobile = function() {
                const input = document.getElementById('recherche-services-mobile');
                if (!input) return;

                const recherche = input.value.toLowerCase().trim();
                const cards = document.querySelectorAll('.service-card');
                const noResults = document.getElementById('no-results');
                let visibleCount = 0;

                cards.forEach(card => {
                    const nom = card.dataset.nom || '';
                    const description = card.dataset.description || '';
                    const categorie = card.dataset.categorie || '';
                    const profil = card.dataset.profil || '';

                    const match = recherche === ''
                        || nom.includes(recherche)
                        || description.includes(recherche)
                        || categorie.includes(recherche)
                        || profil.includes(recherche);

                    card.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });

                if (noResults) {
                    noResults.classList.toggle('hidden', !(visibleCount === 0 && recherche !== ''));
                }
            };
        });
    </script>

    @vite(['public/js/client.js'])
</body>
</html>