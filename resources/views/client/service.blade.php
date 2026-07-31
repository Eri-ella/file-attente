@extends('layouts.client_service')

@section('service')
    <section class="text-(--primary-color) p-5">
        <div>
            <button class="btn-secondary mb-10" onclick="history.back()">Retour</button>
        </div>
        <div class="flex flex-col w-full gap-5">
            <div class="flex w-full">
                <div class="flex flex-col gap-5 w-2/3">
                    <!-- CORRECTION : Titre dynamique -->
                    <h2 class="text-4xl font-medium">{{ $service->nom }}</h2>
                    
                    <!-- CORRECTION : Durée et coût dynamiques (adaptez les noms si vos colonnes s'appellent autrement) -->
                    <p>Durée moy. {{ $service->duree ?? '40min' }}</p>
                    <p>Coût. {{ $service->cout ?? '2000fcfa' }}</p>
                    
                    <!-- CORRECTION : Description dynamique -->
                    <p>{{ $service->description }}</p>
                </div>
                <div class="flex flex-col w-1/3">
                    <p class="mb-5 text-(--white-color) bg-(--primary-color) w-fit px-10 py-1 rounded-tl-lg rounded-br-lg">Documents à fournir</p>
                    <ul class="flex flex-col gap-5 pl-5 list-disc">
                        <!-- Note : Si vous gérez les documents en base de données plus tard, on pourra faire une boucle ici -->
                        <li>Le formulaire de demande</li>
                        <li>Les actes de naissance</li>
                        <li>Les pièces d'identité</li>
                    </ul>
                </div>
            </div>
            <div>
                <!-- CORRECTION : Un seul lien propre avec le style du bouton principal -->
                <a href="{{ route('reservation.create', $service->id) }}" class="btn-primary mt-5 inline-block text-center">
                    Réserver un ticket
                </a>
            </div>
        </div>
    </section>
@endsection
