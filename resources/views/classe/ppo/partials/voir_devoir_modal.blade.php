{{-- resources/views/classe/ppo/partials/voir_devoir_modal.blade.php --}}
<div id="voirDevoirPpoModal"
     class="hidden fixed inset-0 z-50 bg-black/50 bg-opacity-50  overflow-y-auto overflow-x-hidden items-center smd:inset-0 h-[calc(100%-1rem)]  w-100 h-100 mx-auto max-w-full max-h-full">
 

  {{-- wrapper qui prend toute la hauteur --}}
  <div class="min-h-full flex items-start justify-center p-6">

    {{-- panel --}}
    <div class="bg-white rounded-lg w-[900px] max-w-full max-h-[90vh] shadow-xl overflow-hidden flex flex-col">

      {{-- HEADER (ne scrolle pas) --}}
      <div class="p-5 border-b flex items-center justify-between shrink-0">
        <div>
          <h3 class="font-semibold">Liste des devoirs</h3>
          <div id="voirDevoirMatiereName" class="text-xs text-gray-600"></div>
           <div class="mb-4 flex items-center gap-4">
            <label class="text-sm font-medium">Filtrer par semestre :</label>
            <!-- <select id="filtreSemestre" onchange="filtrerParSemestre()" 
        class="border rounded px-3 py-1 text-sm">
  <option value="">Tous les semestres</option>
  <option value="1">Premier semestre</option>
  <option value="2">Deuxième semestre</option>
</select> -->

        </div>
        </div>
      
        
      </div>
      

      {{-- ✅ ZONE QUI SCROLLE --}}
      <div id="voirDevoirContent"
           tabindex="0"
           class="flex-1 min-h-0 p-5 text-sm overflow-y-auto">
        <div class="text-gray-500">Chargement...</div>
      </div>
<div class="flex items-center gap-2">
          @if(auth()->user()->hasRole('formateur'))
            <button type="button"
                    onclick="openAddDevoirFromVoirModal()"
                    class="bg-green-600 text-white text-xs px-3 py-2 rounded hover:bg-green-700">
              + Nouveau devoir
            </button>
          @endif

          <button type="button"
                  onclick="closeVoirDevoirPpoModal()"
                  class="bg-gray-500 text-white text-xs px-3 py-2 rounded hover:bg-gray-600">
            Fermer
          </button>
        </div>
    </div>
    
  </div>
  
</div>


 @include('classe.ppo.partials.add_devoir_modal')
 @include('classe.ppo.partials.devoir_script')