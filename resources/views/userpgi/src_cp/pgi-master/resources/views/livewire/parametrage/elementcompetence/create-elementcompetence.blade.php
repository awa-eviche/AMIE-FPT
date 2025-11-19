<div>
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Sélectionner un métier
        </label>
        <select wire:model="metier" id="metier_id" wire:change="$refresh"  name="metier_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez un métier</option>
            @foreach($metiers as $metierItem)
                <option value="{{ $metierItem->id }}">{{ $metierItem->nom }}</option>
            @endforeach
        </select>
    </div>

    <!-- Champ de niveau qui apparaît uniquement lorsque le métier est sélectionné -->
    @if(!empty($matieres))
        <div class="mb-4 mx-auto w-full">
            <label class="block text-gray-700 text-sm font-bold" for="description">
                Sélectionner une matiere
            </label>
            <select id="matiere_id" name="matiere_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
                <option value="">Sélectionnez une matiere</option>
                @foreach($matieres as $mat)
                    <option value="{{ $mat->id }}">{{ $mat->nom }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
