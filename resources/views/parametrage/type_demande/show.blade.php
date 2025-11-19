<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du Type de Demande') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route("type_demande.index")}}"  class="text-maquette">Liste des type de demandes</a>
        </p>
        <span class="mx-2 text-maquette">/</span>
        <p class="text-first-orange">Détail type de demande</p>
    </div>


    <div class="mt-5 pb-12 pt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 bg-white shadow-xl w-full rounded-sm">
        <div class="max-w-7xl sm:px-2 lg:px-2">
            <div class="bg-white shadow rounded-sm w-full p-4">
                <h2 class="font-bold text-maquette text-xl">
                    Détail de type de demande
                </h2>

                <div class="w-full max-w-md mx-auto shadow mt-2">
                    <div class="flex items-center justify-between bg-gray-200 p-1 mt-2">
                        <p class="font-bold text-first-orange">Détails</p>
                    </div>
                    <div class="p-2">
                        <div class="mt-4 mb-2 flex text-sm">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">libelle :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-gray-700">{{ $typeDemande->libelle }}</span>
                            </div>
                        </div>

                        <div class="mt-4 mb-2 flex text-sm">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">code :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-gray-700">{{ $typeDemande->code }}</span>
                            </div>
                        </div>

                        <div class="mt-4 mb-2 flex text-sm">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">Type demande parent :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-maquette-gris">{{ $typeDemande->typeDemandeParent->libelle ?? ' - ' }}</span>
                            </div>
                        </div>

                        <div class="mt-4 mb-2">
                            <strong class="text-black font-bold">
                                Description
                            </strong>
                            <p class="shadow border p-2 text-maquette rounded-sm mb-2">
                                {{ $typeDemande->description }}
                            </p>

                        </div>


                        <div class="flex justify-end mt-6">
                            <a href="{{ route('type_demande.edit', $typeDemande->id) }}" class="bg-first-orange hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded">
                                Modifier
                            </a>
                        </div>

                    </div>


                </div>
            </div>


        </div>

        <livewire:manage-type-demande-documents :entite="$typeDemande"/>

    </div>


</x-app-layout>
