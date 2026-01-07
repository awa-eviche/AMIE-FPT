<div>
    <h2 class="text-lg font-bold mb-2">
        Gestion des devoirs – Semestre {{ $semestre }}
    </h2>

    <p class="text-sm text-gray-600 mb-4">
    <strong>Matière :</strong> {{ $matiere->nom ?? '—' }} <br>
    <strong>Apprenant :</strong>
    {{ $apprenant?->prenom }} {{ $apprenant?->nom }}
</p>



    <div class="border rounded p-4 mb-4 bg-gray-50">
        <div class="flex gap-3">
            <div class="w-1/2">
                <label class="text-sm font-semibold">Libellé</label>
                <input wire:model.defer="libelle" class="w-full border rounded px-2 py-1">
            </div>

            <div class="w-1/4">
                <label class="text-sm font-semibold">Note /20</label>
                <input type="number" step="0.01"
                       wire:model.defer="note"
                       class="w-full border rounded px-2 py-1">
            </div>

            <button wire:click="addDevoir"
        class="px-4 py-2 rounded
               {{ $editingDevoirId ? 'bg-orange-500' : 'bg-blue-600' }} bg-orange-500">
    {{ $editingDevoirId ? 'Modifier' : 'Ajouter' }}
</button>

        </div>
    </div>

    {{-- LISTE --}}
    <table class="w-full text-sm border">
        <tbody>
            @forelse($devoirs as $devoir)
                <tr>
                    <td class="border p-2">{{ $devoir->libelle }}</td>
                    <td class="border p-2">{{ $devoir->note }}</td>
                    <td class="border p-2 space-x-2">
    <!-- ✏️ MODIFIER -->
    <button wire:click="editDevoir({{ $devoir->id }})"
            class="text-blue-600 text-xs underline">
        Modifier
    </button>

    <!-- 🗑 SUPPRIMER -->
    <button wire:click="deleteDevoir({{ $devoir->id }})"
            class="text-red-600 text-xs underline">
        Supprimer
    </button>
</td>

                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500">
                        Aucun devoir
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <button wire:click="close"
        class="px-4 py-2 bg-gray-500 text-white rounded">
    Terminer
</button>

</div>