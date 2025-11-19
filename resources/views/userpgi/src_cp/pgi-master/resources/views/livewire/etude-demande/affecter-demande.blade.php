<div>
    {{-- le bouton --}}
    <div class="flex justify-end">
        <button wire:click = "toggleAffecting" {{ $disabled ? 'disabled' : '' }} class="flex items-center bg-green-800 hover:bg-green-900 hover:shadow-xl py-2 px-4 rounded text-white font-bold ">
            <span class="mr-2">
                Affecter la demande
            </span>
            <svg height="20" viewBox="0 0 512 512" style="fill : white">
                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
            </svg>
        </button>
    </div>
    {{-- la liste --}}
    {{-- <x-modal wire:model="affecting" > --}}
    <x-modal wire:model="affecting" :maxWidth="'7xl'">
        <div class="flex justify-between mt-5 px-4">
            <p class="font-bold text-first-orange">Veuillez selectionner un instructeur pour l'affectation</p>
            <div class="relative w-96 focus-within:text-first-orange shadow">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="gray" viewBox="0 0 20 20">
                        <path  fill-rule="evenodd"  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <form wire:submit.prevent="setSearch">
                    <input wire:model="search" class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-white border-1 rounded focus:placeholder-gray-500 focus:bg-white focus:border-first-orange focus:outline-none focus:shadow-outline-first-orange form-input py-1" type="search" placeholder="Rechercher des demandes" aria-label="Search"/>

                </form>
            </div>
        </div>
        <div class="p-3 mx-auto shadow mt-4" style="min-height : 80vh">
                <div class="rounded-lg shadow-xs p-0">
                    <div class="text-sm w-full overflow-x-scroll p-0">
                        <table class="w-full border-t">
                            <thead>
                                <tr class="text-xs font-black tracking-wide text-left text-maquette-gris uppercase border-b bg-first-orange">
                                    <th class="px-4 py-4 font-bold"></th>
                                    <th class="px-4 py-4 font-bold">N° </th>
                                    <th class="px-1 text-center py-4 font-bold">Nom</th>
                                    <th class="px-1 text-center py-4 font-bold">Prenom</th>
                                    <th class="px-1 text-center py-4 font-bold">email</th>
                                    <th class="px-1 text-center py-4 font-bold">date naissance</th>
                                    <th class="px-1 text-center py-4 font-bold">telephone</th>
                                    <th class="px-1 text-center py-4 font-bold">Type</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @foreach($instructeurs as $instructeur)
                                    <tr class="text-gray-700">
                                        <td class="px-3 mx-auto py-3 border-b font-bold">
                                            <input type="radio" name="selectionedAgentId" value="{{$instructeur->userable_id}}" id="{{$instructeur->userable_id}}" wire:model="selectionedAgentId">
                                        </td>
                                        <td class="px-3 mx-auto py-3 border-b font-bold">{{ $instructeur->id ?? " " }}</td>
                                        <td class="text-center px-1 py-3 border-b font-bold text-maquette-gris">{{ $instructeur->prenom?? "- " }}</td>
                                        <td class="text-center px-1 py-3 border-b font-bold">{{ $instructeur->nom ?? " - " }}</td>
                                        <td class="text-center px-1 py-3 border-b font-bold text-maquette-gris">{{ $instructeur->email ?? "-" }}</td>
                                        <td class="text-center px-1 py-3 border-b font-bold">{{ $instructeur->date_naissance ?? " - " }}</td>
                                        <td class="text-center px-1 py-3 border-b font-bold">{{ $instructeur->telephone ?? " - " }}</td>
                                        <td class="text-center px-1 py-3 border-b font-bold">{{ $instructeur->role_name ?? " - " }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{$instructeurs->links()}}
                    </div>
                </div>

                <div class="flex justify-between mt-4">
                    <button  wire:click="toggleAffecting" class="cursor-pointer bg-red-800 hover:shadow-xl hover:bg-red-900 py-2 rounded px-3 text-center text-white">
                        fermer
                    </button>
                    <div class="flex">
                        <button  wire:click="affecter" class="mr-3 flex items-center cursor-pointer bg-green-800 hover:bg-green-900 hover:shadow-xl py-2 rounded px-3 text-center text-white">
                            <span class="mr-3">
                                Affecter
                            </span>
                            <svg height="20" viewBox="0 0 512 512" style="fill : white">
                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                            </svg>
                        </button>
                        @if (!$etat->code == "recep_sign_valid")
                            <button  wire:click="toggleGivingInstruction" class="cursor-pointer bg-first-orange hover:bg-blue-900 hover:shadow-xl py-2 rounded px-3 text-center text-white">
                                Mettre les instructions
                            </button>
                        @endif

                    </div>
                </div>
                @if ($givingInstruction)
                    <div class="mt-4 shadowr">
                        <label for="contentMessage" wire:model="contentMessage" class="block mb-2 text-sm font-medium text-gray-900">Vos instructions</label>
                        <textarea id="contentMessage" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border-2 border-gray-700 focus:first-orange focus:border-first-orange" placeholder="Ecrire les instructions ici"></textarea>
                    </div>
                @endif
        </div>
    </x-modal>

</div>
