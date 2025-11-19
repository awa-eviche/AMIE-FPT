<?php

namespace App\Livewire\EtudeDemande;

use App\Enums\TypeNotification;
use App\Models\Agent;
use App\Models\Demande;
use App\Models\EtatWorkflow;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\WorkflowTools;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AffecterDemande extends Component
{
    use WithPagination;

    private WorkflowTools $workflowTools;
    private NotificationService $notificationService;
    public $demande;
    public bool $disabled = false;
    public EtatWorkflow $etat;
    public bool $affecting = false;
    public bool $givingInstruction = false;
    public $selectionedAgentId;
    public String $contentMessage = "";
    public $search = "";


    public function boot(WorkflowTools $workflowTools, NotificationService $notificationService){
        $this->workflowTools = $workflowTools;
        $this->notificationService = $notificationService;
    }

    public function mount(){
        $this->etat = $this->demande->etat;
        $this->selectionedAgentId = $this->demande->accorded_agent_id ?? null;
    }


    public function toggleAffecting(){
        return $this->affecting = !$this->affecting;
    }
    public function toggleGivingInstruction(){
        return $this->givingInstruction = !$this->givingInstruction;
    }

    public function affecter(){
        if ($this->disabled) {
            return;
        }

        $this->disabled = true;

        if(!$this->toggleAffecting()){
            $this->demande->accorded_agent_id = $this->selectionedAgentId;
            $this->demande->save();

            if(!$this->workflowTools->checkAccessRights($this->demande, Auth::user())){
                return redirect()->route('demande.show', $this->demande->id);
            }
            $this->workflowTools->next($this->demande, Auth::user()->id);

            // envoyer un mail à l'agent à qui on l'a affecté de façon personnel
            if($this->etat->code == 'recep_sign_valid' ){
                $message = "Une nouvelle demande vous a été affecté !Veuillez procéder à l'instruction";
                $topic = "Nouvelle affectation";

            }else{
                $message = "Cette demande vous a été affecté pour apporter des correction \n$this->contentMessage";
                $topic = "Reaffectation de demande";

                // une nouvelle affectation, avec des instructions il faut mettre une template de mail qui permet de mettre les instructions..

            }
            $accordedUser = $this->demande->accordeAgent->user;
            $this->notificationService->sendNotification([$accordedUser], $message, TypeNotification::SYSTEME,  $topic, ["route"=> "demande.show", "entity"=> $this->demande]);
            $this->notificationService->sendNotification([$accordedUser], $message, TypeNotification::EMAIL, $topic);

            // raffréchir la page
            return redirect()->route("demande.show", $this->demande->id);

        }

        $this->disabled = false;

    }


    public function render()
    {
        $instructeurs = Agent::join('users', function ($join) {
            $join->on('users.userable_id', '=', 'agents.id')
                ->where('users.userable_type', '=', 'App\\Models\\Agent');
        })
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->where(function($query) {
            $query->where('roles.code', '=', 'abo')
                  ->orWhere('roles.code', '=', 'rbi')
                  ->orWhere('roles.code', '=', 'abi')
                  ->orWhere('roles.code', '=', 'rbo');
        })
        ->select('roles.name as role_name', 'agents.*','users.*')
        ->paginate(10);

        return view('livewire.etude-demande.affecter-demande', compact('instructeurs'));
    }
}
