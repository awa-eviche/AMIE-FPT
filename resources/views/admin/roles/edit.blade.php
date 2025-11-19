@extends('layouts.v1.default')

@section('content')
    {!! Form::model($role, ['method' =>'PATCH',
                    'route' => ['roles.update', $role], 'role' => 'form', 'class' => 'apix-form']) !!}
    @include('admin.roles.partials._form')
    {!! Form::close() !!}
@endsection

@section('stylesAdditionnels')
@endsection

@section('scriptsAdditionnels')
@endsection

@push('myJS')
@endpush