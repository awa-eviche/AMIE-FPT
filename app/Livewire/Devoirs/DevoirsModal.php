<?php

namespace App\Livewire\Devoirs;

use Livewire\Component;
use App\Models\Devoir;
use App\Models\Evaluation;
use App\Models\Matiere;
use App\Models\Inscription;




class DevoirsModal extends Component
{   public $matiere;
    public $apprenant;
    public $inscriptionId;
    public $matiereId;
    public $semestre;

    public $libelle = '';
    public $note;
    public $devoirs = [];
    public ?int $editingDevoirId = null;


    protected $rules = [
        'libelle' => 'required|string|max:255',
        'note' => 'required|numeric|min:0|max:20',
    ];

    public function mount($inscriptionId, $matiereId, $semestre)
    {
        $this->inscriptionId = $inscriptionId;
        $this->matiereId = $matiereId;
        $this->semestre = $semestre;
    
      
        $this->matiere = Matiere::find($matiereId);
        $inscription = Inscription::with('apprenant')->find($inscriptionId);
        $this->apprenant = $inscription?->apprenant;
    
        $this->loadDevoirs();
    }
    

    public function loadDevoirs()
    {
        $this->devoirs = \App\Models\Devoir::where([
            'inscription_id' => $this->inscriptionId,
            'matiere_id' => $this->matiereId,
            'semestre' => $this->semestre,
        ])->get();
    }

    public function updateMoyenneCC()
{
    $moyenne = Devoir::moyenneCC(
        $this->inscriptionId,
        $this->matiereId,
        $this->semestre
    );

    Evaluation::updateOrCreate(
        [
            'inscription_id' => $this->inscriptionId,
            'matiere_id'     => $this->matiereId,
            'semestre'       => $this->semestre,
        ],
        [
            'note_cc' => $moyenne,
        ]
    );
}

public function addDevoir()
{
    $this->validate();

    if ($this->editingDevoirId) {
     
        Devoir::where('id', $this->editingDevoirId)->update([
            'libelle' => $this->libelle,
            'note' => $this->note,
        ]);
    } else {
       
        Devoir::create([
            'inscription_id' => $this->inscriptionId,
            'matiere_id' => $this->matiereId,
            'semestre' => $this->semestre,
            'libelle' => $this->libelle,
            'note' => $this->note,
        ]);
    }

    // 🔄 Recharger les devoirs
    $this->reset(['libelle', 'note', 'editingDevoirId']);
    $this->loadDevoirs();

    // 🔔 Mettre à jour la moyenne CC
    $this->updateMoyenneCC();

    // 🔔 Notifier le parent pour rafraîchir la moyenne
$this->dispatch('moyenne-cc-updated', [
    'matiereId' => $this->matiereId,
    'inscriptionId' => $this->inscriptionId,
    'semestre' => $this->semestre
]);


}



public function editDevoir($id)
{
    $devoir = Devoir::findOrFail($id);

    $this->editingDevoirId = $devoir->id;
    $this->libelle = $devoir->libelle;
    $this->note = $devoir->note;
}

public function deleteDevoir($id)
{
    Devoir::findOrFail($id)->delete();
    $this->loadDevoirs();

    $this->updateMoyenneCC();
}

public function close()
{
    $this->show = false;

    // 🔔 Dire au parent de se rouvrir
    $this->dispatch('back-to-evaluation', matiereId: $this->matiereId);

}


    public function render()
    {
        return view('livewire.devoirs.devoirs-modal');
    }
}