<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvel élément de compétence (ajout multiple)') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{ route('elementcompetence.index') }}" class="text-maquette">Accueil</a>
            <span class="mx-2 text-maquette">/</span>
            <a href="{{ route('elementcompetence.index') }}" class="text-maquette">Référentiel</a>
            <span class="mx-2 text-maquette">/</span>
            <a href="{{ route('elementcompetence.index') }}" class="text-maquette">Élément de Compétence</a>
            <span class="mx-2 text-maquette">/</span>
        </p>
        <p class="text-first-orange">Ajout multiple</p>
    </div>

    <div class="bg-white p-4 rounded shadow mx-auto max-w-6xl">
        <!-- Champs fixes -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label>Métier</label>
                <select wire:model="metier_id" wire:change="$refresh"
                        class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 enlever_shadow" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($metiers as $m)
                        <option value="{{ $m->id }}">{{ $m->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Niveau d’étude</label>
                <select wire:model="niveau_etude_id" wire:change="$refresh"
                        class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 enlever_shadow" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($niveaux as $n)
                        <option value="{{ $n->id }}">{{ $n->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Compétence</label>
                <select wire:model="competence_id" wire:change="$refresh"
                        class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 enlever_shadow" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($competences as $c)
                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Lignes dynamiques -->
        @foreach($rows as $index => $row)
            <div class="border border-gray-300 p-4 mb-4 rounded bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label>Code</label>
                        <input type="text" wire:model="rows.{{ $index }}.code" required
                               class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 enlever_shadow">
                    </div>

                    <div>
                        <label>Nom</label>
                        <input type="text" wire:model="rows.{{ $index }}.nom" required
                               class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 enlever_shadow">
                    </div>

                    <div>
                        <label>Description</label>
                        <input type="text" wire:model="rows.{{ $index }}.description" required
                               class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 enlever_shadow">
                    </div>
                </div>

                <div class="text-right mt-2">
                    <button type="button" wire:click="removeRow({{ $index }})"
                            class="text-red-500 text-sm font-bold">Supprimer</button>
                </div>
            </div>
        @endforeach

        <div class="flex justify-between">
            <button type="button" wire:click="addRow"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                + Ajouter une ligne
            </button>

            <button type="button" wire:click="submit"
                    class="bg-first-orange hover:bg-orange-700 text-white font-bold py-2 px-6 rounded">
                Enregistrer tous
            </button>
        </div>
    </div>

    </div>
