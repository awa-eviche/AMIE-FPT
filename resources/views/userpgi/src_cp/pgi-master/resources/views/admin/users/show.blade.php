@extends('layouts.v1.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('admin.users.partials._detail')
        </div>
    </div>
@endsection

@section('stylesAdditionnels')
    @include('layouts.v1.partials.swal._style')
@endsection

@section('scriptsAdditionnels')
    @include('layouts.v1.partials.swal._script')
@endsection

@push('myJS')
@endpush