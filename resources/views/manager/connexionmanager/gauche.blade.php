
<div class="md:w-[15%] bg-[#222D52] text-white flex flex-col">
    <p class="text-xs tracking-widest text-[#D2B589] px-9 pt-6 pb-4">
        GESTION
    </p>
 
    <nav class="flex flex-col">
        <a id="tableau" href="{{ route('manager.connexionmanager.droitetableau') }}" target="tableau"
           onclick="marquerBoutonActif('tableau')"
           class="px-6 py-3 text-sm text-white actif">
            Tableau De Bord
        </a>
 
        <a id="profil" href="{{ route('manager.connexionmanager.droiteprofil') }}" target="tableau"
           onclick="marquerBoutonActif('profil')"
           class="px-6 py-3 text-sm text-white">
            Profil De La Mairie
        </a>

        <a id="service" href="{{ route('manager.connexionmanager.droiteservice') }}" target="tableau"
           onclick="marquerBoutonActif('service')"
           class="px-6 py-3 text-sm text-white">
            Service
        </a>

        <a id="file" href="{{ route('manager.connexionmanager.droitefile') }}" target="tableau"
           onclick="marquerBoutonActif('file')"
           class="px-6 py-3 text-sm text-white">
            File D'attente
        </a>

        <a id="usager" href="{{ route('manager.connexionmanager.droiteusager') }}" target="tableau"
           onclick="marquerBoutonActif('usager')"
           class="px-6 py-3 text-sm text-white">
            Profil Usager
        </a>

        <a id="categorie" href="{{ route('manager.connexionmanager.droitecategorie') }}" target="tableau"
           onclick="marquerBoutonActif('categorie')"
           class="px-6 py-3 text-sm text-white">
            Catégorie
        </a>

        <a id="historique" href="{{ route('manager.connexionmanager.droitehistorique') }}" target="tableau"
           onclick="marquerBoutonActif('historique')"
           class="px-6 py-3 text-sm text-white">
            Historique
        </a>

        <a id="connexion" href="{{ route('manager.connexionmanager.droiteconnexion') }}" target="tableau"
           onclick="marquerBoutonActif('connexion')"
           class="px-6 py-3 text-sm text-white">
            Connexion
        </a>
 
    </nav>
</div>
 
<script>
    function marquerBoutonActif(idBouton) {
        document.getElementById("tableau").classList.remove("actif");
        document.getElementById("profil").classList.remove("actif");
        document.getElementById("service").classList.remove("actif");
        document.getElementById("file").classList.remove("actif");
        document.getElementById("usager").classList.remove("actif");
        document.getElementById("categorie").classList.remove("actif");
        document.getElementById("historique").classList.remove("actif");
        document.getElementById("connexion").classList.remove("actif");
        document.getElementById(idBouton).classList.add("actif");
    }
</script>