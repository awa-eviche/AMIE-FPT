<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sélection de la classe
        </h2>
    </x-slot>

    <div class="p-4 max-w-4xl mx-auto">
        @livewire('reinscription.liste-admis')
    </div>
</x-app-layout>
