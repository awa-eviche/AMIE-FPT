<div class="p-6 bg-white rounded-lg shadow-lg">
    

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="update" class="space-y-5">

        {{-- Métier --}}
        <div>
            <label for="metier" class="block text-sm font-semibold text-gray-700">Métier</label>
            <select id="metier" wire:model="selectedMetier" class="border-gray-300 rounded-md w-full p-2">
                <option value="">-- Choisir un métier --</option>
                @foreach($metiers as $metier)
                    <option value="{{ $metier->id }}">{{ $metier->nom }}</option>
                @endforeach
            </select>
        </div>

        {{-- Niveau --}}
        <div>
            <label for="niveau" class="block text-sm font-semibold text-gray-700">Niveau</label>
            <select id="niveau" wire:model="selectedNiveau" class="border-gray-300 rounded-md w-full p-2" {{ empty($niveaux) ? 'disabled' : '' }}>
                <option value="">-- Choisir un niveau --</option>
                @foreach($niveaux as $niveau)
                    <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                @endforeach
            </select>
        </div>

        {{-- Compétence --}}
        <div>
            <label for="competence" class="block text-sm font-semibold text-gray-700">Compétence</label>
            <select id="competence" wire:model="selectedCompetence" class="border-gray-300 rounded-md w-full p-2" {{ empty($competences) ? 'disabled' : '' }}>
                <option value="">-- Choisir une compétence --</option>
                @foreach($competences as $competence)
                    <option value="{{ $competence->id }}">{{ $competence->nom }}</option>
                @endforeach
            </select>
        </div>

        {{-- Élément --}}
        <div>
            <label for="element" class="block text-sm font-semibold text-gray-700">Élément de compétence</label>
            <select id="element" wire:model="selectedElement" class="border-gray-300 rounded-md w-full p-2" {{ empty($elements) ? 'disabled' : '' }}>
                <option value="">-- Choisir un élément --</option>
                @foreach($elements as $element)
                    <option value="{{ $element->id }}">{{ $element->nom }}</option>
                @endforeach
            </select>
            @error('selectedElement') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Libellé --}}
        <div>
            <label for="libelle" class="block text-sm font-semibold text-gray-700">Libellé du critère</label>
            <input type="text" id="libelle" wire:model="libelle" class="border-gray-300 rounded-md w-full p-2" placeholder="Libellé du critère">
            @error('libelle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        {{-- Boutons --}}
        <div class="flex justify-end gap-3 mt-6">
          
            <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 text-sm">
                 Modifier le critère
            </button>
        </div>
    </form>
</div>
