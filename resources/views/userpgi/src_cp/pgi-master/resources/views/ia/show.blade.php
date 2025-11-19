<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Ias') }}
        </h2>
    </x-slot>

    
    <livewire:Ia.detail-ia :ia="$ia"/>


</x-app-layout>
