<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="md:container md:mx-auto">
            <h2 class="text-first-orange text-2xl">Formulaire</h2>
            <div class="mt-4 mb-2">
                <a href="{{ route('permissions.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des permissions</a>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="name"
                           class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Nom</label>
                    {!! Form::text('name', null, ['id' => 'name', 'class' => 'my-input bg-white border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5 dark:bg-white dark:border-gray-400  dark:text-gray-600 dark:focus:ring-gray-400 dark:focus:border-gray-400', 'required' => '', 'placeholder' => 'Nom',
                        (isset($permission) && !$permission->isDeletable()) ? 'disabled' : '']) !!}
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="description" class="block mb-2 text-sm font-medium text-regal-black dark:text-regal-black">Description</label>
                    {!! Form::text('description', null, ['id' => 'description', 'class' => 'bg-white border border-gray-400 text-gray-600 text-sm rounded-lg focus:ring-gray-400 focus:border-gray-400 block w-full p-2.5 dark:bg-white dark:border-gray-400  dark:text-gray-400 dark:focus:ring-gray-400 dark:focus:border-gray-400', 'required' => '', 'placeholder' => 'Description']) !!}
                </div>
                @if(isset($permission))
                    {!! Form::hidden('permission_id', $permission->id) !!}
                @endif
            </div>
            <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                <div class="relative z-0 w-full mb-6 group">
                    <button type="submit"
                            class="text-white bg-first-orange hover:bg-first-orange focus:ring-4 focus:ring-bg-first-orange font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-first-orange dark:hover:bg-first-orange focus:outline-none dark:focus:bg-first-orange">
                        Enregistrer
                    </button>
                    <button type="cancel"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                        Annuler
                    </button>
                    {{--<a href="{{ url()->previous() }}" class="btn btn-secondary"> Annuler </a>--}}
                </div>
            </div>
        </div>
    </div>
</div>

@section('stylesAdditionnels')
    @parent
@endsection

@section('scriptsAdditionnels')
    @parent
    @include('layouts.v1.partials.parsley._script')
@endsection

@push('myJS')
    <script>
        $(document).ready(
            function () {
                'use strict';
                //Validation
                $(".apix-form").parsley()
            }
        );
    </script>
@endpush