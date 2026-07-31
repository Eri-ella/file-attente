<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['public/js/admin.js'])
</head>
<body>
    @include('admin.entete')

    <main class="flex w-full">
        <div class="flex flex-col items-start justify-center w-1/2 min-h-screen bg-(--primary-color) gap-5 px-10">
            <p class="text-(--highlight-color) text-xs tracking-widest mb-4">DERNIÈRE ÉTAPE</p>
            <h2 class="text-(--white-color) text-xl md:text-4xl">Choisissez un nouveau mot de passe.</h2>
        </div>
        <form class="flex flex-col items-start justify-center w-1/2 min-h-screen gap-2 text-(--primary-color) px-35" action="{{ route('admin.password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <p class="text-xs tracking-widest text-(--highlight-color) mb-5">ADMINISTRATION</p>
            <h3 class="text-2xl text-(--primary-color) font-medium mb-2">Nouveau mot de passe</h3>

            <div class="flex flex-col gap-3 w-full">
                <label class="text-[#222D52] font-medium">Adresse e-mail</label>
                <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color)" type="email" name="email" value="{{ old('email', $email) }}" required>

                <label class="text-[#222D52] font-medium">Nouveau mot de passe</label>
                <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color)" type="password" name="password" required>

                <label class="text-[#222D52] font-medium">Confirmer le mot de passe</label>
                <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color)" type="password" name="password_confirmation" required>
            </div>

            @if ($errors->any())
                <p class="text-xs text-red-600 mt-2">{{ $errors->first() }}</p>
            @endif

            <div class="flex flex-col w-full gap-5 mt-5 items-center justify-center">
                <input class="block mx-auto w-[280px] bg-[#222D52] hover:bg-[#18213f] text-white font-medium text-base py-3.5 mt-5 rounded-lg" type="submit" value="Réinitialiser">
            </div>
        </form>
    </main>
</body>
</html>