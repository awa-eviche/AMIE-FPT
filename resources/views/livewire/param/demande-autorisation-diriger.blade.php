<div class="w-full">
<h2>Nouveau Directeur Technique (ou des études) </h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="mb-4">
        <x-label for="nom">
            Nom <span class="text-red-500">*</span>
        </x-label>
        <x-input  wire:model="entry.nom" wire:blur="onBlur" id="nom"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nom" :value="old('nom')" autocomplete="nom" />
        @error('nom')
        <span class="text-xs text-red-500">
            {{$message}}
        </span>
        @enderror
    </div>

    <div class="mb-4">  
        <x-label for="prenom">
            Prénom <span class="text-red-500">*</span>
        </x-label>
        <x-input  wire:model="entry.prenom" wire:blur="onBlur" id="prenom"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenom" :value="old('prenom')"  autocomplete="prenom" />
        @error('prenom')
        <span class="text-xs text-red-500">
            {{$message}}
        </span>
        @enderror
    </div>
</div>
</div>