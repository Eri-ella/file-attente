@extends('layouts.client')

@section('client-content')

    <main class="flex flex-col items-center text-(--primary-color) min-h-screen">
        <div class="flex flex-col items-center justify-center w-full min-h-50 bg-(--primary-color) gap-5">
            <p class="text-(--highlight-color)">Votre tour approche</p> <!-- votre ticket est ne cours de traitement -->
            <p class="text-(--white-color) text-7xl font-medium">00:12:40</p> <!-- --:--:-- -->
            <p class="text-(--white-color)">Temps restant avant le passage</p>
        </div>
        <div class="flex w-full justify-center gap-10 mb-10">
            <table class="min-w-70">
                <tbody class="flex flex-col gap-5">
                    <tr class="flex justify-between">
                        <td>Service</td>
                        <td>Demande d'acte de mariage</td>
                    </tr>
                    <tr class="flex justify-between">
                        <td>Date</td>
                        <td>18 juillet 2026</td>
                    </tr>
                    <tr class="flex justify-between">
                        <td>Heure</td>
                        <td>14:20</td>
                    </tr>
                    <tr class="flex justify-between">
                        <td>Titulaire</td>
                        <td>dolo.chou@gmail.fr</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex flex-col justify-center items-center bg-[#d2b58975] border-l-3 border-(--primary-color) border-dashed min-w-30 gap-2 mb-10">
                <p class="text-4xl font-medium">B-042</p>
                <p class="text-xs">Votre ticket</p>
            </div>
        </div>
        <table class="w-70 border-1 border-(--primary-color) mb-10">
            <tbody>
                <tr>
                    <td class="font-light">04</td>
                    <td>Ticket B-039</td>
                    <td class="uppercase bg-[#d2b58975]">En cours</td>
                </tr>
            </tbody>
        </table>
        <div class="flex flex-col justify-center gap-5">
            <h3 class="text-xl font-medium">Mes tickets</h3>
            <table class="w-70 border-1 border-(--primary-color) p-5">
                <tbody>
                    <tr>
                        <td>Ticket B-039</td>
                        <td class="bg-[#222D5275]">non confirmé</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

@endsection