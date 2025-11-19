<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des regions') }}
        </h2>
    
    </x-slot>


    <livewire:regions.detail-region :region="$region"/>


</x-app-layout>
