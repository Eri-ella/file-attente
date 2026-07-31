<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil administrateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['public/js/admin.js'])
</head>
<body>
    @include('admin.entete')

    <main class="flex w-full">
        <div class="flex flex-col items-start justify-center w-1/2 min-h-screen bg-(--primary-color) gap-5 px-10">
            <p class="text-(--highlight-color) text-xs tracking-widest mb-4">MON COMPTE</p>
            <h2 class="text-(--white-color) text-xl md:text-4xl">Gérez vos informations personnelles.</h2>
        </div>
        <div class="flex flex-col items-start justify-center w-1/2 min-h-screen gap-2 text-(--primary-color) px-35">
            @php $admin = auth()->guard('admin')->user(); @endphp
            <form action="{{ route('admin.profil.update') }}" method="POST" class="w-full">
                @csrf
                @method('PUT')

                <h3 class="text-2xl text-(--primary-color) font-medium mb-4">Modifier mes informations</h3>

                <div class="flex flex-col gap-3 w-full">
                    <label class="text-[#222D52] font-medium">Nom</label>
                    <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color) w-full" type="text" name="nom" value="{{ old('nom', $admin->nom) }}" required>

                    <label class="text-[#222D52] font-medium">Prénom</label>
                    <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color) w-full" type="text" name="prenom" value="{{ old('prenom', $admin->prenom) }}" required>

                    <label class="text-[#222D52] font-medium">Email</label>
                    <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color) w-full" type="email" name="email" value="{{ old('email', $admin->email) }}" required>

                    <label class="text-[#222D52] font-medium">Téléphone</label>
                    <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color) w-full" type="text" name="numero" value="{{ old('numero', $admin->numero) }}" required>

                    <label class="text-[#222D52] font-medium">Nouveau mot de passe (facultatif)</label>
                    <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color) w-full" type="password" name="password">

                    <label class="text-[#222D52] font-medium">Confirmer le mot de passe</label>
                    <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color) w-full" type="password" name="password_confirmation">
                </div>

                @if ($errors->any())
                    <p class="text-xs text-red-600 mt-2">{{ $errors->first() }}</p>
                @endif
                @if (session('status'))
                    <p class="text-xs text-green-600 mt-2">{{ session('status') }}</p>
                @endif

                <div class="flex flex-col w-full gap-5 mt-5 items-center justify-center">
                    <input class="block mx-auto w-[280px] bg-[#222D52] hover:bg-[#18213f] text-white font-medium text-base py-3.5 mt-5 rounded-lg cursor-pointer" type="submit" value="Mettre à jour">
                </div>
            </form>

            <!-- Formulaire de suppression -->
            <form action="{{ route('admin.profil.delete') }}" method="POST" onsubmit="return confirm('Supprimer votre compte ? Cette action est définitive.');" class="mt-10">
                @csrf
                @method('DELETE')
                <label class="text-[#222D52] font-medium">Confirmez avec votre mot de passe actuel</label>
                <input class="border-1 border-(--primary-color) p-2 rounded-lg bg-(--white-color) w-full" type="password" name="password" required placeholder="••••••••">
                <button type="submit" class="mt-3 text-red-600 hover:text-red-800 font-medium">Supprimer mon compte</button>
            </form>
        </div>
    </main>
</body>
</html>