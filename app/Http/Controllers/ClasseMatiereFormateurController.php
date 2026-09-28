<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Competence;
use App\Models\AnneeAcademique;
use App\Services\SuppressionNotes;

class ClasseMatiereFormateurController extends Controller
{
    /**
     * Année académique courante : session partagée avec les autres pages
     * (assignations, gestion des notes), avec repli sur l'année académique ouverte.
     */
    private function anneeAcademiqueId(Request $request): ?int
    {
        $id = $request->input('annee_academique_id') ?? session('annee_academique_id');

        if ($id) {
            session()->put('annee_academique_id', $id);
            return (int) $id;
        }

        // Tant qu'aucune année n'est choisie : 2025-2026 (et non l'année ouverte).
        return \App\Services\AnneeDesNotes::anneeParDefaut()
            ?? AnneeAcademique::where('is_open', true)->value('id')
            ?? AnneeAcademique::orderByDesc('annee1')->value('id');
    }

  public function store(Request $request, $classe_id)
{
    $classe = Classe::findOrFail($classe_id);
    $anneeAcademiqueId = $this->anneeAcademiqueId($request);

    if ($classe->modalite === 'PPO') {

        $request->validate([
            'formateur_id' => 'required|integer',
            'matiere_id'   => 'required|integer',
            'semestre'     => 'required|in:1,2',
        ]);

        $table = 'classe_formateur_matiere';
        $fields = [
            'classe_id'           => $classe->id,
            'annee_academique_id' => $anneeAcademiqueId,
            'formateur_id'        => $request->formateur_id,
            'matiere_id'          => $request->matiere_id,
            'semestre'            => $request->semestre,
            'created_at'          => now(),
            'updated_at'          => now(),
        ];

        $exists = DB::table($table)
            ->where('classe_id', $classe->id)
            ->where('formateur_id', $request->formateur_id)
            ->where('matiere_id', $request->matiere_id)
            ->where('annee_academique_id', $anneeAcademiqueId)
            ->where('semestre', $request->semestre)
            ->exists();

    } elseif ($classe->modalite === 'APC') {

        $request->validate([
            'formateur_id'  => 'required|integer',
            'competence_id' => 'required|integer',
            'semestre'      => 'required|in:1,2',
        ]);

        $table = 'classe_formateur_competence';
        $fields = [
            'classe_id'           => $classe->id,
            'annee_academique_id' => $anneeAcademiqueId,
            'formateur_id'        => $request->formateur_id,
            'competence_id'       => $request->competence_id,
            'semestre'            => $request->semestre,
            'created_at'          => now(),
            'updated_at'          => now(),
        ];


        $exists = DB::table($table)
            ->where('classe_id', $classe->id)
            ->where('formateur_id', $request->formateur_id)
            ->where('competence_id', $request->competence_id)
            ->where('annee_academique_id', $anneeAcademiqueId)
            ->exists();

    } else {
        return back()->withErrors(['modalite' => "Modalité non reconnue pour cette classe."]);
    }

    // ✅ IMPORTANT : on bloque seulement PPO si déjà existant pour cette année (APC = autorisé)
    if ($classe->modalite === 'PPO' && $exists) {
        return back()->with('error', "Cette affectation existe déjà en PPO pour cette année académique.");
    }

    DB::table($table)->insert($fields);

    return back()->with('success', 'Affectation enregistrée avec succès.');
}


   
/** Phrase récapitulant les notes supprimées avec l'affectation. */
private function resumeNotes(array $bilan): string
{
    if (!empty($bilan['conservees'])) {
        return ' Les notes ont été conservées : un autre formateur reste affecté à cette matière.';
    }

    $libelles = [
        'devoirs' => 'devoir(s)', 'evaluations' => 'évaluation(s)', 'compositions' => 'composition(s)',
        'sommatives' => 'note(s) sommative(s)',
    ];
    $parties = [];
    foreach ($libelles as $cle => $libelle) {
        if (!empty($bilan[$cle])) {
            $parties[] = $bilan[$cle] . ' ' . $libelle;
        }
    }

    return $parties ? ' Notes supprimées : ' . implode(', ', $parties) . '.' : '';
}

public function destroy(Request $request, $classe_id, $formateur_id, $id)
{
    $classe = Classe::findOrFail($classe_id);
    $competence_id = $id;
    $anneeAcademiqueId = $this->anneeAcademiqueId($request);
    $bilan = [];   // notes supprimées avec l'affectation (voir SuppressionNotes)

    try {
        DB::transaction(function () use ($request, $classe, $classe_id, $formateur_id, $competence_id, $anneeAcademiqueId, &$bilan) {

            // ================= PPO =================
            if ($classe->modalite === 'PPO') {

                $semestre = $request->input('semestre');

                $supprimees = DB::table('classe_formateur_matiere')
                    ->where('classe_id', $classe_id)
                    ->where('formateur_id', $formateur_id)
                    ->where('matiere_id', $competence_id)
                    ->where('annee_academique_id', $anneeAcademiqueId)
                    ->when($semestre, fn($q) => $q->where('semestre', $semestre))
                    ->delete();

                // Les notes de la matière partent avec l'affectation (sauf si un autre formateur la couvre encore).
                if ($supprimees > 0) {
                    $bilan = SuppressionNotes::apresSuppressionPpo(
                        (int) $classe_id, (int) $competence_id, (int) $anneeAcademiqueId, $semestre ? (int) $semestre : null
                    );
                }

                return;
            }

            // ================= APC =================
            if ($classe->modalite !== 'APC') {
                throw new \Exception("Modalité non reconnue pour cette classe.");
            }

            // ✅ obligatoire : supprimer UNE seule assignation via l'id de cfc
            $assignId = $request->input('assign_id');
            if (empty($assignId)) {
                throw new \Exception("assign_id manquant. Impossible de supprimer une assignation spécifique.");
            }

            // ✅ optionnel : si on veut supprimer une ressource précise
            $ressourceId = $request->input('ressource_id');

            // ✅ sécurité : l’assignation ciblée doit appartenir au triplet (classe, formateur, competence)
            $assignation = DB::table('classe_formateur_competence')
                ->where('id', $assignId)
                ->where('classe_id', $classe_id)
                ->where('formateur_id', $formateur_id)
                ->where('competence_id', $competence_id)
                ->first();

            if (!$assignation) {
                throw new \Exception("Assignation introuvable ou non autorisée.");
            }

            // Année de l'affectation supprimée : c'est elle (et non l'année de la session) qui
            // détermine s'il reste des disciplines à ce formateur pour cette compétence.
            $anneeAssignation = $assignation->annee_academique_id ?: $anneeAcademiqueId;

            // -------------------------------------------------
            // 1) Si ressource_id fourni : supprimer CETTE ressource + ses devoirs,
            //    puis supprimer l’assignation seulement si aucune ressource ne reste
            // -------------------------------------------------
            if (!empty($ressourceId)) {

                $ressourceExists = DB::table('ressources')
                    ->where('id', $ressourceId)
                    ->where('classe_id', $classe_id)
                    ->where('formateur_id', $formateur_id)
                    ->where('competence_id', $competence_id)
                    ->exists();

                if (!$ressourceExists) {
                    throw new \Exception("Discipline introuvable ou non autorisée.");
                }

             

                // ✅ supprimer cette ressource uniquement (ses notes sont supprimées plus bas)
                DB::table('ressources')
                    ->where('id', $ressourceId)
                    ->delete();

                // ✅ s’il ne reste plus aucune ressource pour (classe, formateur, competence)
                // => supprimer aussi l’assignation ciblée (UNE seule)
                $stillHasRessource = DB::table('ressources')
                    ->where('classe_id', $classe_id)
                    ->where('formateur_id', $formateur_id)
                    ->where('competence_id', $competence_id)
                    ->when(\App\Services\AnneeDesNotes::aUneColonne('ressources'),
                        fn ($q) => $q->where('annee_academique_id', $anneeAssignation))
                    ->exists();

                $affectationSupprimee = !$stillHasRessource;
                if ($affectationSupprimee) {
                    DB::table('classe_formateur_competence')
                        ->where('id', $assignId)
                        ->delete();
                }

                // Notes de la discipline supprimée, puis (si l'affectation a disparu) notes sommatives
                // de la compétence particulière. Les tables MyISAM sont touchées en dernier.
                $bilan = SuppressionNotes::ressource((int) $ressourceId);
                if ($affectationSupprimee) {
                    $bilan['sommatives'] += SuppressionNotes::competenceParticuliere(
                        (int) $classe_id, (int) $competence_id, (int) $anneeAssignation,
                        $assignation->semestre ? (int) $assignation->semestre : null
                    );
                }

                return;
            }

            DB::table('classe_formateur_competence')
                ->where('id', $assignId)
                ->delete();

            $bilan = ['sommatives' => SuppressionNotes::competenceParticuliere(
                (int) $classe_id, (int) $competence_id, (int) $anneeAssignation,
                $assignation->semestre ? (int) $assignation->semestre : null
            )];
        });

        \Illuminate\Support\Facades\Log::info('Suppression d\'une affectation', [
            'user' => auth()->id(), 'classe' => $classe_id, 'formateur' => $formateur_id, 'element' => $competence_id,
            'annee' => $anneeAcademiqueId, 'notes_supprimees' => $bilan,
        ]);

        return back()->with('success', 'Suppression effectuée avec succès.' . $this->resumeNotes($bilan));
    } catch (\Throwable $e) {
        return back()->with('error', $e->getMessage());
    }
}

}
