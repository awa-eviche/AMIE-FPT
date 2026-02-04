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

     @if($classe ->modalite=== 'APC')
       <th class="px-3 py-2 text-center border">Discipline</th>
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
        @php
            // ✅ compteur fiable (vient du controller)
            $hasDevoir = ((int) ($devoirCountByMatiere[$a->matiere_id] ?? 0)) > 0;

            // $hasDevoirNonFormateur = ((int) ($devoirCountRenseigneByMatiere[$a->matiere_id] ?? 0)) > 0;

            $isFormateurOwner = $user->hasRole('formateur') && $user->id === $a->formateur_id;
        @endphp

        <tr class="border-b hover:bg-gray-50">
            <td class="px-3 py-2 border">{{ $a->formateur_prenom }} {{ $a->formateur_nom }}</td>
            <td class="px-3 py-2 border font-semibold text-gray-800">{{ $a->matiere_nom ?? '-' }}</td>

            <td class="px-3 py-2 border text-center">
                {{-- Supprimer seulement admin --}}
                @if(!$user->hasRole('formateur'))
                    <form class="inline-block" method="POST"
                          action="{{ route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->matiere_id]) }}">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                            Supprimer
                        </button>
                    </form>
                @endif

                
                @if($isFormateurOwner && !$hasDevoir)
                    <button type="button"
                            onclick="openDevoirPpoModal({{ $a->matiere_id }})"
                            class="bg-green-600 text-white text-xs px-2 py-1 rounded">
                        + Devoir
                    </button>
                @endif

                
                @if($hasDevoir)
                    <button type="button"
                            onclick="openVoirDevoirPpoModal({{ $a->matiere_id }})"
                            class="bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                        Voir devoir
                    </button>
                @endif
            </td>
        </tr>
    @endif






       
 @elseif($classe->modalite === 'APC')

   
{{-- ================= COMPÉTENCE GÉNÉRALE ================= --}}

@if ($a->competence_type === 'generale')
@if(!$user->hasRole('formateur') || $user->id === $a->formateur_id)

@php
    // ✅ Compter les doublons d'affectation (même classe + formateur + compétence)
    $apcOcc = $apcOcc ?? [];
    $apcRessourcesCache = $apcRessourcesCache ?? [];

    $key = $classe->id.'|'.$a->formateur_id.'|'.$a->competence_id;

    // numéro d'occurrence: 0,1,2...
    $apcOcc[$key] = ($apcOcc[$key] ?? 0) + 1;
    $slotIndex = $apcOcc[$key] - 1;

    // ✅ Cache des ressources pour éviter N requêtes
    if (!isset($apcRessourcesCache[$key])) {
        $apcRessourcesCache[$key] = \App\Models\Ressource::where('competence_id', $a->competence_id)
            ->where('classe_id', $classe->id)
            ->where('formateur_id', $a->formateur_id)
            ->orderBy('id')
            ->get();
    }

    // ✅ On prend la ressource correspondant à l'occurrence
    $ressource = $apcRessourcesCache[$key]->get($slotIndex);

    $devoirs = $ressource
        ? (
            $user->hasRole('formateur')
                ? $ressource->devoirsAPC
                : $ressource->devoirsAPC->whereNotNull('note')
          )
        : collect();
@endphp


<tr class="border-b hover:bg-gray-50">

    <td class="px-3 py-2 border">
        {{ $a->formateur_prenom }} {{ $a->formateur_nom }}
    </td>

    <td class="px-3 py-2 border font-semibold">
        {{ $a->competence_nom }}
        <div class="text-xs text-gray-500">(Compétence générale)</div>
    </td>

    <td class="px-3 py-2 border text-center">
        @if($ressource)
            <span class="font-semibold">{{ $ressource->nom }}</span>
        @else
            <span class="italic text-gray-400">Discipline non disponible</span>
        @endif
    </td>

    <td class="px-3 py-2 border">
        <div class="flex gap-2 justify-center flex-wrap">

            {{-- FORMATEUR --}}
            @if($user->hasRole('formateur'))

                @if(!$ressource)
                    <button onclick="openRessourceModal({{ $a->competence_id }}, '{{ $a->competence_nom }}')"
                            class="bg-green-600 text-white text-xs px-2 py-1 rounded">
                        + Discipline
                    </button>
                @else
                    <button onclick="openEditRessourceModal({{ $ressource->id }}, '{{ $ressource->nom }}')"
                            class="bg-blue-700 text-white text-xs px-2 py-1 rounded">
                        Modifier
                    </button>

                    @if($devoirs->count() === 0)
                        <button onclick="openDevoirModal({{ $ressource->id }})"
                                  class="bg-green-600 text-white text-xs px-2 py-1 rounded">
                            + Devoir
                        </button>
                    @else
                        <button onclick="openVoirDevoirModal({{ $ressource->id }})"
                                class="bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                            Voir mes devoirs
                        </button>
                    @endif
                @endif

            @endif

            {{-- ADMIN --}}
            @if(!$user->hasRole('formateur'))
                @if($devoirs->count() > 0)
                    <button onclick="openVoirDevoirModal({{ $ressource->id }})"
                            class="bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                        Voir mes devoirs
                    </button>
                @endif

          <form method="POST"
    action="{{ route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->competence_id]) }}">
    @csrf
    @method('DELETE')

    {{-- ✅ id unique de l'assignation (ligne cfc) --}}
    
    <input type="hidden" name="assign_id" value="{{ $a->assign_id }}">



    {{-- ✅ optionnel : si une discipline existe, on peut supprimer la discipline ciblée --}}
    @if($ressource)
        <input type="hidden" name="ressource_id" value="{{ $ressource->id }}">
    @endif

    <button class="bg-red-600 text-white text-xs px-2 py-1 rounded">
        Supprimer
    </button>
</form>

               
            @endif

        </div>
    </td>

</tr>
@endif
@endif


{{-- ================= COMPÉTENCE PARTICULIÈRE ================= --}}
@if ($a->competence_type === 'particuliere')
@if(!$user->hasRole('formateur') || $user->id === $a->formateur_id)

@php
    // ✅ Compter les doublons d'affectation (même classe + formateur + compétence)
    $apcOcc = $apcOcc ?? [];
    $apcRessourcesCache = $apcRessourcesCache ?? [];

    $key = $classe->id.'|'.$a->formateur_id.'|'.$a->competence_id;

    // numéro d'occurrence: 0,1,2...
    $apcOcc[$key] = ($apcOcc[$key] ?? 0) + 1;
    $slotIndex = $apcOcc[$key] - 1;

    // ✅ Cache des ressources pour éviter N requêtes
    if (!isset($apcRessourcesCache[$key])) {
        $apcRessourcesCache[$key] = \App\Models\Ressource::where('competence_id', $a->competence_id)
            ->where('classe_id', $classe->id)
            ->where('formateur_id', $a->formateur_id)
            ->orderBy('id')
            ->get();
    }

    // ✅ On prend la ressource correspondant à l'occurrence
    $ressource = $apcRessourcesCache[$key]->get($slotIndex);

    $devoirs = $ressource
        ? (
            $user->hasRole('formateur')
                ? $ressource->devoirsAPC
                : $ressource->devoirsAPC->whereNotNull('note')
          )
        : collect();
@endphp


<tr class="border-b hover:bg-gray-50">

    {{-- FORMATEUR --}}
    <td class="px-3 py-2 border">
        {{ $a->formateur_prenom }} {{ $a->formateur_nom }}
    </td>

    {{-- COMPÉTENCE --}}
    <td class="px-3 py-2 border font-semibold">
        {{ $a->competence_nom }}
        <div class="text-xs text-gray-500">(Compétence particulière)</div>
    </td>

    
    <td class="px-3 py-2 border text-center">
        @if($ressource)
            <span class="font-semibold">{{ $ressource->nom }}</span>
        @else
            <span class="italic text-gray-400">Discipline non disponible</span>
        @endif
    </td>

    
    <td class="px-3 py-2 border">
        <div class="flex gap-2 justify-center flex-wrap">

           
            @if($user->hasRole('formateur'))

                @if(!$ressource)
                    <button onclick="openRessourceModal({{ $a->competence_id }}, '{{ $a->competence_nom }}')"
                            class="bg-green-600 text-white text-xs px-2 py-1 rounded">
                        + Discipline
                    </button>
                @else
                    <button onclick="openEditRessourceModal({{ $ressource->id }}, '{{ $ressource->nom }}')"
                            class="bg-blue-700 text-white text-xs px-2 py-1 rounded">
                        Modifier
                    </button>

                    @if($devoirs->count() === 0)
                        <button onclick="openDevoirModal({{ $ressource->id }})"
                                class="bg-green-600 text-white text-xs px-2 py-1 rounded">
                            + Devoir
                        </button>
                    @else
                        <button onclick="openVoirDevoirModal({{ $ressource->id }})"
                                class="bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                            Voir mes devoirs
                        </button>
                    @endif
                @endif

            @endif

          
            @if(!$user->hasRole('formateur'))
                @if($devoirs->count() > 0)
                    <button onclick="openVoirDevoirModal({{ $ressource->id }})"
                            class="bg-indigo-600 text-white text-xs px-2 py-1 rounded">
                        Voir mes devoirs
                    </button>
                @endif

          <form method="POST"
    
    action="{{ route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->competence_id]) }}">
    @csrf
    @method('DELETE')

<input type="hidden" name="assign_id" value="{{ $a->assign_id }}">


    {{-- ✅ optionnel : si une discipline existe, on peut supprimer la discipline ciblée --}}
    @if($ressource)
        <input type="hidden" name="ressource_id" value="{{ $ressource->id }}">
    @endif

    <button class="bg-red-600 text-white text-xs px-2 py-1 rounded">
        Supprimer
    </button>
</form>


            @endif

        </div>
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
            Ajouter une discipline à <span id="elementNom" class="text-green-600"></span>
        </h3>

        <form method="POST" action="{{ route('ressources.store') }}">
            @csrf

            <input type="hidden" name="competence_id" id="elementId">
            <input type="hidden" name="classe_id" value="{{ $classe->id }}">

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Nom de la discipline :
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



 <div id="editRessourceModal"
     class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden  hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)]  w-100 h-100 mx-auto max-w-full max-h-full">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Modification de la discipline
        </h2>

        <form id="editRessourceForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="editRessourceNom" class="block text-sm font-medium text-gray-700 mb-1">
                    Nom de la discipline :
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

<div id="devoirModal"
     class="hidden fixed inset-0 z-50 bg-black bg-opacity-70 flex items-center justify-center p-4">

  <div class="bg-white rounded-lg shadow-xl w-[700px] max-w-[95vw]"
       style="height:90vh; display:flex; flex-direction:column; overflow:hidden;">

    {{-- HEADER FIXE --}}
    <div class="p-4 border-b flex items-center justify-between bg-white"
         style="flex:0 0 auto;">
      <h3 class="font-semibold">Ajouter un devoir</h3>
      <button type="button" onclick="closeDevoirModal()"
              class="text-red-600 font-bold text-lg leading-none">✕</button>
    </div>

    <form method="POST" action="{{ route('devoirAPC.store') }}"
          style="flex:1 1 auto; min-height:0; display:flex; flex-direction:column;">
      @csrf

      <input type="hidden" name="ressource_id" id="devoir_ressource_id">

      {{-- CHAMPS (FIXES) --}}
      <div class="p-4 bg-white" style="flex:0 0 auto;">
        <div class="flex items-center gap-3">
          <div>
            <label class="block text-sm mb-1">Semestre</label>
            <select name="semestre" required class="rounded border-gray-300 text-sm">
              <option value="1">Premier semestre</option>
              <option value="2">Deuxième semestre</option>
            </select>
          </div>

          <div class="flex-1">
            <label class="block text-sm mb-1">Libellé du devoir</label>
            <input type="text" name="libelle"
                   class="w-full border rounded px-2 py-1" required>
          </div>
        </div>
      </div>

      {{-- ✅ BODY SCROLL --}}
      <div id="devoirApcBodyScroll"
           class="px-4 pb-4"
           style="flex:1 1 auto; min-height:0; overflow-y:auto; -webkit-overflow-scrolling:touch;">
        <table class="w-full border text-sm">
          <thead class="bg-gray-100" style="position:sticky; top:0; z-index:5;">
            <tr>
              <th class="border px-2 py-2 text-left">Apprenant</th>
              <th class="border px-2 py-2 w-32 text-center">Note</th>
            </tr>
          </thead>
          <tbody>
            @foreach($inscriptionsAll as $inscription)
              <tr>
                <td class="border px-2 py-1">
                  {{ $inscription->apprenant->prenom }} {{ $inscription->apprenant->nom }}
                </td>
                <td class="border px-2 py-1 text-center">
                  <input type="number"
                         name="notes[{{ $inscription->id }}]"
                         step="0.01" min="0" max="20"
                         class="border rounded px-2 py-1 w-24 text-center">
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- FOOTER FIXE --}}
      <div class="p-4 border-t bg-white flex justify-between"
           style="flex:0 0 auto;">
        <button type="button"
                onclick="closeDevoirModal()"
                class="bg-gray-500 text-white px-3 py-2 rounded">
          Annuler
        </button>

        <button type="submit"
                class="bg-green-600 text-white px-3 py-2 rounded">
          Enregistrer
        </button>
      </div>

    </form>
  </div>
</div>


<div id="voirDevoirsModal"
     class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)] w-100 h-100 mx-auto max-w-full max-h-full">
    
    <div class="bg-white rounded-lg w-[900px] p-5 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">Liste des devoirs</h3>
            <button onclick="closeVoirDevoirsModal()" class="text-red-600 font-bold text-xl">✕</button>
        </div>

        <div class="mb-4 flex items-center gap-4">
            <label class="text-sm font-medium">Filtrer par semestre :</label>
            <select id="filtreSemestre" onchange="filtrerParSemestre()"
                    class="border rounded px-3 py-1 text-sm">
                <option value="">Tous les semestres</option>
                <option value="1">Premier semestre</option>
                <option value="2">Deuxième semestre</option>
            </select>
        </div>

        
        <div id="devoirsListContainer">
            <div class="text-center py-8 text-gray-500">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-700 mb-3"></div>
                <p class="italic">Chargement des devoirs...</p>
            </div>
        </div>

       
        @if(auth()->user()->hasRole('formateur'))
        <div class="border-t pt-4 mt-6 text-center">
            <button onclick="openAddDevoirModal()"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + Ajouter un nouveau devoir
            </button>
        </div>
        @endif
    </div>
</div>


<div id="addDevoirModal"
     class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(200%-1rem)] w-500 h-100 mx-auto max-w-full max-h-full">
    
    <div class="bg-white rounded-lg w-[95%] max-w-[1400px] p-6 max-h-[95vh] overflow-y-auto shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">Ajouter un nouveau devoir</h3>
            <button onclick="closeAddDevoirModal()" class="text-red-600 font-bold">✕</button>
        </div>

        <form method="POST" action="{{ route('devoirAPC.store') }}">
            @csrf
            <input type="hidden" name="ressource_id" id="add_devoir_ressource_id">
    <select name="semestre" class="rounded border-gray-300 text-sm">
            <option value="">Tous les semestres</option>
            <option value="1">Premier semestre</option>
            <option value="2">Deuxième semestre</option>
        </select>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Libellé du devoir</label>
                <input type="text" name="libelle"
                       class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                       required placeholder="Ex: Devoir 1">
            </div>

            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">Apprenant</th>
                    <th class="border px-3 py-2 text-left w-32">Note</th>
                </tr>
                </thead>
                <tbody id="notesTableBody">
                    <!-- Les lignes seront ajoutées dynamiquement -->
                </tbody>
            </table>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeAddDevoirModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Annuler
                </button>

                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Enregistrer le devoir
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editDevoirModal"
     class="hidden fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex justify-center items-center p-12 bg-black bg-opacity-25 hidden overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)] w-100 h-100 mx-auto max-w-full max-h-full">
    
    <div class="bg-white rounded-lg w-[700px] p-5 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-lg">Modifier les notes</h3>
            <button onclick="closeEditDevoirModal()" class="text-red-600 font-bold text-xl">✕</button>
        </div>

        <form id="editDevoirForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="libelle" id="edit_devoir_libelle">
            <input type="hidden" name="ressource_id" id="edit_devoir_ressource_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Devoir</label>
                <p class="font-semibold text-blue-700" id="edit_devoir_titre"></p>
            </div>

            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">Apprenant</th>
                    <th class="border px-3 py-2 text-left w-32">Note actuelle</th>
                    <th class="border px-3 py-2 text-left w-32">Nouvelle note</th>
                </tr>
                </thead>
                <tbody id="editNotesTableBody">
                    <!-- Les lignes seront ajoutées dynamiquement -->
                </tbody>
            </table>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeEditDevoirModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Annuler
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Mettre à jour les notes
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
        document.getElementById('elementId').value = id; // competence_id
        document.getElementById('elementNom').textContent = nom;
        document.getElementById('ressourceModal').classList.remove('hidden');
    }

    function closeRessourceModal() {
        document.getElementById('ressourceModal').classList.add('hidden');
    }
</script>

<script>
    function openViewRessourceModal(nomRessource, nomCompetence) {
        document.getElementById('viewRessourceModal').classList.remove('hidden');
        document.getElementById('viewRessourceElement').textContent = nomCompetence;
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

        form.action = `/ressources/${id}`; 
        inputNom.value = nom;

        modal.classList.remove('hidden');
    }

    // Fermer le modal
    function closeEditRessourceModal() {
        document.getElementById('editRessourceModal').classList.add('hidden');
    }
</script>
<script>
function openDevoirModal(ressourceId) {
    document.getElementById('devoir_ressource_id').value = ressourceId;
    document.getElementById('devoirModal').classList.remove('hidden');
}

function closeDevoirModal() {
    document.getElementById('devoirModal').classList.add('hidden');
}

function openVoirDevoirModal(ressourceId) {
    fetch(`/devoir-apc/ressource/${ressourceId}`)
        .then(res => res.json())
        .then(data => {
            let html = '';
            data.forEach(d => {
                html += `
                    <div class="border p-2 rounded">
                        <strong>${d.libelle}</strong>
                        ${d.note !== null ? `<span class="text-sm text-gray-500"> (${d.note})</span>` : ''}
                        <form method="POST" action="/devoir-apc/${d.id}" class="mt-1 flex gap-1">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="bg-red-600 text-white text-xs px-2 py-0.5 rounded">
                                Supprimer
                            </button>
                        </form>
                    </div>
                `;
            });
            document.getElementById('devoirList').innerHTML = html;
            document.getElementById('voirDevoirModal').classList.remove('hidden');
        });
}

function closeVoirDevoirModal() {
    document.getElementById('voirDevoirModal').classList.add('hidden');
}
</script>
<script>
  let currentRessourceId = null;

// Fonction pour charger la liste des devoirs
function openVoirDevoirModal(ressourceId) {
    currentRessourceId = ressourceId;
    
    // Vider le contenu et afficher un indicateur de chargement
    document.getElementById('devoirsListContainer').innerHTML = 
        '<p class="text-center text-gray-500 italic">Chargement des devoirs...</p>';
    
    // Afficher le modal immédiatement
    document.getElementById('voirDevoirsModal').classList.remove('hidden');
    
    // Charger les devoirs via AJAX
    fetch(`/devoirAPC/ressource/${ressourceId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau');
        }
        return response.text();
    })
    .then(html => {
        document.getElementById('devoirsListContainer').innerHTML = html;
    })
    .catch(error => {
        console.error('Erreur:', error);
        document.getElementById('devoirsListContainer').innerHTML = 
            '<div class="text-center py-8 text-red-500">' +
            '<p>Erreur de chargement des devoirs</p>' +
            '<p class="text-sm">Vérifiez la console pour plus de détails</p>' +
            '</div>';
    });
}

function closeVoirDevoirsModal() {
    document.getElementById('voirDevoirsModal').classList.add('hidden');
}

// Fonction pour ouvrir le modal d'ajout
function openAddDevoirModal() {
    // Fermer d'abord le modal de liste
    closeVoirDevoirsModal();
    
    // Remplir l'ID de la ressource
    document.getElementById('add_devoir_ressource_id').value = currentRessourceId;
    
    // Vider le tableau
    const tbody = document.getElementById('notesTableBody');
    tbody.innerHTML = '';
    
    // Ajouter les apprenants (utilise tes données existantes)
    @foreach($inscriptions as $inscription)
        tbody.innerHTML += `
            <tr>
                <td class="border px-2 py-1">
                     {{ $inscription->apprenant->nom }} {{ $inscription->apprenant->prenom }}
                </td>
                <td class="border px-2 py-1 text-center">
                    <input type="number"
                           name="notes[{{ $inscription->id }}]"
                           step="0.01" min="0" max="20"
                           class="border rounded px-2 py-1 w-24"
                           placeholder="0.00">
                </td>
            </tr>
        `;
    @endforeach
    
    // Ouvrir le modal
    document.getElementById('addDevoirModal').classList.remove('hidden');
}

function closeAddDevoirModal() {
    document.getElementById('addDevoirModal').classList.add('hidden');
    // Réouvrir la liste des devoirs
    if (currentRessourceId) {
        openVoirDevoirModal(currentRessourceId);
    }
}
</script>

<script>
  // Fonction pour modifier une note en ligne
function editNoteInline(devoirId) {
    const row = document.getElementById('devoir-row-' + devoirId);
    const noteDisplay = document.getElementById('note-display-' + devoirId);
    const currentNote = noteDisplay.textContent.replace('/20', '').trim();
    
    // Remplacer l'affichage par un champ de saisie
    noteDisplay.outerHTML = `
        <div class="flex items-center justify-center gap-1">
            <input type="number" 
                   id="edit-input-${devoirId}"
                   value="${isNaN(parseFloat(currentNote)) ? '' : currentNote}"
                   step="0.01" min="0" max="20"
                   class="border rounded px-2 py-1 w-20 text-center">
            <button onclick="saveNoteInline(${devoirId})"
                    class="bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700">
                <i class="fa fa-check"></i>
            </button>
            <button onclick="cancelEditNoteInline(${devoirId})"
                    class="bg-gray-600 text-white text-xs px-2 py-1 rounded hover:bg-gray-700">
                <i class="fa fa-times"></i>
            </button>
        </div>
    `;
}

// Fonction pour sauvegarder la note
function saveNoteInline(devoirId) {
    const input = document.getElementById('edit-input-' + devoirId);
    const newNote = input.value;
    const apprenantName = document.querySelector('#devoir-row-' + devoirId + ' td:first-child').textContent.trim();
    
    if (!newNote || isNaN(newNote) || newNote < 0 || newNote > 20) {
        alert('Note invalide (0-20)');
        return;
    }
    
    if (!confirm(`Mettre à jour la note de ${apprenantName} à ${newNote}/20 ?`)) {
        return;
    }
    
    fetch('/devoirAPC/' + devoirId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ note: newNote })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mettre à jour l'affichage
            const colorClass = newNote >= 10 ? 'text-green-600' : 'text-red-600';
            document.querySelector('#edit-input-' + devoirId).parentElement.outerHTML = 
                `<span id="note-display-${devoirId}" class="font-semibold ${colorClass}">${parseFloat(newNote).toFixed(2)}/20</span>`;
            
            // Rafraîchir la MCC si nécessaire
            setTimeout(() => {
                if (currentRessourceId) {
                    openVoirDevoirModal(currentRessourceId);
                }
            }, 500);
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erreur lors de la mise à jour');
        cancelEditNoteInline(devoirId);
    });
}

// Fonction pour annuler l'édition
function cancelEditNoteInline(devoirId) {
    // Recharger la ligne pour afficher la note originale
    if (currentRessourceId) {
        openVoirDevoirModal(currentRessourceId);
    }
}

// Fonction pour supprimer une note individuelle

</script>
<script>// Fonction pour charger la liste des devoirs avec filtre
function openVoirDevoirModal(ressourceId) {
    currentRessourceId = ressourceId;
    
    document.getElementById('devoirsListContainer').innerHTML = 
        '<div class="text-center py-8">Chargement...</div>';
    
    document.getElementById('voirDevoirsModal').classList.remove('hidden');
    
    // Charger sans filtre initial
    chargerDevoirs(ressourceId);
}

function chargerDevoirs(ressourceId, semestre = '') {
    let url = `/devoirAPC/ressource/${ressourceId}`;
    
    // Ajouter le filtre semestre si spécifié
    if (semestre) {
        url += `?semestre=${semestre}`;
    }
    
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('devoirsListContainer').innerHTML = html;
    })
    .catch(error => {
        document.getElementById('devoirsListContainer').innerHTML = 
            '<div class="text-center py-8 text-red-500">Erreur de chargement</div>';
    });
}

// Fonction pour filtrer par semestre
function filtrerParSemestre() {
    const semestre = document.getElementById('filtreSemestre').value;
    
    if (currentRessourceId) {
        chargerDevoirs(currentRessourceId, semestre);
    }
}</script>
<script>
    // Fonction pour charger une page spécifique
function chargerPage(page) {
    currentPage = page;
    chargerDevoirs(currentRessourceId, currentSemestre, currentPage);
}

// Fonction pour charger les devoirs
function chargerDevoirs(ressourceId, semestre = '', page = 1) {
    if (!ressourceId) return;
    
    // Construire l'URL correctement
    let url = `/devoirAPC/ressource/${ressourceId}?page=${page}`;
    
    if (semestre) {
        url += `&semestre=${semestre}`;
    }
    
    console.log('Chargement URL:', url); // Debug
    
    // Afficher le chargement
    const container = document.getElementById('devoirsListContainer');
    if (container) {
        container.innerHTML = '<div class="text-center py-8">Chargement...</div>';
    }
    
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(html => {
        if (container) {
            container.innerHTML = html;
            // Réinitialiser les événements après chargement
            reinitPaginationEvents();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (container) {
            container.innerHTML = '<div class="text-center py-8 text-red-500">Erreur de chargement</div>';
        }
    });
}

// Réinitialiser les événements de pagination
function reinitPaginationEvents() {
    // Réattacher les événements aux liens de pagination
    document.querySelectorAll('a[onclick^="chargerPage"]').forEach(link => {
        const oldOnclick = link.getAttribute('onclick');
        link.removeAttribute('onclick');
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const pageMatch = oldOnclick.match(/chargerPage\((\d+)\)/);
            if (pageMatch && pageMatch[1]) {
                chargerPage(parseInt(pageMatch[1]));
            }
        });
    });
}
</script>
 @if($classe->modalite === 'PPO')
        @include('classe.ppo.partials.devoir_modal')
        @include('classe.ppo.partials.voir_devoir_modal')
        @include('classe.ppo.partials.add_devoir_modal')
        @include('classe.ppo.partials.devoir_script')

    @endif
</x-app-layout>
