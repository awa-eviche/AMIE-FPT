<?php

namespace App\Http\Controllers;
use App\Models\Absence;
use App\Models\Classe;
use App\Models\Ressource;
use App\Models\Sommation;
use App\Models\Competence;
use App\Models\Inscription;
use App\Models\ElementCompetence;
use App\Models\Critere;
use App\Models\NiveauEtude;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class EvaluationSomativeController extends Controller
{
    public function index()
    {
        return view('evaluation.sommative.page');
    }

    
   public function generateClassePdf(Request $request, string $classe_id)
{
    $semestreInt = $request->semestre 
        ? (int) $request->semestre 
        : null;

    $semestreLabel = $semestreInt 
        ? $semestreInt 
        : 'Tous les semestres';
    $classe = Classe::with([
        'niveau_etude',
        'annee_academique',
        'etablissement',
        'inscriptions.apprenant'
    ])->findOrFail($classe_id);

    $classeId = $classe->id;
    $niveauId = $classe->niveau_etude_id;

    /* ===============================
       COMPÉTENCES GÉNÉRALES
    ===============================*/
    $competencesGenerales = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'generale')
        ->whereHas('ressources.classe', function ($q) use ($classeId) {
            $q->where('classes.id', $classeId);
        })
        ->with(['ressources' => function ($q) use ($classeId) {
            $q->whereHas('classe', function ($qq) use ($classeId) {
                $qq->where('classes.id', $classeId);
            })->orderBy('nom');
        }])
        ->get();

    /* ===============================
       COMPÉTENCES PARTICULIÈRES
    ===============================*/
    $competencesParticulieres = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'particuliere')
        ->with('elementCompetences.criteres')
        ->get();

    // Logo base64
    $logoPath = public_path('assets/images/titleHead.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }

    $fmt = fn($n) => rtrim(rtrim(number_format((float)$n, 2, '.', ''), '0'), '.');

    $bulletins = '';

    foreach ($classe->inscriptions as $inscription) {

        $evaluations = Sommation::where('inscription_id', $inscription->id)
            ->when($semestreInt, fn($q) => $q->where('semestre', $semestreInt))
            ->get();

        /* =====================================================
           TABLEAU 1 : COMPÉTENCES GÉNÉRALES
        ======================================================*/
        $htmlRessources = '';

        foreach ($competencesGenerales as $competence) {
            foreach ($competence->ressources as $res) {

                $evaluation = $evaluations
                    ->whereNotNull('ressource_id')
                    ->firstWhere('ressource_id', $res->id);

                $note = $evaluation?->note;
                $appreciation = '-';

                if ($note !== null) {
                    if ($note >= 16) $appreciation = "Excellent travail";
                    elseif ($note >= 14) $appreciation = "Bien";
                    elseif ($note >= 12) $appreciation = "Assez bien";
                    elseif ($note >= 10) $appreciation = "Passable";
                    elseif ($note >= 8) $appreciation = "Travail insuffisant";
                    else $appreciation = "Très insuffisant";
                }

                $htmlRessources .= "
                <tr>
                    <td class='border-td'>".htmlspecialchars($res->nom)."</td>
                    <td class='border-td text-center'>".($note ?? '-')."</td>
                    <td class='border-td text-center'>".$appreciation."</td>
                </tr>";
            }
        }

        if (trim($htmlRessources) === '') {
            $htmlRessources = "
            <tr>
                <td colspan='3' class='border-td text-center'>
                    Aucune ressource évaluée
                </td>
            </tr>";
        }

        /* =====================================================
           TABLEAU 2 : COMPÉTENCES PARTICULIÈRES
        ======================================================*/
        $htmlCompetences = '';

        foreach ($competencesParticulieres as $competence) {

            $firstRow = true;
            $rowCount = $competence->elementCompetences
                ->sum(fn($el) => $el->criteres->count());

            foreach ($competence->elementCompetences as $element) {
                foreach ($element->criteres as $critere) {

                    $evaluation = $evaluations
                        ->whereNotNull('critere_id')
                        ->firstWhere('critere_id', $critere->id);

                    $acquis    = $evaluation?->acquis == 1 ? 'X' : '';
                    $nonacquis = $evaluation?->nonacquis == 1 ? 'X' : '';

                    $htmlCompetences .= '<tr>';

                    if ($firstRow) {
                        $htmlCompetences .= '
                        <td rowspan="'.$rowCount.'" class="border-td bold-exo">
                            '.htmlspecialchars($competence->nom).'
                        </td>';
                        $firstRow = false;
                    }

                    $htmlCompetences .= "
                        <td class='border-td'>".htmlspecialchars($element->nom)."</td>
                        <td class='border-td'>".htmlspecialchars($critere->libelle)."</td>
                        <td class='border-td text-center'>{$acquis}</td>
                        <td class='border-td text-center'>{$nonacquis}</td>
                    </tr>";
                }
            }
        }

        if (trim($htmlCompetences) === '') {
            $htmlCompetences = "
            <tr>
                <td colspan='4' class='border-td text-center'>
                    Aucune compétence particulière évaluée
                </td>
            </tr>";
        }

        /* =====================================================
           ABSENCES & RETARDS
        ======================================================*/
        $absencesSemestre = Absence::where('inscription_id', $inscription->id)
            ->when($semestreInt, fn($q) => $q->where('semestre', $semestreInt))
            ->get();

        $hAbsJust = (float) $absencesSemestre->where('type','absence')->where('justifie', 1)->sum('nombre_heure_absence');
        $hAbsNon  = (float) $absencesSemestre->where('type','absence')->where('justifie', 0)->sum('nombre_heure_absence');
        $hRetJust = (float) $absencesSemestre->where('type','retard')->where('justifie', 1)->sum('nombre_heure_retard');
        $hRetNon  = (float) $absencesSemestre->where('type','retard')->where('justifie', 0)->sum('nombre_heure_retard');

        $hAbsTotal = $hAbsJust + $hAbsNon;
        $hRetTotal = $hRetJust + $hRetNon;

        /* =====================================================
           TEMPLATE
        ======================================================*/
        $template = file_get_contents('sommation.html');

        setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr');
        $dateNow = trim(strftime('%e %B %Y'));
        $anneeScolaire = $classe->annee_academique->code ?? '';

        $page = str_replace([
            '[LOGO]',
            '[BODYRESSOURCE]',
            '[BODYCOMP]',
            '[NB_ABSENCES]',
            '[NB_RETARDS]',
            '[DATE]',
            '[ANNEESCOLAIRE]',
            '[USER]',
            '[DATENAISSANCE]',
            '[LIEUNAISSANCE]',
            '[MATRICULE]',
            '[TEL]',
            '[CLASSE]',
            '[SEMESTRE]',
            '[EFPT]',
            '[EFPTTEL]',
            '[EFPTMAIL]',
        ], [
            $logoBase64,
            $htmlRessources,
            $htmlCompetences,
            $fmt($hAbsTotal),
            $fmt($hRetTotal),
            $dateNow,
            $anneeScolaire,
            $inscription->apprenant->nom.' '.$inscription->apprenant->prenom,
            $inscription->apprenant->date_naissance ?? '',
            $inscription->apprenant->lieu_naissance ?? '',
            $inscription->apprenant->matricule ?? '',
            $inscription->apprenant->telephone ?? '',
            $classe->libelle,
            $semestreLabel,
            $classe->etablissement->nom ?? '',
            $classe->etablissement->telephone ?? '',
            $classe->etablissement->email ?? '',
        ], $template);

        $bulletins .= $page.'<div style="page-break-after: always;"></div>';
    }

    $dompdf = new Dompdf();
    $dompdf->getOptions()->set('isRemoteEnabled', true);
    $dompdf->loadHtml($bulletins);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Carnet_'.$classe->libelle.'.pdf"');
}

}
