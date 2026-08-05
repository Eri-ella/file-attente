<section>
    {{-- ✅ GRILLE : 1 colonne mobile / 2 tablette / 3 PC --}}
    <div id="services-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 p-5 text-(--primary-color)">
        @forelse ($services as $service)
            <div 
                class="service-card flex flex-col w-full h-75 justify-between gap-2 p-5 bg-(--white-color) rounded-tl-lg rounded-br-lg shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer"
                data-nom="{{ strtolower($service->nom) }}"
                data-description="{{ strtolower($service->description) }}"
                data-categorie="{{ strtolower($service->categorie->nom ?? '') }}"
                data-profil="{{ strtolower($service->profil_usager->nom ?? '') }}"
            >
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 flex items-center justify-center text-5xl">
                        <iconify-icon icon="mdi:car"></iconify-icon>
                    </div>
                    <div>
                        <h4 class="font-medium uppercase">{{ $service->nom }}</h4>
                    </div>
                </div>
                <div class="h-30 overflow-hidden">
                    <p>{{ $service->description }}</p>
                </div>
                <span>. . .</span>
                <div>
                    <span></span>
                </div>
                <div class="flex items-center justify-between">
                    <span>
                        <p class="text-xs">Durée moy. {{ \Carbon\Carbon::parse($service->duree)->format('H') * 60 + \Carbon\Carbon::parse($service->duree)->format('i') }} min</p>
                    </span>
                    <span class="btn-secondary">
                        <button>
                            <a href="{{ route('service.show', $service->id) }}" class="btn-secondary">Lire la suite</a>
                        </button>
                    </span>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center py-10 text-gray-500">Aucun service disponible pour le moment.</p>
        @endforelse
    </div>

    {{-- Message quand la recherche ne donne rien --}}
    <div id="no-results" class="hidden text-center py-10 text-(--primary-color)">
        <p class="text-lg">Aucun service ne correspond à votre recherche.</p>
    </div>
</section>

<script>
    // Filtrage des services en temps réel (toutes les barres de recherche)
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

    document.addEventListener('DOMContentLoaded', function() {
        const params = new URLSearchParams(window.location.search);
        const recherche = params.get('recherche');

        // Brancher le filtrage sur TOUTES les barres (PC, mobile, sticky)
        document.querySelectorAll('input[id^="recherche-services"]').forEach(input => {
            if (recherche) {
                input.value = recherche;
            }

            input.addEventListener('input', function() {
                filtrerServices(input);
            });

            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    filtrerServices(input);
                }
            });
        });

        // Filtrer automatiquement si on arrive avec ?recherche=...
        if (recherche) {
            const mainInput = document.getElementById('recherche-services');
            if (mainInput) filtrerServices(mainInput);
        }
    });
</script>