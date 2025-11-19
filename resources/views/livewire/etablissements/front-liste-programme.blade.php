<div class="bg-transparent">
    <div class="flex mb-5 justify-between px-4 flex-col sm:flex-row">
        <div class="flex">
            <span href="#" class="bg-transparent border-transparent px-4  py-2 flex text-black text-sm text-center  bg-white items-center">
                <svg class="w-6 h-6 text-first-orange font-bold" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
            </span>
            <input type="text" wire:model="search" wire:keydown="$refresh" placeholder="Rechercher" class="form-input text-sm px-4 py-3 w-full sm:w-max shadow-sm border border-first-orange">
        </div>
    </div>

    <div class="flex mb-0 justify-end px-4 flex-col sm:flex-row">
    <div class="grid md:grid-cols-1 md:gap-6 pt-2 sm:mr-4">
            <div class="mb-4">
                <label for="sigle" class="block text-gray-700 text-sm font-bold mb-2 ">Filtre Par Secteur</label>
                <select wire:model="selectedSecteur" wire:change="$refresh" class="border border-gray-300 p-3 w-full sm:max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold text-black">
                    <option value="">Sélectionnez un secteur</option>
                    @foreach ($secteurs as $secteur)
                        <option value="{{ $secteur->id }}">{{ $secteur->libelle }}</option>
                    @endforeach
                </select>
                @error('secteur')
                <span class="text-red-500 text-xs mt-3 block ">{{$message}}</span>
                @enderror
            </div>
        </div>


        <div class="grid md:grid-cols-1 md:gap-6 pt-2 sm:mr-4">
            <div class="mb-4">
                <label for="sigle" class="block text-gray-700 text-sm font-bold mb-2">Filtre Par filiere</label>
                <select   @if(!$selectedSecteur) disabled @endif wire:model="selectedFiliere" wire:change="$refresh" id="selectedFiliere"  class="border border-gray-300 p-3 w-full focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold text-black">
                    <option value="">Sélectionnez une filiére</option>
                    
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                    @endforeach
                  
                </select>
                @error('filiere
                ')
                <span class="text-red-500 text-xs mt-3 block ">{{$message}}</span>
                @enderror
            </div>
        </div>
      

     </div>

   


     @if($count)
         <div class="my-0 py-0"><span class="mx-4 bg-first-orange font-bold p-1 px-2 rounded text-white">{{ $count }} programmes trouvés</span></div>
     @endif
    <div class="w-full bg-transparent rounded-lg shadow-xs p-0 flex flex-wrap">


    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 m-2">
    @forelse($metiers as $metier)
        <div class="w-full h-auto bg-white rounded-md shadow-md">
            <div class="p-3">
                <div class="font-bold text-lg mb-2 bg-gray-200 p-2 rounded">
                    {{ Str::limit($metier->nom ?? '-', 32) }}
                </div>
            </div>
            <div class="px-3 py-2">
                <ul class="max-h-48 overflow-y-auto">
                    {{-- Affichage filière et secteur --}}
                    <li class="border-b p-2 font-normal mb-1">
                        <i class="fa fa-circle text-xs me-2"></i><span class="font-bold">Secteur :</span>{{ $metier->filiere->secteur->libelle ?? '-' }}
                    </li>
                    <li class="border-b p-2 font-normal mb-1">
                        <i class="fa fa-circle text-xs me-2"></i><span class="font-bold">Filiere :</span>{{ $metier->filiere->nom ?? '-' }}
                    </li>

                    {{-- Affichage des diplômes uniques liés aux niveaux --}}
                    @foreach($metier->niveaux->pluck('diplome')->unique('id') as $diplome)
    <li class="border-b p-2 font-normal mb-1 text-[#FF6B35]">
        <i class="fa fa-circle text-xs me-2"></i>
        <span class="font-bold">Diplôme :</span> {{ $diplome->nom ?? '-' }}
    </li>
@endforeach
                </ul>
            </div>
        </div>
    @empty
        <div class="w-full justify-center">
            <h3 class="font-bold text-xl py-4 text-center">Aucune donnée disponible</h3>
        </div>
    @endforelse
</div>




    @if($count > 12)
    <div class="flex justify-start items-center mt-5 px-4 pb-4">
        <button {{$startLimit == 0 ? 'disabled' : '' }} wire:click="prev" type="button" class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none">
                <path id="Polygon 1" d="M0.982423 8.69351C-0.0296571 7.89277 -0.0296574 6.35734 0.982422 5.55659L7.00906 0.788418C8.32029 -0.249004 10.25 0.684883 10.25 2.35688V11.8932C10.25 13.5652 8.32029 14.4991 7.00906 13.4617L0.982423 8.69351Z" fill="black" />
            </svg>
        </button>
        <span class="text-md text-black mx-3">{{min($count,$startLimit+1)}} à {{ min($startLimit+12,$count) }} sur {{$count}}</span>
        <button wire:click="next" {{($startLimit+12) >= $count ? 'disabled' : '' }} type="button" class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center">
            <svg class="w-4 h-4" width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path id="Polygon 1" d="M10.0176 5.55649C11.0297 6.35723 11.0297 7.89266 10.0176 8.69341L3.99094 13.4616C2.67971 14.499 0.75 13.5651 0.75 11.8931L0.75 2.35677C0.75 0.684774 2.67971 -0.249114 3.99094 0.788308L10.0176 5.55649Z" fill="black" />
            </svg>
        </button>
    </div>
    @endif

    {{-- <div class="w-full rounded-lg shadow-xs p-0">
        <div class="text-sm w-full p-0 overflow-x-auto">
            
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
</div>
</div> --}}

</div>
