<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex justify-between items-center">
            <span class="text-black text-sm">Liste des entreprises / <span class="text-orange-600"> Entreprise
                    {{ $entreprise->ninea }}</span></span>
            <a href="{{ route('entreprise.create') }}"
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
                </svg><span class="mx-2">Ajouter une entreprise</span>
            </a>
        </div>
    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="flex md:w-full lg:w-1/2 gap-y-4 pr-4 flex-col">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">
                <div class="flex justify-between text-black items-center">
                    <span class="text-first-orange font-bold text-md">Informations de l'entreprise</span>
                    <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1"
                        href="{{ route('entreprise.edit', $entreprise->id) }}">
                        Modifier
                    </a>
                </div>
                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <span>Nom de l'entreprise : </span>
                    <span>
                        {{ $entreprise->nom_entreprise ?? ' - ' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 text-sm">
                    <span>Email : </span>
                    <span>
                        {{ $entreprise->email_entreprise ?? ' -' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 mb-2 text-sm">
                    <span>Ninéa : </span>
                    <span>
                        {{ $entreprise->ninea ?? ' - ' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 mb-2 text-sm">
                    <span>Effectif : </span>
                    <span>
                        {{ $entreprise->effectif ?? ' - ' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 mb-2 text-sm">
                    <span>Date de création : </span>
                    <span>
                        {{ date('d/m/Y', strtotime($entreprise->date_creation)) ?? ' - ' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 mb-2 text-sm">
                    <span>Actif : </span>
                    @if ($entreprise->est_actif)
                        <span
                            class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded ">
                            Oui
                        </span>
                    @else
                        <span
                            class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded ">
                            Non
                        </span>
                    @endif
                </div>
            </div>
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white mt-3">
                <div class="flex justify-between text-black items-center">
                    <span class="text-first-orange font-bold text-md">Informations du promoteur</span>
                    <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1"
                        href="{{ route('entreprise.edit', $entreprise->id) }}">
                        Modifier
                    </a>
                </div>
                <div class="flex justify-between text-black items-center mt-3 text-sm">
                    <span>Nom : </span>
                    <span>
                        {{ $entreprise->user->nom ?? ' - ' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 text-sm">
                    <span>Prénoms : </span>
                    <span>
                        {{ $entreprise->user->prenom ?? ' -' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 mb-2 text-sm">
                    <span>Email : </span>
                    <span>
                        {{ $entreprise->user->email ?? ' - ' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 mb-2 text-sm">
                    <span>Téléphone : </span>
                    <span>
                        {{ $entreprise->user->telephone ?? ' - ' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 mb-2 text-sm">
                    <span>Adresse : </span>
                    <span>
                        {{ $entreprise->user->adresse ?? ' - ' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 mb-2 text-sm">
                    <span>Date de naissance : </span>
                    <span>
                        {{ date('d/m/Y', strtotime($entreprise->user->date_naissance)) ?? ' - ' }}
                    </span>
                </div>
                <div class="flex justify-between text-black items-center mt-1 mb-2 text-sm">
                    <span>Lieu de naissance : </span>
                    <span>
                        {{ $entreprise->user->lieu_naissance ?? ' - ' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex  w-1/2 gap-y-4 pr-4 flex-col">
            <div class="rounded-lg shadow-sm px-8 bg-white">
                <div class="flex justify-center text-white items-center text-center">
                    <div class="border-r border-s-gray-100 py-5">
                        <span class="text-first-orange px-4 py-1 text-6xl font-bold">
                            {{ $entreprise->projets->count() ?? 0 }}
                        </span>
                        <p class="text-center text-black px-4">Projets</p>
                    </div>
                    <div class="border-l border-s-gray-100 py-5">
                        <span class="text-first-orange px-4 py-1 text-6xl font-bold">
                            {{ $entreprise->demandes->count() ?? 0 }}
                        </span>
                        <p class="text-center text-black px-4">Demandes en cours</p>
                    </div>
                </div>
            </div>

            {{-- projets  --}}
            <div class="overflow-hidden shadow-xl sm:rounded-lg mt-0">
                <h3 class="text-md font-bold mb-0 text-black p-1">Projets de l'entreprise</h3>
                <div class="">
                    @if ($entreprise->projets->count() > 0)

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full bg-white text-sm text-left text-gray-500 ">
                                <thead class="text-xs text-gray-700 uppercase ">
                                    <tr class="text-white">
                                        <th scope="col" class="px-3 py-3 bg-first-orange">
                                            Type agrément
                                        </th>
                                        <th scope="col" class="px-3 py-3 bg-first-orange">
                                            Statut
                                        </th>
                                        <th scope="col" class="px-3 py-3 bg-first-orange">
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entreprise->projets as $projet)
                                        <tr class="border-b border-gray-200 ">
                                            <td
                                                class="px-3 py-3 font-medium whitespace-nowrap bg-gray-50 ">
                                                {{ $projet->type_agrement }}
                                            </td>
                                            <td class="px-3 py-3">
                                                @if ($projet->est_agree)
                                                    <span
                                                        class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded ">
                                                        Oui
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded ">
                                                        Non agréé
                                                    </span>
                                                @endif

                                            </td>

                                            <td class="px-2 py-3">
                                                <div
                                                    class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5">
                                                    <a href="#"
                                                        class="text-black font-bold flex py-1 items-center">
                                                        Voir&nbsp;
                                                        <svg width="18" height="14" viewBox="0 0 18 14"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="Vector">
                                                                <path
                                                                    d="M1.57129 7C1.57129 7 4.37648 1 9.28557 1C14.1947 1 16.9999 7 16.9999 7C16.9999 7 14.1947 13 9.28557 13C4.37648 13 1.57129 7 1.57129 7Z"
                                                                    stroke="#1B212D" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M9.28557 8.71429C10.2323 8.71429 10.9999 7.94677 10.9999 7C10.9999 6.05323 10.2323 5.28571 9.28557 5.28571C8.3388 5.28571 7.57129 6.05323 7.57129 7C7.57129 7.94677 8.3388 8.71429 9.28557 8.71429Z"
                                                                    stroke="#1B212D" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </g>
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
                        <p class="text-center">Aucun projet trouvé pour cette entreprise.</p>
                    @endif

                </div>


            {{-- demandes --}}
            <div class="overflow-hidden sm:rounded-lg mt-0">
                <h3 class="text-md font-bold mb-0 text-black p-1">Demandes de l'entreprise</h3>
                <div class="">
                    @if ($entreprise->demandes->count() > 0)

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full bg-white text-sm text-left text-gray-500 ">
                                <thead class="text-xs text-gray-700 uppercase ">
                                    <tr class="text-white">
                                        <th scope="col" class="px-3 py-3 bg-first-orange">
                                            Libelle
                                        </th>
                                        <th scope="col" class="px-3 py-3 bg-first-orange">
                                            Date dépôt
                                        </th>
                                        <th scope="col" class="px-3 py-3 bg-first-orange">
                                            Type demande
                                        </th>
                                        <th scope="col" class="px-3 py-3 bg-first-orange">
                                            Actions
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entreprise->demandes as $demande)
                                        <tr class="border-b border-gray-200 ">
                                            <td
                                                class="px-3 py-2 font-medium whitespace-nowrap bg-gray-50">
                                                {{ $demande->libelle }}
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $demande->date_depot }}

                                            </td>

                                            <td class="px-3 py-2">
                                                {{ $demande->typeDemande->code ?? ' - ' }}

                                            </td>

                                            <td class="px-2 py-2">
                                                <div
                                                    class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                                    <a href="{{ route('demande.show', $demande->id) }}"
                                                        class="text-black font-bold flex py-1 items-center">
                                                        Voir&nbsp;
                                                        <svg width="18" height="14" viewBox="0 0 18 14"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="Vector">
                                                                <path
                                                                    d="M1.57129 7C1.57129 7 4.37648 1 9.28557 1C14.1947 1 16.9999 7 16.9999 7C16.9999 7 14.1947 13 9.28557 13C4.37648 13 1.57129 7 1.57129 7Z"
                                                                    stroke="#1B212D" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M9.28557 8.71429C10.2323 8.71429 10.9999 7.94677 10.9999 7C10.9999 6.05323 10.2323 5.28571 9.28557 5.28571C8.3388 5.28571 7.57129 6.05323 7.57129 7C7.57129 7.94677 8.3388 8.71429 9.28557 8.71429Z"
                                                                    stroke="#1B212D" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </g>
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
                        <p class="text-center">Aucun projet trouvé pour cette entreprise.</p>
                    @endif

                </div>


        </div>
    </div>

</div>
