@php 
    $apprenant=$inscription->apprenant; 
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Gestion des apprenants") }}
        </h2>
    </x-slot>

    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-gris text-xl py-4">
                {{ $currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée' }}
            </h2>
        </div>
        <div class="flex-1">
            <select wire:model="classe" wire:change="$refresh" class="border bg-white3 font-bold text-md border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-md">
                <option value="{{$inscription->classe->id}}">{{$inscription->classe->libelle}}</option>
            </select>
        </div>
    </div>

    @if($currentClasse)
            <div class="py-2 px-4 m-2 shadow bg-vert2 rounded shadow border border-black">
                <div class="grid grid-cols-3 gap-2 py-2 text-md">
                    <div class="flex items-center">
                        <span class="text-gray-800">Année Scolaire :</span>
                        <span class="font-bold">{{ $inscription->anneeAcademique->code ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-800">Filiere :</span>
                        <span class="font-bold">{{$currentClasse->niveau_etude->metier->filiere->nom}}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-800">Métier :</span>
                        <span class="font-bold">{{$currentClasse->niveau_etude->metier->nom}}</span>
                        &nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;   &nbsp;&nbsp;&nbsp;
                        <span class="text-gray-800">Modalite :</span>
                        <span class="font-bold">{{$currentClasse->modalite}}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-800">Niveau d'études :</span>
                        <span class="font-bold">{{$currentClasse->niveau_etude->nom}}</span>
                    </div>

                    <div class="flex items-center">
                        <span class="text-gray-800">Etat classe :</span>
                        <span class="font-bold">{{ strval( $currentClasse->statut)=="" ?'Non Validé' : (!($currentClasse->etat_classe) ? 'Validé' : 'Lancé')}}</span>
                    </div>

                    <div class="flex items-center">
                        <span class="text-gray-800">Nombre apprenants :</span>
                        <span class="font-bold">{{ count($apprenants) }}</span>
                    </div>
                    
                </div>
            </div> 
@endif

<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex flex-col lg:flex-row">
            <!-- Première colonne -->
            <div class="lg:w-full flex items-center px-4 py-2">
                <div>
                    <div class="col text-gray-700 font-bold text-lg font-medium">
                    <a href="{{ route('classe.show', $currentClasse->id) }}">
    <span><i class="fa fa-angle-left"></i></span> 
    <span class="text-gray-600 text-md pl-2">
        Retour à la liste des apprenants
    </span>
</a>

                    </div>

                                      
                </div>
            </div>
        </div>
        <div class="mx-4" align="right">
        @can('edit_evaluation')
                        
              {{--          <a href="{{route('evaluation.create')}}" class="px-3 rounded-md py-2 text-white text-sm font-bold text-center bg-orange-400 text-end mx-2">
                            <i class="fa fa-check"></i> <span class="mx-2">Gestion des Evaluation </span>

                        </a>
                        <a href="" class="px-3 rounded-md py-2 text-white text-sm font-bold text-center bg-orange-400 text-end">
                            <i class="fa fa-check"></i> <span class="mx-2">Gestion des absences </span>

                        </a> --}}
                    @endcan()  

        </div>
    </div>

    <div class="flex md:flex-wrap justify-between  m-4">
        <div class="flex md:w-full">
            <div class="rounded-lg border bg-gray shadow px-8 py-2 mr-2 bg-white sm:w-2/3 ">
            <div class="flex justify-between text-black items-center">
    <span class="text-first-orange font-bold text-xl">
        Fiche détaillée de l'apprenant {{ $apprenant->nom }} {{ $apprenant->prenom }}
    </span>
    
    <div class="flex items-center justify-end space-x-2 mt-2">
    @if($inscription->statut === 'actif')
        {{-- Bouton Suspendre --}}
        <form action="{{ route('inscription.suspendre', $inscription->id) }}"
              method="POST"
              onsubmit="return confirm('Voulez-vous vraiment suspendre cet apprenant de cette classe ?');"
              class="inline">
            @csrf
            <button type="submit"
                    class="px-4 py-1 text-sm text-orange-700 bg-orange-100 hover:bg-orange-200 rounded-md shadow">
                Suspendre
            </button>
        </form>

        {{-- Bouton Modifier --}}
        <a href="{{ route('apprenant.edit', $apprenant->id) }}"
           class="px-4 py-1 text-sm text-orange-700 bg-orange-100 hover:bg-orange-200 rounded-md shadow">
            Modifier
        </a>

        {{-- Bouton Supprimer --}}
        <form action="{{ route('apprenant.destroy', $apprenant->id) }}"
              method="POST"
              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet apprenant ?');"
              class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-4 py-1 text-sm text-orange-700 bg-orange-100 hover:bg-orange-200 rounded-md shadow">
                Supprimer
            </button>
        </form>
    @else
        {{-- Si l’apprenant est suspendu, ne rien afficher --}}
        <span class="italic text-sm text-gray-500">Cet apprenant est suspendu.</span>
    @endif
</div>
</div>


                <div class="flex justify-between text-black items-center text-md">
                <div class="w-full sm:w-1/2 px-2">
                            <div class="my-2">
                                    <span>Nom : </span>
                                    <span>
                                        <b>{{ $apprenant->nom ?? '-' }}</b>
                                    </span>
                            </div>
                            <div class="my-2">
                                    <span>Prenom : </span>
                                    <span>
                                        <b>{{ $apprenant->prenom ?? 'Non renseigné' }}</b>
                                    </span>
                            </div>

                            <div class="my-2">
                                     <span>Date de naissance : </span>
                                <span>
                                    <b>{{ date('d-m-Y',strtotime($apprenant->date_naissance) ?? " ") }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Lieu de naissance : </span>
                                <span>
                                    <b>{{ $apprenant->lieu_naissance ?? ' <span class="text-sm font-normal">Non renseigné</span> ' }}</b>
                                </span>
                            </div>
                            <div class="my-2">
                                <span>Matricule: </span>
                                <span>
                                    <b>{{ $apprenant->matricule ?? '-' }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Adresse: </span>
                                <span>
                                    <b>{{ $apprenant->adresse ?? '-' }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Commune: </span>
                                <span>
                                    <b>{{ $apprenant->commune->libelle ?? '-' }}</b>
                                </span>
                            </div>
                            <div class="my-2">
                                <span>Nationalité: </span>
                                <span>
                                    <b>{{ $apprenant->nationalite ?? '-' }}</b>
                                </span>
                            </div>
                            <div class="my-2">
                                <span>Nom du tuteur : </span>
                                <span>
                                    <b>{{ $apprenant->nomTuteur ?? "-" }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Prenom du tuteur : </span>
                                <span>
                                    <b>{{ $apprenant->prenomTuteur ?? '-' }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Numero Tel Tuteur : </span>
                                <span>
                                    <b>{{ $apprenant->numTelTuteur ?? '-' }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Situation Matrimoniale : </span>
                                <span>
                                    <b>{{ $apprenant->situationMatrimoniale ?? '-' }}</b>
                                </span>
                            </div>


                        </div>

                            <div class="w-full sm:w-1/2 px-2 pb-5">
                            <div class="my-2">
                                <span>Prenom Pere: </span>
                                <span>
                                    <b>{{ $apprenant->prenomPere ?? '-' }}</b>
                                </span>
                            </div>
                            <div class="my-2">
                                <span>Prenom Mere: </span>
                                <span>
                                    <b>{{ $apprenant->prenomMere ?? '-' }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>nom Mere: </span>
                                <span>
                                    <b>{{ $apprenant->nomMere ?? '-' }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Email: </span>
                                <span>
                                    <b>{{ $apprenant->email ?? '-' }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Telephone: </span>
                                <span>
                                    <b>{{ $apprenant->telephone ?? '-' }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                                <span>Date d'insertion: </span>
                                <span>
                                    <b>{{ $apprenant->dateInsertion ?? '-' }}</b>
                                </span>
                            </div>

                            <div class="my-2">
                            AutoEmploi
                                <span>Auto Emploi: </span>
                                <b>{{ $apprenant->autoEmploi == 1 ? "OUI" : "NON" }}</b>
                            </div>

                            <div class="my-2">
                                <span>Emploi Salarie: </span>
                                <b>{{ $apprenant->emploiSalarie == 1 ? "OUI" : "NON" }}</b>
                                
                            </div>

                        </div>
                            
                            

                </div>

            </div>
            <div class="rounded-lg border shadow-sm px-8 py-2 sm:w-1/3 ">
                <h3 class="text-first-orange font-bold text-xl mb-4">Compétences à acquérir</h3>
                 @if($currentClasse && $currentClasse->modalite === 'PPO')
    @foreach($matieres as $matiere)
        <div class="flex items-center my-2">
            <i class="fa fa-star text-gray text-xs me-2"></i> 
            <span class="font-normal">
                <span class="font-bold">{{ $matiere->code }}</span>: {{ $matiere->nom }}
            </span>
        </div>
    @endforeach
@elseif($currentClasse && $currentClasse->modalite === 'APC')
    @foreach($competences as $competence)
        <div class="flex items-center my-2">
            <i class="fa fa-check text-green-500 text-xs me-2"></i> 
            <span class="font-normal">
                <span class="font-bold">{{ $competence->code }}</span>: {{ $competence->nom }}
            </span>
        </div>
    @endforeach
@endif

            </div>
        </div>
    </div>

</div>
</x-app-layout>
