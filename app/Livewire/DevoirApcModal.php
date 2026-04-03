<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ressource;
use App\Models\DevoirAPC;
use App\Models\Inscription;

class DevoirApcModal extends Component
{
    public $showModal = false;
    public $ressourceId;

    public $libelle;
    public $notes = [];

    public $inscriptions = [];
    public $devoirs = [];

    protected $rules = [
        'libelle' => 'required|string',
    ];

    public function open($ressourceId)
    {
        $this->ressourceId = $ressourceId;
        $this->showModal = true;

        $this->loadData();
    }

    public function loadData()
    {
        $ressource = Ressource::findOrFail($this->ressourceId);

        $this->inscriptions = Inscription::with('apprenant')
            ->where('classe_id', $ressource->classe_id)
            ->get();

        $this->devoirs = DevoirAPC::with('inscription.apprenant')
            ->where('ressource_id', $this->ressourceId)
            ->get()
            ->groupBy('libelle');
    }

    public function saveDevoir()
    {
        $this->validate();

        foreach ($this->notes as $inscriptionId => $note) {
            if ($note === null || $note === '') {
                continue;
            }

            DevoirAPC::create([
                'libelle' => $this->libelle,
                'note' => $note,
                'ressource_id' => $this->ressourceId,
                'inscription_id' => $inscriptionId,
            ]);
        }

        $this->reset(['libelle', 'notes']);
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.devoir-apc-modal');
    }
}
