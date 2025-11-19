<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modification d\'un inspecteur') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route('inspecteur.index')}}"  class="text-gray-800">Liste des Inspecteurs</a>
        </p>
        <span class="mx-2 text-gray-800">/</span>
        <p class="text-first-orange">Editer un inspecteur</p>
    </div>

    <div class="bg-white shadow rounded w-full">
        
        <form class="bg-white shadow-md rounded pt-6 pb-8 mb-4" action="{{ route('inspecteur.update', $inspecteur->id) }}" method="POST">
            @csrf

            <div class="max-w-7xl sm:px-2 lg:px-4">
                <div class="">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Edition de l'inspecteur
                    </h3>
                    @method('PUT')
                    <br>
                    <div class="flex flex-wrap w-full justify-evenly">
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="prenom">
                                Prenom <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="prenom" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenom" value="{{ $inspecteur->prenom }}" required autofocus autocomplete="prenom" />
                            @error('prenom')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                            @enderror
                        </div>
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="nom">
                                Nom <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="nom" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nom" value="{{ $inspecteur->nom}}" required autofocus autocomplete="nom" />
                            @error('nom')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap w-full justify-evenly">
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="telephone">
                                Telephone <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="telephone" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="telephone" value="{{ $inspecteur->telephone}}" required autofocus autocomplete="telephone" />
                            @error('telephone')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                            @enderror
                        </div>
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="email">
                                Email <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="email" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="email" value="{{ $inspecteur->email}}" required autofocus autocomplete="email" />
                            @error('email')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap w-full justify-evenly">
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="specialite">
                                Specialite <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="specialite" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="specialite" name="specialite" value="{{ $inspecteur->specialite}}" required autofocus autocomplete="specialite" />
                            @error('specialite')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                            @enderror
                        </div>
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="ia_id">
                                IA 
                            </x-label>
                            <x-input id="ia_id" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="ia_id" value="{{ $inspecteur->ia_id}}" autofocus autocomplete="ia_id" />
                            @error('site web')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap w-full justify-evenly">
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="ief_id">
                                IEF <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="ief_id" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="ief_id" value="{{ $inspecteur->ief_id}}" required autofocus autocomplete="ief_id" />
                            @error('ief_id')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                            @enderror
                        </div>
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="specialite">
                                Spécialité
                            </x-label>
                            <x-input id="specialite" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="specialite" value="{{ $inspecteur->specialite}}" required autofocus autocomplete="specialite" />
                            @error('specialite')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                            @enderror
                        </div>
                    </div>
                   
                </div>
                <a style="height:40px;margin-right:10px;" class="py-2 px-5 bg-red-500 text-white font-semibold rounded shadow-md hover:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75"
                href="{{route('inspecteur.index')}}"> Annuler </a>
                <button type="submit" class="my-5 bg-first-orange rounded px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>
            </div>
        </form>
    </div>
   


</x-app-layout>
