<div>
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Selectionner un metier
        </label>

        <select wire:model="selectedValue" id="metier_id" wire:change="updateMetier($event.target.value)" class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow" id="metier" name="metier_id" required id="metier_id">
            <option value="">Sélectionnez un metier</option>
            @foreach($metiers as $metier)
            <option value="{{ $metier->id }}">{{ $metier->nom }}</option>
            @endforeach
        </select>
    </div>
    @if(!empty($matieres))
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="description">
            Sélectionner une matiere
        </label>
        <select id="matiere_id" name="matiere_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez une matiere</option>
            @foreach($matieres as $matiere)
            <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
            @endforeach
        </select>
    </div>
    @endif
</div>