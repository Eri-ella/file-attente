<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    @vite(['public/js/client.js'])

    {{-- ✅ CSS pour l'entête fixe --}}
    <style>
        #sticky-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 50;
            transform: translateY(-100%);
            transition: transform 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background: white;
        }
        #sticky-header.visible {
            transform: translateY(0);
        }
        /* Carte Google Maps responsive */
        .map-container iframe {
            width: 100%;
            height: 450px;
            max-width: 100%;
        }
        @media (max-width: 768px) {
            .map-container iframe {
                height: 300px;
            }
        }
    </style>
</head>
<body>

    {{-- ✅ ENTÊTE STICKY CLAIR (responsive) --}}
    <div id="sticky-header">
        <header class="bg-(--white-color) border-b-1 border-(--primary-color) w-full">
            <div class="flex items-center justify-between px-4 md:px-10 py-2">
                <a href="{{ route('acceuil') }}">
                    <img class="w-25 md:w-35" src="{{ asset('assets/smart-queue-dark.png') }}" alt="smart queue logo">
                </a>

                {{-- Menu PC --}}
                <ul class="hidden md:flex justify-between gap-5 text-(--primary-color)">
                    <li><a href="{{ route('acceuil') }}">Acceuil</a></li>
                    <li><a href="{{ route('tousServices') }}">Services</a></li>
                    <li><a href="{{ route('information') }}#contacts">Contacts</a></li>
                </ul>

                {{-- Barre de recherche PC --}}
                <form action="" class="hidden md:flex items-center" onsubmit="event.preventDefault(); if (window.filtrerServices) filtrerServices();">
                    <div class="flex items-center bg-(--white-color) rounded-full pl-3 pr-1 h-11 w-80 shadow-lg transition overflow-hidden">
                        <iconify-icon icon="boxicons:search" class="text-gray-500"></iconify-icon>
                        <input 
                            id="recherche-services-sticky" 
                            oninput="if (window.filtrerServices) filtrerServices(this);" 
                            class="outline-none placeholder-gray-400 text-black bg-transparent flex-1 px-2 text-sm" 
                            type="text" 
                            placeholder="ex : carte biométrique"
                        >
                        <button type="submit" class="self-stretch my-1 px-4 bg-[#222d52] hover:opacity-50 text-white text-sm font-semibold rounded-full whitespace-nowrap transition">
                            Rechercher
                        </button>
                    </div>
                </form>

                <div class="hidden md:block">
                    <button class="btn-secondary"><a href="{{ route('connexion') }}">Se connecter</a></button>
                </div>

                {{-- Bouton hamburger mobile --}}
                <button id="mobile-menu-btn-sticky" class="md:hidden text-(--primary-color) text-3xl">
                    <iconify-icon icon="mdi:menu"></iconify-icon>
                </button>
            </div>

            {{-- Menu mobile sticky --}}
            <div id="mobile-menu-sticky" class="hidden md:hidden flex-col bg-(--white-color) border-t border-(--primary-color)/20 px-4 py-4 gap-4 text-(--primary-color)">
                <ul class="flex flex-col gap-3">
                    <li><a href="{{ route('acceuil') }}" class="block py-2">Acceuil</a></li>
                    <li><a href="{{ route('tousServices') }}" class="block py-2">Services</a></li>
                    <li><a href="{{ route('information') }}#contacts" class="block py-2">Contacts</a></li>
                </ul>
                <form action="" class="flex items-center" onsubmit="event.preventDefault(); if (window.filtrerServices) filtrerServices();">
                    <div class="flex items-center bg-(--white-color) rounded-full pl-3 pr-1 h-11 w-full shadow-lg transition overflow-hidden">
                        <iconify-icon icon="boxicons:search" class="text-gray-500"></iconify-icon>
                        <input 
                            id="recherche-services-sticky-mobile" 
                            oninput="if (window.filtrerServices) filtrerServices(this);" 
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
    </div>

    {{-- ✅ ENTÊTE BLEU FONCÉ (responsive) --}}
    <header class="bg-(--primary-color) w-full">
        <div class="flex items-center justify-between px-4 md:px-15 py-3">
            <a href="{{ route('acceuil') }}">
                <img class="w-25 md:w-35" src="{{ asset('assets/smart-queue-light.png') }}" alt="smart queue logo">
            </a>

            <ul class="hidden md:flex justify-between gap-5 text-(--white-color)">
                <li><a href="{{ route('acceuil') }}">Acceuil</a></li>
                <li><a href="{{ route('tousServices') }}">Services</a></li>
                <li><a href="{{ route('information') }}#contacts">Contacts</a></li>
            </ul>

            <div class="hidden md:block">
                <button class="btn-secondary"><a href="{{ route('connexion') }}">Se connecter</a></button>
            </div>

            <button id="mobile-menu-btn" class="md:hidden text-(--white-color) text-3xl">
                <iconify-icon icon="mdi:menu"></iconify-icon>
            </button>
        </div>

        {{-- Menu mobile bleu foncé --}}
        <div id="mobile-menu" class="hidden md:hidden flex-col bg-(--primary-color) border-t border-(--white-color)/20 px-4 py-4 gap-4 text-(--white-color)">
            <ul class="flex flex-col gap-3">
                <li><a href="{{ route('acceuil') }}" class="block py-2">Acceuil</a></li>
                <li><a href="{{ route('tousServices') }}" class="block py-2">Services</a></li>
                <li><a href="{{ route('information') }}#contacts" class="block py-2">Contacts</a></li>
            </ul>
            <button class="btn-secondary w-full"><a href="{{ route('connexion') }}" class="block w-full text-center">Se connecter</a></button>
        </div>
    </header>

    <main>
        {{-- ✅ SECTION HÉRO (responsive) --}}
        <section class="flex items-center rounded-b-[50px] md:rounded-b-[100px] text-(--white-color) p-5 md:p-10 gap-5 md:gap-10 mb-10 min-h-[80vh] md:h-[80vh] relative bg-cover bg-center" style="background-image: url('{{ asset('assets/image-bg.png') }}');">
            <div class="flex flex-col md:flex-row items-center gap-10 md:gap-20 w-full">
                <div class="flex flex-col gap-5 pl-0 md:pl-5 text-center md:text-left">
                    <h2 class="text-2xl md:text-4xl font-medium">Votre place dans la file d'attente, directement dans votre poche.</h2>
                    <p class="text-sm md:text-base">Trouvez vos établissements favoris, estimez votre temps d'attente grâce à notre algorithme en direct et payez vos services en un clic. L'application indispensable pour ne plus jamais perdre une minute dans un hall d'accueil.</p>
                    <div class="flex flex-col sm:flex-row items-center gap-4 md:gap-10">
                        <button class="btn-secondary w-full sm:w-auto"><a href="{{ route('information') }}">Apprendre à réserver</a></button>
                        <button class="btn-secondary w-full sm:w-auto"><a href="{{ route('ticket') }}">Voir mes tickets</a></button>
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="container">
                        <div class="car1">
                            <div class="progress-circle">
                                <svg class="circle-container" width="150" height="150">
                                    <circle class="gray-circle" cx="75" cy="75" r="30" fill="none" stroke="#222D52" stroke-width="10"/>
                                    <circle class="blue-circle" cx="75" cy="75" r="30" fill="none" stroke="#D2B589" stroke-width="10"/>
                                </svg>
                                <iconify-icon class="ticket-icon" icon="griddy-icons:ticket"></iconify-icon>
                                <div class="timer">
                                    <span id="hour">5</span>:<span id="minute">45</span>
                                </div>
                            </div>
                        </div>
                        <div class="car2"></div>
                        <div class="car3"></div>
                        <div class="car4">
                            <div class="progress-time">
                                <svg class="time-container" width="100" height="100">
                                    <circle class="big-circle" cx="50" cy="50" r="40" fill="#222D52"/>
                                    <circle class="little-circle" cx="50" cy="50" r="2" fill="#D2B589"/>
                                    <line class="minute-line" x1="50" y1="50" x2="75" y2="70" stroke="#D2B589"/>
                                    <line class="hour-line" x1="50" y1="50" x2="50" y2="30" stroke="#D2B589"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ✅ BARRE DE RECHERCHE IMPOSANTE (style Affluences) --}}
            <div id="hero-search" class="absolute left-1/2 -translate-x-1/2 bottom-[-28px] md:bottom-[-38px] w-[92%] max-w-4xl">
                <form action="" class="flex items-center" onsubmit="event.preventDefault(); if (window.filtrerServices) filtrerServices();">
                    <div class="flex items-center bg-(--white-color) rounded-full pl-5 md:pl-7 pr-1.5 md:pr-2 h-14 md:h-20 w-full shadow-2xl transition overflow-hidden">
                        <iconify-icon icon="boxicons:search" class="text-gray-600 text-xl md:text-3xl"></iconify-icon>
                        <input 
                            id="recherche-services" 
                            oninput="if (window.filtrerServices) filtrerServices(this);" 
                            class="outline-none placeholder-gray-400 text-black bg-transparent flex-1 px-3 md:px-5 text-sm md:text-lg" 
                            type="text" 
                            placeholder="ex : carte biométrique"
                        >
                        <button type="submit" class="self-stretch my-1.5 md:my-2 px-6 md:px-12 bg-[#222d52] hover:opacity-50 text-white text-sm md:text-lg font-semibold rounded-full whitespace-nowrap transition">
                            Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </section>

        {{-- ✅ SECTION SERVICES (responsive) --}}
        <section class="flex flex-col text-(--primary-color) gap-4 md:gap-6 p-5 md:p-10 mt-14 md:mt-16 mb-10">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl md:text-4xl font-medium">Services</h2>
                <div class="flex items-center gap-3">
                    <span class="w-7 h-7 flex items-center justify-center text-(--white-color) rounded-full bg-(--primary-color) cursor-pointer">
                        <button id="buttonLeft" class="flex items-center justify-center bg-transparent border-none text-white cursor-pointer">
                            <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                        </button>
                    </span>
                    <span id="buttonRight" class="w-7 h-7 flex items-center justify-center text-(--white-color) rounded-full bg-(--primary-color) cursor-pointer">
                        <button class="flex items-center justify-center bg-transparent border-none text-white cursor-pointer">
                            <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                        </button>
                    </span>
                </div>
            </div>

            <div class="flex gap-5 overflow-x-auto w-full pb-4" id="slidedContainer">
                @for ($i = 0; $i < 7; $i++)
                <div 
                    class="service-card flex flex-col shrink-0 w-65 md:w-75 h-75 justify-between gap-2 p-5 bg-(--white-color) rounded-tl-lg rounded-br-lg shadow-lg slided-elt transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer"
                    data-nom="{{ strtolower($services[$i]->nom) }}"
                    data-description="{{ strtolower($services[$i]->description) }}"
                >
                    <div class="flex items-center gap-5">
                        <div class="w-20 h-20 flex items-center justify-center text-5xl">
                            <iconify-icon icon="mdi:car"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="font-medium uppercase text-sm md:text-base">{{ $services[$i]->nom}}</h4>
                        </div>
                    </div>
                    <div class="h-30 overflow-hidden">
                        <p class="text-sm">{{ $services[$i]->description }}</p>
                    </div>
                    <span>. . .</span>
                    <div>
                        <span></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>
                            <p class="text-xs">Durée moy. {{ \Carbon\Carbon::parse($services[$i]->duree)->format('H') * 60 + \Carbon\Carbon::parse($services[$i]->duree)->format('i') }} min</p>
                        </span>
                        <span class="btn-secondary">
                            <button>
                                <a href="{{ route('service.show', $services[$i]->id) }}" class="btn-secondary">Lire la suite</a>
                            </button>
                        </span>
                    </div>
                </div>
                @endfor
            </div>
        </section>

        {{-- ✅ SECTION STATS (responsive) --}}
        <section class="grid grid-cols-2 md:grid-cols-4 text-(--primary-color) p-5 md:p-10 divide-x-0 md:divide-x-1 divide-y-1 md:divide-y-0 divide-(--primary-color) stats-section mb-10 md:mb-20" id="statsSection">
            <span class="w-full flex flex-col items-center justify-center card stat-card p-4" data-value="{{ $ticketsMois }}" data-suffix="">
                <div class="odometer-display"></div>
                <p class="text-sm text-center">tickets délivrées ce mois</p>
            </span>
            <span class="w-full flex flex-col items-center justify-center card stat-card p-4" data-value="{{ $attenteMoyenne }}" data-suffix="min">
                <div class="odometer-display"></div>
                <p class="text-sm text-center">attente moyenne</p>
            </span>
            <span class="w-full flex flex-col items-center justify-center card stat-card p-4" data-value="{{ $nbServices }}" data-suffix="">
                <div class="odometer-display"></div>
                <p class="text-sm text-center">services disponibles</p>
            </span>
            <span class="w-full flex flex-col items-center justify-center card stat-card p-4" data-value="{{ $pourcentageALHeure }}" data-suffix="%">
                <div class="odometer-display"></div>
                <p class="text-sm text-center">clients reçus à l'heure</p>
            </span>
        </section>

        @php
        $serviceIcon = function($nom) {
            $nom = strtolower($nom);
            if (str_contains($nom, 'passeport')) return 'mdi:passport';
            if (str_contains($nom, 'carte') || str_contains($nom, 'grise') || str_contains($nom, 'biométrique')) return 'mdi:card-account-details';
            if (str_contains($nom, 'urbanisme') || str_contains($nom, 'construction')) return 'mdi:home-city';
            if (str_contains($nom, 'état') || str_contains($nom, 'civil')) return 'mdi:file-document';
            if (str_contains($nom, 'aide') || str_contains($nom, 'social')) return 'mdi:hand-heart';
            if (str_contains($nom, 'permis') || str_contains($nom, 'conduire')) return 'mdi:car-key';
            return 'mdi:office-building';
        };
        @endphp

        {{-- ✅ PODIUM TOP SERVICES (responsive) --}}
        <section class="flex flex-col items-center justify-center text-(--primary-color) mb-10 px-5 md:px-10" id="topServicesSection">
            <h3 class="text-2xl md:text-4xl font-medium mb-5 text-center">Les services les plus réservés</h3>
            
            {{-- Mobile : empilé / PC : podium --}}
            <div class="flex flex-col md:flex-row md:items-end gap-4 w-full md:w-auto">
                
                {{-- 2ème place --}}
                @if(isset($topServices[1]))
                <div class="order-2 md:order-1 flex flex-col items-center justify-center text-center card2 top-service-side">
                    <div class="w-25 h-25 md:w-30 md:h-30 flex items-center justify-center text-5xl md:text-7xl bg-(--white-color) rounded-full service-icon-wrap">
                        <iconify-icon icon="{{ $serviceIcon($topServices[1]->nom) }}"></iconify-icon>
                    </div>
                    <h4 class="font-medium max-w-50 mt-4">{{ $topServices[1]->nom }}</h4>
                    <p class="text-xs text-gray-500 mt-1 side-counter" data-value="{{ $topServices[1]->total_reservations }}">{{ $topServices[1]->total_reservations }} réservations</p>
                </div>
                @endif

                {{-- 1ère place --}}
                @if(isset($topServices[0]))
                <div class="order-1 md:order-2 flex flex-col justify-center items-center bg-(--white-color) px-2 py-5 min-h-80 md:min-h-100 mb-5 shadow-lg rounded-tl-lg rounded-br-lg card2 top-service-center w-full md:w-auto">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div class="w-25 h-25 md:w-30 md:h-30 flex items-center justify-center text-5xl md:text-7xl bg-(--bg-color) rounded-full mb-5 service-icon-wrap">
                            <iconify-icon icon="{{ $serviceIcon($topServices[0]->nom) }}"></iconify-icon>
                        </div>
                        <h4 class="font-medium max-w-50">{{ $topServices[0]->nom }}</h4>
                    </div>
                    <div class="grid grid-cols-3 text-(--primary-color) p-4 md:p-10 divide-x-1 divide-(--primary-color) w-full">
                        <span class="w-full flex flex-col items-center justify-center p-1">
                            <div class="odometer-display-sm" data-value="{{ $topServices[0]->reservation_pct }}" data-suffix="%"></div>
                            <p class="text-xs text-center">de réservations</p>
                        </span>
                        <span class="w-full flex flex-col items-center justify-center p-1">
                            <div class="odometer-display-sm" data-value="{{ $topServices[0]->satisfaction_pct }}" data-suffix="%"></div>
                            <p class="text-xs text-center">de satisfaction</p>
                        </span>
                        <span class="w-full flex flex-col items-center justify-center p-1">
                            <div class="odometer-display-sm" data-value="{{ $topServices[0]->cout ?? 0 }}" data-suffix=" fcfa"></div>
                            <p class="text-xs text-center">à dépenser</p>
                        </span>
                    </div>
                    <p class="text-xs">Durée moy. {{ $topServices[0]->duree_minutes }} min</p>
                </div>
                @endif

                {{-- 3ème place --}}
                @if(isset($topServices[2]))
                <div class="order-3 flex flex-col items-center justify-center text-center card2 top-service-side">
                    <div class="w-25 h-25 md:w-30 md:h-30 flex items-center justify-center text-5xl md:text-7xl bg-(--white-color) rounded-full service-icon-wrap">
                        <iconify-icon icon="{{ $serviceIcon($topServices[2]->nom) }}"></iconify-icon>
                    </div>
                    <h4 class="font-medium max-w-50 mt-4">{{ $topServices[2]->nom }}</h4>
                    <p class="text-xs text-gray-500 mt-1 side-counter" data-value="{{ $topServices[2]->total_reservations }}">{{ $topServices[2]->total_reservations }} réservations</p>
                </div>
                @endif

            </div>
            <div class="mt-6">
                <button class="btn-secondary btn-explore"><a href="{{ route('tousServices') }}">Explorer les services</a></button>
            </div>
        </section>

        {{-- ✅ SECTION CARTE (responsive) --}}
        <section class="flex flex-col items-center justify-center text-(--primary-color) mb-10 px-5 md:px-10">
            <h3 class="text-2xl md:text-4xl font-medium mb-5 text-center">Où nous retrouver ?</h3>
            <div class="map-container w-full">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7930.283789706511!2d2.4132353999999996!3d6.3756767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102355a370a3da01%3A0x259bf9725256151!2sMairie%20de%20Cotonou!5e0!3m2!1sfr!2sbj!4v1784631435816!5m2!1sfr!2sbj" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </section>
    </main>

    {{-- ✅ FOOTER (responsive) --}}
    <footer class="bg-linear-to-t from-(--primary-color) to-(--blue-gradient-color) rounded-t-[50px] md:rounded-t-[100px] text-(--white-color) px-5 md:px-10 py-10 md:py-20">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-4">
            <div class="flex flex-col items-center md:items-start">
                <img class="w-32 md:w-40 mb-4" src="/assets/smart-queue-light.png" alt="smart queue logo">
                <p class="text-center md:text-left max-w-100 mb-5">Prenez votre ticket où que vous soyez, et laissez l'algorithme gérer votre place dans la file.</p>
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

    {{-- ✅ SCRIPTS (menu hamburger + sticky + filtrage) --}}
    <script>
        // Filtrage des cartes (fonctionne avec toutes les barres)
        window.filtrerServices = function(input) {
            if (!input) input = document.getElementById('recherche-services');
            if (!input) return;

            const recherche = input.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.service-card');
            const noResults = document.getElementById('no-results');
            let visibleCount = 0;

            cards.forEach(card => {
                const nom = card.dataset.nom || '';
                const description = card.dataset.description || '';

                const match = recherche === ''
                    || nom.includes(recherche)
                    || description.includes(recherche);

                card.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            if (noResults) {
                noResults.classList.toggle('hidden', !(visibleCount === 0 && recherche !== ''));
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Entrée = rechercher (toutes les barres)
            document.querySelectorAll('input[id^="recherche-services"]').forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        filtrerServices(input);
                    }
                });
            });

            // ✅ Menu hamburger - entête bleu foncé
            const btnTop = document.getElementById('mobile-menu-btn');
            const menuTop = document.getElementById('mobile-menu');
            if (btnTop && menuTop) {
                btnTop.addEventListener('click', function() {
                    menuTop.classList.toggle('hidden');
                    menuTop.classList.toggle('flex');
                });
            }

            // ✅ Menu hamburger - entête sticky clair
            const btnSticky = document.getElementById('mobile-menu-btn-sticky');
            const menuSticky = document.getElementById('mobile-menu-sticky');
            if (btnSticky && menuSticky) {
                btnSticky.addEventListener('click', function() {
                    menuSticky.classList.toggle('hidden');
                    menuSticky.classList.toggle('flex');
                });
            }

            // ✅ Entête sticky au scroll
            const sticky = document.getElementById('sticky-header');
            const heroSearch = document.getElementById('hero-search');
            if (!sticky || !heroSearch) return;

            const onScroll = () => {
                if (heroSearch.getBoundingClientRect().bottom < 0) {
                    sticky.classList.add('visible');
                } else {
                    sticky.classList.remove('visible');
                }
            };

            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        });
    </script>

    @vite(['public/js/client.js'])
</body>
</html>