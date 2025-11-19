<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faire une evaluation') }}
        </h2>
    </x-slot>

    <div class="bg-transparent shadow rounded-sm w-full p-4">

        <div class="mt-2 mb-2">
            <a href="{{ route('inscription.show',$inscription->id) }}" class="text-blue-500 hover:underline">&larr; Retour au détails de l'apprenant</a>
        </div>
        <div class="w-full mx-auto">
            <form class="bg-white pt-6 pb-8 mb-4" action="{{ route('evaluate.store',$inscription->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="md:container md:mx-auto">

                    <div class="w-full sm:px-2 lg:px-4 ">
                        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
                            <p>
                                <a href="{{ !(str_contains(auth()->user()->userable_type,'Entreprise')) ? '/dashboard' : 'javascript:void(0);' }}" class="text-maquette-gris">Accueil</a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p>
                                <a href="{{route('classes.index')}}">Classes  </a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p>
                                <a href="javascript:void(0);">Apprenants  </a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p>
                                <a href="javascript:void(0);">Visualiser  </a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p class="text-first-orange">Faire une évaluation</p>
                            <p></p>
                        </div>
                        <div class="border border-gray-200">
                            <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                Evaluation
                            </h3>

                            @livewire('apprenants.competence.evaluer',['inscription'=>$inscription,'competences'=>$competences,'message'=>isset($message) ? $message : ''])

                        </div>
                        <button type="submit" class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
