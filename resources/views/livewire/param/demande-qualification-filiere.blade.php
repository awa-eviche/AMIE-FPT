<div class="w-full">
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="mb-4">
        <x-label for="filiere">
            Filière <span class="text-red-500">*</span>
        </x-label>
        <x-input wire:model="entry.filiere" id="filiere" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="filiere" :value="old('filiere')" autocomplete="filiere" />
        @error('filiere')
        <span class="text-xs text-red-500">
            {{$message}}
        </span>
        @enderror
    </div>

    <div class="mb-4">
        <x-label for="niveau">
        Niveau <span class="text-red-500">*</span>
        </x-label>
        <x-input wire:model="entry.niveau" id="niveau" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="niveau" :value="old('niveau')" autofocus autocomplete="niveau" />
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
                @php
                $num = 1;
                @endphp
                @foreach($datasets as $donnee)
                <tr>
                    <td class="px-4 py-2 border border-gray-300 text-center">{{$donnee['filiere']}}</td>
                    <td class="px-4 py-2 border border-gray-300 text-center">{{$donnee['niveau']}}</td>
                    <td class="px-4 py-2 border border-gray-300 text-center"><i class="fa fa-trash text-orange-600" wire:click="remove({{ $num }})" style="cursor: pointer;"></i></td>
                </tr>
                @php
                $num += 1;
                @endphp
                @endforeach
            </tbody>
        </table>

    </div>
</div>