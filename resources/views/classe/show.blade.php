<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Informations détaillées de la classe') }}
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="bg-white shadow rounded-lg p-6">

            {{-- ==== Année académique en cours (s'applique à toute la page) ==== --}}
            @php $userTop = auth()->user(); @endphp
            @if(
                $userTop->hasRole('chef_de_travaux') ||
                $userTop->hasRole('chef_etablissement') ||
                $userTop->hasRole('superadmin') ||
                $userTop->hasRole('agent') ||
                $userTop->hasRole('autorite') ||
                $userTop->hasRole('directeur_etude') ||
                $userTop->hasRole('formateur')
            )
                <form method="GET" action="{{ route('classe.show', $classe->id) }}" class="mb-6">
                    <label for="annee_academique_id"
                           class="bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg text-base font-bold px-5 py-3 inline-flex items-center gap-3 cursor-pointer shadow-md w-fit">
                        <i class="fa fa-calendar-days text-lg"></i>
                        <span>Sélectionner une année académique :</span>
                        <select name="annee_academique_id" id="annee_academique_id" onchange="this.form.submit()"
                                class="bg-indigo-600 text-white font-extrabold text-base border-none focus:outline-none focus:ring-0 cursor-pointer">
                            @foreach ($anneeAcademiques as $annee)
                                <option value="{{ $annee->id }}" class="text-black"
                                        {{ ($selectedAnneeAcademiqueId ?? request('annee_academique_id')) == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->code }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </form>
            @endif

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
        $user->hasRole('formateur')||
        $user->hasRole('autorité')||
        $user->hasRole('superadmin') || $user->hasRole('agent')
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
            @endif

            {{-- 🔸 Formulaire d’assignation + filtre semestre, sur une seule ligne --}}
            <div class="flex flex-wrap gap-3 items-end mb-1">

                @if(!$user->hasRole('formateur'))
                    <form id="assignForm" method="POST" action="{{ route('classe.assign.store', $classe->id) }}"
                          style="display:contents" onsubmit="return checkSemestreSelected()">
                        @csrf
                        <input type="hidden" name="annee_academique_id" value="{{ $selectedAnneeAcademiqueId ?? '' }}">
                        <input type="hidden" name="semestre" value="{{ $selectedSemestre ?? '' }}">

                        <div class="flex-1 min-w-[180px]">
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

                        <div class="flex-1 min-w-[180px]">
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
                    </form>
                @endif

                <form method="GET" action="{{ route('classe.show', $classe->id) }}" style="display:contents" onsubmit="return false">
                    <input type="hidden" name="annee_academique_id" value="{{ $selectedAnneeAcademiqueId ?? '' }}">
                    <div class="flex-1 min-w-[160px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Choisissez un semestre
                        </label>
                        <select id="globalSemestre" name="semestre" required onchange="changerSemestre(this)"
                            class="w-full border-gray-300 focus:ring-first-orange focus:border-first-orange rounded-md p-2 text-sm">
                            <option value="" disabled {{ empty($selectedSemestre) ? 'selected' : '' }}>-- Choisir un semestre --</option>
                            <option value="1" {{ ($selectedSemestre ?? '') == 1 ? 'selected' : '' }}>Premier semestre</option>
                            <option value="2" {{ ($selectedSemestre ?? '') == 2 ? 'selected' : '' }}>Deuxième semestre</option>
                        </select>
                    </div>
                </form>

                @if(!$user->hasRole('formateur') && ($user->hasRole('chef_etablissement')|| $user->hasRole('directeur_etude') || $user->hasRole('chef_de_travaux')))
                    <div>
                        <button type="submit" form="assignForm"
                            class="bg-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-700">
                            Assigner
                        </button>
                    </div>
                @endif
            </div>
            <p class="text-xs text-gray-500 mb-4">(le semestre filtre la liste ci-dessous et sera utilisé pour toute nouvelle assignation)</p>

            @if (session('success'))
                <div class="mb-3 p-2 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('message'))
                <div class="mb-3 p-2 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-3 p-2 bg-red-100 text-red-700 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

         <div id="assignationsTable">
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
            <td class="px-3 py-2 border font-semibold text-gray-800">
                {{ $a->matiere_nom ?? '-' }}
                @if(!empty($a->semestre))
                    <div class="text-xs text-gray-500 font-normal">Semestre {{ $a->semestre }}</div>
                @endif
            </td>

            <td class="px-3 py-2 border text-center">
                {{-- Supprimer seulement admin --}}
                @if(!$user->hasRole('formateur') && !$user->hasRole('superadmin') && !$user->hasRole('autorite') && !$user->hasRole('agent'))
                    @php
                        $semestresConcernes = !empty($a->semestre) ? [(int) $a->semestre] : [1, 2];
                        $nbDevoirs = collect($semestresConcernes)->sum(fn ($sm) => $notesParMatiereSemestre[$a->matiere_id . '|' . $sm]['devoirs'] ?? 0);
                        $nbEvaluations = collect($semestresConcernes)->sum(fn ($sm) => $notesParMatiereSemestre[$a->matiere_id . '|' . $sm]['evaluations'] ?? 0);
                        $msgSuppr = "Supprimer l'affectation de la matière « {$a->matiere_nom} » pour "
                            . trim($a->formateur_prenom . ' ' . $a->formateur_nom)
                            . (!empty($a->semestre) ? " (semestre {$a->semestre})" : ' (tous les semestres)') . " ?"
                            . "\n\nATTENTION : les notes de cette matière pour cette classe et cette année seront DÉFINITIVEMENT supprimées"
                            . " ({$nbDevoirs} devoir(s), {$nbEvaluations} évaluation(s) avec compositions)"
                            . ", sauf si un autre formateur reste affecté à cette matière pour ce semestre."
                            . "\n\nCette action est irréversible.";
                    @endphp
                    <form class="inline-block" method="POST"
                          onsubmit="return demanderConfirmation(this, {{ \Illuminate\Support\Js::from($msgSuppr) }})"
                          action="{{ route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->matiere_id]) }}">
                        @csrf @method('DELETE')
                        <input type="hidden" name="annee_academique_id" value="{{ $selectedAnneeAcademiqueId ?? '' }}">
                        <input type="hidden" name="semestre" value="{{ $a->semestre }}">
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
            ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $selectedAnneeAcademiqueId,
                fn ($q) => $q->where('annee_academique_id', $selectedAnneeAcademiqueId))
            ->orderBy('id')
            ->get();
    }

    // ✅ On prend la ressource correspondant à l'occurrence
    $ressource = $apcRessourcesCache[$key]->get($slotIndex);

    $devoirs = $ressource
        ? (
            $user->hasRole('formateur')
                ? $ressource->devoirsAPC->where('annee_academique_id', $selectedAnneeAcademiqueId)
                : $ressource->devoirsAPC->where('annee_academique_id', $selectedAnneeAcademiqueId)->whereNotNull('note')
          )
        : collect();
@endphp


<tr class="border-b hover:bg-gray-50">

    <td class="px-3 py-2 border">
        {{ $a->formateur_prenom }} {{ $a->formateur_nom }}
    </td>

    <td class="px-3 py-2 border font-semibold">
        {{ $a->competence_nom }}
        <div class="text-xs text-gray-500">
            (Compétence générale)
            @if(!empty($a->semestre))
                &middot; Semestre {{ $a->semestre }}
            @endif
        </div>
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
                    <!-- <button onclick="openRessourceModal({{ $a->competence_id }}, '{{ $a->competence_nom }}')"
                            class="bg-green-600 text-white text-xs px-2 py-1 rounded">
                        + Discipline
                    </button> -->
                    <button
  type="button"
  data-competence-id="{{ $a->competence_id }}"
  data-competence-nom="{{ $a->competence_nom }}"
  onclick="openRessourceModalFromBtn(this)"
  class="bg-green-600 text-white text-xs px-2 py-1 rounded"
>
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

          @php
        $formateurNom = trim($a->formateur_prenom . ' ' . $a->formateur_nom);
        if ($ressource) {
            $nbDevoirsRes = \App\Models\DevoirAPC::where('ressource_id', $ressource->id)->count();
            $nbCompositions = \App\Models\Evalute::where('ressource_id', $ressource->id)->whereNotNull('composition')->count();
            $nbSommatives = \App\Models\Sommation::where('ressource_id', $ressource->id)->count();
            $msgSuppr = "Supprimer la discipline « {$ressource->nom} » (compétence « {$a->competence_nom} », {$formateurNom}) ?"
                . "\n\nATTENTION : les notes de cette discipline seront DÉFINITIVEMENT supprimées"
                . " ({$nbDevoirsRes} devoir(s), {$nbCompositions} composition(s), {$nbSommatives} note(s) sommative(s))."
                . "\n\nSi c'est la dernière discipline de ce formateur pour cette compétence, l'affectation sera aussi supprimée."
                . "\n\nCette action est irréversible.";
        } else {
            $msgSuppr = "Supprimer l'affectation de la compétence « {$a->competence_nom} » pour {$formateurNom} ?"
                . ($a->competence_type === 'particuliere'
                    ? "\n\nATTENTION : les notes sommatives des critères de cette compétence pour cette classe et cette année seront DÉFINITIVEMENT supprimées (sauf si une autre affectation la couvre encore)."
                    : '')
                . "\n\nCette action est irréversible.";
        }
    @endphp
    <form method="POST"
          onsubmit="return demanderConfirmation(this, {{ \Illuminate\Support\Js::from($msgSuppr) }})"
          action="{{ route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->competence_id]) }}">
    @csrf
    @method('DELETE')
    {{-- Année affichée sur la page (la suppression porte sur les affectations de cette année) --}}
    <input type="hidden" name="annee_academique_id" value="{{ $selectedAnneeAcademiqueId ?? '' }}">

    {{-- ✅ id unique de l'assignation (ligne cfc) --}}
    
    <input type="hidden" name="assign_id" value="{{ $a->assign_id }}">



    {{-- ✅ optionnel : si une discipline existe, on peut supprimer la discipline ciblée --}}
    @if($ressource)
        <input type="hidden" name="ressource_id" value="{{ $ressource->id }}">
    @endif
@if(!$user->hasRole('formateur') && !$user->hasRole('superadmin') && !$user->hasRole('autorite') && !$user->hasRole('agent'))
    <button class="bg-red-600 text-white text-xs px-2 py-1 rounded">
        Supprimer
    </button>
@endif
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
            ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources') && $selectedAnneeAcademiqueId,
                fn ($q) => $q->where('annee_academique_id', $selectedAnneeAcademiqueId))
            ->orderBy('id')
            ->get();
    }

    // ✅ On prend la ressource correspondant à l'occurrence
    $ressource = $apcRessourcesCache[$key]->get($slotIndex);

    $devoirs = $ressource
        ? (
            $user->hasRole('formateur')
                ? $ressource->devoirsAPC->where('annee_academique_id', $selectedAnneeAcademiqueId)
                : $ressource->devoirsAPC->where('annee_academique_id', $selectedAnneeAcademiqueId)->whereNotNull('note')
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
        <div class="text-xs text-gray-500">
            (Compétence particulière)
            @if(!empty($a->semestre))
                &middot; Semestre {{ $a->semestre }}
            @endif
        </div>
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
                    <!-- <button onclick="openRessourceModal({{ $a->competence_id }}, '{{ $a->competence_nom }}')"
                            class="bg-green-600 text-white text-xs px-2 py-1 rounded">
                        + Discipline
                    </button> -->
                    <button type="button"data-competence-id="{{ $a->competence_id }}"data-competence-nom="{{ $a->competence_nom }}"onclick="openRessourceModalFromBtn(this)"
                    class="bg-green-600 text-white text-xs px-2 py-1 rounded"> + Discipline
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

          @php
        $formateurNom = trim($a->formateur_prenom . ' ' . $a->formateur_nom);
        if ($ressource) {
            $nbDevoirsRes = \App\Models\DevoirAPC::where('ressource_id', $ressource->id)->count();
            $nbCompositions = \App\Models\Evalute::where('ressource_id', $ressource->id)->whereNotNull('composition')->count();
            $nbSommatives = \App\Models\Sommation::where('ressource_id', $ressource->id)->count();
            $msgSuppr = "Supprimer la discipline « {$ressource->nom} » (compétence « {$a->competence_nom} », {$formateurNom}) ?"
                . "\n\nATTENTION : les notes de cette discipline seront DÉFINITIVEMENT supprimées"
                . " ({$nbDevoirsRes} devoir(s), {$nbCompositions} composition(s), {$nbSommatives} note(s) sommative(s))."
                . "\n\nSi c'est la dernière discipline de ce formateur pour cette compétence, l'affectation sera aussi supprimée."
                . "\n\nCette action est irréversible.";
        } else {
            $msgSuppr = "Supprimer l'affectation de la compétence « {$a->competence_nom} » pour {$formateurNom} ?"
                . ($a->competence_type === 'particuliere'
                    ? "\n\nATTENTION : les notes sommatives des critères de cette compétence pour cette classe et cette année seront DÉFINITIVEMENT supprimées (sauf si une autre affectation la couvre encore)."
                    : '')
                . "\n\nCette action est irréversible.";
        }
    @endphp
    <form method="POST"
          onsubmit="return demanderConfirmation(this, {{ \Illuminate\Support\Js::from($msgSuppr) }})"
          action="{{ route('classe.assign.destroy', [$classe->id, $a->formateur_id, $a->competence_id]) }}">
    @csrf
    @method('DELETE')
    {{-- Année affichée sur la page (la suppression porte sur les affectations de cette année) --}}
    <input type="hidden" name="annee_academique_id" value="{{ $selectedAnneeAcademiqueId ?? '' }}">

<input type="hidden" name="assign_id" value="{{ $a->assign_id }}">


 
    @if($ressource)
        <input type="hidden" name="ressource_id" value="{{ $ressource->id }}">
    @endif

            @if(!$user->hasRole('formateur'))
    <button class="bg-red-600 text-white text-xs px-2 py-1 rounded">
        Supprimer
    </button>
    @endif
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
</div>{{-- /#assignationsTable --}}


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
            {{-- Année affichée sur la page : la discipline est créée pour cette année-là --}}
            <input type="hidden" name="annee_academique_id" value="{{ $selectedAnneeAcademiqueId ?? '' }}">

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
            <span class="text-sm font-semibold text-green-700" id="devoirModalSemestreLabel">-</span>
            <input type="hidden" name="semestre" id="devoirModalSemestreInput">
          </div>

          <div class="flex-1">
            <label class="block text-sm mb-1">Libellé du devoir</label>
            <input type="text" name="libelle"
                   class="w-full border rounded px-2 py-1" required>
          </div>
        </div>
      </div>

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

        <div class="mb-4 flex items-center gap-4 flex-wrap">
            <span class="text-xs text-gray-600">
                Année académique : <strong>{{ $anneeAcademiques->firstWhere('id', $selectedAnneeAcademiqueId)?->code ?? '-' }}</strong>
            </span>
            <label class="text-sm font-medium">Semestre :</label>
            <span class="text-sm font-semibold text-green-700" id="voirDevoirsModalSemestreLabel">-</span>
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
     class="hidden fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4">

  <!-- MODAL -->
  <div class="bg-white rounded-lg shadow-2xl w-[95%] max-w-[1400px]"
       style="height:90vh; display:flex; flex-direction:column; overflow:hidden;">

    <!-- HEADER FIXE -->
    <div class="p-4 border-b flex justify-between items-center bg-white"
         style="flex:0 0 auto;">
      <h3 class="font-semibold text-lg">Ajouter un nouveau devoir</h3>
      <button onclick="closeAddDevoirModal()"
              class="text-red-600 font-bold text-lg leading-none">✕</button>
    </div>

    <!-- FORM -->
    <form method="POST"
          action="{{ route('devoirAPC.store') }}"
          style="flex:1 1 auto; min-height:0; display:flex; flex-direction:column;">
      @csrf

      <input type="hidden" name="ressource_id" id="add_devoir_ressource_id">

      <!-- CHAMPS FIXES -->
      <div class="p-4 border-b bg-white"
           style="flex:0 0 auto;">
        <span class="text-sm font-semibold text-green-700" id="addDevoirModalSemestreLabel">-</span>
      <input type="hidden" name="semestre" id="addDevoirModalSemestreInput">

        <div class="mt-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">
            Libellé du devoir
          </label>
          <input type="text" name="libelle"
                 class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                 required>
        </div>
      </div>

      <!-- CONTENU SCROLLABLE -->
      <div class="p-4"
           style="flex:1 1 auto; min-height:0; overflow-y:scroll; -webkit-overflow-scrolling:touch;">

        <table class="w-full border text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2 text-left">Apprenant</th>
              <th class="border px-3 py-2 text-left w-32">Note</th>
            </tr>
          </thead>
          <tbody id="notesTableBody">
            <!-- lignes dynamiques -->
          </tbody>
        </table>

      </div>

      <!-- FOOTER FIXE -->
      <div class="p-4 border-t bg-white flex justify-end gap-3"
           style="flex:0 0 auto;">
        <button type="button"
                onclick="closeAddDevoirModal()"
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
    $user->hasRole('superadmin') ||
    $user->hasRole('agent') ||
    $user->hasRole('autorite') ||
    $user->hasRole('directeur_etude')
)
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
        {{-- Année académique sélectionnée (session) --}}
        @php
            $annee = $anneeAcademiques->firstWhere('id', $selectedAnneeAcademiqueId);
        @endphp

        @if($annee)
            <input type="hidden" name="annee_academique_id" value="{{ $annee->id }}">
            <span class="text-xs text-gray-600 whitespace-nowrap">Année : <strong>{{ $annee->code }}</strong></span>
        @else
            <p class="text-red-500 text-sm">⚠️ Aucune année académique sélectionnée</p>
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
    @php
        $apprenant = $entry['user']->apprenant;
        $authInscriptionId = auth()->user()->inscription_id;
    
        $canSee = is_null($authInscriptionId) || ($authInscriptionId === $entry['user']->id);
    @endphp

    @if ($canSee)
        <tr>
            <td class="px-2 py-2">{{ $apprenant->matricule ?? '-' }}</td>
            <td class="px-2 py-2">
                {{ $apprenant->nom ?? '-' }}
                {{ $apprenant->prenom ?? '' }}
            </td>
            <td class="px-2 py-2 text-center">
                {{ $apprenant?->date_naissance ? \Carbon\Carbon::parse($apprenant->date_naissance)->format('d-m-Y') : '-' }}
            </td>
            <td class="px-2 py-2 text-center">
    
                <a href="{{ route('inscription.show', $entry['user']->id) }}" class="text-green-600 hover:text-green-800">
                    <i class="fa fa-eye"></i>
                </a>

            </td>
        </tr>
    @endif
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
                        {{ $inscriptions->appends(['annee_academique_id' => $selectedAnneeAcademiqueId ?? request('annee_academique_id')])->links() }}
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
 <!-- <script>
    function openRessourceModal(id, nom) {
        document.getElementById('elementId').value = id; // competence_id
        document.getElementById('elementNom').textContent = nom;
        document.getElementById('ressourceModal').classList.remove('hidden');
    }

    function closeRessourceModal() {
        document.getElementById('ressourceModal').classList.add('hidden');
    }
</script> -->
<script>
  function openRessourceModalFromBtn(btn) {
    const id = btn.dataset.competenceId;
    const nom = btn.dataset.competenceNom;

    document.getElementById('elementId').value = id;
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
    if (!getGlobalSemestre()) {
        alert('Veuillez sélectionner un semestre avant d\'ajouter un devoir.');
        return;
    }
    syncGlobalSemestre();
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

function openAddDevoirModal() {
    if (!getGlobalSemestre()) {
        alert('Veuillez sélectionner un semestre avant d\'ajouter un devoir.');
        return;
    }
    closeVoirDevoirsModal();
    syncGlobalSemestre();
    document.getElementById('add_devoir_ressource_id').value = currentRessourceId;
    
    // Vider le tableau
    const tbody = document.getElementById('notesTableBody');
    tbody.innerHTML = '';
    
    // Ajouter les apprenants (utilise tes données existantes)
 // Ajouter les apprenants (utilise tes données existantes)
// ✅ Ajouter TOUS les apprenants de la classe (non paginé)
@foreach($inscriptionsAll as $inscription)
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
<script>
function openVoirDevoirModal(ressourceId) {
    currentRessourceId = ressourceId;
    syncGlobalSemestre();

    document.getElementById('devoirsListContainer').innerHTML =
        '<div class="text-center py-8">Chargement...</div>';

    document.getElementById('voirDevoirsModal').classList.remove('hidden');

    chargerDevoirs(ressourceId, getGlobalSemestre());
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

function filtrerParSemestre() {
    if (currentRessourceId) {
        chargerDevoirs(currentRessourceId, getGlobalSemestre());
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
<script>
function showToastApc(message, type = 'success') {
    const colors = { success: 'bg-green-600', error: 'bg-red-600' };
    const toast = document.createElement('div');
    toast.className = `fixed bottom-6 right-6 z-[100] text-white text-sm px-5 py-3 rounded shadow-lg ${colors[type]}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

function confirmerSuppressionApc(devoirId, semestre, libelle) {
    const semestreLabel = semestre == 1 ? 'Premier semestre (S1)' : 'Deuxième semestre (S2)';
    const ok = confirm(`Êtes-vous sûr de vouloir supprimer les notes du devoir "${libelle}" du ${semestreLabel} ?`);
    if (!ok) return;

    fetch(`/devoirAPC/${devoirId}?semestre=${semestre}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const container = document.getElementById('devoirsListContainer');
            if (container && currentRessourceId) {
                container.innerHTML = '<div class="text-center py-8 text-gray-500">Chargement...</div>';
                const semestreFiltre = getGlobalSemestre();
                const url = semestreFiltre
                    ? `/devoirAPC/ressource/${currentRessourceId}?semestre=${semestreFiltre}`
                    : `/devoirAPC/ressource/${currentRessourceId}`;

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                })
                .then(r => r.text())
                .then(html => {
                    container.innerHTML = html;
                    showToastApc('✅ Devoir supprimé avec succès.');
                })
                .catch(() => showToastApc('Erreur de rechargement.', 'error'));
            }
        } else {
            showToastApc('Erreur lors de la suppression.', 'error');
        }
    })
    .catch(() => showToastApc('Erreur réseau.', 'error'));
}
</script>

{{-- Fenêtre de confirmation des suppressions d'affectation (remplace la boîte native du navigateur) --}}
<div id="confirmationSuppression" role="dialog" aria-modal="true" aria-labelledby="confirmationTitre"
     style="display:none;position:fixed;inset:0;z-index:80;background:rgba(17,24,39,.55);align-items:center;justify-content:center;padding:1rem;">
    <div style="background:#fff;border-radius:.75rem;max-width:32rem;width:100%;box-shadow:0 25px 50px -12px rgba(0,0,0,.35);overflow:hidden;">
        <div style="display:flex;align-items:center;gap:.75rem;padding:1rem 1.25rem;border-bottom:1px solid #e5e7eb;">
            <span aria-hidden="true" style="flex:none;width:2.25rem;height:2.25rem;border-radius:9999px;background:#fee2e2;color:#dc2626;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.1rem;">!</span>
            <h3 id="confirmationTitre" style="margin:0;font-size:1.05rem;font-weight:600;color:#111827;">Confirmer la suppression</h3>
        </div>
        <div id="confirmationCorps" style="padding:1rem 1.25rem;max-height:60vh;overflow-y:auto;font-size:.9rem;line-height:1.45;color:#374151;"></div>
        <div style="display:flex;justify-content:flex-end;gap:.5rem;padding:.85rem 1.25rem;background:#f9fafb;border-top:1px solid #e5e7eb;">
            <button type="button" id="confirmationAnnuler"
                    style="padding:.5rem 1rem;border-radius:.5rem;border:1px solid #d1d5db;background:#fff;color:#374151;font-size:.875rem;cursor:pointer;">Annuler</button>
            <button type="button" id="confirmationValider"
                    style="padding:.5rem 1rem;border-radius:.5rem;border:1px solid #dc2626;background:#dc2626;color:#fff;font-size:.875rem;font-weight:600;cursor:pointer;">Supprimer définitivement</button>
        </div>
    </div>
</div>

<script>
// Confirmation par fenêtre intégrée. Le message est découpé en paragraphes (séparés par une ligne vide) :
// le premier est la question, ceux qui commencent par « ATTENTION » sont mis en évidence.
(function () {
    let formulaire = null;
    let precedent = null;

    const boite = () => document.getElementById('confirmationSuppression');

    function fermer() {
        boite().style.display = 'none';
        document.removeEventListener('keydown', touches);
        formulaire = null;
        if (precedent && precedent.focus) precedent.focus();
    }

    function touches(e) {
        if (e.key === 'Escape') fermer();
    }

    window.demanderConfirmation = function (form, message) {
        if (!boite()) return confirm(message);   // repli : boîte native si la fenêtre est absente

        formulaire = form;
        precedent = document.activeElement;

        const corps = document.getElementById('confirmationCorps');
        corps.textContent = '';
        String(message).split('\n\n').forEach(function (bloc, i) {
            const p = document.createElement('p');
            p.textContent = bloc;
            p.style.margin = i === 0 ? '0 0 .75rem' : '.5rem 0 0';
            if (i === 0) {
                p.style.fontWeight = '600';
                p.style.color = '#111827';
            } else if (/^attention/i.test(bloc)) {
                p.style.cssText += ';padding:.6rem .75rem;background:#fef2f2;border:1px solid #fecaca;border-radius:.5rem;color:#991b1b;';
            } else if (/^cette action est irr/i.test(bloc)) {
                p.style.fontWeight = '600';
                p.style.color = '#991b1b';
            }
            corps.appendChild(p);
        });

        document.getElementById('confirmationValider').disabled = false;
        boite().style.display = 'flex';
        document.getElementById('confirmationAnnuler').focus();   // le choix par défaut est d'annuler
        document.addEventListener('keydown', touches);

        return false;   // la soumission attend le clic sur « Supprimer définitivement »
    };

    document.getElementById('confirmationAnnuler').addEventListener('click', fermer);
    boite().addEventListener('click', function (e) { if (e.target === boite()) fermer(); });
    document.getElementById('confirmationValider').addEventListener('click', function () {
        const f = formulaire;
        this.disabled = true;   // évite un double envoi
        boite().style.display = 'none';
        document.removeEventListener('keydown', touches);
        if (f) f.submit();
    });
})();
</script>
<script>
function getGlobalSemestre() {
    return document.getElementById('globalSemestre')?.value || '';
}

// Change de semestre sans recharger la page : le serveur renvoie la page filtrée (même logique
// qu'avant, y compris la numérotation des disciplines APC) et on ne remplace que le tableau des
// affectations. Le formateur, la matière ou la compétence déjà choisis sont conservés.
let changementSemestreEnCours = 0;
async function changerSemestre(select) {
    const semestre = select.value;
    if (!semestre) return;

    const champ = document.querySelector('#assignForm input[name="semestre"]');
    if (champ) champ.value = semestre;
    syncGlobalSemestre();

    const url = new URL(window.location.href);
    url.searchParams.set('semestre', semestre);

    const numero = ++changementSemestreEnCours;
    const cible = document.getElementById('assignationsTable');
    if (cible) cible.style.opacity = '0.5';

    try {
        const reponse = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
            credentials: 'same-origin',
        });
        if (!reponse.ok) throw new Error('HTTP ' + reponse.status);

        const page = new DOMParser().parseFromString(await reponse.text(), 'text/html');
        const nouveau = page.getElementById('assignationsTable');
        if (!nouveau) throw new Error('tableau introuvable');

        if (numero !== changementSemestreEnCours) return;   // un choix plus récent est en cours
        document.getElementById('assignationsTable').replaceWith(nouveau);
        history.replaceState(null, '', url);
    } catch (e) {
        window.location.href = url;   // repli : rechargement classique
    } finally {
        const zone = document.getElementById('assignationsTable');
        if (zone) zone.style.opacity = '';
    }
}

function checkSemestreSelected() {
    if (!getGlobalSemestre()) {
        alert('Veuillez sélectionner un semestre avant d\'assigner un formateur.');
        return false;
    }
    return true;
}

function getSemestreLabel(val) {
    if (val == 1) return 'Premier semestre';
    if (val == 2) return 'Deuxième semestre';
    return '-';
}

function syncGlobalSemestre() {
    const val  = getGlobalSemestre();
    const lbl  = getSemestreLabel(val);
    const pairs = [
        ['devoirModalSemestreLabel',    'devoirModalSemestreInput'],
        ['addDevoirModalSemestreLabel',  'addDevoirModalSemestreInput'],
        ['ppoDevoirModalSemestreLabel',  'ppoDevoirModalSemestreInput'],
        ['ppoAddDevoirSemestreLabel',    'ppoAddDevoirSemestreInput'],
    ];
    pairs.forEach(([labelId, inputId]) => {
        const el  = document.getElementById(labelId);
        const inp = document.getElementById(inputId);
        if (el)  el.textContent = lbl;
        if (inp) inp.value = val;
    });
    const vl = document.getElementById('voirDevoirsModalSemestreLabel');
    if (vl) vl.textContent = lbl;
    const vlPpo = document.getElementById('voirDevoirPpoModalSemestreLabel');
    if (vlPpo) vlPpo.textContent = lbl;
}
</script>

 @if($classe->modalite === 'PPO')
        @include('classe.ppo.partials.devoir_modal')
        @include('classe.ppo.partials.voir_devoir_modal')
        @include('classe.ppo.partials.add_devoir_modal')
        @include('classe.ppo.partials.devoir_script')

    @endif
</x-app-layout>
