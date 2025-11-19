<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl ext-first-orange leading-tight">
            {{ __('Gestion des apprenants') }}
        </h2>
    </x-slot>


    <div x-data="app()">

        <div class="flex items-center px-4">
            <div class="flex-1">
                <h2 class="font-bold text-maquette-gris text-xl py-4">
                    {{ $currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée' }}
                </h2>
            </div>
            <div class="flex-1">
                <select wire:model="classe" class="disabled readonly border bg-white3 font-bold text-md border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-md">
                    @foreach ($classes as $listedClasse)
                    <option {{ $currentClasse && $currentClasse->id == $listedClasse->id ? 'selected' : ''}} value="{{$listedClasse->id}}">{{$listedClasse->libelle}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if($currentClasse)
        <div class="py-2 px-4 m-2 shadow bg-vert2 rounded shadow border border-black">
            <div class="grid grid-cols-3 gap-2 py-2 text-md">
                <div class="flex items-center">
                    <span class="text-gray-800">Année Scolaire :</span>
                    <span class="font-bold"></span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Filiere :</span>
                    <span class="font-bold">{{$currentClasse->niveau_etude->metier->filiere->nom}}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Métier :</span>
                    <span class="font-bold">{{$currentClasse->niveau_etude->metier->nom}}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Niveau d'études :</span>
                    <span class="font-bold">{{$currentClasse->niveau_etude->nom}}</span>
                </div>

                <div class="flex items-center">
                    <span class="text-gray-800">Etat classe :</span>
                    <span class="font-bold">{{ strval( $currentClasse->statut)=="" ?'Non Validé' : (!($currentClasse->etat_classe) ? 'Validé' : 'Lancé')}}</span>
                </div>

                <div class="flex items-center">
                    <span class="text-gray-800">Nombre apprenants :</span>
                    <span class="font-bold">{{ count($apprenants) }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('apprenant.store') }}" method="POST" class="bg-white border-x-2 rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="max-full mx-auto px-4 py-10">

                <div x-show.transition="step === 'complete'">
                    <div class="bg-white rounded-lg p-10 flex items-center shadow justify-between">
                        <div>
                            <svg class="mb-4 h-20 w-20 text-green-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>

                            <h2 class="text-2xl mb-4 text-gray-800 text-center font-bold">Succès</h2>



                            <button @click="step = 1" class="w-40 block mx-auto focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">Back to home</button>
                        </div>
                    </div>
                </div>


                <div x-show.transition="step != 'complete'">
                    <!-- Top Navigation -->

                    <div class="border-b-2 py-4">
                        <div class="uppercase tracking-wide text-xs font-bold text-gray-500 mb-1 leading-tight text-end mr-20" x-text="`Etape: ${step} sur 2`"></div>
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div x-show="step === 1">
                                    <div class="text-lg font-bold text-gray-700 leading-tight">Informations de l'apprenant</div>
                                </div>

                                <div x-show="step === 2">
                                    <div class="text-lg font-bold text-gray-700 leading-tight">Contacts</div>
                                </div>


                            </div>

                            <div class="flex items-center md:w-64">
                                <div class="w-full bg-orange-200  rounded-full mr-2">
                                    <div class="rounded-full bg-orange-300 text-xs leading-none h-2 text-center text-white" :style="'width: '+ parseInt(step / 2 * 100) +'%'"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Top Navigation -->

                    <!-- Step Content -->
                    <div class="py-10">
                        <div x-show.transition.in="step === 1">

                        <input type="hidden" name="classe_id" value="{{ $currentClasse->id }}">

<div class="form-group">
    <label for="annee_academique_id">Année académique</label>
    <select name="annee_academique_id" class="form-control" required>
        @foreach ($anneeAcademiques as $annee)
            <option value="{{ $annee->id }}">{{ $annee->code }}</option>
        @endforeach
    </select>
</div>
                            <div class="flex flex-wrap">
                            


                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="nom">
                                        Nom <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="nom" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nom" :value="old('nom')" required autofocus autocomplete="nom" />
                                    @error('nom')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="prenom">
                                        Prénoms <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="prenom" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="prenom" />
                                    @error('prenom')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="date_naissance">
                                        Date de naissance <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="date_naissance" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="date" name="date_naissance" :value="old('date_naissance')" required autofocus autocomplete="date_naissance" />
                                    @error('date de naissance')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="lieu_naissance">
                                        Lieu de naissance <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="lieu_naissance" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="lieu_naissance" :value="old('lieu_naissance')" required autofocus autocomplete="lieu_naissance" />
                                    @error('lieu de naissance')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>


                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="commune">
                                        Commune de résidence <span class="text-red-500">*</span>
                                    </x-label>
                                    <select id="commune_id" name="commune_id" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ">
                                        <option value="">Choisir la commune</option>
                                        @foreach($communes as $commune)
                                        <option value="{{$commune->id}}">{{$commune->libelle}}</option>
                                        @endforeach

                                    </select>
                                    @error('commune_id')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>


                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="nationalite">
                                        Nationalité <span class="text-red-500">*</span>
                                    </x-label>
                                    <select id="nationalite" name="nationalite" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2" required autofocus>
                                        <option value="">Choisissez la nationalité</option>
                                        @foreach ($pays as $nationalite)
                                        <option value="{{ $nationalite->en_short_name }}">{{ $nationalite->en_short_name}}</option>
                                        @endforeach
                                    </select> @error('nationalite')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="adresse">
                                        Adresse <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="adresse" x-model="adresse" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="adresse" :value="old('adresse')" required autofocus autocomplete="adresse" />
                                    @error('adresse')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>


                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="sexe">
                                        Sexe <span class="text-red-500">*</span>
                                    </x-label>
                                    <select id="sexe" name="sexe" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ">
                                        <option value="">Choisir le sexe</option>
                                        <option value="M">M</option>
                                        <option value="F">F</option>

                                    </select> @error('sexe')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="situationMatrimoniale">
                                        Situation matrimoniale
                                    </x-label>
                                    <select id="situationMatrimoniale" name="situationMatrimoniale" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 ">
                                        <option value="">Choisir la situation matrimoniale</option>
                                        <option value="{{\App\Enums\MarriageStatus::SINGLE}}">Célibataire</option>
                                        <option value="{{\App\Enums\MarriageStatus::MARRIED}}">Marié</option>
                                        <option value="{{\App\Enums\MarriageStatus::DIVORCED}}">Divorcé</option>
                                        <option value="{{\App\Enums\MarriageStatus::WIDOWED}}">Veuf</option>
                                    </select>
                                    @error('situationMatrimoniale')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>


                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="nomTuteur">
                                        Nom du Tuteur <span class="text-red-500"></span>
                                    </x-label>
                                    <x-input id="nomTuteur" x-model="nomTuteur" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nomTuteur" :value="old('nomTuteur')"  autofocus autocomplete="nomTuteur" />
                                    @error('nomTuteur')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="prenomTuteur">
                                        Prénom du Tuteur <span class="text-red-500"></span>
                                    </x-label>
                                    <x-input id="prenomTuteur" x-model="prenomTuteur" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenomTuteur" :value="old('prenomTuteur')"  autofocus autocomplete="prenomTuteur" />
                                    @error('prenomTuteur')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="numTelTuteur">
                                        Téléphone du tuteur <span class="text-red-500"></span>
                                    </x-label>
                                    <x-input id="numTelTuteur" x-model="numTelTuteur" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="numTelTuteur" :value="old('numTelTuteur')"  autofocus autocomplete="numTelTuteur" />
                                    @error('numTelTuteur')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror

                                </div>


                   


                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="prenomMere">
                                        Prénom de la mère <span class="text-red-500"></span>
                                    </x-label>
                                    <x-input id="prenomMere" x-model="prenomMere" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenomMere" :value="old('prenomMere')"  autofocus autocomplete="prenomMere" />
                                    @error('prenomMere')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="nomMere">
                                        Nom de la mère <span class="text-red-500"></span>
                                    </x-label>
                                    <x-input id="nomMere" x-model="nomMere" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nomMere" :value="old('nomMere')"  autofocus autocomplete="nomMere" />
                                    @error('nomMere')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>


                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="prenomPere">
                                        Prénom du père<span class="text-red-500"></span>
                                    </x-label>
                                    <x-input id="prenomPere" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenomPere" :value="old('prenomPere')"  autofocus autocomplete="prenomPere" />
                                    @error('prenomPere')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div x-show.transition.in="step === 2">


                            <div class="flex flex-wrap">

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="email">
                                        Email <span class="text-red-500"></span>
                                    </x-label>
                                    <x-input id="email" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="email" name="email" :value="old('email')"  autofocus autocomplete="email" />
                                    @error('email')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>


                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="telephone">
                                        Téléphone <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="telephone" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="telephone" :value="old('telephone')" required autofocus autocomplete="telephone" />
                                    @error('telephone')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>


                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="dateInsertion">
                                        Date d'insertion <span class="text-red-500"></span>
                                    </x-label>
                                    <x-input id="dateInsertion" x-model="dateInsertion" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="date" name="dateInsertion" :value="old('dateInsertion')"  autofocus autocomplete="dateInsertion" />
                                    @error('dateInsertion')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="autoEmploi">
                                        Auto emploi ? <span class="text-red-500"></span>
                                    </x-label>

                                    <select id="autoEmploi" x-model="autoEmploi" name="autoEmploi" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 "  autofocus>
                                        <option value="">Choisir une option</option>
                                        <option value="1">Oui</option>
                                        <option value="0">Non</option>
                                    </select>
                                    @error('autoEmploi')
                                    <span class="text-xs text-red-500">
                                        {{$message}}
                                    </span>
                                    @enderror

                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="emploiSalarie">
                                        Emploi salarié ?<span class="text-red-500"></span>
                                    </x-label>
                                    <select id="emploiSalarie" x-model="emploiSalarie" name="emploiSalarie" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " autofocus>
                                        <option value="">Choisir une option</option>
                                        <option value="1">Oui</option>
                                        <option value="0">Non</option>
                                    </select>
                                    @error('emploiSalarie')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="flex-grow mb-4 mr-2 hidden">
                                    <label for="etablissement_id">Sélectionner un établissement :</label>
                                    <x-input id="etablissement_id" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2" type="number" name="etablissement_id" :value="optional(auth()->user()->personnel)->etablissement_id" required autofocus autocomplete="etablissement_id" />

                                </div>




                            </div>

                        </div>

                    </div>
                    <!-- / Step Content -->
                </div>
            </div>

            <!-- Bottom Navigation -->
            <div class="bottom-0 left-0 right-0 py-5 bg-white shadow-md" x-show="step != 'complete'">
                <div class="max-w-3xl mx-auto px-4">
                    <div class="flex justify-between">
                        <div class="w-1/2">
                            <button x-show="step > 1" @click="step--" class="w-32 focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">Précédent</button>
                        </div>

                        <div class="w-1/2 text-right">
                            <!-- <button type="button" x-show="step < 2" @click="step++" class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Suivant</button> -->
                            <button type="button" x-show="step < 2" @click="if(validNextStep(step)) step++" class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Suivant</button>

                            <button x-show="step === 2" type="submit" class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    @else
    <div class="flex p-10 justify-center items-center">
        <h3 class="text-xl">Veuillez sélectionner une Classe !</h3>
    </div>
    @endif

    <script>
        function app() {
            return {
                step: 1,
                image: 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAAAAAAAD/4QBCRXhpZgAATU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAAkAAAAMAAAABAAAAAEABAAEAAAABAAAAAAAAAAAAAP/bAEMACwkJBwkJBwkJCQkLCQkJCQkJCwkLCwwLCwsMDRAMEQ4NDgwSGRIlGh0lHRkfHCkpFiU3NTYaKjI+LSkwGTshE//bAEMBBwgICwkLFQsLFSwdGR0sLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLP/AABEIAdoB2gMBIgACEQEDEQH/xAAfAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgv/xAC1EAACAQMDAgQDBQUEBAAAAX0BAgMABBEFEiExQQYTUWEHInEUMoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+fr/xAAfAQADAQEBAQEBAQEBAAAAAAAAAQIDBAUGBwgJCgv/xAC1EQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/APTmZsnmk3N60N1NJTELub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lJQA7c3rSbm9aSigBdzetG4+tJRQAZPrRuPrSUUALub1/lRub1pKSgBdzUbm9aSigBdzetG5vX+VJSUALub1/lUu5qhqXj1oAG6mkpW6mkoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooASiiigAooooAKSiigAooo+lACUZoooAKKKSgAo/rRSUALUlRVJz60AObqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACkoooAKKKKACiikoAKSlooASiiigA+lHpRQaACkoooATmilpPegBP/ANdS5HrUdSfL7UAObqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKSiigAooooAKKKKAEooooASij60UAFFFHpQAUmaKPxoAKSlpPWgA/wAmk/pS/Sk47dqADpUvPvUXrUn4H8qAHt1NJSt1NJQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFISFBJIAHUk4FAC0VTlv4EyEBc+3C/nVSS9uX6MEHonX8zQBrEqvLEAe5A/nUTXVqvWVfwyf5VjFmY5Ykn3JP86SmBrG/tB3c/RTTf7QtvST8hWXRQBqi/te+8f8AAc09by0b/loB/vAiseigDeV43+66t9CDTq5/p04+lTJdXMfSQkej/MP1oA2qKoR6gpwJUK/7Scj8utXEkjkG5GDD2P8AMUgH0UUUAFFFJQAUUUUAFFFJQAtJRRQAUlFFABR2oo+lAB1pKKP60AFFFFACUHjNH/66KAEpaSj/APVQAc0/I9KZUufpQA5uppKVuppKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACimsyopZiAo5JNZlxePLlI8rH0J/ib60AWp72KLKph3/wDHR9TWdLNNMcuxPoOij6Co6KYBRRRQAUUUUAFFFFABRRRQAUUUUAFKruhDIxUjuDikooA0IL/os4/4Gv8AUVfBVgCpBB6Ecg1gVLBcSwH5eUP3lPQ/SgDaoqOKaOZdyH/eB6qfepKQBRRRQAlFFFABSUUUAFFFFABRRSf5NABxR6e1FJQAcUUUnP6UALSf5/GjvRz+FAB06d6KT6UGgA96kyf8mo//ANdP59P1oAlbqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACmu6RqzucKvJNKSACScADJJ7Csi6uDO2BkRqflHr7mgBLi5edu4QH5V/qagoopgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFACUUUUAPjkkiYOhwR+RHoa14J0nTI4YffX0NYtPileJ1dDyOoPQj0NAG7SUyKVJkDr36juD6U+kAUhoooAKKKKACij/JpKACj/PNFFABScUelFACUdqP8mj+dABn9KMjij60d+tACf5FH5Uf59qOOlACfhUn40zmn4oAlbqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKhuJhDEz/xfdQerGgCpfXGT5CHgf6w+/8AdqhQSSSScknJPqTRTAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACkoooAKKKKACiiigCe2nMEnP+rbhx6e9bHoQevT3zXP1p2M+9DE33k5X/AHf/AK1AF2koNFIAoopKAFpKKPSgApPX0pf8mkoAKKTPP1paAE+lFFIT/ntQAelHAoz0oz/hQAd6T155oooAKk2+wqLPt/8AWqTj1P5GgCZuppKVuppKACiiigAooooAKKKKACiiigAooooAKKKKACiiigArJvpd8uwH5Y+P+BHrWnK4jjkc/wAKkj69qwiSSSepJJ+ppgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABSUUUAFFFFABRRSUAFFFFABT4pDFIkg/hPPuO4plFAG8CGAYchgCD7HmlqpYy74dp6xnH4HkVapALSUUUAH+NFFJQAc0f5+tHFJQAUUUepoAP/r0nP/1sUH1ozQAUnOaPwo9OlAAcd6T60tJQAHn+lSZPotR/55qTJ/yKAJm6mkpW6mkoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAKWoPiNE/vtk/RazKt6g2Zgv9xB+Z5qpTAKKKKACiiigAooooAKKKKA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',
                nom: '',
                annee_academique_id: '',
                prenom: '',
                adresse: '',
                date_naissance: '',
                lieu_naissance: '',
                sexe: '',
                matricule: '',
                nomTuteur: '',
                prenomTuteur: '',
                numTelTuteur: '',
                situationMatrimoniale: '',
                prenomPere: '',
                nomPere: '',
                prenomMere: '',
                nomMere: '',
                email: '',
                tel: '',
                dateInsertion: '',
                autoEmploi: '',
                emploiSalarie: '',

                validNextStep(step) {
                    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    inp1 = ['nom', 'prenom', 'date_naissance', 'lieu_naissance', 'commune_id', 'adresse', 'sexe','annee_academique_id']
                    inp2 = ['tel', 'email', 'dateInsertion', 'autoEmploi', 'emploiSalarie'];
                    ok = 1;
                    if (step === 1) {
                        for (let ix = 0; ix < inp1.length; ix++) {
                            const el = inp1[ix];
                            if ($("#" + el).val() == '') {
                                $("#" + el).focus();
                                ok = 0;
                                break;
                            }
                        }
                    } else if (step === 2) {
                        for (let ix = 0; ix < inp2.length; ix++) {
                            const el = inp2[ix];
                            if ($("#" + el).val() == '') {
                                $("#" + el).focus();
                                ok = 0;
                                break;
                            }
                        }
                    }
                    step++;
                    return ok;
                    // console.log("Afficher step======>", this.step);
                }


            }
        }
    </script>
</x-app-layout>
