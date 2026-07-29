
    <section class="flex flex-col text-(--primary-color) bg-yellow-100">
        @foreach ($categories as $categorie)
        <h4 class="font-medium pb-5">{{ $categorie->nom }}</h4>
        <div class="flex flex-col pl-10 gap-5">
            @foreach ($services as $service)
            @if ($service->categorie == $categorie->nom )
                <p>{{ $service->nom }}</p>
            @endif
            @endforeach
        </div>
        <span class="flex w-[80%] h-px bg-(--primary-color) my-5"></span>
        @endforeach
    </section>
