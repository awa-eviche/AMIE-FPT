<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des entreprises') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold">
        <p>
            <a href="{{route("entreprise.index")}}"  class="text-maquette-gris">Liste des entreprises</a>
        </p>
        <span class="mx-2 text-maquette-gris">/</span>
        <p class="text-first-orange">Détail entreprise</p>
    </div>

    <livewire:entreprises.detail-entreprise :entreprise="$entreprise"/>


</x-app-layout>
