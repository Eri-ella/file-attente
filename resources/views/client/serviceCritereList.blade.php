<section class="flex flex-col text-(--primary-color) bg-red-100 p-4">
    {{-- Services gratuits --}}
    @php
        $gratuits = $services->where('cout', 0)->sortBy('nom');
    @endphp
    @if ($gratuits->isNotEmpty())
        <div>
            <h3 class="font-medium pb-5">🆓 Services gratuits</h3>
            <div class="flex flex-col gap-2 pl-4">
                @foreach ($gratuits as $service)
                    <p>{{ $service->nom }}</p>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-500">Aucun service gratuit disponible.</p>
    @endif

    {{-- Séparateur --}}
    <hr class="my-6 border-gray-300">

    {{-- Services payants --}}
    @php
        $payants = $services->where('cout', '>', 0)->sortBy('cout');
    @endphp
    @if ($payants->isNotEmpty())
        <div>
            <h3 class="font-medium pb-5">💰 Services payants</h3>
            <div class="flex flex-col gap-2 pl-4">
                @foreach ($payants as $service)
                    <p>{{ $service->nom }} – {{ number_format($service->cout, 0, ',', ' ') }} FCFA</p>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-500">Aucun service payant disponible.</p>
    @endif
</section>