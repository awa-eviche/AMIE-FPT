<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détail état') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route("workflow.index")}}"  class="text-maquette-gris">Liste des workflows</a>
        </p>
        <span class="mx-2 text-maquette-gris">/</span>
        <p>
            <a href="{{route("workflow.show", $etatWorkflow->workflow->id)}}"  class="text-first-orange">WF : {{$etatWorkflow->workflow->code}}</a>
        </p>
        <span class="mx-2 text-maquette-gris">/</span>
        <p class="text-first-orange">Détail etat</p>
    </div>

    <livewire:show-etat-workflow :etatWorkflow="$etatWorkflow"/>


</x-app-layout>

