<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvelle compétence') }}
        </h2>
    </x-slot>

    {{-- Fil d’Ariane --}}
    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <a href="{{ route('competence.index') }}" class="text-maquette">Accueil</a>
        <span class="mx-2 text-maquette">/</span>
        <a href="{{ route('competence.index') }}" class="text-maquette">Référentiel</a>
        <span class="mx-2 text-maquette">/</span>
        <a href="{{ route('competence.index') }}" class="text-maquette">Compétence</a>
        <span class="mx-2 text-maquette">/</span>
        <span class="text-first-orange">Nouvelle compétence</span>
    </div>

    <div class="mx-auto max-w-5xl shadow-xl rounded">
        <form action="{{ route('competence.store') }}" method="POST"
              class="bg-white border-x-2 rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                Création d’une compétence
            </h3>

            <div class="border border-gray-200 p-4">

                {{-- Bouton ajouter --}}
                <div class="mb-4">
                    <button type="button" id="add-row"
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                        + Ajouter une ligne
                    </button>
                </div>

                {{-- Lignes compétences --}}
                <div id="competence-rows">

                    <div class="flex flex-wrap w-full justify-evenly competence-row">

                        {{-- Code --}}
                        <div class="flex-grow mb-4 mr-2">
                            <x-label>Code <span class="text-red-500">*</span></x-label>
                            <x-input name="code[]" type="text"
                                     class="block w-full enlever_shadow rounded px-2 py-0.75 text-sm border-2 focus:border-first-orange"/>
                        </div>

                        {{-- Nom --}}
                        <div class="flex-grow mb-4 mr-2">
                            <x-label>Nom <span class="text-red-500">*</span></x-label>
                            <x-input name="nom[]" type="text"
                                     class="block w-full enlever_shadow rounded px-2 py-0.75 text-sm border-2 focus:border-first-orange"/>
                        </div>

                        {{-- Type --}}
                        <div class="flex-grow mb-4 mr-2">
                            <x-label>Type de compétence <span class="text-red-500">*</span></x-label>
                            <x-select name="type[]"
                                      class="block w-full enlever_shadow rounded px-2 py-0.75 text-sm border-2 focus:border-first-orange">
                                <option value="" selected hidden disabled>Sélectionner un type</option>
                                <option value="generale">Générale</option>
                                <option value="particuliere">Particulière</option>
                            </x-select>
                        </div>

                        {{-- supprimer --}}
                        <div class="flex items-end mb-4">
                            <button type="button"
                                    class="remove-row text-red-600 font-bold text-lg ml-2">
                                ×
                            </button>
                        </div>

                    </div>

                </div>

                {{-- Livewire --}}
                @livewire('parametrage.Competence.CreateCompetence')

                {{-- Description --}}
                <div class="mb-4">
                    <x-label for="description">Description</x-label>
                    <textarea id="description" name="description" rows="4" required
                              class="enlever_shadow shadow border-2 border-gray-400 rounded w-full py-2 px-3 text-gray-700 focus:border-first-orange"
                              placeholder="Description">{{ old('description') }}</textarea>
                </div>

            </div>

            {{-- Bouton enregistrer --}}
            <div class="flex items-center justify-end">
                <button type="submit"
                        class="flex items-center bg-first-orange hover:bg-cyan-700 text-white rounded px-4 py-1">
                    Enregistrer
                </button>
            </div>

        </form>
    </div>

</x-app-layout>

{{-- Script --}}
<script>

document.getElementById('add-row').addEventListener('click', function () {

    let container = document.getElementById('competence-rows');

    let row = document.querySelector('.competence-row').cloneNode(true);

    row.querySelectorAll('input').forEach(input => input.value = '');

    row.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

    container.appendChild(row);

});


document.addEventListener('click', function(e){

    if(e.target.classList.contains('remove-row')){

        let rows = document.querySelectorAll('.competence-row');

        if(rows.length > 1){
            e.target.closest('.competence-row').remove();
        }

    }

});

</script>