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
    <header class="flex items-center justify-between bg-(--primary-color) w-[100%] px-10">
        <a href="{{  route('acceuil') }}"><img class="w-35" src={{ asset('assets/smart-queue-light.png') }} alt="smart queue logo"></a>
        <ul class="flex justify-between gap-5 text-(--white-color)">
            <li><a href="{{  route('acceuil') }}">Acceuil</a></li>
            <li><a href="{{ route('tousServices') }}">Services</a></li>
            <li><a href="{{ route('information') }}">Contacts</a></li>
        </ul>
        <div>
            <button class="btn-secondary"><a href="{{ route('connexion') }}">Se connecter</a></button>
        </div>
    </header>

    <main>
        <section class="bg-linear-to-b from-(--primary-color) to-(--blue-gradient-color) rounded-b-[100px] text-(--white-color) p-10 gap-10 mb-10">
            <div class="flex items-center gap-20">
                <div class="flex flex-col gap-5">
                    <h2 class="text-4xl font-medium">Votre place dans la file d'attente, directement dans votre poche.</h2>
                    <p class="">Trouvez vos établissements favoris, estimez votre temps d'attente grâce à notre algorithme en direct et payez vos services en un clic. L'application indispensable pour ne plus jamais perdre une minute dans un hall d'accueil.</p>
                    <div class="flex items-center justify-center gap-10">
                        <button class="btn-secondary"><a href="{{ route('information') }}">Apprendre à réserver</a></button>
                        <button class="btn-secondary"><a href="{{ route('ticket') }}">Voir mes tickets</a></button>
                    </div>
                </div>
                <div>
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
            <div>
                <form action=""  class="flex relative items-center justify-center">
                    <div class="flex absolute bg-(--white-color) py-1 px-2 rounded-tl-lg rounded-br-lg top-5 hover:bg-gray-100 shadow-lg">
                        <input class="outline-none placeholder-gray-400" type="text" name="" id="" placeholder="ex : carte biométrique">
                        <iconify-icon icon="boxicons:search" class="mt-1 text-gray-400 cursor-pointer"></iconify-icon>
                    </div>
                </form>
            </div>
        </section>

        
        <section class="flex flex-col text-(--primary-color) gap-6 p-10 mt-5 mb-10">
            <h2 class="text-4xl font-medium">Services</h2>
            <div class="flex items-center justify-between">
                <p class="text-xs">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint, voluptatem doloremque.</p>
                <div class="flex gap-3">
                    <span class="w-7 h-7 flex justify-center text-(--white-color) rounded-full bg-(--primary-color)">
                        <button id="buttonLeft">
                            <iconify-icon icon="solar:arrow-left-linear"></iconify-icon>
                        </button>
                    </span>
                    <span id="buttonRight" class="w-7 h-7 flex justify-center text-(--white-color) rounded-full bg-(--primary-color)">
                        <button>
                            <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
                        </button>
                    </span>                
                </div>
            </div>
            <div class="grid grid-flow-col gap-5 overflow-hidden" id="slidedContainer">
                @for ($i = 0; $i < 7; $i++)
                <div class="flex flex-col w-75 h-75 justify-between gap-2 p-5 bg-(--white-color) rounded-tl-lg rounded-br-lg shadow-lg slided-elt">
                    <div class="flex items-center gap-5">
                        <div class="w-20 h-20 flex items-center justify-center text-5xl">
                            <iconify-icon icon="mdi:car"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="font-medium uppercase">{{ $services[$i]->nom}}</h4>
                        </div>
                    </div>
                    <div class="h-30 overflow-hidden">
                        <p>{{ $services[$i]->description }}</p>
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
                                <a href="{{ route('service.show', $services[$i]->id) }}"        class="btn-secondary">Lire la suite</a>
                            </button>
                        </span>
                    </div>
                </div>
                @endfor
            </div>
        </section>

        <section class="grid grid-cols-4 text-(--primary-color) p-10 divide-x-1 divide-(--primary-color)">
            <span class="w-full flex flex-col items-center justify-center card">
                <h3 class="text-6xl">1284</h3>
                <p>tickets delivrées ce mois</p>
            </span>
            <span class="w-full flex flex-col items-center justify-center card">
                <h3 class="text-6xl">8min</h3>
                <p>attente moyenne</p>
            </span>
            <span class="w-full flex flex-col items-center justify-center card">
                <h3 class="text-6xl">14</h3>
                <p>services disponibles</p>
            </span>
            <span class="w-full flex flex-col items-center justify-center card">
                <h3 class="text-6xl">96%</h3>
                <p>clients reçus à l'heure</p>
            </span>
        </section>

        <section class="flex flex-col items-center justify-center text-(--primary-color) mb-10">
            <h3 class="text-4xl font-medium mb-5">Les services les plus réservés</h3>
            <div class="flex">
                <div class="flex flex-col items-center justify-center text-center card2">
                    <div class="w-30 h-30 flex items-center justify-center text-7xl bg-(--white-color) rounded-full">
                        <iconify-icon icon="mdi:car"></iconify-icon>
                    </div>
                    <h4 class="font-medium max-w-50">{{ $services[1]->nom}}</h4>
                </div>
                <div class="flex flex-col justify-center items-center bg-(--white-color) px-2 py-5 min-h-100 mb-5 shadow-lg rounded-tl-lg rounded-br-lg card2">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div class="w-30 h-30 flex items-center justify-center text-7xl bg-(--bg-color) rounded-full mb-5">
                            <iconify-icon icon="mdi:car"></iconify-icon>
                        </div>
                        <h4 class="font-medium max-w-50">{{ $services[2]->nom}}</h4>
                    </div>
                    <div class="grid grid-cols-3 text-(--primary-color) p-10 divide-x-1 divide-(--primary-color)">
                        <span class="w-full flex flex-col items-center justify-center p-1">
                            <p>86 %</p>
                            <p class="text-xs">de reservations</p>
                        </span>
                        <span class="w-full flex flex-col items-center justify-center p-1">
                            <p>99 %</p>
                            <p class="text-xs">de satisfaction</p>
                        </span>
                        <span class="w-full flex flex-col items-center justify-center p-1">
                            <p>0 fcfa</p>
                            <p class="text-xs">à dépenser</p>
                        </span>
                    </div>
                    <p class="text-xs">Durée moy. {{ $services[2]->duree}} min</p>
                </div>
                <div class="flex flex-col items-center justify-center text-center card2">
                    <div class="w-30 h-30 flex items-center justify-center text-7xl bg-(--white-color) rounded-full">
                        <iconify-icon icon="mdi:car"></iconify-icon>
                    </div>
                    <h4 class="font-medium max-w-50">{{ $services[3]->nom}}</h4>
                </div>
            </div>
            <div>
                <button class="btn-secondary"><a href="{{ route('tousServices') }}">Explorer les services</a></button>
            </div>
        </section>

        <section class="flex flex-col items-center justify-center text-(--primary-color) mb-10">
            <h3 class="text-4xl font-medium mb-5">Où nous retrouver ?</h3>
            <div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7930.283789706511!2d2.4132353999999996!3d6.3756767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102355a370a3da01%3A0x259bf9725256151!2sMairie%20de%20Cotonou!5e0!3m2!1sfr!2sbj!4v1784631435816!5m2!1sfr!2sbj" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </section>
    </main>
    <footer class="bg-linear-to-t from-(--primary-color) to-(--blue-gradient-color) rounded-t-[100px] text-(--white-color) px-10 py-20">
        <div class="flex items-start justify-evenly">
            <div>
                <img class="w-40" src="/assets/smart-queue-light.png" alt="smart queue logo">
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