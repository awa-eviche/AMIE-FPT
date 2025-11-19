<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Evaluation;
use App\Models\Absence;
use App\Models\Inscription;
use App\Models\Matiere;
use App\Models\Apprenant;
use App\Models\HistoryNote;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;
//use Barryvdh\DomPDF\Facade as PDF;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;
use App\Models\Classe;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Illuminate\Support\Facades\File;


//use Barryvdh\DomPDF\Facade\Pdf; // si tu utilises barryvdh/laravel-dompdf


class EvaluationController extends Controller
{
    protected $logUserRepository;
    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
        $this->logUserRepository = $logUserRepository;
    }

    public function index()
    {

        return view('inscription.index');
    }

    public function create($inscriptionId, $matiereId)
    {
        $inscription = Inscription::findOrFail($inscriptionId);
        $matiere = Matiere::findOrFail($matiereId);

        return view('evaluation.evaluationcreate', compact('inscription', 'matiere'));
    }


    public function show($inscriptionId)
    {
        $inscription = Inscription::findOrFail($inscriptionId);


        if ($inscription->classe) {
            $matieres = Matiere::where('niveau_etude_id', $inscription->classe->niveau_etude_id)->get();

            return view('evaluation.evaluationcreate', compact('inscription', 'matieres'));
        } else {
        }
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'inscription_id' => 'required|string|exists:inscriptions,id',
            'matiere_id'     => 'required|string|exists:matieres,id',
            'semestre'       => 'required|in:1,2',
            'note_cc'        => 'required|numeric|max:20',
            'note_composition' => 'required|numeric|max:20',
            // On ne valide pas "appreciation", car elle sera générée automatiquement
        ]);

// ✅ Vérification d’accès AVANT tout enregistrement
    $inscription = Inscription::findOrFail($request->inscription_id);
    $classe = $inscription->classe;
    $user = auth()->user();
    $personnel = $user->personnel;

    if (
        !$user->hasRole('superadmin') &&
        (!$classe || !$classe->formateurs()
            ->where('personnel_etablissement_id', $personnel?->id)
            ->exists())
    ) {
        abort(403, 'Vous n’êtes pas autorisé à évaluer les apprenants de cette classe.');
    }
    
        // Vérification s'il existe déjà une évaluation pour cet apprenant, matière et semestre
        $existingEvaluation = Evaluation::where('inscription_id', $request->inscription_id)
            ->where('matiere_id', $request->matiere_id)
            ->where('semestre', $request->semestre)
            ->exists();
    
        if ($existingEvaluation) {
            return redirect()->route('evaluation.index')
                ->withMessage('Vous avez déjà évalué cet apprenant pour ce semestre et cette matière.');
        }
    
        try {
            // Calcul automatique de la moyenne et de l’appréciation
            $moyenne = $this->calculerMoyenne($request->note_cc, $request->note_composition);
            $appreciation = $this->noteAppreciation($moyenne);
    
            $evaluation = Evaluation::create([
                'inscription_id'   => $request->inscription_id,
                'matiere_id'       => $request->matiere_id,
                'semestre'         => Session::get('selectedsemestre', $request->semestre),
                'note_cc'          => $request->note_cc,
                'note_composition' => $request->note_composition,
                'appreciation'     => $appreciation, // Automatique ici
            ]);
    
            // Historique de modification
            HistoryNote::create([
                'evaluation_id' => $evaluation->id,
                'user_id'       => auth()->user()->id,
            ]);
    
            // Log de l’action
            $this->logUserRepository->store([
                'action'      => UserAction::AddEvaluation,
                'model'       => Model::Evaluation,
                'new_object'  => json_encode($evaluation),
            ]);
    
            return redirect()->route('inscription.index')
                ->with('success', 'Évaluation enregistrée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors('Une erreur s\'est produite lors de l\'enregistrement de l\'évaluation.');
        }
    }
    


    public function edit($evaluationId)
    {
        $evaluation = Evaluation::findOrFail($evaluationId);

        $inscription = $evaluation->inscription;

        if ($inscription && $inscription->classe) {

            $matieres = Matiere::where('niveau_etude_id', $inscription->classe->niveau_etude_id)->get();

            return view('evaluation.evaluationedit', compact('evaluation', 'matieres', 'inscription'));
        } else {
        }
    }



    public function update(Request $request, $evaluationId)
    {
        $evaluation = Evaluation::findOrFail($evaluationId);

$inscription = $evaluation->inscription;
        $classe = $inscription?->classe;
        $user = auth()->user();
        $personnel = $user->personnel;
    
           // ✅ Vérification d’accès : seuls certains rôles peuvent modifier
    if (!(
        $user->hasRole('superadmin') ||
        $user->hasRole('chef_de_travaux') ||
 $user->hasRole('directeur_etude') ||
        $user->hasRole('chef_etablissement')
    )) {
        abort(403, 'Vous n’êtes pas autorisé à modifier les évaluations de cette classe.');
    }
    
        $request->validate([
            'matiere_id' => 'required',
            'semestre' => 'required',
            'note_cc' => 'required|numeric|max:20',
            'note_composition' => 'required|numeric|max:20',
        ]);

        $request->merge(['appreciation' => $this->noteAppreciation($this->calculerMoyenne($request->note_cc, $request->note_composition))]);

        HistoryNote::create([
            'evaluation_id' => $evaluation->id,
            'user_id' => auth()->user()->id,
            'old_note_cc' => $evaluation->note_cc != $request['note_cc'] ? $evaluation->note_cc : null,
            'old_note_composition' => $evaluation->note_composition != $request['note_composition'] ? $evaluation->note_composition : null,
        ]);

        $evaluation->update($request->all());



        return redirect()->route('inscription.index')->withMessage('Évaluation mise à jour avec succès.');
    }


    public function destroy($evaluationId)
    {
        $evaluation = Evaluation::findOrFail($evaluationId);
$inscription = $evaluation->inscription;
        $classe = $inscription?->classe;
        $user = auth()->user();
        $personnel = $user->personnel;
      //  ^|^e V  rification d ^`^yacc  s : seuls certains r  les peuvent modifier
    if (!(
        $user->hasRole('superadmin') ||
        $user->hasRole('chef_de_travaux') ||
 $user->hasRole('directeur_etude') ||
        $user->hasRole('chef_etablissement')
    ))
        {
            abort(403, 'Vous n’êtes pas autorisé à supprimer les évaluations de cette classe.');
        }
        $evaluation->delete();

        return redirect()->route('inscription.index')->with('success', 'Évaluation supprimée avec succès.');
    }
      

public function generatePDF($id)
{
    $semestre = session()->get('selectedsemestre');

    $inscription = Inscription::findOrFail($id);
    $matieres = Matiere::where('niveau_etude_id', $inscription->classe->niveau_etude->id)->get();

    // --- Fonction de calcul de la moyenne par semestre ---
    $calculerMoyenneSemestre = function ($insc, $semestreNum) use ($matieres) {
        $evaluations = Evaluation::where('inscription_id', $insc->id)
            ->where('semestre', $semestreNum)
            ->get();

        $sommeMoyennesPonderees = 0;
        $sommeCoefficients = 0;

        foreach ($matieres as $matiere) {
            $eval = $evaluations->firstWhere('matiere_id', $matiere->id);
            if ($eval) {
                $moyenneMatiere = $this->calculerMoyenne($eval->note_cc, $eval->note_composition);
                $sommeMoyennesPonderees += $moyenneMatiere * $matiere->coef;
                $sommeCoefficients += $matiere->coef;
            }
        }

        return $sommeCoefficients > 0 ? $sommeMoyennesPonderees / $sommeCoefficients : 0;
    };

    // --- Moyennes semestrielles ---
    $moyenneS1 = $calculerMoyenneSemestre($inscription, 1);
    $moyenneS2 = $calculerMoyenneSemestre($inscription, 2);
    $moyenneAnnuelle = ($moyenneS1 + $moyenneS2) / 2;
    $moyenneCourante = $calculerMoyenneSemestre($inscription, $semestre);

    // --- Rang et moyenne de classe ---
    $inscriptionsClasse = Inscription::where('classe_id', $inscription->classe_id)->get();
    $moyennesClasse = [];

    foreach ($inscriptionsClasse as $insc) {
        $moyennesClasse[$insc->id] = $calculerMoyenneSemestre($insc, $semestre);
    }

    arsort($moyennesClasse);
    $position = array_search($inscription->id, array_keys($moyennesClasse)) + 1;
    $effectifClasse = count($moyennesClasse);
    $rangTexte = $position . 'e sur ' . $effectifClasse;
    $moyenneClasse = $effectifClasse > 0 ? array_sum($moyennesClasse) / $effectifClasse : 0;

    // --- Table des moyennes (affichée au 2e semestre) ---
    $moyennesTable = '';
    if ($semestre == 2) {
        $moyennesTable = '
            <table class="full-table" cellspacing="0" style="margin-top: 10px;">
                <tr>
                    <td class="border-td bg-grey bold-exo">Moyenne 1er Semestre</td>
                    <td class="border-td">' . number_format($moyenneS1, 2, ',', '.') . '</td>
                </tr>
                <tr>
                    <td class="border-td bg-grey bold-exo">Moyenne 2e Semestre</td>
                    <td class="border-td">' . number_format($moyenneS2, 2, ',', '.') . '</td>
                </tr>
                <tr>
                    <td class="border-td bg-grey bold-exo">Moyenne Générale Annuelle</td>
                    <td class="border-td">' . number_format($moyenneAnnuelle, 2, ',', '.') . '</td>
                </tr>
            </table>
        ';
    }

    // --- Évaluations du semestre ---
    $evaluations = Evaluation::where('inscription_id', $inscription->id)
        ->where('semestre', $semestre)
        ->get()
        ->keyBy('id');

    $output = '';
    $sommeMoyennesPonderees = 0;
    $sommeCoefficients = 0;

    foreach ($matieres as $matiere) {
        $evaluation = $evaluations->firstWhere('matiere_id', $matiere->id);
        $output .= '<tr class="border-td">';
        $output .= '<td class="border-td">' . ($matiere->nom ?? '-') . '</td>';
        $output .= '<td class="border-td">' . $matiere->coef . '</td>';
        $output .= '<td class="border-td">' . ($evaluation ? $evaluation->note_cc ?? '-' : '-') . '</td>';
        $output .= '<td class="border-td">' . ($evaluation ? $evaluation->note_composition ?? '-' : '-') . '</td>';
        $output .= '<td class="border-td">' . ($evaluation ? $this->calculerMoyenne($evaluation->note_cc, $evaluation->note_composition) : '-') . '</td>';
        $output .= '<td class="border-td">' . ($evaluation ? $evaluation->appreciation ?? '-' : '-') . '</td>';
        $output .= '</tr>';

        if ($evaluation) {
            $moyenneMatiere = $this->calculerMoyenne($evaluation->note_cc, $evaluation->note_composition);
            $sommeMoyennesPonderees += $moyenneMatiere * $matiere->coef;
            $sommeCoefficients += $matiere->coef;
        }
    }

    $moyenneGenerale = $sommeCoefficients > 0 ? $sommeMoyennesPonderees / $sommeCoefficients : 0;

    // --- 🔸 Comptage des absences et retards (hors justifiées) ---
    $absencesSemestre = Absence::where('inscription_id', $inscription->id)
        ->where('semestre', $semestre)
        ->get();

    $nbAbsences = $absencesSemestre
        ->where('type', 'absence')
        ->where('justifie', false)
        ->count();

    $nbRetards = $absencesSemestre->where('type', 'retard')->count();

    // --- 🔹 Préparer le PDF ---
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->setFontCache(storage_path('fonts'));
    $options->set('isRemoteEnabled', true);
    $options->set('pdfBackend', 'GD');
    $options->setChroot(['/', storage_path('fonts')]);

    $template = file_get_contents('evaluation.html');
    $template = str_replace('[BODY]', $output, $template);
    $template = str_replace('[TABLE_MOYENNES]', $moyennesTable, $template);
    $template = str_replace('[RANG]', $rangTexte, $template);
    $template = str_replace('[MOYENNE_CLASSE]', number_format($moyenneClasse, 2, ',', '.'), $template);

    // 🔸 Injection des absences et retards
    $template = str_replace('[NB_ABSENCES]', $nbAbsences, $template);
    $template = str_replace('[NB_RETARDS]', $nbRetards, $template);

    // --- Date en français ---
    setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr');
    $date = strftime('%e %B %Y');
    $template = str_replace('[DATE]', ucfirst($date), $template);

    // --- Infos Apprenant / Classe ---
    $template = str_replace('[USER]', $inscription->apprenant->nom . ' ' . $inscription->apprenant->prenom, $template);
    $template = str_replace('[DATENAISSANCE]', $inscription->apprenant->date_naissance, $template);
    $template = str_replace('[LIEUNAISSANCE]', $inscription->apprenant->lieu_naissance, $template);
    $template = str_replace('[TEL]', $inscription->apprenant->telephone, $template);
    $template = str_replace('[EMAIL]', $inscription->apprenant->email, $template);
    $template = str_replace('[MATRICULE]', $inscription->apprenant->matricule, $template);
    $template = str_replace('[SEMESTRE]', $semestre, $template);
    $template = str_replace('[CLASSE]', $inscription->classe->libelle ?? '', $template);
    $template = str_replace('[ANNEE]', $inscription->classe->niveau_etude->nom ?? '', $template);
    $template = str_replace('[ANNEESCOLAIRE]', $inscription->classe->annee_academique->code ?? '', $template);
    $template = str_replace('[EFPT]', $inscription->classe->etablissement->nom ?? '', $template);
    $template = str_replace('[EFPTTEL]', $inscription->classe->etablissement->telephone ?? '', $template);
    $template = str_replace('[MOYENNE]', number_format($moyenneGenerale, 2, ',', '.'), $template);

    // --- Génération du PDF ---
    $dompdf->loadHtml($template);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $nom = 'bulletin_note_semestre_' . $semestre . '.pdf';
    $dompdf->stream($nom, ['Attachment' => false]);
}


    public function calculerMoyenne($note_cc, $note_composition)
    {

        if ($note_cc !== null && $note_composition !== null) {

            $moyenne = ($note_cc + $note_composition) / 2;
            return $moyenne;
        } else {

            return null;
        }
    }

    
    public function noteAppreciation($note)
{
    if ($note < 10) {
        return "Insuffisant";
    } else if ($note >= 10 && $note < 12) {
        return "Passable";
    } else if ($note >= 12 && $note < 14) {
        return "Assez Bien";
    } else if ($note >= 14 && $note < 16) {
        return "Bien";
    } else if ($note >= 16 && $note < 18) {
        return "Bon Travail";
    } else { // note >= 18
        return "Très Bon Travail";
    }
}







public function previewClasseBulletins($classe_id, $semestre)
{
    $classe = Classe::with(['etablissement', 'inscriptions.apprenant'])->findOrFail($classe_id);
    $inscriptions = $classe->inscriptions;

    if ($inscriptions->isEmpty()) {
        return back()->with('error', 'Aucun apprenant trouvé pour cette classe.');
    }

    // 🔹 Charger le modèle HTML
    $templatePath = public_path('evaluation.html');
    if (!file_exists($templatePath)) {
        return back()->with('error', 'Le modèle evaluation.html est introuvable.');
    }

    $template = file_get_contents($templatePath);
    $html = '';

    /**
     * 🧮 Étape 1 : Calcul des moyennes et rangs
     */
    $moyennes = [];

    foreach ($inscriptions as $inscription) {
        $evaluations = Evaluation::where('inscription_id', $inscription->id)
            ->where('semestre', $semestre)
            ->with('matiere')
            ->get();

        $total = 0;
        $coefTotal = 0;
        foreach ($evaluations as $eval) {
            $moy = (($eval->note_cc ?? 0) + ($eval->note_composition ?? 0)) / 2;
            $total += $moy * ($eval->matiere->coef ?? 1);
            $coefTotal += ($eval->matiere->coef ?? 1);
        }

        $moyennes[$inscription->id] = $coefTotal > 0 ? round($total / $coefTotal, 2) : 0;
    }

    // 🔹 Moyenne de la classe
    $moyenneClasse = count($moyennes) ? round(array_sum($moyennes) / count($moyennes), 2) : 0;

    // 🔹 Rangs
    arsort($moyennes);
    $rangs = [];
    $position = 1;
    foreach ($moyennes as $id => $moy) {
        $rangs[$id] = $position++;
    }

    /**
     * 🧾 Étape 2 : Bulletins individuels
     */
    foreach ($inscriptions as $inscription) {
        $apprenant = $inscription->apprenant;
        $evaluations = Evaluation::where('inscription_id', $inscription->id)
            ->where('semestre', $semestre)
            ->with('matiere')
            ->get();

        $body = '';
        $total = 0;
        $coefTotal = 0;

        foreach ($evaluations as $eval) {
            $moy = (($eval->note_cc ?? 0) + ($eval->note_composition ?? 0)) / 2;
            $total += $moy * ($eval->matiere->coef ?? 1);
            $coefTotal += ($eval->matiere->coef ?? 1);

            $body .= '
                <tr>
                    <td class="border-td">' . ($eval->matiere->nom ?? '-') . '</td>
                    <td class="border-td centered">' . ($eval->matiere->coef ?? '-') . '</td>
                    <td class="border-td centered">' . ($eval->note_cc ?? '-') . '</td>
                    <td class="border-td centered">' . ($eval->note_composition ?? '-') . '</td>
                    <td class="border-td centered">' . number_format($moy, 2) . '</td>
                    <td class="border-td centered">' . $this->getAppreciation($moy) . '</td>
                </tr>';
        }

        $moyenne = $coefTotal > 0 ? number_format($total / $coefTotal, 2) : '-';
        $rang = $rangs[$inscription->id] ?? '-';

        // Remplacement des variables dans le template
        $content = str_replace(
            ['[EFPT]', '[EFPTTEL]', '[CLASSE]', '[SEMESTRE]', '[ANNEESCOLAIRE]', '[USER]',
             '[DATENAISSANCE]', '[LIEUNAISSANCE]', '[TEL]', '[EMAIL]', '[MATRICULE]',
             '[BODY]', '[MOYENNE]', '[MOYENNE_CLASSE]', '[RANG]', '[DATE]', '[TABLE_MOYENNES]'],
            [
                $classe->etablissement->nom ?? '---',
                $classe->etablissement->telephone ?? '---',
                $classe->libelle ?? '',
                $semestre,
                now()->year,
                strtoupper(($apprenant->prenom ?? '') . ' ' . ($apprenant->nom ?? '')),
                $apprenant->date_naissance ?? '-',
                $apprenant->lieu_naissance ?? '-',
                $apprenant->telephone ?? '-',
                $apprenant->email ?? '-',
                $apprenant->matricule ?? '-',
                $body,
                $moyenne,
                $moyenneClasse,
                $rang,
                now()->format('d/m/Y'),
                ''
            ],
            $template
        );

        $html .= '<div style="page-break-after: always;">' . $content . '</div>';


    }

    /**
     * 📊 Étape 3 : Tableau récapitulatif des moyennes
     */
    $html .= '
        <h3 style="text-align:center; margin-top:30px;">Tableau Récapitulatif des Résultats - Classe : ' . e($classe->libelle) . '</h3>
        <table style="width:100%; border-collapse:collapse; margin-top:10px; font-size:12px;">
            <thead>
                <tr style="background-color:#f1f1f1; border:1px solid #000;">
                    <th style="border:1px solid #000; padding:4px;">N°</th>
                    <th style="border:1px solid #000; padding:4px;">Apprenant</th>
                    <th style="border:1px solid #000; padding:4px;">Moyenne</th>
                    <th style="border:1px solid #000; padding:4px;">Rang</th>
                    <th style="border:1px solid #000; padding:4px;">Mention</th>
                </tr>
            </thead>
            <tbody>';

    $i = 1;
    foreach ($rangs as $id => $rang) {
        $inscription = $inscriptions->firstWhere('id', $id);
        $apprenant = $inscription?->apprenant;
        $html .= '
            <tr>
                <td style="border:1px solid #000; padding:4px; text-align:center;">' . $i++ . '</td>
                <td style="border:1px solid #000; padding:4px;">' . strtoupper(($apprenant->prenom ?? '') . ' ' . ($apprenant->nom ?? '')) . '</td>
                <td style="border:1px solid #000; padding:4px; text-align:center;">' . number_format($moyennes[$id], 2) . '</td>
                <td style="border:1px solid #000; padding:4px; text-align:center;">' . $rang . '</td>
                <td style="border:1px solid #000; padding:4px; text-align:center;">' . $this->getAppreciation($moyennes[$id]) . '</td>
            </tr>';
    }

    $html .= '
            </tbody>
        </table>';

    // Générer le PDF dans le navigateur
    $pdf = Pdf::loadHTML($html)->setPaper('A4', 'portrait');
    return $pdf->stream('Bulletins_' . str_replace(' ', '_', $classe->libelle) . '_Semestre_' . $semestre . '.pdf');
}

private function getAppreciation($note)
{
    if ($note < 5) return "Insuffisant";
    if ($note < 10) return "Médiocre";
    if ($note < 12) return "Passable";
    if ($note < 14) return "Assez Bien";
    if ($note < 16) return "Bien";
    if ($note < 18) return "Très Bien";
    return "Excellent";
}



}
