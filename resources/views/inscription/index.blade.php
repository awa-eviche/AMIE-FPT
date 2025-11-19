<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestions des Evaluations PPO') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:Inscription.ListeInscription/>
    </div>

</x-app-layout>
