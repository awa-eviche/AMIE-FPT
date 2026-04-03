@if($showNotesModal)
  <div class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50" wire:click="closeNotesModal"></div>

    {{-- Card --}}
    <div class="relative w-full max-w-7xl bg-white rounded-lg shadow-xl"
         style="max-height:92vh;"
         wire:click.stop
         wire:keydown.escape.window="closeNotesModal">

      {{-- Header (fixe) --}}
      <div class="flex items-center justify-between px-4 py-3 border-b bg-gray-50">
        <div class="min-w-0">
          <div class="font-bold text-gray-900 truncate">
            Résumé des notes (MCC / Intégration)
          </div>
          <div class="text-xs text-gray-600">
            Semestre : <span class="font-semibold">{{ $apcSemestre }}</span>
          </div>
        </div>

        <button type="button"
                wire:click="closeNotesModal"
                class="text-gray-600 hover:text-gray-900 px-2 py-1 rounded">
          ✕
        </button>
      </div>

      @php
        // =========================
        // ✅ Helpers
        // =========================
        $obsFromNote = function ($note) {
          if (!is_numeric($note)) return '-';
          $note = (float)$note;
          if ($note < 10) return 'Insuffisant';
          if ($note < 12) return 'Passable';
          if ($note < 14) return 'Assez bien';
          if ($note < 16) return 'Bien';
          return 'Très bien';
        };

        // ✅ Liste complète des inscriptions (avec apprenant)
        $apprenantsAll = collect($apprenantsApcModal ?? []);

        // ✅ Filtre : notesApprenantId = apprenant_id (pas inscription_id)
        $selectedApprenantId = ($notesApprenantId !== '' && $notesApprenantId !== null) ? (int)$notesApprenantId : null;

        // ✅ Liste affichée selon apprenant_id
        $apprenantsList = $apprenantsAll;
        if ($selectedApprenantId) {
          $apprenantsList = $apprenantsAll->filter(function($insc) use ($selectedApprenantId) {
            $aid = (int)($insc->apprenant->id ?? $insc->apprenant_id ?? 0);
            return $aid === $selectedApprenantId;
          })->values();
        }

        /**
         * ✅ Build groups par INSCRIPTION (iid = inscription_id)
         * - discipline = ressource_id
         * - garde uniquement les ressources où cette inscription a une note (MCC ou comp/int)
         * - regroupe par label "CompA / CompB"
         */
        $buildGroupsForInscription = function($competences, $iid, $mccsApc, $compositionsApc) {
          $discMap = [];

          foreach (($competences ?? collect()) as $comp) {
            $compNom = trim((string)($comp->nom ?? ''));

            foreach (($comp->ressources ?? collect()) as $res) {
              $rid = (int)($res->id ?? 0);
              if (!$rid) continue;

              // ✅ uniquement si note existe pour cette inscription
              $iidKey = (string)$iid;
              $ridKey = (string)$rid;

              $mcc = $mccsApc[$iidKey][$ridKey] ?? null;
              $compOrInt = $compositionsApc[$iidKey][$ridKey] ?? null;

              if (!is_numeric($mcc) && !is_numeric($compOrInt)) {
                continue;
              }

              if (!isset($discMap[$rid])) {
                $discMap[$rid] = [
                  'rid' => $rid,
                  'discipline' => (string)($res->nom ?? ''),
                  'competence_noms' => [],
                ];
              }

              if ($compNom !== '' && !in_array($compNom, $discMap[$rid]['competence_noms'], true)) {
                $discMap[$rid]['competence_noms'][] = $compNom;
              }
            }
          }

          // group by label
          $groups = [];
          foreach ($discMap as $row) {
            $noms = array_values(array_unique($row['competence_noms'] ?? []));
            sort($noms, SORT_NATURAL | SORT_FLAG_CASE);

            $label = trim(implode(' / ', $noms));
            if ($label === '') $label = '—';

            $groups[$label] ??= [];
            $groups[$label][] = ['rid' => $row['rid'], 'discipline' => $row['discipline']];
          }

          foreach ($groups as $label => $items) {
            usort($items, fn($a, $b) => strcmp($a['discipline'], $b['discipline']));
            $groups[$label] = $items;
          }

          ksort($groups, SORT_NATURAL | SORT_FLAG_CASE);

          $out = [];
          foreach ($groups as $label => $items) {
            $out[] = ['competence_label' => $label, 'items' => $items];
          }
          return $out;
        };
      @endphp

      <style>
        .notes-wrap { white-space: normal; word-break: break-word; overflow-wrap: anywhere; }
        .notes-num  { white-space: nowrap; text-align: center; }
        .notes-sticky thead th { position: sticky; top: 0; background: #f3f4f6; z-index: 2; }
        .filter-sticky { position: sticky; top: 0; z-index: 5; background: #fff; }
      </style>

      {{-- ✅ BODY SCROLL --}}
      <div class="overflow-auto" style="max-height:78vh;">

        {{-- ✅ Filtre sticky : apprenant seulement --}}
        <div class="px-4 pt-4 pb-3 border-b filter-sticky">
          <div class="flex flex-col sm:flex-row gap-3 sm:items-end">

            <div class="w-full sm:w-[560px]">
              <label class="text-xs text-gray-600">Filtrer par apprenant</label>
              <select wire:model.live="notesApprenantId" class="w-full border rounded px-2 py-2 text-sm">
                <option value="">Tous les apprenants</option>
                @foreach($apprenantsAll as $insc)
                  @php
                    $aid = (int)($insc->apprenant->id ?? $insc->apprenant_id ?? 0);
                    $nomAppr = trim(($insc->apprenant->nom ?? '').' '.($insc->apprenant->prenom ?? ''));
                    $mat = $insc->apprenant->matricule ?? '';
                  @endphp
                  <option value="{{ $aid }}">{{ $nomAppr ?: 'Apprenant #'.$aid }}{{ $mat ? ' — '.$mat : '' }}</option>
                @endforeach
              </select>
            </div>

            <div class="text-xs text-gray-600">
              Apprenants affichés : <span class="font-semibold">{{ $apprenantsList->count() }}</span>
            </div>

          </div>
        </div>

        {{-- ✅ CONTENU --}}
        <div class="px-4 py-4 space-y-4">

       
          <div class="border rounded-lg overflow-hidden">
            <div class="px-3 py-2 bg-green-600 text-white font-semibold">
              Compétences générales
            </div>

            <div class="p-3">
              @forelse($apprenantsList as $insc)
                @php
                  $iid = (int)$insc->id; // inscription_id (clé notes)
                  $nomAppr = trim(($insc->apprenant->nom ?? '').' '.($insc->apprenant->prenom ?? ''));

                  $groupsGen = $buildGroupsForInscription($competencesGenerales, $iid, $mccsApc, $compositionsApc);
                @endphp

                <div class="mb-4 border rounded-lg overflow-hidden">
                  <div class="px-3 py-2 bg-gray-50 flex items-center justify-between gap-3">
                    <div class="font-semibold text-sm text-gray-900 truncate">
                      {{ $nomAppr ?: 'Apprenant #'.$iid }}
                    </div>
                    <div class="text-xs text-gray-600">
                      Matricule : <span class="font-semibold">{{ $insc->apprenant->matricule ?? '-' }}</span>
                    </div>
                  </div>

                  <div class="overflow-x-auto border-t">
                    <table class="min-w-[1050px] w-full text-sm border-collapse notes-sticky">
                      <thead>
                        <tr>
                          <th class="border px-2 py-2 text-left">Compétence(s)</th>
                          <th class="border px-2 py-2 text-left">Discipline</th>
                          <th class="border px-2 py-2 notes-num">MCC</th>
                          <th class="border px-2 py-2 notes-num">Composition</th>
                          <th class="border px-2 py-2 text-left">Appréciation</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(empty($groupsGen))
                          <tr><td class="border px-2 py-2" colspan="5" align="center">Aucune discipline (aucune note).</td></tr>
                        @else
                          @foreach($groupsGen as $g)
                            @php $rows = count($g['items']); $first = true; @endphp
                            @foreach($g['items'] as $it)
                              @php
                                $rid = (int)$it['rid'];

                                $mcc = $mccsApc[(string)$iid][(string)$rid] ?? null;
                                $compRaw = $compositionsApc[(string)$iid][(string)$rid] ?? null;

                                $composition = is_numeric($compRaw) ? (float)$compRaw : (is_numeric($mcc) ? (float)$mcc : null);

                                $mccTxt  = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
                                $compTxt = is_numeric($composition) ? number_format((float)$composition, 2) : '-';
                                $appTxt  = is_numeric($composition) ? $obsFromNote($composition) : '-';
                              @endphp

                              <tr>
                                @if($first)
                                  <td rowspan="{{ $rows }}" class="border px-2 py-2 notes-wrap font-semibold align-top">
                                    {{ $g['competence_label'] }}
                                  </td>
                                  @php $first = false; @endphp
                                @endif
                                <td class="border px-2 py-2 notes-wrap">{{ $it['discipline'] }}</td>
                                <td class="border px-2 py-2 notes-num">{{ $mccTxt }}</td>
                                <td class="border px-2 py-2 notes-num">{{ $compTxt }}</td>
                                <td class="border px-2 py-2 notes-wrap">{{ $appTxt }}</td>
                              </tr>
                            @endforeach
                          @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>

              @empty
                <div class="text-sm text-gray-600">Aucun apprenant.</div>
              @endforelse
            </div>
          </div>

          {{-- =========================
             COMPETENCES PARTICULIERES
          ========================== --}}
          <div class="border rounded-lg overflow-hidden">
            <div class="px-3 py-2 bg-indigo-700 text-white font-semibold">
              Compétences particulières
            </div>

            <div class="p-3">
              @forelse($apprenantsList as $insc)
                @php
                  $iid = (int)$insc->id;
                  $nomAppr = trim(($insc->apprenant->nom ?? '').' '.($insc->apprenant->prenom ?? ''));

                  $groupsPart = $buildGroupsForInscription($competencesParticulieres, $iid, $mccsApc, $compositionsApc);
                @endphp

                <div class="mb-4 border rounded-lg overflow-hidden">
                  <div class="px-3 py-2 bg-gray-50 flex items-center justify-between gap-3">
                    <div class="font-semibold text-sm text-gray-900 truncate">
                      {{ $nomAppr ?: 'Apprenant #'.$iid }}
                    </div>
                    <div class="text-xs text-gray-600">
                      Matricule : <span class="font-semibold">{{ $insc->apprenant->matricule ?? '-' }}</span>
                    </div>
                  </div>

                  <div class="overflow-x-auto border-t">
                    <table class="min-w-[1050px] w-full text-sm border-collapse notes-sticky">
                      <thead>
                        <tr>
                          <th class="border px-2 py-2 text-left">Compétence(s)</th>
                          <th class="border px-2 py-2 text-left">Discipline</th>
                          <th class="border px-2 py-2 notes-num">MCC</th>
                          <th class="border px-2 py-2 notes-num">Intégration</th>
                          <th class="border px-2 py-2 text-left">Appréciation</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(empty($groupsPart))
                          <tr><td class="border px-2 py-2" colspan="5" align="center">Aucune discipline (aucune note).</td></tr>
                        @else
                          @foreach($groupsPart as $g)
                            @php $rows = count($g['items']); $first = true; @endphp
                            @foreach($g['items'] as $it)
                              @php
                                $rid = (int)$it['rid'];

                                $mcc = $mccsApc[(string)$iid][(string)$rid] ?? null;
                                $intRaw = $compositionsApc[(string)$iid][(string)$rid] ?? null;

                                $integration = is_numeric($intRaw) ? (float)$intRaw : null;

                                $mccTxt = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
                                $intTxt = is_numeric($integration) ? number_format((float)$integration, 2) : '-';
                                $appTxt = is_numeric($integration) ? $obsFromNote($integration) : '-';
                              @endphp

                              <tr>
                                @if($first)
                                  <td rowspan="{{ $rows }}" class="border px-2 py-2 notes-wrap font-semibold align-top">
                                    {{ $g['competence_label'] }}
                                  </td>
                                  @php $first = false; @endphp
                                @endif
                                <td class="border px-2 py-2 notes-wrap">{{ $it['discipline'] }}</td>
                                <td class="border px-2 py-2 notes-num">{{ $mccTxt }}</td>
                                <td class="border px-2 py-2 notes-num">{{ $intTxt }}</td>
                                <td class="border px-2 py-2 notes-wrap">{{ $appTxt }}</td>
                              </tr>
                            @endforeach
                          @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>

              @empty
                <div class="text-sm text-gray-600">Aucun apprenant.</div>
              @endforelse
            </div>
          </div>

        </div>
      </div>

      {{-- Footer (fixe) --}}
      <div class="px-4 py-3 border-t bg-gray-50 flex justify-end">
        <button type="button"
                wire:click="closeNotesModal"
                class="bg-gray-700 text-white text-sm px-4 py-2 rounded hover:bg-gray-900">
          Fermer
        </button>
      </div>

    </div>
  </div>
@endif
