<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{--    {{ __('Données de l\'établissement') }}  --}}
        </h2>
    </x-slot>

    <!-- <div class="flex mb-4 text-sm font-bold">
        <p>
            <a href="{{route("etablissement.index")}}"  class="text-maquette-gris">Liste des etablissements</a>
        </p>
        <span class="mx-2 text-maquette-gris">/</span>
        <p class="text-first-orange">Détail etablissement</p>
    </div> -->

    <livewire:etablissements.detail-etablissement :id="$id"  :etablissement="$etablissement"  />


</x-app-layout>
