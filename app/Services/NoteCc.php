<?php

namespace App\Services;

use App\Models\Devoir;
use App\Models\DevoirAPC;
use App\Models\Evaluation;

/**
 * Contrôle continu (moyenne des devoirs) d'un apprenant, recalculé après chaque ajout,
 * modification ou suppression de devoir.
 *
 * Une inscription appartient à une seule année : la clé (inscription, matière/ressource, semestre)
 * suffit donc à isoler l'année et le semestre.
 */
class NoteCc
{
    /**
     * PPO : met à jour devoirs.mcc et evaluations.note_cc (toutes les lignes de la clé, doublons
     * compris). Sans devoir noté, le CC est vidé (null) : la matière n'entre alors pas dans la
     * moyenne, au lieu d'y compter pour 0.
     */
    public static function ppo(int $inscriptionId, int $matiereId, int $semestre): ?float
    {
        $devoirs = Devoir::where('inscription_id', $inscriptionId)
            ->where('matiere_id', $matiereId)
            ->where('semestre', $semestre);

        $moyenne = (clone $devoirs)->whereNotNull('note')->avg('note');
        $mcc = $moyenne !== null ? round((float) $moyenne, 2) : null;

        (clone $devoirs)->update(['mcc' => $mcc]);

        $evaluations = Evaluation::where('inscription_id', $inscriptionId)
            ->where('matiere_id', $matiereId)
            ->where('semestre', $semestre);

        if ((clone $evaluations)->exists()) {
            $evaluations->update(['note_cc' => $mcc]);
        } elseif ($mcc !== null) {
            $annee = AnneeDesNotes::desInscriptions([$inscriptionId])[$inscriptionId] ?? AnneeDesNotes::courante();

            Evaluation::create([
                'inscription_id' => $inscriptionId,
                'matiere_id'     => $matiereId,
                'semestre'       => $semestre,
                'note_cc'        => $mcc,
            ] + AnneeDesNotes::attributs('evaluations', $annee));
        }

        return $mcc;
    }

    /** APC : met à jour devoirapc.mcc sur tous les devoirs de l'apprenant pour la ressource et le semestre. */
    public static function apc(int $inscriptionId, int $ressourceId, int $semestre): ?float
    {
        $devoirs = DevoirAPC::where('inscription_id', $inscriptionId)
            ->where('ressource_id', $ressourceId)
            ->where('semestre', $semestre);

        $moyenne = (clone $devoirs)->whereNotNull('note')->avg('note');
        $mcc = $moyenne !== null ? round((float) $moyenne, 2) : null;

        $devoirs->update(['mcc' => $mcc]);

        return $mcc;
    }
}
