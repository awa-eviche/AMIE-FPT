<?php

namespace App\Http\Controllers;

use App\Models\Devoir;
use App\Services\NoteCc;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DevoirController extends Controller
{
    public function store(Request $request)
    {
        $anneeAcademiqueId = $request->input('annee_academique_id')
            ?? session('annee_academique_id')
            ?? \App\Services\AnneeDesNotes::anneeParDefaut();
        // Chaque note prend l'année de l'inscription de l'apprenant (à défaut, celle de la page).
        $anneesInscriptions = \App\Services\AnneeDesNotes::desInscriptions(array_keys((array) $request->notes));
        // Année du devoir : celle des inscriptions notées (une classe est réutilisée d'une année à l'autre).
        $anneeDevoir = collect($anneesInscriptions)->countBy()->sortDesc()->keys()->first() ?? $anneeAcademiqueId;

        $request->validate([
            'classe_id'  => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'semestre'   => 'required|in:1,2',
            'libelle'    => [
                'required',
                'string',
                Rule::unique('devoirs', 'libelle')->where(function ($q) use ($request, $anneeDevoir) {
                    return $q->where('classe_id', $request->classe_id)
                             ->where('matiere_id', $request->matiere_id)
                             ->where('semestre', $request->semestre)
                             ->where('annee_academique_id', $anneeDevoir);
                }),
            ],
            'notes'      => 'required|array',
            'notes.*'    => 'nullable|numeric|min:0|max:20',
        ], [
            'libelle.unique'  => 'Ce libellé existe déjà pour cette classe, cette matière et ce semestre.',
            'notes.*.numeric' => 'Chaque note doit être un nombre.',
            'notes.*.min'     => 'Chaque note doit être comprise entre 0 et 20.',
            'notes.*.max'     => 'Chaque note doit être comprise entre 0 et 20.',
        ]);

        $touched = [];

        foreach ($request->notes as $inscription_id => $note) {

            if ($note === null || $note === '' || !is_numeric($note)) {
                continue;
            }

            Devoir::updateOrCreate(
                [
                    'classe_id'           => (int) $request->classe_id,
                    'matiere_id'          => (int) $request->matiere_id,
                    'semestre'            => (int) $request->semestre,
                    'libelle'             => (string) $request->libelle,
                    'inscription_id'      => (int) $inscription_id,
                    'annee_academique_id' => $anneesInscriptions[(int) $inscription_id] ?? $anneeDevoir,
                ],
                [
                    'note' => (float) $note,
                ]
            );

            // on mémorise les apprenants touchés pour recalculer MCC une seule fois
            $touched[(int)$inscription_id] = true;
        }

        // ✅ Recalcul MCC (devoirs.mcc et evaluations.note_cc)
        foreach (array_keys($touched) as $inscriptionId) {
            NoteCc::ppo((int) $inscriptionId, (int) $request->matiere_id, (int) $request->semestre);
        }

        return back()->with('success', 'Devoir et notes enregistrés avec succès');
    }

    public function listeParMatiere($matiereId, Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'semestre'  => 'nullable|in:1,2',
        ]);

        $classeId = (int) $request->classe_id;

        $anneeAcademiqueId = $request->input('annee_academique_id')
            ?? session('annee_academique_id')
            ?? \App\Services\AnneeDesNotes::anneeParDefaut();

        $agg = Devoir::query()
            ->selectRaw('classe_id, inscription_id, matiere_id, semestre, ROUND(AVG(note), 2) as mcc')
            ->where('classe_id', $classeId)
            ->where('matiere_id', $matiereId)
            ->when($anneeAcademiqueId, fn($q) => $q->where('annee_academique_id', $anneeAcademiqueId))
            ->when($request->filled('semestre'), fn($q) => $q->where('semestre', $request->semestre))
            ->whereNotNull('note')
            ->groupBy('classe_id', 'inscription_id', 'matiere_id', 'semestre');

        $devoirs = Devoir::query()
            ->with('inscription.apprenant')
            ->leftJoinSub($agg, 'm', function ($join) {
                $join->on('devoirs.classe_id', '=', 'm.classe_id')
                     ->on('devoirs.inscription_id', '=', 'm.inscription_id')
                     ->on('devoirs.matiere_id', '=', 'm.matiere_id')
                     ->on('devoirs.semestre', '=', 'm.semestre');
            })
            ->select('devoirs.*', 'm.mcc')
            ->where('devoirs.classe_id', $classeId)
            ->where('devoirs.matiere_id', $matiereId)
            ->when($anneeAcademiqueId, fn($q) => $q->where('devoirs.annee_academique_id', $anneeAcademiqueId))
            ->when($request->filled('semestre'), fn($q) => $q->where('devoirs.semestre', $request->semestre))
            ->orderBy('devoirs.semestre', 'asc')
            ->orderBy('devoirs.created_at', 'desc')
            ->get();

        $groupesDevoirs = $devoirs->groupBy(['semestre', 'libelle']);

        return view('classe.ppo.partials.voir_devoir_content', compact('groupesDevoirs'));
    }

    public function edit($devoirId)
    {
        $devoir = Devoir::with('inscription.apprenant')->findOrFail($devoirId);

        $devoirs = Devoir::with('inscription.apprenant')
            ->where('classe_id', $devoir->classe_id)
            ->where('libelle', $devoir->libelle)
            ->where('matiere_id', $devoir->matiere_id)
            ->where('semestre', $devoir->semestre)
            ->where(fn($q) => $this->memeAnnee($q, $devoir))
            ->get();

        return view('devoirsPPO.edit', [
            'devoirs'    => $devoirs,
            'libelle'    => $devoir->libelle,
            'matiere_id' => $devoir->matiere_id,
            'semestre'   => $devoir->semestre,
            'classe_id'  => $devoir->classe_id,
        ]);
    }

    public function update(Request $request, $devoirId)
    {
        try {
            $request->validate([
                'note' => 'required|numeric|min:0|max:20'
            ]);

            $devoir = Devoir::findOrFail($devoirId);
            $devoir->note = (float) $request->note;
            $devoir->save();

            NoteCc::ppo((int) $devoir->inscription_id, (int) $devoir->matiere_id, (int) $devoir->semestre);

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
     * Supprime un devoir pour toute la classe (même libellé, matière, semestre et année),
     * puis recalcule le CC de chaque apprenant qui l'avait.
     */
    public function destroy($id, Request $request)
    {
        $devoir = Devoir::findOrFail($id);

        $groupe = Devoir::where('libelle', $devoir->libelle)
            ->where('classe_id', $devoir->classe_id)
            ->where('matiere_id', $devoir->matiere_id)
            ->where('semestre', $devoir->semestre)
            ->where(fn($q) => $this->memeAnnee($q, $devoir));

        $inscriptionIds = (clone $groupe)->distinct()->pluck('inscription_id');

        $groupe->delete();

        foreach ($inscriptionIds as $inscriptionId) {
            NoteCc::ppo((int) $inscriptionId, (int) $devoir->matiere_id, (int) $devoir->semestre);
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
    private function memeAnnee($query, Devoir $devoir)
    {
        return $devoir->annee_academique_id
            ? $query->where('annee_academique_id', $devoir->annee_academique_id)
            : $query->whereNull('annee_academique_id');
    }

// DevoirController
public function parInscriptionPPO($inscriptionId)
{
    $devoirs = Devoir::where('inscription_id', $inscriptionId)
        ->with('matiere')
        ->orderBy('created_at', 'asc')
        ->get()
        ->map(function ($d) {
            return [
                'matiere'  => $d->matiere->nom ?? 'Non définie',
                'note'     => $d->note,
                'mcc'      => $d->mcc,
                'semestre' => $d->semestre,
            ];
        });

    return response()->json($devoirs);
}


}
