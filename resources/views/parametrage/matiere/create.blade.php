<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajout multiple de matières') }}
        </h2>
    </x-slot>

    <!-- Fil d’Ariane -->
    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{ route('matiere.index') }}" class="text-maquette">Accueil</a>
            <span class="mx-2 text-maquette">/</span>
            <a href="{{ route('matiere.index') }}" class="text-maquette">Référentiel</a>
            <span class="mx-2 text-maquette">/</span>
            <a href="{{ route('matiere.index') }}">Matière</a>
            <span class="mx-2 text-maquette">/</span>
            <span class="text-first-orange">Ajout Multiple</span>
        </p>
    </div>

    <!-- Composant Livewire -->
    <div class="max-w-5xl mx-auto mt-6">
        @livewire('parametrage.matiere.multiple-create-matiere')
    </div>
</x-app-layout>
