<div class="p-4">
    {{-- ✅ Messages --}}
    @if(session('success'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 5000)" 
            x-show="show"
            x-transition
            class="bg-green-200 text-green-800 p-3 rounded mb-4"
        >
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 5000)" 
            x-show="show"
            x-transition
            class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4"
        >
            {{ session('warning') }}
        </div>
    @endif

    {{-- 🔺 Erreur de validation --}}
    @error('apprenantsSelectionnes') 
        <div class="bg-red-100 text-red-700 p-2 rounded mb-2">
            {{ $message }}
        </div>
    @enderror

    <div class="flex flex-col md:flex-row gap-4 mb-4">
    {{-- Sélection de la classe --}}
    <div class="w-full md:w-1/2">
        <label class="block font-semibold mb-1">Classe :</label>
        <select wire:model="classe" wire:change="$refresh" class="border rounded p-2 w-full">
            <option value="">-- Choisir une classe --</option>
            @foreach ($classes as $c)
                <option value="{{ $c->id }}">{{ $c->libelle }}</option>
            @endforeach
        </select>
    </div>

    {{-- Sélection année académique --}}
    <div class="w-full md:w-1/2">
        <label class="block font-semibold mb-1">Année académique :</label>
        <select wire:model="annee_academique_id" wire:change="$refresh" class="border p-2 rounded w-full">
            <option value="">-- Choisir une année --</option>
            @foreach ($annees as $a)
                <option value="{{ $a->id }}">{{ $a->code }}</option>
            @endforeach
        </select>
    </div>
</div>


    @if($currentClasse && $annee_academique_id)
        <h1 class="text-xl font-bold mb-4">
            Apprenants admis à réinscrire – {{ $currentClasse->libelle }}
        </h1>

        @if(count($admis) > 0)
            {{-- Tableau des admis --}}
            <table class="table-auto w-full bg-white shadow rounded mb-6">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Prénom</th>
                        <th class="px-4 py-2">Matricule</th>
                        <th class="px-4 py-2">Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admis as $entry)
                        <tr class="border-b">
                            <td class="px-4 py-2">
                                <input type="checkbox" wire:model="apprenantsSelectionnes" value="{{ $entry['inscription']->apprenant->id }}">
                            </td>
                            <td class="px-4 py-2">{{ $entry['inscription']->apprenant->nom }}</td>
                            <td class="px-4 py-2">{{ $entry['inscription']->apprenant->prenom }}</td>
                            <td class="px-4 py-2">{{ $entry['inscription']->apprenant->matricule }}</td>
                            <td class="px-4 py-2">{{ $entry['moyenne'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <label class="inline-flex items-center space-x-2 mt-2 mb-4">
    <input type="checkbox" id="selectAllCheckbox" onclick="toggleCheckboxes()" class="form-checkbox h-4 w-4 text-blue-600">
    <span class="text-sm text-blue-600 cursor-pointer">Tout cocher / décocher</span>
</label>



            {{-- Sélection nouvelle classe --}}
            <div class="mb-4">
                <label class="block font-semibold">Nouvelle classe :</label>
                <select wire:model="nouvelle_classe_id" wire:change="$refresh" class="border p-2 rounded w-full">
                    <option value="">-- Choisir --</option>
                    @foreach ($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->libelle }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Sélection année académique de réinscription --}}
<div class="mb-4">
    <label class="block font-semibold">Année académique de réinscription :</label>
    <select wire:model="annee_reinscription_id" wire:change="$refresh" class="border p-2 rounded w-full">
        <option value="">-- Choisir une année --</option>
        @foreach ($annees as $a)
            <option value="{{ $a->id }}">{{ $a->code }}</option>
        @endforeach
    </select>
</div>

            {{-- Bouton --}}
            <button wire:click="reinscrire" 
                class="bg-green-600 text-white mt-6 px-6 py-2 rounded hover:bg-green-700">
                Réinscrire les apprenants sélectionnés
            </button>
        @else
            <p class="text-gray-600">Aucun apprenant admissible à la réinscription dans cette classe pour cette année académique.</p>
        @endif
    @endif
</div>
<script>
    function toggleCheckboxes() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model="apprenantsSelectionnes"]');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);

        checkboxes.forEach(cb => cb.checked = !allChecked);

        // Manuellement déclencher un événement 'input' pour Livewire
        checkboxes.forEach(cb => {
            cb.dispatchEvent(new Event('input', { bubbles: true }));
        });
    }
</script>
