


@extends('layouts.v1.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="md:container md:mx-auto">
                        <h2 class="text-first-orange text-2xl">Détails du projet</h2>
                        <div class="mt-4">
                            <a href="{{ route('projet.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                                projets</a>
                        </div>
                        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white shadow overflow-hidden rounded-lg">
                                <ul class="divide-y divide-gray-200">
                                    <li class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <strong class="text-md font-medium text-gray-600 mr-3">Type agrément: </strong>
                                            <span class="text-gray-900">{{ $projet->type_agrement}}</span>
                                        </div>
                                    </li>
                                    <li class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center">
                                            <strong class="text-md font-medium text-gray-600 mr-3">Est agréé :</strong>
                                            @if ($projet->est_agree == 1 )
                                                <span class="text-gray-900">OUI</span>
                                            @else 
                                                <span class="text-gray-900"> NON </span>
                                            @endif
                                        </div>
                                    </li>
                                    <div class="flex items-center">
                                            <strong class="text-md font-medium text-gray-600 mr-3">Document Projet :</strong>
                                            
                                        </div>
                                    </li>
                                    <div class="w-1/4">
                                        <a href="{{ url('/storage/projets/' . $document->lien_ressource) }}">Visualiser le document</a>
                                    </div>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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