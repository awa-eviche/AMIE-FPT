<?php

namespace App\Livewire;

use App\Models\Document;
use App\Models\Liste;
use App\Models\TypeDemande;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageTypeDemandeDocuments extends Component
{

    public $entite;
    public $monNomEntite = "type de demande";
    public bool $isAdding = false;
    public string $libelle = "";
    public string $description= "";
    public int $detailedDocumentId = 0;
    public bool $isModifying = false;
    public int $modifyingDocumentId = 0;

    public function mount(){
        if(get_class($this->entite) == "App\\Models\\Secteur"){
            $this->monNomEntite = "secteur";
        }
    }


    public function addTypeDocument(){
        $this->validate();
        $liste = new Liste();
        $liste->libelle = $this->libelle;
        $liste->valeur = $this->libelle;
        $liste->description = $this->description;
        $liste->listeable_type = get_class($this->entite);
        $liste->listeable_id = $this->entite->id;
        $liste->save();

        $this->reset(["libelle", "description", "isAdding"]);
    }


    #[On('typeDocumentUpdated')]
    public function onTypeDocumentUpdated(){
        $this->modifyingDocumentId = 0;
        $this->setIsModifying();
    }

    public function setIsModifying(){
        return $this->isModifying = $this->isModifying == true ? false : true;
    }
    public function setModifyingDocumentId(int $id){
        if(!$this->setIsModifying()){
            $this->modifyingDocumentId = 0;
        }else{
            $this->modifyingDocumentId = $id;

        }
    }

    public function setDetailedDocumentId(int $id){
        if($this->detailedDocumentId == $id){
            $this->detailedDocumentId = 0;
        }else{
            $this->detailedDocumentId = $id;

        }
    }

    public function rules()
    {
        return [
            'libelle' => 'required|min:3',
            'description' => 'required|max:255',
        ];
    }

    public function afficherDescription(){

    }

    public function toggleIsAdding(){
        $this->isAdding = $this->isAdding == true ? false : true;
        if(!$this->isAdding){
            $this->reset(["libelle", "description", "isAdding"]);
        }
    }


    public function supprimer($idTypeDocument){
        $toDelete = Liste::find($idTypeDocument);
        $toDelete->delete();
    }

    public function render()
    {
        return view('livewire.manage-type-demande-documents', [
            "documents" => $this->entite->listes
        ]);
    }
}
