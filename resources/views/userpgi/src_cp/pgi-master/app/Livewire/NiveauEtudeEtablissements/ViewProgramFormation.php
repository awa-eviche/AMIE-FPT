<?php

namespace App\Livewire\NiveauEtudeEtablissements;

use App\Models\Etablissement;
use App\Models\NiveauEtudeEtablissement;
use App\Services\NotificationService;
use App\Models\Filiere;
use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Repositories\UserRepository;
use Livewire\Component;
use Livewire\WithPagination;
use App\Enums\TypeNotification as TypeNotificationEnums;




class ViewProgramFormation extends Component
{
    use WithPagination;
    public $search = "";
    public $startLimit;
    public $count;
    public $idEtablissement;
    public $etablissement;
    private NotificationService $notificationService;
    private UserRepository $userRepository;

    // public $orderField = "";

    public function boot(
    NotificationService $notificationService,
    UserRepository $userRepository,
    ){
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
    }
    // public $orderDirection = "ASC";

    function mount()
    {
        $this->fill([
            'search' => '',
            'startLimit' => 0,
            'count' => 0
        ]);
    }

    function next()
    {
        $this->startLimit += 10;
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
        $les_metiers = [];

                $qry = NiveauEtudeEtablissement::where('etablissement_id', $this->idEtablissement);
                $this->etablissement = Etablissement::find($this->idEtablissement);
        
                if ($this->search) { 
                    $qry->whereHas('filiere', function ($query) {
                        $query->where('nom', 'like', "%{$this->search}%"); 
                    });
                }
            
                if ($qry) { 
                    $count = $qry->count(); 

                    $niveauetudeetablissements = $qry->orderBy('id', 'desc')
                        // ->offset($this->startLimit)
                        // ->limit(10)
                        ->get();
                }
            
        
        $f0=""; $ix=0;
        foreach($niveauetudeetablissements as $niv) {
            $nivE = NiveauEtude::find($niv->niveau_etude_id);
            if($nivE->metier_id != $f0) {
                $metier = Metier::find($nivE->metier_id);
                if(!isset($les_metiers[$metier->nom]))$les_metiers[$metier->nom] = []; 
                $les_metiers[$metier->nom][] = $nivE; 
            }
        }
        

               
        return  view('livewire.niveauetudeetablissement.view-program-formation', [ "niveauetudeetablissements" => $niveauetudeetablissements,
        "les_metiers" => $les_metiers,
        "approved" => $this->etablissement->approved,
        "count" => $count]);
       
    }


    public function validateProgram()
    {
        Etablissement::find($this->idEtablissement)->update(['approved' => true]);
        $message = "Programme de formation traité";
        $topic = "Traitement Programme de formation";
        $this->notificationService->sendNotification($this->userRepository->getEtablissementInfoFromUser($this->idEtablissement), $message, TypeNotificationEnums::SYSTEME, $topic);
        return redirect()->route('program.view', $this->idEtablissement)->with('success', 'Programme de formation mis à jour.');
    }
}
