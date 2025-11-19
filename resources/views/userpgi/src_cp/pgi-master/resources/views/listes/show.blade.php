<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des listes') }}
        </h2>
    </x-slot>


    <livewire:listes.detail-liste :liste="$liste"/>


</x-app-layout>
