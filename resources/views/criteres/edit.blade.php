<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier un critère') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-transparent shadow rounded-sm w-full p-4">

        {{-- Lien de retour --}}
        <div class="mt-2 mb-4">
            <a href="{{ route('critere.index') }}" class="text-blue-500 hover:underline">
                &larr; Retour à la liste des  seuil de réussite
            </a>
        </div>

        {{-- Fil d’Ariane --}}
        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
            <p>
                <a href="/dashboard" class="text-maquette-black">Accueil</a>
                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p>
                <a href="{{ route('critere.index') }}" class="text-maquette-black"> Seuil de réussite</a>
                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p class="text-first-orange">Modifier</p>
        </div>

        {{-- Contenu principal --}}
        <div class="border border-gray-200 bg-white rounded-sm">
        

            <div class="p-5">
                {{-- Intégration du composant Livewire --}}
                @livewire('param.edit-critere', ['id' => $critere->id])
            </div>
        </div>
    </div>
</x-app-layout>
