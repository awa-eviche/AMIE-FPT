<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Classe') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:Classe.ListeClasse/>
    </div>

</x-app-layout>
