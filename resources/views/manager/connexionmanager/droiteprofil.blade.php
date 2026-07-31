<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Profil Manager</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">
        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Mon Profil</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('manager.profil.update') }}" class="space-y-5 max-w-md">
                    @csrf
    
                <div>
                    <label for="prenom" class="block text-sm text-gray-500 mb-1">Prénom</label>
                    <input type="text" id="prenom" name="prenom"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                        value="{{ $manager->prenom }}" required>
                </div>

                <div>
                    <label for="nom" class="block text-sm text-gray-500 mb-1">Nom</label>
                    <input type="text" id="nom" name="nom"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                        value="{{ $manager->nom }}" required>
                </div>
    
                <div>
                    <label for="numero" class="block text-sm text-gray-500 mb-1">Téléphone</label>
                    <input type="text" id="numero" name="numero"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                        value="{{ $manager->numero }}" required>
                </div>
    
                <div>
                    <label for="email" class="block text-sm text-gray-500 mb-1">Adresse E-Mail</label>
                    <input type="email" id="email" name="email"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]"
                        value="{{ $manager->email }}" required>
                </div>
    
                <div class="text-center pt-2">
                    <button type="submit"
                            class="bg-[#222D52] hover:bg-[#18213f] text-white text-sm font-medium px-8 py-2.5 rounded">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-8 border-t border-[#222D52]/30">
                <form action="{{ route('manager.profil.delete') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-8 py-2.5 rounded">
                        Supprimer mon compte
                    </button>
                </form>
            </div>
           
        </main>
    </body>
</html>