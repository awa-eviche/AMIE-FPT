<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreneauEmploiDuTemps extends Model
{
    use HasFactory;

    protected $table = 'creneaux_emploi_du_temps';

    protected $fillable = [
        'emploi_du_temps_id',
        'personnel_etablissement_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'salle',
        'matiere_id',
        'ressource_id',
        'competence_id',
        'element_competence_id',
    ];

    public function emploiDuTemps()
    {
        return $this->belongsTo(EmploiDuTemps::class);
    }

    public function formateur()
    {
        return $this->belongsTo(PersonnelEtablissement::class, 'personnel_etablissement_id');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function elementCompetence()
    {
        return $this->belongsTo(ElementCompetence::class);
    }

    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }

    public function competence()
    {
        return $this->belongsTo(Competence::class);
    }

    public function getContenuAttribute(): string
    {
        if ($this->matiere_id) {
            return $this->matiere->nom ?? '';
        }
        if ($this->ressource_id) {
            return $this->ressource->nom ?? '';
        }
        if ($this->competence_id) {
            return $this->competence->nom ?? '';
        }
        if ($this->element_competence_id) {
            return $this->elementCompetence->nom ?? '';
        }
        return '';
    }
}
