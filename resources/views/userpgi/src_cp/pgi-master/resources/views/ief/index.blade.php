<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('IEF') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:Ief.ListeIef/>
    </div>

</x-app-layout>
