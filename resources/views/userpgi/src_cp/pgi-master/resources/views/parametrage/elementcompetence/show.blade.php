<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Visualisation de l'element de competence") }}
        </h2>
    </x-slot>

    <div>
    <div class="max-w-10xl mx-auto">
    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route('elementcompetence.index')}}"  class="text-maquette">Accueil</a>
              <span class="mx-2 text-maquette">/</span>
            <a href="{{route('elementcompetence.index')}}"  class="text-maquette">Référentiel</a>
              <span class="mx-2 text-maquette">/</span>
        <p> <a href="{{route('elementcompetence.index')}}" >Element de Competence  </a>
            
            <span class="mx-2 text-maquette">/</span>
        </p>

        <p class="text-first-orange">Détail de l'element de competence</p>
        </p>
      
    </div> 
    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="w-full mx-auto max-w-6xl">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">
                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange py-2">
                                   Détail de l'element de competence
                                   <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1"
                           href="{{ route('elementcompetence.edit', $elementcompetence->id)  }}" style='position:relative;left: 68%;'>
                           Modifier
                       </a>
                               </h3>
                <div class="border border-gray-200 p-4">
                    <div class="flex justify-between text-black items-center mt-3 text-sm">
                        <div>
                            <span>Code de l'element de competence  : </span>
                            <span>
                                <b>{{ $elementcompetence->code ?? ' - ' }}</b>
                            </span>
                        </div>
                        
                        <div>
                            <span>Libellé de l'element de competence : </span>
                            <span>
                                <b>{{ $elementcompetence->nom ?? ' -' }}</b>
                            </span>
                        </div>
                        
                    </div>
                   <br>
                   <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                            <span>Metier l'element de competence  : </span>
                            <span>
                                <b>{{ $elementcompetence->metier->nom ?? ' - ' }}</b>
                            </span>
                        </div>
                        <div>
                            <span>Matiere de l'element de competence  : </span>
                            <span>
                                <b>{{ $elementcompetence->matiere->nom ?? ' - ' }}</b>
                            </span>
                        </div>
                        
                        </div>
                </div>
                
            </div>
        </div>
    </div>

</div>


</x-app-layout>
