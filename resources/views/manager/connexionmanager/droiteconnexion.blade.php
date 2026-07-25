<!DOCTYPE html>
<html lang="fr" class="h-full">
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="h-full flex flex-col">
        <main class="flex-1 bg-[#F9F8F5] p-10 overflow-auto border border-[#222D52]/50"> 
            <h1 class="text-2xl font-medium text-[#222D52] mb-8">Connexion</h1>

            
            <form method="POST" action="#" class="space-y-5 max-w-md">
                    @csrf
    
                <div>
                    <label for="nom_mairie" class="block text-sm text-gray-500 mb-1">Identifiant</label>
                    <input type="text" id="identifiant" name="identifiant"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52]">
                </div>
    
                <div class="pb-[4rem]">
                    <label for="adresse" class="block text-sm text-gray-500 mb-1">Mot de passe</label>
                    <input type="text" id="mot" name="mot"
                        class="w-full border border-[#222D52]/30 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#222D52] ">
                </div>
    
                <div>
                    <a  href="{{route('pageManager')}}" target="_top"
                            class="bg-red-500 hover:bg-red-800 text-white text-sm font-medium px-8 py-2.5 rounded">
                            Se deconnecter
                    </a>
                </div>

            </form>
           
        </main>
    </body>
</html>