<?php

// app/Http/Controllers/ReinscriptionController.php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Evaluation;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\Apprenant;
use App\Models\AnneeAcademique;

class ReinscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'annee_academique_id' => 'required|exists:annee_academiques,id',
            'apprenants' => 'required|array',
            'apprenants.*' => 'exists:apprenants,id',
        ]);

        $classe_id = $request->classe_id;
        $annee_id = $request->annee_academique_id;

        $ignorés = [];

        foreach ($request->apprenants as $apprenant_id) {
            $deja_inscrit = Inscription::where('apprenant_id', $apprenant_id)
                ->where('annee_academique_id', $annee_id)
                ->exists();

            if ($deja_inscrit) {
                $ignorés[] = $apprenant_id;
                continue;
            }

            Inscription::create([
                'apprenant_id' => $apprenant_id,
                'classe_id' => $classe_id,
                'annee_academique_id' => $annee_id,
                'date_inscription' => now(),
            ]);
        }

        if (count($ignorés) > 0) {
            $noms = Apprenant::whereIn('id', $ignorés)->get();
            $liste = $noms->map(fn($a) => $a->prenom . ' ' . $a->nom)->implode(', ');

            return back()->with([
                'warning' => 'Les apprenants suivants ont été ignorés car déjà inscrits cette année : ' . $liste,
                'success' => 'Les autres apprenants ont été réinscrits avec succès.',
            ]);
        }

        return back()->with('success', 'Réinscription réussie pour tous les apprenants sélectionnés.');
    }


    public function selectClasse()
    {
        $etablissementId = auth()->user()->etablissementId();
        $classes = Classe::where('etablissement_id', $etablissementId)->get();
    
        return view('reinscription.select_classe', compact('classes'));
    }
    



    public function getAdmis($classe_id)
    {
        $classe = Classe::with('niveau_etude', 'inscriptions.apprenant')->findOrFail($classe_id);
        $matieres = Matiere::where('niveau_etude_id', $classe->niveau_etude_id)->get();
        $admis = [];

        foreach ($classe->inscriptions as $inscription) {
            $moyenne = $this->calculerMoyenneGenerale($inscription, $matieres);

            if ($moyenne !== null && $moyenne >= 10) {
                $admis[] = [
                    'inscription' => $inscription,
                    'moyenne' => round($moyenne, 2)
                ];
            }
        }

        $etablissementId = auth()->user()->etablissementId();
        $classes = Classe::where('etablissement_id', $etablissementId)->get();
        $annees = AnneeAcademique::orderByDesc('code')->get();

        return view('reinscription.admis', [
            'classe' => $classe,
            'admis' => $admis,
            'classes' => $classes,
            'annees' => $annees,
        ]);
    }

    private function calculerMoyenneGenerale($inscription, $matieres)
    {
        $somme = 0;
        $coeffs = 0;

        foreach ($matieres as $matiere) {
            $eval = Evaluation::where('inscription_id', $inscription->id)
                ->where('matiere_id', $matiere->id)
                ->first();

            if ($eval && $matiere->coef > 0) {
                $moy = ($eval->note_cc + $eval->note_composition) / 2;
                $somme += $moy * $matiere->coef;
                $coeffs += $matiere->coef;
            }
        }

        return $coeffs > 0 ? $somme / $coeffs : null;
    }
}
