<div>
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Sélectionner une compétence
        </label>
        <select wire:model="competence" id="competence_id" wire:change="$refresh"  name="competence_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez une competence</option>
            @foreach($competences as $comp)
                <option value="{{ $comp->id }}">{{ $comp->nom }}</option>
            @endforeach
        </select>
    </div>

    @if(!empty($elements))
        <div class="mb-4 mx-auto w-full">
            <label class="block text-gray-700 text-sm font-bold" for="element">
                Sélectionner un élément de compétence
            </label>
            <select id="element" name="element" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
                <option value="">Sélectionnez un élément de compétence</option>
                @foreach($elements as $elt)
                    <option value="{{ $elt->id }}">{{ $elt->nom }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
