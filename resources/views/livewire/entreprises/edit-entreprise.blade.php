<div class="bg-white shadow rounded-sm w-full p-4">
    <h2 class="font-bold text-maquette-gris text-xl">
        Edition
    </h2>
    <div class="w-full mx-auto">
        <form class="bg-white shadow-md rounded pt-6 pb-8 mb-4" action="{{ route('entreprise.update', $entreprise->id) }}" method="POST">
            <div class="mt-5 pb-12 pt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 bg-white shadow-xl w-full rounded-sm">

                <div class="max-w-7xl sm:px-2 lg:px-4 shadow-xl">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Edition de l'investisseur
                    </h3>
                    <div class="border border-gray-200 p-4">
                        @csrf
                        @method('PUT')
                        <div class="p-5">
                            <div class="mb-4">
                                <label for="nom_entreprise" class="block text-gray-700 text-sm font-bold mb-2">Nom de l'entreprise</label>
                                <input type="text" class="border border-gray-300 p-2 w-full focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm" id="nom_entreprise" name="nom_entreprise" value="{{ $entreprise->nom_entreprise }}">
                                @error('nom_entreprise')
                                    {{$message}}
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="ninea" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">NINEA</label>
                                <input type="text" class="border border-gray-300 p-2 w-full" id="ninea" name="ninea" value="{{ $entreprise->ninea }}">
                            </div>

                            <div class="mb-4">
                                <label for="effectif" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Effectif</label>
                                <input type="number" class="border border-gray-300 p-2 w-full" id="effectif" name="effectif" value="{{ $entreprise->effectif }}">
                            </div>

                            <div class="mb-4">
                                <label for="email_entreprise" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Email de l'entreprise</label>
                                <input type="email" class="border border-gray-300 p-2 w-full" id="email_entreprise" name="email_entreprise" value="{{ $entreprise->email_entreprise }}">
                            </div>

                            <div class="mb-4">
                                <label for="date_creation" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Date de création</label>
                                <input type="date" class="border border-gray-300 p-2 w-full" id="date_creation" name="date_creation" value="{{ $entreprise->date_creation }}">
                            </div>

                        </div>

                    </div>

                </div>
                <div class="max-w-7xl sm:px-2 lg:px-4 shadow-xl">
                    <h3 class="bg-gray-100 p-2 text-sm font-bold text-first-orange">
                        Information du compte
                    </h3>
                    <div class="border-gray-200 border p-4">

                        <div class="p-5">
                            <div class="mb-4">
                                <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Prénom</label>
                                <input type="text" class="border border-gray-300 p-2 w-full" id="prenom" name="prenom" value="{{ $entreprise->user->prenom }}">
                            </div>
                            <div class="mb-4">
                                <label for="nom" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Nom</label>
                                <input type="text" class="border border-gray-300 p-2 w-full" id="nom" name="nom" value="{{ $entreprise->user->nom }}">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Email</label>
                                <input type="email" class="border border-gray-300 p-2 w-full" id="email" name="email" value="{{ $entreprise->user->email }}">
                            </div>

                            <div class="mb-4">
                                <label for="date_naissance" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Date de naissance </label>
                                <input type="date" class="border border-gray-300 p-2 w-full" id="date_naissance" name="date_naissance" value="{{ $entreprise->user->date_naissance }}">
                            </div>

                            <div class="mb-4">
                                <label for="lieu_naissance" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Lieu de naissance </label>
                                <input type="text" class="border border-gray-300 p-2 w-full" id="lieu_naissance" name="lieu_naissance" value="{{ $entreprise->user->lieu_naissance }}">
                            </div>

                            <div class="mb-4">
                                <label for="adresse" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Adresse </label>
                                <input type="text" class="border border-gray-300 p-2 w-full" id="adresse" name="adresse" value="{{ $entreprise->user->adresse }}">
                            </div>

                            <div class="mb-4">
                                <label for="telephone" class="block text-gray-700 text-sm font-bold mb-2 focus:border-first-orange enlever_shadow rounded px-2 py-0.75 shadow-first-orange text-sm">Téléphone </label>
                                <input type="text" class="border border-gray-300 p-2 w-full" id="telephone" name="telephone" value="{{ $entreprise->user->telephone }}">
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="my-5 bg-first-orange rounded-sm px-3 py-1 text-white hover:bg-first-orange">Enregistrer</button>
                </div>
            </div>





        </form>

    </div>
</div>
