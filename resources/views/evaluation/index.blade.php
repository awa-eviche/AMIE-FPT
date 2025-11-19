<x-app-layout>
  

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Evaluation') }}
        </h2>
    </x-slot>

    <div class="mx-auto">
    <livewire:Evaluation.ListeEvaluation/>
    </div>

</x-app-layout>
