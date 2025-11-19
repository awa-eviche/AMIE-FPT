<?php

namespace App\Livewire\Etablissements;

use App\Models\Apprenant;
use App\Models\Classe;
use App\Models\Commune;
use App\Models\Etablissement;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function Laravel\Prompts\select;

class GetAllApprenant extends Component
{
    public $search;
    public $selectedsexe;
    public $selectedEtablissement;
    public $selectedCommune;
    public $selectedNiveau;
    public $selectedClasse;
    public $selectedFiliere;
    public $filieres;
    public $count;

    public function setSearch(){
    }
    public function resetAll(){
        $this->selectedsexe = "";
        $this->selectedNiveau="";
        $this->search = "";
        $this->selectedEtablissement =  "";
        $this->selectedClasse =  "";
        $this->selectedFiliere="";

    }
    public function render()

    {

            $etablissementId =auth()->user()->personnel->etablissement_id;
            $apprenantsAll = Classe::query('classes')
                            ->select('classes.etablissement_id',$etablissementId)
                            ->join('inscriptions','inscriptions.classe_id','=','classes.id')
                            ->join('apprenants', 'apprenants.id','=','inscriptions.apprenant_id')
                            ->join('niveau_etudes as niveaux','niveaux.id','=','classes.niveau_etude_id')
                            ->join('metiers','metiers.id','=','niveaux.metier_id')
                            ->join('filieres','filieres.id', '=', 'metiers.filiere_id')
                            ->Where(function($query) {
                                $query->where('apprenants.sexe','like', '%'. $this->selectedsexe.'%');
                                if ($this->selectedNiveau) {
                                    $query->Where('niveaux.id',$this->selectedNiveau);
                                }
                                if ($this->selectedClasse) {
                                    $query->Where('classes.id',$this->selectedClasse);
                                }
                                if ($this->selectedFiliere) {
                                    $query->Where('filieres.id',$this->selectedFiliere);
                                }
                                
                                $query->where('apprenants.isDeleted', 0);
                                                    
                            });
                            $this->count = $apprenantsAll->count();
                            $this->filieres = $apprenantsAll->select('filieres.*')->get()->unique('id');
                            $niveaux = $apprenantsAll->select('niveaux.*')->get()->unique('id');
                            $classes = $apprenantsAll->select('classes.*')->get()->unique('id');
                            $apprenants = $apprenantsAll->select('apprenants.*','niveaux.nom as niveauName', 'classes.libelle as classeName' )->distinct(['apprenants.id'])->paginate(50);
            
            return view('livewire.etablissements.get-all-apprenant', compact('apprenants','niveaux','classes'));   
        
    }
}
