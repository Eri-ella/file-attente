
    <section>
        <div class="grid grid-cols-[repeat(auto-fit,minmax(250px,1fr))] gap-7 p-7 overflow-hidden text-(--primary-color)">
            @foreach ($services as $service)
                <div class="flex flex-col w-75 h-75 justify-between gap-2 p-5 bg-(--white-color) rounded-tl-lg rounded-br-lg shadow-lg slided-elt">
                    <div class="flex items-center gap-5">
                        <div class="w-20 h-20 flex items-center justify-center text-5xl">
                            <iconify-icon icon="mdi:car"></iconify-icon>
                        </div>
                        <div>
                            <h4 class="font-medium uppercase">{{ $service->nom}}</h4>
                        </div>
                    </div>
                    <div class="h-30 overflow-hidden">
                        <p>{{ $service->description }}</p>
                    </div>
                    <span>. . .</span>
                    <div>
                        <span></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>
                            <p class="text-xs">Durée moy. {{ \Carbon\Carbon::parse($service->duree)->format('H') * 60 + \Carbon\Carbon::parse($service->duree)->format('i') }} min</p>
                        </span>
                        <span class="btn-secondary">
                            <button>
                                <a href="{{ route('service.show', $service->id) }}"     class="btn-secondary">Lire la suite</a>
                            </button>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    