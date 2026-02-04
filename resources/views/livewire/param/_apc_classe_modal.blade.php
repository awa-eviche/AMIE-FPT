@if($showApcClasseModal)
<div class="fixed inset-0 z-50 bg-black/70 flex bg-opacity-70 items-center justify-center p-4">

  <div class="bg-white rounded-lg shadow-xl w-[1200px] max-w-[95vw] bg-opacity-70"
       style="height:90vh; display:flex; flex-direction:column; overflow:hidden;">

    {{-- HEADER FIXE --}}
    <div class="p-4 border-b flex items-center justify-between bg-white" style="flex:0 0 auto;">
      <div>
        <div class="font-semibold text-lg text-green-600">Évaluation APC </div>
        <div class="text-xs text-gray-600">
          Classe : <span class="font-semibold">{{ $currentClasse?->libelle ?? '-' }}</span>
          • Année : <span class="font-semibold">{{ $anneeAcademiqueLabel ?? '-' }}</span>
        </div>
      </div>

      <button type="button"
              wire:click="closeApcClasseModal"
              class="text-red-600 font-bold text-lg leading-none">✕</button>
    </div>

    {{-- MESSAGE SUCCESS / ERROR --}}
    <div class="px-4 pt-3" style="flex:0 0 auto;">
      @if (session()->has('success'))
        <div class="flex items-center p-3 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-sm" role="alert">
          <span class="font-medium">Succès !</span>&nbsp;{{ session('success') }}
        </div>
      @endif

      @if (session()->has('error'))
        <div class="flex items-center p-3 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-sm" role="alert">
          <span class="font-medium">Erreur !</span>&nbsp;{{ session('error') }}
        </div>
      @endif
    </div>

    <form wire:submit.prevent="saveApcClasse"
          style="flex:1 1 auto; min-height:0; display:flex; flex-direction:column;">

      {{-- CHAMPS FIXES --}}
      <div class="p-4 bg-white border-b" style="flex:0 0 auto;">
        <div class="flex items-center justify-between gap-3">
          <div class="flex items-center">
            <label class="block text-sm font-bold text-gray-700 mr-2">Semestre :</label>
           <select wire:model.live="apcSemestre" class="border border-gray-300 rounded shadow-sm text-sm">

              <option value="">Sélectionnez un semestre</option>
              <option value="1">Premier semestre</option>
              <option value="2">Deuxième semestre</option>
            </select>
          </div>

       
        </div>
      </div>

      
      <div class="p-4"
           style="flex:1 1 auto; min-height:0; overflow-y:auto; -webkit-overflow-scrolling:touch;">

        @if(empty($apprenantsApcModal))
          <div class="text-sm text-gray-500">Aucun apprenant chargé.</div>
        @else

        @foreach($apprenantsApcModal as $insc)
  <details wire:key="apc-insc-{{ $insc->id }}" class="mb-4 border rounded-lg bg-white">
              <summary class="cursor-pointer px-4 py-3 font-semibold bg-gray-50">
                {{ $insc->apprenant?->prenom }} {{ $insc->apprenant?->nom }}
                <span class="text-xs text-gray-500">
                  [{{ $insc->apprenant?->matricule ?? '-' }}]
                </span>
              </summary>

              <div class="p-4">

                {{-- COMPÉTENCES GÉNÉRALES --}}
              @if(!empty($competencesGenerales) && count($competencesGenerales) > 0)
  <h2 class="font-bold text-lg mb-2">Compétences Générales</h2>

  <table class="w-full border mb-6 text-sm">
    <thead>
      <tr class="bg-first-orange text-white text-xs uppercase border-b">
        <th class="px-4 py-2 border">Compétence</th>
        <th class="px-4 py-2 border">Discipline</th>
        <th class="px-4 py-2 border">MCC</th>
        <th class="px-4 py-2 border">Intégration</th>
      </tr>
    </thead>
    <tbody class="bg-white">
      @foreach($competencesGenerales as $competence)
        @foreach($competence->ressources as $ressource)
          @php($mcc = $mccsApc[$insc->id][$ressource->id] ?? 0)
          <tr>
            <td class="border px-4 py-2 font-bold">{{ $competence->nom }}</td>
            <td class="border px-4 py-2">{{ $ressource->nom }}</td>
            <td class="border px-4 py-2 text-center font-bold text-green-700">
              {{ number_format((float)$mcc, 2) }}
            </td>
            <td class="border px-4 py-2 text-center">
              <input type="number"
                     wire:model.defer="compositionsApc.{{ $insc->id }}.{{ $ressource->id }}"
                     min="0" max="20" step="0.5"
                     class="border border-gray-300 p-1 w-24 text-center">
            </td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>
@endif


                {{-- COMPÉTENCES PARTICULIÈRES --}}
               @if(!empty($competencesParticulieres) && count($competencesParticulieres) > 0)
  <h2 class="font-bold text-lg mb-2">Compétences Particulières</h2>

  <table class="w-full border text-sm">
    <thead class="bg-first-orange text-white text-xs uppercase">
      <tr>
        <th class="border px-2 py-2">Compétence</th>
        <th class="border px-2 py-2">Discipline</th>
        <th class="border px-2 py-2">MCC</th>
        <th class="border px-2 py-2">Intégration</th>
      </tr>
    </thead>
    <tbody>
      @foreach($competencesParticulieres as $competence)
        @foreach($competence->ressources as $ressource)
          @php($mcc = $mccsApc[$insc->id][$ressource->id] ?? 0)
          <tr>
            <td class="border px-2 py-2 font-bold text-center">{{ $competence->nom }}</td>
            <td class="border px-2 py-2 text-center">{{ $ressource->nom }}</td>
            <td class="border px-2 py-2 text-center font-bold text-green-700">
              {{ number_format((float)$mcc, 2) }}
            </td>
            <td class="border px-2 py-2 text-center">
              <input type="number"
                     wire:model.defer="compositionsApc.{{ $insc->id }}.{{ $ressource->id }}"
                     min="0" max="20" step="0.5"
                     class="border rounded px-2 py-1 w-24 text-center">
            </td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>
@endif


              </div>
            </details>

          @endforeach
        @endif

      </div>

    
      <div class="p-4 border-t bg-white flex justify-end gap-2" style="flex:0 0 auto;">
           @if(auth()->user()->hasRole('formateur'))
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow inline-flex items-center gap-2">
              <i class="fa fa-save"></i>&nbsp; Enregistrer les changements
            </button>
          @endif
        <button type="button" wire:click="closeApcClasseModal"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
          Fermer
        </button>
      </div>

    </form>
  </div>
</div>
@endif
