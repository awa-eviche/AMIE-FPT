
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Création de l\'évaluation du premier semestre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('evaluation.store', ['inscriptionId' => $inscription->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="inscription_id" value="{{ $inscription->id }}">
                        
                        <input type="hidden" name="matiere_id" value="{{ $matiere->id }}">


                        <input type="hidden" name="semestre" value="{{ Session::get('selectedsemestre') }}">

                   
                        <div class="flex flex-wrap w-full justify-evenly">
                            <div class="flex-grow mb-4 mr-2">
                                <label for="note_cc" class="block text-sm font-bold text-gray-700">Note Contrôle Continu:</label>
                                <input type="text" name="note_cc" id="note_cc" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                            </div>

                            <div class="flex-grow mb-4 mr-2">
                                <label for="note_composition" class="block text-sm font-bold text-gray-700">Note Composition:</label>
                                <input type="text" name="note_composition" id="note_composition" class="form-input rounded-md shadow-sm mt-1 block w-full" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
