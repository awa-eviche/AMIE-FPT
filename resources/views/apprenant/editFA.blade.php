<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modification d\'un apprenant') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route('apprenant.index')}}" class="text-gray-800">Liste des apprenants</a>
        </p>
        <span class="mx-2 text-gray-800">/</span>
        <p class="text-first-orange">Editer un nouveau apprenant</p>
    </div>

    <div class="bg-white shadow rounded w-full">

        <form class="bg-white shadow-md rounded pt-6 pb-8 mb-4" action="{{ route('apprenant.update', $apprenant->id) }}" method="POST">
            @csrf

            <div class="max-w-7xl sm:px-2 lg:px-4">
                <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                    Edition de l'apprenant
                </h3>
                <div class="p-4">
                    @method('PUT')
                    <br>
                    <div class="flex flex-wrap w-full justify-evenly">
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="prenom">
                                Prénom <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="prenom" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenom" value="{{ $apprenant->prenom }}" required autofocus autocomplete="prenom" />
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
                            <x-input id="nom" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nom" value="{{ $apprenant->nom }}" required autofocus autocomplete="nom" />
                            @error('nom')
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror
                        </div>

                    </div>
                    <div class="flex flex-wrap w-full justify-evenly">


                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="date_naissance">
                                Date de naissance <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="date_naissance" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="date_naissance" value="{{ $apprenant->date_naissance}}" required autofocus autocomplete="date_naissance" />
                            @error('date_naissance')
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror
                        </div>
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="lieu_naissance">
                                Lieu de naissance <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="lieu_naissance" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="lieu_naissance" value="{{ $apprenant->lieu_naissance}}" required autofocus autocomplete="lieu_naissance" />
                            @error('lieu_naissance')
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap w-full justify-evenly">
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="nomTuteur">
                                Nom du Tuteur <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="nomTuteur" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nomTuteur" value="{{ $apprenant->nomTuteur}}" required autofocus autocomplete="nomTuteur" />
                            @error('nomTuteur')
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror
                        </div>
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="prenomTuteur">
                                Prénom du Tuteur <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="prenomTuteur" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenomTuteur" value="{{ $apprenant->prenomTuteur}}" required autofocus autocomplete="prenomTuteur" />
                            @error('prenomTuteur')
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap w-full justify-evenly">

                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="numTelTuteur">
                                Téléphone du tuteur <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="numTelTuteur" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="numTelTuteur" value="{{ $apprenant->numTelTuteur}}" required autofocus autocomplete="numTelTuteur" />
                            @error('numTelTuteur')
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror
                        </div>


                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="situationMatrimoniale">
                                Situation Matrimoniale
                            </x-label>
                            <select id="situationMatrimoniale" name="situationMatrimoniale" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ">
                                <option value="">Choisir la situation matrimoniale</option>
                                <option value="{{\App\Enums\MarriageStatus::SINGLE}}" {{ $apprenant->situationMatrimoniale == \App\Enums\MarriageStatus::SINGLE ? 'selected' : '' }}>Célibataire</option>
                                <option value="{{\App\Enums\MarriageStatus::MARRIED}}" {{ $apprenant->situationMatrimoniale == \App\Enums\MarriageStatus::MARRIED ? 'selected' : '' }}>Marié</option>
                                <option value="{{\App\Enums\MarriageStatus::DIVORCED}}" {{ $apprenant->situationMatrimoniale == \App\Enums\MarriageStatus::DIVORCED ? 'selected' : '' }}>Divorcé</option>
                                <option value="{{\App\Enums\MarriageStatus::WIDOWED}}" {{ $apprenant->situationMatrimoniale == App\Enums\MarriageStatus::WIDOWED ? 'selected' : '' }}>Veuf</option>


                            </select>
                            @error('situationMatrimoniale')
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror
                        </div>

                    </div>


                    <div class="flex flex-wrap w-full justify-evenly">
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="prenomMere">
                                Prénom de la Mère <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="prenomMere" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenomMere" value="{{ $apprenant->prenomMere}}" required autofocus autocomplete="prenomMere" />
                            @error("prenomMere")
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror
                        </div>
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="nomMere">
                                Nom de la Mère <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="nomMere" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nomMere" value="{{ $apprenant->nomMere}}" required autofocus autocomplete="nomMere" />
                            @error("nomMere")
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror

                        </div>
                    </div>
                    <div class="flex flex-wrap w-full justify-evenly">

                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="prenomPere">
                                Prénom du Père <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="prenomPere" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenomPere" value="{{ $apprenant->prenomPere}}" required autofocus autocomplete="prenomPere" />
                            @error('prenomPere')
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror
                        </div>
                        <div class="flex-grow mb-4 mr-2">
                            <x-label for="email">
                                Email <span class="text-red-500">*</span>
                            </x-label>
                            <x-input id="email" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="email" value="{{ $apprenant->email}}" required autofocus autocomplete="email" />
                            @error("email")
                            <span class="text-xs text-red-500">
                                {{$message}}

                            </span>
                            @enderror

                        </div>
                        <div class="flex flex-wrap w-full justify-evenly">
                            <div class="flex-grow mb-4 mr-2">
                                <x-label for="telephone">
                                    Téléphone <span class="text-red-500">*</span>
                                </x-label>
                                <x-input id="telephone" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="telephone" value="{{ $apprenant->telephone}}" required autofocus autocomplete="telephone" />
                                @error("telephone")
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                                @enderror

                            </div>
                            <div class="w-full sm:w-1/2 px-2 pb-5">
                                <x-label for="matricule">
                                    Matricule de l'apprenant <span class="text-red-500"></span>
                                </x-label>
                                <x-input id="matricule" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="matricule" value="{{ $apprenant->matricule }}"  autofocus autocomplete="matricule" />
                                @error('matricule')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                                @enderror

                            </div>
                        </div>

                        <div class="flex flex-wrap w-full justify-evenly">

                            <div class="w-full sm:w-1/2 px-2 pb-5">
                                <x-label for="sexe">
                                    Sexe <span class="text-red-500">*</span>
                                </x-label>
                                <select id="sexe" name="sexe" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ">
                                    <option value="">Choisir le sexe</option>
                                    <option value="Homme" {{ $apprenant->sexe == "Homme" ? 'selected' : '' }}>Homme</option>
                                    <option value="Femme" {{ $apprenant->sexe == "Femme" ? 'selected' : '' }}>Femme</option>

                                </select> @error('sexe')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                                @enderror
                            </div>
                            <div class="w-full sm:w-1/2 px-2 pb-5">
                                <x-label for="commune">
                                    Commune <span class="text-red-500">*</span>
                                </x-label>
                                <select id="commune_id" name="commune_id" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ">
                                    <option value="">Choisir la commune</option>
                                    @foreach($communes as $commune)
                                    <option value="{{$commune->id}}" {{ $apprenant->commune_id == $commune->id ? 'selected' : '' }}>{{$commune->libelle}}</option>
                                    @endforeach

                                </select>
                                @error('commune_id')
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex flex-wrap w-full justify-evenly">
                            <div class="flex-grow mb-4 mr-2">
                                <x-label for="dateInsertion">
                                    Date d'Insertion
                                </x-label>
                                <x-input id="dateInsertion" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="date" name="dateInsertion" value="{{ $apprenant->dateInsertion}}" autofocus autocomplete="dateInsertion" />
                                @error("dateInsertion")
                                <span class="text-xs text-red-500">
                                    {{$message}}

                                </span>
                                @enderror
                            </div>
                            <div class="flex-grow mb-4 mr-2">
                                <x-label for="autoEmploi">
                                    AutoEmploi
                                </x-label>
                                <select id="autoEmploi" name="autoEmploi" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " required autofocus>
                                    <option value="">Choisir une option</option>
                                    <option value="1" {{ $apprenant->autoEmploi == 1 ? 'selected' : '' }}>Oui</option>
                                    <option value="0" {{ $apprenant->autoEmploi == 0 ? 'selected' : '' }}>Non</option>
                                </select>
                                @error('autoEmploi')
                                <span class="text-xs text-red-500">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="flex flex-wrap w-full justify-evenly">
                            <div class="flex-grow mb-4 mr-2">
                                <x-label for="nationalite">
                                    Nationalité
                                </x-label>
                                <select id="nationalite" name="nationalite" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " required autofocus>
                                    <option value="">Choisissez la nationalité</option>
                                    @foreach ($pays as $nationalite)
                                    <option value="{{ $nationalite->en_short_name }}"  @if($apprenant->nationalite === $nationalite->en_short_name ) selected @endif>{{ $nationalite->en_short_name}}</option>
                                    @endforeach
                                </select>
                                @error('nationalite')
                                <span class="text-xs text-red-500">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>

                            <div class="flex-grow mb-4 mr-2">
                                <x-label for="emploiSalarie">
                                    Emploi Salarié
                                </x-label>
                                <select id="emploiSalarie" name="emploiSalarie" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " required autofocus>
                                    <option value="">Choisir une option</option>
                                    <option value="1" {{ $apprenant->emploiSalarie == 1 ? 'selected' : '' }}>Oui</option>
                                    <option value="0" {{ $apprenant->emploiSalarie == 0 ? 'selected' : '' }}>Non</option>
                                </select>
                                @error('autoEmploi')
                                <span class="text-xs text-red-500">
                                    {{$message}}
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <a style="height:40px;margin-right:10px;" class="py-2 px-5 bg-red-500 text-white font-semibold rounded shadow-md hover:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-400 focus:ring-opacity-75" href="{{route('inscription.index')}}"> Annuler </a>
                    <button type="submit" class="my-5 bg-first-orange rounded px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>
                </div>
        </form>
    </div>



</x-app-layout>