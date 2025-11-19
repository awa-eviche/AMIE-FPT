<?php

namespace App\Livewire;

use Livewire\Component;

class TypeDocumentForm extends Component
{
    public $document;
    public string $libelle;
    public string $description;

    public $newDocument;

    public function mount(){
            $this->newDocument = [
            "libelle" => $this->document->libelle,
            "description" => $this->document->description,
        ];
    }

    public function saveModification(){
        $this->validate([
            'newDocument.libelle' => 'required',
            'newDocument.description' => 'required',
        ]);

        $this->document->libelle = $this->newDocument['libelle'];
        $this->document->valeur = $this->newDocument['libelle'];
        $this->document->description = $this->newDocument['description'];
        $this->document->save();
        $this->dispatch('typeDocumentUpdated');
    }

    public function render()
    {
        return view('livewire.type-document-form');
    }
}
