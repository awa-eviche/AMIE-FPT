
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Visualisation de l'inscription") }}
        </h2>
    </x-slot>

<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex flex-col lg:flex-row">
            <!-- Première colonne -->
            <div class="lg:w-full flex justify-between items-center px-4 py-2">
                <div>
                    <span class="text-gray-700 font-bold text-lg font-medium">
                        <a href="{{ route('inscription.index') }}">
                            <span><i class="fa fa-angle-left"></i></span> 
                            <span class="text-gray-700 text-xl font-bold pl-2">
                                {{ $inscription->classe->libelle }}</span>
                        </a>
                    </span>
                </div>
                <div>

                </div>
            </div>
        </div>

    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="flex md:w-full  flex-col">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">
                <div class="flex justify-between text-black items-center">
                    <span class="text-first-orange font-bold text-md">Informations générales</span>
                    <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1" href="{{ route('apprenant.edit', $inscription->apprenant->id) }}">
                        Modifier
                    </a>
                </div>
                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>Nom Apprenant : </span>
                        <span>
                            <b>{{ $inscription->apprenant->nom ?? ' - ' }}</b>
                        </span>
                    </div>
                    <div>
                        <span>Prenom Apprenant: </span>
                        <span>
                            <b> {{ $inscription->apprenant->prenom ?? ' - ' }}</b>
                        </span>
                    </div>
                </div>

                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>Classe : </span>
                        <span>
                            <b>{{ $inscription->classe->libelle ?? '-' }}</b>
                        </span>
                    </div>
                    <div>
                        <span>Metier : </span>
                        <span>
                            <b>{{ $inscription->classe->niveau_etude->metier->nom ?? '-' }}</b>
                        </span>
                    </div>
                </div>

                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>EFPT: </span>
                        <span>
                            <b>{{ $inscription->classe->etablissement->nom ?? ' - ' }}</b>
                        </span>
                    </div>
                  
                </div>
              

                <div class="flex justify-between text-black items-center pt-5">
                    <span class="text-first-orange font-bold text-md">Contacts</span>
                </div>

                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <div>
                        <span>Téléphone Apprenant : </span>
                        <span>
                            <b>{{ $inscription->apprenant->telephone ?? ' - ' }}</b>
                        </span>
                    </div>
                    <div>
                        <span>Email Apprenant: </span>
                        <span>
                            <b>{{ $inscription->apprenant->email ?? ' - ' }}</b>
                        </span>
                    </div>
                </div>

             
               
              

               
    


            </div>
        </div>
    </div>

</div>
</x-app-layout>