<?php

namespace App\Http\Controllers;

use App\Models\Devoir;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DevoirController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'classe_id'  => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'semestre'   => 'required|in:1,2',
            'libelle'    => [
                'required',
                'string',
                Rule::unique('devoirs', 'libelle')->where(function ($q) use ($request) {
                    return $q->where('classe_id', $request->classe_id)
                             ->where('matiere_id', $request->matiere_id)
                             ->where('semestre', $request->semestre);
                }),
            ],
            'notes'      => 'required|array',
        ], [
            'libelle.unique' => 'Ce libellé existe déjà pour cette classe, cette matière et ce semestre.',
        ]);

        $touched = [];

        foreach ($request->notes as $inscription_id => $note) {

            if ($note === null || $note === '' || !is_numeric($note)) {
                continue;
            }

            Devoir::updateOrCreate(
                [
                    'classe_id'      => (int) $request->classe_id,
                    'matiere_id'     => (int) $request->matiere_id,
                    'semestre'       => (int) $request->semestre,
                    'libelle'        => (string) $request->libelle,
                    'inscription_id' => (int) $inscription_id,
                ],
                [
                    'note' => (float) $note,
                ]
            );

            // on mémorise les apprenants touchés pour recalculer MCC une seule fois
            $touched[(int)$inscription_id] = true;
        }

        // ✅ Recalcul MCC et ENREGISTREMENT dans la colonne mcc
        foreach (array_keys($touched) as $inscriptionId) {
            $this->recalculerMCC(
                (int) $inscriptionId,
                (int) $request->classe_id,
                (int) $request->matiere_id,
                (int) $request->semestre
            );
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

        $agg = Devoir::query()
            ->selectRaw('classe_id, inscription_id, matiere_id, semestre, ROUND(AVG(note), 2) as mcc')
            ->where('classe_id', $classeId)
            ->where('matiere_id', $matiereId)
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

            $this->recalculerMCC(
                (int) $devoir->inscription_id,
                (int) $devoir->classe_id,
                (int) $devoir->matiere_id,
                (int) $devoir->semestre
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
        $devoir = Devoir::findOrFail($id);

        $inscription_id = (int) $devoir->inscription_id;
        $classe_id      = (int) $devoir->classe_id;
        $matiere_id     = (int) $devoir->matiere_id;
        $semestre       = (int) $devoir->semestre;

        $devoir->delete();

        $this->recalculerMCC($inscription_id, $classe_id, $matiere_id, $semestre);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Devoir supprimé avec succès.'
            ]);
        }

        return back()->with('success', 'Devoir supprimé.');
    }


    private function recalculerMCC(int $inscription_id, int $classe_id, int $matiere_id, int $semestre): float
    {
        $base = Devoir::where('inscription_id', $inscription_id)
            ->where('classe_id', $classe_id)
            ->where('matiere_id', $matiere_id)
            ->where('semestre', $semestre)
            ->whereNotNull('note');

        $sum   = (float) $base->sum('note');
        $count = (int) $base->count();

        $mcc = $count > 0 ? round($sum / $count, 2) : 0.00;

        Devoir::where('inscription_id', $inscription_id)
            ->where('classe_id', $classe_id)
            ->where('matiere_id', $matiere_id)
            ->where('semestre', $semestre)
            ->update(['mcc' => $mcc]);

        return $mcc;
    }
}
