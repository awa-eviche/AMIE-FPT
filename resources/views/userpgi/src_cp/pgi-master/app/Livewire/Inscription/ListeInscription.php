<?php

namespace App\Livewire\Inscription;
use Illuminate\Support\Facades\Session;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Evaluation;
use App\Models\Matiere;
use Livewire\Component;

class ListeInscription extends Component
{
    public $search = "";
    public $startLimit;
    public $count;
    public $evaluationId;
    public $classe;
    public $currentApprenant;
    public $selectedApprenant;
    public $currentClasse;
    public $classes;
    public $evaluations;
    public $apprenants;
    public $matieres;
    public $inscription;
    public $selectedsemestre;
    public $evaluationExists;
    public $semestreFilter;
    public $estEnCreationEvaluation = false;
    public $showModal = false;

    public function mount()
    {
        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            $this->classes = Classe::where('etablissement_id', auth()->user()->personnel->etablissement_id)->get();
        } else {
            $this->classes = Classe::all();
        }
       
        $this->selectedsemestre = session()->get('selectedsemestre', '');

        $this->classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $this->currentClasse = $this->classe ? Classe::find($this->classe) : null;
        $this->apprenants = $this->classe ? Inscription::where('classe_id', session()->get('currentClasse'))->get() : [];
        $this->matieres = $this->classe ? Matiere::where('niveau_etude_id', optional($this->currentClasse)->niveau_etude->id)->get() : [];
        $this->selectedApprenant = session()->get('selectedApprenant', null);
        $this->currentApprenant = null;

        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0,
        ]);
    }

    public function updatedSelectedSemestre($value)
    {
        Session::put('selectedsemestre', $value);
    }

    

    public function loadCompetences($id)
    {
        
        $this->selectedApprenant = $id;
        session()->put('selectedApprenant', $this->selectedApprenant);
        return redirect()->route('inscription.index');
        
    }

    public function next()
    {
        $this->startLimit += 10;
    }

    public function prev()
    {
        $this->startLimit -= 10;
    }

    public function updatingSearch()
    {
        $this->startLimit = 0;
    }

    public function updatedClasse()
    {
        session()->forget('selectedApprenant'); 
        session()->put('currentClasse', $this->classe);
        return redirect()->route('inscription.index');
    }

    public function calculerMoyenne($note_cc, $note_composition)
    {
        // Vérifier si les notes sont valides
        if ($note_cc !== null && $note_composition !== null) {
          
            $moyenne = ($note_cc + $note_composition) / 2;
            return $moyenne;
        } else {
          
            return null;
        }
    }


    

    public function render()
    {
        $inscriptionId = null;
        $evaluationId = null;
        $matieres = null;
        $evalu = null;


        
        if ($this->selectedApprenant) {
            $apprenantId = $this->selectedApprenant;
            $inscription = Inscription::find($apprenantId);
            $evaluationId = Evaluation::find($apprenantId);

            if ($inscription) {
                $this->currentApprenant = $inscription;
                $inscriptionId = $inscription->id;

                $qry = Evaluation::where('inscription_id', $inscriptionId);
                if ($this->semestreFilter) {
                    $qry->where('semestre', $this->semestreFilter);
                }

                $evalu = $qry->get();
                $matieres = Matiere::where('niveau_etude_id', optional($inscription->classe)->niveau_etude->id)->get();
            }

             // Calculer la moyenne pour chaque évaluation
             foreach ($evalu as $evaluation) {
                $evaluation->moyenne = $this->calculerMoyenne($evaluation->note_cc, $evaluation->note_composition);
            }
        }

        return view('livewire.inscription.liste-inscription', [
            "apprenants" => $this->apprenants,
            "inscriptionId" => $inscriptionId,
            "evaluationId" => $evaluationId,
            "matieres" => $matieres,
            "evalu" => $evalu,
            'currentApprenant' => $this->currentApprenant,
        ]);
    }
}
