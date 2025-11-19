<?php

namespace App\Livewire\Demandes;

use App\Models\Document;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class EditDemande extends Component
{

    use WithFileUploads;

    public $demande;
    public $documents;
    public $donnees = [
        "libelle" => ""
    ];
    public $nomFichier = "";
    public $fichier;


    public function mount(){
        $this->documents = $this->demande->documents;
        $this->donnees["libelle"] = $this->demande->libelle;
    }


    public function render()
    {
        return view('livewire.demandes.edit-demande');
    }




    public function addDocument()
    {
        $documentToUpload = new Document();
        $this->validate([
            'nomFichier' => 'required|string',
        ], [
            'nomFichier.required' => 'Il faut nous le nom de fichier',
        ]);

        $nomFichierUnique = $this->nomFichier ."_" .uniqid() . '.' . pathinfo($this->fichier->getFileName(), PATHINFO_EXTENSION);
        $cheminFinal = "public/demandes";

        Log::info("chemin final\n");
        Log::info($cheminFinal);
        Log::info("\nnom fichier unique\n");
        Log::info($nomFichierUnique);

        $this->fichier->storeAs($cheminFinal, $nomFichierUnique);

        $documentToUpload->nom = $nomFichierUnique;

        $documentToUpload->lien_ressource = "demandes/{$nomFichierUnique}";
        $documentToUpload->description = "";
        $documentToUpload->documentable_id = $this->demande->id;
        $documentToUpload->documentable_type = "App\\Models\\Demande";
        $documentToUpload->save();

        $this->documents = $this->demande->documents;
        sleep(1);

    }


    public function enregistrer(){
        $this->validate([
            'donnees.libelle' => 'required|string',
        ], [
            'donnees.required' => 'Le libelle est obligatoire',
        ]);

        $this->demande->libelle = $this->donnees['libelle'];
        $this->demande->save();
        // return $this->redirect()
        return redirect()->route('demande.show', $this->demande->id);

    }




    /**
     * supprime tout simplement un document
     */
    public function supprimerDocument(Document $document){
        $cheminFichier = public_path('storage/' . $document->lien_ressource);

        if (file_exists($cheminFichier)) {
            unlink($cheminFichier);
        }
        $document->delete();
        $this->documents = $this->demande->documents;

    }





}
