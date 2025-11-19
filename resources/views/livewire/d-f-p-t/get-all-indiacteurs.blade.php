<div>
    
        
        <div class="my-4 px-4">
            <label for="indicateur" class="block text-gray-700 text-sm font-bold mb-2">Filtre Par Annee Academique</label>
            <select wire:model="selectedClasseAnnee" name="selectedClasseAnnee" wire:change="$refresh"
                class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                <option value="">Sélectionnez une année academique</option>
                @foreach($annees as $academiques)
                <option value="{{ $academiques->id }}">{{ $academiques->annee1 }}-{{ $academiques->annee2 }}</option>
                @endforeach

            </select>

        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 p-4 lg:grid-cols-2 xl:grid-cols-4"> 
        
        
        @foreach ($indicateurs as $indicateur)
            <a wire:click="getRealisations('{{ $indicateur->id }}','{{ $indicateur->typeIndicateur->libelle }}')" href="#" class="element_sidebar_acitf flex items-center justify-between p-2 rounded-md dark:bg-darker">
            <div>
                <h6 class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light" style="color: white;">
                {{ $indicateur->typeIndicateur->libelle }}
                </h6>
                {{-- <span class="text-xl font-semibold" style="color: brown;">30,000</span>
                <span class="inline-block px-2 py-px ml-2 text-xs text-green-500 bg-green-100 rounded-md">
                +4.4%
                </span> --}}
            </div>
            <div>
                <span>
                <svg class="w-12 h-12 text-gray-300 dark:text-primary-dark" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                </span>
            </div>
            </a>
            {{-- suiviIndicateur --}}

                        <!-- Main modal -->
                        <div tabindex="-1" aria-hidden="true"
                            class="flex justify-center bg-slate-700 bg-opacity-25 {{ $realisations?'':'hidden' }}  overflow-y-auto overflow-x-hidden fixed z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-4xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class=" flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <div>
                                            <h1 class="font-bold text-lg">
                                                <i class="fa-solid fa-building-circle-check" style="color:green;"></i>
                                                    {{ $nameIndicateur ?? ' - ' }}
                                            </h1>
                                        </div>
                                        <button wire:click="close" type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="show-suiviindicateur-modal'{{ $indicateur->id }}'">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    @if ($realisations)
                                    <div class="w-full p-3 overflow-hidden rounded-lg shadow-xs p-0">
                                        <div class="text-sm w-full overflow-x-scroll p-0">
                                            <table class="w-full border-t mb-3">
                                                <thead>
                                                    <tr
                                                        class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b bg-first-orange">
                                                        <th class="px-4 py-3">Indicateur </th>
                                                        <th class="px-4 py-4">Nom Etalissement</th>
                                                        <th class="px-4 py-4">Valeur</th>
                                                        <th class="px-4 py-4">Date Ajout</th>

                                                    </tr>
                                                </thead>

                                                <tbody class="bg-white divide-y ">
                                                    @forelse ($realisations as $realisation)

                                                    <tr class="text-gray-700 ">
                                                        <td class="px-6 py-3 border-b">
                                                            {{$realisation->indicateur->typeIndicateur->libelle ?? ' - '}}
                                                        </td>
                                                        <td class="px-6 py-3 border-b">
                                                            {{$realisation->etablissement->sigle??' - ' }}
                                                        </td>
                                                        <td class="px-6 py-3 border-b">
                                                            {{ $realisation->valeurAtteinte ?? '-' }}
                                                        </td>
                                                        
                                                        <td class="px-6 py-3 border-b">
                                                            {{ date('d-m-y',strtotime($realisation->created_at)) ?? '-' }}
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="6" class="px-6 py-4 font-bold text-lg text-center">
                                                            Aucune donnée disponible</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>

                                            {{$realisations->links()}}
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Modal footer -->

                                </div>
                            </div>
                        </div>
                        {{-- suiviIndicateur --}}
        @endforeach
        
      </div>
      {{ $indicateurs->links() }}
    {{-- <div class="flex">
            <span href="#"
                class="bg-transparent border-transparent px-4  py-2 flex text-black text-sm text-center  bg-white items-center">
                <svg class="w-6 h-6 text-first-orange font-bold" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </span>
            <input type="text" wire:model="search" wire:keydown="$refresh" placeholder="Rechercher"
                class="form-input text-sm px-4 py-3 w-max shadow-sm border-white">
        </div>
    <div class="flex mb-5 justify-between px-4">
        
        <div class="grid md:grid-cols-1 md:gap-6 pt-2">
            <div class="mb-4">
                <label for="indicateur" class="block text-gray-700 text-sm font-bold mb-2">Filtre Par Annee
                    Academique</label>
                <select wire:model="selectedClasseAnnee" name="selectedClasseAnnee" wire:change="$refresh"
                    class="border border-gray-300 p-3 w-full max-w-xs focus:border-first-orange enlever_shadow rounded px-8 py-0.75 shadow-first-orange text-sm font-bold">
                    <option value="">Sélectionnez une année academique</option>
                    @foreach($annees as $academiques)
                    <option value="{{ $academiques->id }}">{{ $academiques->annee1 }}-{{ $academiques->annee2 }}</option>
                    @endforeach

                </select>

            </div>
        </div>
    </div>

    <div class="text-sm w-full overflow-x-scroll p-0">
        <table class="w-full border-t mb-3">
            <thead>
                <tr
                    class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold uppercase border-b bg-first-orange">
                    <th class="px-4 py-3">Indicateur </th>
                    <th class="px-4 py-3">Année Académique </th>
                    <th class="px-4 py-3">Description </th>
                    <th class="px-4 py-4">Nom Utilisateur</th>
                    <th class="px-4 py-4">Valeur</th>
                    <th class="px-4 py-4">Observation</th>
                    <th class="px-4 py-4">Date Ajout</th>

                </tr>
            </thead>

            <tbody class="bg-white divide-y ">
                @forelse ($realisations as $realisation)

                <tr class="text-gray-700 ">
                    <td class="px-6 py-3 border-b">
                        {{$realisation->indicateur->typeIndicateur->libelle ?? ' - '}}
                    </td>
                    <td class="px-6 py-3 border-b">
                        {{ $realisation->indicateur->anneeacademique->annee1 }}-{{ $realisation->indicateur->anneeacademique->annee2 }}
                    </td>
                    <td class="px-6 py-3 border-b">
                        {{$realisation->indicateur->typeIndicateur->description ?? ' - '}}
                    </td>
                    <td class="px-6 py-3 border-b">
                        {{$realisation->etablissement->nom??' - ' }}
                    </td>
                    <td class="px-6 py-3 border-b">
                        {{ $realisation->valeurAtteinte ?? '-' }}
                    </td>
                    <td class="px-6 py-3 border-b">
                        {{ $realisation->observation ?? '-' }}
                    </td>
                    <td class="px-6 py-3 border-b">
                        {{ date('d-m-y',strtotime($realisation->created_at)) ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 font-bold text-lg text-center">
                        Aucune donnée disponible</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{$realisations->links()}}
    </div> --}}


</div>
