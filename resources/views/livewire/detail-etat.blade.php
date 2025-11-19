<div class="w-full md:w-1/2 p-4">
    <h3 class="text-xl font-semibold mb-4">Détails de l'État Workflow</h3>
    <div class="container mx-auto">
        <div class="bg-white shadow p-6 rounded-sm">
            <div class="flex items-center justify-between bg-gray-200 p-1 mt-2">
                <p class=" font-bold text-first-orange">Données de base</p>
                <a href="{{route("etat_workflow.edit", $etatWorkflow->id)}}" class="flex items-center justify-end bg-first-orange hover:bg-first-orange text-white px-2 py-1 rounded text-sm" wire:click="setEtatRejet">
                    <span class="mr-2">Modifier </span>
                    <svg width="12" height="15" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.09868 0.23645C4.37895 0.23645 3.76665 0.73733 3.53973 1.43645H1.79266C0.879723 1.43645 0.139648 2.24233 0.139648 3.23645V17.6365C0.139648 18.6305 0.879723 19.4365 1.79266 19.4365H4.55096C4.55899 19.2995 4.57862 19.1606 4.6108 19.0203L4.79077 18.2365H1.79266C1.48835 18.2365 1.24166 17.9678 1.24166 17.6365V3.23645C1.24166 2.90508 1.48835 2.63645 1.79266 2.63645H3.53973C3.76665 3.33557 4.37895 3.83645 5.09868 3.83645H8.4047C9.12442 3.83645 9.7367 3.33557 9.9636 2.63645H11.7107C12.015 2.63645 12.2617 2.90508 12.2617 3.23645V8.91447C12.6137 8.75022 12.9875 8.65875 13.3637 8.64005V3.23645C13.3637 2.24233 12.6236 1.43645 11.7107 1.43645H9.9636C9.7367 0.73733 9.12442 0.23645 8.4047 0.23645H5.09868ZM4.54768 2.03645C4.54768 1.70508 4.79437 1.43645 5.09868 1.43645H8.4047C8.70897 1.43645 8.9557 1.70508 8.9557 2.03645C8.9557 2.36782 8.70897 2.63645 8.4047 2.63645H5.09868C4.79437 2.63645 4.54768 2.36782 4.54768 2.03645ZM6.72937 16.2891L12.0515 10.4938C12.8563 9.61734 14.1613 9.61734 14.9661 10.4938C15.7708 11.3702 15.7708 12.7911 14.9661 13.6676L9.64402 19.4629C9.33369 19.8008 8.94491 20.0404 8.5192 20.1563L6.8685 20.6057C6.15061 20.8011 5.50037 20.0931 5.67985 19.3114L6.09251 17.5139C6.19895 17.0504 6.41908 16.627 6.72937 16.2891Z" fill="white"/>
                    </svg>


                </a>
            </div>
            <div class="shadow p-6 rounded-sm">
                <div class="mt-4 mb-2 flex ">
                    <div class="w-1/3 flex items-end justify-end pr-2">
                        <strong class="text-black">Position :</strong>
                    </div>
                    <div class="w-2/3">
                        <span class="text-grey-600">{{ $etatWorkflow->position }}</span>
                    </div>
                </div>
                <hr>

                <div class="mt-4 mb-2 flex ">
                    <div class="w-1/3 flex items-end justify-end pr-2">
                        <strong class="text-black capitalize">code :</strong>
                    </div>
                    <div class="w-2/3">
                        <span class="text-grey-600">{{ $etatWorkflow->code }}</span>
                    </div>
                </div>
                <hr>

                <div class="mt-4 mb-2 flex ">
                    <div class="w-1/3 flex items-end justify-end pr-2">
                        <strong class="text-black">libelle :</strong>
                    </div>
                    <div class="w-2/3">
                        <span class="text-grey-600">{{ $etatWorkflow->libelle ?? " -" }}</span>
                    </div>
                </div>
                <hr>
                <div class="mt-4 mb-2 flex ">
                    <div class="w-1/3 flex items-end justify-end pr-2">
                        <strong class="text-black">Status :</strong>
                    </div>
                    <div class="w-2/3">
                        <span class="text-grey-600">{{ $etatWorkflow->status ?? " - " }}</span>
                    </div>
                </div>
                <hr>
                <div class="mt-4 mb-2">
                    <strong class="text-black font-bold">
                        Description
                    </strong>
                    <p class="shadow border p-2 text-grey-600 rounded-sm mb-2">
                        {{ $etatWorkflow->description }}
                    </p>

                </div>


                <div class="mt-4 mb-2 flex ">
                    <div class="w-1/3 flex items-end justify-end pr-2">
                        <strong class="text-black">Est rejetable :</strong>
                    </div>
                    <div class="w-2/3">
                        <span class="text-grey-600">
                            @if($etatWorkflow->est_rejetable)
                                <span class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded">
                                    Oui
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded">
                                    Non
                                </span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="mt-4 mb-2 flex ">
                    <div class="w-1/3 flex items-end justify-end pr-2">
                        <strong class="text-black">Est final :</strong>
                    </div>
                    <div class="w-2/3">
                        <span class="text-grey-600">
                            @if($etatWorkflow->est_fin)
                                <span class="px-3 py-1 text-xs font-semibold leading-tight text-green-700 bg-green-100 rounded">
                                    Oui
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold leading-tight text-red-700 bg-red-100 rounded">
                                    Non
                                </span>
                            @endif
                        </span>
                    </div>
                </div>


            </div>


            {{-- etat suivant --}}
            <div class="flex items-center justify-between bg-gray-200 p-1 mt-2">
                <p class="font-bold text-first-orange">État Suivant</p>
                <button wire:click="setModifyingBoutonSuivant" class="flex items-center text-white bg-first-orange px-2 py-1 rounded text-sm">
                    <span class="mr-2">Modifier état suivant</span>
                        <svg width="12" height="16" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.09868 0.23645C4.37895 0.23645 3.76665 0.73733 3.53973 1.43645H1.79266C0.879723 1.43645 0.139648 2.24233 0.139648 3.23645V17.6365C0.139648 18.6305 0.879723 19.4365 1.79266 19.4365H4.55096C4.55899 19.2995 4.57862 19.1606 4.6108 19.0203L4.79077 18.2365H1.79266C1.48835 18.2365 1.24166 17.9678 1.24166 17.6365V3.23645C1.24166 2.90508 1.48835 2.63645 1.79266 2.63645H3.53973C3.76665 3.33557 4.37895 3.83645 5.09868 3.83645H8.4047C9.12442 3.83645 9.7367 3.33557 9.9636 2.63645H11.7107C12.015 2.63645 12.2617 2.90508 12.2617 3.23645V8.91447C12.6137 8.75022 12.9875 8.65875 13.3637 8.64005V3.23645C13.3637 2.24233 12.6236 1.43645 11.7107 1.43645H9.9636C9.7367 0.73733 9.12442 0.23645 8.4047 0.23645H5.09868ZM4.54768 2.03645C4.54768 1.70508 4.79437 1.43645 5.09868 1.43645H8.4047C8.70897 1.43645 8.9557 1.70508 8.9557 2.03645C8.9557 2.36782 8.70897 2.63645 8.4047 2.63645H5.09868C4.79437 2.63645 4.54768 2.36782 4.54768 2.03645ZM6.72937 16.2891L12.0515 10.4938C12.8563 9.61734 14.1613 9.61734 14.9661 10.4938C15.7708 11.3702 15.7708 12.7911 14.9661 13.6676L9.64402 19.4629C9.33369 19.8008 8.94491 20.0404 8.5192 20.1563L6.8685 20.6057C6.15061 20.8011 5.50037 20.0931 5.67985 19.3114L6.09251 17.5139C6.19895 17.0504 6.41908 16.627 6.72937 16.2891Z" fill="white"/>
                        </svg>
                </button>
            </div>

            @if ($modifyingEtatSuivant)
                <div class=" mt-2">

                    <div class="mb-4">
                        <label for="bouton_suivant" class="block text-first-orange font-bold mb-1">Libellé Bouton Suivant:</label>
                        <input type="text" id="bouton_suivant" wire:model="bouton_suivant" class="form-input rounded-md border-gray-300 shadow-sm block w-full">
                    </div>

                    <div class="mb-4">
                        <label for="etat_suivant_id" class="block text-first-orange font-bold mb-2">État Suivant:</label>
                        <select id="etat_suivant_id" wire:model="etat_suivant_id" class="form-input rounded-md border-gray-300 shadow-sm block w-full">
                            <option value="">Sélectionnez l'état suivant</option>
                            @foreach($allEtatWorkflow as $etat)
                                <option value="{{ $etat->id }}">{{ $etat->position . ' - ' . $etat->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button class="flex items-center bg-first-orange text-white px-4 py-1 rounded hover:bg-blue-500" wire:click="setEtatSuivant">
                            <span class="mr-2">Valider</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.5917 6.00822C15.5142 5.93011 15.4221 5.86811 15.3205 5.82581C15.219 5.7835 15.11 5.76172 15 5.76172C14.89 5.76172 14.7811 5.7835 14.6796 5.82581C14.578 5.86811 14.4858 5.93011 14.4084 6.00822L8.20004 12.2249L5.59171 9.60822C5.51127 9.53052 5.41632 9.46942 5.31227 9.42842C5.20823 9.38742 5.09713 9.36731 4.98531 9.36924C4.87349 9.37118 4.76315 9.39512 4.66058 9.4397C4.55802 9.48427 4.46524 9.54862 4.38754 9.62905C4.30984 9.70949 4.24875 9.80444 4.20774 9.90848C4.16674 10.0125 4.14663 10.1236 4.14856 10.2354C4.1505 10.3473 4.17444 10.4576 4.21902 10.5602C4.2636 10.6627 4.32794 10.7555 4.40837 10.8332L7.60837 14.0332C7.68584 14.1113 7.77801 14.1733 7.87956 14.2156C7.98111 14.2579 8.09003 14.2797 8.20004 14.2797C8.31005 14.2797 8.41897 14.2579 8.52052 14.2156C8.62207 14.1733 8.71424 14.1113 8.79171 14.0332L15.5917 7.23322C15.6763 7.15518 15.7438 7.06047 15.79 6.95506C15.8361 6.84964 15.86 6.7358 15.86 6.62072C15.86 6.50563 15.8361 6.3918 15.79 6.28638C15.7438 6.18096 15.6763 6.08625 15.5917 6.00822Z" fill="white"/>
                            </svg>
                        </button>

                    </div>

                </div>

            @else
                <div class="shadow p-6 rounded-lg">
                    <div class="mt-4 mb-2 flex ">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Bouton suivant :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-grey-600">{{ $etatWorkflow->bouton_suivant }}</span>
                        </div>
                    </div>
                    @if ($etatWorkflow->etatSuivant)
                        <div class="mt-4 mb-2 flex ">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">État Suivant :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-grey-600">{{ $etatWorkflow->etatSuivant->libelle }}</span>
                            </div>
                        </div>
                    @else
                        <div class="mt-4 mb-2 flex ">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">État Suivant :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-grey-600">Aucun</span>
                            </div>
                        </div>
                    @endif
                </div>

            @endif

            {{-- etat rejet --}}
            <div class="flex items-center justify-between bg-gray-200 p-1 mt-2">
                <p class="text-first-orange font-bold">État rejet</p>
                <button wire:click="setModifyingBoutonRejet" class="flex items-center text-white bg-first-orange px-2 py-1 rounded text-sm">
                    <span class="mr-2">Modifier état rejet</span>
                        <svg width="12" height="16" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.09868 0.23645C4.37895 0.23645 3.76665 0.73733 3.53973 1.43645H1.79266C0.879723 1.43645 0.139648 2.24233 0.139648 3.23645V17.6365C0.139648 18.6305 0.879723 19.4365 1.79266 19.4365H4.55096C4.55899 19.2995 4.57862 19.1606 4.6108 19.0203L4.79077 18.2365H1.79266C1.48835 18.2365 1.24166 17.9678 1.24166 17.6365V3.23645C1.24166 2.90508 1.48835 2.63645 1.79266 2.63645H3.53973C3.76665 3.33557 4.37895 3.83645 5.09868 3.83645H8.4047C9.12442 3.83645 9.7367 3.33557 9.9636 2.63645H11.7107C12.015 2.63645 12.2617 2.90508 12.2617 3.23645V8.91447C12.6137 8.75022 12.9875 8.65875 13.3637 8.64005V3.23645C13.3637 2.24233 12.6236 1.43645 11.7107 1.43645H9.9636C9.7367 0.73733 9.12442 0.23645 8.4047 0.23645H5.09868ZM4.54768 2.03645C4.54768 1.70508 4.79437 1.43645 5.09868 1.43645H8.4047C8.70897 1.43645 8.9557 1.70508 8.9557 2.03645C8.9557 2.36782 8.70897 2.63645 8.4047 2.63645H5.09868C4.79437 2.63645 4.54768 2.36782 4.54768 2.03645ZM6.72937 16.2891L12.0515 10.4938C12.8563 9.61734 14.1613 9.61734 14.9661 10.4938C15.7708 11.3702 15.7708 12.7911 14.9661 13.6676L9.64402 19.4629C9.33369 19.8008 8.94491 20.0404 8.5192 20.1563L6.8685 20.6057C6.15061 20.8011 5.50037 20.0931 5.67985 19.3114L6.09251 17.5139C6.19895 17.0504 6.41908 16.627 6.72937 16.2891Z" fill="white"/>
                        </svg>
                </button>
            </div>

            @if ($modifyingEtatRejet)
                <div class=" mt-4">

                    <div class="mb-4">
                        <label for="bouton_rejet" class="block text-first-orange font-bold my-1">Libellé Bouton rejet:</label>
                        <input type="text" id="bouton_rejet" wire:model="bouton_rejet" class="form-input rounded-md border-gray-300 shadow-sm block w-full">
                    </div>

                    <div class="mb-4">
                        <label for="etat_rejet_id" class="block text-first-orange font-bold my-1">État rejet:</label>
                        <select id="etat_rejet_id" wire:model="etat_rejet_id" class="form-input rounded-md border-gray-300 shadow-sm block w-full">
                            <option value="">Sélectionnez un état de rejet</option>
                            @foreach($allEtatWorkflow as $etat)
                                <option value="{{ $etat->id }}">{{ $etat->position . ' - ' . $etat->libelle }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button class="flex items-center justify-end bg-first-orange text-white px-4 py-1 rounded" wire:click="setEtatRejet">
                            <span class="mr-2">Valider </span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.5917 6.00822C15.5142 5.93011 15.4221 5.86811 15.3205 5.82581C15.219 5.7835 15.11 5.76172 15 5.76172C14.89 5.76172 14.7811 5.7835 14.6796 5.82581C14.578 5.86811 14.4858 5.93011 14.4084 6.00822L8.20004 12.2249L5.59171 9.60822C5.51127 9.53052 5.41632 9.46942 5.31227 9.42842C5.20823 9.38742 5.09713 9.36731 4.98531 9.36924C4.87349 9.37118 4.76315 9.39512 4.66058 9.4397C4.55802 9.48427 4.46524 9.54862 4.38754 9.62905C4.30984 9.70949 4.24875 9.80444 4.20774 9.90848C4.16674 10.0125 4.14663 10.1236 4.14856 10.2354C4.1505 10.3473 4.17444 10.4576 4.21902 10.5602C4.2636 10.6627 4.32794 10.7555 4.40837 10.8332L7.60837 14.0332C7.68584 14.1113 7.77801 14.1733 7.87956 14.2156C7.98111 14.2579 8.09003 14.2797 8.20004 14.2797C8.31005 14.2797 8.41897 14.2579 8.52052 14.2156C8.62207 14.1733 8.71424 14.1113 8.79171 14.0332L15.5917 7.23322C15.6763 7.15518 15.7438 7.06047 15.79 6.95506C15.8361 6.84964 15.86 6.7358 15.86 6.62072C15.86 6.50563 15.8361 6.3918 15.79 6.28638C15.7438 6.18096 15.6763 6.08625 15.5917 6.00822Z" fill="white"/>
                            </svg>

                        </button>

                    </div>

                </div>

            @else
                <div class="shadow p-6 rounded-lg">
                    <div class="mt-4 mb-2 flex ">
                        <div class="w-1/3 flex items-end justify-end pr-2">
                            <strong class="text-black">Bouton rejet :</strong>
                        </div>
                        <div class="w-2/3">
                            <span class="text-grey-600">{{ $etatWorkflow->bouton_rejet }}</span>
                        </div>
                    </div>
                    @if ($etatWorkflow->etatRejet)
                        <div class="mt-4 mb-2 flex ">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">État Rejet :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-grey-600">{{ $etatWorkflow->etatRejet->libelle }}</span>
                            </div>
                        </div>
                    @else
                        <div class="mt-4 mb-2 flex ">
                            <div class="w-1/3 flex items-end justify-end pr-2">
                                <strong class="text-black">État rejet :</strong>
                            </div>
                            <div class="w-2/3">
                                <span class="text-grey-600">Aucun</span>
                            </div>
                        </div>
                    @endif
                </div>

            @endif

        </div>
    </div>


</div>
