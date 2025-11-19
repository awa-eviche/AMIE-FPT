@php
use Collective\Html\FormFacade as Form;
@endphp


@extends('layouts.v1.default')

@section('content')


    {!! Form::model($permission, ['method' =>'PATCH',
                    'route' => ['permissions.update', $permission], 'role' => 'form', 'class' => 'apix-form']) !!}
    @include('admin.permissions.partials._form')
    {!! Form::close() !!}
@endsection

@section('stylesAdditionnels')
@endsection

@section('scriptsAdditionnels')
@endsection

@push('myJS')
@endpush