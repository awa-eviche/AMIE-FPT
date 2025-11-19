@extends('layouts.v1.default')

@section('content')

{!! Form::model(new \App\Models\Newsletter(), ['route' => ['update.newsletters',$newsletter->id], 'role' => 'form', 'class' => 'apix-form', 'files' => 'true']) !!}
    @php
        $pClass = " p-2.5";
        $inputClass = "bg-white border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full dark:bg-white dark:border-gray-400 dark:text-gray-400 dark:focus:ring-gray-600 dark:focus:border-gray-600";
    @endphp
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="md:container md:mx-auto">
                <h2 class="text-first-orange text-2xl py-2">Formulaire</h2><hr>
                <div class="mt-4">
                    <a href="{{ route('index.newsletters') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                        newsletters</a>
                </div>
                <div class="grid md:grid-cols-1 md:gap-6 pt-4">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="titre" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Objet</label>
                        {!! Form::text('newsletter_object', $newsletter->newsletter_object, ['id' => 'newsletter_object', 'class' => $inputClass.$pClass, 'required' => 'true', 'placeholder' => 'Objet de la newsletter']) !!}
                    </div>
                </div>
                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="corps" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Message</label>
                        {!! Form::text('newsletter_content', $newsletter->newsletter_content, ['id' => 'richEd', 'class' => $inputClass.$pClass, 'required' => 'true', 'placeholder' => '']) !!}
                    </div>
                </div>
                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                    <div class="relative z-0 w-full mb-6 group">
                        <button type="submit" class="text-white bg-first-orange hover:bg-first-orange focus:ring-4 focus:ring-first-orange font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-first-orange dark:hover:bg-first-orange focus:outline-none dark:focus:bg-first-orange">
                            Enregistrer
                        </button>
                        <a href="{{ route('index.newsletters') }}" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-3 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            Annuler </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}

@section('stylesAdditionnels')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
@include('layouts.v1.partials.swal._style')
@parent
{{--@include('layouts.v1.partials.select2._style')--}}
@endsection

@section('scriptsAdditionnels')
@parent
@include('layouts.v1.partials.swal._script')
@include('layouts.v1.partials.select2._script')
@include('layouts.v1.partials.richEditor._script')
@include('layouts.v1.partials.richEditor._style')
@include('layouts.v1.partials.parsley._script')

<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

@endsection

@push('myJS')
<script>
    var files;
    var pond;

    $(document).ready(
        function() {
            'use strict';
            $('.select2').select2();
            $(".apix-form").parsley();
            var richEd = new RichTextEditor("#richEd");

            const filesElement = document.getElementById('actualite_galleries');
            pond = FilePond.create(filesElement);
            pond.labelIdle = 'Télécharger vos fichiers ici';
        }
    );
</script>
@endpush
@endsection

