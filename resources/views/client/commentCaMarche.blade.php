@extends('layouts.client')

@section('client-content')

    <main class="text-(--primary-color) p-10">
        <section>
            <h3 class="text-4xl font-medium my-5">Comment ça marche ?</h3>
            <ol class="flex flex-col list-decimal gap-5 ml-5">
                <li class="text-2xl">Rendez-vous dans la partie service</li>
                <p>Grâce à la bar de navigation, rendez vous dans la partie service, recherchez puis choisissez un service selon les critères de votre choix.</p>
                <li class="text-2xl">Choisissez votre service</li>
                <p>Sélectionnez la tâche exacte que vous souhaitez effectuer (ex: Renouvellement de CNI, retrait de passeport, légalisation de documents). L'application vous affiche automatiquement le tarif du service ainsi que la liste des pièces justificatives à apporter pour éviter les aller-retours inutiles.</p>
                <li class="text-2xl">Validez à la volée (Sans inscription !)</li>
                <p>Pas besoin de perdre du temps à créer un compte ou à retenir un mot de passe. Cliquez sur « Prendre un ticket », renseignez simplement votre adresse e-mail, puis laissez-vous guider.</p>
                <li class="text-2xl">Suivez votre rang et présentez-vous sans stress</li>
                <p>Votre ticket est généré ! Vous pouvez fermer l'application : votre position dans la file est enregistrée. Vous recevrez des alertes SMS en temps réel à l'approche de votre tour.Un imprévu ? Vous pouvez annuler en un clic.</p>
            </ol>
        </section>
        <section>
            <h3 class="text-4xl font-medium my-5">Contacts</h3>
            <p class="flex flex-col gap-1">Pour toute information supplementaires contacter nous via les num2ros: <br>
                <b>+229 0000000000 ( Appel ) <br>
                +229 0000000000 ( Appel/Whatsapp ) </b><br>
                ou via nos differents réseaux:
                <div class="flex gap-5 text-4xl mt-5">
                    <iconify-icon icon="ion:logo-facebook"></iconify-icon>
                    <iconify-icon icon="ion:social-github"></iconify-icon>
                    <iconify-icon icon="ion:social-whatsapp"></iconify-icon>
                    <iconify-icon icon="ion:mail-sharp"></iconify-icon>
                </div>
            </p>
        </section>
    </main>

@endsection