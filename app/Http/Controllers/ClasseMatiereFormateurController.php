<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Competence;

class ClasseMatiereFormateurController extends Controller
{
    
  public function store(Request $request, $classe_id)
{
    $classe = Classe::findOrFail($classe_id);

    if ($classe->modalite === 'PPO') {

        $request->validate([
            'formateur_id' => 'required|integer',
            'matiere_id'   => 'required|integer',
        ]);

        $table = 'classe_formateur_matiere';
        $fields = [
            'classe_id'    => $classe->id,
            'formateur_id' => $request->formateur_id,
            'matiere_id'   => $request->matiere_id,
            'created_at'   => now(),
            'updated_at'   => now(),
        ];

        $exists = DB::table($table)
            ->where('classe_id', $classe->id)
            ->where('formateur_id', $request->formateur_id)
            ->where('matiere_id', $request->matiere_id)
            ->exists();

    } elseif ($classe->modalite === 'APC') {

        $request->validate([
            'formateur_id'  => 'required|integer',
            'competence_id' => 'required|integer',
        ]);

        $table = 'classe_formateur_competence';
        $fields = [
            'classe_id'     => $classe->id,
            'formateur_id'  => $request->formateur_id,
            'competence_id' => $request->competence_id,
            'created_at'    => now(),
            'updated_at'    => now(),
        ];


        $exists = DB::table($table)
            ->where('classe_id', $classe->id)
            ->where('formateur_id', $request->formateur_id)
            ->where('competence_id', $request->competence_id)
            ->exists();

    } else {
        return back()->withErrors(['modalite' => "Modalité non reconnue pour cette classe."]);
    }

    // ✅ IMPORTANT : on bloque seulement PPO si déjà existant (APC = autorisé)
    if ($classe->modalite === 'PPO' && $exists) {
        return back()->with('error', "Cette affectation existe déjà en PPO.");
    }

    DB::table($table)->insert($fields);

    return back()->with('success', 'Affectation enregistrée avec succès.');
}


   
public function destroy(Request $request, $classe_id, $formateur_id, $id)
{
    $classe = Classe::findOrFail($classe_id);
    $competence_id = $id;

    try {
        DB::transaction(function () use ($request, $classe, $classe_id, $formateur_id, $competence_id) {

            // ================= PPO (NE PAS CHANGER) =================
            if ($classe->modalite === 'PPO') {

                DB::table('classe_formateur_matiere')
                    ->where('classe_id', $classe_id)
                    ->where('formateur_id', $formateur_id)
                    ->where('matiere_id', $competence_id)
                    ->delete();

                DB::table('devoirs')
                    ->where('classe_id', $classe_id)
                    ->where('matiere_id', $competence_id)
                    ->delete();

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
            $assignExists = DB::table('classe_formateur_competence')
                ->where('id', $assignId)
                ->where('classe_id', $classe_id)
                ->where('formateur_id', $formateur_id)
                ->where('competence_id', $competence_id)
                ->exists();

            if (!$assignExists) {
                throw new \Exception("Assignation introuvable ou non autorisée.");
            }

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

                // ✅ devoirs liés à cette ressource uniquement
                DB::table('devoirapc')
                    ->where('ressource_id', $ressourceId)
                    ->delete();

                // ✅ supprimer cette ressource uniquement
                DB::table('ressources')
                    ->where('id', $ressourceId)
                    ->delete();

                // ✅ s’il ne reste plus aucune ressource pour (classe, formateur, competence)
                // => supprimer aussi l’assignation ciblée (UNE seule)
                $stillHasRessource = DB::table('ressources')
                    ->where('classe_id', $classe_id)
                    ->where('formateur_id', $formateur_id)
                    ->where('competence_id', $competence_id)
                    ->exists();

                if (!$stillHasRessource) {
                    DB::table('classe_formateur_competence')
                        ->where('id', $assignId)
                        ->delete();
                }

                return;
            }

            DB::table('classe_formateur_competence')
                ->where('id', $assignId)
                ->delete();
        });

        return back()->with('success', 'Suppression effectuée avec succès.');
    } catch (\Throwable $e) {
        return back()->with('error', $e->getMessage());
    }
}

}
