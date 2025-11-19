<div class="py-4">
    <div class="w-full rounded-lg shadow-xs p-0">
        <div class="flex flex-col sm:flex-row w-full justify-between sm:items-center">
            {{-- Afficher l'apprenant --}}
            <div class="font-bold text-lg text-red-600">
    @if($apprenant && $apprenant->apprenant)
        Évaluation de :
        {{ $apprenant->apprenant->prenom.' '.$apprenant->apprenant->nom }}
        [{{ $apprenant->apprenant->matricule ?? '-' }}]
    @else
        Aucun apprenant trouvé.
    @endif
</div>


            {{-- Bouton pour enregistrer --}}
            <button type="button"
                    onclick="gatherInfos()"
                    class="w-max my-2 sm:my-0 bg-first-orange px-4 py-2 mb-5 text-white hover:bg-first-orange rounded-md">
                <i class="fa fa-save"></i>&nbsp;&nbsp;Enregistrer les changements
            </button>
        </div>

        {{-- Affichage du message de succès (après redirect) --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-2">
                {{ session('message') }}
            </div>
        @endif

        {{-- ✅ Choix du semestre --}}
        <div class="flex items-center justify-end mb-4">
            <label for="selectedsemestre" class="block text-sm font-bold text-gray-700 mr-2">Semestre :</label>
            <select wire:model.live="selectedsemestre" id="selectedsemestre" name="semestre" 
                    class="block w-auto border border-gray-300 rounded shadow-sm focus:border-first-orange text-sm required">
                <option value="">Tous les semestres</option>
                <option value="1">Premier semestre</option>
                <option value="2">Deuxième semestre</option>
            </select>
        </div>

        {{-- ===== Tableau Compétences Générales ===== --}}
        <div class="text-sm w-full p-0 relative overflow-x-auto my-2">
            <h2 class="font-bold text-lg mb-2">Compétences Générales</h2>
            <table class="w-full border-t mb-3">
                <thead>
                    <tr class="text-xs font-black tracking-wide text-left text-white font-bold uppercase border-b bg-first-orange">
                        <th class="px-4 py-4 text-white border border-black">Compétence</th>
                        <th class="px-4 py-4 text-white border border-black">Element de compétence</th>
                        <th class="px-4 py-4 text-white border border-black">Critère</th>
                        <th class="px-4 py-4 text-white border border-black">Note /20</th>
                        <th class="px-4 py-4 text-white border border-black">
                            <abbr title="Date evaluation">Date Eva</abbr>
                        </th>
                     
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @if($competencesGenerales && $competencesGenerales->count() > 0)
                        @php
                            $output = '';
                            $rowspanCount = 0;
                            foreach ($competencesGenerales as $cptCompetence => $competence) {
                                foreach ($competence->elementCompetences as $elementCompetence) {
                                    foreach ($elementCompetence->criteres as $cpt => $critere) {
                                        $output .= '<tr class="critereRow" id="'.$critere->id.'">';

                                        if ($rowspanCount == 0) {
                                            $output .= '<td rowspan="'.$rowspansGenerales[$cptCompetence].'" class="px-4 py-3 border border-black text-center font-bold">'
                                                        . ($competence->nom ?? '-') . '</td>';
                                        }

                                        if ($cpt == 0) {
                                            $rowElement = count($elementCompetence->criteres);
                                            $output .= '<td rowspan="'.$rowElement.'" class="px-4 py-3 border border-black text-center font-bold">'
                                                        . ($elementCompetence->nom ?? '-') . '</td>';
                                        }

                                        $output .= '<td class="px-4 py-3 border border-black">'. ($critere->libelle ?? '-') . '</td>';

                                        $findRow = $evaluations[$critere->id] ?? null;

                                        // Note
                                        $output .= '<td class="px-4 py-3 border border-black text-center">';
                                        $output .= '<input type="number" min="0" max="20" step="0.5"
                                                        class="noteCritere border border-gray-300 p-1 w-full text-center"
                                                        value="' . ($findRow['note'] ?? '') . '" />';
                                        $output .= '</td>';

                                        // Date
                                        $output .= '<td class="px-4 py-3 border border-black text-center">';
                                        $output .= '<input type="date"
                                                           class="critereDate border border-gray-300 p-1 w-full"
                                                           value="'.($findRow['date'] ?? '').'" />';
                                        $output .= '</td>';

                                        // Observations
                                        
                                        $output .= '</tr>';

                                        $rowspanCount++;
                                        if ($rowspanCount == $rowspansGenerales[$cptCompetence]) $rowspanCount = 0;
                                    }
                                }
                            }
                        @endphp
                        {!! $output !!}
                    @else
                        <tr>
                            <td colspan="6" class="px-4 py-4 font-bold text-center">Aucune donnée disponible</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- ===== Tableau Compétences Particulières ===== --}}
        <div class="text-sm w-full p-0 relative overflow-x-auto my-2">
            <h2 class="font-bold text-lg mb-2">Compétences Particulières</h2>
            <table class="w-full border-t mb-3">
                <thead>
                    <tr class="text-xs font-black tracking-wide text-left text-white font-bold uppercase border-b bg-first-orange">
                        <th class="px-4 py-4 text-white border border-black">Compétence</th>
                        <th class="px-4 py-4 text-white border border-black">Element de compétence</th>
                        <th class="px-4 py-4 text-white border border-black">Critère</th>
                        <th class="px-4 py-4 text-white border border-black">Note /20</th>
                        <th class="px-4 py-4 text-white border border-black">
                            <abbr title="Date evaluation">Date Eva</abbr>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @if($competencesParticulieres && $competencesParticulieres->count() > 0)
                        @php
                            $output = '';
                            $rowspanCount = 0;
                            foreach ($competencesParticulieres as $cptCompetence => $competence) {
                                foreach ($competence->elementCompetences as $elementCompetence) {
                                    foreach ($elementCompetence->criteres as $cpt => $critere) {
                                        $output .= '<tr class="critereRow" id="'.$critere->id.'">';

                                        if ($rowspanCount == 0) {
                                            $output .= '<td rowspan="'.$rowspansParticulieres[$cptCompetence].'" class="px-4 py-3 border border-black text-center font-bold">'
                                                        . ($competence->nom ?? '-') . '</td>';
                                        }

                                        if ($cpt == 0) {
                                            $rowElement = count($elementCompetence->criteres);
                                            $output .= '<td rowspan="'.$rowElement.'" class="px-4 py-3 border border-black text-center font-bold">'
                                                        . ($elementCompetence->nom ?? '-') . '</td>';
                                        }

                                        $output .= '<td class="px-4 py-3 border border-black">'. ($critere->libelle ?? '-') . '</td>';

                                        $findRow = $evaluations[$critere->id] ?? null;

                                        // Note
                                        $output .= '<td class="px-4 py-3 border border-black text-center">';
                                        $output .= '<input type="number" min="0" max="20" step="0.5"
                                                        class="noteCritere border border-gray-300 p-1 w-full text-center"
                                                        value="' . ($findRow['note'] ?? '') . '" />';
                                        $output .= '</td>';

                                        // Date
                                        $output .= '<td class="px-4 py-3 border border-black text-center">';
                                        $output .= '<input type="date"
                                                           class="critereDate border border-gray-300 p-1 w-full"
                                                           value="'.($findRow['date'] ?? '').'" />';
                                        $output .= '</td>';

                                        // Observations
                                        

                                        $output .= '</tr>';

                                        $rowspanCount++;
                                        if ($rowspanCount == $rowspansParticulieres[$cptCompetence]) $rowspanCount = 0;
                                    }
                                }
                            }
                        @endphp
                        {!! $output !!}
                    @else
                        <tr>
                            <td colspan="6" class="px-4 py-4 font-bold text-center">Aucune donnée disponible</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scriptsAdditionnels')
    @include('layouts.v1.partials.swal._script')

    <script>
    function gatherInfos()
    {
        Swal.fire({
            title: 'Confirmation de l\'action ?',
            text: "Enregistrer les modifications apportées",
            icon: "info",
            confirmButtonColor: '#16A34A',
            showCancelButton: true,
            confirmButtonText: 'Je confirme !',
            cancelButtonText: 'Annuler',
            closeOnConfirm: true
        }).then((result) => {
            if (result.value) {
                var rows = document.querySelectorAll('tr.critereRow');
                var datas = [];

                rows.forEach(row => {
                    let critereId   = row.getAttribute('id');
                    let note        = row.querySelector('.noteCritere');
                    let dateCritere = row.querySelector('.critereDate');
                    let obs         = row.querySelector('.observations');

                    datas.push({
                        id: critereId,
                        note: note ? parseFloat(note.value) : null,
                        date: dateCritere ? dateCritere.value : '',
                        observations: obs ? obs.value : ''
                    });
                });

                
                let semestre = document.getElementById('selectedsemestre').value;
                Livewire.dispatch('saveDatas', {
                    datas: JSON.stringify(datas),
                    semestre: semestre
                });
            }
        });
    }
    </script>
@endsection
