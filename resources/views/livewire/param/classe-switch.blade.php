<div>
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
    </div>'
@endif

 
  @if (session('error'))
    <div class="mb-4">
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-sm dark:bg-gray-800 dark:text-red-300 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 inline w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2A1 1 0 1 1 7.707 9.293L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg>
            <span class="sr-only">Error</span>
            <div>
                <span class="font-medium">Erreur !</span> {{ session('error') }}
            </div>
        </div>
    </div> 
@endif

    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-black text-xl py-4">
                {{ $currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée' }}
            </h2>
        </div>

        <div class="mb-4 flex gap-4">
            <!-- Classe -->
            <div>
                <label for="classe" class="block text-sm font-medium">Classe :</label>
                <select wire:model="classe" wire:change="$refresh" id="classe" class="rounded border-gray-300 text-sm">
                    <option value="">-- Choisir une classe ftp --</option>
                    @foreach ($classes as $cl)
                        <option value="{{ $cl->id }}">{{ $cl->libelle }}</option>
                    @endforeach
                </select>
            </div>

            
            <div>
                <label for="annee_academique_id" class="block text-sm font-medium">Année académique :</label>
                <select wire:model="annee_academique_id" wire:change="$refresh" id="annee_academique_id"
                    class="rounded border-gray-300 text-sm">
                    <option value="">-- Toutes les années --</option>
                    @foreach (\App\Models\AnneeAcademique::all() as $annee)
                        <option value="{{ $annee->id }}">{{ $annee->code }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @if($currentClasse)
        <!-- Informations classe -->
        <div class="py-2 px-4 m-2 shadow bg-vert2 border border-black rounded-md">
            <div class="grid sm:grid-cols-3 gap-2 py-2 text-md">
                <div><span class="text-gray-800">Année Scolaire :</span> <span
                        class="font-bold">{{ $anneeAcademiqueLabel ?? 'N/A' }}</span></div>
                <div><span class="text-gray-800">Centre de ressources :</span>
                    <span class="font-bold">{{ $currentClasse->etablissement->nom }}</span>
                </div>
                <div><span class="text-gray-800">Filière :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->metier->filiere->nom }}</span>
                </div>
                <div><span class="text-gray-800">Métier :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->metier->nom }}</span>
                </div>
                <div><span class="text-gray-800">Niveau d'études :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->nom }}</span>
                </div>
                <div><span class="text-gray-800">Nombre apprenants :</span>
                    <span class="font-bold">{{ $nombreApprenants }}</span>
                </div>
            </div>
        </div>


                @php
    $user = auth()->user();
@endphp
         @if ($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude') || $user->hasRole('surveillant')|| $user->hasRole('superadmin'))
<div class="flex flex-col sm:flex-row sm:items-center gap-3 px-4 pb-4">

  <!-- Ligne des actions -->
  <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full">

    <!-- Form PDF -->
    <form method="GET"
          action="{{ route('classe.bulletins.pdf', $currentClasse->id) }}"
          target="_blank"
          class="flex flex-col sm:flex-row sm:items-center gap-2">
      
      <select name="semestre" class="rounded border-gray-300 text-sm">
        <option value="">Tous les semestres</option>
        <option value="1">Premier semestre</option>
        <option value="2">Deuxième semestre</option>
      </select>

      <button type="submit"
              class="text-white bg-red-800 text-sm rounded-md shadow-md px-4 py-2 hover:bg-red-700">
        <i class="fa fa-file-pdf"></i>&nbsp;Télécharger les bulletins de la classe (PDF)
      </button>
    </form>

<button type="button"
        wire:click="goEvaluationSomative"
        class="text-white bg-green-700 text-sm rounded-md shadow-md px-4 py-2 hover:bg-green-800">
  <i class="fa-solid fa-file-lines"></i>&nbsp;Évaluation Finale
</button>


  </div>
</div>

@endif
        
        <div class="w-full sm:px-2 lg:px-4">
            <div class="flex flex-col sm:flex-row py-2 gap-4">

 
                <div class="sm:w-1/2 p-4 border bg-gray border shadow rounded" style="min-height:50vh">
        
    @include('livewire.param._apc_classe_modal')
     
 @php
    $user = auth()->user();
@endphp
<label for="selectedsemestre1" class="text-sm font-bold text-gray-700 mr-2">Semestre :</label>
                            <select wire:model.live="selectedsemestre1" id="selectedsemestre1" name="semestre"
                                class="border border-gray-300 rounded shadow-sm text-sm">
                                <option value="">Tous les semestres</option>
                                <option value="1">Premier semestre</option>
                                <option value="2">Deuxième semestre</option>
                            </select> 
@if ($user->hasRole('formateur'))
<div class="flex justify-end mb-3">
  
    <button type="button"
        wire:click="openApcClasseModal"
        class="text-white bg-blue-600 text-sm rounded-md shadow-md px-4 py-2 hover:bg-blue-700">
        <i class="fa fa-edit"></i>&nbsp;Évaluer
    </button>
</div>
@endif

                    <h2 class="font-bold text-xl mb-4">Liste des apprenants ({{ sizeof($apprenants) }})</h2>
                    <hr class="mb-2">
                    <div class="text-sm w-full overflow-x-auto">
                      
                        <table class="w-full border-t mb-3">
                            <thead>
                                <tr class="text-xs font-black tracking-wide text-left text-maquette-gris border-b">
                                    <th class="p-2 text-gray-800">Matricule</th>
                                    <th class="p-2 text-gray-800">Nom Prénoms</th>
                                    <th class="p-2 text-gray-800 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                @forelse ($apprenants as $inscription)
                                    <tr
                                        class="text-gray-700 {{ $selectedApprenant == $inscription->id ? 'bg-green-600 text-white' : '' }}">
                                        <td wire:click="loadCompetences({{ $inscription->id }})"
                                            class="px-2 font-bold cursor-pointer">
                                            <i class="fa fa-caret-right"></i>
                                            {{ $inscription->apprenant->matricule ?? '-' }}
                                        </td>
                                        <td class="px-2">
                                            {{ $inscription->apprenant->nom . ' ' . ($inscription->apprenant->prenom ?? '-') }}
                                        </td>
                                        <td class="px-2 text-center">
                                            <a href="#" wire:click="loadCompetences({{ $inscription->id }})"
                                                class="text-green-700 hover:text-blue-900">
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
                        <div class="mt-4">
                    
                      </div>
                    </div>
     
                </div>
       

                @if ($selectedApprenant)
                
                    <div class="sm:w-1/2 p-4 border bg-gray-100 rounded border shadow">
                        <h2 class="font-bold text-xl mb-4">
                            Liste des compétences de
                            {{ $currentApprenant->apprenant->matricule }}
                            {{ $currentApprenant->apprenant->nom }}
                            {{ $currentApprenant->apprenant->prenom }}
                        </h2>
                        <hr class="mb-2">
                        <div class="flex justify-between items-center mb-3">
                            <select wire:model="filtre" wire:change="$refresh"
                                class="border border-gray-300 p-2 w-1/2 rounded text-sm">
                                <option value="">Filtrer par compétence</option>
                                @foreach ($filtres as $comp)
                                    <option value="{{ $comp->id }}">{{ $comp->nom }}</option>
                                @endforeach
                            </select>
                            
                     @php
    $user = auth()->user();
@endphp




@if ($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude')|| $user->hasRole('surveillant')|| $user->hasRole('superadmin'))

  
 <a href="#"
   wire:click.prevent="openNotesModal"
   class="text-white bg-blue-600 text-sm rounded-md shadow-md px-4 py-2 hover:bg-green-700">
    <i class="fa fa-eye"></i>&nbsp;Voir les notes
</a>

@endif

                        </div>

                        
                        <div class="flex items-center justify-end mb-3">
                                                
                @php
    $user = auth()->user();
@endphp
         @if ($user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude')|| $user->hasRole('autorite'))
                              <a class="text-white bg-red-800 text-sm rounded-md shadow-md px-4 py-1" target="_blank" href="{{route('competence.generate.pdf',$currentApprenant->id)}}">
                            <i class="fa fa-file-pdf"></i>&nbsp;Télecharger le Bulletin
                        </a>
@endif
                        </div>
                         @if(
    $user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude')||$user->hasRole('surveillant'))
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
    class="text-white bg-blue-700 text-sm rounded-md shadow-md px-4 py-2 hover:bg-blue-800">
    <i class="fa fa-eye"></i>&nbsp;Voir les absences et retards
</button>

<div id="absencesListModal"
    class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex justify-center items-center p-4 transition duration-300 ease-in-out">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl relative">
        
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
 <button class='bg-blue-800 hover:bg-blue-900 text-white px-3 py-1 rounded text-xs shadow'
data-update-url="{{ route('absences.update',$abs->id) }}"
onclick="openEditAbsenceModal(
{{ $abs->id }},
'{{ $abs->semestre }}',
'{{ $abs->type }}',
'{{ $abs->nombre_heure_absence }}',
'{{ $abs->nombre_heure_retard }}',
'{{ $abs->justifie }}',
this.dataset.updateUrl
)">
Modifier
</button>
    <button
    wire:click="deleteAbsence({{ $abs->id }})"
    onclick="confirm('Voulez-vous vraiment supprimer cette absence ?') || event.stopImmediatePropagation()"
    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs shadow">
    <i class="fa fa-trash"></i> Supprimer
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

<div id="editAbsenceModal" class="hidden fixed inset-0 z-50 bg-black/70 backdrop-blur-sm flex justify-center items-center p-4 transition duration-300 ease-in-out">
    <div class="bg-white rounded-lg shadow-lg w-96 p-5">
        <h3 class="text-lg font-bold mb-4 text-gray-700">Modifier l'absence</h3>

        <form id="editAbsenceForm" method="POST"  action="#">
        @csrf
         @method('PUT')

  
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
      <input type="checkbox" name="nonjustifie" value="nonjustifie" id="edit_nonjustifie_radio">
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


                       
     @if ($competences && $competences->count() > 0)
  <div class="overflow-x-auto">
    <table class="min-w-full border text-sm">
      <thead class="bg-green-600 text-white uppercase">
        <tr>
          <th class="px-4 py-2 border text-center">COMPÉTENCE</th>
          <th class="px-4 py-2 border text-center">Discipline</th>
          <th class="px-4 py-2 border text-center">MCC</th>
          <th class="px-4 py-2 border text-center">Intégration</th>
        </tr>
      </thead>

      <tbody class="bg-white divide-y">
        @foreach ($competences as $comp)
          @php
            if ($filtre && $comp->id != $filtre) continue;

            $ressources = $comp->ressources ?? collect();
            $rowspan = max($ressources->count(), 1);
            $firstRow = true;
          @endphp

          @forelse($ressources as $res)
            @php
              $eval = $evaluations[$res->id] ?? null;
              $mcc = $eval['mcc'] ?? 0;
              $composition = $eval['composition'] ?? null;
            @endphp

            <tr>
              @if ($firstRow)
                <td rowspan="{{ $rowspan }}" class="px-4 py-2 border font-semibold bg-gray-50 align-top">
                  {{ $comp->nom }}
                </td>
                @php $firstRow = false; @endphp
              @endif

              <td class="px-4 py-2 border">{{ $res->nom }}</td>

              <td class="px-4 py-2 border text-center font-bold text-green-700">
                {{ number_format((float)$mcc, 2) }}
              </td>

              <td class="px-4 py-2 border text-center">
                {{ $composition !== null ? number_format((float)$composition, 2) : '-' }}
              </td>
            </tr>
          @empty
            <tr>
              <td class="px-4 py-2 border font-semibold bg-gray-50">{{ $comp->nom }}</td>
              <td class="px-4 py-2 border text-center text-gray-500" colspan="3">
                Aucune discipline liée
              </td>
            </tr>
          @endforelse
        @endforeach
      </tbody>
    </table>
  </div>


  
   @include('livewire.param.shownote')

@else
    <div class="text-center py-4 text-gray-500">
        Aucune compétence assignée ou évaluation disponible.
    </div>
@endif

                    </div>
                @else
                    <div class="sm:w-1/2 p-4 border bg-gray-100 rounded border shadow text-center">
                        <span class="text-red-600 text-lg">Aucun apprenant sélectionné !</span>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert bg-orange-100 flex p-4 rounded mt-4 p-10 m-10 justify-center items-center">
            <h3 class="text-2xl text-gray-700">
                Veuillez sélectionner une classe et une année académique !
            </h3>
        </div>
    @endif

  

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
</script>

<script>
  function openEditAbsenceModal(id, semestre, type, hAbs, hRet, justifie, updateUrl) {
    const modal = document.getElementById('editAbsenceModal');
    const form  = document.getElementById('editAbsenceForm');

    // ✅ URL correcte /absences/{id}
    form.action = updateUrl;

    // ✅ Remplissage champs
    document.getElementById('edit_absence_id').value = id;
    document.getElementById('edit_semestre').value = (semestre ?? '').toString();
    document.getElementById('edit_type').value = (type ?? 'absence').toString();

    document.getElementById('edit_nombre_heure_absence').value = (hAbs ?? '');
    document.getElementById('edit_nombre_heure_retard').value = (hRet ?? '');

    document.getElementById('edit_justifie').checked = (parseInt(justifie) === 1);

    // ✅ Afficher modal
    modal.classList.remove('hidden');
  }

  function closeEditAbsenceModal() {
    document.getElementById('editAbsenceModal').classList.add('hidden');
  }
</script>
