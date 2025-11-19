<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __("Liste des apprenants") }}
        </h2>
    </x-slot>

    {{-- <livewire:etablissements.info-etablissement  :etablissement="$etablissement"  /> --}}
    @livewire('etablissements.get-all-apprenant')


</x-app-layout>
