<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Critere extends Model
{
    use HasFactory;
    protected $fillable = [
        "element_competence_id",
        "code",
        "libelle",
        "description",
        "competence_id",
       "niveau_etude_id",
    ];

    public function elementCompetence()
	{
	    return $this->belongsTo(ElementCompetence::class);
	}

    public function competence()
	{
	    return $this->belongsTo(Competence::class);
	}

 public function niveauetude()
	{
	    return $this->belongsTo(NiveauEtude::class);
	}

	/**
	 * Extrait le seuil de réussite (en %) depuis le libellé du critère
	 * (ex: "70%" -> 70.0). Retourne null si le libellé n'est pas un
	 * pourcentage exploitable (ex: "Reussi", "critere1").
	 */
	public function seuilPourcentage(): ?float
	{
		// ✅ Le libellé doit être ENTIÈREMENT un nombre (avec ou sans "%"),
		// pas juste contenir un chiffre quelque part (ex: "critere1" ne doit
		// pas être lu comme un seuil de 1%).
		if (preg_match('/^\s*(\d+(?:[.,]\d+)?)\s*%?\s*$/', (string) $this->libelle, $matches)) {
			return (float) str_replace(',', '.', $matches[1]);
		}

		return null;
	}
}
