<section class="flex flex-col text-(--primary-color)">
    @foreach ($categories as $categorie)
        <h4 class="font-medium pb-5">{{ $categorie->nom }}</h4>
        <div class="flex flex-col pl-10 gap-5">
            @forelse ($categorie->services as $service)
                <p>{{ $service->nom }}</p>
            @empty
                <p class="text-gray-500 text-sm">Aucun service dans cette catégorie</p>
            @endforelse
        </div>
        <span class="flex w-[80%] h-px bg-(--primary-color) my-5"></span>
    @endforeach
</section>