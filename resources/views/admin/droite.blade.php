<div class="md:w-[50%] bg-[#F9F8F5] px-10 py-16 md:px-16 flex items-center justify-center border border-[#222D52]/50">
    <div class="w-full max-w-md">
        <p class="text-xs tracking-widest text-[#D2B589] mb-5">
            ADMINISTRATION
        </p>
<<<<<<< HEAD
        <h2 class="text-2xl text-[#222D52] font-medium mb-2">
            Connexion administrateur
        </h2>
        <p class="text-sm text-gray-600 mb-6">
            Identifiez-vous pour accéder à l'espace admin
        </p>

<<<<<<< HEAD
        <!-- AJOUT : autocomplete="off" pour empêcher le navigateur de tricher -->
        <form method="POST" action="{{ route('admin.login') }}" autocomplete="off">
            @csrf
            <label for="email" class="text-[#222D52] font-medium ">Identifiants</label>
            <!-- AJOUT : autocomplete="new-password" pour bloquer le re-remplissage automatique -->
            <input
                type="email"
                id="email"
                name="email"
                placeholder="admin@mairie-virtu3ll3"
                class="w-full border border-gray-300 bg-[#FDFFFF] px-3 py-2 mb-5 text-sm text-gray-800 mt-3"
                autocomplete="new-password"
                required
                value="{{ old('email') }}"
            >

            <label for="password" class="text-[#222D52] font-medium ">Mot de passe</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="••••••••"
<<<<<<< HEAD
                class="w-full border border-gray-300 px-3 py-2 mb-2 text-sm text-gray-800 mt-3" 
                autocomplete="new-password"
                required
            >

            <!-- AJOUT : La section du message d'erreur en rouge sous le mot de passe -->
            @error('login_error')
                <p class="text-xs text-red-600 font-medium mb-4">
                    {{ $message }}
                </p>
            @enderror

            <button type="submit" class="block mx-auto w-[280px] bg-[#222D52] hover:bg-[#18213f] text-white font-medium text-base py-3.5 mt-5"> Se connecter</button>
            
        </form>
    </div>
</div>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>
@vite(['public/js/admin.js'])

=======
                class="w-full  border border-gray-300 px-3 py-2 mb-5 text-sm text-gray-800 mt-3 rounded-lg" 
                required
            >
            <span class="password-icon absolute right-10 top-10">
                <i data-feather="eye" class="absolute"></i>
                <i data-feather="eye-off" class="absolute"></i>
            </span>
            </label>
            <script src="https://unpkg.com/feather-icons"></script>
            <script>
            feather.replace();
            </script>
            <p class="cursor-pointer place-self-end text-[#222D52]/50 hover:text-[#222D52]"><a href="{{ route('admin.motdepasse') }}"> Mot de passe oublié ?</a></p>
            <button type="submit" class="block mx-auto w-[280px] bg-[#222D52] hover:bg-[#18213f] text-white font-medium text-base py-3.5 mt-5 rounded-lg"> Se connecter</button>
        </form>
    </div>
</div>
@vite(['public/js/admin.js'])
>>>>>>> main
