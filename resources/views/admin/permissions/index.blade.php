
@extends('layouts.v1.default')

@section('content')
    <div class="flex justify-between mt-0">
        <div>
            <h1 class="text-2xl font-bold">Liste des permissions</h1>
        </div>
    </div>
    <div class="mt-4 pb-3">
                <a href="#" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    menus</a>
            </div>
    <div class="p-6 text-gray-900">
        @include('admin.permissions.partials._liste')
    </div>
@endsection

@section('stylesAdditionnels')
@endsection

@section('scriptsAdditionnels')
@endsection

@push('myJS')
@endpush