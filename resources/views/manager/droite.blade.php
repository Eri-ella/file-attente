<div class="md:w-[50%] bg-[#F9F8F5] px-10 py-16 md:px-16 flex items-center justify-center border border-[#222D52]/50">
    <div class="w-full max-w-md">
         @if(request()->query('deleted'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                Votre compte a bien été supprimé.
            </div>
            <script>
                alert('Votre compte a été supprimé avec succès.');
            </script>
        @endif
        <p class="text-xs tracking-widest text-[#D2B589] mb-5">
            GESTION
        </p>
        <h2 class="text-2xl text-[#222D52] font-medium mb-2">
            Connexion manager
        </h2>
        <p class="text-sm text-gray-600 mb-6">
            Identifiez-vous pour accéder à l'espace admin
        </p>

        <form method="POST" action="{{ route('manager.login') }}" autocomplete="off">
            @csrf
            <label for="email" class="text-[#222D52] font-medium">Identifiants</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="manager@mairie-virtu3ll3"

                class="w-full border border-gray-300 bg-[#FDFFFF] px-3 py-2 mb-5 text-sm text-gray-800 mt-3 rounded-lg" 
                autocomplete="new-password"

                class="w-full  border border-gray-300 bg-[#FDFFFF] px-3 py-2 mb-5 text-sm text-gray-800 mt-3 rounded-lg" 

                required
                value="{{ old('email') }}"
            >
            <!-- CORRECTION : Un conteneur parent 'relative' dédié uniquement au champ password et son icône -->
            <div class="relative w-full mb-2">
                <label for="password" class="text-[#222D52] font-medium block">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    class="w-full border border-gray-300 px-3 py-2 text-sm text-gray-800 mt-3 rounded-lg pr-10" 
                    autocomplete="new-password"
                    required
                >
                <!-- CORRECTION : Positionnement chirurgical de l'icône par rapport au champ de saisie -->
                <span class="password-icon absolute right-3 bottom-3 cursor-pointer text-gray-400">
                    <i data-feather="eye" class="w-5 h-5"></i>
                </span>
            </div>

            <!-- SECTION DU MESSAGE D'ERREUR PLACÉE IDÉALEMENT -->
            @error('login_error')
                <p class="text-xs text-red-600 font-medium mb-4 mt-1">
                    {{ $message }}
                </p>
            @enderror

            <p class="cursor-pointer text-right text-[#222D52]/50 hover:text-[#222D52] mb-4 text-sm mt-2">
                <a href="{{ route('manager.motdepasse') }}">Mot de passe oublié ?</a>
            </p>

            <button type="submit" class="w-full block mx-auto w-[280px] bg-[#222D52] hover:bg-[#18213f] text-white font-medium text-base py-3.5 mt-5 rounded-lg transition-colors">
                Se connecter
            </button>
        </form>

        </form>

    </div>
</div>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>
@vite(['public/js/manager.js'])


