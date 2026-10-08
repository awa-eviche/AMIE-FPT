<div>
    {{-- ✅ Message success --}}
    @if (session('success'))
        <div class="mb-4 px-4">
            <div class="flex items-center p-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-sm" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2A1 1 0 1 1 7.707 9.293L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <div>
                    <span class="font-medium">Succès !</span> {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 px-4">
            <div class="flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-sm" role="alert">
                <div>
                    <span class="font-medium">Erreur !</span> {{ session('error') }}
                </div>
            </div>
        </div>
    @endif

    {{-- ✅ Header + filtres (même architecture que la page des notes APC) --}}
    <div class="flex items-center px-4">
        <div class="flex-1">
            <h2 class="font-bold text-maquette-black text-xl py-4">
                Évaluation Sommative — {{ $currentClasse ? $currentClasse->libelle : 'Aucune classe sélectionnée' }}
            </h2>
        </div>

        <div class="mb-4 flex gap-4">
            <!-- Classe -->
            <div>
                <label for="classe" class="block text-sm font-medium">Classe :</label>
                <select wire:model="classe" wire:change="$refresh" id="classe" class="rounded border-gray-300 text-sm">
                    <option value="">-- Choisir une classe --</option>
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

    @if ($currentClasse)
        <!-- Informations classe -->
        <div class="py-2 px-4 m-2 shadow bg-vert2 border border-black rounded-md">
            <div class="grid sm:grid-cols-3 gap-2 py-2 text-md">
                <div><span class="text-gray-800">Année Scolaire :</span> <span
                        class="font-bold">{{ $anneeAcademiqueLabel ?? 'N/A' }}</span></div>
                <div><span class="text-gray-800">Centre de ressources :</span>
                    <span class="font-bold">{{ $currentClasse->etablissement->nom ?? '-' }}</span>
                </div>
                <div><span class="text-gray-800">Filière :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->metier->filiere->nom ?? '-' }}</span>
                </div>
                <div><span class="text-gray-800">Métier :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->metier->nom ?? '-' }}</span>
                </div>
                <div><span class="text-gray-800">Niveau d'études :</span>
                    <span class="font-bold">{{ $currentClasse->niveau_etude->nom ?? '-' }}</span>
                </div>
                <div><span class="text-gray-800">Nombre apprenants :</span>
                    <span class="font-bold">{{ $nombreApprenants }}</span>
                </div>
            </div>
        </div>

        @php $user = auth()->user(); @endphp

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-4 pb-4">

            <!-- Ligne des actions -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full">

                <!-- Form PDF -->
                <form method="GET" action="{{ route('classe.sommation.pdf', $currentClasse->id) }}" target="_blank"
                      class="flex flex-col sm:flex-row sm:items-center gap-2">
                    {{-- Semestre de la page : utilisé pour le PDF et pour l'évaluation --}}
                    <select name="semestre" wire:model.live="somativeSemestre" class="rounded border-gray-300 text-sm">
                        <option value="">Tous les semestres</option>
                        <option value="1">Premier semestre</option>
                        <option value="2">Deuxième semestre</option>
                    </select>

                    <button type="submit" class="text-white bg-red-800 text-sm rounded-md shadow-md px-4 py-2 hover:bg-red-700">
                        <i class="fa fa-file-pdf"></i>&nbsp;Télécharger les bulletins de la classe (PDF)
                    </button>
                </form>

                @if($user->hasRole('formateur') || $user->hasRole('chef_de_travaux') || $user->hasRole('chef_etablissement') || $user->hasRole('directeur_etude') || $user->hasRole('surveillant') || $user->hasRole('superadmin'))
                    <button type="button"
                            wire:click="openSomativeClasseModal"
                            class="text-white bg-green-700 text-sm rounded-md shadow-md px-4 py-2 hover:bg-green-800">
                        <i class="fa-solid fa-file-lines"></i>&nbsp;Évaluer
                    </button>
                @endif

                <a href="{{ route('competence.manage.index') }}" class="text-white bg-blue-700 text-sm rounded-md shadow-md px-4 py-2 hover:bg-blue-800 inline-flex items-center">
                    <i class="fa fa-arrow-left"></i>&nbsp;Retour
                </a>

            </div>
        </div>

        @if($showSomativeClasseModal)
            <div class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4" style="position:fixed; top:0; right:0; bottom:0; left:0; z-index:50; background-color:rgba(0,0,0,.7); display:flex; align-items:center; justify-content:center; padding:1rem;"
                 wire:click.self="closeSomativeClasseModal"
                 wire:keydown.escape.window="closeSomativeClasseModal">

                <div class="bg-white rounded-lg shadow-xl w-[1200px] max-w-[95vw]"
                     style="width:1200px; max-width:95vw; height:90vh; display:flex; flex-direction:column; overflow:hidden;">

                    <div class="p-4 border-b flex items-center justify-between bg-white" style="flex:0 0 auto;">
                        <div>
                            <div class="font-semibold text-lg text-green-600">Évaluation Sommative</div>
                            <div class="text-xs text-gray-600">
                                Classe : <span class="font-semibold">{{ $currentClasse?->libelle ?? '-' }}</span>
                                • Année : <span class="font-semibold">{{ $anneeAcademiqueLabel ?? '-' }}</span>
                            </div>
                            {{-- Semestre évalué, mis en évidence --}}
                            <div style="margin-top:8px;">
                                <span style="display:inline-block; background:#047857; color:#fff; font-size:14px; font-weight:700; padding:5px 14px; border-radius:999px;">
                                    {{ $somativeSemestre == 2 ? 'Deuxième semestre' : 'Premier semestre' }}
                                </span>
                            </div>
                        </div>

                        <button type="button" wire:click="closeSomativeClasseModal"
                                class="text-red-600 font-bold text-lg leading-none">✕</button>
                    </div>

                    <form wire:submit.prevent="saveSomativeClasse"
                          style="flex:1 1 auto; min-height:0; display:flex; flex-direction:column;">

                      
                        @if (session('success'))
                            <div class="px-4 py-2 text-sm text-green-800 bg-green-50 border-b border-green-300" style="flex:0 0 auto;">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="px-4 py-2 text-sm text-red-800 bg-red-50 border-b border-red-300" style="flex:0 0 auto;">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- BODY SCROLL --}}
                        <div class="p-4" style="flex:1 1 auto; min-height:0; overflow-y:auto; -webkit-overflow-scrolling:touch;">

                            @if(empty($apprenantsSomativeModal))
                                <div class="text-sm text-gray-500">Aucun apprenant chargé.</div>
                            @else

                                @foreach($apprenantsSomativeModal as $insc)
                                    <details wire:key="somative-insc-{{ $insc->id }}" class="mb-4 border rounded-lg bg-white">
                                        <summary class="cursor-pointer px-4 py-3 font-semibold bg-gray-50">
                                            {{ $insc->apprenant?->prenom }} {{ $insc->apprenant?->nom }}
                                            <span class="text-xs text-gray-500">[{{ $insc->apprenant?->matricule ?? '-' }}]</span>
                                        </summary>

                                        <div class="p-4 space-y-6">

                                            {{-- ✅ GÉNÉRALES (ressource + note/date/obs) --}}
                                            {{-- ✅ COMPÉTENCES GÉNÉRALES : Compétence fusionnée + Ressource + Note --}}
@if(!empty($competencesGenerales) && $competencesGenerales->count() > 0)
  <div>
    <h3 class="font-bold text-lg mb-2 text-gray-800">Compétences Générales</h3>

    <div class="text-sm w-full overflow-x-auto my-2">
      <table class="w-full border">
        <thead>
          <tr class="text-xs font-black tracking-wide text-left text-white uppercase border-b bg-first-orange">
            <th class="px-4 py-3 border border-black">Compétence</th>
            <th class="px-4 py-3 border border-black">Ressource</th>
            <th class="px-4 py-3 border border-black text-center">Note /20</th>
           
          </tr>
        </thead>

        <tbody class="bg-white divide-y">
          @foreach($competencesGenerales as $competence)

            @php
              $ressources = $competence->ressources ?? collect();
              if(!($ressources instanceof \Illuminate\Support\Collection)){
                $ressources = collect($ressources);
              }

              // ✅ rowspan = nb de ressources (min 1)
              $rowspanC = max($ressources->count(), 1);

              // ✅ flag pour n'afficher la compétence qu'une fois
              $printedC = false;
            @endphp

            {{-- ✅ Si aucune ressource --}}
            @if($ressources->count() === 0)
              <tr>
                <td class="px-4 py-2 border border-black font-bold">
                  {{ $competence->nom ?? '-' }}
                </td>
                <td colspan="4" class="px-4 py-2 border border-black text-center text-gray-500">
                  Aucune ressource liée
                </td>
              </tr>
            @else

              @foreach($ressources as $res)
                <tr>
                  {{-- ✅ cellule compétence fusionnée --}}
                  @if(!$printedC)
                    <td rowspan="{{ $rowspanC}}"
                        class="px-4 py-2 border border-black font-bold align-middle">
                      {{ $competence->nom ?? '-' }}
                    </td>
                    @php $printedC = true; @endphp
                  @endif

                  <td class="px-4 py-2 border border-black">
                    {{ $res->nom ?? '-' }}
                  </td>

                  <td class="px-4 py-2 border border-black text-center">
                    <input type="number" min="0" max="20" step="0.5"
                           class="border border-gray-300 p-1 w-28 text-center rounded"
                           wire:model.defer="somativeNoteRessource.{{ $insc->id }}.{{ $res->id }}">
                  </td>

                
                </tr>
              @endforeach

            @endif
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endif


                                            {{-- ✅ PARTICULIÈRES (AUCUNE variable undefined) --}}
                                            @if(($competencesParticulieres ?? collect())->count() > 0)
                                                <div>
                                                    <h3 class="font-bold text-lg mb-2 text-gray-800">Compétences Particulières</h3>

                                                    @php
                                                        // ✅ Closure safe (toujours >= 1)
                                                        $rowspanForCompetence = function($competence){
                                                            $els = $competence->elementCompetences ?? collect();
                                                            if(!($els instanceof \Illuminate\Support\Collection)) $els = collect($els);
                                                            $sum = 0;
                                                            foreach($els as $el){
                                                                $cr = $el->criteres ?? collect();
                                                                if(!($cr instanceof \Illuminate\Support\Collection)) $cr = collect($cr);
                                                                $sum += $cr->count();
                                                            }
                                                            return max($sum, 1);
                                                        };
                                                    @endphp

                                                    <div class="text-sm w-full overflow-x-auto my-2">
                                                        <table class="w-full border-t mb-3">
                                                            <thead>
                                                                <tr class="text-xs font-black tracking-wide text-left text-white font-bold uppercase border-b bg-first-orange">
                                                                    <th class="px-4 py-3 text-white border border-black">Compétence</th>
                                                                    <th class="px-4 py-3 text-white border border-black">Element de compétence</th>
                                                                    <th class="px-4 py-3 text-white border border-black">Critère (seuil de réussite)</th>
                                                                    <th class="px-4 py-3 text-white border border-black">Note /20</th>
                                                                    <th class="px-4 py-3 text-white border border-black">Acquis</th>
                                                                    <th class="px-4 py-3 text-white border border-black">Non acquis</th>
                                                                    <th class="px-4 py-3 text-white border border-black">Appréciation</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="bg-white divide-y">
                                                                @foreach(($competencesParticulieres ?? collect()) as $competence)

                                                                    @php
                                                                        $elements = $competence->elementCompetences ?? collect();
                                                                        if(!($elements instanceof \Illuminate\Support\Collection)) $elements = collect($elements);

                                                                        $rowspanCompetence = $rowspanForCompetence($competence);
                                                                        $printedCompetence = false;
                                                                    @endphp

                                                                    @if($elements->count() === 0)
                                                                        <tr>
                                                                            <td class="px-4 py-2 border border-black text-center font-bold">{{ $competence->nom ?? '-' }}</td>
                                                                            <td colspan="7" class="px-4 py-2 border border-black text-center text-gray-500">
                                                                                Aucun élément de compétence
                                                                            </td>
                                                                        </tr>
                                                                    @else

                                                                        @foreach($elements as $elementCompetence)
                                                                            @php
                                                                                $criteres = $elementCompetence->criteres ?? collect();
                                                                                if(!($criteres instanceof \Illuminate\Support\Collection)) $criteres = collect($criteres);

                                                                                $rowspanElement = max($criteres->count(), 1);
                                                                                $printedElement = false;
                                                                            @endphp

                                                                            @if($criteres->count() === 0)
                                                                                <tr>
                                                                                    @if(!$printedCompetence)
                                                                                        <td rowspan="{{ $rowspanCompetence }}" class="px-4 py-2 border border-black text-center font-bold">
                                                                                            {{ $competence->nom ?? '-' }}
                                                                                        </td>
                                                                                        @php $printedCompetence = true; @endphp
                                                                                    @endif

                                                                                    <td class="px-4 py-2 border border-black text-center font-bold">
                                                                                        {{ $elementCompetence->nom ?? '-' }}
                                                                                    </td>

                                                                                    <td colspan="6" class="px-4 py-2 border border-black text-center text-gray-500">
                                                                                        Aucun critère lié
                                                                                    </td>
                                                                                </tr>
                                                                            @else

                                                                                @foreach($criteres as $critere)
                                                                                    @php
                                                                                        $seuil = $critere->seuilPourcentage();
                                                                                        $noteExistante = $somativeNoteCritere[$insc->id][$critere->id] ?? null;
                                                                                    @endphp
                                                                                    <tr
                                                                                        x-data="{
                                                                                            note: {{ $noteExistante !== null ? $noteExistante : 'null' }},
                                                                                            seuil: {{ $seuil !== null ? $seuil : 'null' }}
                                                                                        }"
                                                                                    >
                                                                                        @if(!$printedCompetence)
                                                                                            <td rowspan="{{ $rowspanCompetence }}" class="px-4 py-2 border border-black text-center font-bold">
                                                                                                {{ $competence->nom ?? '-' }}
                                                                                            </td>
                                                                                            @php $printedCompetence = true; @endphp
                                                                                        @endif

                                                                                        @if(!$printedElement)
                                                                                            <td rowspan="{{ $rowspanElement }}" class="px-4 py-2 border border-black text-center font-bold">
                                                                                                {{ $elementCompetence->nom ?? '-' }}
                                                                                            </td>
                                                                                            @php $printedElement = true; @endphp
                                                                                        @endif

                                                                                        <td class="px-4 py-2 border border-black">
                                                                                            {{ $critere->libelle ?? '-' }}
                                                                                            @if($seuil === null)
                                                                                                <div class="text-xs text-red-600 font-semibold">Seuil invalide (à corriger dans "Seuil de réussite")</div>
                                                                                            @endif
                                                                                        </td>

                                                                                        {{-- Note sur 20 saisie par le formateur --}}
                                                                                        <td class="px-4 py-2 border border-black text-center">
                                                                                            <input type="number" min="0" max="20" step="0.5"
                                                                                                   class="w-20 border rounded px-2 py-1 text-center"
                                                                                                   wire:model.defer="somativeNoteCritere.{{ $insc->id }}.{{ $critere->id }}"
                                                                                                   @input="note = $event.target.value === '' ? null : Number($event.target.value)">
                                                                                            <span class="text-gray-500">/20</span>
                                                                                        </td>

                                                                                        {{-- Acquis / Non acquis : cochés automatiquement (lecture seule),
                                                                                             calculés en comparant la note /20, ramenée en % (x5), au seuil de réussite. La
                                                                                             valeur réellement enregistrée est calculée côté serveur à
                                                                                             partir de la note, ces cases ne sont qu'un aperçu visuel. --}}
                                                                                        <td class="px-4 py-2 border border-black text-center">
                                                                                            <input type="checkbox" disabled
                                                                                                   :checked="seuil !== null && note !== null && note !== '' && Number(note) * 5 >= seuil">
                                                                                        </td>
                                                                                        <td class="px-4 py-2 border border-black text-center">
                                                                                            <input type="checkbox" disabled
                                                                                                   :checked="seuil !== null && note !== null && note !== '' && Number(note) * 5 < seuil">
                                                                                        </td>

                                                                                        {{-- Appréciation calculée en direct à partir de la note /20,
                                                                                             même échelle que le bulletin PDF et que les disciplines. --}}
                                                                                        <td class="px-4 py-2 border border-black text-center text-xs"
                                                                                            x-text="note === null || note === '' ? '-' :
                                                                                                (Number(note) >= 16 ? 'Excellent travail' :
                                                                                                 Number(note) >= 14 ? 'Bien' :
                                                                                                 Number(note) >= 12 ? 'Assez bien' :
                                                                                                 Number(note) >= 10 ? 'Passable' :
                                                                                                 Number(note) >= 8 ? 'Travail insuffisant' :
                                                                                                 'Très insuffisant')">
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach

                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </details>
                                @endforeach

                            @endif
                        </div>

                        {{-- FOOTER --}}
                        <div class="p-4 border-t bg-white flex justify-end gap-2" style="flex:0 0 auto;">
                            @if(auth()->user()->hasRole('chef_etablissement') || auth()->user()->hasRole('directeur_etude')  || auth()->user()->hasRole('chef_de_travaux'))
                                <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow inline-flex items-center gap-2">
                                    <i class="fa fa-save"></i>&nbsp; Enregistrer les changements
                                </button>
                            @endif

                            <button type="button" wire:click="closeSomativeClasseModal"
                                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Fermer
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        @endif

    @else
        <div class="alert bg-orange-100 flex p-4 rounded mt-4 p-10 m-10 justify-center items-center">
            <h3 class="text-2xl text-gray-700">
                Veuillez sélectionner une classe et une année académique !
            </h3>
        </div>
    @endif
</div>
