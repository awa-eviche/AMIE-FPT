<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Filière') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:parametrage.Filiere.ListeFiliere/>
    </div>

</x-app-layout>
