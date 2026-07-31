@extends('layouts.client')

@section('client-content')
    @php $user = auth()->guard('superclient')->user(); @endphp
    <main class="flex text-(--primary-color) w-full min-h-screen">
        <div class="w-1/5 flex flex-col justify-center">
            <div class="flex flex-col items-center mb-5">
                <span class="text-(--highlight-color) bg-(--primary-color) size-20 rounded-full flex items-center justify-center text-3xl">{{ strtoupper(substr($superclient->prenom, 0, 1)) }}{{ strtoupper(substr($superclient->nom, 0, 1)) }}</span>
                <p class="text-xl font-medium">{{ $superclient->prenom }} {{ $superclient->nom }}</p>
                <p class="text-xs">{{ $superclient->email }}</p>
            </div>
            <div class="grid grid-rows-3 divide-y-1 divide-(--primary-color) gap-5 px-5">
                <p id="info_click" class="cursor-pointer">Mes informations</p>
                <p id="histo_click" class="cursor-pointer">Historique</p>
            </div>
        </div>
        <div class="w-4/5 min-h-screen flex flex-col" id="profil_infos">
            <div class="size-full">
                @include('client.profilInfos')
            </div>
        </div>
        <div class="w-4/5 min-h-screen hidden flex-col" id="profil_historique">
            <div class="size-full">
                @include('client.historique')
            </div>
        </div>
    </main>
@endsection