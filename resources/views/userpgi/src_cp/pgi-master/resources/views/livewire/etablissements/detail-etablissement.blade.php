<style>
    input {
        border: none;
    }
</style>

<div class="bg-transparent shadow rounded-sm w-full p-4">
    <div class="mt-2 mb-2">
        <a href="{{ route('etablissement.index') }}" class="text-blue-500 hover:underline">&larr; Retour à la liste des
            établissements</a>
    </div>
    <div class="bg-white w-full mx-auto pb-4">
        <div class="md:container md:mx-auto">
            <div class="w-full sm:px-2 lg:px-4 ">
                <div class="flex mb-4 text-sm font-bold bg-white px-4 py-3 rounded-sm">
                    <p>
                        <a href="/dashboard" class="text-maquette-gris">Accueil</a>
                        <span class="mx-2 text-maquette-gris">/</span>
                    </p>
                    <p> <a href="{{route('etablissement.index')}}">Etablissements </a>
                        <span class="mx-2 text-maquette-gris">/</span>
                    </p>
                    <p class="text-first-orange">Visualiser</p>
                    <p></p>
                </div>
                <div class="flex-1 border border-gray-200">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Visualisation de l'établissement
                    </h3>
                    <div class="p-5">

                        <div class="flex justify-end items-center gap-x-6">
                            @can('edit_etablissement')
                            <a href="{{route('etablissement.edit', $etablissement->id)}}" class="w-max px-2 rounded-md py-1 flex items-center text-sm text-center bg-orange-700 text-white }}">
                                <i class="fa fa-edit"></i>
                                <span class="ml-1">Modifier</span>
                            </a>

                            <a href="{{route('etablissement.send', $etablissement->id)}}" class="w-max px-2 rounded-md py-1 flex items-center text-sm text-center bg-blue-700 text-white }}">
                                <i class="fa fa-key"></i>
                                <span class="ml-1">Envoyer les accès</span>
                            </a>
                            @endcan
                            <a href="{{route('program.view', $etablissement->id)}}" class="w-max px-2 rounded-md py-1 flex items-center text-sm text-center bg-black text-white }}">
                                <i class="fa fa-book"></i>
                                <span class="ml-1">Programmes de formation</span>
                            </a>
                            <a href="{{route('demande.demandebyEfpt', $etablissement->id)}}" class="w-max px-2 rounded-md py-1 flex items-center text-sm text-center bg-orange-500  text-white }}">
                                <i class="fa fa-book"></i>
                                <span class="ml-1">Demandes</span>
                            </a>
                            @can('edit_etablissement')
                            {!! Form::open(array(
                            'method' => 'PATCH',
                            'class' => 'apix-form',
                            'style' => 'display: inline;',
                            'route' => ['users.activationEtablissement', $etablissement->id, $etablissement->is_active]))!!}
                            {{ csrf_field() }}
                            <a href="#" class="w-max px-2 rounded-md py-1 flex items-center text-sm text-center {{$etablissement->is_active ? 'bg-red-600 text-white' : 'bg-green-600 text-white'}} apix-confirm" data-toggle="tooltip" title="{{$etablissement->is_active ? 'Désactiver' : 'Activer'}} mot de passe">
                                <i class="fas fa-{{$etablissement->is_active ? 'close' : 'check'}}"></i>
                                <span class="ml-1">{{$etablissement->is_active ? 'Désactiver' : 'Activer'}}</span>
                            </a>
                            {!! Form::close() !!}
                            @endcan
                        </div>


                        <div class="grid md:grid-cols-1 md:gap-6 pt-2">
                            <div class="mb-4">
                                <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Logo :</label>
                                @if(!empty($etablissement->logo))
                                <img class="thumbnail-slider py-4" src="{{ asset('storage/etablissements/'. $etablissement->logo) }}" alt="{{$etablissement->sigle}}" />
                                @endif
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-2 flex justify-between items-center">
                                <label for="nom_etablissement" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Nom de l'établissement :</label>
                                <input readonly type="text" value="{{ old('nom') ?? $etablissement->nom}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="nom" name="nom">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="sigle" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Sigle :</label>
                                <input readonly type="text" value="{{ old('sigle') ?? $etablissement->sigle}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="sigle" name="sigle">

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-2 flex justify-between items-center">
                                <label for="nom_etablissement" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Site web :</label>
                                <input readonly type="text" value="{{ old('siteWeb') ?? $etablissement->siteWeb}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="siteWeb" name="siteWeb">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="sigle" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Adresse :</label>
                                <input readonly type="text" value="{{ old('adresse') ?? $etablissement->adresse}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="adresse" name="adresse">

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-2 flex justify-between items-center">
                                <label for="email" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Email :</label>
                                <input readonly type="email" value="{{ old('email') ?? $etablissement->email}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="email" name="email">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="boitePostale" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Téléphone :</label>
                                <input readonly type="tel" value="{{ old('telephone') ?? $etablissement->telephone}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="telephone" name="telephone">

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-2 flex justify-between items-center">
                                <label for="boitePostale" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Boite postale :</label>
                                <input readonly type="text" value="{{ old('adresse') ?? $etablissement->adresse}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="boitePostale" name="boitePostale">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="type" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Type :</label>
                                <input readonly type="text" value="{{ old('type') ?? $etablissement->type}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="type" name="type">

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-2 flex justify-between items-center">
                                <label for="statut" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Statut :</label>
                                <input readonly type="text" value="{{ old('statut') ?? $etablissement->statut}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="statut" name="statut">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="statutJuridique" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Statut juridique :</label>
                                <input readonly type="text" value="{{ old('statutJuridique') ?? $etablissement->statutJuridique}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="statutJuridique" name="statutJuridique">

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-2 flex justify-between items-center">
                                <label for="reference" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Reference :</label>
                                <input readonly type="text" value="{{ old('reference') ?? $etablissement->reference}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="reference" name="reference">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="dateCreation" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Date création :</label>
                                <input readonly type="date" value="{{ old('dateCreation') ?? $etablissement->dateCreation}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="dateCreation" name="dateCreation">

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-2 flex justify-between items-center">
                                <label for="nomResponsable" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Nom responsable :</label>
                                <input readonly type="text" value="{{ old('nomResponsable') ?? $etablissement->nomResponsable}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="nomResponsable" name="nomResponsable">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="prenomResponsable" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Prénoms responsable :</label>
                                <input readonly type="text" value="{{ old('prenomResponsable') ?? $etablissement->prenomResponsable}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="prenomResponsable" name="prenomResponsable">

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-2 flex justify-between items-center">
                                <label for="numRecipisse" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Numéro recepisse :</label>
                                <input readonly type="text" value="{{ old('numRecipisse') ?? $etablissement->numRecipisse}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="numRecipisse" name="numRecipisse">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="dateRecepisseDepot" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Date recepisse dépôt :</label>
                                <input readonly type="date" value="{{ old('dateRecepisseDepot') ?? $etablissement->dateRecepisseDepot}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="dateRecepisseDepot" name="dateRecepisseDepot">

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                            <div class="mb-2 flex justify-between items-center">
                                <label for="numAutOuv" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Numéro AutOuv :</label>
                                <input readonly type="text" value="{{ old('numAutOuv') ?? $etablissement->numAutOuv}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="numAutOuv" name="numAutOuv">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="dateAutOuv" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Date AutOuv :</label>
                                <input readonly type="date" value="{{ old('dateAutOuv') ?? $etablissement->dateAutOuv}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="dateAutOuv" name="dateAutOuv">

                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">

                            <div class="mb-2 flex justify-between items-center ">
                                <label for="dateAutOuv" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Région :</label>
                                <input readonly type="text" value="{{ $etablissement->commune->departement->region->libelle }}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="commune_id" name="commune_id">

                            </div>
                            <div class="mb-2 flex justify-between items-center ">
                                <label for="specifite" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Département :</label>
                                <input readonly type="text" value="{{ $etablissement->commune->departement->libelle }}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="specifite" name="specifite">

                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6 pt-2">

                            <div class="mb-2 flex justify-between items-center ">
                                <label for="dateAutOuv" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Commune :</label>
                                <input readonly type="text" value="{{ $etablissement->commune->libelle }}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="commune_id" name="commune_id">

                            </div>
                            <div class="mb-2 flex justify-between items-center">
                                <label for="specifite" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Spécifité :</label>
                                <input readonly type="text" value="{{ old('specifite') ?? $etablissement->specifite}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="specifite" name="specifite">

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>