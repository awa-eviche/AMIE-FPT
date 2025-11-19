<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Element de Compètence') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:parametrage.ElementCompetence.ListeElementCompetence/>
    </div>

</x-app-layout>
