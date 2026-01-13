<div>

    <div class="w-full mr-4 border bg-gray-100 shadow p-2 rounded">

        {{-- HEADER --}}
        <div class="flex w-1/5 items-center p-2 my-2 bg-white rounded-md">
            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"/>
                </svg>
            </div>

            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Etablissement</p>
                <p class="text-lg font-semibold text-gray-700">
                    <span class="siffre" style="color:rgba(227, 142, 24, 1);">{{ $count }}</span>
                </p>
            </div>
        </div>

        {{-- BOUTON TOUS --}}
        <div class="w-1/6 flex items-center">
            <p wire:click="resetAll" class="border-2 flex items-center font-bold bg-first-orange rounded py-1 px-3 text-sm cursor-pointer text-white">
                Tous
            </p>
        </div>

        {{-- FILTRES LIGNE 1 --}}
        <div class="flex justify-between items-center bg-gray-100">

            {{-- Region --}}
            <div class="flex items-baseline my-2 w-full">
                <select wire:model="selectedRegion"  wire:change="$refresh" class="border border-gray-300 p-3 w-full rounded text-sm font-bold">
                    <option value="">Choisir une Région</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->libelle }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Département --}}
            <div class="flex items-baseline my-2 w-full">
                <select wire:model="selectedDepartemant" wire:change="$refresh" class="border border-gray-300 p-3 w-full rounded text-sm font-bold">
                    <option value="">Choisir un Département</option>
                    @foreach ($departements as $departement)
                        <option value="{{ $departement->id }}">{{ $departement->libelle }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Commune --}}
            <div class="flex items-baseline my-2 w-full">
                <select wire:model="selectedCommune" wire:change="$refresh" class="border border-gray-300 p-3 w-full rounded text-sm font-bold">
                    <option value="">Choisir une Commune</option>
                    @foreach ($communes as $commune)
                        <option value="{{ $commune->id }}">{{ $commune->libelle }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- FILTRES LIGNE 2 --}}
        <div class="flex justify-between items-center">

            {{-- IA --}}
            <div class="flex items-baseline my-2 w-full">
                <select wire:model="selectedIA" wire:change="$refresh" class="border border-gray-300 p-3 w-full rounded text-sm font-bold">
                    <option value="">Choisir une IA</option>
                    @foreach ($ias as $ia)
                        <option value="{{ $ia->id }}">{{ $ia->nom }}</option>
                    @endforeach
                </select>
            </div>

            {{-- IEF --}}
            <div class="flex items-baseline my-2 w-full">
                <select wire:model="selectedIef" wire:change="$refresh" class="border border-gray-300 p-3 w-full rounded text-sm font-bold">
                    <option value="">Choisir une IEF</option>
                    @foreach ($iefs as $ief)
                        <option value="{{ $ief->id }}">{{ $ief->nom }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Métier --}}
            <div class="flex items-baseline my-2 w-full">
                <select wire:model="selectedMetier" wire:change="$refresh" class="border border-gray-300 p-3 w-full rounded text-sm font-bold">
                    <option value="">Choisir un métier</option>
                    @foreach ($metiers as $m)
                        <option value="{{ $m->id }}">{{ $m->nom }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- FILTRES LIGNE 3 --}}
        <div class="flex justify-between items-center">

            {{-- Niveau --}}
            <div class="flex items-baseline my-2 w-full">
                <select wire:model="selectedNiveau" wire:change="$refresh" class="border border-gray-300 p-3 w-full rounded text-sm font-bold">
                    <option value="">Choisir un Niveau</option>
                    @foreach ($niveaux as $niveau)
                        <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Classe --}}
            <div class="flex items-baseline my-2 w-full">
                <select wire:model="selectedClasse" wire:change="$refresh" class="border border-gray-300 p-3 w-full rounded text-sm font-bold">
                    <option value="">Choisir une Classe</option>
                    @foreach ($classes as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->libelle }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filière --}}
            <div class="flex items-baseline my-2 w-full">
                <select wire:model="selectedFiliere" wire:change="$refresh" class="border border-gray-300 p-3 w-full rounded text-sm font-bold">
                    <option value="">Choisir une Filière</option>
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- TABLEAU --}}
        <div class="p-2 w-full bg-white">

        <table class="w-full mb-3">
                <thead>
                    <tr
                        class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold border-b">
                        {{-- <th class="px-4 py-3">N° </th> --}}
                        <th class="px-1 text-gray-800">Nom</th>
                        <th class="px-1 text-gray-800">Email</th>
                        <th class="px-1 text-gray-800">Commune</th>
                        <th class="px-1 text-gray-800">type</th>
                        <th class="px-1 text-gray-800">Réference</th>
                        
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
    @foreach ($etablissements as $etablissement)
        <tr class="text-gray-700">
            <td class="p-2 border-b text-gray-500">
                {{ $etablissement->nom ?? '-' }}
            </td>
            <td class="p-2 border-b text-gray-500">
                {{ $etablissement->email ?? '-' }}
            </td>
            <td class="p-2 border-b text-gray-500">
                {{ $etablissement->nameCommune ?? '-' }}
            </td>
            <td class="p-2 border-b text-gray-500">
                {{ $etablissement->type ?? '-' }}
            </td>
            <td class="p-2 border-b text-gray-500">
                {{ $etablissement->reference ?? '-' }}
            </td>
        </tr>
    @endforeach
</tbody>

            </table>

            {{-- PAGINATION À L’INTERIEUR POUR EVITER PAGE NOIRE --}}
            @if ($etablissements->total() > $etablissements->perPage())
    <div class="mt-3">
        {{ $etablissements->links() }}
    </div>
@endif

        </div>

    </div>
  
</div>
