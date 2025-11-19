<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Faire une evaluation') }}
        </h2>
    </x-slot>

    @section('stylesAdditionnels')
        @include('layouts.v1.partials.swal._style')
        <style>
            input[type='checkbox']{
                color: #16A34A;
            }
        </style>
    @endsection

    <div class="bg-transparent shadow rounded-sm w-full p-4">
        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm pl-4">
            <p>
                <a href="/dashboard" class="text-maquette-gris">Accueil</a>
                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p> <a href="{{route('classe.index')}}">Classes </a>

                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p> <a href="javascript:void(0);">Apprenants </a>

                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p> <a href="javascript:void(0);">Compétences </a>

                <span class="mx-2 text-maquette-gris">/</span>
            </p>
            <p class="text-first-orange">Evaluer </p>
            <p></p>
        </div>
        @hasanyrole(['agent','superadmin','responsable_technique'])
        <div class="mt-2 mb-2">
            <a href="{{ route('competence.manage.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la gestion de compétences</a>
        </div>
        @endhasanyrole
        @livewire('Apprenants.Competence.Evaluation',['inscription_id'=>$inscription->id])
    </div>
</x-app-layout>
