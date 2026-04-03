<div id="devoirPpoModal"
     class="hidden fixed inset-0 z-50 bg-black bg-opacity-70 flex items-center justify-center p-4">

  <div class="bg-white rounded-lg shadow-xl w-[700px] max-w-[95vw]"
       style="height:90vh; display:flex; flex-direction:column; overflow:hidden;">


    <div class="p-4 border-b flex items-center justify-between bg-white"
         style="flex: 0 0 auto;">
      <h3 class="font-semibold">Ajouter un devoir</h3>
      <button type="button" onclick="closeDevoirPpoModal()"
              class="text-red-600 font-bold text-lg leading-none">✕</button>
    </div>

    <form method="POST" action="{{ route('devoirPPO.store') }}"
          style="flex:1 1 auto; min-height:0; display:flex; flex-direction:column;">
      @csrf

      <input type="hidden" name="matiere_id" id="devoir_matiere_id">
      <input type="hidden" name="classe_id" value="{{ $classe->id }}">

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

      {{-- ✅ ZONE SCROLL GARANTIE --}}
      <div id="devoirPpoBodyScroll"
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
           style="flex: 0 0 auto;">
        <button type="button"
                onclick="closeDevoirPpoModal()"
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
