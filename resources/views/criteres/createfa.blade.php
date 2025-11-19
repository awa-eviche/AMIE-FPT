<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un critère') }}
        </h2>
    </x-slot>

    <div class="bg-transparent shadow rounded-sm w-full p-4">

        <div class="mt-2 mb-2">
            <a href="{{ route('critere.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des critères</a>
        </div>
        <div class="w-full mx-auto">
            <form class="bg-white pt-6 pb-8 mb-4" action="{{ route('critere.store') }}" method="POST">
                @csrf
                <div class="md:container md:mx-auto">

                    <div class="w-full sm:px-2 lg:px-4 ">
                        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
                            <p>
                                <a href="/dashboard" class="text-maquette-black">Accueil</a>
                                  <span class="mx-2 text-maquette-gris">/</span>
                            </p><p> <a href="{{route('critere.index')}}">Critères</a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p class="text-first-orange">Ajouter</p>
                            <p></p>
                        </div>
                        <div class="border border-gray-200">
                            <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                Formulaire d'ajout
                            </h3>
                            <div class="p-5">
                            @livewire('param.CreateCritere')
                            <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Code<span class="text-red-600 mx-2">*</span></label>
                                        <input type="text" value="{{ old('code') ?? ''}}" required class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="code" name="code" >
                                        @error('code')
                                            {{$message}}
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="libelle" class="block text-gray-700 text-sm font-bold mb-2">Seuil de Reussite<span class="text-red-600 mx-2">*</span></label>
                                        <input type="text" value="{{ old('libelle') ?? ''}}" required class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="libelle" name="libelle" >
                                        @error('libelle')
                                            {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                        <textarea class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" name="description" id="description" cols="10" rows="5"></textarea>
                                        @error('description')
                                            {{$message}}
                                        @enderror
                                    </div>
                                </div>
                        </div>
                        <button type="submit" class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
