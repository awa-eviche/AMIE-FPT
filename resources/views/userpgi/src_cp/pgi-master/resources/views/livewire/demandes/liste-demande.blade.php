<div>


    <div class="flex justify-between items-center mb-3 flex-wrap" >
        <div class="flex my-3">
            <p wire:click="resetAll" class="border-2 flex items-center font-bold bg-first-orange rounded py-1 px-3 text-sm cursor-pointer text-white mr-2">Tous</p>
            {{-- <p class="font-bold bg-white rounded py-1 px-3 text-sm cursor-pointer mr-2">Demandes en cours</p> --}}
            <p class="flex items-center font-bold bg-white rounded py-1 px-3 text-sm cursor-pointer border-2 {{ $filterByMyState ? 'border-first-orange text-first-orange' : '' }}" wire:click="toggleFilterByMyState">Me concernant</p>
            <p class="px-3">
                <select wire:change="setStatusDemandeFiltre($event.target.value)" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 text-gray-700 text-sm leading-tight focus:outline-none focus:border-first-orange enlever_shadow font-bold" id="status" name="status" required>
                    <option class="text-sm" value="">Par status</option>
                    <option class="text-sm" value="{{ App\Enums\StatusDemandeEnum::BROUILLON }}">Brouillon</option>
                    <option class="text-sm" value="{{ App\Enums\StatusDemandeEnum::COURS }}">En cours</option>
                    <option class="text-sm" value="{{ App\Enums\StatusDemandeEnum::REJETE }}">Rejeté</option>
                    <option class="text-sm" value="{{ App\Enums\StatusDemandeEnum::ATTENTE }}">A compléter</option>
                    <option class="text-sm" value="{{ App\Enums\StatusDemandeEnum::VALIDE }}">Validé</option>
                </select>

            </p>
            <p>
                <select wire:change="setTypeDemandeFiltreId($event.target.value)" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:border-first-orange enlever_shadow font-bold " id="status" name="status" required>
                    <option class="text-sm" value="0">Type de demande</option>
                    @foreach ($typeDemandes as $typeDemande)
                        <option class="text-sm" value="{{$typeDemande->id}}">{{$typeDemande->libelle}}</option>

                    @endforeach
                </select>

            </p>
            {{-- <h2 class="text-first-orange font-bold">Liste des demandes</h2> --}}
        </div>
        <div class="h-full flex justify-end flex-1 ml-5">
            {{-- <x-md-dropdown>
                <x-slot name="buttonContent">
                    <div class="flex justify-end flex-1 h-full min-w-xs max-w-sm xl:max-w-xl ml-5">
                        <div class="border-2 border-gray-300 py-2 cursor-pointer mr-2 bg-white px-4 text-sm font-bold flex items-center rounded">
                            <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.00033 14.1667V15H2.50033C2.27931 15 2.06735 15.0878 1.91107 15.2441C1.75479 15.4004 1.66699 15.6124 1.66699 15.8334C1.66699 16.0544 1.75479 16.2663 1.91107 16.4226C2.06735 16.5789 2.27931 16.6667 2.50033 16.6667H5.00033V17.5C5.00033 17.7211 5.08812 17.933 5.2444 18.0893C5.40068 18.2456 5.61264 18.3334 5.83366 18.3334C6.05467 18.3334 6.26663 18.2456 6.42291 18.0893C6.57919 17.933 6.66699 17.7211 6.66699 17.5V14.1667C6.66699 13.9457 6.57919 13.7337 6.42291 13.5775C6.26663 13.4212 6.05467 13.3334 5.83366 13.3334C5.61264 13.3334 5.40068 13.4212 5.2444 13.5775C5.08812 13.7337 5.00033 13.9457 5.00033 14.1667ZM8.33366 15.8334C8.33366 16.0544 8.42146 16.2663 8.57774 16.4226C8.73402 16.5789 8.94598 16.6667 9.16699 16.6667H17.5003C17.7213 16.6667 17.9333 16.5789 18.0896 16.4226C18.2459 16.2663 18.3337 16.0544 18.3337 15.8334C18.3337 15.6124 18.2459 15.4004 18.0896 15.2441C17.9333 15.0878 17.7213 15 17.5003 15H9.16699C8.94598 15 8.73402 15.0878 8.57774 15.2441C8.42146 15.4004 8.33366 15.6124 8.33366 15.8334ZM15.0003 10C15.0003 10.2211 15.0881 10.433 15.2444 10.5893C15.4007 10.7456 15.6126 10.8334 15.8337 10.8334H17.5003C17.7213 10.8334 17.9333 10.7456 18.0896 10.5893C18.2459 10.433 18.3337 10.2211 18.3337 10C18.3337 9.77903 18.2459 9.56707 18.0896 9.41079C17.9333 9.25451 17.7213 9.16671 17.5003 9.16671L15.8337 9.16671C15.6126 9.16671 15.4007 9.25451 15.2444 9.41079C15.0881 9.56707 15.0003 9.77903 15.0003 10ZM8.33366 2.50004V3.33337H2.50033C2.27931 3.33337 2.06735 3.42117 1.91107 3.57745C1.75479 3.73373 1.66699 3.94569 1.66699 4.16671C1.66699 4.38772 1.75479 4.59968 1.91107 4.75596C2.06735 4.91224 2.27931 5.00004 2.50033 5.00004H8.33366V5.83337C8.33366 6.05439 8.42146 6.26635 8.57774 6.42263C8.73402 6.57891 8.94598 6.66671 9.16699 6.66671C9.38801 6.66671 9.59997 6.57891 9.75625 6.42263C9.91253 6.26635 10.0003 6.05439 10.0003 5.83337L10.0003 2.50004C10.0003 2.27903 9.91253 2.06706 9.75625 1.91079C9.59997 1.75451 9.38801 1.66671 9.16699 1.66671C8.94598 1.66671 8.73402 1.75451 8.57774 1.91079C8.42146 2.06706 8.33366 2.27903 8.33366 2.50004ZM11.667 4.16671C11.667 4.38772 11.7548 4.59968 11.9111 4.75596C12.0674 4.91224 12.2793 5.00004 12.5003 5.00004L17.5003 5.00004C17.7213 5.00004 17.9333 4.91224 18.0896 4.75596C18.2459 4.59968 18.3337 4.38772 18.3337 4.16671C18.3337 3.94569 18.2459 3.73373 18.0896 3.57745C17.9333 3.42117 17.7213 3.33337 17.5003 3.33337L12.5003 3.33337C12.2793 3.33337 12.0674 3.42117 11.9111 3.57745C11.7548 3.73373 11.667 3.94569 11.667 4.16671ZM11.667 8.33337V9.16671H2.50033C2.27931 9.16671 2.06735 9.25451 1.91107 9.41079C1.75479 9.56707 1.66699 9.77903 1.66699 10C1.66699 10.2211 1.75479 10.433 1.91107 10.5893C2.06735 10.7456 2.27931 10.8334 2.50033 10.8334H11.667V11.6667C11.667 11.8877 11.7548 12.0997 11.9111 12.256C12.0674 12.4122 12.2793 12.5 12.5003 12.5C12.7213 12.5 12.9333 12.4122 13.0896 12.256C13.2459 12.0997 13.3337 11.8877 13.3337 11.6667V8.33337C13.3337 8.11236 13.2459 7.9004 13.0896 7.74412C12.9333 7.58784 12.7213 7.50004 12.5003 7.50004C12.2793 7.50004 12.0674 7.58784 11.9111 7.74412C11.7548 7.9004 11.667 8.11236 11.667 8.33337Z" fill="black"/>
                            </svg>

                            <p class="ml-2">filtre</p>
                        </div>

                    </div>
                </x-slot>

                <x-slot name="dropdownContent">
                    <div class="bg-white w-36 p-3 shadow rounded">
                        <div class="cursor-pointer">
                            hello world
                        </div>
                    </div>
                </x-slot>
            </x-md-dropdown> --}}

            <div class="relative w-full focus-within:text-first-orange shadow">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path  fill-rule="evenodd"  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <form wire:submit.prevent="setSearch">
                    <input wire:model="search" class="border-2 border-gray-300 py-2 w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-white border-0 rounded focus:placeholder-gray-500 enlever_shadow form-input py-1" type="search" placeholder="Rechercher des demandes" aria-label="Search"/>

                </form>
            </div>
        </div>

    </div>

    @if ($demandes->count() > 0)
        <div class="w-full overflow-hidden rounded-lg shadow-xs p-0">
            <div class="text-sm w-full overflow-x-scroll p-0">
                <table class="w-full border-t">
                    <thead>
                        <tr class="text-xs font-black tracking-wide text-left text-maquette-gris uppercase border-b bg-first-orange">
                            <th wire:click="setOrderField('id')" class="cursor-pointer flex items-center px-4 py-4 font-bold">
                                <span class="mr-3">
                                    N°
                                </span>
                                @if ($orderField == "id" && $orderDirection =="ASC")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                        <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                    </svg>

                                @elseif($orderField =="id")
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                    </svg>

                                @endif

                            </th>
                            <th wire:click="setOrderField('libelle')" class="px-2 py-4 font-bold cursor-pointer">
                                <p class="flex items-center">
                                    <span class="mr-3">
                                        Libelle
                                    </span>
                                    @if ($orderField == "libelle" && $orderDirection =="ASC")
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                        </svg>

                                    @elseif($orderField =="libelle")
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                        </svg>

                                    @endif

                                </p>
                            </th>
                            <th wire:click="setOrderField('type_demandes.libelle')" class="px-2 py-4 font-bold cursor-pointer">
                                <p class="flex items-center">
                                    <span class="mr-3">
                                        Type
                                    </span>
                                    @if ($orderField == "type_demandes.libelle" && $orderDirection =="ASC")
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                        </svg>

                                    @elseif($orderField =="type_demandes.libelle")
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                        </svg>

                                    @endif
                                </p>
                            </th>
                            <th wire:click="setOrderField('etablissements.nom')" class="px-2 py-4 font-bold cursor-pointer">
                                <p class="flex items-center">
                                    <span class="mr-3">
                                        Etablissement
                                    </span>
                                    @if ($orderField == "etablissements.nom" && $orderDirection =="ASC")
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                                            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                        </svg>

                                    @elseif($orderField =="etablissements.nom")
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                        </svg>

                                    @endif

                                </p>
                            </th>
                            <th wire:click="setOrderField('etat_workflows.libelle')" class="px-2 py-4 font-bold cursor-pointer">Etat</th>
                            <th class="px-1 text-center py-4 font-bold">Actions</th>
                        </tr>

                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach($demandes as $demande)
                            <tr class="text-gray-700">
                                <td class="px-2 py-3 border-b font-bold">{{ $demande->id ?? " " }}</td>
                                <td class="px-2 py-3 border-b font-bold">{{ $demande->libelle?? "- " }}</td>
                                <td class="px-2 py-3 border-b font-bold">{{ $demande->type_demande_libelle ?? " - " }}</td>
                                <td class="px-2 py-3 border-b font-bold">{{ $demande->nom_etablissement ?? "-" }}</td>
                                <td class="px-2 py-3 border-b font-bold">
                                @if($demande->est_rejete == true )
                                <span class="bg-red-200 py-1 px-2 rounded text-sm text-red-800 font-bold">Rejeté</span>
                                @else
                                    {{-- <!-- {{ $demande->etat->code ?? " - " }} --> --}}
                                    <span class="bg-green-200 py-1 px-2 rounded text-sm text-green-800 font-bold">{{ $demande->etat_libelle?? " - " }}</span>
                                @endif
                                </td>
                                <td class="px-4 py-3 border-b font-bold text-maquette-gris">
                                    <div class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                        <a href="{{ route('demande.show', $demande->id) }}" class="text-maquette-gris">
                                            <svg width="15" height="13" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>

                                        </a>
                                        <a href="{{ route('demande.edit', $demande->id) }}" class="text-purple-600">
                                            <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8 9.5058L5 10.0458L5.5 7.0058L11.23 1.2958C11.323 1.20207 11.4336 1.12768 11.5554 1.07691C11.6773 1.02614 11.808 1 11.94 1C12.072 1 12.2027 1.02614 12.3246 1.07691C12.4464 1.12768 12.557 1.20207 12.65 1.2958L13.71 2.3558C13.8037 2.44876 13.8781 2.55936 13.9289 2.68122C13.9797 2.80308 14.0058 2.93379 14.0058 3.0658C14.0058 3.19781 13.9797 3.32852 13.9289 3.45037C13.8781 3.57223 13.8037 3.68284 13.71 3.7758L8 9.5058Z" stroke="#929EAE" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12.5 10.0059V13.0059C12.5 13.2711 12.3946 13.5254 12.2071 13.713C12.0196 13.9005 11.7652 14.0059 11.5 14.0059H2C1.73478 14.0059 1.48043 13.9005 1.29289 13.713C1.10536 13.5254 1 13.2711 1 13.0059V3.50586C1 3.24064 1.10536 2.98629 1.29289 2.79875C1.48043 2.61122 1.73478 2.50586 2 2.50586H5" stroke="#929EAE" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>

                                        </a>
                                        <form class="text-center" action="{{ route('demande.destroy', $demande->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')
                                            <button title="supprimer" type="submit" class="text-purple-600">
                                                <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20 10.5V11H28V10.5C28 9.43913 27.5786 8.42172 26.8284 7.67157C26.0783 6.92143 25.0609 6.5 24 6.5C22.9391 6.5 21.9217 6.92143 21.1716 7.67157C20.4214 8.42172 20 9.43913 20 10.5ZM17.5 11V10.5C17.5 8.77609 18.1848 7.12279 19.4038 5.90381C20.6228 4.68482 22.2761 4 24 4C25.7239 4 27.3772 4.68482 28.5962 5.90381C29.8152 7.12279 30.5 8.77609 30.5 10.5V11H41.75C42.0815 11 42.3995 11.1317 42.6339 11.3661C42.8683 11.6005 43 11.9185 43 12.25C43 12.5815 42.8683 12.8995 42.6339 13.1339C42.3995 13.3683 42.0815 13.5 41.75 13.5H38.833L36.833 37.356C36.681 39.1676 35.854 40.856 34.5158 42.0866C33.1776 43.3172 31.426 44.0001 29.608 44H18.392C16.5742 43.9998 14.8228 43.3168 13.4848 42.0863C12.1468 40.8557 11.3199 39.1674 11.168 37.356L9.168 13.5H6.25C5.91848 13.5 5.60054 13.3683 5.36612 13.1339C5.1317 12.8995 5 12.5815 5 12.25C5 11.9185 5.1317 11.6005 5.36612 11.3661C5.60054 11.1317 5.91848 11 6.25 11H17.5ZM13.659 37.147C13.7585 38.3338 14.3003 39.4399 15.1769 40.2462C16.0535 41.0524 17.201 41.4999 18.392 41.5H29.608C30.7992 41.5002 31.9469 41.0528 32.8237 40.2465C33.7005 39.4403 34.2424 38.334 34.342 37.147L36.324 13.5H11.676L13.659 37.147ZM21.5 20.25C21.5 20.0858 21.4677 19.9233 21.4049 19.7716C21.342 19.62 21.25 19.4822 21.1339 19.3661C21.0178 19.25 20.88 19.158 20.7284 19.0951C20.5767 19.0323 20.4142 19 20.25 19C20.0858 19 19.9233 19.0323 19.7716 19.0951C19.62 19.158 19.4822 19.25 19.3661 19.3661C19.25 19.4822 19.158 19.62 19.0951 19.7716C19.0323 19.9233 19 20.0858 19 20.25V34.75C19 34.9142 19.0323 35.0767 19.0951 35.2284C19.158 35.38 19.25 35.5178 19.3661 35.6339C19.4822 35.75 19.62 35.842 19.7716 35.9049C19.9233 35.9677 20.0858 36 20.25 36C20.4142 36 20.5767 35.9677 20.7284 35.9049C20.88 35.842 21.0178 35.75 21.1339 35.6339C21.25 35.5178 21.342 35.38 21.4049 35.2284C21.4677 35.0767 21.5 34.9142 21.5 34.75V20.25ZM27.75 19C28.44 19 29 19.56 29 20.25V34.75C29 35.0815 28.8683 35.3995 28.6339 35.6339C28.3995 35.8683 28.0815 36 27.75 36C27.4185 36 27.1005 35.8683 26.8661 35.6339C26.6317 35.3995 26.5 35.0815 26.5 34.75V20.25C26.5 19.56 27.06 19 27.75 19Z" fill="#FF0000"/>
                                                </svg>

                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$demandes->links()}}
            </div>
        </div>

    @else
        <p class="text-first-orange text-center text-lg font-bold py-4 bg-white">Il n'y a aucune demande </p>
    @endif

</div>
