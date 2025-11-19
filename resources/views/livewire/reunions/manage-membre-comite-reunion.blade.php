<div class="overflow-hidden sm:rounded-lg mt-0">
    <h3 class="text-md font-bold mb-0 text-black p-1">Les membre qui ont participié à la réunion</h3>
    <div class="mt-4">
        @if ($membresReunion->count() > 0)
            <div class="relative overflow-scroll shadow-md sm:rounded-lg">
                <table class="w-full bg-white text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr class="text-white">
                            <th scope="col" class="px-3 py-3 bg-first-orange">
                                N°
                            </th>
                            <th scope="col" class="px-3 py-3 bg-first-orange text-center">
                                prénom-nom
                            </th>
                            <th scope="col" class="px-3 py-3 bg-first-orange text-center">
                                email
                            </th>

                            <th scope="col" class="px-3 py-3 bg-first-orange text-center">
                                interne
                            </th>
                            <th scope="col" class="px-3 py-3 bg-first-orange">

                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($membresReunion as $membreComite)
                            <tr class="border-b border-gray-200 ">
                                <td
                                    class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                    {{ $membreComite->id }}
                                </td>
                                <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                    <p class="text-center">
                                        {{ $membreComite->prenom }}
                                    </p>
                                    <p class="text-center">
                                        {{ $membreComite->nom }}
                                    </p>
                                </td>
                                <td
                                    class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                    {{ $membreComite->email }}
                                </td>
                                <td class="px-3 py-3 text-center">
                                    @if ($membreComite->userable_type == "App\\Models\\Agent")
                                        <span
                                            class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded ">
                                            Interne
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded ">
                                            Externe
                                        </span>
                                    @endif

                                </td>

                                <td class="px-1 py-2">
                                    <div class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                        <a href="#" class="text-maquette-gris">
                                            <svg width="15" height="13" viewBox="0 0 18 15" fill="none">
                                                <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>

                                        </a>
                                        @if ($autoriser)
                                            <a wire:click="retirerMembre({{$membreComite->id}})" class="cursor-pointer text-maquette-gris ml-5">
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
            <p class="text-center text-first-orange mt-4">Vous n'avez pas encore renseigner les membres qui ont participer à la réunion.</p>
        @endif
    </div>




    <div class="mt-4">
        @if ($autoriser)
            <div class="flex justify-end">
                <button wire:click="addSelectedMembers" class="bg-first-orange py-1 text-white text-bold rounded my-3 hover:shadow-xl px-3">Ajouter</button>
            </div>
            @if ($otherMembres->count() > 0)

                <div class="relative overflow-scroll shadow-md sm:rounded-lg">
                    <table class="w-full bg-white text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr class="text-white">
                                @if ($isModifying)
                                    <th scope="col" class="px-2 py-3 bg-first-orange"></th>

                                @endif
                                <th scope="col" class="px-3 py-3 bg-first-orange">
                                    N°
                                </th>
                                <th scope="col" class="px-3 py-3 bg-first-orange text-center">
                                    prénom-nom
                                </th>
                                <th scope="col" class="px-3 py-3 bg-first-orange text-center">
                                    email
                                </th>

                                <th scope="col" class="px-3 py-3 bg-first-orange text-center">
                                    interne
                                </th>
                                <th scope="col" class="px-3 py-3 bg-first-orange">

                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($otherMembres as $membreComite)
                            <tr class="border-b border-gray-200 ">
                                    @if ($isModifying)
                                        <td class="px-3 py-2">
                                            <input type="checkbox" wire:model="selection" value="{{$membreComite->id}}">
                                        </td>
                                    @endif
                                    <td
                                        class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                        {{ $membreComite->id }}
                                    </td>
                                    <td class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                        <p class="text-center">
                                            {{ $membreComite->prenom }}
                                        </p>
                                        <p class="text-center">
                                            {{ $membreComite->nom }}
                                        </p>
                                    </td>
                                    <td
                                        class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                        {{ $membreComite->email }}
                                    </td>
                                    <td class="px-3 py-3 text-center">
                                        @if ($membreComite->userable_type == "App\\Models\\Agent")
                                            <span
                                                class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded ">
                                                Interne
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded ">
                                                Externe
                                            </span>
                                        @endif

                                    </td>

                                    <td class="px-1 py-2">
                                        <div class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                            <a href="#" class="text-maquette-gris">
                                                <svg width="15" height="13" viewBox="0 0 18 15" fill="none">
                                                    <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                <p class="text-center">Il ne reste aucune autre membres de comité !.</p>
            @endif
        @endif



    </div>
</div>
