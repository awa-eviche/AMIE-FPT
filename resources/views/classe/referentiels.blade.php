<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Référentiels de la classe : {{ $classe->libelle }}
    </h2>
</x-slot>

<!-- Search + controls -->

<div>
                    <h2 class="text-2xl font-bold">{{ $classe->libelle }}</h2>
                    <a href="{{ route('classe.index') }}" class="text-blue-600 hover:underline text-sm">
                        &larr; Retour à la liste des classes
                    </a>
                </div>
                <br>
                <br>
<!-- Grid -->
<div id="refsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  @forelse($referentiels as $ref)
    <article class="ref-card bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-1 transition">
      <div class="p-5 flex flex-col h-full">
        <div class="flex items-start justify-between gap-4">
          <div>
            <h3 class="font-semibold text-lg text-gray-800">{{ $ref->titre }}</h3>
            <p class="text-sm text-indigo-600 mt-1">{{ $ref->type_referentiel }}</p>
          </div>

          <div class="flex flex-col items-end gap-2">
            <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($ref->created_at)->format('d/m/Y') }}</span>
            <div class="flex gap-2">
              <button onclick="openModal('{{ asset('storage/'.$ref->fichier) }}','{{ addslashes($ref->titre) }}','{{ addslashes($ref->type_referentiel) }}')"
                      class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-indigo-600 hover:bg-indigo-50 border border-indigo-100">
                <!-- eye icon -->
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voir
              </button>

              <a href="{{ asset('storage/'.$ref->fichier) }}" target="_blank"
                 class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-green-600 hover:bg-green-50 border border-green-100">
                <!-- download icon -->
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v12m0 0l4-4m-4 4l-4-4M21 21H3" />
                </svg>
                Télécharger
              </a>
            </div>
          </div>
        </div>



        <div class="mt-auto flex items-center justify-between text-xs text-gray-400 pt-4">
          <span>{{ $ref->pages ?? '' }}</span>
          <span>{{ number_format(filesize(storage_path('app/public/'.$ref->fichier))/1024, 1) ?? '' }} KB</span>
        </div>
      </div>
    </article>
  @empty
    <p class="text-center text-gray-500 col-span-full">Aucun référentiel disponible</p>
  @endforelse
</div>


<!-- MODAL PDF -->
<div id="pdfModal" class="fixed inset-0 bg-black bg-opacity-80 hidden z-50 flex items-center justify-center">

<div class="w-full h-full relative">

<!-- Bouton fermer -->
<button onclick="closeModal()" 
        class="absolute top-4 right-6 text-white text-3xl font-bold z-50">
    ✕
</button>

<!-- PDF -->
<iframe id="pdfFrame"
        src=""
        class="w-full h-full">
</iframe>

</div>

</div>

<script>
function openModal(url) {
    document.getElementById('pdfFrame').src = url;
    document.getElementById('pdfModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('pdfModal').classList.add('hidden');
}
</script>

</x-app-layout>