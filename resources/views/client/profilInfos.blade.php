@extends('layouts.client_service')

@section('service')
    <form action="{{ route('profil.update') }}" method="POST" class="min-h-screen flex flex-col justify-center items-center gap-5 text-(--primary-color)">
            @csrf
            <h2 class="text-4xl font-medium">Mes informations</h2>
            <div class="flex flex-col gap-5">
                <div class="flex gap-10">
                    <div class="flex flex-col gap-5">
                        <label class="text-xl font-medium">Nom complet</label>
                        <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="nom_complet" id="" value="{{ $superclient->prenom }} {{ $superclient->nom }}" required>
                    </div>
                    <div class="flex flex-col gap-5">
                        <label class="text-xl font-medium">Téléphone</label>
                        <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="telephone" id="" value="{{ $superclient->numero }}" required>
                    </div>
                </div>
                <div class="flex flex-col gap-5">
                    <label class="text-xl font-medium">Adresse e-mail</label>
                    <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="email" id="" value="{{ $superclient->email }}" required>
                </div>   
            </div>
            <div>
                <input class="btn-primary" type="submit" value="Enregistrer les modifications">
            </div>
            <div class="flex gap-10">
                <div class="flex flex-col gap-5">
                    <label class="text-xl font-medium">Nouveau mot de passe (facultatif)</label>
                    <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="password" name="pass">
                </div>
                <div class="flex flex-col gap-5">
                    <label class="text-xl font-medium">Confirmer le mot de passe</label>
                    <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="password" name="pass_confirmation">
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="text-red-500 text-sm w-full text-center">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        @if (session('status'))
            <p class="text-green-600 text-sm">{{ session('status') }}</p>
        @endif

        <div>
            <input class="btn-primary" type="submit" value="Enregistrer les modifications">
        </div>
    </form>

    <div class="flex justify-center mt-5">
        <form action="{{ route('profil.delete') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
            @csrf
            <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                Supprimer mon compte
            </button>
        </form>
    </div>
@endsection