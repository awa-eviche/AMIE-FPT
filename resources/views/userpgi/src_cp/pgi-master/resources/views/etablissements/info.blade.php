<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{--    {{ __('Données de l\'établissement') }}  --}}
        </h2>
    </x-slot>

    <livewire:etablissements.info-etablissement  :etablissement="$etablissement"  />


</x-app-layout>
