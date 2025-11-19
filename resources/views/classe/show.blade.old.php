<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visualisation de la classe') }}
        </h2>
    </x-slot>

    <div>
    <div class="max-w-10xl mx-auto">
    <div class="flex mb-4 text-sm font-bold">
        <p>
            <a href="{{route('classe.index')}}"  class="text-maquette">Accueil</a>
              <span class="mx-2 text-maquette">/</span>
        
        <p> <a href="{{route('classe.index')}}" >Classe  </a>
            
            <span class="mx-2 text-maquette">/</span>
        </p>

        <p class="text-first-orange">Détail de la Classe</p>
        </p>
      
    </div> 
    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="w-full mx-auto max-w-6xl">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">
                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange py-2">
                    Détail de la classe
                    <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 float-end"
                       href="{{ route('classe.edit', $classe->id) }}" >
                       Modifier
                   </a>
                </h3>
                <div class="border border-gray-200 p-4">
                    <div class="flex justify-between text-black items-center mt-3 text-sm">
                        <div>
                            <span>libelle de la classe : </span>
                            <span>
                                <b>{{ $classe->libelle ?? ' - ' }}</b>
                            </span>
                        </div>
                        <div>
                            <span>EFPT : </span>
                            <span>
                                <b>{{ $classe->etablissement->nom ?? ' -' }}</b>
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between text-black items-center mt-3 text-sm">
                        <div>
                            <span>Niveau Etude : </span>
                            <span>
                                <b>{{ $classe->niveau_etude->nom ?? ' - ' }}</b>
                            </span>
                        </div>
                        <div>
                            <span>Annee Academique : </span>
                            <span>
                                <b>{{ $classe->annee_academique->code }}</b>
                            </span>
                        </div>
                    </div>
                    <div>
                        <span>Metier : </span>
                        <span>
                            <b>{{ $classe->niveau_etude->metier->nom ?? '-' }}</b>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


</x-app-layout>
