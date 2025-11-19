

@extends('layouts.v1.default')

@section('content')

    <div class="flex justify-between mt-0 mb-2">
        <div class="mb-5 ml-5">
            <h1 class="text-2xl font-bold">Liste des utilisateurs</h1>
        </div>
    </div>
    <div class="mt-4 pb-3">
                <a href="#" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    menu</a>
            </div>
    @include('projet.partials._header')
    @include('projet.partials._liste')
@endsection

@section('stylesAdditionnels')
    @include('layouts.v1.partials.swal._style')
@endsection

@section('scriptsAdditionnels')
    @include('layouts.v1.partials.swal._script')
@endsection

@push('myJS')
@endpush