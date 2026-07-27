@extends('layouts.client')

@section('client-content')

    <main class="flex w-full">
        <div class="flex flex-col items-start justify-center w-1/2 min-h-screen bg-(--primary-color) gap-5 px-10">
            <p class="text-(--highlight-color)">NOUVEAU ICI ?</p>
            <h2 class="text-(--white-color) text-4xl font-medium">Créez un compte pour garder une trace de chaque démarche.</h2>
        </div>
        <form class="flex flex-col items-start justify-center w-1/2 min-h-screen gap-2 px-10 text-(--primary-color)">
            <p class="text-(--highlight-color)">ESPACE CLIENT</p>
            <h3 class="text-4xl font-medium">Créer un compte</h3>
            <p class="text-xs">Quelques informations suffisent.</p>
            <div class="flex flex-col gap-3 w-full">
                <label class="text-xl font-medium">Nom complet</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="" id="" placeholder="Jean Houessou"> 
                <label class="text-xl font-medium">Adresse e-mail</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="" id="" placeholder="jeandev@gmail.com"> 
                <label class="text-xl font-medium">Téléphone</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="" id="" placeholder="01 94 01 02 05 01"> 
                <label class="text-xl font-medium">Mot de passe</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="password" name="" id="">                 
            </div>
            <div class="flex flex-col w-full gap-5 mt-5 items-center justify-center">
                <input class="btn-primary" type="submit" value="Créer mon compte">
                <p>Déjà un compte ? <a href="{{ route('connexion') }}" class="font-medium">Se connecter.</a></p>
            </div>
        </form>
    </main>

@endsection