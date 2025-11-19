<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des communes') }}
        </h2>
    </x-slot>

    
    <livewire:communes.detail-commune :commune="$commune"/>


</x-app-layout>
