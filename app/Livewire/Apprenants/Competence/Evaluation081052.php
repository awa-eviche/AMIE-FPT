<?php

namespace App\Livewire\Apprenants\Competence;

use App\Models\Competence;
use App\Models\Inscription;
use App\Models\Evalute;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Evaluation extends Component
{
    public $inscription_id;
    public $apprenant;
    public $classe;

    public $selectedsemestre= null;   // semestre choisi
    public $evaluationData = [];       // [critere_id => ['note' => X, 'date' => Y]]

    public function mount($inscription_id)
    {
        $this->inscription_id = $inscription_id;

        // Charger le semestre s'il existe en session
        $this->selectedsemestre = session()->get('selectedsemestre');
        if ($this->selectedsemestre) {
            $this->loadEvaluations($this->selectedsemestre);
        }
    }

    public function render()
    {
        $inscription = Inscription::with(['classe', 'apprenant.user'])
            ->find($this->inscription_id);

        $this->apprenant = $inscription;
        $this->classe    = $inscription?->classe;

        $competencesGenerales = collect();
        $competencesParticulieres = collect();

        if ($this->classe) {
            $competencesGenerales = Competence::where('niveau_etude_id', $this->classe->niveau_etude_id)
                ->where('type', 'generale')
                ->with('elementCompetences.criteres')
                ->get();

            $competencesParticulieres = Competence::where('niveau_etude_id', $this->classe->niveau_etude_id)
                ->where('type', 'particuliere')
                ->with('elementCompetences.criteres')
                ->get();
        }

        return view('livewire.apprenant.competence.evaluation', [
            'apprenant'                => $this->apprenant,
            'competencesGenerales'     => $competencesGenerales,
            'competencesParticulieres' => $competencesParticulieres,
        ]);
    }

    /**
     * Quand on change de semestre
     */
    public function updatedSelectedsemestre($semestre)
    {
        session()->put('selectedsemestre', $semestre);

        // Réinitialiser les champs
        $this->evaluationData = [];

        // ⚡ Si aucun semestre => on vide tout
        if (!$semestre) {
            return;
        }

        // ⚡ Charger les évaluations si semestre choisi
        $this->loadEvaluations($semestre);
    }

    private function loadEvaluations($semestre)
    {
        $this->evaluationData = []; // reset

        $evals = Evalute::where('inscription_id', $this->inscription_id)
            ->where('semestre', (int)$semestre)
            ->get();

        foreach ($evals as $e) {
            $this->evaluationData[$e->critere_id] = [
                'note' => $e->note,
                'date' => $e->date ? Carbon::parse($e->date)->format('Y-m-d') : '',
            ];
        }
    }

    /**
     * Sauvegarder les notes et dates
     */
    public function saveDatas()
    {
        $semestre = $this->selectedsemestre;

        if (!$semestre) {
            session()->flash('error', 'Veuillez sélectionner un semestre.');
            return;
        }

        if (empty($this->evaluationData)) {
            session()->flash('error', 'Aucune donnée à enregistrer.');
            return;
        }

        $savedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($this->evaluationData as $critereId => $data) {
                $note = $data['note'] ?? null;

                if (!$critereId || $note === null || !is_numeric($note)) {
                    continue;
                }

                $date = !empty($data['date']) ? Carbon::parse($data['date'])->format('Y-m-d') : null;

                Evalute::updateOrCreate(
                    [
                        'inscription_id' => $this->inscription_id,
                        'critere_id'     => $critereId,
                        'semestre'       => $semestre,
                    ],
                    [
                        'note' => (float) $note,
                        'date' => $date,
                    ]
                );

                $savedCount++;
            }

            DB::commit();
            session()->flash('message', "Évaluations enregistrées avec succès ({$savedCount}).");

            // Recharger les notes du semestre choisi
            $this->loadEvaluations($semestre);

        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', "Erreur lors de l'enregistrement : " . $e->getMessage());
        }
    }
}
