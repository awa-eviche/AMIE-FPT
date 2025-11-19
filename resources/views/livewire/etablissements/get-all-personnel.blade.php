<div>

    {{-- modal --}}
        


   
    <div class="flex justify-between items-center mb-3 flex-wrap" >
        <div class="flex my-3">
            <p wire:click="resetAll" class="border-2 flex items-center font-bold bg-first-orange rounded py-1 px-3 text-sm cursor-pointer text-white mr-2">Tous</p>
            {{-- <p class="font-bold bg-white rounded py-1 px-3 text-sm cursor-pointer mr-2">Demandes en cours</p> --}}
            <p class="px-3">
                <select wire:change="filterFunction($event.target.value)" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 text-gray-700 text-sm leading-tight focus:outline-none focus:border-first-orange enlever_shadow font-bold" id="status" name="status" required>
                    <option class="text-sm" value="">Par status</option>
                    @foreach ($fonctions as $fonction)
                    <option class="text-sm" value="{{ $fonction->fonction }}">{{ $fonction->fonction }}</option>
                    @endforeach
                </select>

            </p>
            <p>
                {{-- <select wire:change="setTypeDemandeFiltreId($event.target.value)" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 text-sm leading-tight focus:outline-none focus:border-first-orange enlever_shadow font-bold " id="status" name="status" required>
                    <option class="text-sm" value="0">Type de demande</option>
                    @foreach ($typeDemandes as $typeDemande)
                        <option class="text-sm" value="{{$typeDemande->id}}">{{$typeDemande->libelle}}</option>

                    @endforeach
                </select> --}}

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

            <div class="relative w-1/4 focus-within:text-first-orange shadow">
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

    @if ($users->count() > 0)
        <div class="w-full overflow-hidden rounded-lg shadow-xs p-0">
            <div class="text-sm w-full overflow-x-scroll p-0">
                <table class="w-full border-t mb-3">
                    <thead>
                        <tr class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold uppercase border-b bg-first-orange">
                            <th class="px-4 py-3">Nom </th>
                            <th class="px-4 py-4">Prenom</th>
                            <th class="px-4 py-4">Email</th>
                            <th class="px-4 py-4">Téléphone</th>
                            <th class="px-4 py-4">Fonction</th>
                            <th class="px-4 py-4">Adresse</th>
                            <th class="px-4 py-4">Date Naissance</th>
                            <th class="px-4 py-4 w-[60px]">Lieu Naissance</th>
                        </tr>
                    </thead>
    
                    <tbody class="bg-white divide-y ">
                        @forelse ($users as $user)
                        
                            <tr class="text-gray-700 ">
                                <td class="px-6 py-3 border-b">{{ $user->nom ?? ' - ' }}</td>
                                <td class="px-6 py-3 border-b">{{ $user->prenom ?? '-' }}</td>
                                <td class="px-6 py-3 border-b">{{ $user->email ?? '-' }}</td>
                                <td class="px-6 py-3 border-b">{{ $user->telephone ?? '-' }}</td>
                                <td class="px-6 py-3 border-b">{{ $user->personnel->fonction ?? '-' }}</td>
                                <td class="px-6 py-3 border-b">{{ $user->adresse ?? '-' }}</td>
                                <td class="px-6 py-3 border-b">{{ $user->date_naissance ?? '-' }}</td>
                                <td class="px-6 py-3 border-b">{{ $user->lieu_naissance ?? '-' }}</td>
    
                               
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-4 font-bold text-lg text-center">Aucune donnée disponible</td></tr>
                        @endforelse
                    </tbody>
                </table>

                {{$users->links()}}
            </div>
        </div>

    @else
        <p class="text-first-orange text-center text-lg font-bold py-4 bg-white">Il n'y a aucune demande </p>
    @endif

</div>
