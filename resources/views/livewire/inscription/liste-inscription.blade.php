<div>

@if (session()->has('error'))
  <div class="mb-4 px-4 pt-3">
    <div class="flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-sm" role="alert">
      <span class="font-medium">Erreur !</span>&nbsp;{{ session('error') }}
    </div>
  </div>
@endif
    @if (session('success'))
    <div class="mb-4">
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-sm dark:bg-gray-800 dark:text-green-300 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2A1 1 0 1 1 7.707 9.293L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            <span class="sr-only">Success</span>
            <div>
                <span class="font-medium">Succès !</span> {{ session('success') }}
            </div>
        </div>
    </div>
@endif



    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-gris text-xl py-4">
                {{ $currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée' }}
            </h2>
        </div>
        <div class="flex gap-4 items-center px-4">
            <!-- Select Classe -->
            <select wire:model="classe" wire:change="$refresh" class="border border-gray-300 p-2 rounded text-sm w-1/2">
                <option value="">Sélectionner la classe</option>
                @foreach ($classes as $c)
                    <option value="{{ $c->id }}">{{ $c->libelle }}</option>
                @endforeach
            </select>

            <!-- Select Année académique -->
            <select wire:model="anneeAcademique" wire:change="$refresh" class="border border-gray-300 p-2 rounded text-sm w-1/2">
                <option value="">Sélectionner l’année académique</option>
                @foreach ($anneeAcademiques as $a)
                    <option value="{{ $a->id }}">{{ $a->code }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($currentClasse)
        <div class="py-2 px-4 m-2 shadow bg-vert2 rounded shadow border border-black">
            <div class="grid grid-cols-3 gap-2 py-2 text-md">
                <div class="flex items-center">
                    <span class="text-gray-800">Année Scolaire :</span>
                    <span class="font-bold">{{ $anneeAcademiqueLabel ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Filière :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->metier->filiere->nom }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Métier :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->metier->nom }}</span>
                    &nbsp;&nbsp;&nbsp;
                    <span class="text-gray-800">Modalité :</span>
                    <span class="font-bold">{{ $currentClasse->modalite }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Niveau d'études :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->nom }}</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">État classe :</span>
                    <span class="font-bold">
                        {{ strval($currentClasse->statut) == "" ? 'Non Validé' : (!($currentClasse->etat_classe) ? 'Validé' : 'Lancé') }}
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-800">Nombre apprenants :</span>
                    <span class="font-bold">{{ count($apprenants) }}</span>
                </div>
            </div>
        </div>
        <br />
    @endif

    <div class="w-full sm:px-2 lg:px-4">
        <div class="">
            @if($currentClasse)
                <div class="flex py-2">
                    <div class="w-1/2 me-2 p-4 border bg-gray border shadow rounded" style="min-height:50vh">
                        <h2 class="font-bold text-xl mb-4">Liste des apprenants</h2>
                        <hr class="w-50">
                        <div class="py-2 ">
                            <table class="w-full mb-3">
                                <tbody class="bg-white divide-y ">
                                    @forelse ($apprenants as $apprenant)
                                        <tr class="text-gray-700 {{ ($selectedApprenant == $apprenant->id) ? 'bg-green-600' : '' }}">
                                            <td wire:click="loadCompetences({{ $apprenant->id }})"
                                                class="pt px-2 font-bold border-b {{ ($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-600' }}">
                                                <i class="fa fa-caret-right"></i>
                                                {{ $apprenant->apprenant->user->matricule ?? '-' }}
                                            </td>
                                            <td class="px-2 border-b {{ ($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-500' }}">
                                                {{ ($apprenant->apprenant->nom.' '.$apprenant->apprenant->prenom) ?? '-' }}
                                            </td>
                                            <td class="px-2 text-center border-b {{ ($selectedApprenant == $apprenant->id) ? 'text-white' : 'text-gray-500' }}">
                                                <a href="#" wire:click="loadCompetences({{ $apprenant->id }})" class="text-green-600">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-2 font-bold text-xs text-center">
                                                Aucun apprenant n'est enregistré pour cette classe.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if($selectedApprenant)
                    @php
    $user = auth()->user();
    $personnel = $user?->personnel;
    $isFormateurAssigné = false;

    if ($personnel && $currentClasse) {
        $isFormateurAssigné = \Illuminate\Support\Facades\DB::table('formateur_etablissement')
            ->where('classe_id', $currentClasse->id)
            ->where('personnel_etablissement_id', $personnel->id)
            ->exists();
    }
@endphp


                        <div class="w-1/2 p-4 border bg-gray-100 rounded border shadow">
                            <h2 class="font-bold text-xl mb-4">
                                Liste des matières et détails d'évaluation {{ $currentApprenant->apprenant->matricule }}
                                {{ $currentApprenant->apprenant->nom }} {{ $currentApprenant->apprenant->prenom }}
                            </h2>
                            <hr class="w-50">
                            <div class="mt-4 flex gap-4 ">
                            @php
    $user = auth()->user();
@endphp

@if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
)
                                <a class="text-white bg-green-600 text-sm rounded-md shadow-md px-2 py-2"
                                   target="_blank" href="{{ route('evaluation.pdf', $currentApprenant->id) }}">
                                    <i class="fa fa-file-pdf"></i>&nbsp;Télécharger le bulletin
                                </a>

                               <a href="{{ route('evaluation.classe.preview', ['id' => $currentClasse->id, 'semestre' => $selectedsemestre ?: 1]) }}"
   target="_blank"
   class="bg-green-600 text-white px-2 py-2 rounded-md shadow hover:bg-green-700">
   <i class="fa fa-print"></i> Imprimer les bulletins de la classe
</a>
                                @endif
  <div class="flex items-center justify-end">
                                    <label for="selectedsemestre" class="block text-sm font-bold text-gray-700 mr-2">Semestre :</label>
                                    <select wire:model="selectedsemestre" id="selectedsemestre" name="semestre"
                                            class="block w-auto border border-gray-300 rounded shadow-sm focus:border-first-orange enlever_shadow text-sm"
                                            wire:change="$refresh">
                                        <option value="">Tous les semestres</option>
                                        <option value="1">Premier semestre</option>
                                        <option value="2">Deuxième semestre</option>
                                    </select>

                                </div>
        @if ($user->hasRole('formateur'))
@foreach($matieres as $matiere)
  <tr>
    <!-- <td>{{ $matiere->nom }}</td> -->

    <td class="text-right">
     <button type="button"
        wire:click="openCompositionClasseModal({{ $matiere->id }})"
        class="bg-indigo-600 text-white text-xs px-5 py-3 rounded hover:bg-indigo-700">
  <i class="fa fa-edit"></i>&nbsp;Évaluer
</button>

    </td>
  </tr>
@endforeach
      @endif                              

 @php
    $user = auth()->user();
@endphp
     @if(
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('surveillant') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
)
     <button type="button"
       wire:click="openAbsenceClasseModal"
        class="text-white bg-green-600 text-sm rounded-md shadow-md px-4 py-2 hover:bg-green-700">
  <i class="fa fa-plus-circle"></i>&nbsp;Ajouter des absences/Retards
</button>

@if($showAbsenceClasseModal)
<div class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4"
     wire:click.self="closeAbsenceClasseModal"
     wire:keydown.escape.window="closeAbsenceClasseModal">

  <div class="bg-white rounded-lg shadow-xl w-[900px] max-w-[95vw]"
       style="height:90vh; display:flex; flex-direction:column; overflow:hidden;">

    {{-- HEADER --}}
    <div class="p-4 border-b flex items-center justify-between bg-white" style="flex:0 0 auto;">
      <div>
        <div class="font-semibold text-lg text-green-600">Gestion des absences</div>
        <div class="text-xs text-gray-600">
          Classe : <span class="font-semibold">{{ $currentClasse?->libelle ?? '-' }}</span>
          • Année : <span class="font-semibold">{{ $anneeAcademiqueLabel ?? '-' }}</span>
        </div>
      </div>

      <button type="button" wire:click="closeAbsenceClasseModal"
              class="text-red-600 font-bold text-lg leading-none">✕</button>
    </div>

    {{-- BODY SCROLL --}}
    <form method="POST" action="{{ route('absences.store') }}"
          style="flex:1 1 auto; min-height:0; display:flex; flex-direction:column;">
      @csrf

      <div class="p-4"
           style="flex:1 1 auto; min-height:0; overflow-y:auto; -webkit-overflow-scrolling:touch;">

        @if(empty($apprenantsAbsModal) || count($apprenantsAbsModal) === 0)
          <div class="text-sm text-gray-500">Aucun apprenant chargé.</div>
        @else

          <div class="text-xs text-gray-600 mb-6">
            Déplie un apprenant et remplisser le formulaire.
          </div>

          @foreach($apprenantsAbsModal as $insc)
            <details class="mb-3 border rounded-lg bg-white" data-absence-details>
              <summary class="cursor-pointer px-4 py-3 font-semibold bg-gray-50">
                
                  <span class="truncate">
                    {{ $insc->apprenant?->prenom }} {{ $insc->apprenant?->nom }}
                  </span>
                  <span class="text-xs text-gray-500 whitespace-nowrap">
                    [{{ $insc->apprenant?->matricule ?? '-' }}]
                  </span>
               
                <!-- <span class="text-xs text-gray-400 whitespace-nowrap">Ouvrir/Fermer</span> -->
              </summary>

              <div class="p-4 space-y-3">

                
              

                           <input type="hidden" name="inscription_id[{{ $insc->id }}]" value="{{ $insc->id }}">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                  <div>
                    <label class="block text-sm font-medium text-gray-700">Semestre</label>
                    <select name="semestre[{{ $insc->id }}]"
                            class="w-full border rounded p-2 js-semestre">
                      <option value="">-- Sélectionnez --</option>
                      <option value="1">Premier semestre</option>
                      <option value="2">Deuxième semestre</option>
                    </select>
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type[{{ $insc->id }}]"
                            class="w-full border rounded p-2 js-absence-type">
                      <option value="">-- Sélectionnez --</option>
                      <option value="absence">Absence</option>
                      <option value="retard">Retard</option>
                    </select>
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700 js-absence-label">
                      Nombre d’heures d’absence
                    </label>
                    <input type="number" step="0.5" min="0"
                           name="nombre_heure_absence[{{ $insc->id }}]"
                           class="w-full border rounded p-2 js-hours-abs"
                           placeholder="Ex: 2">
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre d’heures de retard</label>
                    <input type="number" step="0.5" min="0"
                           name="nombre_heure_retard[{{ $insc->id }}]"
                           class="w-full border rounded p-2 js-hours-ret "
                           placeholder="Ex: 0.5">
                  </div>

                </div>

                <div class="flex flex-wrap items-center gap-6">
                  <label class="inline-flex items-center gap-2">
                    <input type="checkbox"
                           name="justifie[{{ $insc->id }}]"
                           value="1"
                           class="js-justifie">
                    <span class="text-sm font-medium">Justifiée</span>
                  </label>

                  <label class="inline-flex items-center gap-2">
                    <input type="checkbox"
                           name="nonjustifie[{{ $insc->id }}]"
                           value="1"
                           class="js-nonjustifie">
                    <span class="text-sm font-medium">Non justifiée</span>
                  </label>

                  
                </div>

              </div>
            </details>
          @endforeach

        @endif
      </div>

      
      <div class="p-4 border-t bg-white flex justify-end gap-2" style="flex:0 0 auto;">
        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow inline-flex items-center gap-2">
          <i class="fa fa-save"></i>&nbsp; Enregistrer
        </button>
        <button type="button" wire:click="closeAbsenceClasseModal"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
          Fermer
        </button>
      </div>

    </form>

  </div>
</div>
@endif


<button type="button"
    onclick="openAbsencesListModal()"
    class="text-white bg-blue-700 text-sm rounded-md shadow-md px-2 py-2 hover:bg-blue-800">
    <i class="fa fa-eye"></i>&nbsp;Voir les absences et retards
</button>

<div id="absencesListModal"
    class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex justify-center items-center p-4 transition duration-300 ease-in-out">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl relative">
        <!-- En-tête -->
        <div class="flex justify-between items-center border-b px-4 py-3 bg-gray-100 rounded-t-lg">
            <h2 class="text-lg font-bold text-gray-800">
                Absences et retards — 
                <span class="text-green-700">
                    {{ $currentApprenant->apprenant->nom ?? '' }} {{ $currentApprenant->apprenant->prenom ?? '' }}
                </span>
            </h2>
            <button onclick="closeAbsencesListModal()"
                class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
        </div>

        <!-- Contenu -->
        <div class="p-5 max-h-[75vh] overflow-y-auto">
           @if(!empty($absences))

                <div class="overflow-x-auto border rounded-md shadow">
                     <table class="min-w-full text-sm">
                        <thead class="bg-green-700 text-black uppercase text-xs">
                            <tr>
                               
                                <th class="px-3 py-2 border">Semestre</th>
                                <th class="px-3 py-2 border">Type</th>
                                <th class="px-3 py-2 border">Nombre  heures d'absence</th>
                                <th class="px-3 py-2 border">Nombre  heures de retard</th>
                                
                                <th class="px-3 py-2 border">Justifiée</th>
                               
                                <th class="px-3 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($absences as $abs)
                                <tr class="hover:bg-gray-50">
                                   
                                    <td class="px-3 py-2 border text-center">{{ $abs->semestre ?? '-' }}</td>
                                    <td class="px-3 py-2 border text-center">
                                        @if($abs->type === 'retard')
                                            <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Retard</span>
                                        @else
                                            <span class="bg-red-200 text-red-800 px-2 py-1 rounded text-xs font-semibold">Absence</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 border text-center">{{ $abs->nombre_heure_absence ?? '-' }}</td>
                                    <td class="px-3 py-2 border text-center">{{ $abs->nombre_heure_retard ?? '-' }}</td>
                                    
                                    <td class="px-3 py-2 border text-center">
                                        @if($abs->justifie)
                                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-xs font-semibold">Oui</span>
                                        @else
                                            <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs">Non</span>
                                        @endif
                                    </td>
                                   
    <td class="px-3 py-2 border text-center">
<button type="button"
  class="bg-blue-800 hover:bg-blue-900 text-white px-3 py-1 rounded text-xs shadow"
  data-id="{{ $abs->id }}"
  data-semestre="{{ $abs->semestre }}"
  data-type="{{ $abs->type }}"
  data-habs="{{ $abs->nombre_heure_absence }}"
  data-hret="{{ $abs->nombre_heure_retard }}"
  data-justifie="{{ $abs->justifie ? 1 : 0 }}"
  data-nonjustifie="{{ $abs->nonjustifie ? 1 : 0 }}"
  data-update-url="{{ route('absences.update', $abs->id) }}"
  onclick="openEditAbsenceModal(this)">
  <i class="fa fa-edit"></i> Modifier
</button>


    
</td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-gray-600 italic py-6">
                    Aucune absence ou retard enregistré pour cet apprenant.
                </div>
            @endif
        </div>

        <!-- Pied du modal -->
        <div class="flex justify-end border-t p-4 bg-gray-50 rounded-b-lg">
            <button onclick="closeAbsencesListModal()"
                class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Fermer
            </button>
        </div>

    </div>

</div>
@endif 
<div id="editAbsenceModal"
     class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4"
     onclick="if(event.target===this)closeEditAbsenceModal()">
    <div class="bg-white rounded-lg shadow-lg w-96 p-5">
        <h3 class="text-lg font-bold mb-4 text-gray-700">Modifier l'absence</h3>

       <form id="editAbsenceForm" method="POST"  action="#">
        @csrf
         @method('PUT')

  <!-- IMPORTANT : doit avoir name="id" ou edit_absence_id pour script -->
  <input type="hidden" id="edit_absence_id" name="absence_id">

 

  <div class="mb-3">
    <label class="text-sm font-semibold text-gray-700">Semestre</label>
    <input type="text" id="edit_semestre" name="semestre"
           class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
  </div>

  <div class="mb-3">
    <label class="text-sm font-semibold text-gray-700">Type</label>
    <select id="edit_type" name="type"
            class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
      <option value="absence">Absence</option>
      <option value="retard">Retard</option>
    </select>
  </div>

  <div class="grid grid-cols-2 gap-3 mb-3">
    <div>
      <label class="text-sm font-semibold text-gray-700">Nombre d’heures d’absence</label>
   
      <input type="number" step="0.5" min="0"
             id="edit_nombre_heure_absence"
             name="nombre_heure_absence"
             class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
    </div>

    <div>
      <label class="text-sm font-semibold text-gray-700">Nombre d’heures de retard</label>
     
      <input type="number" step="0.5" min="0"
             id="edit_nombre_heure_retard"
             name="nombre_heure_retard"
             class="w-full border rounded p-2 focus:ring-green-600 focus:border-green-600">
    </div>
  </div>


  <div class="mb-3">
    <label class="inline-flex items-center gap-2">
      <input type="checkbox" id="edit_justifie" name="justifie" value="1">
      <span class="text-sm font-semibold text-gray-700">Justifiée ?</span>
    </label>
  </div>
  <div class="mb-3">
     <label class="inline-flex items-center gap-2">
      <input type="checkbox" name="nonjustifie" value="1"id="edit_nonjustifie">
      
      <span class="text-sm">Non justifiée</span>
    </label>
     </div>

  <div class="flex justify-end mt-4 space-x-2 border-t pt-4">
    <button type="button" onclick="closeEditAbsenceModal()"
            class="bg-gray-300 px-3 py-2 rounded text-gray-800 hover:bg-gray-400">
      Annuler
    </button>

    <button type="submit"
            class="bg-green-600 px-3 py-2 rounded text-white hover:bg-green-700">
      Enregistrer
    </button>
  </div>
</form>
    </div>
</div>

                            </div>
                            <div class="py-2 text-xs">
                                @php
    $user = auth()->user();

    $isFormateur = $user->hasRole('formateur');

    // Peut modifier (formateur assigné OU rôles admin/chef)
    $canEdit = $user->hasRole('superadmin')
        || $user->hasRole('chef_de_travaux')
        || $user->hasRole('directeur_etude')
        || $user->hasRole('chef_etablissement')
        || $isFormateurAssigné;

    // Historique + suppression : seulement NON formateur + rôles admin/chef
    $canHistory = !$isFormateur && (
        $user->hasRole('superadmin')
        || $user->hasRole('chef_de_travaux')
        || $user->hasRole('directeur_etude')
        || $user->hasRole('chef_etablissement')
    );

    $canDelete = $canHistory; // même règle que l'historique
@endphp
                              <table class="w-full mb-3">
    <thead>
        <tr class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold uppercase border-b">
            <th class="p-2 border text-center text-gray-800">Matière</th>
            <th class="p-2 border text-center text-gray-800">Coef</th>
            <th class="p-2 border text-center text-gray-800">Note CC</th>
            <th class="p-2 border text-center text-gray-800">Note Composition</th>
            <th class="p-2 border text-center text-gray-800">Moyenne</th>
            <th class="p-2 border text-center text-gray-800">Semestre</th>
            <th class="p-2 border text-center text-gray-800">Actions</th>
        </tr>
    </thead>

    @php
        
        $evaluByMatiere = collect($evalu ?? [])
            ->when($selectedsemestre, fn($c) => $c->where('semestre', (int) $selectedsemestre))
            ->keyBy('matiere_id');
    @endphp

    <tbody class="bg-white divide-y">
        @forelse($matieres as $matiere)
            @php
                $evaluation = $evaluByMatiere->get($matiere->id);
                $moyenne = $evaluation ? $this->calculerMoyenne($evaluation->note_cc, $evaluation->note_composition) : null;
            @endphp
            <tr>
                <td class="p-2 border text-center font-bold">{{ $matiere->nom }}</td>
                <td class="p-2 border text-center">{{ $matiere->coef }}</td>
                <td class="p-2 border text-center">{{ $evaluation->note_cc ?? '-' }}</td>
                <td class="p-2 border text-center">{{ $evaluation->note_composition ?? '-' }}</td>
                <td class="p-2 border text-center">{{ $moyenne !== null ? number_format($moyenne, 2) : '-' }}</td>
                <td class="p-2 border text-center">{{ $evaluation->semestre ?? '-' }}</td>

                <td class="p-2 border text-center">
                  
                    @if($evaluation)

                        @if($canEdit)
                            {{-- Modifier : visible pour formateur (assigné) + rôles --}}
                            <a href="#"
                               data-modal-target="default-modal-edit{{ $matiere->id }}"
                               data-modal-toggle="default-modal-edit{{ $matiere->id }}">
                                <i class="fa fa-edit text-green-600"></i>
                            </a>

                
                            <div id="default-modal-edit{{ $matiere->id }}" tabindex="-1" aria-hidden="true"
                                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Modification de l'évaluation de la matière {{ $matiere->nom }}
                                            </h3>
                                            <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="default-modal-edit{{ $matiere->id }}">
                                                ✕
                                            </button>
                                        </div>

                                        <div class="p-4 md:p-5 space-y-4">
                                            <form action="{{ route('evaluation.update', ['evaluation' => $evaluation->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="semestre" value="{{ $selectedsemestre ?: ($evaluation->semestre ?? 1) }}">
                                                <input type="hidden" name="matiere_id" value="{{ $evaluation->matiere_id }}">

                                                <div class="flex flex-wrap w-full justify-evenly mb-4">
                                                    <div class="flex-grow mr-2">
                                                        <label class="block text-sm font-bold text-gray-700">Note Contrôle Continu :</label>
                                                        <input type="text"
                                                               value="{{ $evaluation->note_cc !== null ? number_format($evaluation->note_cc, 2) : '' }}"
                                                               readonly
                                                               class="form-input rounded-md shadow-sm mt-1 block w-full bg-gray-100 cursor-not-allowed" />
                                                    </div>

                                                    <div class="flex-grow mr-2">
                                                        <label class="block text-sm font-bold text-gray-700">Note Composition :</label>
                                                        <input type="text" name="note_composition"
                                                               class="form-input rounded-md shadow-sm mt-1 block w-full"
                                                               value="{{ $evaluation->note_composition }}" />
                                                    </div>
                                                </div>

                                                <div class="flex justify-end">
                                                    <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                        Enregistrer les modifications
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Historique : seulement NON formateur (rôles) --}}
                            @if($canHistory)
                                &nbsp;&nbsp;&nbsp;
                                <a href="#"
                                   data-modal-target="default-modal-edit-note{{ $matiere->id }}"
                                   data-modal-toggle="default-modal-edit-note{{ $matiere->id }}">
                                    <i class="fa fa-eye text-orange-500"></i>
                                </a>

                                <div id="default-modal-edit-note{{ $matiere->id }}" tabindex="-1" aria-hidden="true"
                                     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Historique de modification — {{ $matiere->nom }}
                                                </h3>
                                                <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                        data-modal-hide="default-modal-edit-note{{ $matiere->id }}">
                                                    ✕
                                                </button>
                                            </div>

                                            <div class="p-4 md:p-5 space-y-4">
                                                @php
                                                    $historiques = App\Models\HistoryNote::where('evaluation_id', $evaluation->id)->get();
                                                @endphp

                                                <table class="min-w-full bg-white border border-gray-200">
                                                    <thead>
                                                        <tr class="bg-gray-200 text-left">
                                                            <th class="py-2 px-4 border-b">Auteur</th>
                                                            <th class="py-2 px-4 border-b">Modification</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($historiques as $h)
                                                            <tr class="hover:bg-gray-100">
                                                                <td class="py-2 px-4 border-b">
                                                                    {{ $h->user->nom.' '.$h->user->prenom }}
                                                                    <i class="text-xs">({{ $h->created_at->format('d-m-y H:i') }})</i>
                                                                </td>
                                                                <td class="py-2 px-4 border-b">
                                                                    @if($h->old_note_cc == null && $h->old_note_composition == null)
                                                                        Nouvelle note ajoutée
                                                                    @elseif($h->old_note_cc != null && $h->old_note_composition != null)
                                                                        Respectivement {{ $h->old_note_cc }} et {{ $h->old_note_composition }} avant la modification.
                                                                    @elseif($h->old_note_cc != null && $h->old_note_composition == null)
                                                                        Note de contrôle continu modifiée ({{ $h->old_note_cc }})
                                                                    @elseif($h->old_note_cc == null && $h->old_note_composition != null)
                                                                        Note de composition modifiée ({{ $h->old_note_composition }})
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="2" class="p-2 font-bold text-lg text-center">Pas d'historique.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                           
                           

                        @else
                            <span class="text-gray-400 text-xs italic">Non autorisé</span>
                        @endif

                    @else
                        {{-- === Pas d'évaluation : formateur assigné peut ajouter === --}}
                        @if($isFormateurAssigné)
                            <a href="#"
                               data-modal-target="default-modal{{ $matiere->id }}"
                               data-modal-toggle="default-modal{{ $matiere->id }}">
                                <!-- <i class="fa fa-plus-circle text-green-600"></i> -->
                            </a>

                            <!-- Modal Ajouter -->
                            <!-- <div id="default-modal{{ $matiere->id }}" tabindex="-1" aria-hidden="true"
                                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Évaluation — {{ $matiere->nom }}
                                            </h3>
                                            <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="default-modal{{ $matiere->id }}">
                                                ✕
                                            </button>
                                        </div>

                                        <div class="p-4 md:p-5 space-y-4">
                                            <form action="{{ route('evaluation.store', ['inscriptionId' => $inscriptionId]) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="inscription_id" value="{{ $inscriptionId }}">
                                                <input type="hidden" name="matiere_id" value="{{ $matiere->id }}">
                                                <input type="hidden" name="semestre" value="{{ $selectedsemestre }}">

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-bold text-gray-700">Moyenne Contrôle Continu</label>
                                                        <input type="text"
                                                               wire:model.live="moyenneCC.{{ $matiere->id }}"
                                                               readonly
                                                               class="form-input rounded-md bg-gray-100 shadow-sm mt-1 w-full text-gray-700 cursor-not-allowed"/>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-bold text-gray-700">Note Composition</label>
                                                        <input type="text" name="note_composition"
                                                               class="form-input rounded-md shadow-sm mt-1 w-full"/>
                                                    </div>
                                                </div>

                                                <div class="flex justify-end mt-4">
                                                    <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                        Enregistrer
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        @else
                            <span class="text-gray-400 text-xs italic">Non autorisé</span>
                        @endif
                    @endif
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="7" class="p-3 text-center font-bold">Aucune matière.</td>
            </tr>
        @endforelse
    </tbody>
</table>

                            </div>
                        </div>
                    @else
                        <div class="w-full items-center text-md m-3 text-center text-red-600">
                            Aucun apprenant sélectionné !
                        </div>
                    @endif
                </div>
            @else
                <div class="flex p-10 justify-center items-center">
                    <h3 class="text-2xl">Aucune donnée disponible</h3>
                </div>
            @endif
        </div>
    </div>
  
@include('livewire.inscription.partials.composition_modal')

</div>
<script>
    function openAbsenceModal() {
        document.getElementById('absenceModal').classList.remove('hidden');
    }

    function closeAbsenceModal() {
        document.getElementById('absenceModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const typeSelect = document.getElementById('typeAbsence');
        const retardDiv = document.getElementById('minutesRetardDiv');

        typeSelect.addEventListener('change', function() {
            if (this.value === 'retard') {
                retardDiv.classList.remove('hidden');
            } else {
                retardDiv.classList.add('hidden');
            }
        });
    });
</script>
<script>
    function openAbsencesListModal() {
        const modal = document.getElementById('absencesListModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeAbsencesListModal() {
        const modal = document.getElementById('absencesListModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>


<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('back-to-evaluation', (data) => {
            const matiereId = data.matiereId;
            const modalId = 'default-modal' + matiereId;

            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    });
</script>
<script>
    Livewire.on('moyenneCCUpdated', moyenne => {
        console.log('Nouvelle moyenne CC :', moyenne);
    });
</script>
<!-- <script>
(function () {
  function syncType(details){
    const typeSel = details.querySelector('.js-absence-type');
    const label   = details.querySelector('.js-absence-label');
    const hAbs    = details.querySelector('.js-hours-abs');
    const hRet    = details.querySelector('.js-hours-ret');
    if(!typeSel || !label || !hAbs || !hRet) return;

    if(typeSel.value === 'retard'){
      label.textContent = "Nombre d’heures de retard";
      hAbs.classList.add('hidden'); hAbs.value = '';
      hRet.classList.remove('hidden');
    } else {
      label.textContent = "Nombre d’heures d’absence";
      hRet.classList.add('hidden'); hRet.value = '';
      hAbs.classList.remove('hidden');
    }
  }

  document.addEventListener('change', function(e){
    const el = e.target;
    if(!el) return;

    // type change
    if(el.classList.contains('js-absence-type')){
      const details = el.closest('[data-absence-details]');
      if(details) syncType(details);
    }

    // exclusivité
    if(el.classList.contains('js-justifie')){
      const details = el.closest('[data-absence-details]');
      const nj = details?.querySelector('.js-nonjustifie');
      if(el.checked && nj) nj.checked = false;
    }
    if(el.classList.contains('js-nonjustifie')){
      const details = el.closest('[data-absence-details]');
      const j = details?.querySelector('.js-justifie');
      if(el.checked && j) j.checked = false;
    }
  });
})();
</script> -->

<script>
  window.openEditAbsenceModal = function(btn) {
    const modal = document.getElementById('editAbsenceModal');
    const form  = document.getElementById('editAbsenceForm');

    const updateUrl = btn.dataset.updateUrl;
    if (!modal || !form || !updateUrl) {
      console.error('modal/form/updateUrl manquant', { modal, form, updateUrl });
      return;
    }

    form.action = updateUrl;

    document.getElementById('edit_absence_id').value = btn.dataset.id || '';
    document.getElementById('edit_semestre').value   = btn.dataset.semestre || '';
    document.getElementById('edit_type').value       = btn.dataset.type || 'absence';

    document.getElementById('edit_nombre_heure_absence').value = btn.dataset.habs || '';
    document.getElementById('edit_nombre_heure_retard').value  = btn.dataset.hret || '';

    const cbJust = document.getElementById('edit_justifie');
    const cbNon  = document.getElementById('edit_nonjustifie');

    cbJust.checked = (btn.dataset.justifie === '1');
    cbNon.checked  = (btn.dataset.nonjustifie === '1');

    // exclusivité
    cbJust.onchange = () => { if (cbJust.checked) cbNon.checked = false; };
    cbNon.onchange  = () => { if (cbNon.checked) cbJust.checked = false; };

    modal.classList.remove('hidden');
  }

  window.closeEditAbsenceModal = function() {
    document.getElementById('editAbsenceModal')?.classList.add('hidden');
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeEditAbsenceModal();
  });
</script>

