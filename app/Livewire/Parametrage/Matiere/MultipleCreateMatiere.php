<?php

namespace App\Livewire\Parametrage\Matiere;

use Livewire\Component;
use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\Matiere;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;

class MultipleCreateMatiere extends Component
{
    public $metier = '';
    public $niveau = '';
    public $description = '';
    public $matieres = [['code' => '', 'nom' => '', 'coef' => '']];
    public $niveaux = [];

    protected $rules = [
        'metier' => 'required|exists:metiers,id',
        'niveau' => 'required|exists:niveau_etudes,id',
        'description' => 'required|string|max:1000',
        'matieres.*.code' => 'required|string|max:255',
        'matieres.*.nom' => 'required|string|max:255',
        'matieres.*.coef' => 'required|numeric|min:1',
    ];

    protected LogUserRepository $logUserRepository;

    public function boot(LogUserRepository $logUserRepository)
    {
        $this->logUserRepository = $logUserRepository;
    }

    public function updatedMetier($value)
    {
        $this->niveau = '';
        $this->niveaux = NiveauEtude::where('metier_id', $value)->get();
    }

    public function ajouterMatiere()
    {
        $this->matieres[] = ['code' => '', 'nom' => '', 'coef' => ''];
    }

    public function supprimerMatiere($index)
    {
        unset($this->matieres[$index]);
        $this->matieres = array_values($this->matieres);
    }

    public function enregistrer()
    {
        $this->validate();

        foreach ($this->matieres as $matiere) {
            $nouvelle = Matiere::create([
                'code' => $matiere['code'],
                'nom' => $matiere['nom'],
                'coef' => $matiere['coef'],
                'description' => $this->description,
                'niveau_etude_id' => $this->niveau,
                'metier_id' => $this->metier,
            ]);

            $this->logUserRepository->store([
                'action' => UserAction::AddMatiere,
                'model' => Model::Matiere,
                'new_object' => json_encode($nouvelle)
            ]);
        }

        return redirect()->route('matiere.index')->with('message', 'Les matières ont été enregistrées avec succès.');

        // Réinitialiser les champs
        $this->reset(['metier', 'niveau', 'description', 'matieres']);
        $this->matieres = [['code' => '', 'nom' => '', 'coef' => '']];
    }

    public function render()
    {
        $metiers = Metier::all();
        return view('livewire.parametrage.matiere.multiple-create-matiere', [
            'metiers' => $metiers,
            'niveaux' => $this->niveaux,
        ]);
    }
}
