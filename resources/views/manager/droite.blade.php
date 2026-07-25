<div class="md:w-[50%] bg-[#F9F8F5] px-10 py-16 md:px-16 flex items-center justify-center border border-[#222D52]/50">
    <div class="w-full max-w-md">
        <p class="text-xs tracking-widest text-[#D2B589] mb-5">
            GESTION
        </p>
         <h2 class="text-2xl  text-[#222D52] font-medium mb-2">
            Connexion manager
        </h2>
         <p class="text-sm text-gray-600 mb-6">
            Identifiez-vous pour accéder à l'espace admin
        </p>

        <form method="POST" action="">
            @csrf
            <label for="email" class="text-[#222D52] font-medium ">Identifiants</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="manager@mairie-virtu3ll3"
                class="w-full  border border-gray-300 bg-[#FDFFFF] px-3 py-2 mb-5 text-sm text-gray-800 mt-3" 
                required
            >

            <label for="password" class="text-[#222D52] font-medium ">Mot de passe</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
                class="w-full  border border-gray-300 px-3 py-2 mb-5 text-sm text-gray-800 mt-3" 
                required
            >

            <button type="submit" class="block mx-auto w-[280px] bg-[#222D52] hover:bg-[#18213f] text-white font-medium text-base py-3.5 mt-5"> Se connecter</button>
            
        </form>
    </div>
</div>