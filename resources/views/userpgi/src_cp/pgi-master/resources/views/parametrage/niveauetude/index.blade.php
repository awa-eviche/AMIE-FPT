<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Niveau d\'étude') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:parametrage.NiveauEtude.ListeNiveauEtude/>
    </div>

</x-app-layout>
