<div>
    <!-- Région (sur toute la ligne) -->
    <div class="flex flex-wrap">
        <div class="w-full  px-2 pb-5">
            <label for="region" class="block text-gray-700 text-sm font-bold mb-2">
                Région <span class="text-red-600">*</span>
            </label>
            <select value="{{ old('region') ?? '' }}" wire:model="region" wire:change="loadDepartements()"
                class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 "
                id="region" name="region">
                <option value="">Sélectionner la région</option>
                @foreach ($regions ?? [] as $region)
                    <option value="{{ $region->id }}">{{ $region->libelle }}</option>
                @endforeach
            </select>
            @error('region')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Département et Commune (sur une seule ligne, côte à côte) -->
    <div class="flex flex-wrap">
        <!-- Département -->
        <div class="w-full sm:w-1/2 px-2 pb-5">
            <label for="departement" class="block text-gray-700 text-sm font-bold mb-2">
                Département <span class="text-red-600">*</span>
            </label>
            <select value="{{ old('departement') ?? '' }}" wire:model="departement" wire:change="loadCommunes()"
                class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 "
                id="departement" name="departement">
                <option value="">Sélectionner le département</option>
                @foreach ($departements ?? [] as $dep)
                    <option value="{{ $dep->id }}">{{ $dep->libelle }}</option>
                @endforeach
            </select>
            @error('departement')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <!-- Commune -->
        <div class="w-full sm:w-1/2 px-2 pb-5">
            <label for="commune_id" class="block text-gray-700 text-sm font-bold mb-2">
                Commune <span class="text-red-600">*</span>
            </label>
            <select value="{{ old('commune_id') ?? '' }}" wire:model="commune"
                class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 "
                id="commune_id" name="commune_id">
                <option value="">Sélectionner la commune</option>
                @foreach ($communes ?? [] as $com)
                    <option value="{{ $com->id }}">{{ $com->libelle }}</option>
                @endforeach
            </select>
            @error('commune_id')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
