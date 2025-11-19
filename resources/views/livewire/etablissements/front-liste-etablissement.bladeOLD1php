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
                <label for="sigle" class="block text-gray-700 text-sm font-bold mb-2">Filtre Par Région</label>
                <select  wire:model="selectedRegion" wire:change="$refresh" id="selectRegion"  class="border border-gray-300 p-3 w-full focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold text-black">
                    <option value="">Sélectionnez une région</option>
                    @if ($regions)
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->libelle }}</option>
                    @endforeach
                    @endif
                </select>
                @error('region
                ')
                <span class="text-red-500 text-xs mt-3 block ">{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="grid md:grid-cols-1 md:gap-6 pt-2 sm:mr-4">
            <div class="mb-4">
                <label for="sigle" class="block text-gray-700 text-sm font-bold mb-2 ">Filtre Par Département</label>
                <select @if(!$selectedRegion) disabled @endif wire:model="selectedDepartement" wire:change="$refresh" class="border border-gray-300 p-3 w-full sm:max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold text-black">
                    <option value="">Sélectionnez un département</option>
                    @foreach ($departements as $departement)
                        <option value="{{ $departement->id }}">{{ $departement->libelle }}</option>
                    @endforeach
                </select>
                @error('departement')
                <span class="text-red-500 text-xs mt-3 block ">{{$message}}</span>
                @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-1 md:gap-6 pt-2">
            <div class="mb-4">
                <label for="sigle" class="block text-gray-700 text-sm font-bold mb-2">Filtre Par commune</label>
                <select @if(!$selectedDepartement) disabled @endif wire:model="selectedCommune" wire:change="$refresh" class="border border-gray-300 p-3 w-full sm:max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold text-black ">
                    <option value="">Sélectionnez une commune</option>
                    @foreach ($communes as $commune)
                        <option value="{{ $commune->id }}">{{ $commune->libelle }}</option>
                    @endforeach
                </select>
                @error('commune')
                <span class="text-red-500 text-xs mt-3 block ">{{$message}}</span>
                @enderror
            </div>
        </div>

     </div>



     @if($count)
         <div class="my-0 py-0"><span class="mx-4 bg-first-orange font-bold p-1 px-2 rounded text-white">{{ $count }} efpt(s) trouvés</span></div>
     @endif
    <div class="w-full bg-transparent rounded-lg shadow-xs p-0 flex flex-wrap">

        @forelse ($etablissements as $etablissement)
        <div class="sm:w-1/3 w-full p-4 text-black">
            <div class="rounded-lg shadow-md p-4 bg-white3">
                <h1 class="font-bold text-lg"><i class="fa-solid fa-building text-first-orange"></i> {{$etablissement->nom}}</h1>
                <hr class="my-2" />
                <div class="flex flex-col sm:flex-row mb-4 sm:items-center">
                    <img class="rounded-lg sm:w-1/3 w-1/2 px-4" src="{{ asset('storage/etablissements/'. $etablissement->logo) }}" alt="Logo" />
                    <div class="px-4 flex-1 py-3 sm:py-0">
                        <h3 class="text-sm py-1"><i class="text-first-orange fa fa-location"></i>&nbsp;Région : <span class="font-bold">{{ $etablissement->commune->departement->region->libelle ?? ' - ' }}</span></h3>
                        <h3 class="text-sm py-1"><i class="text-first-orange fa fa-list"></i>&nbsp;Etablissement : <span class="font-bold">{{ $etablissement->nom ?? ' - ' }}</span></h3>
                        <h3 class="text-sm py-1"><i class="text-first-orange fa fa fa-list"></i>&nbsp;Type : <span class="font-bold">{{ $etablissement->statut ?? ' - ' }}</span></h3>
                        <h3 class="text-sm py-1"><i class="text-first-orange fa fa-envelope"></i>&nbsp;Email : <span class="font-bold">{{ $etablissement->email ?? ' - ' }}</span></h3>

                       {{-- <h3 class="text-sm py-1"><i class="text-first-orange fa fa-list"></i>&nbsp;Nombre d'étudiants : {{$students}}</h3>  --}}
                    </div>
                    <div class="px-4 flex items-end py-1 sm:py-0">
                        <div class="flex items-center {{$etablissement->is_active ? 'bg-green-100' : 'bg-red-100'}} px-4 py-1 rounded-lg">
                        <i class="fa fa-circle {{$etablissement->is_active ? 'text-orange-600' : 'text-red-600' }} text-xs pr-3"></i>
                            <h3>{{$etablissement->is_active ? 'Actif' : 'Inactif'}}</h3>
                        </div>
                    </div>
                </div>
                <hr>
                {{-- <div class="mt-4">
                    <div class="flex justify-between items-center mt-3">
                        <a href="{{route('etablissement.edit',$etablissement->id)}}" class="flex items-center px-1 rounded-md py-1 border flex text-orange-600 text-sm text-center bg-white border-orange-600 hover:bg-orange-600 hover:text-white">
                            <i class="fa fa-edit"></i>
                            <span class="mx-2">Modifier</span>
                        </a>
                        <a href="{{route('etablissement.show',$etablissement->id)}}" class="flex items-center px-1 rounded-md py-1 border flex text-green-600 text-sm text-center bg-white border-green-600 hover:bg-green-600 hover:text-white">
                            <i class="fa fa-eye"></i>
                            <span class="mx-2">Détails</span>
                        </a>
                    </div>
                </div> --}}
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
            <table class="w-full border-t mb-3">
                <thead>
                    <tr
                        class="text-xs font-black tracking-wide text-left text-white font-bold uppercase border-b bg-first-orange">
                        <th class="px-4 py-3">Logo</th>
                        <th class="px-4 py-4 text-white">Nom</th>
                        <th class="px-4 py-4 text-white">Sigle</th>
                        <th class="px-4 py-4 text-white">Email</th>
                        <th class="px-4 py-4 text-white">Telephone</th>
                        <th class="px-4 py-4 text-white">Adresse</th>
                        <th class="px-4 py-4 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y ">
                    @forelse ($etablissements as $etablissement)
                        <tr class="text-gray-700 ">
                            <td class="px-4 py-3 border-b">
                                <a target="_blank" href="{{ asset('storage/etablissements/'. $etablissement->logo) }}"><img class="thumbnail-slider" src="{{ asset('storage/etablissements/'. $etablissement->logo) }}" alt="Logo" /></a>
    </td>
    <td class="px-4 py-3 border-b">{{ $etablissement->nom ?? ' - ' }}</td>
    <td class="px-4 py-3 border-b">{{ $etablissement->sigle ?? ' - ' }}</td>
    <td class="px-4 py-3 border-b text-maquette-gris">
        {{ $etablissement->email ?? ' - ' }}
    </td>
    <td class="px-4 py-3 border-b">{{ $etablissement->telephone ?? '-' }}</td>
    <td class="px-4 py-3 border-b text-maquette-gris">{{ $etablissement->adresse ?? '-' }}</td>
    <td class="px-4 py-3 border-b text-end">
        <div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
            <div @click="open = ! open">
                <button class="bg-dark hover:first-orange text-white font-semibold py-2 px-4 rounded inline-flex items-center justify-end">

                    <svg width="18" height="4" viewBox="0 0 18 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="Iconly/Light-Outline/More-Circle">
                            <g id="More-Circle">
                                <g id="Combined-Shape">
                                    <path d="M17.5 2C17.5 1.06211 16.7419 0.303986 15.804 0.303986H15.787C14.8508 0.303986 14.0995 1.06211 14.0995 2C14.0995 2.9379 14.8661 3.69602 15.804 3.69602C16.7419 3.69602 17.5 2.9379 17.5 2Z" fill="#1A4085" />
                                    <path d="M10.6995 2C10.6995 1.06211 9.94138 0.303986 9.00348 0.303986H8.98822C8.05032 0.303986 7.30068 1.06211 7.30068 2C7.30068 2.9379 8.06559 3.69602 9.00348 3.69602C9.94138 3.69602 10.6995 2.9379 10.6995 2Z" fill="#1A4085" />
                                    <path d="M3.90051 2C3.90051 1.06211 3.14239 0.303986 2.2045 0.303986H2.18923C1.25134 0.303986 0.5 1.06211 0.5 2C0.5 2.9379 1.2666 3.69602 2.2045 3.69602C3.14239 3.69602 3.90051 2.9379 3.90051 2Z" fill="#1A4085" />
                                </g>
                            </g>
                        </g>
                    </svg>

                </button>
            </div>

            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 mt-1 w-48 rounded-md shadow-lg origin-top-right right-0" @click="open = false" style="display: none;">
                <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">
                    <div class="border shadow-md py-2 text-center">
                        <a href="{{ route('etablissement.show', $etablissement->id) }}" class="text-purple-600">Voir
                        </a>
                    </div>
                    <div class="border shadow-md py-2 text-center">
                        <a href="{{ route('etablissement.edit', $etablissement->id) }}" class="text-purple-600">
                            Modifier
                        </a>
                    </div>
                    <div class="border shadow-md py-2 text-center">
                        <form class="text-center" action="{{ route('etablissement.destroy', $etablissement->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button title="Supprimer" type="submit" class="text-purple-600">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="px-4 py-4 font-bold text-lg text-center">Aucune donnée disponible</td>
    </tr>
    @endforelse
    </tbody>
    </table>
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
