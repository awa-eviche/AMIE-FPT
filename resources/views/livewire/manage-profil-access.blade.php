<div class="w-full">
    <h3 class="text-xl font-semibold mb-4">Liste des profils ayant accès à cet état</h3>
    <div class="bg-white shadow p-6 rounded-lg">
        <div class="flex justify-end mb-3">
            <button wire:click = "addProfil" class="flex items-center bg-first-orange py-1 px-3 text-sm hover:bg-cyan-700 text-white font-bold rounded">
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

        @if($allRoles->count() > 0)

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>

                            @if ($modifying)
                                <th></th>

                            @endif
                            <th scope="col" class="px-3 py-3">
                                Code
                            </th>
                            <th scope="col" class="px-3 py-3 bg-gray-50">
                                nom
                            </th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allRoles as $profil)
                            @php
                                $profilHasAccess = $roles->contains('id', $profil->id);
                            @endphp
                            @if ($modifying || $profilHasAccess)
                                <tr class="border-b border-gray-200 ">
                                    @if ($modifying)
                                        <td class="px-3 py-2">
                                            <input type="checkbox" wire:model="selection" value="{{$profil->id}}">
                                        </td>

                                    @endif
                                    <td class="px-3 py-2 font-medium whitespace-nowrap bg-gray-50">
                                        {{ $profil->name }}
                                    </td>
                                    <td class="px-3 py-2">
                                        {{ $profil->code }}
                                    </td>

                                    <td class="px-3 py-2">
                                        <div class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                            <a href="#" class="text-maquette-gris">
                                                <svg width="15" height="13" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>

                                            </a>
                                        </div>
                                    </td>


                                </tr>

                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>Aucun profil n'est autorisé à avoir accès à cet etat.</p>
        @endif

    </div>

</div>

