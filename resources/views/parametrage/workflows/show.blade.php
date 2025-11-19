<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail workflow') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold">
        <p>
            <a href="{{route("workflow.index")}}"  class="text-maquette">Liste des workflows</a>
        </p>
        <span class="mx-2 text-maquette">/</span>
        <p class="text-first-orange">Détail workflow</p>
    </div>

    {{--  --}}
    <div class="mt-5 pb-12 pt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 bg-white shadow-xl w-full rounded-sm max-h-screen">
        <div class="max-w-7xl sm:px-2 lg:px-2" >
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <div class="flex font-semibold mb-4 bg-gray-200 p-1 text-first-orange justify-between">
                    <h3 class="text-xl" >Détails du Workflow</h3>
                    <div class="flex items-center text-sm">
                        <a href="{{ route('workflow.edit', $workflow->id) }}" class="flex items-center bg-first-orange text-white rounded px-3 py-1 hover:bg-cyan-700">

                            <span class="mr-2">Modifier</span>
                            <svg width="12" height="16" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.09868 0.23645C4.37895 0.23645 3.76665 0.73733 3.53973 1.43645H1.79266C0.879723 1.43645 0.139648 2.24233 0.139648 3.23645V17.6365C0.139648 18.6305 0.879723 19.4365 1.79266 19.4365H4.55096C4.55899 19.2995 4.57862 19.1606 4.6108 19.0203L4.79077 18.2365H1.79266C1.48835 18.2365 1.24166 17.9678 1.24166 17.6365V3.23645C1.24166 2.90508 1.48835 2.63645 1.79266 2.63645H3.53973C3.76665 3.33557 4.37895 3.83645 5.09868 3.83645H8.4047C9.12442 3.83645 9.7367 3.33557 9.9636 2.63645H11.7107C12.015 2.63645 12.2617 2.90508 12.2617 3.23645V8.91447C12.6137 8.75022 12.9875 8.65875 13.3637 8.64005V3.23645C13.3637 2.24233 12.6236 1.43645 11.7107 1.43645H9.9636C9.7367 0.73733 9.12442 0.23645 8.4047 0.23645H5.09868ZM4.54768 2.03645C4.54768 1.70508 4.79437 1.43645 5.09868 1.43645H8.4047C8.70897 1.43645 8.9557 1.70508 8.9557 2.03645C8.9557 2.36782 8.70897 2.63645 8.4047 2.63645H5.09868C4.79437 2.63645 4.54768 2.36782 4.54768 2.03645ZM6.72937 16.2891L12.0515 10.4938C12.8563 9.61734 14.1613 9.61734 14.9661 10.4938C15.7708 11.3702 15.7708 12.7911 14.9661 13.6676L9.64402 19.4629C9.33369 19.8008 8.94491 20.0404 8.5192 20.1563L6.8685 20.6057C6.15061 20.8011 5.50037 20.0931 5.67985 19.3114L6.09251 17.5139C6.19895 17.0504 6.41908 16.627 6.72937 16.2891Z" fill="white"/>
                            </svg>

                        </a>
                    </div>

                </div>
                <div class="p-3">

                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Code :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-gray-700">{{ $workflow->code }}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Libellé :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-gray-700">{{ $workflow->libelle }}</span>
                        </div>
                    </div>

                    <hr>


                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Type demande :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-gray-700">{{ $workflow->typeDemande->libelle }}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="mt-4 mb-2 flex">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Status :</strong>
                        </div>
                        <div class="w-2/3">
                            @if($workflow->est_actif)
                                <span class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded">
                                    ACTIF
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded">
                                    INACTIF
                                </span>
                            @endif

                        </div>
                    </div>

                    <hr>
                    <div class="mt-4 mb-2">
                        <strong class="text-black font-bold">
                            Description
                        </strong>
                        <p class="shadow border p-2 text-maquette rounded-sm mb-2 h-32 min-h-full">
                            {{ $workflow->description }}
                        </p>

                    </div>



                </div>
            </div>
        </div>

        {{-- les etats --}}
        <div class="max-w-7xl sm:px-2 lg:px-2 max-h-screen overflow-x-auto">
            <div class="bg-white shadow-xl sm:rounded-lg max-h-full pb-10 overflow-y-auto">
                <h3 class="text-xl font-bold mb-4 text-first-orange bg-gray-200 p-1">États du Workflow</h3>
                <div class="p-3">
                    <div class="flex justify-end mb-3">
                        <a href="{{ route('etat_workflow.create', $workflow->id) }}" class="flex items-center bg-first-orange py-1 text-sm hover:bg-cyan-700 px-3 text-white font-bold rounded">
                            <span class="mr-2">Nouvel état</span>
                            <svg style="fill: white" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                            </svg>
                        </a>
                    </div>

                    @if($workflow->etatWorkflows->count() > 0)

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase">
                                    <tr>
                                        <th scope="col" class="px-3 py-3 bg-gray-50">
                                            N°
                                        </th>
                                        <th scope="col" class="px-3 py-3">
                                            Code
                                        </th>
                                        <th scope="col" class="px-3 py-3 bg-gray-50">
                                            Libellé
                                        </th>
                                        <th scope="col" class="px-3 py-3">
                                            Suivant
                                        </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workflow->etatWorkflows as $etat)
                                        <tr class="border-b border-gray-200">
                                            <td class="px-3 py-2 font-medium whitespace-nowrap bg-gray-50">
                                                {{ $etat->position }}
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $etat->code }}
                                            </td>
                                            <td class="px-3 py-2 bg-gray-50">
                                                {{ $etat->libelle }}
                                            </td>
                                            <td class="px-3 py-2">
                                                {{ $etat->etat_suivant_id ? $etat->etatSuivant->libelle : '-' }}
                                            </td>
                                            <td class="px-3 py-2">
                                                <div class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                                    <a href="{{ route('etat_workflow.show', $etat->id) }}" class="text-maquette-gris">
                                                        <svg width="15" height="13" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>

                                                    </a>
                                                    <a href="{{ route('etat_workflow.edit', $etat->id) }}" class="text-purple-600">
                                                        <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M8 9.5058L5 10.0458L5.5 7.0058L11.23 1.2958C11.323 1.20207 11.4336 1.12768 11.5554 1.07691C11.6773 1.02614 11.808 1 11.94 1C12.072 1 12.2027 1.02614 12.3246 1.07691C12.4464 1.12768 12.557 1.20207 12.65 1.2958L13.71 2.3558C13.8037 2.44876 13.8781 2.55936 13.9289 2.68122C13.9797 2.80308 14.0058 2.93379 14.0058 3.0658C14.0058 3.19781 13.9797 3.32852 13.9289 3.45037C13.8781 3.57223 13.8037 3.68284 13.71 3.7758L8 9.5058Z" stroke="#929EAE" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M12.5 10.0059V13.0059C12.5 13.2711 12.3946 13.5254 12.2071 13.713C12.0196 13.9005 11.7652 14.0059 11.5 14.0059H2C1.73478 14.0059 1.48043 13.9005 1.29289 13.713C1.10536 13.5254 1 13.2711 1 13.0059V3.50586C1 3.24064 1.10536 2.98629 1.29289 2.79875C1.48043 2.61122 1.73478 2.50586 2 2.50586H5" stroke="#929EAE" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>

                                                    </a>
                                                    {{-- <form class="text-center" action="{{ route('etatWorkflow.destroy', $etat->id) }}" method="POST">

                                                        @csrf
                                                        @method('DELETE')
                                                        <button title="supprimer" type="submit" class="text-purple-600">
                                                            <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M20 10.5V11H28V10.5C28 9.43913 27.5786 8.42172 26.8284 7.67157C26.0783 6.92143 25.0609 6.5 24 6.5C22.9391 6.5 21.9217 6.92143 21.1716 7.67157C20.4214 8.42172 20 9.43913 20 10.5ZM17.5 11V10.5C17.5 8.77609 18.1848 7.12279 19.4038 5.90381C20.6228 4.68482 22.2761 4 24 4C25.7239 4 27.3772 4.68482 28.5962 5.90381C29.8152 7.12279 30.5 8.77609 30.5 10.5V11H41.75C42.0815 11 42.3995 11.1317 42.6339 11.3661C42.8683 11.6005 43 11.9185 43 12.25C43 12.5815 42.8683 12.8995 42.6339 13.1339C42.3995 13.3683 42.0815 13.5 41.75 13.5H38.833L36.833 37.356C36.681 39.1676 35.854 40.856 34.5158 42.0866C33.1776 43.3172 31.426 44.0001 29.608 44H18.392C16.5742 43.9998 14.8228 43.3168 13.4848 42.0863C12.1468 40.8557 11.3199 39.1674 11.168 37.356L9.168 13.5H6.25C5.91848 13.5 5.60054 13.3683 5.36612 13.1339C5.1317 12.8995 5 12.5815 5 12.25C5 11.9185 5.1317 11.6005 5.36612 11.3661C5.60054 11.1317 5.91848 11 6.25 11H17.5ZM13.659 37.147C13.7585 38.3338 14.3003 39.4399 15.1769 40.2462C16.0535 41.0524 17.201 41.4999 18.392 41.5H29.608C30.7992 41.5002 31.9469 41.0528 32.8237 40.2465C33.7005 39.4403 34.2424 38.334 34.342 37.147L36.324 13.5H11.676L13.659 37.147ZM21.5 20.25C21.5 20.0858 21.4677 19.9233 21.4049 19.7716C21.342 19.62 21.25 19.4822 21.1339 19.3661C21.0178 19.25 20.88 19.158 20.7284 19.0951C20.5767 19.0323 20.4142 19 20.25 19C20.0858 19 19.9233 19.0323 19.7716 19.0951C19.62 19.158 19.4822 19.25 19.3661 19.3661C19.25 19.4822 19.158 19.62 19.0951 19.7716C19.0323 19.9233 19 20.0858 19 20.25V34.75C19 34.9142 19.0323 35.0767 19.0951 35.2284C19.158 35.38 19.25 35.5178 19.3661 35.6339C19.4822 35.75 19.62 35.842 19.7716 35.9049C19.9233 35.9677 20.0858 36 20.25 36C20.4142 36 20.5767 35.9677 20.7284 35.9049C20.88 35.842 21.0178 35.75 21.1339 35.6339C21.25 35.5178 21.342 35.38 21.4049 35.2284C21.4677 35.0767 21.5 34.9142 21.5 34.75V20.25ZM27.75 19C28.44 19 29 19.56 29 20.25V34.75C29 35.0815 28.8683 35.3995 28.6339 35.6339C28.3995 35.8683 28.0815 36 27.75 36C27.4185 36 27.1005 35.8683 26.8661 35.6339C26.6317 35.3995 26.5 35.0815 26.5 34.75V20.25C26.5 19.56 27.06 19 27.75 19Z" fill="#FF0000"/>
                                                            </svg>


                                                        </button>
                                                    </form> --}}
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else
                        <p class="text-center">Aucun état trouvé pour ce workflow.</p>
                    @endif

                </div>

            </div>
        </div>

    </div>




</x-app-layout>
