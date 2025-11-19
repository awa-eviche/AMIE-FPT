<div class="py-4">
    <div class="w-full rounded-lg shadow-xs p-0">
        <div class="flex flex-col sm:flex-row w-full justify-between sm:items-center">
            {{-- Afficher l'apprenant --}}
            <div class="text-poppins_black font-bold text-lg">
                @if($apprenant && $apprenant->apprenant && $apprenant->apprenant->user)
                    {{ $apprenant->apprenant->user->prenom .' '. $apprenant->apprenant->user->nom }}
                    [{{ $apprenant->apprenant->user->matricule ?? '-' }}]
                @else
                    <span class="text-red-600">Aucun apprenant trouvé.</span>
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

        <div class="text-sm w-full p-0 relative overflow-x-auto my-2">
            <table class="w-full border-t mb-3">
                <thead>
                    <tr class="text-xs font-black tracking-wide text-left text-white font-bold uppercase border-b bg-first-orange">
                        <th class="px-4 py-4 text-white border border-black">Compétence</th>
                        <th class="px-4 py-4 text-white border border-black">Element de compétence</th>
                        <th class="px-4 py-4 text-white border border-black">Critère</th>
                        <th class="px-4 py-4 text-white border border-black">Acquis</th>
                        <th class="px-4 py-4 text-white border border-black">
                            <abbr title="En Cours d'Acquisition">ECA</abbr>
                        </th>
                        <th class="px-4 py-4 text-white border border-black">Non acquis</th>
                        <th class="px-4 py-4 text-white border border-black">
                            <abbr title="Date evaluation">Date Eva</abbr>
                        </th>
                        <th class="px-4 py-4 text-white border border-black">Observations</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @if($competences && $competences->count() > 0)
                        @php
                            $output = '';
                            $rowspanCount = 0;

                            // Boucle sur chaque compétence
                            foreach ($competences as $cptCompetence => $competence) {

                                // Boucle sur chaque élément de compétence
                                foreach ($competence->elementCompetences as $elementCompetence) {
                                    
                                    // Boucle sur chaque critère
                                    foreach ($elementCompetence->criteres as $cpt => $critere) {

                                        $output .= '<tr class="critereRow" id="'.$critere->id.'">';

                                        // Affichage de la compétence (une seule fois par bloc)
                                        if ($rowspanCount == 0) {
                                            $output .= '<td rowspan="'.$rowspans[$cptCompetence].'"
                                                           class="px-4 py-3 border border-black text-center font-bold">'
                                                         . ($competence->nom ?? '-')
                                                         . '</td>';
                                        }

                                        // Affichage de l'élément de compétence (une seule fois par groupe de critères)
                                        if ($cpt == 0) {
                                            $rowElement = count($elementCompetence->criteres);
                                            $output .= '<td rowspan="'.$rowElement.'"
                                                           class="px-4 py-3 border border-black text-center font-bold">'
                                                         . ($elementCompetence->nom ?? '-')
                                                         . '</td>';
                                        }

                                        // Critère
                                        $output .= '<td class="px-4 py-3 border border-black">'
                                                   . ($critere->libelle ?? '-')
                                                   . '</td>';

                                        // Chercher s'il y a une évaluation existante
                                        $findRow = null;
                                        foreach ($evaluations as $evaluation) {
                                            if ($evaluation['inscription_id'] == $inscription_id
                                                && $evaluation['critere_id'] == $critere->id) {
                                                $findRow = $evaluation;
                                                break;
                                            }
                                        }

                                        // Acquis
                                        $output .= '<td class="px-4 py-3 border border-black text-center font-bold text-lg text-green-600">';
                                        if ($findRow) {
                                            $output .= '<input class="form-check-input acquis"
                                                               type="checkbox"
                                                               '.($findRow['acquis'] ? 'checked' : '').' />';
                                        } else {
                                            $output .= '<input class="form-check-input acquis" type="checkbox" />';
                                        }
                                        $output .= '</td>';

                                        // En Cours
                                        $output .= '<td class="px-4 py-3 border border-black text-center font-bold text-lg text-red-600">';
                                        if ($findRow) {
                                            $output .= '<input class="form-check-input encours"
                                                               type="checkbox"
                                                               '.($findRow['enCours'] ? 'checked' : '').' />';
                                        } else {
                                            $output .= '<input class="form-check-input encours" type="checkbox" />';
                                        }
                                        $output .= '</td>';

                                        // Non acquis
                                        $output .= '<td class="px-4 py-3 border border-black text-center font-bold text-lg text-red-600">';
                                        if ($findRow) {
                                            $output .= '<input class="form-check-input nonAcquis"
                                                               type="checkbox"
                                                               '.($findRow['nonAcquis'] ? 'checked' : '').' />';
                                        } else {
                                            $output .= '<input class="form-check-input nonAcquis" type="checkbox" />';
                                        }
                                        $output .= '</td>';

                                        // Date
                                        $output .= '<td class="px-4 py-3 border border-black text-center font-bold">';
                                        if ($findRow && $findRow['date']) {
                                            $output .= '<input type="date"
                                                               class="critereDate border border-gray-300 p-1 w-full"
                                                               value="'.date('Y-m-d', strtotime($findRow['date'])).'" />';
                                        } else {
                                            $output .= '<input type="date" class="critereDate border border-gray-300 p-1 w-full" />';
                                        }
                                        $output .= '</td>';

                                        // Observations
                                        $output .= '<td class="px-4 py-3 border border-black text-center font-bold">';
                                        if ($findRow && $findRow['observations']) {
                                            $output .= '<input type="text"
                                                               class="observations border border-gray-300 p-1 w-full"
                                                               value="'.htmlspecialchars($findRow['observations']).'" />';
                                        } else {
                                            $output .= '<input type="text"
                                                               placeholder="Ex: Observations"
                                                               class="observations border border-gray-300 p-1 w-full" />';
                                        }
                                        $output .= '</td>';

                                        $output .= '</tr>'; // fin du <tr>

                                        // Incrémente le rowspanCount
                                        $rowspanCount++;
                                        if ($rowspanCount == $rowspans[$cptCompetence]) {
                                            $rowspanCount = 0;
                                        }
                                    }
                                }
                            }
                        @endphp

                        {!! $output !!}

                    @else
                        <tr>
                            <td colspan="8" class="px-4 py-4 font-bold text-lg text-center">
                                Aucune donnée disponible
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            {{-- Pagination manuelle si besoin --}}
            @if($count > 10)
                <div class="flex justify-start items-center mt-5">
                    <button type="button"
                            class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center"
                            wire:click="prev"
                            @if($startLimit==0) disabled @endif>
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none">
                            <path d="M0.982423 8.69351C-0.0296571 7.89277 -0.0296574 6.35734 0.982422 5.55659L7.00906 0.788418C8.32029 -0.249004 10.25 0.684883 10.25 2.35688V11.8932C10.25 13.5652 8.32029 14.4991 7.00906 13.4617L0.982423 8.69351Z" fill="black"/>
                        </svg>
                    </button>

                    <span class="text-md text-black mx-3">
                        {{ min($count, $startLimit+1) }}
                        à
                        {{ min($startLimit+10, $count) }}
                        sur {{ $count }}
                    </span>

                    <button type="button"
                            class="bg-white px-4 rounded-md border-white py-3 flex text-black text-sm text-center shadow-lg items-center"
                            wire:click="next"
                            @if(($startLimit+10) >= $count) disabled @endif>
                        <svg class="w-4 h-4" width="11" height="14" viewBox="0 0 11 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.0176 5.55649C11.0297 6.35723 11.0297 7.89266 10.0176 8.69341L3.99094 13.4616C2.67971 14.499 0.75 13.5651 0.75 11.8931L0.75 2.35677C0.75 0.684774 2.67971 -0.249114 3.99094 0.788308L10.0176 5.55649Z" fill="black"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

@section('scriptsAdditionnels')
    {{-- Si vous avez un partial pour SweetAlert --}}
    @include('layouts.v1.partials.swal._script')

    <script>
        // Pour empêcher qu'un checkbox "annule" les autres dans le même critère,
        // vous pouvez adapter cette logique si vous ne voulez pas de mutuelle exclusion
        $(function(){
            $('input[type="checkbox"]').change(function() {
                // Si je décoche, je reste décoché
                if(!$(this).is(':checked')) {
                    $(this).prop('checked', false);
                    return;
                }
                // Sinon, je décoche les autres checkboxes qui ont le même "name" (si vous avez un name commun)
                // Sauf que, dans votre code, le name n'est pas forcément le même. Ajustez au besoin.
            });
        });

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
                        let acquis      = row.querySelector('.acquis');
                        let enCours     = row.querySelector('.encours');
                        let nonAcquis   = row.querySelector('.nonAcquis');
                        let dateCritere = row.querySelector('.critereDate');
                        let obs         = row.querySelector('.observations');

                        datas.push({
                            id: critereId,
                            acquis: acquis ? acquis.checked : false,
                            enCours: enCours ? enCours.checked : false,
                            nonAcquis: nonAcquis ? nonAcquis.checked : false,
                            date: dateCritere ? dateCritere.value : '',
                            observations: obs ? obs.value : ''
                        });
                    });

                    // Livewire 3 => dispatch
                    // Si vous êtes en Livewire 2, on ferait : Livewire.emit('saveDatas', JSON.stringify(datas));
                    Livewire.dispatch('saveDatas', {
                        datas: JSON.stringify(datas)
                    });
                }
            });
        }
    </script>
@endsection
