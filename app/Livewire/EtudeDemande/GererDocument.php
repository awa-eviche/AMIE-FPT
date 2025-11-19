<?php

namespace App\Livewire\EtudeDemande;

use App\Enums\EtatTransactionEnum;
use App\Models\Demande;
use App\Models\Document;
use App\Models\SignatureTransaction;
use App\Services\SignatureService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Livewire\Component;

class GererDocument extends Component
{
    public Collection $documents;
    public Demande $demande;

    public ?int $idDocumentToSign = null;
    public bool $readyToSign = false;
    public bool $disabled = false;
    public bool $timeToConfirme = false;

    public int $nombre = 1;
    public ?string $lienSignature = null;
    public string $warning = "";

    public ?Collection $signatures = null;
    public $transactionSEncours;

    private SignatureService $signatureService;

    public function booted(SignatureService $signatureService)
    {
        $this->signatureService = $signatureService;
    }

    public function mount()
    {
        $this->documents = $this->demande->documents;
    }

    public function toggleReadyToSign(): bool
    {
        return $this->readyToSign = !$this->readyToSign;
    }

    public function toggleTimeToConfirm(): bool
    {
        return $this->timeToConfirme = !$this->timeToConfirme;
    }

    public function signer()
    {
        if (!$this->toggleReadyToSign()) {
            $this->toggleTimeToConfirm();
        }
    }

    public function signerUnDocument()
    {
        if ($this->disabled) {
            return;
        }

        $this->disabled = true;
        $this->nombre++;
        $this->lienSignature = "hello $this->nombre";

        $this->toggleTimeToConfirm();

        if ($this->toggleReadyToSign()) {
            if ($this->idDocumentToSign === null) {
                $this->disabled = false;
                return;
            }

            $document = Document::find($this->idDocumentToSign);

            if (!$document) {
                $this->warning = "Document introuvable.";
                $this->disabled = false;
                return;
            }

            try {
                $result = $this->signatureService->signerDocument($document, Auth::user());

                if ($result["success"]) {
                    SignatureTransaction::create([
                        "idTransaction" => $result["idTransaction"],
                        "lien_signature" => $result["url"],
                        "user_id" => Auth::id(),
                        "document_id" => $document->id,
                    ]);

                    $this->lienSignature = $result["url"];

                    return redirect()->route('demande.show', $this->demande->id);
                } else {
                    $this->warning = "Erreur serveur. Réessayez ou contactez l'administrateur.";
                }

            } catch (\Throwable $th) {
                Log::error("Erreur de signature : " . $th->getMessage());
                $this->warning = "Une erreur est survenue lors de la signature.";
            }
        }

        $this->disabled = false;
    }

    public function supprimerDocument(Document $document)
    {
        $cheminFichier = public_path('storage/' . $document->lien_ressource);

        if (file_exists($cheminFichier)) {
            unlink($cheminFichier);
        }

        $document->delete();

        // Refresh des documents liés à la demande
        $this->documents = $this->demande->documents;
    }

    public function recupererTransactionEnCours()
    {
        $transactions = $this->recupererTransaction();

        if ($transactions && $transactions->count()) {
            $this->updateBd($transactions);
            $transactions = $this->recupererTransaction();
        }

        return $transactions;
    }

    public function recupererTransaction()
    {
        $user = Auth::user();
        $documentIds = $this->documents->pluck('id')->toArray();

        // À activer si nécessaire
        /*
        return SignatureTransaction::where('etat', EtatTransactionEnum::COURS)
            ->where('user_id', $user->id)
            ->whereIn('document_id', $documentIds)
            ->get();
        */
    }

    public function updateBd($signatures)
    {
        foreach ($signatures as $signature) {
            try {
                $retour = $this->signatureService->verifierStatut($signature->idTransaction);

                if ($retour['est_signe']) {
                    $signature->etat = EtatTransactionEnum::SIGNE;
                    $signature->lien_doc_signe = $retour['lien_document'];
                    $signature->save();
                }
            } catch (\Throwable $th) {
                Log::error("Erreur updateBd : " . $th->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.etude-demande.gerer-document');
    }
}
