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

    /**
     * Construit la grille horaire avec fusion des lignes (rowspan).
     * Retourne [indexHeure][jour] => ['rowspan' => n, 'creneaux' => Collection] pour la cellule de début,
     * false pour les cellules couvertes par un créneau (à ne pas afficher), absent pour une cellule vide.
     */
    public static function grille($parJour, array $heures, array $jours): array
    {
        $premiere = (int) substr($heures[0], 0, 2);
        $nb       = count($heures);
        $grille   = [];

        foreach ($jours as $jour) {
            $items = collect($parJour->get($jour, collect()))
                ->map(function ($cr) use ($premiere, $nb) {
                    $debut  = (int) substr($cr->heure_debut, 0, 2) - $premiere;
                    $hFin   = (int) substr($cr->heure_fin, 0, 2);
                    $mFin   = (int) substr($cr->heure_fin, 3, 2);
                    // Fin réelle (exclusive) et fin affichée qui inclut la ligne de l'heure de fin (08h–10h => 08, 09, 10)
                    $finReelle = max($debut + 1, $hFin + ($mFin > 0 ? 1 : 0) - $premiere);
                    $fin       = min($nb, max($finReelle, $hFin - $premiere + 1));
                    return ['cr' => $cr, 'debut' => $debut, 'finReelle' => $finReelle, 'fin' => $fin];
                })
                ->filter(fn ($i) => $i['debut'] >= 0 && $i['debut'] < $nb)
                ->sortBy('debut')
                ->values();

            // Regroupe les créneaux qui se chevauchent dans un même bloc
            $blocs = [];
            foreach ($items as $item) {
                $dernier = count($blocs) - 1;
                if ($dernier >= 0 && $item['debut'] < $blocs[$dernier]['finReelle']) {
                    $blocs[$dernier]['fin']       = max($blocs[$dernier]['fin'], $item['fin']);
                    $blocs[$dernier]['finReelle'] = max($blocs[$dernier]['finReelle'], $item['finReelle']);
                    $blocs[$dernier]['creneaux']->push($item['cr']);
                } else {
                    // Le créneau suivant commence à l'heure de fin du précédent : on libère cette ligne
                    if ($dernier >= 0) {
                        $blocs[$dernier]['fin'] = min($blocs[$dernier]['fin'], $item['debut']);
                    }
                    $blocs[] = ['debut' => $item['debut'], 'fin' => $item['fin'], 'finReelle' => $item['finReelle'], 'creneaux' => collect([$item['cr']])];
                }
            }

            foreach ($blocs as $bloc) {
                $grille[$bloc['debut']][$jour] = ['rowspan' => $bloc['fin'] - $bloc['debut'], 'creneaux' => $bloc['creneaux']];
                for ($i = $bloc['debut'] + 1; $i < $bloc['fin']; $i++) {
                    $grille[$i][$jour] = false;
                }
            }
        }

        return $grille;
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
