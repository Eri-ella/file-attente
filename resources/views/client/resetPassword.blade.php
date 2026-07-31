@extends('layouts.client')

@section('client-content')
<main class="flex w-full">
    <div class="flex flex-col items-start justify-center w-1/2 min-h-screen bg-(--primary-color) gap-5 px-10">
        <p class="text-(--highlight-color)">DERNIÈRE ÉTAPE</p>
        <h2 class="text-(--white-color) text-4xl font-medium">Choisissez un nouveau mot de passe.</h2>
    </div>
    <form action="{{ route('password.update') }}" method="POST" class="flex flex-col items-start justify-center w-1/2 min-h-screen gap-2 px-10 text-(--primary-color)">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <p class="text-(--highlight-color)">ESPACE CLIENT</p>
        <h3 class="text-4xl font-medium">Nouveau mot de passe</h3>

        <div class="flex flex-col gap-3 w-full">
            <label class="text-xl font-medium">Adresse e-mail</label>
            <input class="border-1 p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="email" name="email" value="{{ old('email', $email) }}" required>

            <label class="text-xl font-medium">Nouveau mot de passe</label>
            <input class="border-1 p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="password" name="password" required>

            <label class="text-xl font-medium">Confirmer le mot de passe</label>
            <input class="border-1 p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="password" name="password_confirmation" required>
        </div>

        @if ($errors->any())
            <p class="text-red-500 text-sm">{{ $errors->first() }}</p>
        @endif

        <div class="flex flex-col w-full gap-5 mt-5 items-center justify-center">
            <input class="btn-primary" type="submit" value="Réinitialiser">
        </div>
    </form>
</main>
@endsection