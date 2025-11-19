<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modification d\'un apprenant') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p><a href="{{route('apprenant.index')}}" class="text-gray-800">Liste des apprenants</a></p>
        <span class="mx-2 text-gray-800">/</span>
        <p class="text-first-orange">Modifier un apprenant</p>
    </div>

    <div class="bg-white shadow rounded w-full">
        <form class="bg-white shadow-md rounded pt-6 pb-8 mb-4"
              action="{{ route('apprenant.update', $apprenant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="max-w-7xl sm:px-2 lg:px-4">
                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                    Édition de l'apprenant
                </h3>


                <div class="w-full sm:w-1/2 px-2 pb-5">
    <x-label for="annee_academique_id">Année académique</x-label>
    <select id="annee_academique_id" name="annee_academique_id" class="w-full border rounded" required>
        <option value="">Choisir une année</option>
        @foreach ($annees as $annee)
            <option value="{{ $annee->id }}" {{ $inscription && $inscription->annee_academique_id == $annee->id ? 'selected' : '' }}>
                {{ $annee->code }}
            </option>
        @endforeach
    </select>
</div>

                <div class="p-4">
                    <div class="flex flex-wrap w-full justify-evenly">
                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="nom">Nom <span class="text-red-500">*</span></x-label>
                            <x-input id="nom" name="nom" type="text" class="w-full" value="{{ $apprenant->nom }}" required />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="prenom">Prénom <span class="text-red-500">*</span></x-label>
                            <x-input id="prenom" name="prenom" type="text" class="w-full" value="{{ $apprenant->prenom }}" required />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="date_naissance">Date de naissance <span class="text-red-500">*</span></x-label>
                            <x-input id="date_naissance" name="date_naissance" type="date" class="w-full" value="{{ $apprenant->date_naissance }}" required />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="lieu_naissance">Lieu de naissance <span class="text-red-500">*</span></x-label>
                            <x-input id="lieu_naissance" name="lieu_naissance" type="text" class="w-full" value="{{ $apprenant->lieu_naissance }}" required />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="commune_id">Commune de résidence <span class="text-red-500">*</span></x-label>
                            <select id="commune_id" name="commune_id" class="w-full border rounded">
                                <option value="">Choisir la commune</option>
                                @foreach($communes as $commune)
                                    <option value="{{ $commune->id }}" {{ $apprenant->commune_id == $commune->id ? 'selected' : '' }}>
                                        {{ $commune->libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="adresse">Adresse <span class="text-red-500">*</span></x-label>
                            <x-input id="adresse" name="adresse" type="text" class="w-full" value="{{ $apprenant->adresse }}" required />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="nationalite">Nationalité <span class="text-red-500">*</span></x-label>
                            <select id="nationalite" name="nationalite" class="w-full border rounded" required>
                                <option value="">Choisissez la nationalité</option>
                                @foreach ($pays as $nationalite)
                                    <option value="{{ $nationalite->en_short_name }}" {{ $apprenant->nationalite == $nationalite->en_short_name ? 'selected' : '' }}>
                                        {{ $nationalite->en_short_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="sexe">Sexe <span class="text-red-500">*</span></x-label>
                            <select id="sexe" name="sexe" class="w-full border rounded" required>
                                <option value="">Choisir le sexe</option>
                                <option value="M" {{ $apprenant->sexe == 'M' ? 'selected' : '' }}>M</option>
                                <option value="F" {{ $apprenant->sexe == 'F' ? 'selected' : '' }}>F</option>
                            </select>
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="telephone">Téléphone <span class="text-red-500">*</span></x-label>
                            <x-input id="telephone" name="telephone" type="text" class="w-full" value="{{ $apprenant->telephone }}" required />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="email">Email</x-label>
                            <x-input id="email" name="email" type="email" class="w-full" value="{{ $apprenant->email }}" />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="situationMatrimoniale">Situation matrimoniale</x-label>
                            <select id="situationMatrimoniale" name="situationMatrimoniale" class="w-full border rounded">
                                <option value="">Choisir</option>
                                <option value="{{ \App\Enums\MarriageStatus::SINGLE }}" {{ $apprenant->situationMatrimoniale == \App\Enums\MarriageStatus::SINGLE ? 'selected' : '' }}>Célibataire</option>
                                <option value="{{ \App\Enums\MarriageStatus::MARRIED }}" {{ $apprenant->situationMatrimoniale == \App\Enums\MarriageStatus::MARRIED ? 'selected' : '' }}>Marié</option>
                                <option value="{{ \App\Enums\MarriageStatus::DIVORCED }}" {{ $apprenant->situationMatrimoniale == \App\Enums\MarriageStatus::DIVORCED ? 'selected' : '' }}>Divorcé</option>
                                <option value="{{ \App\Enums\MarriageStatus::WIDOWED }}" {{ $apprenant->situationMatrimoniale == \App\Enums\MarriageStatus::WIDOWED ? 'selected' : '' }}>Veuf</option>
                            </select>
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="nomTuteur">Nom du Tuteur</x-label>
                            <x-input id="nomTuteur" name="nomTuteur" type="text" class="w-full" value="{{ $apprenant->nomTuteur }}" />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="prenomTuteur">Prénom du Tuteur</x-label>
                            <x-input id="prenomTuteur" name="prenomTuteur" type="text" class="w-full" value="{{ $apprenant->prenomTuteur }}" />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="numTelTuteur">Téléphone du Tuteur</x-label>
                            <x-input id="numTelTuteur" name="numTelTuteur" type="text" class="w-full" value="{{ $apprenant->numTelTuteur }}" />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="prenomMere">Prénom de la mère</x-label>
                            <x-input id="prenomMere" name="prenomMere" type="text" class="w-full" value="{{ $apprenant->prenomMere }}" />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="nomMere">Nom de la mère</x-label>
                            <x-input id="nomMere" name="nomMere" type="text" class="w-full" value="{{ $apprenant->nomMere }}" />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="prenomPere">Prénom du père</x-label>
                            <x-input id="prenomPere" name="prenomPere" type="text" class="w-full" value="{{ $apprenant->prenomPere }}" />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="matricule">Matricule</x-label>
                            <x-input id="matricule" name="matricule" type="text" class="w-full" value="{{ $apprenant->matricule }}" />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="dateInsertion">Date d'insertion</x-label>
                            <x-input id="dateInsertion" name="dateInsertion" type="date" class="w-full" value="{{ $apprenant->dateInsertion }}" />
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="autoEmploi">Auto emploi</x-label>
                            <select id="autoEmploi" name="autoEmploi" class="w-full border rounded">
                                <option value="">Choisir une option</option>
                                <option value="1" {{ $apprenant->autoEmploi == 1 ? 'selected' : '' }}>Oui</option>
                                <option value="0" {{ $apprenant->autoEmploi == 0 ? 'selected' : '' }}>Non</option>
                            </select>
                        </div>

                        <div class="w-full sm:w-1/2 px-2 pb-5">
                            <x-label for="emploiSalarie">Emploi salarié</x-label>
                            <select id="emploiSalarie" name="emploiSalarie" class="w-full border rounded">
                                <option value="">Choisir une option</option>
                                <option value="1" {{ $apprenant->emploiSalarie == 1 ? 'selected' : '' }}>Oui</option>
                                <option value="0" {{ $apprenant->emploiSalarie == 0 ? 'selected' : '' }}>Non</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('apprenant.index') }}" class="px-4 py-2 bg-gray-300 rounded text-gray-700 mr-4">Annuler</a>
                        <button type="submit" class="px-4 py-2 bg-first-orange text-white rounded hover:bg-orange-600">Enregistrer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
