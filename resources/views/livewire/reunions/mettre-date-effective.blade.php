<div>
    <div class="mt-4 mb-2 flex">
        <div class="w-1/3 flex items-end justify-end pr-2">
            <strong class="text-black">date effective :</strong>
        </div>
        @if ($reunion->date_effective ||
            // $reunion->etat == App\Enums\ReunionEtatEnum::TRANSMISE ||
            $reunion->etat == App\Enums\ReunionEtatEnum::PREPARATION)
            <div class="w-2/3">
                <span class="text-maquette-gris">{{date('d-m-Y',strtotime($reunion->date_effective) ?? " ")}}</span>

            </div>
        @else
            <div class="">
                <button class="bg-green-200 hover:bg-green-300 hover:shadow-xl text-green-900 rounded px-3 py-1 text-bold" wire:click="toggleIsModifying">Renseigner</button>
            </div>
        @endif
    </div>
    @if ($isModifying)
        <div class="text-center mt-2">
            <x-input wire:model="dateEffective" id="dateEffective" class="block mx-auto focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 w-96" type="date" name="dateEffective" :value="old('dateEffective')" autofocus autocomplete="dateEffective" />
            @error('dateEffective')
                <span class="text-xs text-red-500 block mt-1">
                    {{$message}}
                </span>
            @enderror
        </div>

        <div class="flex justify-end my-3">
            <button class ="mr-3 bg-red-800 text-white px-3 py-1 rounded hover:bg-red-900 hover:shadow-xl" wire:click="toggleIsModifying">Annuler</button>
            <button class="bg-green-800 text-white px-3 py-1 rounded hover:bg-green-900 hover:shadow-xl" wire:click="changerDateEffective">Valider</button>

        </div>
    @endif
</div>
