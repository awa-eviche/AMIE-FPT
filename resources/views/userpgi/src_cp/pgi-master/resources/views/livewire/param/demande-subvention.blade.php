<div class="w-full">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="mb-4">
            <x-label for="annee_academique_id" class="font-semibold text-black">
                Année académique <span class="text-red-500">*</span>
            </x-label>
            <select wire:model="entry.annee_academique_id" wire:change="onAnneeAcademiqueChange" wire:ignore class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="annee_academique_id">
                <option value="">Choisir une année académique</option>
                @foreach($anneeAcademiqueBDs as $a)
                <option value="{{$a->id}}" wire:key="{{ $a->id }}">{{ $a['annee1'] . ' - '. $a['annee2']}}</option>
                @endforeach
            </select>
            @error('anneeAcademiqueBD')
            <span class="text-xs text-red-500">
                {{$message}}
            </span>
            @enderror
        </div>
    </div>
</div>