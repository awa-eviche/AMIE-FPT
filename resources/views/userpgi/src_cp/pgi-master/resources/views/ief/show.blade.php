<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des IEFs') }}
        </h2>
    </x-slot>

    
    <livewire:Ief.detail-ief :ief="$ief"/>


</x-app-layout>
