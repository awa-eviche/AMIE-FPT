<div>
    <div class="max-w-10xl mx-auto">
        <div class="flex flex-col lg:flex-row">
            <!-- Première colonne -->
            <div class="lg:w-full flex justify-between items-center px-4 py-2">
                <div>
                    <span class="text-gray-700 font-bold text-lg font-medium">
                        <a href="{{ route('inscription.index') }}">
                            <span><i class="fa fa-angle-left"></i></span> 
                            <span class="text-gray-700 text-xl font-bold pl-2">
                            Fiche détaillée de l'apprenant {{ $apprenant->nom }} {{ $apprenant->prenom }}</span>
                        </a>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="flex md:flex-wrap justify-between  mt-8 mb-10">
        <div class="flex md:w-full  flex-col">
            <div class="rounded-lg shadow-sm px-8 py-5 bg-white">
                <div class="flex justify-between text-black items-center">
                    <span class="text-first-orange font-bold text-md">Informations générales</span>
                    <a class="text-orange-600 bg-orange-100 text-sm rounded-md shadow-md px-4 py-1" href="{{ route('apprenant.edit', $apprenant->id) }}">
                        Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white w-full mx-auto pb-4">
                <div class="md:container md:mx-auto">
                    <div class="w-full sm:px-2 lg:px-4 ">
                     
                        <div class="flex-1 border border-gray-200">
                            <div class="p-5">
                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="nom" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Nom:</label>
                                        <input readonly type="text" value="{{ old('nom') ?? $apprenant->nom}}"  class="flex-1 border border-gray-100 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="nom" name="nom" >

                                    </div>
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="prenom" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Prénom :</label>
                                        <input readonly type="text" value="{{ old('prenom') ??  $apprenant->prenom}}"  class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="prenom" name="prenom" >

                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="date_naissance" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Date de naissance :</label>
                                        <input readonly type="text" value="{{ old('da') ?? $apprenant->date_naissance}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="date_naissance" name="date_naissance" >

                                    </div>
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="lieu_naissance" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Lieu de naissance :</label>
                                        <input readonly type="text" value="{{ old('lieu_naissance') ?? $apprenant->lieu_naissance}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="lieu_naissance" name="lieu_naissance" >

                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="nomTuteur" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Nom Tuteur :</label>
                                        <input readonly type="nomTuteur" value="{{ old('nomTuteur') ?? $apprenant->nomTuteur}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="nomTuteur" name="nomTuteur" >

                                    </div>
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="prenomTuteur" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Prénom :</label>
                                        <input readonly type="tel" value="{{ old('prenomTuteur') ?? $apprenant->prenomTuteur}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="prenomTuteur" name="prenomTuteur" >

                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="numTelTuteur" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Numéro Tuteur :</label>
                                        <input readonly type="text" value="{{ old('numTelTuteur') ?? $apprenant->numTelTuteur}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="numTelTuteur" name="numTelTuteur" >

                                    </div>
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="situationMatrimoniale" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Situation matrimoniale :</label>
                                        <input readonly type="text" value="{{ old('situationMatrimoniale') ?? $apprenant->situationMatrimoniale}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="situationMatrimoniale" name="situationMatrimoniale" >

                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="prenomPere" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Prénom père :</label>
                                        <input readonly type="text" value="{{ old('prenomPere') ?? $apprenant->prenomPere }}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="prenomPere" name="prenomPere" >

                                    </div>
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="nomPere" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Nom Père :</label>
                                        <input readonly type="text" value="{{ old('nomPere') ?? $apprenant->nomPere}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="nomPere" name="nomPere" >

                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="prenomMere" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Prénom mère :</label>
                                        <input readonly type="text" value="{{ old('prenomMere') ?? $apprenant->prenomMere}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="prenomMere" name="prenomMere" >

                                    </div>
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="nomMere" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Nom mère :</label>
                                        <input readonly type="date" value="{{ old('nomMere') ??$apprenant->nomMere}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="nomMere" name="nomMere" >

                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="email" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Email :</label>
                                        <input readonly type="text" value="{{ old('email') ?? $apprenant->email}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="email" name="email" >

                                    </div>
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="telephone" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Téléphone :</label>
                                        <input readonly type="text" value="{{ old('telephone') ?? $apprenant->telephone}}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="telephone" name="telephone" >

                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="dateInsertion" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Date insertion :</label>
                                        <input readonly type="text" value="{{ old('dateInsertion') ?? $apprenant->dateInsertion }}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="dateInsertion" name="dateInsertion" >

                                    </div>
                                
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">
                                    <div class="mb-2 flex justify-between items-center">
                                        <label for="autoEmploi" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Auto Emploi :</label>
                                      <span  class="flex-1  p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="autoEmploi"></span>  {{ $apprenant->autoEmploi == 1 ? "OUI" : "NON" }}

                                    </div>
                                    <div class="mb-2 flex justify-between items-center">
                                    <label for="emploiSalarie" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Emploi Salarié :</label>
                                      <span  class="flex-1  p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="emploiSalarie"></span>  {{ $apprenant->emploiSalarie == 1 ? "OUI" : "NON" }}

                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">

                                    <div class="mb-2 flex justify-between items-center ">
                                        <label for="dateAutOuv" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Région :</label>
                                        <input readonly type="text" value="{{ $apprenant->commune->departement->region->libelle }}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="commune_id" name="commune_id" >

                                    </div>
                                    <div class="mb-2 flex justify-between items-center ">
                                        <label for="specifite" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Département :</label>
                                        <input readonly type="text" value="{{ $apprenant->commune->departement->libelle }}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="specifite" name="specifite" >

                                    </div>
                                </div>
                                <div class="grid md:grid-cols-2 md:gap-6 pt-2">

                                    <div class="mb-2 flex justify-between items-center ">
                                        <label for="dateAutOuv" class="flex-1 block text-gray-700 text-sm font-bold mb-2">Commune :</label>
                                        <input readonly type="text" value="{{ $apprenant->commune->libelle }}" class="flex-1 border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="commune_id" name="commune_id" >

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
        </div>

</div>