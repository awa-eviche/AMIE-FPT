<?php
namespace App\Http\Controllers;
use App\Models\DevoirAPC;
use App\Models\Evalute;
use App\Models\Ressource;
use App\Services\NoteCc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DevoirAPCController extends Controller
{
public function store(Request $request)
    {
        $anneeAcademiqueId = $request->input('annee_academique_id')
            ?? session('annee_academique_id')
            ?? \App\Services\AnneeDesNotes::anneeParDefaut();
        // Chaque note prend l'année de l'inscription de l'apprenant (à défaut, celle de la page).
        $anneesInscriptions = \App\Services\AnneeDesNotes::desInscriptions(array_keys((array) $request->notes));
        // Année du devoir : celle des inscriptions notées.
        $anneeDevoir = collect($anneesInscriptions)->countBy()->sortDesc()->keys()->first() ?? $anneeAcademiqueId;

        $request->validate([
            'libelle' => [
                'required','string',

                Rule::unique('devoirapc', 'libelle')->where(function ($q) use ($request, $anneeDevoir) {
                    return $q->where('ressource_id', $request->ressource_id)
                             ->where('semestre', $request->semestre)
                             ->where('annee_academique_id', $anneeDevoir);
                }),
            ],
            'ressource_id' => 'required|exists:ressources,id',
            'semestre'     => 'required|in:1,2',
            'notes'        => 'required|array',
            'notes.*'      => 'nullable|numeric|min:0|max:20',
        ], [
            'libelle.unique'  => 'Ce libellé existe déjà pour cette ressource et ce semestre.',
            'notes.*.numeric' => 'Chaque note doit être un nombre.',
            'notes.*.min'     => 'Chaque note doit être comprise entre 0 et 20.',
            'notes.*.max'     => 'Chaque note doit être comprise entre 0 et 20.',
        ]);

        foreach ($request->notes as $inscription_id => $note) {

            if ($note === null || $note === '' || !is_numeric($note)) {
                continue;
            }

            // ✅ anti double insert: updateOrCreate (double clic / latence)
            DevoirAPC::updateOrCreate(
                [
                    'ressource_id'        => (int) $request->ressource_id,
                    'semestre'            => (int) $request->semestre,
                    'libelle'             => (string) $request->libelle,
                    'inscription_id'      => (int) $inscription_id,
                    'annee_academique_id' => $anneesInscriptions[(int) $inscription_id] ?? $anneeDevoir,
                ],
                [
                    'note' => (float) $note,
                ]
            );

            NoteCc::apc((int) $inscription_id, (int) $request->ressource_id, (int) $request->semestre);
        }

        return back()->with('success', 'Devoir et notes enregistrés avec succès');
    }






public function listeParRessource($ressourceId, Request $request)
{
    $anneeAcademiqueId = $request->input('annee_academique_id')
        ?? session('annee_academique_id')
        ?? \App\Services\AnneeDesNotes::anneeParDefaut();

    $query = DevoirAPC::with('inscription.apprenant')
        ->selectRaw('
            devoirapc.*,
            ROUND(
                AVG(note) OVER (
                    PARTITION BY inscription_id, ressource_id, semestre
                ), 2
            ) as mcc
        ')
        ->where('ressource_id', $ressourceId)
        ->when($anneeAcademiqueId, fn($q) => $q->where('annee_academique_id', $anneeAcademiqueId));

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
        
        // Récupérer TOUS les devoirs avec le même libellé, du même semestre et de la même année
        $devoirs = DevoirAPC::with('inscription.apprenant')
            ->where('libelle', $devoir->libelle)
            ->where('ressource_id', $devoir->ressource_id)
            ->where('semestre', $devoir->semestre)
            ->where(fn($q) => $this->memeAnnee($q, $devoir))
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
        
        NoteCc::apc((int) $devoir->inscription_id, (int) $devoir->ressource_id, (int) $devoir->semestre);

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
       
/**
 * Supprime un devoir pour toute la classe (même libellé, ressource, semestre et année),
 * puis recalcule le CC de chaque apprenant qui l'avait.
 */
public function destroy($id, Request $request)
{
    $devoir = DevoirAPC::findOrFail($id);

    $ressource_id = (int) $devoir->ressource_id;
    $semestre     = (int) $devoir->semestre;

    $groupe = DevoirAPC::where('libelle', $devoir->libelle)
        ->where('ressource_id', $ressource_id)
        ->where('semestre', $semestre)
        ->where(fn($q) => $this->memeAnnee($q, $devoir));

    $inscriptionIds = (clone $groupe)->distinct()->pluck('inscription_id');

    $groupe->delete();

    foreach ($inscriptionIds as $inscId) {
        NoteCc::apc((int) $inscId, $ressource_id, $semestre);

        // La composition restait rattachée à un devoir supprimé : on la rattache au dernier devoir restant.
        Evalute::where('inscription_id', $inscId)
            ->where('ressource_id', $ressource_id)
            ->where('semestre', $semestre)
            ->update(['devoirapc_id' => DevoirAPC::where('inscription_id', $inscId)
                ->where('ressource_id', $ressource_id)
                ->where('semestre', $semestre)
                ->max('id')]);
    }

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Devoir supprimé avec succès.'
        ]);
    }

    return back()->with('success', 'Devoir supprimé.');
}

/** Restreint aux devoirs de la même année académique que $devoir. */
private function memeAnnee($query, DevoirAPC $devoir)
{
    return $devoir->annee_academique_id
        ? $query->where('annee_academique_id', $devoir->annee_academique_id)
        : $query->whereNull('annee_academique_id');
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
