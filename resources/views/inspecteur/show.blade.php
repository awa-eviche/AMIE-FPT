<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{--    {{ __('Données de l\'inspecteur') }}  --}}
        </h2>
    </x-slot>

    <livewire:Inspecteur.detailInspecteur :id="$id" :user="$user" :inspecteur="$inspecteur"  />


</x-app-layout>
