<main class="text-(--primary-color) px-5">
    <div>
        <ul class="grid grid-cols-3 divide-x-1 divide-(--primary-color) border-b-1 border-(--primary-color) w-full py-3 text-xl">
            <li id="service_thematique" class="w-full flex items-center justify-center cursor-pointer">Services par thématique</li>
            <li id="service_profil" class="w-full flex items-center justify-center cursor-pointer">Service par profil usager</li>
            <li id="service_critere" class="w-full flex items-center justify-center cursor-pointer">Service par critère technique/financier</li>
        </ul>
    </div>

    <div class="flex w-full gap-5 py-5">
        <div class="w-1/4 relative">
            <div class="flex min-w-full min-h-screen h-auto absolute" id="thematique">
                @include('client.serviceThematiqueList')
            </div>
            <div class="min-w-full min-h-screen h-auto hidden absolute" id="profil">
                @include('client.serviceProfilList')
            </div>
            <div class="min-w-full min-h-screen h-auto hidden absolute" id="critere">
                @include('client.serviceCritereList')
            </div>
        </div>

        <div class="w-3/4">
            <div class="min-w-full min-h-screen h-auto" id="services-content">
                @include($innerView, $innerData ?? [])
            </div>
        </div>
    </div>
</main>

@include('client.partials.service-ajax')