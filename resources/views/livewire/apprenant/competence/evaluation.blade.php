<div class="py-4">
    <div class="w-full rounded-lg shadow-xs p-0">

        {{-- HEADER --}}
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

        {{-- MESSAGE --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-2">
                {{ session('message') }}
            </div>
        @endif

        {{-- SELECT SEMESTRE --}}
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
                @php
                    $totalRows = $rowspansGenerales[$idx] ?? 1;
                    $rowspanCount = 0;
                @endphp

                @foreach($comp->elementCompetences as $el)
                    @foreach($el->ressource()->get() as $rIndex => $res)
                        @php
                            $findRow = $evaluations[$res->id] ?? null;
                        @endphp

                        <tr class="ressourceRow" id="{{ $res->id }}">

                            {{-- Nom compétence --}}
                            @if($rowspanCount == 0)
                                <td rowspan="{{ $totalRows }}" class="border px-4 py-2 font-bold align-top">
                                    {{ $comp->nom }}
                                </td>
                            @endif

                            {{-- Élément --}}
                            @if($rIndex == 0)
                                <td rowspan="{{ $el->ressource()->count() }}"
                                    class="border px-4 py-2 font-semibold align-top">
                                    {{ $el->nom }}
                                </td>
                            @endif

                            {{-- Ressource --}}
                            <td class="border px-4 py-2">{{ $res->nom }}</td>

                            {{-- Note --}}
                            <td class="border text-center">
                                <input type="number" min="0" max="20" step="0.5"
                                       class="noteRessource border border-gray-300 p-1 w-full text-center"
                                       value="{{ $findRow['note'] ?? '' }}">
                            </td>

                            {{-- Date --}}
                            <td class="border text-center">
                                <input type="date"
                                       class="ressourceDate border border-gray-300 p-1 w-full"
                                       value="{{ $findRow['date'] ?? '' }}">
                            </td>
                        </tr>

                        @php
                            $rowspanCount++;
                            if ($rowspanCount == $totalRows) $rowspanCount = 0;
                        @endphp

                    @endforeach
                @endforeach

            @empty
                <tr><td colspan="5" class="text-center py-3">Aucune donnée disponible</td></tr>
            @endforelse
            </tbody>
        </table>


    
        <h2 class="font-bold text-lg mb-2">Compétences Particulières</h2>

        <table class="w-full border-t mb-3">
            <thead>
            <tr class="text-xs font-black uppercase bg-first-orange text-white border-b">
                <th class="px-4 py-4 border">Compétence</th>
                <th class="px-4 py-4 border">Élément de compétence</th>
                <th class="px-4 py-4 border">Critère</th>
                <th class="px-4 py-4 border">Acquis</th>
                <th class="px-4 py-4 border">Non acquis</th>
                <th class="px-4 py-4 border">Date Eva</th>
              
            </tr>
            </thead>

            <tbody class="bg-white divide-y">

            @forelse($competences as $cptCompetence => $competence)

                @php $rowspanCount = 0; @endphp

                @foreach ($competence->elementCompetences as $elementCompetence)
                    @foreach ($elementCompetence->criteres as $cpt => $critere)

                        @php
                            $findRow = $evaluations[$critere->id] ?? null;
                        @endphp

                        <tr class="critereRow" id="{{ $critere->id }}">

                            {{-- Compétence --}}
                            @if($rowspanCount == 0)
                                <td rowspan="{{ $rowspans[$cptCompetence] }}"
                                    class="px-4 py-3 border text-center font-bold">
                                    {{ $competence->nom }}
                                </td>
                            @endif

                            {{-- Élément --}}
                            @if($cpt == 0)
                                <td rowspan="{{ count($elementCompetence->criteres) }}"
                                    class="px-4 py-3 border text-center font-bold">
                                    {{ $elementCompetence->nom }}
                                </td>
                            @endif

                            {{-- Critère --}}
                            <td class="px-4 py-3 border">{{ $critere->libelle }}</td>

                            {{-- Acquis --}}
                            <td class="px-4 py-3 border text-center">
                                <input type="checkbox" class="acquis"
                                       {{ isset($findRow['acquis']) && $findRow['acquis'] ? 'checked' : '' }}>
                            </td>

                            {{-- Non acquis --}}
                            <td class="px-4 py-3 border text-center">
                                <input type="checkbox" class="nonAcquis"
                                       {{ isset($findRow['nonAcquis']) && $findRow['nonAcquis'] ? 'checked' : '' }}>
                            </td>

                            {{-- Date --}}
                            <td class="px-4 py-3 border text-center">
                                <input type="date"
                                    class="critereDate border border-gray-300 p-1 w-full"
                                    value="{{ $findRow['date'] ?? '' }}">
                            </td>

                          

                        </tr>

                        @php
                            $rowspanCount++;
                            if ($rowspanCount == $rowspans[$cptCompetence]) $rowspanCount = 0;
                        @endphp

                    @endforeach
                @endforeach

            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 font-bold">
                        Aucune donnée disponible
                    </td>
                </tr>
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
        title: 'Enregistrer ?',
        text: "Confirmez la sauvegarde des évaluations",
        icon: "question",
        confirmButtonColor: '#16A34A',
        showCancelButton: true,
        confirmButtonText: 'Oui',
        cancelButtonText: 'Annuler',
    }).then((result) => {

        if (!result.value) return;

        let datas = [];

        // RESSOURCES (générales)
        document.querySelectorAll('.ressourceRow').forEach(row => {
            datas.push({
                id: row.id,
                type: 'ressource',
                note: row.querySelector('.noteRessource')?.value || '',
                date: row.querySelector('.ressourceDate')?.value || '',
            });
        });

        // CRITERES (particulieres)
        document.querySelectorAll('.critereRow').forEach(row => {
            datas.push({
                id: row.id,
                type: 'critere',
                acquis: row.querySelector('.acquis')?.checked ? 1 : 0,
                nonAcquis: row.querySelector('.nonAcquis')?.checked ? 1 : 0,
                date: row.querySelector('.critereDate')?.value || '',
               
            });
        });

        Livewire.dispatch('saveDatas', {
            datas: JSON.stringify(datas),
            semestre: document.getElementById('selectedsemestre').value
        });
    });
}
</script>
@endsection
