<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvel Demandes') }}
        </h2>
    </x-slot>
    <div class="flex mb-4 text-sm font-bold">
        <p>
            <a href="{{route("demande.index")}}"  class="text-maquette-gris">Liste des demandes</a>
        </p>
        <span class="mx-2 text-maquette-gris">/</span>

        <p class="text-first-orange">Edit</p>
    </div>
    <livewire:demandes.edit-demande :demande="$demande"/>

</x-app-layout>
