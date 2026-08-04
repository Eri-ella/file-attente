@extends('layouts.client')

@section('client-content')

<main class="flex flex-col items-center text-(--primary-color) min-h-screen justify-center">

    <div class="flex flex-col items-center justify-center w-full min-h-50 bg-(--primary-color) gap-5">
        <p class="text-(--highlight-color) text-sm tracking-widest">MES TICKETS</p>
        <h2 class="text-(--white-color) text-4xl font-medium">Retrouvez votre ticket</h2>
        <p class="text-(--white-color) opacity-80">Entrez l'email utilisé lors de la réservation</p>
    </div>

    <div class="flex flex-col items-center justify-center w-full max-w-md py-20 px-4">
        
        @if(session('erreur'))
            <div class="w-full mb-6 text-red-700 bg-red-100 px-4 py-3 rounded border border-red-300">
                {{ session('erreur') }}
            </div>
        @endif

        <form action="{{ route('ticket.rechercher') }}" method="POST" class="w-full space-y-5">
            @csrf
            
            <div>
                <label for="email" class="block text-sm text-gray-500 mb-1">Adresse email</label>
                <input type="email" id="email" name="email" required
                       placeholder="ex: jean.dupont@email.com"
                       class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
            </div>

            @error('email')
                <p class="text-xs text-red-600">{{ $message }}</p>
            @enderror

            <button type="submit" 
                    class="w-full bg-[#222D52] hover:bg-[#18213f] text-white font-medium py-3 rounded-lg transition-colors">
                Rechercher mon ticket
            </button>
        </form>

        <p class="mt-8 text-sm text-gray-500">
            Vous n'avez pas encore de ticket ? 
            <a href="{{ route('tousServices') }}" class="text-[#222D52] underline">Réserver un service</a>
        </p>
    </div>

</main>

@endsection