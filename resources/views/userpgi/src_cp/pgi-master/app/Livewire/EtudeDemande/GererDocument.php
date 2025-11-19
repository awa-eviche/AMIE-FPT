<?php

namespace App\Livewire\EtudeDemande;

use App\Enums\EtatTransactionEnum;
use App\Models\Demande;
use App\Models\Document;
use App\Models\SignatureTransaction;
use App\Models\SignatureUser;
use App\Models\User;
use App\Services\SignatureService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

use function Laravel\Prompts\warning;

class GererDocument extends Component
{
    public $documents;
    public Demande $demande;
    public bool $readyToSign = false;
    public int $idDocumentToSign;
    public bool $disabled = false;
    private SignatureService $signatureService;
    public $signatures = null;
    public $transactionSEncours;
    public $lienSignature = null;
    public $warning ="";
    public $timeToConfirme = false;
    public $nombre = 1;

    public function mount(){
        $this->documents = $this->demande->documents;
      //  $this->transactionSEncours = $this->recupererTransactionEnCours();
    }


    public function recupererTransactionEnCours(){
        $transactions = $this->recupererTransaction();
        if($transactions->count() != 0){
            $this->updateBd($transactions);
            $transactions = $this->recupererTransaction();
        }
        return $transactions;

    }

    public function recupererTransaction(){
        $user = Auth::user();
        $documentIds = $this->documents->pluck('id')->toArray();
       /* $this->signatures = SignatureTransaction::where('etat', EtatTransactionEnum::COURS)
        ->where('user_id', $user->id)
        ->whereIn('document_id', $documentIds)
        ->get();

        return $this->signatures;*/
    }


    public function updateBd($signatures){
        // pour chacun des signature il faut verifier s'il vraiment à jour
        try {
            foreach ($signatures as $key => $signature) {
                $retour = $this->signatureService->verifierStatut($signature->idTransaction);
                if($retour['est_signe']){
                    $signature->etat = EtatTransactionEnum::SIGNE;
                    $signature->lien_doc_signe = $retour['lien_document'];
                    $signature->save();
                }

            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function boot(SignatureService $signatureService){
        $this->signatureService = $signatureService;
    }

    public function toggleReadyToSign(){
        return $this->readyToSign = !$this->readyToSign;
    }

    public function signer(){
        if(!$this->toggleReadyToSign()){
            $this->toggleTimeToConfirm();
        }
    }
    public function toggleTimeToConfirm(){
        return $this->timeToConfirme = !$this->timeToConfirme;

    }

    public function signerUnDocument(){
        if ($this->disabled) {
            return;
        }

        $this->disabled = true;
        $this->nombre = $this->nombre + 1;
        $this->lienSignature = "hello $this->nombre";


        $this->toggleTimeToConfirm();
        if($this->toggleReadyToSign()){
            if($this->idDocumentToSign == null){
                $this->disabled = false;
                return;
            }
            $document = Document::find($this->idDocumentToSign);


            try {
                $result = $this->signatureService->signerDocument($document, Auth::user());
                if($result["success"]){
                    // là, il faut faire les enregsitrement dans la base de données
                    SignatureTransaction::create([
                        "idTransaction" => $result["idTransaction"],
                        "lien_signature" => $result["url"],
                        "user_id" => Auth::user()->id,
                        "document_id" => $document->id,

                    ]);
                    $this->lienSignature = $result["url"];
                    return redirect()->route('demande.show', $this->demande->id);

                }else{

                    $this->warning ="Il y a eu une erreur serveur. Nous vous demandons de réessayer plus tard ou de contacter l'admin !";
                }
                //code...
            } catch (\Throwable $th) {
                Log::info($th);
                $this->warning ="Il y a eu une erreur serveur. Nous vous demandons de réessayer plus tard ou de contacter l'admin !";
            }
        }

        $this->disabled = false;

    }

    public function supprimerDocument(Document $document){
        $cheminFichier = public_path('storage/' . $document->lien_ressource);

        if (file_exists($cheminFichier)) {
            unlink($cheminFichier);
        }
        $document->delete();
        $this->documents = $this->demande->documents;

    }

    public function render()
    {
        return view('livewire.etude-demande.gerer-document');
    }
}
