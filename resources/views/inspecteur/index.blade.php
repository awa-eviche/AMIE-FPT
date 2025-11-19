<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Inspecteurs') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:Inspecteur.ListeInspecteur/>
    </div>

</x-app-layout>
