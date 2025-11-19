<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Type Survey') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold"style="position:relative;left:1%">
        
        <p> 
            <a href="{{route('typeIndicateur.index')}}" >Type survey</a>
            
            <span class="mx-2 text-maquette-gris">/</span>
        </p>

        <p class="text-first-orange">Liste type survey </p>
        </p>
        </div>

    <div class="mx-auto">
        <livewire:Parametrage.typeindicateur.ListeTypeIndicateur/>
    </div>

</x-app-layout>

