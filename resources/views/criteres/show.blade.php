<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visualiser un critère') }}
        </h2>
    </x-slot>

    @section('stylesAdditionnels')
        @include('layouts.v1.partials.swal._style')
        <style>
            input{
                border:none;
            }
            .tab-content {
                display: none;
            }

            .tab-content.active {
                display: block;
            }

            .tab-div{
                border-bottom:2px solid  rgb(22 163 74 / var(--tw-text-opacity));
            }

            .tab-button{
                cursor: pointer;
                margin-right:2px;
                border:0px;
                border-top-right-radius: 4px;
                border-top-left-radius: 4px;;
                background-color: #eee;
                color:#666;
                font-weight: normal;
            }
            .tab-button:hover{
                color:rgb(22 163 74 / var(--tw-text-opacity));
            }
            .tab-button.active{
                /* border-bottom: .2rem solid rgb(22 163 74 / var(--tw-text-opacity)); */
                border:0px;
                border-bottom:0px;
                background-color: rgb(22 163 74 / var(--tw-text-opacity));;
                /* position:relative; 
                top:1px; */
                color:#FFFFFF;
                font-weight: bold;
            }
        </style>
    @endsection

    @section('scriptsAdditionnels')
        @include('layouts.v1.partials.swal._script')
        <script>
            function switchTab(event) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Deactivate all tab buttons
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('active');
                });

                // Get target tab content and button, then activate them
                const targetId = event.target.getAttribute('data-target');
                const targetContent = document.getElementById(targetId);
                const targetButton = event.target;

                targetContent.classList.add('active');
                targetButton.classList.add('active');
            }

            // Add click event listener to each tab button
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', switchTab);
            });
        </script>
    @endsection

    <div class="bg-transparent shadow rounded-sm w-full p-4">

        <div class="mt-2 mb-2">
            <a href="{{ route('critere.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des critères</a>
        </div>
        <div class="w-full mx-auto">
            <div class="bg-white pt-6 pb-8 mb-4">
                <div class="md:container md:mx-auto">

                    <div class="w-full sm:px-2 lg:px-4 ">
                        <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
                            <p>
                                <a href="/dashboard" class="text-maquette-black">Accueil</a>
                                  <span class="mx-2 text-maquette-gris">/</span>
                            </p><p> <a href="{{route('critere.index')}}">Critères</a>
                                <span class="mx-2 text-maquette-gris">/</span>
                            </p>
                            <p class="text-first-orange">Modifier</p>
                            <p></p>
                        </div>
                        <div class="border border-gray-200">
                            <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                                Formulaire d'ajout
                            </h3>
                            <div class="p-5">

                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="element" class="block text-gray-700 text-sm font-bold mb-2">Elément de compétence : &nbsp;<span class="font-light">{{$critere->elementCompetence->libelle}}</span></label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Code : &nbsp;<span class="font-light">{{$critere->code}}</span></label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="libelle" class="block text-gray-700 text-sm font-bold mb-2">Libellé : &nbsp;<span class="font-light">{{$critere->libelle}}</span></label>
                                    </div>
                                </div>
                                <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                                    <div class="mb-4">
                                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                                        <textarea class="border readonly border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" name="description" id="description" cols="10" rows="5">{{old('description') ?? $critere->description}}</textarea>
                                        @error('description')
                                            {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('critere.edit', $critere->id) }}" class="px-3 rounded-md py-2 flex items-center w-min text-white text-sm text-center bg-first-orange">
                                        <i class="fa fa-edit"></i>&nbsp;Modifier
                                    </a>
                                    {!! Form::open(array(
                                        'method' => 'DELETE',
                                        'class' => 'delete-form',
                                        'style' => 'display: inline;',
                                        'route' => array('critere.destroy', $critere->id))) !!}
                                        {{ csrf_field() }}
                                        <a href="#delete" class="flex items-center w-max text-white bg-red-600 text-sm rounded-md shadow-md px-4 py-2 apix-delete" data-toggle="tooltip" title="Supprimer cette critere">
                                            <i class="fa fa-trash"></i>&nbsp;Supprimer
                                        </a>
                                    {!! Form::close() !!}
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
