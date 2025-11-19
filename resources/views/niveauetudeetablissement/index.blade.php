<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Programme de formation') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:NiveauEtudeEtablissements.ListeNiveauEtudeEtablissement/>
    </div>

</x-app-layout>
