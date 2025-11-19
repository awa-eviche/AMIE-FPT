<div>
    <!-- Sélection du métier -->
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="metier">
            Sélectionner un métier
        </label>
        <select wire:model="metier" id="metier_id" name="metier_id" wire:change="$refresh" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
            <option value="">Sélectionnez un métier</option>
            @foreach($metiers as $metierItem)
                <option value="{{ $metierItem->id }}" {{ $metier == $metierItem->id ? 'selected' : '' }}>
                    {{ $metierItem->nom }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Sélection du niveau -->
    @if(!empty($niveauEtudes))
    <div class="mb-4 mx-auto w-full">
        <label class="block text-gray-700 text-sm font-bold" for="niveau">
            Sélectionner un niveau d’étude
        </label>
        <select wire:model="niveau" id="niveau" wire:change="$refresh" class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700">
            <option value="">Sélectionnez un niveau d’étude</option>
            @foreach($niveauEtudes as $niveauEtude)
                <option value="{{ $niveauEtude->id }}" {{ $niveau == $niveauEtude->id ? 'selected' : '' }}>
                    {{ $niveauEtude->nom }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

    <!-- Sélection de la compétence -->
    @if(!empty($competences))
        <!-- Champs cachés pour soumission dans le formulaire principal -->
        <input type="hidden" name="metier_id" value="{{ $metier }}">
        <input type="hidden" name="niveau_etude_id" value="{{ $niveau }}">

        <div class="mb-4 mx-auto w-full">
            <label class="block text-gray-700 text-sm font-bold" for="competence_id">
                Sélectionner une compétence
            </label>
            <select id="competence_id" name="competence_id" required class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline enlever_shadow">
                <option value="">Sélectionnez une compétence</option>
                @foreach($competences as $comp)
                    <option value="{{ $comp->id }}" {{ $competence == $comp->id ? 'selected' : '' }}>
                        {{ $comp->nom }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif
</div>
