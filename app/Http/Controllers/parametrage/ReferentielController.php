<?php

namespace App\Http\Controllers\parametrage;

use App\Http\Controllers\Controller;
use App\Models\Referentiel;
use App\Models\Metier;
use App\Models\NiveauEtude;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferentielController extends Controller
{
    public function index()
    {
        $referentiels = Referentiel::with('metier')->get();
        return view('referentiels.index', compact('referentiels'));
    }

    public function create()
    {
        $metiers = Metier::all();
        $niveaux = NiveauEtude::all();
        return view('referentiels.create', compact('metiers','niveaux'));
    }

   

public function store(Request $request)
{
    $request->validate([
        'metier_id' => 'required',
        'niveaux' => 'required|array|max:3',
        'niveaux.*' => 'exists:niveau_etudes,id',

        'titre' => 'required|array',
        'titre.*' => 'required|string',

        'type_referentiel' => 'required|array',
        'type_referentiel.*' => 'required|string',

        'fichier' => 'required|array',
        'fichier.*' => 'file|mimes:pdf,doc,docx',
    ]);

    DB::beginTransaction();

    try {

        $files = $request->file('fichier');

        foreach ($request->titre as $index => $titre) {
        
            if (isset($files[$index])) {
        
                $path = $files[$index]->store('referentiels', 'public');
        
                $referentiel = \App\Models\Referentiel::create([
                    'metier_id' => $request->metier_id,
                    'type_referentiel' => $request->type_referentiel[$index] ?? null,
                    'titre' => $titre,
                    'fichier' => $path,
                ]);
        
                // 🔥 ATTACH MULTI NIVEAUX
                $referentiel->niveaux()->sync($request->niveaux);
            }
        }

        DB::commit();

        return redirect()->route('referentiel.index')
            ->with('success', 'Référentiels ajoutés avec succès');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', 'Erreur lors de l\'enregistrement');
    }
}
    public function destroy($id)
    {
        $ref = Referentiel::findOrFail($id);
        $ref->delete();
        return back();
    }

    // REFERENTIELS POUR ETABLISSEMENT
    public function mesReferentiels()
    {
        $user = auth()->user();

        $classes = Classe::where('etablissement_id', $user->etablissement_id)->get();
        $niveauIds = $classes->pluck('niveau_etude_id');

        $referentiels = Referentiel::whereIn('niveau_etude_id', $niveauIds)
            ->with('metier','niveauEtude')
            ->get();

        return view('etablissement.referentiels.index', compact('referentiels'));
    }



    public function getNiveaux($metier_id)
{
    $niveaux = \App\Models\NiveauEtude::where('metier_id', $metier_id)->get();

    return response()->json($niveaux);
}
}