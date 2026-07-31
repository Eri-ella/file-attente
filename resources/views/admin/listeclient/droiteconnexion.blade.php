<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Mon profil – Administrateur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex flex-col">
    <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
        <h1 class="text-2xl font-medium text-[#222D52] mb-8">Mon compte</h1>

        @php $admin = auth()->guard('admin')->user(); @endphp

        <form method="POST" action="{{ route('admin.profil.update') }}" class="space-y-5 max-w-md">
            @csrf
            @method('PUT')

            <div>
                <label for="email" class="block text-sm text-gray-500 mb-1">Identifiant (email)</label>
                <input type="email" id="email" name="email"
                    class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                    value="{{ old('email', $admin->email) }}" required>
            </div>

            <div>
                <label for="nom" class="block text-sm text-gray-500 mb-1">Nom</label>
                <input type="text" id="nom" name="nom"
                    class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                    value="{{ old('nom', $admin->nom) }}" required>
            </div>

            <div>
                <label for="prenom" class="block text-sm text-gray-500 mb-1">Prénom</label>
                <input type="text" id="prenom" name="prenom"
                    class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                    value="{{ old('prenom', $admin->prenom) }}" required>
            </div>

            <div>
                <label for="numero" class="block text-sm text-gray-500 mb-1">Téléphone</label>
                <input type="text" id="numero" name="numero"
                    class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                    value="{{ old('numero', $admin->numero) }}" required>
            </div>

            <div>
                <label for="password" class="block text-sm text-gray-500 mb-1">Nouveau mot de passe (facultatif)</label>
                <input type="password" id="password" name="password"
                    class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm text-gray-500 mb-1">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
            </div>

            @if ($errors->any())
                <div class="text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if (session('status'))
                <p class="text-green-600 text-sm">{{ session('status') }}</p>
            @endif

            <div class="flex gap-4">
                <button type="submit"
                    class="bg-[#222D52] hover:bg-[#18213f] text-white text-sm font-medium px-6 py-2.5 rounded">
                    Enregistrer les modifications
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('admin.profil.delete') }}" class="mt-8 max-w-md" onsubmit="return confirm('Supprimer votre compte ? Cette action est définitive.')">
            @csrf
            @method('DELETE')

            <div>
                <label for="delete_password" class="block text-sm text-gray-500 mb-1">Confirmez avec votre mot de passe actuel</label>
                <input type="password" id="delete_password" name="password"
                    class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]" required>
            </div>
            <div class="mt-4">
                <button type="submit"
                    class="bg-red-500 hover:bg-red-700 text-white text-sm font-medium px-6 py-2.5 rounded">
                    Supprimer mon compte
                </button>
            </div>
        </form>

        <div class="mt-8">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="bg-red-500 hover:bg-red-800 text-white text-sm font-medium px-8 py-2.5 rounded">
                Se déconnecter
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </main>
</body>
</html>