<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex justify-between items-center">
        <span class="text-first-orange font-bold text-sm">
                <a href="{{ route('region.index') }}">Liste des régions </a>
                    / <span class="text-orange-600"> region
                    {{ $region->nom }}</span></span>
        </div>
    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="w-full mx-auto max-w-6xl">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">

                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange py-2">
                                Détails de la région
                                <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1 float-end"
                        href="{{ route('region.edit', $region->id) }}">
                        Modifier
                    </a>
                </h3>
                <div class="border border-gray-200 p-4">
                    <div class="flex justify-between text-black items-center mt-3 text-sm">
                        <div>
                            <span>Code de la region : </span>
                            <span>
                                <b>{{ $region->code ?? ' - ' }}</b>
                            </span>
                        </div>
                        <div>
                            <span>Nom de la region : </span>
                            <span>
                                <b>{{ $region->libelle ?? ' -' }}</b>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
