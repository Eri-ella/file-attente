<div class="md:w-[50%] bg-[#F9F8F5] px-10 py-16 md:px-16 flex items-center justify-center border border-[#222D52]/50">
    <div class="w-full max-w-md">
        <p class="text-xs tracking-widest text-[#D2B589] mb-5">
            ADMINISTRATION
        </p>
        <h2 class="text-2xl text-[#222D52] font-medium mb-2">
            Connexion administrateur
        </h2>
        <p class="text-sm text-gray-600 mb-6">
            Identifiez-vous pour accéder à l'espace admin
        </p>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <label for="email" class="text-[#222D52] font-medium">Identifiants</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="admin@mairie-virtu3ll3"
                class="w-full border border-gray-300 bg-[#FDFFFF] px-3 py-2 mb-5 text-sm text-gray-800 mt-3 rounded-lg" 
                required
                value="{{ old('email') }}"
            >

            <label for="password" class="text-[#222D52] font-medium block">Mot de passe</label>
            <div class="relative w-full mb-2">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    class="w-full border border-gray-300 px-3 py-2 text-sm text-gray-800 mt-3 rounded-lg pr-10" 
                    autocomplete="new-password"
                    required
                >
                <span class="password-icon absolute right-3 bottom-3 cursor-pointer text-gray-400">
                    <i data-feather="eye" class="eye-open w-5 h-5"></i>
                    <i data-feather="eye-off" class="eye-closed w-5 h-5 hidden"></i>
                </span>
            </div>

            @error('login_error')
                <p class="text-xs text-red-600 font-medium mb-4">
                    {{ $message }}
                </p>
            @enderror

            <button type="submit" class="w-full block mx-auto w-[280px] bg-[#222D52] hover:bg-[#18213f] text-white font-medium text-base py-3.5 mt-5 rounded-lg">
                Se connecter
            </button>
        </form>
    </div>
</div>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace();
</script>
@vite(['public/js/admin.js'])