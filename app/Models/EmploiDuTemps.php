<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploiDuTemps extends Model
{
    use HasFactory;

    protected $table = 'emploi_du_temps';

    protected $fillable = [
        'classe_id',
        'etablissement_id',
        'annee_academique_id',
        'type_planning',
        'semaine',
        'semestre',
        'statut',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    public function creneaux()
    {
        return $this->hasMany(CreneauEmploiDuTemps::class)->orderBy('jour')->orderBy('heure_debut');
    }

    public function getLibellePeriodeAttribute(): string
    {
        if ($this->type_planning === 'hebdomadaire') {
            return 'Semaine ' . $this->semaine;
        }
        return 'Semestre ' . $this->semestre;
    }
}
