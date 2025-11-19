
@extends('layouts.v1.default')

@section('content')
    <div class="flex justify-between mt-0 mb-2">
        <div class="mb-5">
            <h1 class="text-2xl font-bold">{{$title}}</h1>
            <div class="mt-4">
                @if($fromUser == true)
                <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste</a>
                @endif
                <div class="mt-4 pb-3">
                <a href="{{ route('admin.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    menu</a>
            </div>
            </div>
            {{--<h2 class="text-lg font-medium text-gray-500">Ajouter un nouvel utilisateur</h2>--}}
        </div>
    </div>
    @include('admin.users.partials._logs')
@endsection

@section('stylesAdditionnels')
    @include('layouts.v1.partials.swal._style')
@endsection

@section('scriptsAdditionnels')
    @include('layouts.v1.partials.swal._script')
@endsection

@push('myJS')
@endpush