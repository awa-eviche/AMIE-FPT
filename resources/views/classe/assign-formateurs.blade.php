<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Assigner des formateurs à la classe {{ $classe->libelle }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('classe.formateurs.storeAssign', $classe->id) }}">
            @csrf

            <div class="mb-4">
                <h3 class="font-bold text-lg text-gray-700 mb-3">
                    Sélectionnez les formateurs de l'établissement
                    
                </h3>

                <p class="text-xs text-gray-500 mb-3">
                    Seuls les formateurs actuellement en poste dans cet établissement apparaissent ci-dessous.
                    
                </p>

                @if($assignationsHistoriques > 0)
                    <div class="mb-3 p-2 bg-blue-50 border border-blue-200 rounded text-xs text-blue-800">
                        <i class="fa fa-info-circle"></i>
                        {{ $assignationsHistoriques }} formateur(s) muté(s) ne figurent plus dans cette liste
                        (conservé(s) dans l'historique).
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @forelse ($formateurs as $formateur)
                        <label class="flex items-start space-x-2 border rounded p-3 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="formateurs[]" value="{{ $formateur->id }}"
                                   {{ in_array($formateur->id, $formateursAssignes) ? 'checked' : '' }}
                                   class="mt-1 text-blue-600 focus:ring-blue-500">
                            <div>
                                <div class="font-medium">
                                    {{ $formateur->user->prenom ?? '' }} {{ $formateur->user->nom ?? '' }}
                                </div>
                               
                                @if($formateur->specialite)
                                    <div class="text-xs text-gray-400">
                                        {{ $formateur->specialite }}
                                    </div>
                                @endif
                            </div>
                        </label>
                    @empty
                        <div class="col-span-2 text-center text-gray-500 italic py-6">
                            <i class="fa fa-users-slash text-2xl mb-2"></i>
                            <p>Aucun formateur actif dans cet établissement.</p>
                            <p class="text-xs mt-1">
                                Les formateurs mutés sont automatiquement masqués.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('classe.show', $classe->id) }}"
                   class="bg-gray-400 text-white px-5 py-2 rounded hover:bg-gray-500 mr-2">
                    Annuler
                </a>
                <button type="submit"
                        class="bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</x-app-layout>