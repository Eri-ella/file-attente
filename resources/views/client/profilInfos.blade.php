@extends('layouts.client_service')

@section('service')
    <form action="{{ route('profil.update') }}" method="POST" class="min-h-screen flex flex-col justify-center items-center gap-5 text-(--primary-color)">
        @csrf
        @method('PUT')

        <h2 class="text-4xl font-medium">Mes informations</h2>
        <div class="flex flex-col gap-5">
            <div class="flex gap-10">
                <div class="flex flex-col gap-5">
                    <label class="text-xl font-medium">Nom</label>
                    <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="nom" value="{{ old('nom', auth()->guard('superclient')->user()->nom) }}" required>
                </div>
                <div class="flex flex-col gap-5">
                    <label class="text-xl font-medium">Prénom</label>
                    <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="prenom" value="{{ old('prenom', auth()->guard('superclient')->user()->prenom) }}" required>
                </div>
            </div>
            <div class="flex gap-10">
                <div class="flex flex-col gap-5">
                    <label class="text-xl font-medium">Email</label>
                    <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="email" name="email" value="{{ old('email', auth()->guard('superclient')->user()->email) }}" required>
                </div>
                <div class="flex flex-col gap-5">
                    <label class="text-xl font-medium">Téléphone</label>
                    <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="telephone" value="{{ old('telephone', auth()->guard('superclient')->user()->numero) }}" required>
                </div>
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
@endsection