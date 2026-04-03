{{-- resources/views/devoirsAPC/partials/liste-devoirs.blade.php --}}
@php
    $groupesDevoirs = $groupesDevoirs ?? collect();
@endphp

@if($groupesDevoirs->isNotEmpty())

    <div class="overflow-y-auto"
         style="max-height: calc(100vh - 300px);"
         id="devoirsScrollContainer">

        
        @foreach($groupesDevoirs as $semestre => $groupByLibelle)

            @foreach($groupByLibelle as $libelle => $devoirsGroupe)
                <div class="mb-6 border rounded-lg p-4 bg-gray-50">

                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-bold text-lg text-blue-700">{{ $libelle }}</h4>

                        {{-- (Optionnel) badge semestre à droite aussi --}}
                        <span class="text-xs px-2 py-1 rounded
                            {{ (int)$semestre === 1 ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            Semestre {{ $semestre }}
                        </span>
                    </div>

                    <table class="w-full border text-sm">
                        <thead class="bg-blue-100">
                            <tr>
                                <th class="border px-3 py-2 text-left">Apprenant</th>
                                <th class="border px-3 py-2 text-left">Note</th>
                                <th class="border px-3 py-2 text-left">MCC</th>
                                <th class="border px-3 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devoirsGroupe as $devoir)
                                <tr class="hover:bg-gray-100" id="devoir-row-{{ $devoir->id }}">
                                    <td class="border px-3 py-2">
                                        {{ $devoir->inscription->apprenant->nom ?? '' }}
                                        {{ $devoir->inscription->apprenant->prenom ?? '' }}
                                    </td>

                                    <td class="border px-3 py-2 text-center">
                                        @if($devoir->note !== null)
                                            <span id="note-display-{{ $devoir->id }}"
                                                  class="font-semibold {{ $devoir->note >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format((float)$devoir->note, 2) }}/20
                                            </span>
                                        @else
                                            <span id="note-display-{{ $devoir->id }}" class="text-gray-400 italic">Non noté</span>
                                        @endif
                                    </td>

                                    <td class="border px-3 py-2 text-center">
                                        @if($devoir->mcc !== null)
                                            <span class="font-bold {{ $devoir->mcc >= 10 ? 'text-green-700' : 'text-red-700' }}">
                                                {{ number_format((float)$devoir->mcc, 2) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="border px-3 py-2 text-center">
                                        <div class="flex justify-center gap-1">
                                            <button type="button"
                                                    onclick="editNoteInline({{ $devoir->id }})"
                                                    class="bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            @endforeach

        @endforeach

    </div>

@else
    <div class="text-center py-8 text-gray-500">
        <i class="fa fa-clipboard-list text-4xl mb-3"></i>
        <p class="text-lg">Aucun devoir enregistré pour cette discipline</p>
    </div>
@endif
