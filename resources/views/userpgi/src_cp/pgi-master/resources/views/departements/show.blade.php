<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des departements') }}
        </h2>
    </x-slot>


    <livewire:departements.detail-departement :departement="$departement"/>


</x-app-layout>
