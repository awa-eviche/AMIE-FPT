<div class="w-full">
    {{-- les attaché --}}
    <div class="mb-3">
        <h3 class="text-first-orange font-bold ml-3 text-lg">Les demandes de la réunion</h3>
        <div class="mt-4 w-full p-2 text-center mb-5">
            @if ($demandesOfThisReunion->count() > 0)

                <div class="relative overflow-scroll shadow-md sm:rounded-lg">
                    <table class="w-full bg-white text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr class="text-white bg-first-orange">
                                <th class="px-2 py-4 font-bold">N° </th>
                                <th class="px-2 py-4 font-bold text-center">Date dépôt</th>
                                <th class="px-2 py-4 font-bold text-center">Type</th>
                                <th class="px-2 py-4 font-bold text-center">Entreprise</th>
                                <th class="px-2 py-4 font-bold text-center">Etat</th>
                                <th class="px-3 py-3 bg-first-orange">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($demandesOfThisReunion as $demande)
                                <tr class="border-b border-gray-200 ">
                                    <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50">
                                        {{ $demande->id ?? " -" }}
                                    </td>
                                    <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 text-center">
                                        {{date('d-m-Y',strtotime($demande->date_depot) ?? " ")}}
                                    </td>
                                    <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 text-center">
                                        {{ $demande->type_demande_libelle ?? " -" }}
                                    </td>
                                    <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 text-center">
                                        {{ $demande->nom_entreprise ?? " -" }}
                                    </td>
                                    <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 text-center">
                                        <span class="bg-gray-200 py-2 px-3 rounded">
                                            {{ $demande->etat_libelle }}

                                        </span>
                                    </td>


                                    <td class="px-1 py-2 w-24">
                                        <div class="flex justify-center rounded items-center text-sm shadow-xl p-1 bg-gray-200">
                                            <a href="{{route('demande.show', $demande->id)}}" class="text-maquette-gris">
                                                <svg width="20" height="17" viewBox="0 0 18 15" fill="none">
                                                    <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>

                                            </a>
                                            @if ($autoriser)
                                                <a wire:click="detacher({{$demande->id}})" class="cursor-pointer text-maquette-gris ml-5">
                                                    <svg height="17" viewBox="0 0 448 512">
                                                        <path d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-first-orange font-bold">Pas de membre de comité pour l'instant dans le système.</p>
            @endif

        </div>

    </div>
    {{-- les nons attaché --}}
    @if ($reunion->etat == App\Enums\ReunionEtatEnum::PREPARATION )
        <div class="">
            <h3 class="mt-10 text-first-orange font-bold ml-3 text-lg">
                Les autres demandes
            </h3>
            <div class="mt-4 w-full p-2 text-center">
                @if ($unSelectedDemande->count() > 0)
                <div class="flex justify-between mb-3">
                        <h3 class="text-first-orange font-bold ml-3 text-lg">Les autres</h3>
                        <button wire:click = "attacher" class="flex items-center bg-first-orange py-1 px-3 text-sm hover:bg-cyan-700 text-white font-bold rounded">
                            @if ($modifying)
                                <span class="mr-2">Valider</span>
                            @else
                                <span class="mr-2">Ajouter</span>
                            @endif

                            @if ($modifying)
                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.6979 6.55208L12.4479 0.302083C12.3519 0.208384 12.2387 0.134107 12.1146 0.0833333C11.9854 0.030851 11.8477 0.00260216 11.7083 0H3.375C2.5462 0 1.75134 0.32924 1.16529 0.915291C0.57924 1.50134 0.25 2.2962 0.25 3.125V15.625C0.25 16.4538 0.57924 17.2487 1.16529 17.8347C1.75134 18.4208 2.5462 18.75 3.375 18.75H15.875C16.7038 18.75 17.4987 18.4208 18.0847 17.8347C18.6708 17.2487 19 16.4538 19 15.625V7.29167C19.0008 7.15458 18.9745 7.01868 18.9227 6.89176C18.8708 6.76485 18.7945 6.64942 18.6979 6.55208ZM6.5 2.08333H10.6667V4.16667H6.5V2.08333ZM12.75 16.6667H6.5V13.5417C6.5 13.2654 6.60975 13.0004 6.8051 12.8051C7.00045 12.6097 7.2654 12.5 7.54167 12.5H11.7083C11.9846 12.5 12.2496 12.6097 12.4449 12.8051C12.6403 13.0004 12.75 13.2654 12.75 13.5417V16.6667ZM16.9167 15.625C16.9167 15.9013 16.8069 16.1662 16.6116 16.3616C16.4162 16.5569 16.1513 16.6667 15.875 16.6667H14.8333V13.5417C14.8333 12.7129 14.5041 11.918 13.918 11.332C13.332 10.7459 12.5371 10.4167 11.7083 10.4167H7.54167C6.71286 10.4167 5.91801 10.7459 5.33196 11.332C4.74591 11.918 4.41667 12.7129 4.41667 13.5417V16.6667H3.375C3.09873 16.6667 2.83378 16.5569 2.63843 16.3616C2.44308 16.1662 2.33333 15.9013 2.33333 15.625V3.125C2.33333 2.84873 2.44308 2.58378 2.63843 2.38843C2.83378 2.19308 3.09873 2.08333 3.375 2.08333H4.41667V5.20833C4.41667 5.4846 4.52641 5.74955 4.72176 5.9449C4.91711 6.14025 5.18207 6.25 5.45833 6.25H11.7083C11.9846 6.25 12.2496 6.14025 12.4449 5.9449C12.6403 5.74955 12.75 5.4846 12.75 5.20833V3.55208L16.9167 7.71875V15.625Z" fill="white"/>
                                </svg>
                            @else
                                <svg style="fill: white" height="19" height="19" viewBox="0 0 448 512">
                                    <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                                </svg>
                            @endif
                        </button>
                    </div>

                    <div class="relative overflow-scroll shadow-md sm:rounded-lg">
                        <table class="w-full bg-white text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase">
                                <tr class="text-white bg-first-orange">
                                    @if ($modifying)
                                        <th class="px-3 py-3 bg-first-orange"> </th>

                                    @endif
                                    <th class="px-2 py-4 font-bold">N° </th>
                                    <th class="px-2 py-4 font-bold text-center">Date dépôt</th>
                                    <th class="px-2 py-4 font-bold text-center">Type</th>
                                    <th class="px-2 py-4 font-bold text-center">Entreprise</th>
                                    <th class="px-2 py-4 font-bold text-center">Etat</th>
                                    <th class="px-3 py-3 bg-first-orange">

                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($unSelectedDemande as $demande)
                                    <tr class="border-b border-gray-200 ">
                                        @if ($modifying)
                                            <td class="px-3 py-2">
                                                <input type="checkbox" wire:model="selection" value="{{$demande->id}}">
                                            </td>
                                        @endif
                                        <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50">
                                            {{ $demande->id ?? " -" }}
                                        </td>
                                        <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 text-center">
                                            {{ $demande->date_depot ?? " -" }}
                                        </td>
                                        <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 text-center">
                                            {{ $demande->type_demande_libelle ?? " -" }}
                                        </td>
                                        <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 text-center">
                                            {{ $demande->nom_entreprise ?? " -" }}
                                        </td>
                                        <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 text-center">
                                            <span class="bg-gray-200 py-2 px-3 rounded">
                                                {{ $demande->etat_libelle }}

                                            </span>
                                        </td>



                                        <td class="px-1 py-2 w-24">
                                            <div class="flex justify-center rounded items-center space-x-2 text-sm shadow p-2 bg-gray-200">
                                                <a href="{{route('demande.show', $demande->id)}}">
                                                    <svg width="20" height="17" viewBox="0 0 18 15" fill="none">
                                                        <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-first-orange">Pas de demande pour l'instant dans le système.</p>
                @endif

            </div>




        </div>

    @endif
</div>
