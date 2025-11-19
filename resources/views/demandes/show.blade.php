<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de la Demande') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold px-4">
        <p>
            <a href="{{route("demande.index")}}" class="text-black">Liste des demandes</a>
        </p>
        <span class="mx-2 text-black">/</span>

        <p class="text-first-orange">Détail demande</p>
    </div>


    

    <div x-data="{step : 1}" class="bg-transparent px-4">
        {{-- stepper --}}
        <div class="mt-3 bg-white py-1">
            <!-- component -->
            <div class="grid grid-flow-col justify-stretch text-base text-gray-600">
                {{-- 1 --}}
                <div @click="step=1" class="cursor-pointer text-center border-b-2 " x-bind:class="{'border-b-first-orange':step == 1, 'border-b-gray-200' : step !=1}">
                    <p class="px-3 font-black w-full " x-bind:class="{'text-first-orange border-first-orange': step == 1 }">Général</p>
                </div>

                {{-- 2 --}}

                <div @click="step=2" class="cursor-pointer text-center border-b-2 " x-bind:class="{'border-b-first-orange':step == 2, 'border-b-gray-200' : step !=2}">
                    <p class="px-3 font-black w-full " x-bind:class="{'text-first-orange border-first-orange': step == 2 }">Documents</p>
                </div>

                {{-- 3 --}}
                <div @click="step=3" class="cursor-pointer text-center border-b-2 " x-bind:class="{'border-b-first-orange':step == 3, 'border-b-gray-200' : step !=3}">
                    <p class="px-3 font-black w-full " x-bind:class="{'text-first-orange border-first-orange': step == 3 }">Historiques</p>
                </div>



            </div>
        </div>

        {{-- step 1 général --}}
        <div class="bg-white" x-show.transition="step == 1">
            <div class="flex justify-between px-4 py-4 mt-4">
                <div class="flex items-center">
                    <span class="font-bold mr-2">Statut de la demande:</span>
                    @switch($demande->etat->status)
                    @case(App\Enums\StatusDemandeEnum::BROUILLON)
                    <span class="bg-gray-200 py-1 px-2 rounded text-sm text-gray-800 font-bold">Brouillon</span>
                    @break
                    @case(App\Enums\StatusDemandeEnum::COURS)
                    <span class="bg-blue-200 py-1 px-2 rounded text-sm text-blue-800 font-bold">En cours</span>
                    @break
                    @case(App\Enums\StatusDemandeEnum::VALIDE)
                    <span class="bg-green-200 py-1 px-2 rounded text-sm text-green-800 font-bold">Validé</span>
                    @break
                    @case(App\Enums\StatusDemandeEnum::ATTENTE)
                    <span class="bg-yellow-100 py-1 px-2 rounded text-sm text-yellow-800 font-bold">En attente</span>
                    @break
                    @default
                    <span class="bg-orange-200 py-1 px-2 rounded text-sm text-orange-800 font-bold">Soumis</span>
                    @endswitch


                </div>

               @if((($demande->etat->code != "conforme_1") || ($demande->etat->code != "non_conforme_1")) && Auth::user()->isSuperAdmin())
                <button class="bg-first-orange text-white rounded py-2 px-4 mr-5 font-bold">
                    <a href="{{ route('demande.genererRecepisser', $demande->id) }}">Générer</a>
                </button>
                @endif


                {{-- @if ($demande->etat->position == 1)
                {{-- @if ($demande->etat->position == 1)
                    <div class="flex justify-end">
                        <button class="bg-first-orange text-white rounded-sm py-1 px-2 mr-5 font-bold text-sm">
                            <a href="{{route('demande.completer', $demande->id)}}">Compléter la demande</a>
                </button>
                
            </div>


            @else
            @if ($isAuthorized)
            <livewire:demandes.set-etat-demande :demande="$demande" />
            @endif
            @endif --}}
            @if ($demande->etat->position == 1)
            <div class="flex justify-end">
                <button class="bg-first-orange text-white rounded-sm py-1 px-2 mr-5 font-bold text-sm">
                    <a href="{{ route('demande.completer', $demande->id) }}">Completer la demande</a>
                </button>
            </div>
            @elseif ($isAuthorized)
            <livewire:demandes.set-etat-demande :demande="$demande" />
            @endif



        </div>

        <div class="bg-white">
            <div class="mt-5 pb-12 flex flex-col bg-white shadow-xl w-full rounded-sm">

                <div class="flex w-full flex-1 items-center">
                    <div class="w-1/2 px-8 py-2 flex-1">
                        <div class="w-full mx-auto shadow mt-2 rounded border border-gray-200 border-2">
                            <div class="p-2 mb-2">
                                <h2 class="font-black text-xl py-1">
                                    Informations de la demande
                                </h2>
                                <hr>
                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Type de Demande :</strong>
                                        <span class="text-black">{{ $demande->typeDemande->libelle ?? " - " }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Libellé :</strong>
                                        <span class="text-black">{{ $demande->libelle ?? " - " }}</span>
                                    </div>
                                </div>

                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Etat :</strong>
                                        @if($demande->est_rejete == true )
                                        <span class="bg-red-200 py-1 px-2 rounded text-sm text-red-800 font-bold">Rejeté</span>
                                        @else
                                        <span class="bg-green-200 py-1 px-2 rounded text-sm text-green-800 font-bold">{{ $demande->etat->libelle?? " - " }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Date de dépôt :</strong>
                                        <span class="text-black">{{date('d-m-Y',strtotime($demande->date_depot) ?? " ")}}</span>
                                    </div>
                                </div>

                                @if ($demande->description)
                                <div class="mt-4 mb-2 px-4">
                                    <strong class="text-black font-bold">
                                        Description
                                    </strong>
                                    <p class="shadow border p-2 text-black rounded-sm mb-2">
                                        {{ $demande->description }}
                                    </p>

                                </div>
                                @endif


                                @if ($isAuthorized)
                                <div class="flex justify-end py-3 px-4">

                                    <p class="text-sm font-bold bg-first-orange px-2 py-1 rounded text-white hover:bg-green-700">
                                        <a href="{{ route('demande.edit', $demande->id) }}" class="flex items-center">
                                            <span class="mr-2">{{auth()->user()->hasRole(config('constants.roles.ia')) ? "Joindre le rapport d'enquête" : "Modifier"}}</span>
                                            <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 9.5058L5 10.0458L5.5 7.0058L11.23 1.2958C11.323 1.20207 11.4336 1.12768 11.5554 1.07691C11.6773 1.02614 11.808 1 11.94 1C12.072 1 12.2027 1.02614 12.3246 1.07691C12.4464 1.12768 12.557 1.20207 12.65 1.2958L13.71 2.3558C13.8037 2.44876 13.8781 2.55936 13.9289 2.68122C13.9797 2.80308 14.0058 2.93379 14.0058 3.0658C14.0058 3.19781 13.9797 3.32852 13.9289 3.45037C13.8781 3.57223 13.8037 3.68284 13.71 3.7758L8 9.5058Z" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M12.5 10.0059V13.0059C12.5 13.2711 12.3946 13.5254 12.2071 13.713C12.0196 13.9005 11.7652 14.0059 11.5 14.0059H2C1.73478 14.0059 1.48043 13.9005 1.29289 13.713C1.10536 13.5254 1 13.2711 1 13.0059V3.50586C1 3.24064 1.10536 2.98629 1.29289 2.79875C1.48043 2.61122 1.73478 2.50586 2 2.50586H5" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2 px-8 py-2 flex-1">
                        <div class="w-full mx-auto shadow mt-2 rounded border border-gray-200 border-2">
                            <div class="p-2 mb-2">

                                <h2 class="font-black text-xl py-1">
                                    Données de la demande
                                </h2>
                                <hr>
                                @if(($demande->typeDemande->code == config('constants.requests.D-OUVERTURE-ETABLISSEMENT')) || 
                                ($demande->typeDemande->code == config('constants.requests.D-RECONNAISSANCE') || 
                                ($demande->typeDemande->code == config('constants.requests.D-EXTENSION-FILIERE'))))
                                @foreach($demande->projets as $projet)
                                <div class="mt-4 mb-2 flex w-full px-4 items-center justify-between">
                                    <div class="">
                                        <strong class="text-black">Filière :</strong>
                                        <span class="text-black">{{ $projet->filiere->nom ?? " - " }}</span>
                                    </div>
                                    <div class="">
                                        <strong class="text-black">Niveau :</strong>
                                        <span class="text-black">{{ $projet->niveau->nom ?? " - " }}</span>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                @if(($demande->typeDemande->code == config('constants.requests.D-AUTORISATION-DIRIGER')))
                                @foreach($demande->projets as $projet)
                                <div class="mt-4 mb-2 flex w-full px-4 items-center justify-between">
                                    <div class="">
                                        <strong class="text-black">Nom :</strong>
                                        <span class="text-black">{{ $projet->nom ?? " - " }}</span>
                                    </div>
                                    <div class="">
                                        <strong class="text-black">Prénom :</strong>
                                        <span class="text-black">{{ $projet->prenom ?? " - " }}</span>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                @if(($demande->typeDemande->code == config('constants.requests.D-CHANGEMENT-DENOMINATION')))
                                @foreach($demande->projets as $projet)
                                <div class="mt-4 mb-2 flex w-full px-4 items-center justify-between">
                                    <div class="">
                                        <strong class="text-black">Ancienne dénomination :</strong>
                                        <span class="text-black">{{ $projet->ancienne_denomination_etablissement     ?? " - " }}</span>
                                    </div>
                                    <div class="">
                                        <strong class="text-black">Nouvelle dénomination :</strong>
                                        <span class="text-black">{{ $projet->nouvelle_denomination_etablissement ?? " - " }}</span>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                @if(($demande->typeDemande->code == config('constants.requests.D-TRANSFERT-ETABLISSEMENT')))
                                @foreach($demande->projets as $projet)
                                <div class="mt-4 mb-2 flex w-full px-4 items-center justify-between">
                                    <div class="">
                                        <strong class="text-black">Ancienne adresse :</strong>
                                        <span class="text-black">{{ $projet->ancienne_adresse_etablissement     ?? " - " }}</span>
                                    </div>
                                    <div class="">
                                        <strong class="text-black">Nouvelle adresse :</strong>
                                        <span class="text-black">{{ $projet->nouvelle_adresse_etablissement ?? " - " }}</span>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                @if(($demande->typeDemande->code == config('constants.requests.D-QUALIFICATION-FILIERE')))
                                @foreach($demande->projets as $projet)
                                <div class="mt-4 mb-2 flex w-full px-4 items-center justify-between">
                                    @foreach($projet->aire as $a)
                                    <div class="">
                                        <strong class="text-black">Filière :</strong>
                                        <span class="text-black">{{ $a['filiere']     ?? " - " }}</span>
                                    </div>
                                    <div class="">
                                        <strong class="text-black">Niveau :</strong>
                                        <span class="text-black">{{ $a['niveau'] ?? " - " }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                                @endif
                                @if(($demande->typeDemande->code == config('constants.requests.D-SUBVENTION')))
                                @foreach($demande->projets as $projet)
                                <div class="mt-4 mb-2 flex w-full px-4 items-center justify-between">
                                    <div class="">
                                        <strong class="text-black">Pour l'année académique :</strong>
                                        <span class="text-black">{{ $projet->anneeAcademique->annee1 . ' - '.  $projet->anneeAcademique->annee2 }}</span>
                                    </div>
                                  
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div class="flex w-full flex-1 items-center">
                    <div class="w-1/2 px-8 mt-4">
                        <div class="p-1 border-gray-200 border-2 shadow-xl border rounded">
                            <div class="pt-2 mb-2">
                                <h2 class="font-bold text-xl py-1 px-2">
                                    Informations de l'établissement
                                </h2>
                                <hr>
                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Nom :</strong>
                                        <span class="text-black">{{ $demande->etablissement->nom ?? " - "  }}</span>
                                    </div>
                                </div>

                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Email :</strong>
                                        <span class="text-black">{{ $demande->etablissement->email?? " - " }}</span>
                                    </div>
                                </div>

                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Date de création :</strong>
                                        <span class="text-black">{{date('d-m-Y',strtotime($demande->etablissement->dateCreation) ?? " ")}}</span>
                                    </div>
                                </div>

                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Localisation :</strong>
                                        <span class="text-black">{{ $demande->etablissement->commune->libelle?? " - " }}</span>
                                    </div>
                                </div>

                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Type :</strong>
                                        <span class="text-black">{{ $demande->etablissement->type?? " - " }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Statut :</strong>
                                        <span class="text-black">{{ $demande->etablissement->statut?? " - " }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Statut Juridique :</strong>
                                        <span class="text-black">{{ $demande->etablissement->statutJuridique?? " - " }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="w-1/2 px-8 mt-4 ">
                        <div class="p-1 border-gray-200 border-2 shadow-xl border rounded">
                            <div class="pt-2 mb-2">
                                <h2 class="font-bold text-xl py-1 px-2">
                                    Informations du requêteur
                                </h2>
                                <hr>
                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Nom et Prénom :</strong>
                                        <span class="">{{ $demande->demandeur->nom . ' '.  $demande->demandeur->prenom ?? " - " }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Email :</strong>
                                        <span class="">{{ $demande->demandeur->email  ?? " - " }}</span>
                                    </div>
                                </div>
                                <div class="mt-4 mb-2 flex">
                                    <div class="flex w-full px-4 items-center justify-between">
                                        <strong class="text-black">Adresse :</strong>
                                        <span class="text-black"><span class="">{{ $demande->demandeur->adresse  ?? " - " }}</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- step 2 : documents --}}
    <div class="bg-white" x-show.transition="step == 2">
        @if ($isAuthorized)
        <livewire:etude-demande.gerer-document :demande="$demande" />
        @else
        <div class="mt-5 border border-gray-100">
            <div class="p-5">
                <p class="font-black text-xl ">Les pièces jointes : </p>
            </div>
            <ul class="list-disc pl-4 flex flex-wrap justify-evenly">

                @foreach($demande->documents as $key=> $document)
                <li class="flex items-center justify-between mb-2 bg-gray-100 w-[350px] m-3 p-3">

                    <div class="flex items-center w-[290px] overflow-hidden">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.75293 10.5C10.0484 10.5 10.341 10.4418 10.614 10.3287C10.887 10.2157 11.135 10.0499 11.3439 9.84099C11.5529 9.63206 11.7186 9.38402 11.8317 9.11104C11.9447 8.83806 12.0029 8.54547 12.0029 8.25C12.0029 7.95453 11.9447 7.66194 11.8317 7.38896C11.7186 7.11598 11.5529 6.86794 11.3439 6.65901C11.135 6.45008 10.887 6.28434 10.614 6.17127C10.341 6.0582 10.0484 6 9.75293 6C9.15619 6 8.5839 6.23705 8.16194 6.65901C7.73998 7.08097 7.50293 7.65326 7.50293 8.25C7.50293 8.84674 7.73998 9.41903 8.16194 9.84099C8.5839 10.2629 9.15619 10.5 9.75293 10.5Z" fill="#0d6e77" />
                            <path d="M21 21C21 21.7956 20.6839 22.5587 20.1213 23.1213C19.5587 23.6839 18.7956 24 18 24H6C5.20435 24 4.44129 23.6839 3.87868 23.1213C3.31607 22.5587 3 21.7956 3 21V3C3 2.20435 3.31607 1.44129 3.87868 0.87868C4.44129 0.316071 5.20435 0 6 0L14.25 0L21 6.75V21ZM6 1.5C5.60218 1.5 5.22064 1.65804 4.93934 1.93934C4.65804 2.22064 4.5 2.60218 4.5 3V18L7.836 14.664C7.95422 14.5461 8.10843 14.4709 8.27417 14.4506C8.43992 14.4302 8.60773 14.4657 8.751 14.5515L12 16.5L15.2355 11.97C15.2988 11.8815 15.3806 11.8078 15.4753 11.754C15.5699 11.7003 15.6751 11.6678 15.7836 11.6588C15.8921 11.6498 16.0012 11.6645 16.1034 11.702C16.2056 11.7394 16.2985 11.7986 16.3755 11.8755L19.5 15V6.75H16.5C15.9033 6.75 15.331 6.51295 14.909 6.09099C14.4871 5.66903 14.25 5.09674 14.25 4.5V1.5H6Z" fill="#0d6e77" />
                        </svg>

                        <span class="ml-3 w-[265px] overflow-hidden">{{$document["nom"]}}</span>
                    </div>
                    <div class="flex items-center w-[40px] justify-between">
                        <a href="{{ asset('/storage/' . $document->lien_ressource) }}" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_747_2897)">
                                    <path d="M0.916992 6.99998C0.916992 6.99998 3.25033 2.33331 7.33366 2.33331C11.417 2.33331 13.7503 6.99998 13.7503 6.99998C13.7503 6.99998 11.417 11.6666 7.33366 11.6666C3.25033 11.6666 0.916992 6.99998 0.916992 6.99998Z" stroke="#0d6e77" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7.3335 8.75C8.29999 8.75 9.0835 7.9665 9.0835 7C9.0835 6.0335 8.29999 5.25 7.3335 5.25C6.367 5.25 5.5835 6.0335 5.5835 7C5.5835 7.9665 6.367 8.75 7.3335 8.75Z" stroke="#0d6e77" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_747_2897">
                                        <rect width="14" height="14" fill="white" transform="translate(0.333496)" />
                                    </clipPath>
                                </defs>
                            </svg>

                        </a>
                        <a href="{{ asset('/storage/' . $document->lien_ressource) }}" download>
                            <svg width="18" height="17" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.5835 8.75V11.0833C12.5835 11.3928 12.4606 11.6895 12.2418 11.9083C12.023 12.1271 11.7262 12.25 11.4168 12.25H3.25016C2.94074 12.25 2.644 12.1271 2.4252 11.9083C2.20641 11.6895 2.0835 11.3928 2.0835 11.0833V8.75" stroke="#0d6e77" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4.41699 5.83331L7.33366 8.74998L10.2503 5.83331" stroke="#0d6e77" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M7.3335 8.75V1.75" stroke="#0d6e77" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        </a>

                    </div>
                </li>

                @endforeach
            </ul>

        </div>

        @endif
    </div>
    {{-- step 3 : historique --}}
    <div class="bg-white" x-show.transition="step == 3">
        <table class="border-collapse w-full mt-5">
            <tbody>
                @foreach ($historiques as $historique)
                <tr class="border-b">
                    <td class="p-4">
                        <div class="relative">
                            @if ($loop->last)
                            <div class="flex">
                                <div class="relative mr-3">


                                    <p class="rounded-full bg-gray-200 h-8 w-8 relative z-20"></p>
                                </div>
                                <p class="text-first-orange">{{$historique->etatWorkflow->libelle}}</p>
                            </div>

                            @else
                            <div class="flex">
                                <div class="relative mr-3">
                                    <svg class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-30" width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.20948 11.5602C5.04155 11.5676 4.87603 11.5183 4.73948 11.4202L0.249483 7.71024C-0.0397957 7.45413 -0.0833516 7.01857 0.149483 6.71024C0.405152 6.4223 0.837337 6.37476 1.14948 6.60024L5.14948 9.86024L15.6495 0.150241C15.96 -0.0828876 16.3971 -0.0404685 16.657 0.248016C16.9169 0.5365 16.9136 0.97565 16.6495 1.26024L5.71948 11.3602C5.58026 11.488 5.39843 11.5593 5.20948 11.5602Z" fill="#27AE60" />
                                    </svg>

                                    <p class="rounded-full bg-green-200 h-8 w-8 relative z-20"></p>
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 h-20 w-1 bg-cyan-700 z-10"></div>
                                </div>
                                <p class="text-green-600">{{$historique->etatWorkflow->libelle}}</p>
                            </div>

                            @endif
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="text-gray-700 text-sm">
                            {{ \Carbon\Carbon::parse($historique->date_entree)->format('d M Y, H:i:s') }}
                        </div>
                        <div class="mb-2">{{$historique->etatWorkflow->description ?? " - "}}</div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold mb-2">{{$historique->user->prenom}} {{$historique->user->nom}}
                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>


    </div>


    </div>


    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('refresh', function() {
                window.location.reload();
            });
        });
    </script>




</x-app-layout>