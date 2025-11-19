<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modification d\'un établissement') }}
        </h2>
    </x-slot>

    <div class="flex mb-4 text-sm font-bold p-3 bg-white">
        <p>
            <a href="{{route('etablissement.index')}}" class="text-gray-800">Liste des établissements</a>
        </p>
        <span class="mx-2 text-gray-800">/</span>
        <p class="text-first-orange">Editer d'un nouveau établissement</p>
    </div>


    <div x-data="app()">
        <form action="{{ route('etablissement.update', $etablissement->id) }}" method="POST" class="bg-white border-x-2 rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT') 
            <div class="max-full mx-auto px-4 py-10">

                <div x-show.transition="step === 'complete'">
                    <div class="bg-white rounded-lg p-10 flex items-center shadow justify-between">
                        <div>
                            <svg class="mb-4 h-20 w-20 text-green-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>

                            <h2 class="text-2xl mb-4 text-gray-800 text-center font-bold">Succès</h2>

                            <div class="text-gray-600 mb-8">
                                Merci. Un mail est envoyé au responsable de l'établissement comportant ses accès.
                            </div>

                            <button @click="step = 1" class="w-40 block mx-auto focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">Back to home</button>
                        </div>
                    </div>
                </div>


                <div x-show.transition="step != 'complete'">
                    <!-- Top Navigation -->

                    <div class="border-b-2 py-4">
                        <div class="uppercase tracking-wide text-xs font-bold text-gray-500 mb-1 leading-tight" x-text="`Etape: ${step} sur 3`"></div>
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div x-show="step === 1">
                                    <div class="text-lg font-bold text-gray-700 leading-tight">Informations Générales</div>
                                </div>

                                <div x-show="step === 2">
                                    <div class="text-lg font-bold text-gray-700 leading-tight">Contacts</div>
                                </div>

                                <div x-show="step === 3">
                                    <div class="text-lg font-bold text-gray-700 leading-tight">Détails du récépissé</div>
                                </div>
                            </div>

                            <div class="flex items-center md:w-64">
                                <div class="w-full bg-orange-200  rounded-full mr-2">
                                    <div class="rounded-full bg-orange-300 text-xs leading-none h-2 text-center text-white" :style="'width: '+ parseInt(step / 3 * 100) +'%'"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Top Navigation -->

                    <!-- Step Content -->
                    <div class="py-10">
                        <div x-show.transition.in="step === 1">

                            <div class="flex flex-wrap">
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="nom">
                                        Nom <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="nom"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nom" value="{{$etablissement->nom}}" required autofocus autocomplete="nom" />
                                    @error('nom')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="sigle">
                                        Sigle <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="sigle"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="sigle" value="{{$etablissement->sigle}}" required autofocus autocomplete="sigle" />
                                    @error('sigle')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="prenomResponsable">
                                        Prénom du responsable
                                    </x-label>
                                    <x-input id="prenomResponsable" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="prenomResponsable" value="{{$etablissement->prenomResponsable}}" autofocus autocomplete="prenomResponsable" />
                                    @error('prénom du responsable')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="nomResponsable">
                                        Nom du responsable
                                    </x-label>
                                    <x-input id="nomResponsable" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="nomResponsable" value="{{$etablissement->nomResponsable}}" required autofocus autocomplete="nomResponsable" />
                                    @error('nom du responsable')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="reference">
                                        Référence <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="reference"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="reference" value="{{$etablissement->reference}}" required autofocus autocomplete="reference" />
                                    @error('reference')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="dateCreation">
                                        Date de création <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="dateCreation" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="date" name="dateCreation" value="{{$etablissement->dateCreation}}" required autofocus autocomplete="dateCreation" />
                                    @error('date de création')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>


                            {{--   <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="statutJuridique">
                                        Statut juridique <span class="text-red-500">*</span>
                                    </x-label>
                                    <select  class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="statutJuridique"  name="statutJuridique">
                                        <option value="">Choisir le statut juridique</option>
                                        @if($statutJuridiques->count() >= 1)
                                        @foreach($statutJuridiques as $statutJuridique)
                                        <option value="{{$statutJuridique->valeur}}" {{ $etablissement->statutJuridique == $statutJuridique->valeur ? 'selected' : '' }}>{{$statutJuridique->valeur}}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                </div>  --}}
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="statut">
                                        Statut <span class="text-red-500">*</span>
                                    </x-label>
                                    <select  class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="statut" name="statut">
                                        <option value="">Choisir le statut</option>
                                        @if($statuts->count() >= 1)
                                        @foreach($statuts as $statut)
                                        <option value="{{$statut->valeur}}" {{ $etablissement->statut == $statut->valeur ? 'selected' : '' }}>{{$statut->valeur}}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                </div>

                            </div>
                        </div>
                        <div x-show.transition.in="step === 2">


                            <div class="flex flex-wrap">
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="telephone">
                                        Téléphone <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="telephone" x-model="telephone" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="telephone" value="{{$etablissement->telephone}}" required autofocus autocomplete="telephone" />
                                    @error('telephone')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="email">
                                        Email <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="email"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="email" name="email" value="{{$etablissement->email}}" required autofocus autocomplete="email" />
                                    @error('email')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="siteWeb">
                                        Site Web
                                    </x-label>
                                    <x-input id="siteWeb"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="siteWeb"  value="{{$etablissement->siteWeb}}" autofocus autocomplete="siteWeb" />
                                    @error('site web')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="adresse">
                                        Adresse <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="adresse"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="adresse"  value="{{$etablissement->adresse}}" siteWeb required autofocus autocomplete="adresse" />
                                    @error('adresse')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="specifite">
                                        Spécificité
                                    </x-label>
                                    <x-input id="specifite" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="specifite"   value="{{$etablissement->specifite}}" autofocus autocomplete="specifite" />
                                    @error('spécifite')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="boitePostale">
                                        Boîte postale <span class="text-red-500">*</span>
                                    </x-label>
                                    <x-input id="boitePostale"  class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="boitePostale"  value="{{$etablissement->boitePostale}}" required autofocus autocomplete="boitePostale" />
                                    @error("boîte postale")
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="type">
                                        Type <span class="text-red-500">*</span>
                                    </x-label>
                                    <select  class="shadow appearance-none border-2 border-gray-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" name="type">
                                        <option value="">Choisir le type</option>
                                        @if($types->count() >= 1)
                                        @foreach($types as $type)
                                        <option value="{{$type->valeur}}" {{ $etablissement->type == $type->valeur ? 'selected' : '' }}>{{$type->valeur}}</option>
                                        @endforeach
                                        @endif

                                    </select>
                                </div>
                         
                     @livewire('param.localisation')
                            </div>

                        </div>
                        <div x-show.transition.in="step === 3">

                            <div class="flex flex-wrap">
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="dateAutOuv">
                                        Date d'autorisation d'ouverture
                                    </x-label>
                                    <x-input id="dateAutOuv" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="date" name="dateAutOuv"  value="{{$etablissement->dateAutOuv}}" autofocus autocomplete="dateAutOuv" />
                                    @error("date d'autorisation d'ouverture")
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="numAutOuv">
                                        Numéro d'autorisation d'ouverture
                                    </x-label>
                                    <x-input id="numAutOuv" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="numAutOuv"  value="{{$etablissement->numAutOuv}}" autofocus autocomplete="numAutOuv" />
                                    @error("numéro d'autorisation d'ouverture")
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>

                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="dateRecepisseDepot">
                                        Date récépissé de dépot
                                    </x-label>
                                    <x-input id="dateRecepisseDepot" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="date" name="dateRecepisseDepot" value="{{$etablissement->dateRecepisseDepot}}" autofocus autocomplete="dateRecepisseDepot" />
                                    @error('date récépissé de dépot')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
                                </div>
                                <div class="w-full sm:w-1/2 px-2 pb-5">
                                    <x-label for="numRecipisse">
                                        Numéro de récépissé
                                    </x-label>
                                    <x-input id="numRecipisse" class="block w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm border-2 " type="text" name="numRecipisse"  value="{{$etablissement->numRecipisse}}" autofocus autocomplete="numéro de récépissé" />
                                    @error('numéro de récépissé')
                                    <span class="text-xs text-red-500">
                                        {{$message}}

                                    </span>
                                    @enderror
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
                            <button type="button" x-show="step < 3" @click="step++" class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Suivant</button>

                            <button x-show="step === 3" type="submit" class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
            function app() {
                return {
                    step: 1,
                    image: 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAAAAAAAD/4QBCRXhpZgAATU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAAkAAAAMAAAABAAAAAEABAAEAAAABAAAAAAAAAAAAAP/bAEMACwkJBwkJBwkJCQkLCQkJCQkJCwkLCwwLCwsMDRAMEQ4NDgwSGRIlGh0lHRkfHCkpFiU3NTYaKjI+LSkwGTshE//bAEMBBwgICwkLFQsLFSwdGR0sLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLCwsLP/AABEIAdoB2gMBIgACEQEDEQH/xAAfAAABBQEBAQEBAQAAAAAAAAAAAQIDBAUGBwgJCgv/xAC1EAACAQMDAgQDBQUEBAAAAX0BAgMABBEFEiExQQYTUWEHInEUMoGRoQgjQrHBFVLR8CQzYnKCCQoWFxgZGiUmJygpKjQ1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4eLj5OXm5+jp6vHy8/T19vf4+fr/xAAfAQADAQEBAQEBAQEBAAAAAAAAAQIDBAUGBwgJCgv/xAC1EQACAQIEBAMEBwUEBAABAncAAQIDEQQFITEGEkFRB2FxEyIygQgUQpGhscEJIzNS8BVictEKFiQ04SXxFxgZGiYnKCkqNTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqCg4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2dri4+Tl5ufo6ery8/T19vf4+fr/2gAMAwEAAhEDEQA/APTmZsnmk3N60N1NJTELub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lFAC7m9aNzetJRQAu5vWjc3rSUUALub1o3N60lJQA7c3rSbm9aSigBdzetG4+tJRQAZPrRuPrSUUALub1/lRub1pKSgBdzUbm9aSigBdzetG5vX+VJSUALub1/lUu5qhqXj1oAG6mkpW6mkoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooASiiigAooooAKSiigAooo+lACUZoooAKKKSgAo/rRSUALUlRVJz60AObqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACkoooAKKKKACiikoAKSlooASiiigA+lHpRQaACkoooATmilpPegBP/ANdS5HrUdSfL7UAObqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKSiigAooooAKKKKAEooooASij60UAFFFHpQAUmaKPxoAKSlpPWgA/wAmk/pS/Sk47dqADpUvPvUXrUn4H8qAHt1NJSt1NJQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFISFBJIAHUk4FAC0VTlv4EyEBc+3C/nVSS9uX6MEHonX8zQBrEqvLEAe5A/nUTXVqvWVfwyf5VjFmY5Ykn3JP86SmBrG/tB3c/RTTf7QtvST8hWXRQBqi/te+8f8AAc09by0b/loB/vAiseigDeV43+66t9CDTq5/p04+lTJdXMfSQkej/MP1oA2qKoR6gpwJUK/7Scj8utXEkjkG5GDD2P8AMUgH0UUUAFFFJQAUUUUAFFFJQAtJRRQAUlFFABR2oo+lAB1pKKP60AFFFFACUHjNH/66KAEpaSj/APVQAc0/I9KZUufpQA5uppKVuppKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACimsyopZiAo5JNZlxePLlI8rH0J/ib60AWp72KLKph3/wDHR9TWdLNNMcuxPoOij6Co6KYBRRRQAUUUUAFFFFABRRRQAUUUUAFKruhDIxUjuDikooA0IL/os4/4Gv8AUVfBVgCpBB6Ecg1gVLBcSwH5eUP3lPQ/SgDaoqOKaOZdyH/eB6qfepKQBRRRQAlFFFABSUUUAFFFFABRRSf5NABxR6e1FJQAcUUUnP6UALSf5/GjvRz+FAB06d6KT6UGgA96kyf8mo//ANdP59P1oAlbqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACmu6RqzucKvJNKSACScADJJ7Csi6uDO2BkRqflHr7mgBLi5edu4QH5V/qagoopgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFACUUUUAPjkkiYOhwR+RHoa14J0nTI4YffX0NYtPileJ1dDyOoPQj0NAG7SUyKVJkDr36juD6U+kAUhoooAKKKKACij/JpKACj/PNFFABScUelFACUdqP8mj+dABn9KMjij60d+tACf5FH5Uf59qOOlACfhUn40zmn4oAlbqaSlbqaSgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKhuJhDEz/xfdQerGgCpfXGT5CHgf6w+/8AdqhQSSSScknJPqTRTAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACkoooAKKKKACiiigCe2nMEnP+rbhx6e9bHoQevT3zXP1p2M+9DE33k5X/AHf/AK1AF2koNFIAoopKAFpKKPSgApPX0pf8mkoAKKTPP1paAE+lFFIT/ntQAelHAoz0oz/hQAd6T155oooAKk2+wqLPt/8AWqTj1P5GgCZuppKVuppKACiiigAooooAKKKKACiiigAooooAKKKKACiiigArJvpd8uwH5Y+P+BHrWnK4jjkc/wAKkj69qwiSSSepJJ+ppgFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABSUUUAFFFFABRRSUAFFFFABT4pDFIkg/hPPuO4plFAG8CGAYchgCD7HmlqpYy74dp6xnH4HkVapALSUUUAH+NFFJQAc0f5+tHFJQAUUUepoAP/r0nP/1sUH1ozQAUnOaPwo9OlAAcd6T60tJQAHn+lSZPotR/55qTJ/yKAJm6mkpW6mkoAKKKKACiiigAooooAKKKKACiiigAooooAKKKKAKWoPiNE/vtk/RazKt6g2Zgv9xB+Z5qpTAKKKKACiiigAooooAKKKKA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',
                    nom: '',
                    sigle: '',
                    reference: '',
                    dateCreation: '',
                    telephone: '',
                    email: '',
                    adresse: '',
                    boitePostale: '',
                    siteWeb: '',
                    type: '',
                    statutJuridique: '',
                    statut: '',
                    commune_id: '',
                    dateAutOuv: '',
                    numAutOuv: '',
                    dateRecepisseDepot: '',
                    numRecipisse: '',
                    validNextStep(step) {
                        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (step === 1) {
                            if (this.nom.length > 0 && this.sigle.length > 0  && this.reference.length > 0 && this.dateCreation.length > 0) {
                                this.step++;
                            }
                        } else if (step === 2) {
                            if (this.telephone.length > 0 && this.email.length > 0 && this.email.match(regex)  && this.adresse.length > 0 && this.boitePostale.length > 0) {
                                this.step++;
                            }
                        } else if (step === 3) { // Ajouter une vérification pour l'étape 3
                            if (this.dateAutOuv.length > 0 && this.numAutOuv.length > 0 && this.dateRecepisseDepot.length > 0 && this.numRecipisse.length > 0) {
                                // Assurez-vous de vérifier toutes les conditions nécessaires pour l'étape 3
                                this.step++;
                            }
                        }
                        console.log("Afficher step======>", this.step);
                    }


                }
            }
        </script>


</x-app-layout>
