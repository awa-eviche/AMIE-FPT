<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier un Métier') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <a href="{{ route('metier.index') }}" class="text-maquette">Accueil</a>
        <span class="mx-2 text-maquette">/</span>
        <a href="{{ route('metier.index') }}" class="text-maquette">Référentiel</a>
        <span class="mx-2 text-maquette">/</span>
        <a href="{{ route('metier.index') }}">Métier</a>
        <span class="mx-2 text-maquette">/</span>
        <p class="text-first-orange">Modifier Métier</p>
    </div>

    <div class="rounded-sm w-full">
        <div class="mx-auto max-w-5xl shadow-xl rounded">
            <form action="{{ route('metier.update', $metier->id) }}" method="POST" 
                  class="bg-white border-x-2 rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                @method('PUT')

                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                    Modification d'un métier
                </h3>

                <div class="border border-gray-200 p-4">
                    <div class="flex flex-wrap w-full justify-evenly">
                        {{-- Code --}}
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="code">Code <span class="text-red-500">*</span></x-label>
                            <x-input id="code" type="text" name="code" 
                                     class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2"
                                     value="{{ old('code', $metier->code) }}" required />
                            @error('code')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Nom --}}
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="nom">Nom <span class="text-red-500">*</span></x-label>
                            <x-input id="nom" type="text" name="nom" 
                                     class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2"
                                     value="{{ old('nom', $metier->nom) }}" required />
                            @error('nom')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Filière --}}
                    <div class="mb-4">
                        <x-label for="filiere_id">Sélectionner une filière :</x-label>
                        <select id="filiere_id" name="filiere_id"
                            class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline enlever_shadow">
                            <option value="">Choisir une filière</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}" 
                                    {{ old('filiere_id', $metier->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                    {{ $filiere->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Modalité --}}
                    <div class="mb-4">
                        <x-label for="modalite">Modalité :</x-label>
                        <select id="modalite" name="modalite"
                            class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline enlever_shadow">
                            <option value="">Choisir une modalité</option>
                            <option value="APC" {{ old('modalite', $metier->modalite) == 'APC' ? 'selected' : '' }}>APC</option>
                            <option value="PPO" {{ old('modalite', $metier->modalite) == 'PPO' ? 'selected' : '' }}>PPO</option>
                        </select>
                    </div>

                    {{-- Statut programme --}}
                    <div class="mb-4">
                        <x-label for="statut_programme">Statut du programme :</x-label>
                        <select id="statut_programme" name="statut_programme"
                            class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline enlever_shadow">
                            <option value="">Choisir un statut</option>
                            <option value="achevé" {{ old('statut_programme', $metier->statut_programme) == 'achevé' ? 'selected' : '' }}>Achevé</option>
                            <option value="révisé" {{ old('statut_programme', $metier->statut_programme) == 'révisé' ? 'selected' : '' }}>Révisé</option>
                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <x-label for="description">Description</x-label>
                        <textarea id="description" name="description" rows="4" required
                            class="shadow appearance-none border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline enlever_shadow">{{ old('description', $metier->description) }}</textarea>
                    </div>

                    {{-- Bouton submit --}}
                    <div class="flex items-center justify-end">
                        <button type="submit" class="flex items-center bg-first-orange hover:bg-cyan-700 text-white font-bold py-1 px-4 rounded focus:outline-none focus:shadow-outline">
                            <svg width="19" height="19" fill="white" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.6979 6.55208L12.4479 0.302083C12.3519 0.208384 12.2387 0.134107 12.1146 0.0833333C11.9854 0.030851 11.8477 0.00260216 11.7083 0H3.375C2.5462 0 1.75134 0.32924 1.16529 0.915291C0.57924 1.50134 0.25 2.2962 0.25 3.125V15.625C0.25 16.4538 0.57924 17.2487 1.16529 17.8347C1.75134 18.4208 2.5462 18.75 3.375 18.75H15.875C16.7038 18.75 17.4987 18.4208 18.0847 17.8347C18.6708 17.2487 19 16.4538 19 15.625V7.29167C19.0008 7.15458 18.9745 7.01868 18.9227 6.89176C18.8708 6.76485 18.7945 6.64942 18.6979 6.55208ZM6.5 2.08333H10.6667V4.16667H6.5V2.08333Z"/>
                            </svg>
                            <span class="ml-2 text-sm">Enregistrer</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
