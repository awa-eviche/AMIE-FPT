<?php

namespace App\Livewire\Apprenants\Competence;

use App\Models\Competence;
use App\Models\Inscription;
use App\Models\Evalute;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;

class Evaluation extends Component
{
    public $inscription_id;
    public $selectedsemestre = '';

    public function mount($inscription_id)
    {
        $this->inscription_id = $inscription_id;
    }

    // 🔵 Quand le semestre change → recharger les évaluations
    public function updatedSelectedsemestre($value)
    {
        $this->loadEvaluations($value);
    }

    // 🔵 Chargement manuel des évaluations
    public function loadEvaluations($semestre)
    {
        if (!$semestre) {
            $this->evaluations = [];
            return;
        }

        $this->evaluations = Evalute::where('inscription_id', $this->inscription_id)
            ->where('semestre', $semestre)
            ->get()
            ->keyBy(fn($item) => $item->ressource_id ?? $item->critere_id)
            ->toArray();
    }

    // 🔵 Chargement automatique
    #[Computed]
    public function evaluations()
    {
        if (!$this->selectedsemestre) return [];

        return Evalute::where('inscription_id', $this->inscription_id)
            ->where('semestre', $this->selectedsemestre)
            ->get()
            ->keyBy(fn($item) => $item->ressource_id ?? $item->critere_id)
            ->toArray();
    }

    public function render()
    {
        $apprenant = Inscription::with('classe')->find($this->inscription_id);

        if (!$apprenant || !$apprenant->classe) {
            return view('livewire.apprenant.competence.evaluation', [
                'apprenant' => null,
                'competencesGenerales' => collect(),
                'competencesParticulieres' => collect(),
                'rowspansGenerales' => [],
                'rowspansParticulieres' => [],
                'competences' => collect(),
                'rowspans' => [],
                'evaluations' => [],
                'inscription_id' => null
            ]);
        }

        $classe = $apprenant->classe;
        $user = auth()->user();

        // 🔵 Gestion formateur / chef / admin
        if ($user->hasRole('formateur')) {

            $competenceIds = DB::table('classe_formateur_competence')
                ->where('classe_id', $classe->id)
                ->where('formateur_id', $user->id)
                ->pluck('competence_id')
                ->toArray();

            $competencesGenerales = Competence::where('type', 'generale')
                ->where('niveau_etude_id', $classe->niveau_etude_id)
                ->whereIn('id', $competenceIds)
                ->with('elementCompetences.ressource')
                ->get();

            $competencesParticulieres = Competence::where('type', 'particuliere')
                ->where('niveau_etude_id', $classe->niveau_etude_id)
                ->whereIn('id', $competenceIds)
                ->with('elementCompetences.criteres')
                ->get();

        } else {

            $competencesGenerales = Competence::where('type', 'generale')
                ->where('niveau_etude_id', $classe->niveau_etude_id)
                ->with('elementCompetences.ressource')
                ->get();

            $competencesParticulieres = Competence::where('type', 'particuliere')
                ->where('niveau_etude_id', $classe->niveau_etude_id)
                ->with('elementCompetences.criteres')
                ->get();
        }

        // 🔵 Fusion pour ta table particulière
        $competences = $competencesParticulieres;

        // 🔵 Rowspans particulier
        $rowspans = [];
        foreach ($competences as $k => $c) {
            $rowspans[$k] = $c->elementCompetences->sum(fn($e) => $e->criteres->count());
        }

        // 🔵 Rowspans général
        $rowspansGenerales = [];
        foreach ($competencesGenerales as $k => $c) {
            $rowspansGenerales[$k] = $c->elementCompetences->sum(fn($e) => $e->ressource()->count());
        }

        return view('livewire.apprenant.competence.evaluation', [
            'apprenant' => $apprenant,
            'competencesGenerales' => $competencesGenerales,
            'competencesParticulieres' => $competencesParticulieres,

            // 🔥 AJOUTS QUI MANQUAIENT
            'competences' => $competences,
            'rowspans' => $rowspans,

            // Général
            'rowspansGenerales' => $rowspansGenerales,
            'rowspansParticulieres' => $rowspans,

            'evaluations' => $this->evaluations,
            'inscription_id' => $this->inscription_id,
        ]);
    }

    // 🔵 Sauvegarde des données
   #[On('saveDatas')]
public function saveDatas($datas, $semestre)
{
    if (empty($semestre)) {
        session()->flash('error', 'Sélectionnez un semestre avant d’enregistrer.');
        return;
    }

    $rows = json_decode($datas, true) ?? [];

    foreach ($rows as $row) {

        if (empty($row['id'])) continue;


        if ($row['type'] === 'critere') {

          
            if (
                empty($row['acquis']) &&
                empty($row['nonAcquis']) &&
                empty($row['date'])
            ) {
                continue;
            }

            Evalute::updateOrCreate(
                [
                    'inscription_id' => $this->inscription_id,
                    'critere_id'     => $row['id'],
                    'semestre'       => $semestre,
                ],
                [
                    'acquis'        => isset($row['acquis']) ? (bool)$row['acquis'] : false,
                    'nonAcquis'     => isset($row['nonAcquis']) ? (bool)$row['nonAcquis'] : false,
                    'date'          => $row['date'] ?? null,
                ]
            );

            continue;
        }

       
        if ($row['type'] === 'ressource') {

            if (!isset($row['note']) || $row['note'] === '') {
                continue;
            }

            Evalute::updateOrCreate(
                [
                    'inscription_id' => $this->inscription_id,
                    'ressource_id'   => $row['id'],
                    'semestre'       => $semestre,
                ],
                [
                    'note' => $row['note'],
                    'date' => $row['date'] ?? null,
                ]
            );
        }
    }

    session()->flash('message', 'Évaluations enregistrées avec succès.');
}

}
