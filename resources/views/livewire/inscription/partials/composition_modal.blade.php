@if($showCompositionModal)
<div class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4">

  <div class="bg-white rounded-lg shadow-xl w-[1200px] max-w-[95vw]"
       style="height:90vh; display:flex; flex-direction:column; overflow:hidden;">

    {{-- HEADER FIXE --}}
    <div class="p-4 border-b flex items-center justify-between bg-white" style="flex:0 0 auto;">
      <div>
        <div class="font-semibold">Evaluation</div>
        <div class="text-xs text-gray-600">
          {{ $compositionMatiereNom }} • Semestre {{ $compositionSemestre }}
        </div>
      </div>

      <button type="button"
              wire:click="closeCompositionClasseModal"
              class="bg-gray-600 text-white text-xs px-3 py-2 rounded hover:bg-gray-700">
        Fermer
      </button>
    </div>

    <form wire:submit.prevent="saveCompositionClasse"
          style="flex:1 1 auto; min-height:0; display:flex; flex-direction:column;">

      {{-- ZONE SCROLL (SEULE PARTIE QUI SCROLL) --}}
      <div class="p-4"
           style="flex:1 1 auto; min-height:0; overflow-y:auto; -webkit-overflow-scrolling:touch;">

        <table class="w-full text-sm border">
          <thead class="bg-gray-50">
            <tr>
              <th class="border px-2 py-2 text-left">Apprenant</th>
              <th class="border px-2 py-2 text-center">MCC</th>
              <th class="border px-2 py-2 text-center">Composition</th>
            </tr>
          </thead>

          <tbody>
            @foreach($compositionApprenants as $insc)
              @php($mcc = $compositionMcc[$insc->id] ?? null)

              <tr class="hover:bg-gray-50">
                <td class="border px-2 py-2">
                  {{ $insc->apprenant?->prenom }} {{ $insc->apprenant?->nom }}
                </td>

                <td class="border px-2 py-2 text-center">
                  @if($mcc !== null)
                    <span class="font-semibold">{{ number_format((float)$mcc, 2) }}/20</span>
                  @else
                    <span class="text-gray-400">—</span>
                  @endif
                </td>

                <td class="border px-2 py-2 text-center">
                  <input type="number"
                         wire:model.defer="compositionNotes.{{ $insc->id }}"
                         step="0.01" min="0" max="20"
                         class="border rounded px-2 py-1 w-28 text-center"
                         placeholder="0-20">
                  @error("compositionNotes.$insc->id")
                    <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                  @enderror
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>

      {{-- FOOTER FIXE --}}
      <div class="p-4 border-t bg-white flex justify-end gap-2" style="flex:0 0 auto;">
        <button type="button"
                wire:click="closeCompositionClasseModal"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
          Annuler
        </button>

        <button type="submit"
                wire:loading.attr="disabled"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 disabled:opacity-60">
          Enregistrer
        </button>
      </div>

    </form>
  </div>
</div>
@endif
