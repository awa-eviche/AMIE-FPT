
@extends('layouts.v1.default')

@section('content')

    {!! Form::model($projet, ['method' =>'PUT', 'route' => ['projet.update', $id], 'role' => 'form',
    'class' => 'apix-form', 'files' => 'true']) !!}
    @include('projet.partials._form')
    {!! Form::close() !!}
@endsection

@section('stylesAdditionnels')
@endsection

@section('scriptsAdditionnels')
@endsection

@push('myJS')
@endpush