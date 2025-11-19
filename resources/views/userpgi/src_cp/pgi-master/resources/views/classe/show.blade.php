<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Informations détaillée de la classe') }}
        </h2>
    </x-slot>
    <div class="bg-transparent shadow rounded-sm w-full p-4">
        <div class="bg-white pb-4 w-full mx-auto">
            <div class="md:container md:mx-auto">

                <h2 class="font-bold  text-xl sm:px-2 lg:px-4 py-4">
                    {{$classe->libelle}}
                </h2>
                <div class="w-full sm:px-2 lg:px-4">
                    <div class="flex justify-between ">
                        <div class="mt-2 mb-2">
                            <a href="{{ route('classe.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                                classes</a>
                        </div>
                      <div class="flex p-2">
                         <div onclick="window.location='{{ route('classe.edit', $classe->id) }}'" style="background-color:#6d6b00; cursor: pointer;" class="text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ">
                                Modifier
                        </div>
                        <div style="background-color:#006D3A; cursor: pointer;" class="text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 bg-first-orange ">
                            <form class="text-center"
                                 action="{{ route('classe.destroy', $classe->id) }}" method="POST">
                                 @csrf
                                 @method('DELETE')
                                <button title="Supprimer" type="submit" class="focus:outline-none">
                                Supprimer
                                </button>
                            </form>
                        </div>
                        </div>

                    </div>

                    <div class="border border-gray-200">
                        <h3 class="bg-gray-100 p-2 text-md font-bold text-first-orange">
                            Détails de la classe {{$classe->libelle}}
                        </h3>
                        <div class="flex  p-2">
                            <div class="w-2/5 mr-4 border shadow p-2 rounded bg-gray">
                                <h2 class="font-bold text-xl mb-4">Informations générales</h2>
                                <hr class="w-50">
                                <div class="grid grid-cols-2 gap-2 py-2 text-md">
                                    <div class="flex items-center">
                                        <span class="text-gray-800">Année Scolaire :</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-bold">{{$classe->annee_academique->code}}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-800">Etablissement :</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-bold">{{$classe->etablissement->nom}}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-800">Filiere :</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-bold">{{$classe->niveau_etude->metier->filiere->nom}}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-800">Métier :</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-bold">{{$classe->niveau_etude->metier->nom}}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-gray-800">Niveau d'études :</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-bold">{{$classe->niveau_etude->nom}}</span>
                                    </div>



                                    <div class="flex items-center">
                                        <span class="text-gray-800">Modalité :</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="font-bold">{{$classe->modalite}}</span>
                                    </div>


                                    <div class="flex items-center">
                                        <span class="text-gray-800">Etat classe :</span>
                                    </div>
                                    <div class="flex items-center ">
                                        <span class="font-bold">{{ strval( $classe->statut)=="" ?'Non Validé' : (!($classe->statut) ? 'Validé' : 'Lancé')}}</span>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <h2 class="font-bold text-xl mb-2">Compétences au programme</h2>
                                <hr class="w-50">
                                <div class=" gap-2 py-2 text-sm ms-4">
                                    @foreach($matieres as $matiere)
                                    <div class="flex items-center my-2">
                                        <i class="fa fa-star text-gray text-xs me-2"></i> 
                                        <span class="font-normal"><span class="font-bold">{{$matiere->code}}</span>: {{$matiere->nom}}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="w-3/5 mr-4 border bg-gray-100 border-1 shadow p-2 rounded bg-light">
                            <div class="title-container" style="display: flex; justify-content: space-between; align-items: center;">

    <h2 class="font-bold text-xl mb-4" style="margin-right: auto;">Liste des apprenants</h2>

    <!--a href="#" class="mx-2 px-5 rounded-md py-0 flex text-orange-600 text-xxxs font-bold text-center shadow-md items-center" style="border: none; padding: 0;">
    <span><i class="fa fa-download" style="color: green;"></i></span>
</a-->
    <div class="button-container" style="margin-left: 10px;">
        <div onclick="window.location='{{ route('apprenant.create', $classe->id) }}'"
             style="background-color:#6d6b00; cursor: pointer;"
             class="button-style text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700  focus:outline-none dark:focus:ring-blue-800">
            Ajouter un apprenant 
        </div>
    </div>
</div>


                         
                                <hr class="w-50">
                                <div class="p-2">
                                    <table class="w-full mb-3">
                                        <thead>
                                            <tr
                                                class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b">
                                                {{-- <th class="px-4 py-3">N° </th> --}}
                                                <th class="px-1 text-gray-800">Identifiant</th>
                                                <th class="px-1 text-gray-800">Nom et Prénoms</th>
                                                <th class="px-1 text-gray-800">Date naissance</th>
                                                <th class="px-1 text-gray-800"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y ">
                                                <tr class="text-gray-700 ">
                                                    @forelse ($usersWithEnterprises as $usersWithEnterprise)
                                                    <td class="p-2 border-b text-gray-500 ">
                                                        {{ $usersWithEnterprise['user']->apprenant->matricule ?? ' - ' }}
                                                    </td>
                                                    <td class="p-2 border-b text-gray-500 ">
                                                        {{ $usersWithEnterprise['user']->apprenant->nom ?? ' - ' }} {{ $usersWithEnterprise['user']->apprenant->prenom?? ' - ' }}
                                                    </td>
                                                    <td class="p-2 border-b text-gray-500 ">
                                                        {{ \Carbon\Carbon::parse($usersWithEnterprise['user']->apprenant->date_naissance)->format('d-m-Y')?? ' - ' }}
                                                    </td>
                                                    <td class="p-2 border-b text-gray-500 text-center">
                                                        <a href="{{route('inscription.show',$usersWithEnterprise['user']->id)}}" class="text-greeen-600"><i class="fa fa-eye"></i></a>
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr><td colspan="6" class="px-2 py-2 font-bold text-xs text-center">Aucun apprenant n'est enregistré pour cette classe.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                </div>
            </div>
    </div>
</x-app-layout>
