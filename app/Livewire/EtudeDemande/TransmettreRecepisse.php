<?php

namespace App\Livewire\EtudeDemande;

use App\Enums\EtatTransactionEnum;
use App\Enums\TypeNotification;
use App\Models\Document;
use App\Services\NotificationService;
use App\Services\SignatureService;
use App\Services\WorkflowTools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class TransmettreRecepisse extends Component
{
    public $demande;
    private SignatureService $signatureService;
    public $transactions;
    public $lienDocSigner = null;
    private WorkflowTools $workflowTools;
    private NotificationService $notificationService;
    public bool $isCharging = false;


    public function boot(SignatureService $signatureService, WorkflowTools $workflowTools, NotificationService $notificationService){
        $this->signatureService = $signatureService;
        $this->workflowTools = $workflowTools;
        $this->notificationService = $notificationService;
    }



    public function mount(){
        $this->getGoodTransactionLink();
    }

    public function getGoodTransactionLink(){
        foreach ($this->transactions as $key => $transaction) {
            if($transaction->etat == EtatTransactionEnum::SIGNE && $transaction->lien_doc_signe !=null){
                $this->lienDocSigner = $transaction->lien_doc_signe;
                break;
            }

        }
    }


    public function transmettre(){

        $this->isCharging = true;

        $response = $this->signatureService->recupererDocument($this->lienDocSigner);
        if($response["success"]){
            if($this->demande->etat->code == "conforme_1"){
                $nomFichierLocal = "Recepisse_de_Depot_signe ". uniqid() . '.pdf';
                $topic = "recepisse de dépot";
                $message ="Veuillez recevoir le recépissé de dépot de votre demande.." ;

            }
            else{
                $nomFichierLocal = "Recepisse_de_Rejet_signe ". uniqid() . '.pdf';
                $message ="Nous avons le regret de vous annoncer que votre n'a pas été validé. ci joint le recépissé de rejet" ;
                $topic = "recepisse de rejet";

            }

            Storage::put("public/demandes/".$nomFichierLocal, $response['document']);
            $recepisseSigne = new Document();

            $recepisseSigne->nom = $nomFichierLocal;

            $recepisseSigne->lien_ressource = "demandes/{$nomFichierLocal}";
            $recepisseSigne->description = "le recepissé déjà signé";
            $recepisseSigne->documentable_id = $this->demande->id;
            $recepisseSigne->documentable_type = "App\\Models\\Demande";
            $recepisseSigne->save();

            $this->workflowTools->next($this->demande, Auth::user()->id);


            $this->notificationService->sendNotification([$this->demande->entreprise->user], $message, TypeNotification::EMAIL, $topic, null, ["app/public/{$recepisseSigne->lien_ressource}"]);
            $this->notificationService->sendNotification([$this->demande->entreprise->user], $message, TypeNotification::SYSTEME, $topic, null);

            return redirect()->route("demande.show", $this->demande->id);

        }else{
            // il y a un bleme
        }


    }

    public function render()
    {
        return view('livewire.etude-demande.transmettre-recepisse');
    }
}
