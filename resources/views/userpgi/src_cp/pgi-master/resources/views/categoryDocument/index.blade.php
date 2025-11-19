<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Dossiers') }}
        </h2>
    </x-slot>

    <div class="">
        

        @livewire('ListCategory')

    </div>
</x-app-layout>
