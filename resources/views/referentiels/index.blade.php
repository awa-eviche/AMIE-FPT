<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Liste des Référentiels
    </h2>
</x-slot>

<div class="pl-1 pr-5">

    <!-- HEADER ACTIONS -->
    <div class="flex mb-5 justify-between">
        <div class="flex">
            <input type="text" wire:model="search" placeholder="Rechercher"
                   class="form-input text-sm px-4 py-3 w-max shadow-sm border-white">
        </div>

        <div class="flex">
            <a href="{{ route('referentiel.create') }}"
               class="px-3 rounded-md py-3 flex text-white text-xs font-bold bg-orange-400 items-center">
                + Ajouter Référentiel
            </a>
        </div>
    </div>

    <!-- FILTRE -->
  

    <br>

    <!-- TABLEAU -->
    <div class="w-full rounded-lg shadow-xs">
        <table class="w-full border-t mb-3">
            <thead>
                <tr class="text-xs font-black tracking-wide text-left text-maquette-gris font-bold uppercase border-b bg-first-orange">
                    <th class="px-4 py-3">N°</th>
                    <th class="px-4 py-3">Métier</th>
                    <th class="px-4 py-3">Niveau</th>
                    <th class="px-4 py-3">Type</th>
                  
                    <th class="px-4 py-3">Fichier</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y">
                @forelse($referentiels as $key => $ref)
                <tr>
                    <td class="px-4 py-3">{{ $key + 1 }}</td>

                    <td class="px-4 py-3">
                        {{ $ref->metier->nom ?? '-' }}
                    </td>

                    <td class="px-4 py-3">
    @if($ref->niveaux->count())
        {{ $ref->niveaux->pluck('nom')->join(', ') }}
    @else
        -
    @endif
</td>

                    <td class="px-4 py-3">
                        {{ $ref->type_referentiel }}
                    </td>

                 

                    <td class="px-4 py-3">
                        @if($ref->fichier)
                            <a href="{{ asset('storage/'.$ref->fichier) }}" target="_blank"
                               class="text-blue-500 underline">
                                Télécharger
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    <td class="px-6 py-3 border-b flex">
    <div class="relative" x-data="{ open: false }" @click.away="open = false">

        <!-- Bouton 3 points -->
        <div @click="open = ! open">
            <button
                class="bg-dark text-white font-semibold py-2 px-6 rounded inline-flex items-center justify-end">

                <svg width="18" height="4" viewBox="0 0 18 4" fill="none">
                    <circle cx="2" cy="2" r="2" fill="#1A4085"/>
                    <circle cx="9" cy="2" r="2" fill="#1A4085"/>
                    <circle cx="16" cy="2" r="2" fill="#1A4085"/>
                </svg>

            </button>
        </div>

        <!-- Dropdown -->
        <div x-show="open"
             x-transition
             class="absolute z-50 mt-1 w-48 rounded-md shadow-lg origin-top-right right-0"
             style="display: none;">

            <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white">

                <!-- VOIR -->
                @if($ref->fichier)
                <div class="border py-2 text-center">
                    <a href="#"
                       onclick="openModal('{{ asset('storage/'.$ref->fichier) }}')"
                       class="text-blue-600">
                        Voir
                    </a>
                </div>
                @endif

                <!-- MODIFIER -->
                <div class="border py-2 text-center">
                    <a href="{{ route('referentiel.edit', $ref->id) }}"
                       class="text-purple-600">
                        Modifier
                    </a>
                </div>

                <!-- SUPPRIMER -->
                <div class="border py-2 text-center">
                    <form action="{{ route('referentiel.destroy', $ref->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="text-red-500">
                            Supprimer
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        Aucun référentiel trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL PDF -->
<!-- MODAL PDF -->
<div id="pdfModal" class="fixed inset-0 bg-black bg-opacity-70 hidden z-50 flex items-center justify-center">
    
<div class="bg-white w-[95%] h-[90vh] rounded-lg shadow-2xl relative">
        
        <!-- Bouton fermer -->
        <button onclick="closeModal()" 
                class="absolute top-2 right-2 text-red-500 text-xl font-bold">
            ✕
        </button>

        <!-- PDF -->
        <iframe id="pdfFrame" 
                src="" 
                class="w-full h-full rounded">
        </iframe>

    </div>
</div> 

<script>
function openModal(fileUrl) {
    document.getElementById('pdfFrame').src = fileUrl;
    document.getElementById('pdfModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('pdfFrame').src = "";
    document.getElementById('pdfModal').classList.add('hidden');
}
</script>
</x-app-layout>