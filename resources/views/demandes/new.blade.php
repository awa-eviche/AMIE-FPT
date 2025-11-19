<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight border-solid border-2 border-first-orange bg-first-orange w-full">

            {{ __($typeDemande->libelle) }}
        </h2>
    </x-slot>

    <livewire:demandes.new-demande :typeDemande="$typeDemande"/>


</x-app-layout>
