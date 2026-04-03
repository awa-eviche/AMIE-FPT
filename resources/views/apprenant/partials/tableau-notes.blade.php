@php
    $sumTotal = 0; 
    $sumCoef  = 0;
    foreach($data as $e) {
        $coef = is_numeric($e['coef']) ? (float)$e['coef'] : 0;
        $moy  = $e['moyenne'] ?? null;
        if ($coef > 0 && $moy !== null) {
            $sumTotal += $moy * $coef;  // Σ(moyenne * coef)
            $sumCoef  += $coef;          // Σ coef
        }
    }
    // Même formule que generatePDF : ΣTotal / ΣCoef
    $mgPonderee = $sumCoef > 0 ? round($sumTotal / $sumCoef, 2) : null;
@endphp
<div class="overflow-x-auto rounded-lg shadow">
    <table class="w-full text-sm border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left border-b font-semibold text-gray-700">Matière</th>
                <th class="px-4 py-3 text-center border-b font-semibold text-gray-700">Coef</th>
                <th class="px-4 py-3 text-center border-b font-semibold text-gray-700">Note CC</th>
                <th class="px-4 py-3 text-center border-b font-semibold text-gray-700">Note Composition</th>
                <th class="px-4 py-3 text-center border-b font-semibold text-blue-700 bg-blue-50">Moyenne</th>
                <th class="px-4 py-3 text-center border-b font-semibold text-gray-700">Appréciation</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y">
            @foreach($data as $e)
            @php
                $note_cc   = $e['note_cc'] ?? null;
                $note_comp = $e['note_composition'] ?? null;
                $moyenne   = $e['moyenne'] ?? null;
            @endphp
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium text-gray-800 border-b">{{ $e['matiere'] }}</td>
                <td class="px-4 py-3 text-center border-b text-gray-600">{{ $e['coef'] }}</td>

                <td class="px-4 py-3 text-center border-b">
                    @if($note_cc !== null)
                        <span class="font-bold {{ $note_cc >= 10 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $note_cc }}/20
                        </span>
                    @else
                        <span class="text-gray-300">-</span>
                    @endif
                </td>

                <td class="px-4 py-3 text-center border-b">
                    @if($note_comp !== null)
                        <span class="font-bold {{ $note_comp >= 10 ? 'text-green-600' : 'text-red-500' }}">
                            {{ $note_comp }}/20
                        </span>
                    @else
                        <span class="text-gray-300 text-xs italic">En attente</span>
                    @endif
                </td>

                <td class="px-4 py-3 text-center border-b bg-blue-50">
                    @if($moyenne !== null)
                        <span class="font-bold text-lg {{ $moyenne >= 10 ? 'text-blue-700' : 'text-red-600' }}">
                            {{ $moyenne }}/20
                        </span>
                    @else
                        <span class="text-gray-400 text-xs italic">Non définie</span>
                    @endif
                </td>

                <td class="px-4 py-3 text-center border-b">
                    @if($e['appreciation'])
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                            {{ $e['appreciation'] }}
                        </span>
                    @else
                        <span class="text-gray-300">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>

        {{-- Moyenne générale pondérée --}}
        @php
            $sumTotal = 0; $sumCoef = 0;
            foreach($data as $e) {
                $coef = is_numeric($e['coef']) ? (float)$e['coef'] : 0;
                $moy  = $e['moyenne'] ?? null;
                if ($coef > 0 && $moy !== null) {
                    $sumTotal += $moy * $coef;
                    $sumCoef  += $coef;
                }
            }
            $mgPonderee = $sumCoef > 0 ? round($sumTotal / $sumCoef, 2) : null;
        @endphp

        @if($mgPonderee !== null)
        <tfoot class="bg-gray-50">
            <tr>
                <td colspan="4" class="px-4 py-3 text-right font-bold text-gray-700">
                    Moyenne Générale Pondérée :
                </td>
                <td class="px-4 py-3 text-center bg-blue-50">
                    <span class="font-bold text-lg {{ $mgPonderee >= 10 ? 'text-blue-700' : 'text-red-600' }}">
                        {{ $mgPonderee }}/20
                    </span>
                </td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>