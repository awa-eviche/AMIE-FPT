<div>
    
    <button
        wire:click="open({{ $ressource->id }})"
        class="bg-green-600 text-white text-xs px-2 py-1 rounded">
        + Devoir
    </button>

    @if($showModal)
    <div class="fixed inset-0 z-50 bg-black/50 flex justify-center items-center">
        <div class="bg-white rounded-lg w-[900px] p-5 max-h-[90vh] overflow-y-auto">

            <div class="flex justify-between mb-3">
                <h3 class="font-semibold text-lg">Gestion des devoirs</h3>
                <button wire:click="$set('showModal', false)">✕</button>
            </div>

            {{-- LISTE DES DEVOIRS --}}
            @forelse($devoirs as $libelle => $lignes)
                <div class="border rounded p-3 mb-4">
                    <h4 class="font-semibold mb-2">{{ $libelle }}</h4>

                    <table class="w-full border text-sm">
                        @foreach($inscriptions as $inscription)
                            @php
                                $ligne = $lignes
                                    ->where('inscription_id', $inscription->id)
                                    ->first();
                            @endphp
                            <tr>
                                <td class="border px-2 py-1">
                                    {{ $inscription->apprenant->prenom }}
                                    {{ $inscription->apprenant->nom }}
                                </td>
                                <td class="border px-2 py-1 text-center">
                                    {{ $ligne?->note ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @empty
                <p class="text-gray-500 text-center">
                    Aucun devoir enregistré
                </p>
            @endforelse

            {{-- AJOUT DEVOIR --}}
            @if(auth()->user()->hasRole('formateur'))
            <hr class="my-4">

            <h4 class="font-semibold mb-2">Nouveau devoir</h4>

            <form wire:submit.prevent="saveDevoir">
                <input wire:model="libelle"
                       class="border w-full mb-3 px-2 py-1"
                       placeholder="Libellé du devoir">

                <table class="w-full border text-sm">
                    @foreach($inscriptions as $inscription)
                        <tr>
                            <td class="border px-2 py-1">
                                {{ $inscription->apprenant->prenom }}
                                {{ $inscription->apprenant->nom }}
                            </td>
                            <td class="border px-2 py-1 text-center">
                                <input type="number"
                                       wire:model.defer="notes.{{ $inscription->id }}"
                                       min="0" max="20" step="0.01"
                                       class="border w-24 px-1">
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="text-right mt-3">
                    <button class="bg-blue-600 text-white px-4 py-1 rounded">
                        Enregistrer
                    </button>
                </div>
            </form>
            @endif

        </div>
    </div>
    @endif
</div>
