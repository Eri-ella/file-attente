
<div class="md:w-full bg-[#222D52] text-white flex flex-col">
    <p class="text-xs tracking-widest text-[#D2B589] px-9 pt-6 pb-4">
        ADMINISTRATION
    </p>

    <nav class="flex flex-col">
        <a id="clients" href="{{ route('admin.listeclient.droitecli') }}" target="tableau"
        onclick="marquerBoutonActif('clients')"
        class="px-6 py-3 text-sm text-white actif">
            Clients
        </a>

        <a id="managers" href="{{ route('admin.listeclient.droitema') }}" target="tableau"
        onclick="marquerBoutonActif('managers')"
        class="px-6 py-3 text-sm text-white">
            Manager
        </a>

        <a id="profils" href="{{ route('admin.listeclient.droitepro') }}" target="tableau"
        onclick="marquerBoutonActif('profils')"
        class="px-6 py-3 text-sm text-white">
            Profil
        </a>

        <a href="{{route('connexionAdmin')}}" class="px-6 py-3 text-sm text-red-400 hover:bg-red-500/10">
            Déconnexion
        </a>
    </nav>
</div>

<script>
    function marquerBoutonActif(idBouton) {
        document.getElementById("clients").classList.remove("actif");
        document.getElementById("managers").classList.remove("actif");
        document.getElementById("profils").classList.remove("actif");
        document.getElementById(idBouton).classList.add("actif");
    }
</script>