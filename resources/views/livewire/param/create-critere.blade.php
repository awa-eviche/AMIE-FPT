<div>
<div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Sélectionner un métier
        </label>
        <select wire:model="metier" id="metier_id"  wire:change="$refresh" name="metier_id" required
                class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez un métier</option>
            @foreach($metiers as $m)
                <option value="{{ $m->id }}">{{ $m->nom }}</option>
            @endforeach
        </select>
    </div>

<div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="niveauetude_id">
            Sélectionner un niveau d'etude
        </label>
        <select wire:model="niveau" id="niveau_etude_id" wire:change="$refresh" name="niveau_etude_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez un niveau d'etude</option>
            @foreach($niveaux as $niv)
                <option value="{{ $niv->id }}">{{ $niv->nom }}</option>
            @endforeach
        </select>
    </div>
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

    @if(!empty($competences))
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="element">
            Sélectionner un ou plusieurs éléments de compétence
        </label>
        <select id="element" name="element[]" multiple required
                class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            @foreach($elements as $elt)
                <option value="{{ $elt->id }}">{{ $elt->nom }}</option>
            @endforeach
        </select>
    </div>
@endif
</div>
