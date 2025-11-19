<div class="bg-transparent">

    <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm pl-4">
        <p>
            <a href="/dashboard" class="text-maquette-gris">Accueil</a>
            <span class="mx-2 text-maquette-gris">/</span>
        </p>
        <p> <a href="{{route('indicateur.index')}}">Indicateurs </a>

            <span class="mx-2 text-maquette-gris">/</span>
        </p>
        <p class="text-first-orange">Liste</p>
        <p></p>
    </div>
    <div class="flex mb-5 justify-between pl-4">
        <div class="flex">
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
        <div class="flex">
            <a href="#"
                class="mx-2 px-5 rounded-md py-0 flex text-black text-xs font-bold text-center shadow-md bg-white items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g id="uil:sliders-v">
                        <path id="Vector"
                            d="M5.00033 14.1667V15H2.50033C2.27931 15 2.06735 15.0878 1.91107 15.2441C1.75479 15.4004 1.66699 15.6124 1.66699 15.8334C1.66699 16.0544 1.75479 16.2663 1.91107 16.4226C2.06735 16.5789 2.27931 16.6667 2.50033 16.6667H5.00033V17.5C5.00033 17.7211 5.08812 17.933 5.2444 18.0893C5.40068 18.2456 5.61264 18.3334 5.83366 18.3334C6.05467 18.3334 6.26663 18.2456 6.42291 18.0893C6.57919 17.933 6.66699 17.7211 6.66699 17.5V14.1667C6.66699 13.9457 6.57919 13.7337 6.42291 13.5775C6.26663 13.4212 6.05467 13.3334 5.83366 13.3334C5.61264 13.3334 5.40068 13.4212 5.2444 13.5775C5.08812 13.7337 5.00033 13.9457 5.00033 14.1667ZM8.33366 15.8334C8.33366 16.0544 8.42146 16.2663 8.57774 16.4226C8.73402 16.5789 8.94598 16.6667 9.16699 16.6667H17.5003C17.7213 16.6667 17.9333 16.5789 18.0896 16.4226C18.2459 16.2663 18.3337 16.0544 18.3337 15.8334C18.3337 15.6124 18.2459 15.4004 18.0896 15.2441C17.9333 15.0878 17.7213 15 17.5003 15H9.16699C8.94598 15 8.73402 15.0878 8.57774 15.2441C8.42146 15.4004 8.33366 15.6124 8.33366 15.8334ZM15.0003 10C15.0003 10.2211 15.0881 10.433 15.2444 10.5893C15.4007 10.7456 15.6126 10.8334 15.8337 10.8334H17.5003C17.7213 10.8334 17.9333 10.7456 18.0896 10.5893C18.2459 10.433 18.3337 10.2211 18.3337 10C18.3337 9.77903 18.2459 9.56707 18.0896 9.41079C17.9333 9.25451 17.7213 9.16671 17.5003 9.16671L15.8337 9.16671C15.6126 9.16671 15.4007 9.25451 15.2444 9.41079C15.0881 9.56707 15.0003 9.77903 15.0003 10ZM8.33366 2.50004V3.33337H2.50033C2.27931 3.33337 2.06735 3.42117 1.91107 3.57745C1.75479 3.73373 1.66699 3.94569 1.66699 4.16671C1.66699 4.38772 1.75479 4.59968 1.91107 4.75596C2.06735 4.91224 2.27931 5.00004 2.50033 5.00004H8.33366V5.83337C8.33366 6.05439 8.42146 6.26635 8.57774 6.42263C8.73402 6.57891 8.94598 6.66671 9.16699 6.66671C9.38801 6.66671 9.59997 6.57891 9.75625 6.42263C9.91253 6.26635 10.0003 6.05439 10.0003 5.83337L10.0003 2.50004C10.0003 2.27903 9.91253 2.06706 9.75625 1.91079C9.59997 1.75451 9.38801 1.66671 9.16699 1.66671C8.94598 1.66671 8.73402 1.75451 8.57774 1.91079C8.42146 2.06706 8.33366 2.27903 8.33366 2.50004ZM11.667 4.16671C11.667 4.38772 11.7548 4.59968 11.9111 4.75596C12.0674 4.91224 12.2793 5.00004 12.5003 5.00004L17.5003 5.00004C17.7213 5.00004 17.9333 4.91224 18.0896 4.75596C18.2459 4.59968 18.3337 4.38772 18.3337 4.16671C18.3337 3.94569 18.2459 3.73373 18.0896 3.57745C17.9333 3.42117 17.7213 3.33337 17.5003 3.33337L12.5003 3.33337C12.2793 3.33337 12.0674 3.42117 11.9111 3.57745C11.7548 3.73373 11.667 3.94569 11.667 4.16671ZM11.667 8.33337V9.16671H2.50033C2.27931 9.16671 2.06735 9.25451 1.91107 9.41079C1.75479 9.56707 1.66699 9.77903 1.66699 10C1.66699 10.2211 1.75479 10.433 1.91107 10.5893C2.06735 10.7456 2.27931 10.8334 2.50033 10.8334H11.667V11.6667C11.667 11.8877 11.7548 12.0997 11.9111 12.256C12.0674 12.4122 12.2793 12.5 12.5003 12.5C12.7213 12.5 12.9333 12.4122 13.0896 12.256C13.2459 12.0997 13.3337 11.8877 13.3337 11.6667V8.33337C13.3337 8.11236 13.2459 7.9004 13.0896 7.74412C12.9333 7.58784 12.7213 7.50004 12.5003 7.50004C12.2793 7.50004 12.0674 7.58784 11.9111 7.74412C11.7548 7.9004 11.667 8.11236 11.667 8.33337Z"
                            fill="black" />
                    </g>
                </svg>
                <span class="mx-2">Filtres</span>
            </a>
            {{-- <a href="#" data-modal-target="realisation-modal" data-modal-toggle="realisation-modal"
                class="px-3 rounded-md py-3 flex text-white text-sm text-center bg-first-orange mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                        <path id="Vector"
                            d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z"
                            fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_705_6988">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg><span class="mx-2">Liste des réalisations</span>
            </a> --}}

            @if (auth()->user()->hasRole(config('constants.roles.superadmin')))
            <a href="#" data-modal-target="indicateur-modal" data-modal-toggle="indicateur-modal"
                class="px-3 rounded-md py-3 flex text-white text-sm text-center bg-first-orange">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <g id="ic-receipt-24px 1" clip-path="url(#clip0_705_6988)">
                        <path id="Vector"
                            d="M15 14.1666H5V12.5H15V14.1666ZM15 10.8333H5V9.16663H15V10.8333ZM15 7.49996H5V5.83329H15V7.49996ZM2.5 18.3333L3.75 17.0833L5 18.3333L6.25 17.0833L7.5 18.3333L8.75 17.0833L10 18.3333L11.25 17.0833L12.5 18.3333L13.75 17.0833L15 18.3333L16.25 17.0833L17.5 18.3333V1.66663L16.25 2.91663L15 1.66663L13.75 2.91663L12.5 1.66663L11.25 2.91663L10 1.66663L8.75 2.91663L7.5 1.66663L6.25 2.91663L5 1.66663L3.75 2.91663L2.5 1.66663V18.3333Z"
                            fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_705_6988">
                            <rect width="20" height="20" fill="white" />
                        </clipPath>
                    </defs>
                </svg><span class="mx-2">Ajouter un indicateur</span>
            </a>
            @endif


        </div>
        <!-- Main modal -->
        <div id="indicateur-modal" tabindex="-1" aria-hidden="true"
            class="bg-black bg-opacity-25 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="indicateur-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        @livewire('indicateur.create-indicateur')
                    </div>

                </div>
            </div>
        </div>
        <div id="realisation-modal" tabindex="-1" aria-hidden="true"
            class=" bg-black bg-opacity-25 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center md:inset-0 h-[calc(100%-1rem)] w-50 h-50 mx-auto max-w-full max-h-full ">
            <div class="relative w-full max-w-6xl max-h-full mx-8">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Enregister réalisation
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="realisation-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <div class="p-4 md:p-5 space-y-4">
                        @livewire('suiviindicateur.liste_suiviindicateur')
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="realisattion-modal" type="button"
                            class=" flex self-end py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="flex mb-5 justify-between px-4">
        <div class="grid md:grid-cols-1 md:gap-6 pt-2">
            <div class="mb-4">
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
    </div>


    <div class="w-full bg-transparent rounded-lg shadow-xs p-0 flex flex-wrap items-center">

        @forelse ($indicateurs as $indicateur)
        <div class="sm:w-1/3 w-full p-4">
            <div class="rounded-lg shadow-md p-4 bg-white2">
                <div class="flex justify-between items-center">
                    <h1 class="font-bold text-lg">
                        <i class="fa-solid fa-building-circle-check" style="color:green;"></i>
                         {{
                        $indicateur->label ?? ' - ' }}
                    </h1>
                    <a wire:click="getRealisation('{{ $indicateur->id }}','{{ $indicateur->typeIndicateur->libelle }}')" href="#"
                        data-modal-target="show-suiviindicateur-modal'{{ $indicateur->id }}'"
                        data-modal-toggle="show-suiviindicateur-modal'{{ $indicateur->id }}'">
                        <i class="fa fa-eye" aria-hidden="true" style="color:green;"></i>
                    </a>

                </div>

                <hr class="my-2" />
                <div class="flex mb-4 items-center">
                    <div class="px-4 flex-1">

                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-location"></i>&nbsp;Type indicateur :
                            <span class="font-bold">{{ $indicateur->typeIndicateur->libelle?? ' - ' }}</span>
                        </h3>
                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-location"></i>&nbsp;Année academique :
                            <span class="font-bold">{{ $indicateur->anneeacademique->annee1 }}-{{ $indicateur->anneeacademique->annee2 }}</span>
                        </h3>

                        {{-- <h3 class="text-sm py-1"><i class="text-green-600 fa fa-check"></i> &nbsp; cible : <span
                                class="font-bold">{{$indicateur->cible ?? ' - ' }}</span>
                        </h3> --}}

                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-check"></i> &nbsp; Date réalisation:
                            <span class="font-bold">{{ date('d-m-y', strtotime($indicateur->created_at)) }}</span>
                        </h3>
                        <h3 class="text-sm py-1"><i class="text-green-600 fa fa-check"></i> &nbsp; Date échéance:
                            <span class="font-bold">{{$indicateur->date_echeance? date('d-m-y', strtotime($indicateur->date_echeance)) : ' - '}}</span>
                        </h3>
                    </div>
                    <div clas s="px-4 flex items-end">

                    </div>
                </div>
                <hr>
                <div class="mt-4">
                    {{--<p class="text-center">{{$etablissement->slogan }}</p> --}}
                    <div class="flex justify-between items-center mt-3">
                        @if (auth()->user()->hasRole(config('constants.roles.superadmin')))
                        <a href="#" data-modal-target="suiviindicateur-edit-modal'{{ $indicateur->id }}'"
                            data-modal-toggle="suiviindicateur-edit-modal'{{ $indicateur->id }}'"
                            class=" items-center justify-center px-1 rounded-md py-1 border flex text-orange-600 text-sm text-center bg-white border-orange-600 hover:bg-orange-600 hover:text-white">
                            <i class="fa fa-edit"></i>
                            <span class="mx-2"></span>
                        </a>
                        @endif



                        @if ((auth()->user()->personnel && auth()->user()->personnel->etablissement_id) && (\Carbon\Carbon::now()->lte($indicateur->date_echeance) ))
                                <a data-modal-target="suiviindicateur-modal'{{ $indicateur->id }}'"
                                    data-modal-toggle="suiviindicateur-modal'{{ $indicateur->id }}'"
                                    class=" items-center px-1 rounded-md py-1 border flex text-green-600 text-sm text-center bg-white border-green-600 hover:bg-green-600 hover:text-white">
                                    <i class="fa fa-plus"></i>
                                    <span class="mx-2">Enregistrer réalisation</span>
                                </a>
                        
                        @endif

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
                                    {{-- <div class="p-4 md:p-5 space-y-4">
                                        @forelse ($realisations as $realisation)
                                        <div class="rounded-lg w-1/3 shadow-md p-2 bg-white2">
                                            <div class="flex justify-between items-center">
                                                <h1 class="font-bold text-lg">
                                                    <i class="fa-solid fa-building-circle-check"
                                                        style="color:green;"></i> {{
                                                    $realisation->indicateur->typeIndicateur->libelle ?? ' - ' }}
                                                </h1>


                                            </div>

                                            <hr class="my-2" />
                                            <div class="flex mb-4 items-center">
                                                <div class="px-4 flex-1">
                                                    <h3 class="text-sm py-1"><i class="fa fa-school text-green-600"></i>
                                                        {{ $realisation->etablissement->nom }}</h3>
                                                    <h3 class="text-sm py-1"><i
                                                            class="text-green-600 fa fa-location"></i>&nbsp;cible : {{
                                                        $realisation->indicateur->cible }} <span
                                                            class="font-bold"></span></h3>

                                                    <h3 class="text-sm py-1"><i class="text-green-600 fa fa-check"></i>
                                                        &nbsp;Valeur Atteinte :{{ $realisation->valeurAtteinte }} <span
                                                            class="font-bold"></span></h3>

                                                    <h3 class="text-sm py-1"><i class="text-green-600 fa fa-check"></i>
                                                        &nbsp; Date Ajout: <span class="font-bold">{{ date('d-M-y',
                                                            strtotime($realisation->created_at)) }}</span></h3>
                                                </div>
                                                <div clas s="px-4 flex items-end">

                                                </div>
                                            </div>
                                        </div>
                                        @empty

                                        @endforelse

                                        {{ $realisations->links() }}

                                    </div> --}}
                                    @endif

                                    <!-- Modal footer -->

                                </div>
                            </div>
                        </div>
                        {{-- suiviIndicateur --}}
                        {{-- edit indicateur --}}


                        <!-- Main modal -->
                        <div id="suiviindicateur-edit-modal'{{ $indicateur->id }}'" tabindex="-1" aria-hidden="true"
                            class="bg-black bg-opacity-25 hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class=" flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="suiviindicateur-edit-modal'{{ $indicateur->id }}'">
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
                                    <div class="p-4 md:p-5 space-y-4">
                                        <form class="bg-white pt-6 pb-8 mb-4"
                                            action="{{ route('indicateur.update',$indicateur->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="border border-gray-200">
                                                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                                    Modification d'un nouveau indicateur

                                                </h3>
                                                <div class="p-5">


                                                    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                                        <div class="mb-4">
                                                            <label for="typeindicateur"
                                                                class="block text-gray-700 text-sm font-bold mb-2">Type
                                                                d'indicateur</label>
                                                            <select id="typeindicateur_id"
                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                id="typeindicateur_id" name="typeIndicateur_id" required
                                                                id="typeindicateur_id">
                                                                <option value="">Sélectionnez un type indicateur
                                                                </option>
                                                                @foreach($typeIndicateurs as $type)
                                                                <option value="{{ $type->id }}" @selected($indicateur->
                                                                    typeIndicateur->id == $type->id)>{{ $type->libelle}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            @error('libelle')
                                                            {{ $message }}
                                                            @enderror
                                                        </div>



                                                        <div class="mb-4">
                                                            <label for="libelle"
                                                                class="block text-gray-700 text-sm font-bold mb-2">Année
                                                                academique</label>
                                                            <select id="annee_academiques_id"
                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                id="annee_academiques_id" name="anneeAcademique_id"
                                                                required id="annee_academiques_id">
                                                                <option value="">Sélectionnez une année academique
                                                                </option>
                                                                @foreach($annees as $academiques)
                                                                <option value="{{ $academiques->id }}"
                                                                    @selected($indicateur->anneeacademique->id ==
                                                                    $academiques->id )>{{ $academiques->annee1 }}-{{ $academiques->annee2 }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('annee_academiques_id ')
                                                            {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="grid md:grid-cols-2 md:gap-6 pt-2">


                                                        <div class="mb-4 flex items-center">
                                                            <input {{ $indicateur->public==1?"checked":"" }} id="checked-checkbox" name="public" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                            <label for="checked-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Visible au niveau du dashbord</label>
                                                        </div>
                                                        {{-- <div class="mb-4">
                                                            <label class="block text-gray-700 text-sm font-bold"
                                                                for="cible">
                                                                Cible
                                                            </label>
                                                            <input value="{{ $indicateur->cible}}"
                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                id="cible" name="cible" required>

                                                            @error('cible')
                                                            {{ $message }}
                                                            @enderror
                                                        </div> --}}







                                                    </div>

                                                </div>
                                                <div class="w-full sm:px-2 lg:px-4 py-4">

                                                    <button type="submit"
                                                        class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Modifier</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal footer -->

                                </div>
                            </div>
                        </div>

                        {{-- edit indicateur --}}
                        <div id="suiviindicateur-modal'{{ $indicateur->id }}'" tabindex="-1" aria-hidden="true"
                            class=" bg-black bg-opacity-25 hidden  fixed top-0 right-0 left-0 z-50 justify-center items-center  md:inset-0 h-[calc(100%-1rem)] w-50 h-50 mx-auto max-w-full max-h-full">
                            <div class="relative p-4 w-full max-w-6xl max-h-full mx-8">


                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Enregister réalisation
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-hide="suiviindicateur-modal'{{ $indicateur->id }}'">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>

                                    <div class="p-4 md:p-5 space-y-4">


                                        <div class="bg-transparent shadow rounded-sm w-full p-4 ">

                                            <div class="w-full mx-8">

                                                <form class="bg-white pt-6 pb-8 mb-4"
                                                    action="{{ route('suiviIndicateur.store') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="md:container md:mx-auto">

                                                        <div class="w-full sm:px-2 lg:px-4 ">

                                                            <div class="border border-gray-200">
                                                                <h3
                                                                    class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                                                    Creation d'un nouveau réalisation

                                                                </h3>
                                                                <div class="p-5">


                                                                    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                                                        <input type="hidden" value="{{$indicateur->id}}"
                                                                            name="indicateur_id">
                                                                        @if (auth()->user()->personnel)
                                                                        <input type="hidden"
                                                                            value="{{auth()->user()->personnel->etablissement_id}}"
                                                                            name="etablissement_id">
                                                                        @endif

                                                                            <div class="mb-4">
                                                                                <label
                                                                                    class="block text-gray-700 text-sm font-bold"
                                                                                    for="cible">
                                                                                    Code
                                                                                </label>
                                                                                <input
                                                                                    class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                                    value="{{$indicateur->typeIndicateur->code}}"
                                                                                    disabled>

                                                                                @error('valide')
                                                                                {{ $message }}
                                                                                @enderror
                                                                            </div>

                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-gray-700 text-sm font-bold"
                                                                                for="cible">
                                                                                Libellé
                                                                            </label>
                                                                            <input
                                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                                value="{{$indicateur->typeindicateur->libelle}} "
                                                                                disabled>

                                                                            @error('libelle')
                                                                            {{ $message }}
                                                                            @enderror
                                                                        </div>
                                                                        
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-gray-700 text-sm font-bold"
                                                                                for="code">
                                                                                Année Académique
                                                                            </label>
                                                                            <input
                                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                                id="code"
                                                                                value="{{$indicateur->anneeacademique->code}}"
                                                                                required disabled>

                                                                            @error('code')
                                                                            {{ $message }}
                                                                            @enderror
                                                                        </div>

                                                                    </div>

                                                                    <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                                                        {{-- <div class="mb-4">
                                                                            <label
                                                                                class="block text-gray-700 text-sm font-bold"
                                                                                for="cible">
                                                                                Date de réalisation
                                                                            </label>
                                                                            <input Type="date"
                                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                                id="dateMaj" name="dateMaj" required>

                                                                            @error('dateMaj')
                                                                            {{ $message }}
                                                                            @enderror
                                                                        </div> --}}

                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="block text-gray-700 text-sm font-bold"
                                                                                for="cible">
                                                                                Valeur atteinte
                                                                            </label>
                                                                            <input type="number"
                                                                                class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                                id="valeurAtteinte"
                                                                                name="valeurAtteinte" required>

                                                                            @error('valeurAtteinte')
                                                                            {{ $message }}
                                                                            @enderror
                                                                        </div>
                                                                    </div>


                                                                    <div class="mb-4">
                                                                        <label
                                                                            class="block text-gray-700 text-sm font-bold"
                                                                            for="cible">
                                                                            Observation
                                                                        </label>

                                                                        <textarea
                                                                            class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm"
                                                                            id="observation" name="observation" required
                                                                            cols="30" rows="2"></textarea>
                                                                        @error('observation')
                                                                        {{ $message }}
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="w-full sm:px-2 lg:px-4 py-4">

                                                        <button type="submit"
                                                            class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>

                                                    </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div
                                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                    <button data-modal-hide="suiviindicateur-modal'{{ $indicateur->id }}'" type="button"
                                        class=" flex self-end py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Fermer</button>
                                </div>
                            </div>
                        </div>



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
    {{ $indicateurs->links() }}

</div>