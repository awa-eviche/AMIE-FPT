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
                    Sélectionnez les formateurs de l’établissement
                    <span class="text-blue-700">{{ $classe->etablissement->nom }}</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach ($formateurs as $formateur)
                        <label class="flex items-center space-x-2 border rounded p-2 hover:bg-gray-50">
                            <input type="checkbox" name="formateurs[]" value="{{ $formateur->id }}"
                                   {{ in_array($formateur->id, $formateursAssignes) ? 'checked' : '' }}
                                   class="text-blue-600 focus:ring-blue-500">
                            <span>{{ $formateur->user->prenom ?? '' }} {{ $formateur->user->nom ?? '' }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('classe.show', $classe->id) }}"
                   class="bg-gray-400 text-white px-5 py-2 rounded hover:bg-gray-500 mr-2">Annuler</a>
                <button type="submit"
                        class="bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800">Enregistrer</button>
            </div>
        </form>
    </div>
</x-app-layout>
