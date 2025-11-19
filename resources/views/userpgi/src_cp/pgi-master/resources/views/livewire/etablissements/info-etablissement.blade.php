<div class="container mx-auto px-4 py-16">
    <h1 class="text-3xl font-bold text-left mb-8">Mon établissement</h1>

    @if ($etablissement)
    <div class="bg-white shadow-md rounded-lg px-6 py-8 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col space-y-6">
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Nom:</span>
                    <span class="ml-2 text-gray-900 font-bold text-lg">{{ $etablissement->nom ?? "Non renseigné" }}</span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Acronym:</span>
                    <span class="ml-2 text-gray-900 font-bold text-lg">{{ $etablissement->sigle ?? "Non renseigné"}}</span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Adresse:</span>
                    <span class="ml-2 text-gray-900 text-lg">{{ $etablissement->adresse ?? "Non renseigné" }}</span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Boîte Postale:</span>
                    <span class="ml-2 text-gray-900 text-lg font-bold">{{ $etablissement->boitePostale ?? "Non renseigné"}}</span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Date de création:</span>
                    <span class="ml-2 text-gray-900 text-lg font-bold">{{ strftime('%d/%m/%Y', strtotime($etablissement->dateCreation)) ?? "Non renseigné" }}</span>
                </div>
            </div>

            <div class="flex flex-col space-y-6">
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Site Web:</span>
                    <a href="{{ $etablissement->siteWeb }}" class="ml-2 text-blue-500 hover:underline">{{ $etablissement->siteWeb ?? "Non renseigné" }}</a>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Email:</span>
                    <span class="ml-2 text-gray-900 text-lg">{{ $etablissement->email ?? "Non renseigné" }}</span>
                </div>
                <div class="flex items-center border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Téléphone:</span>
                    <span class="ml-2 text-gray-900 text-lg">{{ $etablissement->telephone ?? "Non renseigné" }}</span>
                </div>
                <div class="flex items-center  border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Reference:</span>
                    <span class="ml-2 text-gray-900 text-lg">{{ $etablissement->reference }}</span>
                </div>
                <div class="flex items-center  border-b border-gray-200 pb-4">
                    <span class="text-gray-700 text-lg font-semibold">Commune:</span>
                    <span class="ml-2 text-gray-900 text-lg">{{  $etablissement->commune->libelle ?? "Non renseigné" }}</span>
                </div>
            </div>
            @can('modifier_mon_etablissement')
            <div class="px-2 pt-4 pb-2 text-left">
                    <a href="{{ route('etablissement.show', $etablissement->id) }}" class="mx-2 px-5 rounded-md py-4 flex text-white text-xs font-semibold text-center shadow-md bg-first-orange items-center justify-center">
                        <span class=" fas fa-edit"> Modifier</span>
                    </a>
                </div>
            @endcan
            
        </div>

@endif