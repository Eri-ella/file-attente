@extends('layouts.client')

@section('client-content')

    <main class="flex w-full">
        <div class="flex flex-col items-start justify-center w-1/2 min-h-screen bg-(--primary-color) gap-5 px-10">
            <p class="text-(--highlight-color)">BON RETOUR</p>
            <h2 class="text-(--white-color) text-4xl font-medium">Récupérez l'accès à votre compte en deux minutes.</h2>
        </div>
        <form class="flex flex-col items-start justify-center w-1/2 min-h-screen gap-2 px-10 text-(--primary-color)">
            <p class="text-(--highlight-color)">ESPACE CLIENT</p>
            <h3 class="text-4xl font-medium">Mot de passe oublié</h3>
            <p class="text-xs">Ça arrive à tout le monde.</p>
            <div class="flex flex-col gap-3 w-full"> 
                <label class="text-xl font-medium">Adresse e-mail</label>
                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="" id="" placeholder="jeandev@gmail.com">                
            </div>
            <p class="text-xs place-self-end">Un code de réinitialisation sera envoyé à cette adresse.</p>
            <div class="flex flex-col w-full gap-5 mt-5 items-center justify-center">
                <input class="btn-primary" type="submit" value="Créer mon compte">
                <a href="{{ route('connexion') }}">← Retour à la <b>connexion</b></a>
            </div>
        </form>
    </main>

@endsection