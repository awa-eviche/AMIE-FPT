<?php
namespace App\Http\Controllers;
use App\Models\DevoirAPC;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DevoirAPCController extends Controller
{
public function store(Request $request)
    {
        $request->validate([
            'libelle' => [
                'required','string',
                
                Rule::unique('devoirapc', 'libelle')->where(function ($q) use ($request) {
                    return $q->where('ressource_id', $request->ressource_id)
                             ->where('semestre', $request->semestre);
                }),
            ],
            'ressource_id' => 'required|exists:ressources,id',
            'semestre'     => 'required|in:1,2',
            'notes'        => 'required|array',
        ], [
            'libelle.unique' => 'Ce libellé existe déjà pour cette ressource et ce semestre.',
        ]);

        foreach ($request->notes as $inscription_id => $note) {

            if ($note === null || $note === '' || !is_numeric($note)) {
                continue;
            }

            // ✅ anti double insert: updateOrCreate (double clic / latence)
            DevoirAPC::updateOrCreate(
                [
                    'ressource_id'   => (int) $request->ressource_id,
                    'semestre'       => (int) $request->semestre,
                    'libelle'        => (string) $request->libelle,
                    'inscription_id' => (int) $inscription_id,
                ],
                [
                    'note' => (float) $note,
                ]
            );

            $this->recalculerMCC(
                (int) $inscription_id,
                (int) $request->ressource_id,
                (int) $request->semestre
            );
        }

        return back()->with('success', 'Devoir et notes enregistrés avec succès');
    }






public function listeParRessource($ressourceId, Request $request)
{
    $query = DevoirAPC::with('inscription.apprenant')
        ->selectRaw('
            devoirapc.*,
            ROUND(
                AVG(note) OVER (
                    PARTITION BY inscription_id, ressource_id, semestre
                ), 2
            ) as mcc
        ')
        ->where('ressource_id', $ressourceId);

    // Filtre semestre
    if ($request->filled('semestre')) {
        $query->where('semestre', $request->semestre);
    }

    $allDevoirs = $query->orderBy('created_at', 'desc')->get();

    // ✅ Groupement 2 niveaux : semestre -> libelle
    $groupesDevoirs = $allDevoirs
        ->groupBy('semestre')
        ->map(fn($rows) => $rows->groupBy('libelle'));

    return view('devoirsAPC.partials.liste-devoirs', compact('groupesDevoirs'));
}



 public function edit($devoirId)
    {
        // Récupérer UN devoir (le premier) pour avoir les infos
        $devoir = DevoirAPC::with('inscription.apprenant')
            ->findOrFail($devoirId);
        
        // Récupérer TOUS les devoirs avec le même libellé
        $devoirs = DevoirAPC::with('inscription.apprenant')
            ->where('libelle', $devoir->libelle)
            ->where('ressource_id', $devoir->ressource_id)
            ->get();
        
        return view('devoirsAPC.edit', [
            'devoirs' => $devoirs,
            'libelle' => $devoir->libelle,
            'ressource_id' => $devoir->ressource_id
        ]);
    }
    
  public function update(Request $request, $devoirId)
{
    try {
        // Validation pour UNE seule note
        $request->validate([
            'note' => 'required|numeric|min:0|max:20'  // Note unique
        ]);
        
        // Trouver et mettre à jour le devoir
        $devoir = DevoirAPC::findOrFail($devoirId);
        $devoir->note = $request->note;
        $devoir->save();
        
       $this->recalculerMCC(
        $devoir->inscription_id,
        $devoir->ressource_id,
        $devoir->semestre
    );
        
        return response()->json([
            'success' => true,
            'message' => 'Note mise à jour avec succès'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur: ' . $e->getMessage()
        ], 500);
    }
}
       
public function destroy($id, Request $request)
{
    $devoir = DevoirAPC::findOrFail($id);
    $inscription_id = $devoir->inscription_id;
    $ressource_id   = $devoir->ressource_id;
    $semestre       = $devoir->semestre;
    $devoir->delete();
    $this->recalculerMCC($inscription_id, $ressource_id, $semestre);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Devoir supprimé avec succès.'
        ]);
    }

    return back()->with('success', 'Devoir supprimé.');
}

private function recalculerMCC($inscription_id, $ressource_id, $semestre)
{
    $moyenne = DevoirAPC::where('inscription_id', $inscription_id)
        ->where('ressource_id', $ressource_id)
        ->where('semestre', $semestre)
        ->whereNotNull('note')
        ->avg('note');

    DevoirAPC::updateOrCreate(
        [
            'inscription_id' => $inscription_id,
            'ressource_id' => $ressource_id,
            'semestre' => $semestre,
        ],
        [
            'mcc' => $moyenne !== null ? round($moyenne, 2) : null
        ]
    );
}
public function parInscriptionAPC($inscriptionId)
{
    $devoirs = DevoirAPC::where('inscription_id', $inscriptionId)
        ->with('ressource') // ✅ CHANGEMENT ICI
        ->orderBy('created_at', 'asc')
        ->get()
        ->groupBy(fn($d) => $d->ressource->nom ?? 'Non définie') // ✅ groupement par ressource
        ->flatMap(function ($items) {
            return $items->take(3); // max 3 devoirs
        })
        ->map(fn($d) => [
            'ressource' => $d->ressource->nom ?? '-', // ✅ principal
            'note'      => $d->note,
            'mcc'       => $d->mcc,
            'semestre'  => $d->semestre,
        ])
        ->values();

    return response()->json($devoirs);
}


}
