<?php

namespace App\Http\Controllers;

use App\Models\AnneeAcademique;
use App\Models\CreneauEmploiDuTemps;
use App\Models\EmploiDuTemps;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ── PDF emploi du temps complet (admin) ──────────────────
    public function exportPdf(int $id)
    {
        $emploiDuTemps = EmploiDuTemps::with([
            'classe',
            'etablissement',
            'anneeAcademique',
            'creneaux.formateur.user',
            'creneaux.matiere',
            'creneaux.elementCompetence',
        ])->findOrFail($id);

        abort_unless(
            auth()->user()->hasAnyRole(['chef_etablissement','chef_de_travaux','de','surveillant','formateur']),
            403
        );

        $pdf = Pdf::loadView('emploi-du-temps.pdf', [
            'emploiDuTemps' => $emploiDuTemps,
            'classe'        => $emploiDuTemps->classe,
            'etablissement' => $emploiDuTemps->etablissement,
            'annee'         => $emploiDuTemps->anneeAcademique,
        ])->setPaper('a4', 'landscape');

        $periode = $emploiDuTemps->type_planning === 'hebdomadaire'
            ? 'Semaine_' . ($emploiDuTemps->semaine ?? 'X')
            : 'Semestre_' . ($emploiDuTemps->semestre ?? 'X');

        $filename = 'EDT_'
                  . str_replace(' ', '_', $emploiDuTemps->classe->libelle ?? 'classe')
                  . '_' . $periode . '.pdf';

        return $pdf->stream($filename);
    }

    // ── PDF planning formateur (hebdomadaire ou semestriel, dissocié par classe) ──
    public function exportPdfFormateur(Request $request)
    {
        $formateur = auth()->user()->personnel;
        abort_unless($formateur, 403);

        $anneeId       = $request->integer('annee');
        $mode          = $request->input('mode', 'hebdomadaire') === 'semestriel' ? 'semestriel' : 'hebdomadaire';
        $semaine       = $request->integer('semaine', now()->isoWeek());
        $semestre      = $request->integer('semestre', 1) === 2 ? 2 : 1;
        $annee         = AnneeAcademique::findOrFail($anneeId);
        $etablissement = $formateur->etablissement;

        $creneaux = CreneauEmploiDuTemps::where('personnel_etablissement_id', $formateur->id)
            ->whereHas('emploiDuTemps', function ($q) use ($anneeId, $mode, $semaine, $semestre) {
                $q->where('annee_academique_id', $anneeId)->where('type_planning', $mode);
                if ($mode === 'hebdomadaire') {
                    $q->where('semaine', $semaine)->whereNull('semestre');
                } else {
                    $q->where('semestre', $semestre)->whereNull('semaine');
                }
            })
            ->with(['emploiDuTemps.classe', 'matiere', 'elementCompetence'])
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get()
            ->groupBy(fn($cr) => $cr->emploiDuTemps?->classe_id)
            ->map(fn($classeCreneaux) => [
                'classe'  => $classeCreneaux->first()->emploiDuTemps?->classe,
                'parJour' => $classeCreneaux->groupBy('jour'),
            ]);

        $periodeLabel = $mode === 'hebdomadaire' ? 'Semaine ' . $semaine : 'Semestre ' . $semestre;

        $pdf = Pdf::loadView('emploi-du-temps.pdf-formateur', [
            'creneaux'      => $creneaux,
            'formateur'     => $formateur,
            'etablissement' => $etablissement,
            'annee'         => $annee,
            'mode'          => $mode,
            'semaine'       => $semaine,
            'semestre'      => $semestre,
            'periodeLabel'  => $periodeLabel,
        ])->setPaper('a4', 'portrait');

        $periode = $mode === 'hebdomadaire' ? 'Semaine_' . $semaine : 'Semestre_' . $semestre;

        return $pdf->stream('Planning_' . $periode . '_' . ($annee->annee1 ?? '') . '.pdf');
    }
}
