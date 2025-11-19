<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Flux de traitement') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
        <div class="w-full mx-auto">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="max-full mx-auto">
                    <div class="overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="flex justify-between items-center">
                            <p class="font-bold py-2 m-4 text-first-orange text-xl">Flux de traitement de la demande</p>

                            <div class="flex justify-end m-4 bg-first-orange hover:bg-cyan-700 text-white font-bold py-2 px-4 rounded items-center">
                                <a href="{{ route('workflow.create') }}" class="mr-2 text-sm">
                                    Nouveau flux de traitement
                                </a>
                                <svg height="1em" viewBox="0 0 448 512" style="fill: white">
                                    <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                                </svg>
                            </div>

                        </div>


                        <div class="w-full overflow-hidden rounded-lg shadow-xs p-0">
                            <div class="w-full overflow-x-scroll p-0">
                                <table class="w-full border-t">
                                    <thead>
                                        <tr class="text-xs font-black tracking-wide text-left text-maquette-gris uppercase border-b bg-first-orange">
                                            <th class="px-4 py-4">Code</th>
                                            <th class="px-4 py-4">Libellé</th>
                                            <th class="px-4 py-4">Description</th>
                                            <th class="px-4 py-4">Type demande</th>
                                            <th class="px-4 py-4">Status</th>
                                            <th class="px-4 py-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y">
                                        @foreach($workflows as $workflow)
                                            <tr class="text-gray-700 ">
                                                <td class="px-4 py-3 border-b">{{ $workflow->code }}</td>
                                                <td class="px-4 py-3 border-b">{{ $workflow->libelle }}</td>
                                                <td class="px-4 py-3 border-b">{{ $workflow->description }}</td>
                                                <td class="px-4 py-3 border-b">{{ $workflow->typeDemande->libelle }}</td>
                                                <td class="px-4 py-3 border-b">
                                                    @if($workflow->estActif)
                                                        <span class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded">
                                                            Actif
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded">
                                                            Inactif
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="px-4 py-3 border-b">
                                                    <div class="flex justify-center rounded items-center space-x-2 text-sm shadow-xl p-0.5 bg-gray-100">
                                                        <a href="{{ route('workflow.show', $workflow->id) }}" class="text-maquette-gris">
                                                            <svg width="15" height="13" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1.57141 7.5C1.57141 7.5 4.37661 1.5 9.2857 1.5C14.1948 1.5 17 7.5 17 7.5C17 7.5 14.1948 13.5 9.2857 13.5C4.37661 13.5 1.57141 7.5 1.57141 7.5Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M9.2857 9.21429C10.2325 9.21429 11 8.44677 11 7.5C11 6.55323 10.2325 5.78571 9.2857 5.78571C8.33892 5.78571 7.57141 6.55323 7.57141 7.5C7.57141 8.44677 8.33892 9.21429 9.2857 9.21429Z" stroke="#929EAE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>

                                                        </a>
                                                        <a href="{{ route('workflow.edit', $workflow->id) }}" class="text-purple-600">
                                                            <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M8 9.5058L5 10.0458L5.5 7.0058L11.23 1.2958C11.323 1.20207 11.4336 1.12768 11.5554 1.07691C11.6773 1.02614 11.808 1 11.94 1C12.072 1 12.2027 1.02614 12.3246 1.07691C12.4464 1.12768 12.557 1.20207 12.65 1.2958L13.71 2.3558C13.8037 2.44876 13.8781 2.55936 13.9289 2.68122C13.9797 2.80308 14.0058 2.93379 14.0058 3.0658C14.0058 3.19781 13.9797 3.32852 13.9289 3.45037C13.8781 3.57223 13.8037 3.68284 13.71 3.7758L8 9.5058Z" stroke="#929EAE" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M12.5 10.0059V13.0059C12.5 13.2711 12.3946 13.5254 12.2071 13.713C12.0196 13.9005 11.7652 14.0059 11.5 14.0059H2C1.73478 14.0059 1.48043 13.9005 1.29289 13.713C1.10536 13.5254 1 13.2711 1 13.0059V3.50586C1 3.24064 1.10536 2.98629 1.29289 2.79875C1.48043 2.61122 1.73478 2.50586 2 2.50586H5" stroke="#929EAE" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>

                                                        </a>
                                                        <form class="text-center" action="{{ route('workflow.destroy', $workflow->id) }}" method="POST">

                                                            @csrf
                                                            @method('DELETE')
                                                            <button title="supprimer" type="submit" class="text-purple-600">
                                                                <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M20 10.5V11H28V10.5C28 9.43913 27.5786 8.42172 26.8284 7.67157C26.0783 6.92143 25.0609 6.5 24 6.5C22.9391 6.5 21.9217 6.92143 21.1716 7.67157C20.4214 8.42172 20 9.43913 20 10.5ZM17.5 11V10.5C17.5 8.77609 18.1848 7.12279 19.4038 5.90381C20.6228 4.68482 22.2761 4 24 4C25.7239 4 27.3772 4.68482 28.5962 5.90381C29.8152 7.12279 30.5 8.77609 30.5 10.5V11H41.75C42.0815 11 42.3995 11.1317 42.6339 11.3661C42.8683 11.6005 43 11.9185 43 12.25C43 12.5815 42.8683 12.8995 42.6339 13.1339C42.3995 13.3683 42.0815 13.5 41.75 13.5H38.833L36.833 37.356C36.681 39.1676 35.854 40.856 34.5158 42.0866C33.1776 43.3172 31.426 44.0001 29.608 44H18.392C16.5742 43.9998 14.8228 43.3168 13.4848 42.0863C12.1468 40.8557 11.3199 39.1674 11.168 37.356L9.168 13.5H6.25C5.91848 13.5 5.60054 13.3683 5.36612 13.1339C5.1317 12.8995 5 12.5815 5 12.25C5 11.9185 5.1317 11.6005 5.36612 11.3661C5.60054 11.1317 5.91848 11 6.25 11H17.5ZM13.659 37.147C13.7585 38.3338 14.3003 39.4399 15.1769 40.2462C16.0535 41.0524 17.201 41.4999 18.392 41.5H29.608C30.7992 41.5002 31.9469 41.0528 32.8237 40.2465C33.7005 39.4403 34.2424 38.334 34.342 37.147L36.324 13.5H11.676L13.659 37.147ZM21.5 20.25C21.5 20.0858 21.4677 19.9233 21.4049 19.7716C21.342 19.62 21.25 19.4822 21.1339 19.3661C21.0178 19.25 20.88 19.158 20.7284 19.0951C20.5767 19.0323 20.4142 19 20.25 19C20.0858 19 19.9233 19.0323 19.7716 19.0951C19.62 19.158 19.4822 19.25 19.3661 19.3661C19.25 19.4822 19.158 19.62 19.0951 19.7716C19.0323 19.9233 19 20.0858 19 20.25V34.75C19 34.9142 19.0323 35.0767 19.0951 35.2284C19.158 35.38 19.25 35.5178 19.3661 35.6339C19.4822 35.75 19.62 35.842 19.7716 35.9049C19.9233 35.9677 20.0858 36 20.25 36C20.4142 36 20.5767 35.9677 20.7284 35.9049C20.88 35.842 21.0178 35.75 21.1339 35.6339C21.25 35.5178 21.342 35.38 21.4049 35.2284C21.4677 35.0767 21.5 34.9142 21.5 34.75V20.25ZM27.75 19C28.44 19 29 19.56 29 20.25V34.75C29 35.0815 28.8683 35.3995 28.6339 35.6339C28.3995 35.8683 28.0815 36 27.75 36C27.4185 36 27.1005 35.8683 26.8661 35.6339C26.6317 35.3995 26.5 35.0815 26.5 34.75V20.25C26.5 19.56 27.06 19 27.75 19Z" fill="#FF0000"/>
                                                                </svg>


                                                            </button>
                                                            {{-- <button title="supprimer" type="submit" class="btn p-1"><i class="bi bi-trash3" style="font-size: 14px; color: red; border: none; outline: none;"></i></button> --}}
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
