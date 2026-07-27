@extends('layouts.client')

@section('client-content')

    <main class="text-(--primary-color) px-5">
        <div>
            <ul class="grid grid-cols-3 divide-x-1 divide-(--primary-color) border-b-1 border-(--primary-color) w-full py-3 text-xl">
                <li id="service_thematique" class="w-full flex items-center justify-center cursor-pointer">Services par thématique</li>
                <li id="service_profil" class="w-full flex items-center justify-center cursor-pointer">Service par profil usager</li>
                <li id="service_critere" class="w-full flex items-center justify-center cursor-pointer">Service par critère technique/financier</li>
            </ul>
        </div>

        <div class="flex w-full gap-5 py-5" id="thematique">
            <div class="w-1/4">
                <div class="min-w-full min-h-screen h-auto">
                    @include('client.serviceThematiqueList')
                </div>
            </div>
            <div class="w-3/4">
                <div class="min-w-full min-h-screen h-auto">
                    @include('client.serviceThematiqueGrid')
                </div>
            </div>
        </div>

        <div class="hidden w-full gap-5 py-5" id="profil">
            <div class="w-1/4">
                <div class="min-w-full min-h-screen h-auto">
                    @include('client.serviceProfilList')
                </div>
            </div>
            <div class="w-3/4">
                <div class="min-w-full min-h-screen h-auto">
                    @include('client.serviceProfilGrid')
                </div>
            </div>
        </div>

        <div class="hidden w-full gap-5 py-5" id="critere">
            <div class="w-1/4">
                <div class="min-w-full min-h-screen h-auto">
                    @include('client.serviceCritereList')
                </div>
            </div>
            <div class="w-3/4">
                <div class="min-w-full min-h-screen h-auto">
                    @include('client.serviceCritereGrid')
                </div>
            </div>
        </div>
    </main>

@endsection