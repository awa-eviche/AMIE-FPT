<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Matière') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:parametrage.Matiere.ListeMatiere/>
    </div>

</x-app-layout>
