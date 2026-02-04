@php($groupesDevoirs = $groupesDevoirs ?? collect())

@if($groupesDevoirs->isEmpty())
  <div class="text-center text-gray-500 py-6">
    Aucun devoir enregistré pour cette matière.
  </div>
@else

  @foreach($groupesDevoirs as $semestreKey => $parLibelle)
    @foreach($parLibelle as $libelleKey => $devoirs)
      @php($first = $devoirs->first())

      <div class="border rounded mb-4">
        <div class="bg-gray-100 px-3 py-2 flex justify-between items-center">
          <div class="font-semibold">{{ $libelleKey }}</div>

          <div class="flex items-center gap-2 text-xs">
            <span class="px-2 py-1 rounded {{ (int)$semestreKey === 1 ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
              Semestre {{ $semestreKey }}
            </span>
          </div>
        </div>

        <div class="p-3 overflow-x-auto">
          <table class="w-full text-sm border">
            <thead class="bg-gray-50">
              <tr>
                <th class="border px-2 py-1 text-left">Apprenant</th>
                <th class="border px-2 py-1 text-center">Note</th>
                <th class="border px-2 py-1 text-center">MCC</th>
                @if(auth()->user()->hasRole('formateur'))
                  <th class="border px-2 py-1 text-center">Actions</th>
                @endif
              </tr>
            </thead>

            <tbody>
              @foreach($devoirs as $d)
                <tr id="devoir-row-{{ $d->id }}">
                  <td class="border px-2 py-1">
                    {{ $d->inscription?->apprenant?->prenom }} {{ $d->inscription?->apprenant?->nom }}
                  </td>

                  <td class="border px-2 py-1 text-center">
                    @if($d->note === null)
                      <span class="text-gray-400 italic">—</span>
                    @else
                      <span id="note-display-{{ $d->id }}"
                            class="font-semibold {{ $d->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format((float)$d->note, 2) }}/20
                      </span>
                    @endif
                  </td>

                  <td class="border px-2 py-1 text-center">
                    <span class="text-gray-700 font-semibold">
                      {{ number_format((float)($d->mcc ?? 0), 2) }}/20
                    </span>
                  </td>

                  @if(auth()->user()->hasRole('formateur'))
                    <td class="border px-2 py-1 text-center">
                      <button type="button"
                              onclick="editNoteInlinePPO({{ $d->id }})"
                              class="bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700">
                        <i class="fa fa-edit"></i>
                      </button>
                    </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    @endforeach
  @endforeach

@endif
