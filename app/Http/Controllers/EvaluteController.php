<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Competence;
use App\Models\Evalute;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
      public function create(Inscription $inscription)
{
    $user = Auth::user();
    $personnel = $user->personnel;

    // ✅ Autoriser si :
    //  - c'est un formateur assigné à la classe, OU
    //  - c'est un chef de travaux
    $autorise = false;
if (
    $user->hasRole('chef_de_travaux') ||
    $user->hasRole('chef_etablissement') ||
    $user->hasRole('directeur_etude')
) {
    $autorise = true;
} elseif (
    $personnel &&
    $inscription->classe->formateurs()
        ->where('personnel_etablissement_id', $personnel->id)
        ->exists()
) {
    $autorise = true;
}

    
 elseif ($personnel && $inscription->classe->formateurs()
        ->where('personnel_etablissement_id', $personnel->id)
        ->exists()) {
        $autorise = true;
    }

    if (! $autorise) {
        abort(403, "Vous n'êtes pas autorisé à évaluer les apprenants de cette classe.");
    }

    // 🔹 Chargement des compétences selon le niveau d'étude de la classe
    $competences = Competence::where('niveau_etude_id', $inscription->classe->niveau_etude_id)->get();

    return view('evaluations.evaluate', compact('inscription', 'competences'));
}

    public function store(Request $request, Inscription $inscription)
    {
      $user = Auth::user();
        $personnel = $user->personnel;

        // Vérifie que le formateur connecté est bien assigné à la classe
        $autorise = $personnel && $inscription->classe->formateurs()
            ->where('personnel_etablissement_id', $personnel->id)
            ->exists();

        if (! $autorise) {
            abort(403, "Vous n'êtes pas autorisé à enregistrer une évaluation pour cette classe.");
        } 
  $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'critere' => 'required|exists:criteres,id',
            'date' => 'nullable|date',
            'observations' => 'nullable|string|max:255'
        ]);
    
        $evaluation = new Evalute();
        $evaluation->inscription_id = $inscription->id;
        $evaluation->critere_id = $request->input('critere');
        $evaluation->note = $request->input('note'); // ✅ nouvelle ligne
        $evaluation->date = $request->input('date');
        $evaluation->observations = $request->input('observations');
    
        if ($evaluation->save()) {
            return redirect()->route('competence.manage.index')
                ->with('message', 'Évaluation enregistrée avec succès.');
        }
    
        return redirect()->back()->withErrors('Une erreur est survenue, veuillez réessayer.');
    }

 
    public function show(string $id)
    {
        //
    }

   
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
