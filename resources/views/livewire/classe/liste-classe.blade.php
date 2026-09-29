<div>
    <div class="flex mb-5 justify-between">
        <div class="flex">
            <span href="#" class="bg-transparent border-transparent px-4  py-2 flex text-black text-sm text-center  bg-white items-center">
                <svg class="w-6 h-6 text-first-orange font-bold" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </span>
            <input type="text" wire:model="search" wire:keydown="$refresh" placeholder="Rechercher" class="form-input text-sm px-4 py-3 w-max shadow-sm border-white">
        </div>
        <div class="flex">
            <a href="#" class="mx-2 px-5 rounded-md py-0 flex text-orange-400 text-xs font-bold text-center shadow-md bg-white items-center">
                <span><i class="fa fa-download"></i></span>
                <span class="mx-2">Télécharger liste</span>
            </a>
            <select wire:model="selectedClasseAnnee" wire:change="$refresh">
    <option value="">Choisissez une année</option>
    @foreach ($annee_academique as $annee)
        <option value="{{ $annee->id }}">
            {{ $annee->code ?: ($annee->annee1 . ' - ' . $annee->annee2) }}
            @if($annee->is_open) (en cours) @endif
        </option>
    @endforeach
</select>
 @php
    $user = auth()->user();
@endphp

@if($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude') )
            <a href="{{route('classe.create')}}" class="px-3 rounded-md py-3 flex text-white text-xs font-bold text-center bg-orange-400 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                        <path id="Vector" d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z" fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_705_6988">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg><span class="mx-2">Ajouter une classe</span>

            </a>
@endif
        </div>
    </div>

@if($count)
<div class="mb-2"><span class="bg-green-100 font-bold p-1 px-2 rounded">{{ $count }} classes trouvées</span></div>
@endif
    <div class="flex  -mx-3 mb-0  space-x-4 space-x-reverse" style="padding:8px;">
        @if(optional(Auth()->user()->personnel)->etablissement_id === null)
        <div class="w-full px-7">
            <label class="block tracking-wide text-gray-700 text-xs font-bold mb-2" for="selectedClasseFiliere">
                Etablissement
            </label>
            <select id="selectedEtablissement" wire:model="selectedEtablissement" name="selectedEtablissement" wire:change="$refresh" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2" required autofocus>
                <option value="">Choisissez un établissement</option>
                @foreach ($etablissements as $etablissement)
                <option value="{{ $etablissement->id }}">{{ $etablissement->nom }}</option>
                @endforeach
            </select>
        </div>
        @endif
     


        <div class="w-full px-7">
            <label class="block  tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                Filiere
            </label>
            <select id="selectedClasseFiliere" wire:model="selectedClasseFiliere" name="selectedClasseFiliere" wire:change="$refresh" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " required autofocus>
                <option value="">Choisissez une Filière</option>
                @foreach ($filieres as $filiere)
                <option value="{{$filiere->id}}">{{ $filiere->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full px-7">
            <label class="block  tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                Metier
            </label>
            <select id="selectedClasseMetier" wire:model="selectedClasseMetier" name="metier_id" wire:change="$refresh" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " required autofocus>
                <option value="">Choisissez un métier</option>
                @foreach ($metiers as $metier)
                <option value="{{$metier->id}}">{{ $metier->nom }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="w-full bg-transparent rounded-lg shadow-xs p-0 flex flex-wrap">

        @forelse ($classes as $classe)
        <div class="sm:w-1/3 w-full p-4">
            <div class="rounded-lg shadow-md p-4 bg-white2 ">
                <h1 class="font-bold text-lg"><i class="fa-solid fa-building-user" style="color:green;"></i> {{$classe->libelle }}</h1>
                <hr class="my-2" />
                <div class="flex mb-4 items-center">
                    <div class="px-4 flex-1">
                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-building"></i>&nbsp;EFPT : <span class="font-bold">{{ $classe->etablissement->nom ?? ' - ' }}</span></h3>
                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-star"></i>&nbsp;Filière : <span class="font-bold">{{ $classe->niveau_etude->metier->filiere->nom ?? ' - ' }}</span></h3>

                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-star"></i>&nbsp;Niveau Etude : <span class="font-bold">{{ $classe->niveau_etude->nom ?? ' - ' }}</span></h3>

                        <h3 class="text-sm py-1"><i class=" text-green-600 fas fa-window-maximize"></i></i>&nbsp;Modalite : <span class="font-bold">{{ $classe->modalite ?? ' - ' }}</span></h3>
                                              
                    </div>
                    <div clas s="px-4 flex items-end">
                        <div class="flex items-center {{$classe->statut ? 'bg-green-100' : 'bg-red-100'}} px-4 py-1 rounded-lg">
                            <i class="fa fa-circle {{$classe->statut ? 'text-green-600' : 'text-red-600' }} text-xs pr-3"></i>
                            <h3>{{$classe->statut ? 'Lancée' : 'en attente'}}</h3>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mt-4">
                    <div class="flex justify-between items-center mt-3">

                        @php
                         $user = auth()->user();
                         @endphp

            
                        @if(!$classe->statut)
                        <a href="{{ route('classe.validate', $classe->id) }}" class="flex items-center px-1 rounded-md py-1 border flex text-purple-600 text-sm text-center bg-white border-purple-600 hover:bg-purple-600 hover:text-white">
                            <i class="fa fa-check"></i>
                            <span class="mx-2">Lancer</span>
                        </a>
                        @endif
                        <a href="{{ route('classe.referentiels', $classe->id) }}" class="flex items-center px-1 rounded-md py-1 border flex text-purple-600 text-sm text-center bg-white border-purple-600 hover:bg-purple-600 hover:text-white">
                        <i class="fa fa-check"></i>
                        <span class="mx-2"> Voir référentiels</span>
                         </a>
                        @if ($user->hasAnyRole(['apprenant', 'formateur','chef_de_travaux','chef_etablissement']))
                        <a href="#" class="flex items-center px-1 rounded-md py-1 border flex text-orange-600 text-sm text-center bg-white border-orange-600 hover:bg-orange-600 hover:text-white disabled">
                            <i class="fa fa-edit"></i>
                            <span class="mx-2">Accéder à mes cours E-jang</span>
                        </a>
                        @endif
                        <a href="{{route('classe.show',$classe->id)}}" class="flex items-center px-1 rounded-md py-1 border flex text-green-600 text-sm text-center bg-white border-green-600 hover:bg-green-600 hover:text-white">
                            <i class="fa fa-eye"></i>
                            <span class="mx-2">Détails</span>
     </a>
      @if ($user->hasRole('apprenant'))
    @if ($classe->modalite === 'PPO')
        <a href="#" 
           onclick="ouvrirModalDevoirsPPO({{ auth()->user()->inscription_id }})" 
           class="flex items-center px-1 rounded-md py-1 border text-blue-600 text-sm text-center bg-white border-blue-600 hover:bg-blue-600 hover:text-white">
            <i class="fa fa-check"></i>
            <span class="mx-2">Voir mes devoirs</span>
        </a>
    @elseif ($classe->modalite === 'APC')
        <a href="#" 
           onclick="ouvrirModalDevoirsAPC({{ auth()->user()->inscription_id }})" 
           class="flex items-center px-1 rounded-md py-1 border text-blue-600 text-sm text-center bg-white border-blue-600 hover:bg-blue-600 hover:text-white">
            <i class="fa fa-check"></i>
            <span class="mx-2">Voir mes devoirs</span>
        </a>
    @endif
   @endif
   @if(auth()->user()->hasRole('apprenant'))
      @include('livewire.classe.devoirPPO')
   @endif
     </div>
                </div>
            </div>
        </div>
        @empty
        <div class="w-full justify-center">
            <h3 class="font-bold text-xl py-4 text-center">Aucune donnée disponible</h3>
        </div>
        @endforelse
      </div>


    <div class="flex justify-start items-center mt-5">
        <button {{$startLimit == 0 ? 'disabled' : '' }} wire:click="prev" type="button" class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none">
                <path id="Polygon 1" d="M0.982423 8.69351C-0.0296571 7.89277 -0.0296574 6.35734 0.982422 5.55659L7.00906 0.788418C8.32029 -0.249004 10.25 0.684883 10.25 2.35688V11.8932C10.25 13.5652 8.32029 14.4991 7.00906 13.4617L0.982423 8.69351Z" fill="black" />
            </svg>
        </button>
        <span class="text-md text-black mx-3">{{min($count,$startLimit+1)}} à {{ min($startLimit+10,$count) }} sur {{$count}}</span>
        <button wire:click="next" {{($startLimit+10) >= $count ? 'disabled' : '' }} type="button" class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
            <svg class="w-4 h-4" width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path id="Polygon 1" d="M10.0176 5.55649C11.0297 6.35723 11.0297 7.89266 10.0176 8.69341L3.99094 13.4616C2.67971 14.499 0.75 13.5651 0.75 11.8931L0.75 2.35677C0.75 0.684774 2.67971 -0.249114 3.99094 0.788308L10.0176 5.55649Z" fill="black" />
            </svg>
        </button>
    </div>
    @if(auth()->user()->hasRole('apprenant'))
    @include('livewire.classe.devoirAPC')
   @endif
</div>

