<div class="w-full">
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="mb-4">
        <x-label for="ancienne_denomination_etablissement">
            Ancienne dénomination de l'établissement <span class="text-red-500">*</span>
        </x-label>
        <x-input wire:model="entry.ancienne_denomination_etablissement"  wire:blur="onBlur" id="ancienne_denomination_etablissement" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="ancienne_denomination_etablissement" :value="old('ancienne_denomination_etablissement')" autocomplete="ancienne_denomination_etablissement" />
        @error('ancienne_denomination_etablissement')
        <span class="text-xs text-red-500">
            {{$message}}
        </span>
        @enderror
    </div>

    <div class="mb-4">
        <x-label for="nouvelle_denomination_etablissement">
        Nouvelle dénomination de l'établissement <span class="text-red-500">*</span>
        </x-label>
        <x-input wire:model="entry.nouvelle_denomination_etablissement"  wire:blur="onBlur" id="nouvelle_denomination_etablissement" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nouvelle_denomination_etablissement" :value="old('nouvelle_denomination_etablissement')" autofocus autocomplete="nouvelle_denomination_etablissement" />
        @error('nouvelle_denomination_etablissement')
        <span class="text-xs text-red-500">
            {{$message}}
        </span>
        @enderror
    </div>
</div>
</div>