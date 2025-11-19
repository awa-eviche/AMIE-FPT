<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des établissements') }}
        </h2>
    </x-slot>


    <div class="container p-2 rounded">
        <livewire:etablissements.liste-etablissement/>
    </div>

</x-app-layout>
