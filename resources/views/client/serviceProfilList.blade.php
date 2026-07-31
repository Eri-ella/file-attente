<section class="flex flex-col text-(--primary-color)">
    @foreach ($profils as $profil)
        <h4 class="font-medium pb-5">{{ $profil->nom }}</h4>
        <div class="flex flex-col pl-10 gap-5">
            @forelse ($profil->services as $service)
                <p>{{ $service->nom }}</p>
            @empty
                <p class="text-gray-500 text-sm">Aucun service correspondant à ce profil</p>
            @endforelse
        </div>
        <span class="flex w-[80%] h-px bg-(--primary-color) my-5"></span>
    @endforeach
</section>