<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Competence') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:parametrage.Competence.ListeCompetence/>
    </div>

</x-app-layout>
