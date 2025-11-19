@php $inputClass = "bg-white border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5 dark:bg-white dark:border-gray-400 dark:text-gray-400 dark:focus:ring-gray-600 dark:focus:border-gray-600" @endphp
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="md:container md:mx-auto">
            <h2 class="text-first-orange text-2xl">Formulaire</h2>
            <div class="mt-4">
                <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des
                    utilisateurs</a>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="prenom" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Prénom<span class="text-red-500">*</span></label>
                    {!! Form::text('prenom', null, ['id' => 'prenom', 'class' => $inputClass, 'required' => '', 'placeholder' => 'Prénom']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="nom" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Nom<span class="text-red-500">*</span></label>
                    {!! Form::text('nom', null, ['id' => 'nom', 'class' => $inputClass, 'required' => '', 'placeholder' => 'Nom']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="date_naissance" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Date de naissance</label>
                    {!! Form::date('date_naissance', null, ['id' => 'date_naissance', 'class' => $inputClass, 'placeholder' => 'Date de naissance']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="email" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Email<span class="text-red-500">*</span></label>
                    {!! Form::email('email', null, ['id' => 'email', 'class' => $inputClass, 'required' => '', 'placeholder' => 'Adresse email']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="adresse" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Adresse</label>
                    {!! Form::text('adresse', null, ['id' => 'adresse', 'class' => $inputClass, 'placeholder' => 'Adresse']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="telephone" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">
                        Numéro de téléphone<span class="text-red-500">*</span>
                    </label>
                    {!! Form::text('telephone', null, ['id' => 'telephone', 'class' => $inputClass, 'placeholder' => 'Numéro de téléphone','required' => 'true']) !!}
                </div>


                <div class="relative z-0 w-full mb-6 group">
                    <label for="sexe" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Sexe<span class="text-red-500">*</span></label>
                    {!! Form::select('sexe', ['Homme' => 'Homme', 'Femme' => 'Femme'], null, ['id' => 'sexe', 'class' => $inputClass, 'required' => 'true', 'data-control' => 'select2', 'data-allow-clear' => 'true', 'placeholder' => 'Choisir...']) !!}
                </div>

                <div class="relative z-0 w-full mb-6 group">
    <label for="roles" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Profil<span class="text-red-500">*</span></label>
    {!! Form::select('roles[]', $roles, null, [
        'id' => 'roles',
        'class' => $inputClass,
        'required' => 'true',
        'data-control' => 'select2',
        'data-allow-clear' => 'true',
        'placeholder' => 'Choisir...'
    ]) !!}
</div>

                <div class="relative z-0 w-full mb-6 group" id="iasGroup" style="display: none;">
                    <label for="ias" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">IA <span class="text-red-500">*</span></label>
                    {!! Form::select('ia',$ias->pluck('nom', 'id'), null, ['id' => 'ias', 'class' => $inputClass, 
                    'data-control' => 'select2', 'data-allow-clear' => 'true', 'placeholder' => 'Choisir...']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group" id="iefsGroup" style="display: none;">
                    <label for="iefs" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">IEF</label>
                    {!! Form::select('ief',$iefs->pluck('nom', 'id'), null, ['id' => 'iefs', 'class' => $inputClass, 
                    'data-control' => 'select2', 'data-allow-clear' => 'true', 'placeholder' => 'Choisir...']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="avatar" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Photo</label>
                    <div class="mt-1 flex items-center">
                        <div class="w-full">
                            <div class="relative">
                                {!! Form::file('profile_photo_path', ['id' => 'avatar', 'class' => $inputClass, 'placeholder'=>'Choisir une photo']) !!}
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">La photo doit être au format jpg ou png et la dimension doit
                        être min: 80x80 et max: 800x800.</p>
                    @if(isset($user) && !empty($user->profile_photo_path))
                    <img class="avatar-min" src="{{ asset('storage/avatars/'. $user->profile_photo_path) }}" alt="avatar" />
                    @endif
                </div>

@if((auth()->user()->hasRole(config('constants.roles.chef_etablissement')) || auth()->user()->hasRole('assistante'))
    && auth()->user()->can('edit_personnel'))                
<div class="relative z-0 w-full mb-6 group">
                    <label for="fonction" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Fonction<span class="text-red-500">*</span></label>
                    {!! Form::text('fonction', null, ['id' => 'fonction', 'class' => $inputClass, 'placeholder' => 'Fonction', 'required' => 'true']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">
                        Dernier diplôme académique<span class="text-red-500">*</span>
                    </label>
                    {!! Form::text('dernierDiplomeAcademique', null, ['id' => 'dernierDiplomeAcademique', 'class' => $inputClass, 'placeholder' => 'Dernier diplôme académique', 'required' => 'true']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">
                        Dernier diplôme professionnel<span class="text-red-500">*</span>
                    </label>
                    {!! Form::text('dernierDiplomeProfessionnel', null, ['id' => 'dernierDiplomeProfessionnel', 'class' => $inputClass, 'placeholder' => 'Dernier diplôme professionnel', 'required' => 'true']) !!}
                </div>
                <div class="relative z-0 w-2 mb-3 group">
                    <label for="interne" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Interne</label>
                    {!! Form::checkbox('interne', true, null, ['id' => 'interne', 'class' => $inputClass, 'placeholder' => 'Interne à l\'établissement ou pas ?']) !!}
                </div>
                @endif


                @if(isset($user))
                {!! Form::hidden('user_id', $user->id) !!}
                @endif
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

        $('#roles').change(function() {
            var selectedRole = $(this).val();
            if (selectedRole == 11) {
                $('#iasGroup').show();
                $('#iefsGroup').show();
            } else if (selectedRole == 10) {
                $('#iasGroup').show();
                $('#iefsGroup').hide();
            }
        }),

        function executeOnPageLoad() {
            console.log("Executed Page Load");
            var selectedRole = $('#roles').val();
            if (selectedRole == 11) {
                $('#iasGroup').show();
                $('#iefsGroup').show();
            } else if (selectedRole == 10) {
                $('#iasGroup').show();
                $('#iefsGroup').hide();
            }
            // Ajoutez ici d'autres actions à exécuter au chargement de la page si nécessaire
        },

        // Appel de la fonction au chargement de la page
        executeOnPageLoad(),
        




        function() {
            'use strict';
            $('.select2').select2();
            $(".apix-form").parsley()
        }
    );
</script>
@endpush
