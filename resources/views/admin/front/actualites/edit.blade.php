@extends('layouts.v1.default')

@section('content')

{!! Form::model(new \App\Models\FrontActualite(), ['route' => ['update.actualite',$actualite->id], 'role' => 'form', 'class' => 'apix-form', 'files' => 'true']) !!}
@php
$pClass = " p-2.5";
$inputClass = "bg-white border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full dark:bg-white dark:border-gray-400 dark:text-gray-400 dark:focus:ring-gray-600 dark:focus:border-gray-600";
@endphp
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="md:container md:mx-auto">
            <h2 class="text-first-orange text-2xl py-2">Formulaire</h2>
            <hr>
            <div class="mt-4">
                <a href="{{ route('index.slider') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    actualités</a>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                <div class="relative z-0 w-full mb-3 group">
                    <label for="prenom" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Titre</label>
                    {!! Form::text('actualite_titre', $actualite->actualite_titre, ['id' => 'actualite_titre', 'class' => $inputClass.$pClass, 'required' => 'true', 'placeholder' => 'Titre']) !!}
                </div>
                <div class="relative z-0 w-full mb-3 group">
                    <label for="prenom" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Publier/Dépublier</label>
                    {!! Form::select('actualite_is_active',[0=>'Dépublié',1=>'Publié'], $actualite->actualite_is_active, ['id' => 'actualite_is_active', 'class' => $inputClass.$pClass, 'required' => 'true']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="nom" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Image principale</label>
                    {!! Form::file('actualite_main_pic', ['id' => 'actualite_main_pic', 'class' => $inputClass , 'placeholder'=>'Choisir une image']) !!}
                    @if(!empty($actualite->actualite_main_pic))
                    <img class="thumbnail-slider py-4" src="{{ asset('storage/front/actualites/'. $actualite->actualite_main_pic) }}" alt="{{$actualite->activite_main_pic}}" />
                    @endif
                </div>
            </div>
            <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="corps" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Contenu</label>
                    {!! Form::text('actualite_corps',$actualite->actualite_corps, ['id' => 'richEd', 'class' => $inputClass.$pClass, 'required' => 'true', 'placeholder' => 'Titre']) !!}
                </div>
            </div>
            <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                <div class="relative z-0 w-full mb-6 group">
                    <button type="submit" class="text-white bg-first-orange hover:bg-first-orange focus:ring-4 focus:ring-first-orange font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-first-orange dark:hover:bg-first-orange focus:outline-none dark:focus:bg-first-orange">
                        Enregistrer
                    </button>
                    <a href="{{ route('index.actualite') }}" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-3 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        Annuler </a>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

@section('stylesAdditionnels')
@parent
{{--@include('layouts.v1.partials.select2._style')--}}
@endsection

@section('scriptsAdditionnels')
@parent
@include('layouts.v1.partials.select2._script')
@include('layouts.v1.partials.parsley._script')

@include('layouts.v1.partials.richEditor._script')
@include('layouts.v1.partials.richEditor._style')
@endsection

@push('myJS')
<script>
    var files;
    var pond;
    $(document).ready(
        function() {
            'use strict';
            $('.select2').select2();
            $(".apix-form").parsley()
            var richEd = new RichTextEditor("#richEd");

            const filesElement = document.getElementById('actualite_galleries');
            pond = FilePond.create(filesElement);
            pond.labelIdle = 'Télécharger vos fichiers ici';
        }
    );
</script>
@endpush
@endsection