<?php

namespace App\Livewire\Apprenants\Competence;

use App\Models\Competence;
use App\Models\Critere;
use App\Models\Inscription;
use App\Models\Evalute;
use Livewire\Component;
use Livewire\Attributes\On;

class Evaluation extends Component
{
    public $inscription_id;
    public $apprenant;
    public $classe;
    public $selectedsemestre;
    public $evaluationData = [];

    public function mount($inscription_id)
    {
        $this->inscription_id = $inscription_id;
    }

    public function render()
    {
        $apprenant = Inscription::with('classe')->find($this->inscription_id);

        if (!$apprenant || !$apprenant->classe) {
            return view('livewire.apprenants.competence.evaluation', [
                'apprenant' => null,
                'competencesGenerales' => collect(),
                'competencesParticulieres' => collect(),
                'rowspansGenerales' => [],
                'rowspansParticulieres' => [],
                'evaluations' => [],
                'inscription_id' => null,
            ]);
        }

        // Compétences générales
        $competencesGenerales = Competence::where('niveau_etude_id', $apprenant->classe->niveau_etude_id)
            ->where('type', 'generale')
            ->with('elementCompetences.criteres')
            ->get();

        $rowspansGenerales = [];
        foreach ($competencesGenerales as $key => $competence) {
            $rowspan = 0;
            foreach ($competence->elementCompetences as $elem) {
                $rowspan += $elem->criteres->count();
            }
            $rowspansGenerales[$key] = $rowspan;
        }

        // Compétences particulières
        $competencesParticulieres = Competence::where('niveau_etude_id', $apprenant->classe->niveau_etude_id)
            ->where('type', 'particuliere')
            ->with('elementCompetences.criteres')
            ->get();

        $rowspansParticulieres = [];
        foreach ($competencesParticulieres as $key => $competence) {
            $rowspan = 0;
            foreach ($competence->elementCompetences as $elem) {
                $rowspan += $elem->criteres->count();
            }
            $rowspansParticulieres[$key] = $rowspan;
        }

        // Evaluations existantes
        $evaluations = Evalute::where('inscription_id', $this->inscription_id)
            ->get()
            ->keyBy('critere_id') // plus simple pour la vue
            ->toArray();

        return view('livewire.apprenant.competence.evaluation', [
            'apprenant'                => $apprenant,
            'competencesGenerales'     => $competencesGenerales,
            'competencesParticulieres' => $competencesParticulieres,
            'rowspansGenerales'        => $rowspansGenerales,
            'rowspansParticulieres'    => $rowspansParticulieres,
            'evaluations'              => $evaluations,
            'inscription_id'           => $this->inscription_id,
        ]);
    }

  #[On('saveDatas')]
public function saveDatas($datas, $semestre)
{
    $semestre = $semestre ?: null;
    $dataArray = json_decode($datas, true);

    foreach ($dataArray as $row) {
        if (empty($row['id'])) continue;

        // Ne pas enregistrer si aucune note n'est saisie
        if (!isset($row['note']) || $row['note'] === '') continue;

        $critereId = $row['id'];

        // Inférer le type depuis la compétence associée
        $critere = Critere::with('elementCompetence.competence')->find($critereId);

        Evalute::updateOrCreate(
            [
                'inscription_id' => $this->inscription_id,
                'critere_id'     => $critereId,
                'semestre'       => $semestre,
            ],
            [
                'note'         => $row['note'],
                'date'         => $row['date'] ?? null,
                'observations' => $row['observations'] ?? null,
            ]
        );
    }

    session()->flash('message', 'Évaluations enregistrées avec succès.');
    return redirect()->route('competence.manage.index', $this->inscription_id);
}

}
