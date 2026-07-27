@extends('layouts.client_service')

@section('service')
    <section class="text-(--primary-color) p-5">
        <div>
            <button class="btn-secondary mb-10" onclick="history.back()">Retour</button>
        </div>
        <form action="">
            <div class="flex w-full gap-10">
                <div class="flex flex-col gap-5 w-2/3">
                    <h2 class="text-4xl font-medium">Demande d'acte de mariage</h2>
                    <p class="text-xs bg-[#d2b58975] p-2 border-l-3 border-(--primary-color)">Vous n'avez pas besoin de compte pour réserver. Un e-mail suffit pour recevoir votre ticket et ses notifications.</p>
                    <div class="flex flex-col">
                        <div class="flex flex-col gap-5 mb-5">
                            <label class="text-xl font-medium">Adresse e-mail</label>
                            <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="" id="" placeholder="jeandev@gmail.com">
                        </div>
                        <div class="flex justify-between">
                            <div class="flex flex-col gap-5">
                               <label class="text-xl font-medium">Date souhaitée (optionnel)</label>
                                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="date" name="" id="">
                            </div>
                            <div class="flex flex-col gap-5">
                                <label class="text-xl font-medium">Heure souhaitée (optionnel)</label>
                                <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="time" name="" id="">
                            </div>
                        </div>
                        <p class="text-xs mb-5">Laissez l'heure vide pour obtenir le prochain créneau disponible calculé automatiquement.</p>
                        <div class="flex flex-col gap-5">
                            <label class="text-xl font-medium">Nombre de ticket(s)</label>
                            <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="number" name="" id="">
                        </div>
                        <p class="text-xs mb-5">Un ticket par personne à traiter au guichet.</p>
                    </div>
                </div>
                <div>
                    <h4 class="text-2xl font-medium mb-5">Récapitulatif</h4>
                    <table class="flex flex-col gap-5"> 
                        <tr class="flex justify-between border-b-1 border-(--primary-color) gap-5">
                            <td>Service</td>
                            <td>Demand d'acte de mariage</td>
                        </tr>
                        <tr class="flex justify-between border-b-1 border-(--primary-color) gap-5">
                            <td>Date</td>
                            <td>--</td>
                        </tr>
                        <tr class="flex justify-between gap-5">
                            <td>Ticket(s)</td>
                            <td>1</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div>
                <input class="btn-primary" type="submit" value="Confirmer la réservation">
            </div>
        </form>
    </section>
@endsection