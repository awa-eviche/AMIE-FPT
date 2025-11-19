<div class="relative shadow border-gray-100 mb-5 p-4 text-sm rounded-sm">
    <div wire:loading class="absolute h-full w-full flex items-center justify-center space-x-2 bg-gray-100">
        <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
        <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
        <div class="w-4 h-4 rounded-full animate-pulse bg-first-orange"></div>
    </div>
    <form wire:submit.prevent="saveModification" >
        <div class="p-2 m-3 mb-3 p-3 shadow ">
            <div class="mb-6">

                <x-label for="newDocument.libelle" value="{{ __('Label') }}" />
                <input wire:model="newDocument.libelle" type="text" class="block mt-1 w-full border-gray-300 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm m-1" required autocomplete="newDocument.libelle">
                @error('newDocument.libelle')
                    <span class="text-xs text-red-500">
                        {{$message}}

                    </span>
                @enderror
            </div>
            <div>
                <x-label for="description" value="{{ __('Description') }}" />
                <x-input wire:model="newDocument.description" id="description" class="block mt-1 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" type="text" required autofocus autocomplete="newDocument.description" />
                @error('newDocument.description')
                    <span class="text-xs text-red-500">
                        {{$message}}

                    </span>
                @enderror
            </div>

        </div>
        <button class="bg-first-orange p-1 px-2 text-white font-bold rounded-sm" type="submit">Modifier</button>
    </form>
</div>
