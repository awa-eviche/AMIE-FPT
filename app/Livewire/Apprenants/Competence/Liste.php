<?php

namespace App\Livewire\Apprenants\Competence;

use App\Models\Competence;
use App\Models\Evaluation;
use Livewire\Component;

class Liste extends Component
{
    public $search = "";
    public $startLimit;
    public $count;
    public $inscription_id;
    public $evaluations;
    public $inscriptions;
    public $competences;

    function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0,
            'criteres' => [],
            'evaluations' => [],
            'competences' => []
        ]);
    }

    function next()
    {
        $this->startLimit += 10 ;
    }

    function prev()
    {
        $this->startLimit -= 10;
    }

    function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function setSearch()
    {

    }

    public function render()
    {
        $this->evaluations = Evaluation::where('inscription_id',$this->inscription_id)->get()->keyBy('id')->toArray();
        $competences = Competence::where('niveauetude_id',1);
        $criteres = [];
        $rowspans = [];
        foreach ($competences->get() as $key => $competence)
        {
            $rowspan = 0;
            foreach ($competence->elementCompetences as $ec)
            {
                $rowspan +=  sizeof($ec->criteres);
                $criteres = [...$criteres,...$ec->criteres->toArray()];
            }
            $rowspans[$key] = $rowspan;
        }

        // $qry = \App\Models\Liste::join('liste_keys','listes.cle','=','liste_keys.cle')
        //                 ->where("liste_keys.libelle", "like", "%{$this->search}%")
        //                 ->orWhere('listes.cle', 'like', "%{$this->search}%")
        //                 ->orWhere('listes.valeur', 'like', "%{$this->search}%");

        $count = $competences->count();
        $this->criteres = $criteres;

        $this->count = $count;
        if($count == 0) $this->startLimit = 0;

        $this->competences = $competences->orderBy('id','asc')->offset($this->startLimit)->limit(5)->get();

        return view('livewire.apprenants.competence.liste', [
            'search' => $this->search,
            'rowspans' => $rowspans,
            'startLimit' => $this->startLimit,
            'count' => $this->count,
            'criteres' => $this->criteres,
            'evaluations' => $this->evaluations,
            'competences' => $this->competences
        ]);
    }
}
