@extends('layouts.v1.default')

@section('content')

    {!! Form::model(new \App\Models\User(), ['route' => ['users.store'], 'role' => 'form', 'class' => 'apix-form', 'files' => 'true']) !!}
    @include('admin.users.partials._form')
    {!! Form::close() !!}
@endsection

@section('stylesAdditionnels')
@endsection

@section('scriptsAdditionnels')
@endsection

@push('myJS')
@endpush