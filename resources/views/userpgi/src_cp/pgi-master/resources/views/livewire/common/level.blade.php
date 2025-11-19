<root class="w-full">
    <div class="flex-grow mb-4 mr-2">
        <label for="selectedSecteur">Sélectionner un secteur:</label>
        <select  id="selectedSecteur" wire:model="selectedSecteur" wire:change="$refresh" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2"  name="selectedSecteur">
            <option value="">Choisir un secteur</option>
            @foreach($secteurs as $secteur)
            <option value="{{ $secteur->id }}">{{ $secteur->libelle}}</option>
            @endforeach
        </select>
    </div>
    <div class="flex-grow mb-4 mr-2">
        <label for="selectedFiliere">Sélectionner une filière :</label>
        <select id="selectedFiliere" wire:model="selectedFiliere" wire:change="$refresh"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2" name="selectedFiliere">
            <option value="">Choisir une filière</option>
            @foreach($filieres as $filiere)
            <option value="{{ $filiere->id }}">{{ $filiere->nom}}</option>
            @endforeach
        </select>
    </div>
    <div class="flex-grow mb-4 mr-2">
        <label for="selectedMetier">Sélectionner un métier:</label>
        <select  id="selectedMetier" wire:model="selectedMetier" wire:change="$refresh" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2"  name="selectedMetier">
            <option value="">Choisir un métier</option>
            @foreach($metiers as $metier)
            <option value="{{ $metier->id }}">{{ $metier->nom}}</option>
            @endforeach
        </select>
    </div>

    <div class="flex-grow mb-4 mr-2">
        <label for="selectedNiveau">Sélectionner un niveau:</label>
        <select  id="selectedNiveau" wire:model="selectedNiveau"  wire:change="$refresh" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2"  name="selectedNiveau">
            <option value="">Choisir un niveau</option>
            @foreach($niveauetudes as $niveauetude)
            <option value="{{ $niveauetude->id }}">{{ $niveauetude->nom}}</option>
            @endforeach
        </select>
    </div>
</root>