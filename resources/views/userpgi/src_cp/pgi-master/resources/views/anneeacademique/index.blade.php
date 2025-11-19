<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Annee Academique') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:AnneeAcademiques.ListeAnnee/>
    </div>

</x-app-layout>
