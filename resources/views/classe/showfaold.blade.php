<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Informations détaillées de la classe') }}
        </h2>
    </x-slot>

    <div class="bg-transparent shadow rounded-sm w-full p-4">
        <div class="bg-white pb-4 w-full mx-auto md:container md:mx-auto">

            <h2 class="font-bold text-xl sm:px-2 lg:px-4 py-4">{{ $classe->libelle }}</h2>

            <div class="flex justify-between items-center sm:px-2 lg:px-4">
                <a href="{{ route('classe.index') }}" class="text-blue-500 hover:underline">
                    &larr; Retour à la liste des classes
                </a>

                <div class="flex gap-2">
                    <div onclick="window.location='{{ route('classe.edit', $classe->id) }}'" style="background-color:#006D3A; cursor: pointer;"
                         class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-5 py-2.5 cursor-pointer">
                        Modifier
                    </div>

                    <form action="{{ route('classe.destroy', $classe->id) }}" method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 text-white hover:bg-red-700 rounded-lg text-sm px-5 py-2.5">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-6 border border-gray-200 rounded-lg p-4">
                <h3 class="bg-gray-100 p-2 text-md font-bold text-orange-600">
                    Détails de la classe : {{ $classe->libelle }}
                </h3>

                <div class="flex flex-col lg:flex-row gap-6 mt-4">
                    <!-- Informations générales -->
                    <div class="lg:w-1/3 border shadow p-4 rounded bg-gray-50">
                        <h3 class="font-bold text-xl mb-4">Informations générales</h3>
                        <hr>

                        <div class="grid grid-cols-2 gap-2 py-2 text-sm">
                            <div class="text-gray-800">Etablissement :</div>
                            <div class="font-bold">{{ $classe->etablissement->nom }}</div>

                            <div class="text-gray-800">Filière :</div>
                            <div class="font-bold">{{ $classe->niveau_etude->metier->filiere->nom }}</div>

                            <div class="text-gray-800">Métier :</div>
                            <div class="font-bold">{{ $classe->niveau_etude->metier->nom }}</div>

                            <div class="text-gray-800">Niveau d'études :</div>
                            <div class="font-bold">{{ $classe->niveau_etude->nom }}</div>

                            <div class="text-gray-800">Modalité :</div>
                            <div class="font-bold">{{ $classe->modalite }}</div>
                        </div>

                        <hr class="my-4">

                        <h3 class="font-bold text-lg mb-2">Disciplines au programme</h3>
                        <div class="pl-2 text-sm">
                            @foreach($matieres as $matiere)
                                <div class="flex items-center mb-2">
                                    <i class="fa fa-star text-gray-400 text-xs mr-2"></i>
                                    <span><strong>{{ $matiere->code }}</strong> : {{ $matiere->nom }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Liste des apprenants -->
                    <div class="lg:w-2/3 border shadow p-4 rounded bg-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-xl">Liste des apprenants</h3>

                            <form method="GET" action="{{ route('classe.show', $classe->id) }}" class="flex items-center gap-2">
                                <label for="annee_academique_id" class="text-sm font-medium">Année académique :</label>
                                <select name="annee_academique_id" id="annee_academique_id" onchange="this.form.submit()"
                                        class="rounded border-gray-300 text-sm">
                                    @foreach ($anneeAcademiques as $annee)
                                        <option value="{{ $annee->id }}" {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->code }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <div class="flex justify-between gap-4 mb-6">
                            <!-- Ajouter un apprenant -->
                            <div onclick="window.location='{{ route('apprenant.create', $classe->id) }}'" style="background-color:#006D3A; cursor: pointer;"
                                 class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-5 py-2.5 cursor-pointer">
                                Ajouter un apprenant
                            </div>

                            <!-- Importer un fichier Excel -->
                            <form action="{{ route('apprenant.import', ['classe' => $classe->id]) }}" method="POST" enctype="multipart/form-data"
                                  class="flex flex-col gap-2 items-start">
                                @csrf
                                <label for="fichier_excel" class="text-sm font-medium">Fichier Excel :</label>
                                <input type="file" name="file" accept=".xlsx, .xls"
                                       class="rounded border-gray-300 text-sm" required>
                                <button type="submit" style="background-color:#006D3A; cursor: pointer;"
                                        class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-5 py-2.5 mt-2">
                                    Importer
                                </button>
                            </form>
                        </div>

                        <hr class="mb-4">

                        <!-- Tableau des apprenants -->
                        <table class="w-full text-sm">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-2 py-2 text-left">Matricule</th>
                                    <th class="px-2 py-2 text-left">Nom & Prénoms</th>
                                    <th class="px-2 py-2 text-left">Date de naissance</th>
                                    <th class="px-2 py-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @forelse ($usersWithEnterprises as $entry)
                                    <tr>
                                        <td class="px-2 py-2">{{ $entry['user']->apprenant->matricule ?? '-' }}</td>
                                        <td class="px-2 py-2">
                                            {{ $entry['user']->apprenant->nom ?? '-' }}
                                            {{ $entry['user']->apprenant->prenom ?? '' }}
                                        </td>
                                        <td class="px-2 py-2">
                                            {{ optional($entry['user']->apprenant)->date_naissance ? \Carbon\Carbon::parse($entry['user']->apprenant->date_naissance)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            <a href="{{ route('inscription.show', $entry['user']->id) }}" class="text-green-600 hover:text-green-800">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 font-semibold text-gray-500">
                                            Aucun apprenant inscrit pour cette classe.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4">
                        {{ $inscriptions->appends(['annee_academique_id' => request('annee_academique_id')])->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
