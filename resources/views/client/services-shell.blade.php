<main class="text-(--primary-color) px-3 md:px-5">

    {{-- ✅ ONGLETS : select sur mobile, onglets horizontaux sur PC --}}
    <div class="py-3">
        {{-- Version PC : onglets horizontaux (caché sur mobile) --}}
        <ul class="hidden md:grid grid-cols-3 divide-x-1 divide-(--primary-color) border-b-1 border-(--primary-color) w-full text-xl">
            <li id="service_thematique" class="w-full flex items-center justify-center cursor-pointer py-3">Services par thématique</li>
            <li id="service_profil" class="w-full flex items-center justify-center cursor-pointer py-3">Service par profil usager</li>
            <li id="service_critere" class="w-full flex items-center justify-center cursor-pointer py-3">Service par critère technique/financier</li>
        </ul>

        {{-- Version Mobile : select déroulant (caché sur PC) --}}
        <div class="md:hidden">
            <label for="mobile-tabs" class="block text-sm font-medium mb-2">Filtrer les services par :</label>
            <select 
                id="mobile-tabs" 
                class="w-full border border-(--primary-color) rounded-lg px-4 py-3 bg-(--white-color) text-(--primary-color) focus:outline-none focus:ring-2 focus:ring-(--primary-color)/50"
            >
                <option value="thematique">Services par thématique</option>
                <option value="profil">Service par profil usager</option>
                <option value="critere">Service par critère technique/financier</option>
            </select>
        </div>
    </div>

    {{-- ✅ LAYOUT : empilé sur mobile, menu latéral + contenu sur PC --}}
    <div class="flex flex-col md:flex-row w-full gap-5 py-5">

        {{-- ✅ MENU LATÉRAL --}}
        <div class="w-full md:w-1/4">
            {{-- Accordéon mobile (bouton pour ouvrir/fermer) --}}
            <button 
                id="mobile-filter-toggle"
                class="md:hidden w-full flex items-center justify-between bg-(--primary-color) text-(--white-color) px-4 py-3 rounded-t-lg font-medium"
            >
                <span><iconify-icon icon="mdi:filter-variant" class="mr-2"></iconify-icon>Filtres</span>
                <iconify-icon icon="mdi:chevron-down" id="filter-chevron"></iconify-icon>
            </button>

            {{-- Conteneur des 3 listes (pliable sur mobile, fixe sur PC) --}}
            <div id="mobile-filter-content" class="md:block relative md:min-h-screen">
                <div class="md:absolute md:inset-0 bg-(--white-color) md:bg-transparent p-4 md:p-0 border border-(--primary-color)/20 md:border-0 rounded-b-lg md:rounded-none" id="thematique">
                    @include('client.serviceThematiqueList')
                </div>
                <div class="hidden md:absolute md:inset-0 bg-(--white-color) md:bg-transparent p-4 md:p-0 border border-(--primary-color)/20 md:border-0 rounded-b-lg md:rounded-none" id="profil">
                    @include('client.serviceProfilList')
                </div>
                <div class="hidden md:absolute md:inset-0 bg-(--white-color) md:bg-transparent p-4 md:p-0 border border-(--primary-color)/20 md:border-0 rounded-b-lg md:rounded-none" id="critere">
                    @include('client.serviceCritereList')
                </div>
            </div>
        </div>

        {{-- ✅ CONTENU DES CARTES --}}
        <div class="w-full md:w-3/4">
            <div class="min-w-full min-h-screen h-auto" id="services-content">
                @include($innerView, $innerData ?? [])
            </div>
        </div>
    </div>
</main>

@include('client.partials.service-ajax')

{{-- ✅ SCRIPT RESPONSIVE : liaison select mobile + accordéon filtres --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === 1. Liaison select mobile <-> onglets PC ===
        const mobileTabs = document.getElementById('mobile-tabs');
        const pcOnglets = {
            thematique: document.getElementById('service_thematique'),
            profil: document.getElementById('service_profil'),
            critique: document.getElementById('service_critere'),
        };

        if (mobileTabs) {
            mobileTabs.addEventListener('change', function() {
                // Simule un clic sur l'onglet PC correspondant
                const target = document.getElementById('service_' + this.value);
                if (target) target.click();
            });
        }

        // Mettre à jour le select mobile quand on clique sur un onglet PC
        Object.entries(pcOnglets).forEach(([key, el]) => {
            if (el) {
                el.addEventListener('click', function() {
                    if (mobileTabs) mobileTabs.value = key;
                });
            }
        });

        // === 2. Accordéon pour les filtres sur mobile ===
        const filterToggle = document.getElementById('mobile-filter-toggle');
        const filterContent = document.getElementById('mobile-filter-content');
        const filterChevron = document.getElementById('filter-chevron');

        if (filterToggle && filterContent) {
            // Sur mobile, le contenu est caché par défaut
            if (window.innerWidth < 768) {
                filterContent.classList.add('hidden');
            }

            filterToggle.addEventListener('click', function() {
                filterContent.classList.toggle('hidden');
                if (filterChevron) {
                    filterChevron.setAttribute('icon', 
                        filterContent.classList.contains('hidden') ? 'mdi:chevron-down' : 'mdi:chevron-up'
                    );
                }
            });

            // Au redimensionnement : réajuster
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    filterContent.classList.remove('hidden');
                }
            });
        }
    });
</script>