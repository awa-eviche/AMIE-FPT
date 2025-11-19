<div class="w-full md:w-1/2 p-4">
    <div class="shadow">
        <div class="flex items-center justify-between bg-gray-200 p-1 mt-2">
            <p class="text-first-orange font-bold">Profils qui reçoivent ce type de notfication</p>
        </div>
        <div class="bg-white p-6 rounded">
            <div class="flex justify-end mb-3">
                <button wire:click = "addRole" class="bg-first-orange py-0.5 text-sm hover:bg-cyan-700 px-3 text-white font-bold rounded">
                    {{$modifying ? "valider" : "ajouter un profil" }}
                </button>
            </div>

            @if($allRoles->count() > 0)

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase ">
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
                                    <tr class="border-b border-gray-200">
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
                                                <a href="{{route("profil.show", $profil->id)}}" class="text-maquette-gris">
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
                <p>Aucun profil ne reçoit cette notification pour l'instant.</p>
            @endif

        </div>

    </div>

</div>
