@extends('layouts.client')

@section('client-content')
<main class="flex w-full items-center justify-center min-h-screen">
    <form action="{{ route('password.update') }}" method="POST" class="flex flex-col gap-3 w-full max-w-md text-(--primary-color)">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <h3 class="text-2xl font-medium">Nouveau mot de passe</h3>

        <label>Adresse e-mail</label>
        <input type="email" name="email" value="{{ old('email', $email) }}" class="border p-2 bg-(--white-color)" required>

        <label>Nouveau mot de passe</label>
        <input type="password" name="password" class="border p-2 bg-(--white-color)" required>

        <label>Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" class="border p-2 bg-(--white-color)" required>

        @if ($errors->any())
            <p class="text-red-500 text-sm">{{ $errors->first() }}</p>
        @endif

        <button type="submit" class="btn-primary mt-3">Réinitialiser</button>
    </form>
</main>
@endsection