<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Muter un personnel
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                {{-- Lien retour --}}
                <div class="mb-6">
                    <a href="{{ route('personnel.muter.index') }}" class="text-blue-500 text-sm">
                        &larr; Retour à la liste des mutations
                    </a>
                </div>

                {{-- Titre --}}
                <h3 class="text-lg font-bold mb-4">
                    {{ $personnel->user?->prenom }} {{ $personnel->user?->nom }}
                </h3>

                {{-- Info séjour actuel --}}
                <div class="mb-6 p-4 bg-gray-50 rounded text-sm">
                    <p><strong>Établissement actuel :</strong> {{ $personnel->etablissement?->nom ?? '—' }}</p>
                    <p><strong>Fonction :</strong> {{ $personnel->fonction ?? '—' }}</p>
                    <p><strong>Spécialité :</strong> {{ $personnel->specialite ?? '—' }}</p>
                    <p><strong>Depuis le :</strong> {{ $personnel->date_debut?->format('d/m/Y') ?? '—' }}</p>
                </div>

                {{-- Erreurs --}}
                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                {{-- Formulaire --}}
                <form action="{{ route('personnel.muter.store', $personnel->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">
                            Nouvel établissement <span class="text-red-500">*</span>
                        </label>
                        <select name="nouveau_etablissement_id" required
                                class="w-full border rounded px-3 py-2 text-sm">
                            <option value="">Choisir…</option>
                            @foreach($etablissements as $e)
                                @if($e->id !== $personnel->etablissement_id)
                                    <option value="{{ $e->id }}" @selected(old('nouveau_etablissement_id') == $e->id)>
                                        {{ $e->nom }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">
                            Date de mutation <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_mutation" required
                               value="{{ old('date_mutation', now()->format('Y-m-d')) }}"
                               class="w-full border rounded px-3 py-2 text-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">
                            Fonction dans le nouvel établissement <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="fonction" required
                               value="{{ old('fonction', $personnel->fonction) }}"
                               class="w-full border rounded px-3 py-2 text-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Spécialité</label>
                        <input type="text" name="specialite"
                               value="{{ old('specialite', $personnel->specialite) }}"
                               class="w-full border rounded px-3 py-2 text-sm">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2">Motif (facultatif)</label>
                        <textarea name="motif" rows="3"
                                  class="w-full border rounded px-3 py-2 text-sm">{{ old('motif') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('personnel.muter.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded text-sm">Annuler</a>
                        <button type="submit"
                                class="px-4 py-2 bg-orange-500 text-white rounded text-sm">
                            Confirmer la mutation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>