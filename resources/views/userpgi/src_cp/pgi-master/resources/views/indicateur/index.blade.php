<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des indicateurs') }}
        </h2>
    </x-slot>

    <div class="container p-2 rounded">
        @livewire('Indicateur.ListeIndicateur')
        
    </div>
</x-app-layout>
