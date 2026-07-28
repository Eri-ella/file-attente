<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Liste des profils usager</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">
        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Profil de la mairie</h1>

            
            <form method="POST" action="#" class="space-y-5 max-w-md">
                    @csrf
    
                <div>
                    <label for="nom_mairie" class="block text-sm text-gray-500 mb-1">Nom de la mairie</label>
                    <input type="text" id="nom_mairie" name="nom_mairie"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>
    
                <div>
                    <label for="adresse" class="block text-sm text-gray-500 mb-1">Adresse</label>
                    <input type="text" id="adresse" name="adresse"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>
    
                <div>
                    <label for="telephone" class="block text-sm text-gray-500 mb-1">Téléphone</label>
                    <input type="text" id="telephone" name="telephone"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>
    
                <div>
                    <label for="email" class="block text-sm text-gray-500 mb-1">Adresse E-Mail</label>
                    <input type="email" id="email" name="email"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>
    
                <div>
                    <p class="text-sm text-gray-500 mb-2">Horaires D'ouverture</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="horaire_matin" class="block text-sm text-gray-500 mb-1">Matin</label>
                            <input type="text" id="horaire_matin" name="horaire_matin" placeholder="08h00 - 12h00"
                                class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                        </div>
                        <div>
                            <label for="horaire_soir" class="block text-sm text-gray-500 mb-1">Soir</label>
                            <input type="text" id="horaire_soir" name="horaire_soir" placeholder="14h00 - 17h00"
                                class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                        </div>
                    </div>
                </div>
    
                <div class="text-center pt-2">
                    <button type="submit"
                            class="bg-[#222D52] hover:bg-[#18213f] text-white text-sm font-medium px-8 py-2.5 rounded">
                        Enregistrer
                    </button>
                </div>
    
            </form>
           
        </main>
    </body>
</html>