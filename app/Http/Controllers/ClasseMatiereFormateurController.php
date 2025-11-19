<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Competence;

class ClasseMatiereFormateurController extends Controller
{
    /**
     * Enregistre une assignation (matière ou compétence) à un formateur pour une classe.
     */
    public function store(Request $request, $classe_id)
    {
        $classe = Classe::findOrFail($classe_id);

        // 🔹 Vérifie si la classe utilise PPO ou APC
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
                'classe_id'    => $classe->id,
                'formateur_id' => $request->formateur_id,
                'competence_id' => $request->competence_id,
                'created_at'   => now(),
                'updated_at'   => now(),
            ];

            $exists = DB::table($table)
                ->where('classe_id', $classe->id)
                ->where('formateur_id', $request->formateur_id)
                ->where('competence_id', $request->competence_id)
                ->exists();
        } else {
            return back()->withErrors(['modalite' => "Modalité non reconnue pour cette classe."]);
        }

        // 🔹 Vérifie la duplication
        

        // 🔹 Insère dans la table correspondante
        DB::table($table)->insert($fields);

        return back()->with('success', 'Affectation enregistrée avec succès.');
    }

    /**
     * Supprime une assignation (matière ou compétence)
     */
      public function destroy($classe_id, $formateur_id, $id)
    {
        $classe = Classe::findOrFail($classe_id);

        if ($classe->modalite === 'PPO') {
            DB::table('classe_formateur_matiere')
                ->where('classe_id', $classe_id)
                ->where('formateur_id', $formateur_id)
                ->where('matiere_id', $id)
                ->delete();
        } elseif ($classe->modalite === 'APC') {
        
        DB::table('classe_formateur_competence')
            ->where('classe_id', $classe_id)
            ->where('formateur_id', $formateur_id)
            ->where('competence_id', $id)
            ->delete();

        
        $elements = DB::table('element_competences')
            ->where('competence_id', $id)
            ->pluck('id');

        if ($elements->isNotEmpty()) {
           
            DB::table('ressources')
                ->whereIn('element_competence_id', $elements)
                ->delete();
        }
    }

        return back()->with('success', 'Affectation supprimée avec succès.');
    }
}
