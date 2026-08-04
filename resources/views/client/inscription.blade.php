@extends('layouts.connexion_layout')

@section('connexion-content')

    <main class="flex w-full">
        <div class="flex flex-col items-start justify-center w-1/2 min-h-screen bg-(--primary-color) gap-5 px-10">
            <p class="text-(--highlight-color)">NOUVEAU ICI ?</p>
            <h2 class="text-(--white-color) text-4xl font-medium">Créez un compte pour garder une trace de chaque démarche.</h2>
        </div>
        <form class="flex flex-col items-start justify-center w-1/2 min-h-screen gap-2 px-10 text-(--primary-color)" action="{{ route('inscription.store') }}" method="POST">
            @csrf
            <p class="text-(--highlight-color)">ESPACE CLIENT</p>
            <h3 class="text-4xl font-medium">Créer un compte</h3>
            <p class="text-xs">Quelques informations suffisent.</p>
            <div class="flex flex-col gap-3 w-full">
                <label class="text-xl font-medium">Nom</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="nom" id="" placeholder="Houessou" required value="{{ old('nom') }}"> 

                <label class="text-xl font-medium">Prenom</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="prenom" id="" placeholder="Jean" required value="{{ old('prenom') }}">
               
                <label class="text-xl font-medium">Adresse e-mail</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="email" id="" placeholder="jeandev@gmail.com" required value="{{ old('email') }}"> 
               
                <label class="text-xl font-medium">Téléphone</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="telephone" id="" placeholder="01 94 01 02 05 01" required value="{{ old('telephone') }}"> 
               
                <label class="text-xl font-medium relative">Mot de passe<br>
                <input class="border-1 border-w-full p-2 w-full rounded-tl-lg rounded-br-lg bg-(--white-color) password" type="password" name="pass" id="" required placeholder="••••••••">                 
                    <span class="password-icon absolute right-10 top-10">
                        <i data-feather="eye" class="absolute"></i>
                        <i data-feather="eye-off" class="absolute"></i>
                    </span>
                </label>
                <script src="https://unpkg.com/feather-icons"></script>
                <script>
                feather.replace();
                </script>              
            </div>
            @if ($errors->any())
                <div class="text-red-500 text-sm w-full">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="flex flex-col w-full gap-5 mt-5 items-center justify-center">
                <input class="btn-primary" type="submit" value="Créer mon compte">
                <p>Déjà un compte ? <a href="{{ route('connexion') }}" class="font-medium">Se connecter.</a></p>
            </div>
        </form>
    </main>

@endsection