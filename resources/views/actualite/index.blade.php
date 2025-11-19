<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des actualités') }}
        </h2>
    </x-slot>

    <div class="container p-2 rounded">
        <livewire:page-acceuil.actualite/>
    </div>
    @section('stylesAdditionnels')
        @include('layouts.v1.partials.swal._style')
    @endsection

    @section('scriptsAdditionnels')
        @include('layouts.v1.partials.swal._script')
    @endsection
</x-app-layout>
