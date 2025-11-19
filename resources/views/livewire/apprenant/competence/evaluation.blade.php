<div class="py-4">
    <div class="w-full rounded-lg shadow-xs p-0">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <div class="font-bold text-lg text-red-600">
                @if($apprenant && $apprenant->apprenant)
                    Évaluation de :
                    {{ $apprenant->apprenant->prenom.' '.$apprenant->apprenant->nom }}
                    [{{ $apprenant->apprenant->matricule ?? '-' }}]
                @endif
            </div>

            @if(auth()->user()->hasRole('formateur'))
                <button type="button"
                        onclick="gatherInfos()"
                        class="bg-first-orange px-4 py-2 text-white hover:bg-orange-600 rounded-md shadow">
                    <i class="fa fa-save"></i>&nbsp; Enregistrer les changements
                </button>
            @endif
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-2">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex items-center justify-end mb-4">
            <label class="block text-sm font-bold text-gray-700 mr-2">Semestre :</label>
            <select wire:model.live="selectedsemestre"
                    id="selectedsemestre"
                    class="border border-gray-300 rounded shadow-sm text-sm">
                <option value="">Sélectionnez un semestre</option>
                <option value="1">Premier semestre</option>
                <option value="2">Deuxième semestre</option>
            </select>
        </div>

        {{-- 🟢 COMPÉTENCES GÉNÉRALES --}}
        <h2 class="font-bold text-lg mb-2">Compétences Générales</h2>
        <table class="w-full border mb-6">
            <thead>
                <tr class="bg-first-orange text-white text-xs uppercase border-b">
                    <th class="px-4 py-2 border">Compétence</th>
                    <th class="px-4 py-2 border">Élément</th>
                    <th class="px-4 py-2 border">Ressource</th>
                    <th class="px-4 py-2 border">Note /20</th>
                    <th class="px-4 py-2 border">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($competencesGenerales as $idx => $comp)
                    @php $totalRows = $rowspansGenerales[$idx] ?? 1; $rowspanCount = 0; @endphp
                    @foreach($comp->elementCompetences as $el)
                        @foreach($el->ressource()->get() as $rIndex => $res)
                            @php $findRow = $evaluations[$res->id] ?? null; @endphp
                            <tr class="ressourceRow" id="{{ $res->id }}">
                                @if($rowspanCount == 0)
                                    <td rowspan="{{ $totalRows }}" class="border px-4 py-2 font-bold align-top">{{ $comp->nom }}</td>
                                @endif
                                @if($rIndex == 0)
                                    <td rowspan="{{ $el->ressource()->count() }}" class="border px-4 py-2 font-semibold align-top">{{ $el->nom }}</td>
                                @endif
                                <td class="border px-4 py-2">{{ $res->nom }}</td>
                                <td class="border text-center">
                                    <input type="number" min="0" max="20" step="0.5"
                                           class="noteRessource border border-gray-300 p-1 w-full text-center"
                                           value="{{ $findRow['note'] ?? '' }}">
                                </td>
                                <td class="border text-center">
                                    <input type="date"
                                           class="ressourceDate border border-gray-300 p-1 w-full"
                                           value="{{ $findRow['date'] ?? '' }}">
                                </td>
                            </tr>
                            @php $rowspanCount++; if ($rowspanCount == $totalRows) $rowspanCount = 0; @endphp
                        @endforeach
                    @endforeach
                @empty
                    <tr><td colspan="5" class="text-center py-3">Aucune donnée disponible</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- 🟠 COMPÉTENCES PARTICULIÈRES --}}
        <h2 class="font-bold text-lg mb-2">Compétences Particulières </h2>
        <table class="w-full border">
            <thead>
                <tr class="bg-first-orange text-white text-xs uppercase border-b">
                    <th class="px-4 py-2 border">Compétence</th>
                    <th class="px-4 py-2 border">Élément</th>
                    <th class="px-4 py-2 border">Seuil de reussite</th>
                    <th class="px-4 py-2 border">Note /20</th>
                    <th class="px-4 py-2 border">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($competencesParticulieres as $idx => $comp)
                    @php $totalRows = $rowspansParticulieres[$idx] ?? 1; $rowspanCount = 0; @endphp
                    @foreach($comp->elementCompetences as $el)
                        @foreach($el->criteres as $cIndex => $crit)
                            @php $findRow = $evaluations[$crit->id] ?? null; @endphp
                            <tr class="critereRow" id="{{ $crit->id }}">
                                @if($rowspanCount == 0)
                                    <td rowspan="{{ $totalRows }}" class="border px-4 py-2 font-bold align-top">{{ $comp->nom }}</td>
                                @endif
                                @if($cIndex == 0)
                                    <td rowspan="{{ $el->criteres->count() }}" class="border px-4 py-2 font-semibold align-top">{{ $el->nom }}</td>
                                @endif
                                <td class="border px-4 py-2">{{ $crit->libelle }}</td>
                                <td class="border text-center">
                                    <input type="number" min="0" max="20" step="0.5"
                                           class="noteCritere border border-gray-300 p-1 w-full text-center"
                                           value="{{ $findRow['note'] ?? '' }}">
                                </td>
                                <td class="border text-center">
                                    <input type="date"
                                           class="critereDate border border-gray-300 p-1 w-full"
                                           value="{{ $findRow['date'] ?? '' }}">
                                </td>
                            </tr>
                            @php $rowspanCount++; if ($rowspanCount == $totalRows) $rowspanCount = 0; @endphp
                        @endforeach
                    @endforeach
                @empty
                    <tr><td colspan="5" class="text-center py-3">Aucune donnée disponible</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@section('scriptsAdditionnels')
@include('layouts.v1.partials.swal._script')
<script>
function gatherInfos() {
    Swal.fire({
        title: 'Enregistrer les évaluations ?',
        text: "Confirmez la sauvegarde des données.",
        icon: "question",
        confirmButtonColor: '#16A34A',
        showCancelButton: true,
        confirmButtonText: 'Oui, enregistrer',
        cancelButtonText: 'Annuler',
    }).then((result) => {
        if (result.value) {
            let datas = [];

            document.querySelectorAll('.ressourceRow').forEach(row => {
                datas.push({
                    id: row.id,
                    note: parseFloat(row.querySelector('.noteRessource')?.value || 0),
                    date: row.querySelector('.ressourceDate')?.value || '',
                    type: 'ressource'
                });
            });

            document.querySelectorAll('.critereRow').forEach(row => {
                datas.push({
                    id: row.id,
                    note: parseFloat(row.querySelector('.noteCritere')?.value || 0),
                    date: row.querySelector('.critereDate')?.value || '',
                    type: 'critere'
                });
            });

            Livewire.dispatch('saveDatas', {
                datas: JSON.stringify(datas),
                semestre: document.getElementById('selectedsemestre').value
            });
        }
    });
}
</script>
@endsection
