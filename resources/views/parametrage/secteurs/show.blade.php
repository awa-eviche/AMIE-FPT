<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visualisation du secteur') }}
        </h2>
    </x-slot>
    

    <div>
    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route('secteur.index')}}"  class="text-maquette">Accueil</a>
              <span class="mx-2 text-maquette">/</span>
            <a href="{{route('secteur.index')}}"  class="text-maquette">Référentiel</a>
              <span class="mx-2 text-maquette">/</span>
        <p> <a href="{{route('secteur.index')}}" >Secteur  </a>
            
            <span class="mx-2 text-maquette">/</span>
        </p>

        <p class="text-first-orange">Détail du  Secteur</p>
        </p>
      
    </div>
    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="w-full mx-auto max-w-6xl">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">
           
                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange py-2">
                        Visualiser un secteur
                        <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1 float-end"
                        href="{{ route('secteur.edit', $secteur->id) }}">
                        Modifier
                    </a>
                </h3>
                <div class="border border-gray-200">

                    <div class="flex justify-between text-black items-center mt-3 text-sm">
                        <div>
                            <span>Code du Secteur : </span>
                            <span>
                                <b>{{ $secteur->code ?? ' - ' }}</b>
                            </span>
                        </div>
                        <div>
                            <span>Libellé du secteur : </span>
                            <span>
                                <b>{{ $secteur->libelle ?? ' -' }}</b>
                            </span>
                        </div>
                    </div>
                   <br>
                       <div>
                        <span>Description du secteur : </span>
                        <span>
                            <b>{{ $secteur->description ?? ' -' }}</b>
                        </span>
                    </div>
                </div>
       
                
            </div>
        </div>
    </div>

</div>


</x-app-layout>
