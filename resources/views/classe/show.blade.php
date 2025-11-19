<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Informations détaillées de la classe') }}
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="bg-white shadow rounded-lg p-6">

            {{-- ==== En-tête principale ==== --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold">{{ $classe->libelle }}</h2>
                    <a href="{{ route('classe.index') }}" class="text-blue-600 hover:underline text-sm">
                        &larr; Retour à la liste des classes
                    </a>
                </div>
                @php
    $user = auth()->user();
@endphp

@if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
)
<div onclick="window.location='{{ route('classe.formateurs.assign', $classe->id) }}'"
     style="background-color:#0E7490; cursor: pointer; width: fit-content;"
     class="bg-cyan-700 text-white hover:bg-cyan-800 rounded-lg text-sm px-4 py-2 cursor-pointer" >  <i class="fa fa-user-plus"></i>
    Assigner des formateurs
</div>
@endif 
                <div class="flex flex-wrap gap-2 mt-3 sm:mt-0">
                    <form id="exportForm" method="GET" action="{{ route('classe.exportPdf', $classe->id) }}">
                        <input type="hidden" name="annee_academique_id" id="annee_academique_export">
                        <button type="button" onclick="exportPdf()"
                            class="bg-blue-700 text-white text-sm px-4 py-2 rounded hover:bg-blue-800">
                            Exporter la liste PDF
                        </button>
                    </form>

                    @php $user = auth()->user(); @endphp
                    @if($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement')||
                    $user->hasRole('directeur_etude'))
                        <button onclick="window.location='{{ route('classe.edit', $classe->id) }}'" style="background-color:#006D3A; cursor: pointer;"
                            class="bg-green-700 text-white text-sm px-4 py-2 rounded hover:bg-green-800 cursor-pointer">
                            Modifier
                        </button>
                        <form action="{{ route('classe.destroy', $classe->id) }}" method="POST"
                            onsubmit="return confirm('Supprimer cette classe ?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 text-white text-sm px-4 py-2 rounded hover:bg-red-700">
                                Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- ==== Bloc Détails de la classe ==== --}}
            <div class="border border-gray-200 rounded-lg p-5 mb-8 bg-gray-50 w-full">
    <h3 class="bg-gray-100 p-2 text-md font-bold text-orange-600 mb-4">
        Détails de la classe : {{ $classe->libelle }}
    </h3>

    <div class="flex flex-col lg:flex-row gap-8">
       
        <div class="lg:w-1/2 w-full bg-white shadow-sm rounded-md p-4 border border-gray-100">
            <h4 class="font-bold text-lg mb-3 text-gray-800 border-b pb-2">Informations générales</h4>
            <div class="grid grid-cols-2 text-sm gap-y-2">
                <span class="text-gray-600">Établissement :</span>
                <span class="font-semibold text-gray-900">{{ $classe->etablissement->nom }}</span>

                <span class="text-gray-600">Filière :</span>
                <span class="font-semibold text-gray-900">{{ $classe->niveau_etude->metier->filiere->nom }}</span>

                <span class="text-gray-600">Métier :</span>
                <span class="font-semibold text-gray-900">{{ $classe->niveau_etude->metier->nom }}</span>

                <span class="text-gray-600">Niveau :</span>
                <span class="font-semibold text-gray-900">{{ $classe->niveau_etude->nom }}</span>

                <span class="text-gray-600">Modalité :</span>
                <span class="font-semibold text-gray-900">{{ $classe->modalite }}</span>
            </div>
        </div>

        {{-- Bloc Disciplines au programme --}}
        <div class="lg:w-1/2 w-full bg-white shadow-sm rounded-md p-4 border border-gray-100">
            <h4 class="font-bold text-lg mb-3 text-gray-800 border-b pb-2">
                {{ $classe->modalite === 'PPO' ? 'Matières au programme' : 'Compétences au programme' }}
            </h4>

            <div class="text-sm grid grid-cols-1 md:grid-cols-2 gap-x-6">
                @if($classe->modalite === 'PPO')
                    @forelse($matieres as $matiere)
                        <div class="flex items-center mb-1">
                            <i class="fa fa-star text-gray-400 mr-2"></i>
                            <span><strong>{{ $matiere->code }}</strong> — {{ $matiere->nom }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucune matière définie.</p>
                    @endforelse
                @elseif($classe->modalite === 'APC')
                    @forelse($competences as $comp)
                        <div class="flex items-center mb-1">
                            <i class="fa fa-check text-green-500 mr-2"></i>
                            <span><strong>{{ $comp->code }}</strong> — {{ $comp->nom }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucune compétence définie.</p>
                    @endforelse
                @endif
            </div>
        </div>
    </div>
</div>


         <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @php
        $user = auth()->user();
    @endphp

    @if(
        $user->hasRole('chef_de_travaux') ||
        $user->hasRole('chef_etablissement') ||
        $user->hasRole('directeur_etude') ||
        $user->hasRole('formateur')
    )
        @if(($classe->modalite === 'PPO' && isset($matieres)) || ($classe->modalite === 'APC' && isset($competences)))
        <div class="border rounded-lg p-4 bg-white shadow-sm">
            
            {{-- 🔹 Le bouton d’ouverture du formulaire d’assignation — visible uniquement pour les rôles de gestion --}}
            @if(!$user->hasRole('formateur'))
                <div class="flex justify-between items-center mb-3">
                    <div id="toggleAssignationForm"
                        class="bg-cyan-700 text-white hover:bg-cyan-800 rounded-lg text-sm px-4 py-2 cursor-pointer inline-flex items-center gap-2">
                        <i class="fa fa-user-plus"></i>
                        {{ $classe->modalite === 'PPO'
                            ? 'Assigner des matières aux formateurs de la classe'
                            : 'Assigner des compétences aux formateurs de la classe' }}
                    </div>
                </div>

                {{-- 🔸 Formulaire d’assignation (non visible pour formateur) --}}
                <form method="POST" action="{{ route('classe.assign.store', $classe->id) }}" class="mb-4">
                    @csrf
                    <div class="grid grid-cols-3 gap-3 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Choisissez un formateur
                            </label>
                            <select name="formateur_id" required
                                class="w-full border-gray-300 focus:ring-first-orange focus:border-first-orange rounded-md p-2 text-sm">
                                <option value="">-- Sélectionner un formateur --</option>
                                @foreach($formateurs as $f)
                                    <option value="{{ $f->id }}">{{ $f->prenom }} {{ $f->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                {{ $classe->modalite === 'PPO' ? 'Choisissez une matière' : 'Choisissez une compétence' }}
                            </label>
                            <select 
                                name="{{ $classe->modalite === 'PPO' ? 'matiere_id' : 'competence_id' }}" 
                                required
                                class="w-full border-gray-300 focus:ring-first-orange focus:border-first-orange rounded-md p-2 text-sm">
                                <option value="">
                                    -- {{ $classe->modalite === 'PPO' ? 'Sélectionner une matière' : 'Sélectionner une compétence' }} --
                                </option>

                                @if($classe->modalite === 'PPO')
                                    @foreach($matieres as $m)
                                        <option value="{{ $m->id }}">{{ $m->nom }}</option>
                                    @endforeach
                                @else
                                    @foreach($competences as $c)
                                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div>
                            <button type="submit"
                                class="bg-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-700">
                                Assigner
                            </button>
                        </div>
                    </div>
                </form>
            @endif
  @if (session('success'))
            <div class="mb-3 p-2 bg-green-100 text-green-700 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-3 p-2 bg-red-100 text-red-700 rounded text-sm">
                {{ session('error') }}
            </div>
        @endif
            
         <table class="w-full text-sm border border-gray-300 rounded-md">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-3 py-2 text-left border">Formateur</th>
            <th class="px-3 py-2 text-left border">
                {{ $classe->modalite === 'PPO' ? 'Matière' : 'Compétence' }}
            </th>

            @if ($classe->modalite === 'APC')
                <th class="px-3 py-2 text-left border">Éléments de compétence</th>
            @endif

            <th class="px-3 py-2 text-center border">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($assignations as $a)
            @php
                $elements = $a->elements ?? collect();
                $rowspan = max($elements->count(), 1);
            @endphp

            {{-- ====================== MODALITÉ PPO ====================== --}}
            @if($classe->modalite === 'PPO')
                @if(!$user->hasRole('formateur') || $user->id === $a->formateur_id)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2 border">{{ $a->formateur_prenom }} {{ $a->formateur_nom }}</td>
                        <td class="px-3 py-2 border font-semibold text-gray-800">{{ $a->matiere_nom ?? '-' }}</td>
                        <td class="px-3 py-2 border text-center">
                            {{-- ✅ Bouton Supprimer visible uniquement pour les non-formateurs --}}
                            @if(!$user->hasRole('formateur'))
                                <form method="POST"
                                      action="{{ route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->matiere_id]) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                                        Supprimer
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs italic">Aucune action disponible</span>
                            @endif
                        </td>
                    </tr>
                @endif

            {{-- ====================== MODALITÉ APC ====================== --}}
            @elseif($classe->modalite === 'APC')

                {{-- Compétence générale --}}
                @if ($a->competence_type === 'generale' && $elements->count() > 0)
                    @if(!$user->hasRole('formateur') || $user->id === $a->formateur_id)
                        @foreach($elements as $index => $el)
                            <tr class="border-b hover:bg-gray-50">
                                {{-- Formateur fusionné --}}
                                @if($index === 0)
                                    <td class="px-3 py-2 border align-top" rowspan="{{ $rowspan }}">
                                        {{ $a->formateur_prenom }} {{ $a->formateur_nom }}
                                    </td>
                                    <td class="px-3 py-2 border align-top font-semibold text-gray-800" rowspan="{{ $rowspan }}">
                                        {{ $a->competence_nom }}
                                        <div class="text-xs text-gray-500">(Compétence générale)</div>
                                    </td>
                                @endif

                                <td class="px-3 py-2 border text-gray-800">
                                    {{ $el->nom }}
                                </td>

                                <td class="px-3 py-2 border text-center flex justify-center items-center gap-2">
                                                                       @if($el->ressource && ($user->hasRole('formateur') || $user->hasRole('chef_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude')))
                                            <button onclick="openViewRessourceModal('{{ $el->ressource->nom }}', '{{ $el->nom }}')"
                                                    class="bg-cyan-700 text-white text-xs px-2 py-1 rounded hover:bg-cyan-700">
                                                Voir
                                            </button>  
					 @endif
					    @if($el->ressource && $user->hasRole('formateur'))
                                            <button onclick="openEditRessourceModal({{ $el->ressource->id }}, '{{ $el->ressource->nom }}')"
                                                    class="bg-blue-700 text-white text-xs px-2 py-1 rounded hover:bg-blue-700">
                                                Modifier
                                            </button>
                                             @endif
                                         @if(!$el->ressource && $user->hasRole('formateur'))
                                            <button onclick="openRessourceModal({{ $el->id }}, '{{ $el->nom }}')"
                                                    class="bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700">
                                                + Ressource
                                            </button>
                                        @endif
                                    

                                    @if(!$user->hasRole('formateur') && $index === 0)
                                        <form method="POST" class="inline-block"
                                              action="{{ route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->competence_id]) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                                                Supprimer
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif

                {{-- Compétence particulière --}}
                @elseif($a->competence_type === 'particuliere')
                    @if(!$user->hasRole('formateur') || $user->id === $a->formateur_id)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-3 py-2 border">{{ $a->formateur_prenom }} {{ $a->formateur_nom }}</td>
                            <td class="px-3 py-2 border font-semibold text-gray-800">
                                {{ $a->competence_nom }}
                                <div class="text-xs text-gray-500">(Compétence particulière)</div>
                            </td>
                            <td class="px-3 py-2 border text-center text-gray-400">—</td>
                            <td class="px-3 py-2 border text-center">
                                @if(!$user->hasRole('formateur'))
                                    <form method="POST"
                                          action="{{ route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->competence_id]) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                                            Supprimer
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endif
            @endif
        @empty
           
            <tr>
                <td colspan="4" class="text-center py-3 text-gray-500 italic">
                    Aucune assignation enregistrée.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>


</div>

    @endif
    @endif
 
    
<div id="ressourceModal" class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden  hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)]  w-100 h-100 mx-auto max-w-full max-h-full">
    <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            Ajouter une ressource à <span id="elementNom" class="text-green-600"></span>
        </h3>

      

        <form method="POST" action="{{ route('ressources.store') }}">
            @csrf
            <input type="hidden" name="element_competence_id" id="elementId">
             <input type=�"hidden" name="classe_id" value="{{ $classe->id }}" >
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nom de la ressource :
            </label>
            <input type="text" name="nom" required
                   class="w-full border rounded p-2 text-sm focus:ring-green-500 focus:border-green-500"
                   placeholder="Ex :Anglais"/>

            <div class="flex justify-end mt-4 gap-2">
                <button type="button"
                        onclick="closeRessourceModal()"
                        class="bg-gray-300 px-3 py-1 rounded hover:bg-gray-400 text-sm">
                    Annuler
                </button>
                <button type="submit"
                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
    
</div>

<div id="viewRessourceModal"
     class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden  hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)]  w-100 h-100 mx-auto max-w-full max-h-full">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">
            Ressource enregistrée
        </h2>

        <div class="space-y-2">
            <p class="text-sm text-gray-700">
                <strong>Élément de compétence :</strong>
                <span id="viewRessourceElement" class="text-gray-900 font-medium"></span>
            </p>
            <p class="text-sm text-gray-700">
                <strong>Nom de la ressource :</strong>
                <span id="viewRessourceName" class="text-green-700 font-semibold"></span>
            </p>
        </div>

        <div class="mt-5 text-right">
            <button onclick="closeViewRessourceModal()"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Fermer
            </button>
        </div>
    </div>
</div>
        <div id="editRessourceModal"
     class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden  hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)]  w-100 h-100 mx-auto max-w-full max-h-full">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Modifier la ressource
        </h2>

        <form id="editRessourceForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="editRessourceNom" class="block text-sm font-medium text-gray-700 mb-1">
                    Nom de la ressource
                </label>
                <input type="text" id="editRessourceNom" name="nom"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-first-orange focus:border-first-orange"
                       required>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeEditRessourceModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">
                    Annuler
                </button>
                <button type="submit"
                        class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>



                
                <div class="lg:w-full border shadow p-4 rounded bg-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-xl">Liste des apprenants</h3>
                                   @php
    $user = auth()->user();
@endphp

@if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
)

                        <form method="GET" action="{{ route('classe.show', $classe->id) }}" class="flex items-center gap-2">
                            <label for="annee_academique_id" class="text-sm font-medium">Année académique :</label>
                            <select name="annee_academique_id" id="annee_academique_id" onchange="this.form.submit()"
                                    class="rounded border-gray-300 text-sm">
                                @foreach ($anneeAcademiques as $annee)
                                    <option value="{{ $annee->id }}" {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                                        {{ $annee->code }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div class="flex items-start gap-6 mb-6">
                        {{-- Ajouter un apprenant --}}
                        <div onclick="window.location='{{ route('apprenant.create', $classe->id) }}'" style="background-color:#006D3A; cursor: pointer;"
                             class="bg-green-700 text-white hover:bg-green-800 rounded-lg text-sm px-4 py-2 cursor-pointer">
                            Ajouter un apprenant
                        </div>

                      
                      <form action="{{ route('apprenant.import', ['classe' => $classe->id]) }}"
      method="POST" enctype="multipart/form-data"
      class="bg-white p-4 rounded shadow w-full sm:w-full">
    @csrf

    <div class="flex flex-col sm:flex-row items-center gap-3 w-full">
        {{-- Année académique 2025-2026 --}}
        @php
            $annee = $anneeAcademiques->firstWhere('code', '2025-2026');
        @endphp

        @if($annee)
            <input type="hidden" name="annee_academique_id" value="{{ $annee->id }}">
            <input type="hidden" value="{{ $annee->code }}" readonly>
        @else
            <p class="text-red-500 text-sm">⚠️ Année 2025-2026 introuvable</p>
        @endif

        {{-- Fichier + Bouton côte à côte sans espace inutile --}}
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <label for="file" class="text-sm font-medium whitespace-nowrap">Fichier Excel :</label>

            <input type="file" name="file" id="file" accept=".xlsx, .xls"
                   class="rounded border-gray-300 text-sm w-full sm:w-64" required>

            <button type="submit"
                    style="background-color:#006D3A;"
                    class="text-white hover:bg-green-800 rounded-lg text-sm px-5 py-2.5 whitespace-nowrap">
                Importer des apprenants
            </button>
        </div>
    </div>
</form>
@endif

                    </div>

                    <hr class="mb-4">

                    {{-- Tableau des apprenants --}}
                    <table class="w-full text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-2 py-2 text-left">Matricule</th>
                                <th class="px-2 py-2 text-left">Nom & Prénoms</th>
                                <th class="px-2 py-2 text-left">Date de naissance</th>
                                <th class="px-2 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            @forelse ($usersWithEnterprises as $entry)
                                <tr>
                                    <td class="px-2 py-2">{{ $entry['user']->apprenant->matricule ?? '-' }}</td>
                                    <td class="px-2 py-2">
                                        {{ $entry['user']->apprenant->nom ?? '-' }}
                                        {{ $entry['user']->apprenant->prenom ?? '' }}
                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        {{ optional($entry['user']->apprenant)->date_naissance ? \Carbon\Carbon::parse($entry['user']->apprenant->date_naissance)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td class="px-2 py-2 text-center">
                                        <a href="{{ route('inscription.show', $entry['user']->id) }}" class="text-green-600 hover:text-green-800">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 font-semibold text-gray-500">
                                        Aucun apprenant inscrit pour cette classe.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $inscriptions->appends(['annee_academique_id' => request('annee_academique_id')])->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function exportPdf() {
            const selectedAnnee = document.getElementById('annee_academique_id').value;
            if (!selectedAnnee) {
                alert('Veuillez sélectionner une année académique.');
                return;
            }
            document.getElementById('annee_academique_export').value = selectedAnnee;
            document.getElementById('exportForm').submit();
        }
    </script>
    <script>
function openRessourceModal(id, nom) {
    document.getElementById('elementId').value = id;
    document.getElementById('elementNom').textContent = nom;
    document.getElementById('ressourceModal').classList.remove('hidden');
}
function closeRessourceModal() {
    document.getElementById('ressourceModal').classList.add('hidden');
}
</script>
<script>
    function openViewRessourceModal(nomRessource, nomElement) {
        document.getElementById('viewRessourceModal').classList.remove('hidden');
        document.getElementById('viewRessourceElement').textContent = nomElement;
        document.getElementById('viewRessourceName').textContent = nomRessource;
    }

    function closeViewRessourceModal() {
        document.getElementById('viewRessourceModal').classList.add('hidden');
    }
</script>
<script>
    // Ouvrir le modal prérempli
    function openEditRessourceModal(id, nom) {
        const modal = document.getElementById('editRessourceModal');
        const form = document.getElementById('editRessourceForm');
        const inputNom = document.getElementById('editRessourceNom');

        form.action = `/ressources/${id}`; // ✅ route update dynamique
        inputNom.value = nom;

        modal.classList.remove('hidden');
    }

    // Fermer le modal
    function closeEditRessourceModal() {
        document.getElementById('editRessourceModal').classList.add('hidden');
    }
</script>
</x-app-layout>
