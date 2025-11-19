<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="mb-4">
            <x-label for="filiere" class="font-semibold text-black">
                Filière <span class="text-red-500">*</span>
            </x-label>
            <select wire:model="filiere" wire:change="onFiliereChange" wire:ignore class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="filiere_id">
                <option value="">Chosir une filière</option>
                @foreach($filiereFromBD as $filiere)
                <option value="{{$filiere['id']}}" wire:key="{{ $filiere['id'] }}">{{ $filiere['nom'] }}</option>
                @endforeach
            </select>
            @error('filiere')
            <span class="text-xs text-red-500">
                {{$message}}
            </span>
            @enderror
        </div>

        <div class="mb-4">
            <x-label for="niveau" class="font-semibold text-black">
                Niveau <span class="text-red-500">*</span>
            </x-label>
            <select wire:model="niveau" wire:change="onNiveauChange" class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="niveau_id">
                <option value="">Choisir un niveau</option>
                @foreach($niveauFromBD as $niveau)
                <option value="{{$niveau->id}}" wire:key="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                @endforeach
            </select>
            @error('niveau')
            <span class="text-xs text-red-500">
                {{$message}}
            </span>
            @enderror
        </div>
        <div class="mb-4">
            <p wire:click="add" class="cursor-pointer w-20 flex items-center bg-first-orange mt-5 py-2 px-3 rounded text-white text-sm">
                <i class="fa fa-plus"></i>
                <span class="font-normal">
                    Ajouter
                </span>
            </p>
        </div>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-2">
        <table class="table-auto w-full">
            <thead>
                <tr class="bg-gray-100 text-gray-600 font-bold">
                    <th class="px-4 py-2 text-center">Filière</th>
                    <th class="px-4 py-2 text-center">Niveau</th>
                    <th class="px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
    @if(isset($datasets) && is_array($datasets))
        @php
            $num = 1;
        @endphp
        @foreach($datasets as $donnee)
            <tr>
                <td class="px-4 py-2 border border-gray-300 text-center text-black">
                    {{ isset($donnee['filiere']) && isset($donnee['filiere']['nom']) ? htmlspecialchars($donnee['filiere']['nom']) : 'Nom de filière non disponible' }}
                </td>
                <td class="px-4 py-2 border border-gray-300 text-center text-black">
                    {{ isset($donnee['niveau']) && isset($donnee['niveau']['nom']) ? htmlspecialchars($donnee['niveau']['nom']) : 'Nom de niveau non disponible' }}
                </td>
                <td class="px-4 py-2 border border-gray-300 text-center">
                    <i class="fa fa-trash text-orange-600" wire:click="remove({{ $num }})" style="cursor: pointer;"></i>
                </td>
            </tr>
            @php
                $num += 1;
            @endphp
        @endforeach
    @else
        <p>Aucune donnée disponible.</p>
    @endif
</tbody>




        </table>

    </div>
</div>