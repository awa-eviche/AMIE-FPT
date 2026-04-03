<div class="mb-4">
    <h3 class="font-bold text-sm mb-2 px-2 py-1 rounded text-white" style="background-color: {{ $couleur }};">
        {{ $titre }}
    </h3>

    @if($competences->isEmpty())
        <p class="text-gray-400 text-sm italic px-2">Aucune compétence trouvée.</p>
    @else
    <div class="overflow-x-auto rounded border border-gray-200">
        <table class="w-full text-sm">
            <thead style="background-color: #f3f4f6;">
                <tr>
                    <th class="px-3 py-2 text-left border-b font-semibold text-gray-700" style="width: 28%">Compétence</th>
                    <th class="px-3 py-2 text-left border-b font-semibold text-gray-700" style="width: 32%">Ressource</th>
                    <th class="px-3 py-2 text-center border-b font-semibold text-gray-700" style="width: 12%">MCC</th>
                    <th class="px-3 py-2 text-center border-b font-semibold text-gray-700" style="width: 12%">Intégration</th>
                    <th class="px-3 py-2 text-center border-b font-semibold text-gray-700" style="width: 16%">Appréciation</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @foreach($competences as $comp)
                @php
                    $ressources = ($comp->ressources ?? collect())->unique('id')->values();
                    $rowspan = $ressources->count();
                @endphp
                @if($ressources->isEmpty())
                <tr>
                    <td class="px-3 py-3 font-semibold border-b text-gray-700">{{ $comp->nom }}</td>
                    <td colspan="4" class="px-3 py-3 text-center border-b text-gray-400 italic">Aucune ressource</td>
                </tr>
                @else
                @foreach($ressources as $index => $res)
                <tr class="hover:bg-gray-50">
                    @if($index === 0)
                    <td class="px-3 py-3 font-semibold border-b text-gray-700 align-top" rowspan="{{ $rowspan }}">
                        <span class="px-2 py-1 rounded text-xs text-white" style="background-color: {{ $couleur }};">
                            {{ $comp->nom }}
                        </span>
                    </td>
                    @endif

                    <td class="px-3 py-3 border-b text-gray-600">{{ $res->nom }}</td>

                    @php
                        $mccRow  = $mccSem->get($res->id);
                        $evalRow = $evalSem->get($res->id);
                        $mcc     = $mccRow ? (float)$mccRow->mcc : null;
                        $compositionRaw = $evalRow?->composition;

                        // Règle générale : si pas d'intégration => MCC
                        $integration = ($compositionRaw === null || $compositionRaw === '')
                            ? $mcc
                            : (float)$compositionRaw;

                        $appreciation = $obsFromNote($integration);
                    @endphp

                    {{-- MCC --}}
                    <td class="px-3 py-3 text-center border-b">
                        @if($mcc !== null)
                            <span class="font-bold" style="color: {{ $mcc >= 10 ? '#236F46' : '#ef4444' }}">
                                {{ number_format($mcc, 2) }}/20
                            </span>
                        @else
                            <span class="text-gray-300">-</span>
                        @endif
                    </td>

                    {{-- Intégration --}}
                    <td class="px-3 py-3 text-center border-b" style="background-color: #f0faf4;">
                        @if($integration !== null)
                            <span class="font-bold" style="color: {{ $integration >= 10 ? '#236F46' : '#ef4444' }}">
                                {{ number_format($integration, 2) }}/20
                            </span>
                        @else
                            <span class="text-gray-300 text-xs italic">En attente</span>
                        @endif
                    </td>

                    {{-- Appréciation --}}
                    <td class="px-3 py-3 text-center border-b">
                        @if($appreciation !== '-')
                            <span class="px-2 py-1 rounded text-xs"
                                  style="background-color: #e6f2ec; color: #236F46;">
                                {{ $appreciation }}
                            </span>
                        @else
                            <span class="text-gray-300">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>