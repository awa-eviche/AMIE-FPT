@php $inputClass = "bg-white border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5 dark:bg-white dark:border-gray-400 dark:text-gray-400 dark:focus:ring-gray-600 dark:focus:border-gray-600" @endphp
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="md:container md:mx-auto">
            <h2 class="text-first-orange text-2xl" style="margin-left:40%;"><b>Modification du projet </b></h2>
            </br>

            <div class="mt-4">
                <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    projets</a>
            </div>
            </br>
            <div class="md:container md:mx-auto">   
                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="type_agrement" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Type d'agrément</label>
                        {!! Form::text('type_agrement', null, ['id' => 'type_agrement', 'class' => $inputClass,'readonly' => 'readonly', 'disabled' => 'disabled', 'required' => '']) !!}
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="est_agree" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Statut d'agrément</label>
                        @if($projet->est_agree == 0)
                        <span class="inline-block px-3 py-1 mb-2 mr-1 text-sm font-bold text-white bg-gray rounded-lg">
                                NON
                        </span>
                        @else
                        <span class="inline-block px-3 py-1 mb-2 mr-1 text-sm font-bold text-white bg-gray rounded-lg">
                                OUI
                        </span>
                        @endif
                    </div>
                    @foreach($documents as $document)
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="avatar" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">{{$document->nom}}</label>
                        <div class="mt-1 flex items-center">
                            <div class="w-full">
                                <div class="relative">
                                    {!! Form::file($document->nom, ['id' => 'projet', 'class' => $inputClass, 'placeholder'=>'Choisir un document']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    <!-- @if(isset($user))
                    {!! Form::hidden('user_id', $user->id) !!}
                    @endif -->


                </div>

                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                    <div class="relative z-0 w-full mb-6 group">
                        <button type="submit" class="text-white bg-first-orange hover:bg-first-orange focus:ring-4 focus:ring-first-orange font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-first-orange dark:hover:bg-first-orange focus:outline-none dark:focus:bg-first-orange">
                            Enregistrer
                        </button>
                        <a href="{{ route('users.index') }}" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-3 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                            Annuler </a>
                    </div>
                </div>

        </div>
    </div>
</div>

@section('stylesAdditionnels')
@parent
{{--@include('layouts.v1.partials.select2._style')--}}
@endsection

@section('scriptsAdditionnels')
@parent
@include('layouts.v1.partials.select2._script')
@include('layouts.v1.partials.parsley._script')
@endsection

@push('myJS')
<script>
    $(document).ready(
        function() {
            'use strict';
            $('.select2').select2();
            $(".apix-form").parsley()
        }
    );
</script>
@endpush