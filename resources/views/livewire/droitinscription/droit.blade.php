<div>
 
    @if (session('success'))
        <div class="mb-4">
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-sm dark:bg-gray-800 dark:text-green-300 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2A1 1 0 1 1 7.707 9.293L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="sr-only">Success</span>
                <div>
                    <span class="font-medium">Succès !</span> {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    {{-- Sélection de la classe et année académique --}}
    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-black text-xl py-4">
                {{ $currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée' }}
            </h2>
        </div>

        <div class="mb-4 flex gap-4">
            {{-- Classe --}}
            <div>
                <label for="classe" class="block text-sm font-medium">Classe :</label>
                <select wire:model="classe" wire:change="$refresh" id="classe" class="rounded border-gray-300 text-sm">
                    <option value="">-- Choisir une classe ftp --</option>
                    @foreach ($classes as $cl)
                        <option value="{{ $cl->id }}">{{ $cl->libelle }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Année académique --}}
            <div>
                <label for="annee_academique_id" class="block text-sm font-medium">Année académique :</label>
                <select wire:model="annee_academique_id" wire:change="$refresh" id="annee_academique_id" class="rounded border-gray-300 text-sm">
                    <option value="">-- Toutes les années --</option>
                    @foreach (\App\Models\AnneeAcademique::all() as $annee)
                        <option value="{{ $annee->id }}">{{ $annee->code }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @if ($currentClasse)
        {{-- Informations classe --}}
        <div class="py-2 px-4 m-2 shadow bg-vert2 border border-black rounded-md">
            <div class="grid sm:grid-cols-3 gap-2 py-2 text-md">
                <div><span class="text-gray-800">Année Scolaire :</span> <span class="font-bold">{{ $anneeAcademiqueLabel ?? 'N/A' }}</span></div>
                <div><span class="text-gray-800">Centre de ressources :</span> <span class="font-bold">{{ $currentClasse->etablissement->nom ?? '-' }}</span></div>
                <div><span class="text-gray-800">Filière :</span> <span class="font-bold">{{ optional($currentClasse->niveau_etude->metier->filiere)->nom ?? '-' }}</span></div>
                <div><span class="text-gray-800">Métier :</span> <span class="font-bold">{{ optional($currentClasse->niveau_etude->metier)->nom ?? '-' }}</span></div>
                <div><span class="text-gray-800">Niveau d'études :</span> <span class="font-bold">{{ optional($currentClasse->niveau_etude)->nom ?? '-' }}</span></div>
                <div><span class="text-gray-800">Nombre apprenants :</span> <span class="font-bold">{{ $nombreApprenants ?? 0 }}</span></div>
            </div>
        </div>

        {{-- Liste des apprenants --}}
        <div class="w-full sm:px-2 lg:px-4">
            <div class="flex flex-col sm:flex-row py-2 gap-4">
                @if ($apprenants && count($apprenants))
                    <div class="sm:w-1/2 p-4 border bg-gray-100 shadow rounded" style="min-height:50vh">
                        <h2 class="font-bold text-xl mb-4">Liste des apprenants ({{ count($apprenants) }})</h2>
                        <hr class="mb-2">
                        <div class="text-sm w-full overflow-x-auto">
                            <table class="w-full border-t mb-3">
                                <thead>
                                    <tr class="text-xs font-black tracking-wide text-left text-maquette-gris border-b">
                                        <th class="p-2 text-gray-800">Matricule</th>
                                        <th class="p-2 text-gray-800">Nom Prénoms</th>
                                        <th class="p-2 text-gray-800 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y">
                                    @foreach ($apprenants as $inscription)
                                        <tr class="text-gray-700 {{ $selectedApprenant == $inscription->id ? 'bg-green-600 text-white' : '' }}">
                                            <td wire:click="loadCompetences({{ $inscription->id }})" class="px-2 font-bold cursor-pointer">
                                                <i class="fa fa-caret-right"></i>
                                                {{ $inscription->apprenant->matricule ?? '-' }}
                                            </td>
                                            <td class="px-2">
                                                {{ $inscription->apprenant->nom ?? '-' }} {{ $inscription->apprenant->prenom ?? '-' }}
                                            </td>
                                            <td class="px-2 text-center">
                                                <a href="#" wire:click="loadCompetences({{ $inscription->id }})" class="text-green-700 hover:text-blue-900">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="sm:w-1/2 p-4 border bg-gray-100 rounded shadow text-center">
                        <span class="text-red-600 text-lg">Aucun apprenant enregistré pour cette classe !</span>
                    </div>
                @endif

            </div>
        </div>
    @else
      
        <div class="alert bg-orange-100 flex p-4 rounded mt-4 justify-center items-center">
            <h3 class="text-2xl text-gray-700">
                Veuillez sélectionner une classe et une année académique !
            </h3>
        </div>
    @endif
</div>
