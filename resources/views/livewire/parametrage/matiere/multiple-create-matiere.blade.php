<div class="p-6 bg-white shadow rounded">
    @if (session()->has('message'))
        <div class="mb-4 text-green-600 font-bold">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="enregistrer">
        <!-- Métier -->
        <div class="mb-4">
            <x-label for="metier">Métier</x-label>
            <select wire:model="metier" class="w-full border-2 rounded py-1 px-2" wire:change="$refresh">
                <option value="">-- Sélectionner un métier --</option>
                @foreach ($metiers as $metierItem)
                    <option value="{{ $metierItem->id }}">{{ $metierItem->nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Niveau -->
        @if (!empty($niveaux))
            <div class="mb-4">
                <x-label for="niveau">Niveau</x-label>
                <select wire:model="niveau" class="w-full border-2 rounded py-1 px-2" wire:change="$refresh">
                    <option value="">-- Sélectionner un niveau --</option>
                    @foreach ($niveaux as $nivo)
                        <option value="{{ $nivo->id }}">{{ $nivo->nom }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Description -->
        <div class="mb-4">
            <x-label for="description">Description</x-label>
            <textarea wire:model="description" class="w-full border-2 rounded py-1 px-2" rows="3" required></textarea>
        </div>

        <!-- Lignes de matières -->
        <h4 class="font-bold text-first-orange mb-2">Matières</h4>

        @foreach ($matieres as $index => $matiere)
            <div class="flex flex-wrap gap-2 items-end mb-4">
                <div class="w-full md:w-1/4">
                    <x-label>Code</x-label>
                    <x-input type="text" wire:model="matieres.{{ $index }}.code" class="w-full" required />
                </div>
                <div class="w-full md:w-1/4">
                    <x-label>Nom</x-label>
                    <x-input type="text" wire:model="matieres.{{ $index }}.nom" class="w-full" required />
                </div>
                <div class="w-full md:w-1/4">
                    <x-label>Coefficient</x-label>
                    <x-input type="number"  step="0.01" wire:model="matieres.{{ $index }}.coef" class="w-full" required />
                </div>
                <div>
                    <button type="button" wire:click="supprimerMatiere({{ $index }})" class="text-red-600 text-xl">×</button>
                </div>
            </div>
        @endforeach

        <button type="button" wire:click="ajouterMatiere" class="mb-4 bg-blue-500 text-white px-4 py-1 rounded">+ Ajouter une matière</button>

        <div class="text-right">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Enregistrer</button>
        </div>
    </form>
</div>
