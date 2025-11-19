<?php

namespace App\Livewire\EtudeDemande;

use App\Models\Demande;
use App\Models\Document;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\WithFileUploads;

class GenererRecepisse extends Component
{
    public Demande $demande;
    public bool $isGeneratedRecepisse = false;
    public bool $disabled = false;

    public function mount(){
        foreach ($this->demande->documents as $document) {
           /* if (strpos($document->nom, 'Recepisse_de_Depot') === 0) {
                $this->isGeneratedRecepisse = true;
                break;
            }*/
        }

    }

    public function genererRecepisser(){

     /*   $nomFichier = 'Recepisse_de_Depot_' . uniqid() . '.pdf';

        $pdf = Pdf::loadView('pdf.recepisse-depot', ["demande"=> $this->demande]);

        $document = new Document();
        $document->nom = $nomFichier;
        $document->documentable_type = "App\\Models\\Demande";
        $document->documentable_id = $this->demande->id;
        $document->lien_ressource = 'demandes/' . $nomFichier;
        $document->description = "Le recepisse de dépot d'une demande";

        $pdf->save("demandes/".$nomFichier, 'public');

        // Enregistrez les détails du document dans la base de données
        $document->save();

        $pdf->stream($nomFichier);
        */
        

    }

    public function render()
    {
        return view('livewire.etude-demande.generer-recepisse');
    }
}
