
@extends('layouts.v1.default')

@section('content')

    {!! Form::model($user, ['method' =>'PATCH', 'route' => ['users.update', $user], 'role' => 'form',
    'class' => 'apix-form', 'files' => 'true']) !!}
    @include('admin.users.partials._form')
    {!! Form::close() !!}
@endsection

@section('stylesAdditionnels')
@endsection

@section('scriptsAdditionnels')
@endsection

@push('myJS')
@endpush