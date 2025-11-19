<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Compléter Demande') }}
        </h2>
    </x-slot>

    <livewire:demandes.new-demande :typeDemande="$demande->typeDemande" :gotDemande="$demande"/>
</x-app-layout>
