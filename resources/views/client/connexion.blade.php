@extends('layouts.connexion_layout')

@section('connexion-content')

    <main class="flex w-full">
        <div class="flex flex-col items-start justify-center w-1/2 min-h-screen bg-(--primary-color) gap-5 px-10">
            <p class="text-(--highlight-color)">BON RETOUR</p>
            <h2 class="text-(--white-color) text-4xl font-medium">Retrouvez vos tickets et votre historique en un instant.</h2>
        </div>
        <form class="flex flex-col items-start justify-center w-1/2 min-h-screen gap-2 px-10 text-(--primary-color)" action="{{ route('connexion.store') }}" method="POST">
            @csrf
            <p class="text-(--highlight-color)">ESPACE CLIENT</p>
            <h3 class="text-4xl font-medium">Se connecter</h3>
            <p class="text-xs">Accédez à vos tickets et à votre historique.</p>
            <div class="flex flex-col gap-3 w-full">
                <label class="text-xl font-medium">Adresse e-mail</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="email" id="" placeholder="jeandev@gmail.com" required value="{{ old('email') }}"> 
                <label class="text-xl font-medium block">Mot de passe</label>
                <div class="relative w-full">
                    <input class="border-1 border-w-full p-2 w-full rounded-tl-lg rounded-br-lg bg-(--white-color) password pr-10" 
                        type="password" name="pass" required placeholder="••••••••">                 
                    <span class="password-icon absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-gray-400">
                        <i data-feather="eye" class="eye-open w-5 h-5"></i>
                        <i data-feather="eye-off" class="eye-closed w-5 h-5 hidden"></i>
                    </span>
                </div>
                <script src="https://unpkg.com/feather-icons"></script>
                <script>feather.replace();</script>
            </div>
            <p class="cursor-pointer place-self-end hover:text-(--blue-gradient-color)"><a href="{{ route('passe') }}"> Mot de passe oublié ?</a></p>
            <div class="flex flex-col w-full gap-5 mt-5 items-center justify-center">
                <input class="btn-primary" type="submit" value="Se connecter">
                <p>Pas encore de compte ? <a href="{{ route('inscription') }}" class="font-medium">Créer un compte.</a></p>
            </div>
        </form>
    </main>

@endsection