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
           
           
            <a href="{{route('inspecteur.create')}}" class="px-3 rounded-md py-3 flex text-white text-xs font-bold text-center bg-orange-400 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                        <path id="Vector" d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z" fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_705_6988">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg><span class="mx-2">Ajouter un inspecteur </span>

            </a>
            

            
        </div>
    </div>
    <div class="flex my-1 justify-between px-4">

       

    </div>




    <div class="w-full bg-transparent rounded-lg shadow-xs p-0 flex flex-wrap">

        @forelse ($inspecteurs as $inspecteur)
        <div class="sm:w-1/3 w-full p-4">
            <div class="rounded-lg shadow-md p-4 bg-white3">
                <h1 class="font-bold text-lg"><i class="fa-solid fa-user text-orange-clair">   </i> {{$inspecteur->prenom}} {{$inspecteur->nom}}</h1>
                <hr class="my-2" />
                <div class="flex mb-4 items-center">
                    <img class="rounded-lg w-1/3 sm:w-1/6" src="{{ asset('storage/inspecteurs/'. $inspecteur->logo) }}" alt="Logo" />
                    <div class="px-4 flex-1">
                        <h3 class="text-sm py-1"><i class="text-orange-clair fa fa-location"></i>&nbsp;Email : <span class="font-bold">{{ $inspecteur->email ?? ' - ' }}</span></h3>
                        <h3 class="text-sm py-1"><i class="text-orange-clair fa fa-list"></i>&nbsp;Telephone : <span class="font-bold">{{ $inspecteur->telephone ?? ' - ' }}</span></h3>
                        <h3 class="text-sm py-1"><i class="text-orange-clair fa fa-list"></i>&nbsp;Specialite : <span class="font-bold">{{ $inspecteur->specialite ?? ' - ' }}</span></h3>

                        <h3 class="text-sm py-1"><i class="text-orange-clair fa fa-list"></i>&nbsp;IA :{{ $inspecteur->ia->nom ?? ' - ' }}</h3>
                    </div>
                    <div class="px-4 flex items-end">
                        <div class="flex items-center {{$inspecteur->is_active ? 'bg-orange-100' : 'bg-red-100'}} px-4 py-1 rounded-lg">
                            <i class="fa fa-circle {{$inspecteur->is_active ? 'text-orange-600' : 'text-red-600' }} text-xs pr-3"></i>
                            <h3>{{$inspecteur->is_active ? 'Actif' : 'Inactif'}}</h3>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mt-4">
                    <div class="flex justify-between items-center mt-3">
                        <a href="{{route('inspecteur.edit',$inspecteur->id)}}" class="flex items-center px-1 rounded-md py-1 border flex text-orange-600 text-sm text-center bg-white border-orange-600 hover:bg-orange-600 hover:text-white">
                            <i class="fa fa-edit"></i>
                            <span class="mx-2">Modifier</span>
                        </a>
                        <a href="{{route('inspecteur.show',$inspecteur->id)}}" class="flex items-center px-1 rounded-md py-1 border flex text-green-600 text-sm text-center bg-white border-green-600 hover:bg-green-600 hover:text-white">
                            <i class="fa fa-eye"></i>
                            <span class="mx-2">Détails</span>
                        </a>
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
   



</div>
