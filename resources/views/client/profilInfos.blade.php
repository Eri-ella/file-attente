@extends('layouts.client_service')

@section('service')
    <form action="" class="min-h-screen flex flex-col justify-center items-center gap-5 text-(--primary-color)">
            <h2 class="text-4xl font-medium">Mes informations</h2>
            <div class="flex flex-col gap-5">
                <div class="flex gap-10">
                    <div class="flex flex-col gap-5">
                        <label class="text-xl font-medium">Nom complet</label>
                        <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="nom_complet" id="" value="{{ $superclient->prenom }} {{ $superclient->nom }}" >
                    </div>
                    <div class="flex flex-col gap-5">
                        <label class="text-xl font-medium">Téléphone</label>
                        <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="telephone" id="" value="{{ $superclient->numero }}">
                    </div>
                </div>
                <div class="flex flex-col gap-5">
                    <label class="text-xl font-medium">Adresse e-mail</label>
                    <input class="border-1 border-w-full p-2 rounded-tl-lg rounded-br-lg bg-(--white-color)" type="text" name="email" id="" value="{{ $superclient->email }}">
                </div>   
            </div>
            <div>
                <input class="btn-primary" type="submit" value="Enregistrer les mofications">
            </div>
    </form>
@endsection