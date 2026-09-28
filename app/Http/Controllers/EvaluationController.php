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
use App\Models\Devoir;


//use Barryvdh\DomPDF\Facade\Pdf; // si tu utilises barryvdh/laravel-dompdf


class EvaluationController extends Controller
{
    /**
     * CSS de compaction pour garder le bulletin sur une seule page, quel que
     * soit le nombre de matières. $scale va de 1.0 (aucune réduction, tailles
     * d'origine du template) à 0.55 (compaction maximale). Couvre tous les
     * blocs qui peuvent pousser le contenu sur une 2e page : le tableau des
     * matières, l'en-tête, le bandeau de titre et le bloc mentions/observations
     * (qui avaient des tailles figées, jamais réduites auparavant).
     */
    private function compactStyleFor(float $scale, string $scope = ''): string
    {
        $scale = max(0.55, min(1.0, $scale));

        $bodyFont     = round(10.5 * $scale, 2);
        $lineHeight   = max(0.95, round(1.2 * $scale, 2));
        $pad          = max(0.4, round(2 * $scale, 2));
        $mentionsFont = round(9.5 * $scale, 2);
        $obsHeight    = max(18, round(70 * $scale));
        $h1           = round(18 * $scale, 1);
        $h2           = round(13 * $scale, 1);
        $pFont        = round(12 * $scale, 1);
        $titleFont    = max(11, round(18 * $scale, 1));

        // ✅ Si $scope est fourni (ex: ".bulletin-42"), chaque règle est
        // limitée à ce sous-arbre : indispensable quand plusieurs bulletins
        // (avec chacun leur propre échelle de compaction) sont regroupés dans
        // un même document PDF — sinon des règles non préfixées (body,
        // .border-td...) s'appliqueraient à tout le document et écraseraient
        // la compaction des autres bulletins.
        $root = $scope !== '' ? $scope : 'body';
        $d    = $scope !== '' ? $scope . ' ' : '';

        return "
            {$root} { font-size: {$bodyFont}px !important; line-height: {$lineHeight} !important; }
            {$d}.border-td { padding: {$pad}px !important; }
            {$d}header h1 { font-size: {$h1}px !important; }
            {$d}header h2 { font-size: {$h2}px !important; }
            {$d}header p { font-size: {$pFont}px !important; }
            {$d}header { margin-bottom: 4px !important; }
            {$d}header h1, {$d}header h2, {$d}header p { margin: 1px 0 !important; }
            {$d}.sep-solid, {$d}.sep-dash { margin: 2px auto !important; }
            {$d}.title-band { font-size: {$titleFont}px !important; padding: 3px 8px !important; margin: 3px 0 5px 0 !important; }
            {$d}.infos { margin-top: 2px !important; margin-bottom: 3px !important; }
            {$d}.bloc-mentions table { font-size: {$mentionsFont}px !important; margin-top: 2px !important; }
            {$d}.obs-box { min-height: {$obsHeight}px !important; }
        ";
    }

    /**
     * Injecte la CSS de compaction dans $templateBase (qui contient encore le
     * marqueur </style> intact) puis rend le PDF ; si le résultat déborde sur
     * plusieurs pages, recommence avec une compaction plus forte, jusqu'à ce
     * que tout tienne sur une seule page (ou que la compaction max soit
     * atteinte). Retourne le HTML final (avec la CSS choisie déjà injectée)
     * et l'échelle retenue, pour pouvoir la réutiliser sans re-mesurer.
     *
     * Si $scope est fourni (ex: ".bulletin-42", pour un bulletin de classe où
     * plusieurs élèves sont regroupés dans un même document), la mesure est
     * faite sur la structure EXACTEMENT telle qu'elle sera assemblée dans le
     * document final (contenu isolé dans un <div class="...">) : mesurer sur
     * <body> directement puis extraire le fragment donnerait une échelle
     * légèrement optimiste, le <div> supplémentaire pouvant suffire à faire
     * déborder un ajustement pile-poil.
     */
    private function fitContentOnePage(string $templateBase, \Dompdf\Options $options, string $scope = ''): array
    {
        $scale = 1.0;
        $html  = $templateBase;

        for ($attempt = 0; $attempt < 4; $attempt++) {
            $html = str_replace('</style>', $this->compactStyleFor($scale, $scope) . '</style>', $templateBase);

            if ($scope !== '') {
                $scopeClass = ltrim($scope, '.');
                $wrapped = '<div class="' . $scopeClass . '">' . $this->extractBodyContent($html) . '</div>';
                $html = $this->injectBodyContent($html, $wrapped);
            }

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $pages = $dompdf->getCanvas()->get_page_count();
            if ($pages <= 1 || $scale <= 0.55) {
                break;
            }

            $scale = max(0.55, $scale - 0.12 * $pages);
        }

        return [$html, $scale];
    }

    /**
     * Extrait uniquement le contenu de <body>...</body> d'un document HTML
     * complet. Utilisé pour regrouper plusieurs bulletins dans un seul
     * document final au lieu de concaténer des <html>/<body> complets (que
     * Dompdf aplatit en un seul <body>, faisant "fuir" les <style> de l'un
     * sur les autres).
     */
    private function extractBodyContent(string $html): string
    {
        $bodyOpenPos = strpos($html, '<body');
        if ($bodyOpenPos === false) {
            return $html;
        }
        $bodyOpenEnd = strpos($html, '>', $bodyOpenPos) + 1;

        $bodyClosePos = strpos($html, '</body>');
        if ($bodyClosePos === false) {
            return substr($html, $bodyOpenEnd);
        }

        return substr($html, $bodyOpenEnd, $bodyClosePos - $bodyOpenEnd);
    }

    /**
     * Remplace le contenu de <body>...</body> de $template par $bodyContent.
     */
    private function injectBodyContent(string $template, string $bodyContent): string
    {
        $bodyOpenPos = strpos($template, '<body');
        if ($bodyOpenPos === false) {
            return $template . $bodyContent;
        }
        $bodyOpenEnd = strpos($template, '>', $bodyOpenPos) + 1;

        $bodyClosePos = strpos($template, '</body>');
        if ($bodyClosePos === false) {
            return substr($template, 0, $bodyOpenEnd) . $bodyContent;
        }

        return substr($template, 0, $bodyOpenEnd) . $bodyContent . substr($template, $bodyClosePos);
    }

    /**
     * Bloc mentions : la mention (Félicitations...) reste toujours en 1ère position.
     * En 2e position : mentions de travail (Travail excellent...) au 1er semestre,
     * décision du conseil (passage/redoublement/exclusion) au 2e semestre.
     */
    private function blocMentionsHtml(int $semestre): string
    {
        $mention = '
            <table class="full-table" cellspacing="0" style="font-size:9.5px; white-space:nowrap;">
                <colgroup><col><col style="width:22px;"></colgroup>
                <tr><td class="border-td">Félicitations</td><td class="border-td" style="width:22px;"></td></tr>
                <tr><td class="border-td">Encouragements</td><td class="border-td" style="width:22px;"></td></tr>
                <tr><td class="border-td">Tableau d\'honneur</td><td class="border-td" style="width:22px;"></td></tr>
                <tr><td class="border-td">Passable</td><td class="border-td" style="width:22px;"></td></tr>
                <tr><td class="border-td">Doit redoubler d\'effort</td><td class="border-td" style="width:22px;"></td></tr>
                <tr><td class="border-td">Avertissement</td><td class="border-td" style="width:22px;"></td></tr>
                <tr><td class="border-td">Blâme</td><td class="border-td" style="width:22px;"></td></tr>
            </table>
        ';

        if ($semestre === 2) {
            $second = '
                <table class="full-table" cellspacing="0" style="font-size:9.5px; white-space:nowrap;">
                    <tr>
                        <td class="border-td bg-grey bold-exo centered" style="width:82%;">Décision du Conseil</td>
                        <td class="border-td bg-grey" style="width:18%;"></td>
                    </tr>
                    <tr><td class="border-td" style="width:82%;">Admis(e) en classe supérieure</td><td class="border-td" style="width:18%;"></td></tr>
                    <tr><td class="border-td" style="width:82%;">Autorisé(e) à redoubler</td><td class="border-td" style="width:18%;"></td></tr>
                    <tr><td class="border-td" style="width:82%;">Exclusion</td><td class="border-td" style="width:18%;"></td></tr>
                </table>
            ';
        } else {
            $second = '
                <table class="full-table" cellspacing="0" style="font-size:9.5px; white-space:nowrap;">
                    <colgroup><col><col style="width:22px;"></colgroup>
                    <tr><td class="border-td">Travail excellent</td><td class="border-td" style="width:22px;"></td></tr>
                    <tr><td class="border-td">Satisfaisant doit continuer</td><td class="border-td" style="width:22px;"></td></tr>
                    <tr><td class="border-td">Peut mieux faire</td><td class="border-td" style="width:22px;"></td></tr>
                    <tr><td class="border-td">Insuffisant</td><td class="border-td" style="width:22px;"></td></tr>
                    <tr><td class="border-td">Risque de redoubler</td><td class="border-td" style="width:22px;"></td></tr>
                    <tr><td class="border-td">Risque l\'exclusion</td><td class="border-td" style="width:22px;"></td></tr>
                </table>
            ';
        }

        return '
            <table class="full-table" cellspacing="0">
                <tr>
                    <td style="width:50%; vertical-align:top; padding:0 4px 0 0;">' . $mention . '</td>
                    <td style="width:50%; vertical-align:top; padding:0 0 0 4px;">' . $second . '</td>
                </tr>
            </table>
        ';
    }

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

    // public function create($inscriptionId, $matiereId)
    // {
    //     $inscription = Inscription::findOrFail($inscriptionId);
    //     $matiere = Matiere::findOrFail($matiereId);

    //     return view('evaluation.evaluationcreate', compact('inscription', 'matiere'));
    // }
    


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
        $semestre = Session::get('selectedsemestre', $request->semestre);

        $request->validate([
            'inscription_id' => 'required|string|exists:inscriptions,id',
            'matiere_id'     => 'required|string|exists:matieres,id',
            'semestre'       => 'required|in:1,2',
           // 'note_cc'        => 'required|numeric|max:20',
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
    
       
        $existingEvaluation = Evaluation::where('inscription_id', $request->inscription_id)
            ->where('matiere_id', $request->matiere_id)
            ->where('semestre', $request->semestre)
            ->exists();
    
        if ($existingEvaluation) {
            return redirect()->route('evaluation.index')
                ->withMessage('Vous avez déjà évalué cet apprenant pour ce semestre et cette matière.');
        }
    
        try {

            // ✅ 1. Calcul automatique de la moyenne CC depuis les devoirs
            $moyenneCC = Devoir::where([
                'inscription_id' => $request->inscription_id,
                'matiere_id'     => $request->matiere_id,
                'semestre'       => $request->semestre,
            ])->avg('note');
        
            $moyenneCC = round($moyenneCC ?? 0, 2);
        
            // ✅ 2. Calcul de la moyenne finale
            $moyenne = $this->calculerMoyenne($moyenneCC, $request->note_composition);
        
            // ✅ 3. Appréciation automatique
            $appreciation = $this->noteAppreciation($moyenne);
        
            // ✅ 4. Enregistrement de l’évaluation
            $evaluation = Evaluation::create([
                'inscription_id'   => $request->inscription_id,
                'matiere_id'       => $request->matiere_id,
               // 'semestre'         => Session::get('selectedsemestre', $request->semestre),
               'semestre'         => $semestre,
                'note_cc'          => $moyenneCC, // 🔥 AUTO
                'note_composition' => $request->note_composition,
                'appreciation'     => $appreciation,
            ] + \App\Services\AnneeDesNotes::attributs('evaluations', $inscription->annee_academique_id));

            // Historique
            HistoryNote::create([
                'evaluation_id' => $evaluation->id,
                'user_id'       => auth()->user()->id,
            ]);
        
            // Log
            $this->logUserRepository->store([
                'action'      => UserAction::AddEvaluation,
                'model'       => Model::Evaluation,
                'new_object'  => json_encode($evaluation),
            ]);
        
            return redirect()->route('inscription.index')
                ->with('success', 'Évaluation enregistrée avec succès.');
        
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors('Une erreur s\'est produite lors de l\'enregistrement.');
        }
        dd(
            $semestre,
            Devoir::where('semestre', $semestre)->count(),
            Devoir::where('inscription_id', $request->inscription_id)->count()
        );
        
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
    
        // ✅ Autorisation : rôles + formateur assigné
        $isFormateurAssigne = $classe
            ? $classe->formateurs()
                ->where('personnel_etablissement_id', $personnel?->id)
                ->exists()
            : false;
    
        if (!(
            $user->hasRole('superadmin') ||
            $user->hasRole('chef_de_travaux') ||
            $user->hasRole('directeur_etude') ||
            $user->hasRole('chef_etablissement') ||
            $isFormateurAssigne
        )) {
            abort(403, 'Vous n’êtes pas autorisé à modifier cette évaluation.');
        }
    
        // ✅ Validation : PLUS DE note_cc
        $request->validate([
            'note_composition' => 'required|numeric|min:0|max:20',
            'semestre' => 'required|in:1,2',
            'matiere_id' => 'required',
        ]);
    
        // ✅ Recalcul automatique du CC depuis les devoirs
        $moyenneCC = Devoir::where([
            'inscription_id' => $evaluation->inscription_id,
            'matiere_id'     => $evaluation->matiere_id,
            'semestre'       => $evaluation->semestre,
        ])->avg('note');
    
        $moyenneCC = round($moyenneCC ?? 0, 2);
    
        // ✅ Moyenne finale
        $moyenne = $this->calculerMoyenne($moyenneCC, $request->note_composition);
    
        // ✅ Appréciation
        $appreciation = $this->noteAppreciation($moyenne);
    
        // ✅ Historique (trace propre)
        HistoryNote::create([
            'evaluation_id' => $evaluation->id,
            'user_id' => $user->id,
            'old_note_cc' => $evaluation->note_cc != $moyenneCC ? $evaluation->note_cc : null,
            'old_note_composition' =>
                $evaluation->note_composition != $request->note_composition
                    ? $evaluation->note_composition
                    : null,
        ]);
    
        // ✅ Mise à jour finale
        $evaluation->update([
            'note_cc' => $moyenneCC, 
            'note_composition' => $request->note_composition,
            'appreciation' => $appreciation,
        ]);
    
        return redirect()
            ->route('inscription.index')
            ->with('success', 'Évaluation mise à jour avec succès.');
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
    $semestre = (int) session()->get('selectedsemestre', 1);

    $inscription = Inscription::findOrFail($id);
$classeId = (int) $inscription->classe_id;
    $anneeId = $inscription->annee_academique_id;
    // Matieres de la classe (PPO), affectées pour l'année de l'inscription
  $matieres = Matiere::where('niveau_etude_id', $inscription->classe->niveau_etude->id)
    ->whereIn('id', function ($query) use ($classeId, $anneeId) {
        $query->select('matiere_id')
              ->from('classe_formateur_matiere')
              ->where('classe_id', $classeId)
              ->when($anneeId, fn ($q) => $q->where('annee_academique_id', $anneeId))
              ->whereNotNull('formateur_id'); // matière réellement assignée
    })
    ->get();

    
    $moyenneMatiereFn = function ($note_cc, $note_composition) {
        if ($note_cc === null || $note_composition === null) return null;
        return (((float)$note_cc + (float)$note_composition) / 2);
    };
    $calculerMoyenneSemestre = function ($insc, int $semestreNum) use ($matieres, $moyenneMatiereFn) {

        $evaluations = Evaluation::where('inscription_id', $insc->id)
            ->where('semestre', $semestreNum)
            ->get()
            ->keyBy('matiere_id');

        $sumTotal = 0.0; // Σ(moyenne*coef)
        $sumCoef  = 0.0; // Σ coef

        foreach ($matieres as $matiere) {
            $coef = (float)($matiere->coef ?? 0);
            if ($coef <= 0) continue;

            $eval = $evaluations->get($matiere->id);
            if (!$eval) continue;

            $moy = $moyenneMatiereFn($eval->note_cc, $eval->note_composition);
            if ($moy === null) continue;

            $sumTotal += ($moy * $coef);
            $sumCoef  += $coef;
        }

        return $sumCoef > 0 ? round($sumTotal / $sumCoef, 2) : 0.0;
    };


    $moyenneS1 = $calculerMoyenneSemestre($inscription, 1);
    $moyenneS2 = $calculerMoyenneSemestre($inscription, 2);
    $moyenneAnnuelle = round((($moyenneS1 + $moyenneS2) / 2), 2);
    $moyenneCourante = $calculerMoyenneSemestre($inscription, $semestre);

    // --- Rang et moyenne de classe ---
    $inscriptionsClasse = Inscription::where('classe_id', $inscription->classe_id)
        ->where('annee_academique_id', $inscription->annee_academique_id)
        ->get();

    $moyennesClasse = [];
    foreach ($inscriptionsClasse as $insc) {
        $moyennesClasse[$insc->id] = $calculerMoyenneSemestre($insc, $semestre);
    }

    arsort($moyennesClasse); // décroissant
    $position = array_search($inscription->id, array_keys($moyennesClasse), true);
    $position = $position === false ? 0 : ($position + 1);

    $effectifClasse = count($moyennesClasse);
    $rangTexte = $position . '/ ' . $effectifClasse;
    $moyenneClasse = $effectifClasse > 0 ? round(array_sum($moyennesClasse) / $effectifClasse, 2) : 0.0;

    // --- Table des moyennes (affichée au 2e semestre) ---
    $moyennesTable = '';
    if ($semestre === 2) {
        $moyennesTable = '
            <table class="full-table" cellspacing="0" style="margin-top: 10px;">
                <tr>
                    <td class="border-td bg-grey bold-exo centered">Moy. 1er Sem : ' . number_format($moyenneS1, 2, ',', '.') . '</td>
                    <td class="border-td bg-grey bold-exo centered">Moy. 2e Sem : ' . number_format($moyenneS2, 2, ',', '.') . '</td>
                    <td class="border-td bg-grey bold-exo centered">Moy. Annuelle : ' . number_format($moyenneAnnuelle, 2, ',', '.') . '</td>
                </tr>
            </table>
        ';
    }

    // --- Évaluations du semestre ---
    $evaluations = Evaluation::where('inscription_id', $inscription->id)
        ->where('semestre', $semestre)
        ->get()
        ->keyBy('matiere_id');

    // --- Construction du tableau du bulletin (avec TOTAL) ---
    $output = '';
    $sumTotal = 0.0;
    $sumCoef  = 0.0;

    foreach ($matieres as $matiere) {

        $evaluation = $evaluations->get($matiere->id);

        // ✅ Une matière sans aucune note (ni devoir/CC, ni composition) ne
        // doit pas apparaître sur le bulletin.
        if (!$evaluation || ($evaluation->note_cc === null && $evaluation->note_composition === null)) {
            continue;
        }

        $coef = (float)($matiere->coef ?? 0);

        $moyenneMatiere = null;
        $total = null;

        if ($evaluation && $coef > 0) {
            $moyenneMatiere = $moyenneMatiereFn($evaluation->note_cc, $evaluation->note_composition);
            if ($moyenneMatiere !== null) {
                $total = $moyenneMatiere * $coef;

                $sumTotal += $total;  // Σ Total
                $sumCoef  += $coef;   // Σ Coef
            }
        }

        $appreciation = $moyenneMatiere !== null
            ? $this->noteAppreciation($moyenneMatiere)
            : '-';

        $output .= '<tr class="border-td">';
        $output .= '<td class="border-td">' . ($matiere->nom ?? '-') . '</td>';
        $output .= '<td class="border-td">' . ($matiere->coef ?? '-') . '</td>';
        $output .= '<td class="border-td">' . ($evaluation ? ($evaluation->note_cc ?? '-') : '-') . '</td>';
        $output .= '<td class="border-td">' . ($evaluation ? ($evaluation->note_composition ?? '-') : '-') . '</td>';
        $output .= '<td class="border-td">' . ($moyenneMatiere !== null ? number_format($moyenneMatiere, 2, ',', '.') : '-') . '</td>';

        $output .= '<td class="border-td">' . $appreciation . '</td>'; 
        $output .= '</tr>';
    }

    // ✅ Moyenne générale du semestre = ΣTotal / ΣCoef
    $moyenneGenerale = $sumCoef > 0 ? round($sumTotal / $sumCoef, 2) : 0.0;

    // --- Absences / retards (hors justifiées) ---
 $absencesSemestre = Absence::where('inscription_id', (int) $inscription->id)
    ->when($semestre, fn($q) => $q->where('semestre', (int) $semestre))
    ->get();

// ✅ "justifie" est prioritaire : une ligne ne doit jamais être comptée à la
// fois comme justifiée et non justifiée, même si "nonjustifie" est resté à 1
// par erreur (cf. bug de case à cocher non réinitialisée en édition).
$hAbsJust = (float) $absencesSemestre->where('type','absence')->where('justifie', 1)->sum('nombre_heure_absence');

$hAbsNon = (float) $absencesSemestre->where('type','absence')
    ->where('justifie', '!=', 1)
    ->sum('nombre_heure_absence');

$hRetJust = (float) $absencesSemestre->where('type','retard')->where('justifie', 1)->sum('nombre_heure_retard');

$hRetNon = (float) $absencesSemestre->where('type','retard')
    ->where('justifie', '!=', 1)
    ->sum('nombre_heure_retard');
$hAbsTotal = $hAbsJust + $hAbsNon;
$hRetTotal = $hRetJust + $hRetNon;

$retTotal = $absencesSemestre->where('type', 'retard')->count();

$absTotal = $absencesSemestre->where('type', 'absence')->count();
$absJustifiees = $absencesSemestre->where('type', 'absence')->where('justifie', 1)->count();
$absNonJustifiees = $absencesSemestre->where('type', 'absence')
    ->where('justifie', '!=', 1)
    ->count();

    // --- PDF ---
    $options = new \Dompdf\Options();
    $options->setFontCache(storage_path('fonts'));
    $options->set('isRemoteEnabled', true);
    $options->set('pdfBackend', 'GD');
    $options->setChroot(['/', storage_path('fonts')]);

    $template = file_get_contents('evaluation.html');

    // injecter contenu
    $template = str_replace('[BODY]', $output, $template);
    $template = str_replace('[TABLE_MOYENNES]', $moyennesTable, $template);
    $template = str_replace('[BLOC_MENTIONS]', $this->blocMentionsHtml($semestre), $template);
    $template = str_replace('[RANG]', $rangTexte, $template);
    $template = str_replace('[MOYENNE_CLASSE]', number_format($moyenneClasse, 2, ',', '.'), $template);

    // absences / retards (en heures, cohérent avec la saisie "Nombre d'heures d'absence")
$template = str_replace('[RET_TOTAL]', $this->formatHeures($hRetTotal), $template);
$template = str_replace('[ABS_TOTAL]', $this->formatHeures($hAbsTotal), $template);
$template = str_replace('[ABS_JUSTIFIEES]', $this->formatHeures($hAbsJust), $template);
$template = str_replace('[ABS_NON_JUSTIFIEES]', $this->formatHeures($hAbsNon), $template);
 $logoPath = public_path('assets/images/titleHead.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }
    $template = str_replace('[LOGO]', $logoBase64, $template);

   $template = str_replace('[DATE]', now()->format('d/m/Y'), $template);
    // infos
    $template = str_replace('[USER]', $inscription->apprenant->nom . ' ' . $inscription->apprenant->prenom, $template);
    $template = str_replace('[DATENAISSANCE]', $inscription->apprenant->date_naissance, $template);
    $template = str_replace('[LIEUNAISSANCE]', $inscription->apprenant->lieu_naissance, $template);
    $template = str_replace('[TEL]', $inscription->apprenant->telephone, $template);
    $template = str_replace('[EMAIL]', $inscription->apprenant->email, $template);
    $template = str_replace('[MATRICULE]', $inscription->apprenant->matricule, $template);

    $template = str_replace('[SEMESTRE]', $semestre, $template);
    $template = str_replace('[CLASSE]', $inscription->classe->libelle ?? '', $template);
    $template = str_replace('[ANNEE]', $inscription->classe->niveau_etude->nom ?? '', $template);
    $template = str_replace('[ANNEESCOLAIRE]', $inscription->anneeAcademique->code ?? '', $template);
    $template = str_replace('[EFPT]', $inscription->classe->etablissement->nom ?? '', $template);
    $template = str_replace('[EFPTTEL]', $inscription->classe->etablissement->telephone ?? '', $template);
    $template = str_replace('[EFPTMAIL]', $inscription->classe->etablissement->email ?? '', $template);

    // ✅ moyenne générale pondérée
    $template = str_replace('[MOYENNE]', number_format($moyenneGenerale, 2, ',', '.'), $template);

    // ✅ Compaction adaptative : on mesure le rendu réel et on resserre la
    // police/les marges jusqu'à ce que tout tienne sur une seule page, quel
    // que soit le nombre de matières.
    [$finalHtml, ] = $this->fitContentOnePage($template, $options);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($finalHtml);
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

    
    // ✅ Affiche un nombre d'heures sans décimales inutiles (2 au lieu de 2.00, 2.5 au lieu de 2.50)
    private function formatHeures($valeur): string
    {
        return rtrim(rtrim(number_format((float) $valeur, 2, '.', ''), '0'), '.') ?: '0';
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
    set_time_limit(300);

    $semestre = (int) $semestre;

    $classe = Classe::with(['etablissement', 'inscriptions.apprenant', 'inscriptions.anneeAcademique', 'niveau_etude'])
        ->findOrFail($classe_id);

    // Bulletins de l'année choisie uniquement (une classe est réutilisée d'une année à l'autre).
    $anneeId = \App\Services\AnneeDesNotes::pourClasse((int) $classe->id, request());
    $classe->setRelation('inscriptions', $classe->inscriptions->when($anneeId, fn ($i) => $i->where('annee_academique_id', $anneeId))->values());

    $inscriptions = $classe->inscriptions;

    if ($inscriptions->isEmpty()) {
        return back()->with('error', 'Aucun apprenant trouvé pour cette classe.');
    }

    // ✅ Nombre d'inscrits dans la classe (pour [NbreIns] et "rang / total")
    $nbInscrits = $inscriptions->count();

    // 🔹 Charger le modèle HTML
    $templatePath = public_path('evaluation.html');
    if (!file_exists($templatePath)) {
        return back()->with('error', 'Le modèle evaluation.html est introuvable.');
    }

    $template = file_get_contents($templatePath);
    $html = '';

    // ✅ Logo
    $logoPath = public_path('assets/images/titleHead.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }
    $template = str_replace('[LOGO]', $logoBase64, $template);

    // ✅ Matières du niveau (coef fiable)
// Matières de la classe (PPO)
$classeId = (int) $classe->id;

$matieres = Matiere::where('niveau_etude_id', $classe->niveau_etude_id)
    ->whereIn('id', function ($query) use ($classeId, $anneeId) {
        $query->select('matiere_id')
            ->from('classe_formateur_matiere')
            ->where('classe_id', $classeId)
            ->when($anneeId, fn ($q) => $q->where('annee_academique_id', $anneeId))
            ->whereNotNull('formateur_id');
    })
    ->get();

    // --- moyenne matière ---
    $moyenneMatiereFn = function ($note_cc, $note_composition) {
        if ($note_cc === null || $note_composition === null) return null;
        return (((float)$note_cc + (float)$note_composition) / 2);
    };

    $inscriptionIds = $inscriptions->pluck('id')->all();

    // ✅ Une seule requête pour toutes les évaluations de la classe (tous semestres),
    // groupées par inscription puis par semestre, pour éviter le N+1 sur les 42 apprenants.
    $evaluationsParInscription = Evaluation::whereIn('inscription_id', $inscriptionIds)
        ->get()
        ->groupBy(['inscription_id', 'semestre']);

    // ✅ Une seule requête pour toutes les absences/retards du semestre de la classe.
    $absencesParInscription = Absence::whereIn('inscription_id', $inscriptionIds)
        ->where('semestre', $semestre)
        ->get()
        ->groupBy('inscription_id');

    // ✅ Moyenne pondérée d'une inscription pour un semestre donné (lecture en mémoire, pas de requête)
    $moyenneSemestrePourInscription = function (int $inscriptionId, int $sem) use ($matieres, $moyenneMatiereFn, $evaluationsParInscription) {
        $evaluations = ($evaluationsParInscription->get($inscriptionId)?->get($sem) ?? collect())
            ->keyBy('matiere_id');

        $sumTotal = 0.0;
        $sumCoef  = 0.0;

        foreach ($matieres as $matiere) {
            $coef = (float)($matiere->coef ?? 0);
            if ($coef <= 0) continue;

            $eval = $evaluations->get($matiere->id);
            if (!$eval) continue;

            $moy = $moyenneMatiereFn($eval->note_cc, $eval->note_composition);
            if ($moy === null) continue;

            $sumTotal += ($moy * $coef);
            $sumCoef  += $coef;
        }

        return $sumCoef > 0 ? round($sumTotal / $sumCoef, 2) : 0.0;
    };

    // ✅ Calcul moyennes pondérées pour tous (pour rangs)
    $moyennes = [];

    foreach ($inscriptions as $inscription) {
        $moyennes[$inscription->id] = $moyenneSemestrePourInscription((int) $inscription->id, $semestre);
    }

    $moyenneClasse = count($moyennes)
        ? round(array_sum($moyennes) / count($moyennes), 2)
        : 0.0;

    // ✅ Rangs
    arsort($moyennes);
    $rangs = [];
    $position = 1;
    foreach ($moyennes as $id => $moy) {
        $rangs[$id] = $position++;
    }

    // ✅ Options Dompdf pour la mesure/compaction (une par élève : le nombre
    // de matières visibles diffère selon les notes disponibles).
    $pdfOptions = new \Dompdf\Options();
    $pdfOptions->set('isRemoteEnabled', true);

    // ✅ CSS de compaction accumulée, scopée par élève (voir plus bas).
    $allCss = '';

    // 🔹 Bulletins
    foreach ($inscriptions as $inscription) {
        $apprenant = $inscription->apprenant;

        // ✅ Absences / retards (heures)
        $absencesSemestre = $absencesParInscription->get((int) $inscription->id) ?? collect();

        // ✅ "justifie" est prioritaire : une ligne ne doit jamais être comptée à la
        // fois comme justifiée et non justifiée, même si "nonjustifie" est resté à 1
        // par erreur (cf. bug de case à cocher non réinitialisée en édition).
        $hAbsJust = (float)$absencesSemestre->where('type', 'absence')->where('justifie', 1)->sum('nombre_heure_absence');
        $hAbsNon  = (float)$absencesSemestre->where('type', 'absence')
            ->where('justifie', '!=', 1)
            ->sum('nombre_heure_absence');

        $hRetJust = (float)$absencesSemestre->where('type', 'retard')->where('justifie', 1)->sum('nombre_heure_retard');
        $hRetNon  = (float)$absencesSemestre->where('type', 'retard')
            ->where('justifie', '!=', 1)
            ->sum('nombre_heure_retard');

        $hAbsTotal = $hAbsJust + $hAbsNon;
        $hRetTotal = $hRetJust + $hRetNon;

        $retTotal = $absencesSemestre->where('type', 'retard')->count();

        $absTotal = $absencesSemestre->where('type', 'absence')->count();
        $absJustifiees = $absencesSemestre->where('type', 'absence')->where('justifie', 1)->count();
        $absNonJustifiees = $absencesSemestre->where('type', 'absence')
            ->where('justifie', '!=', 1)
            ->count();

        // ✅ Evaluations du semestre courant
        $evaluations = ($evaluationsParInscription->get((int) $inscription->id)?->get($semestre) ?? collect())
            ->keyBy('matiere_id');

        $body = '';
        $sumTotal = 0.0;
        $sumCoef  = 0.0;

        foreach ($matieres as $matiere) {
            $eval = $evaluations->get($matiere->id);

            $note_cc   = $eval?->note_cc;
            $note_comp = $eval?->note_composition;

            // ✅ Une matière sans aucune note (ni devoir/CC, ni composition)
            // ne doit pas apparaître sur le bulletin.
            if ($note_cc === null && $note_comp === null) {
                continue;
            }

            $coef = (float)($matiere->coef ?? 0);

            $moy = $moyenneMatiereFn($note_cc, $note_comp);

            if ($moy !== null && $coef > 0) {
                $sumTotal += ($moy * $coef);
                $sumCoef  += $coef;
            }

            $app = $moy !== null ? $this->noteAppreciation($moy) : '-';

            $body .= '
                <tr>
                    <td class="border-td">' . ($matiere->nom ?? '-') . '</td>
                    <td class="border-td centered">' . ($matiere->coef ?? '-') . '</td>
                    <td class="border-td centered">' . ($note_cc !== null ? $note_cc : '-') . '</td>
                    <td class="border-td centered">' . ($note_comp !== null ? $note_comp : '-') . '</td>
                    <td class="border-td centered">' . ($moy !== null ? number_format($moy, 2, ',', '.') : '-') . '</td>
                    <td class="border-td centered">' . $app . '</td>
                </tr>';
        }

        $moyenne = $sumCoef > 0 ? number_format(($sumTotal / $sumCoef), 2, ',', '.') : '-';

        // ✅ Rang + total inscrits
        $rangSimple = $rangs[$inscription->id] ?? '-';
        $rangAffiche = ($rangSimple !== '-') ? ($rangSimple . ' / ' . $nbInscrits) : '-';

        // ✅ TABLE_MOYENNES (si semestre 2)
        $moyennesTable = '';
        if ($semestre === 2) {
            $moyenneS1 = $moyenneSemestrePourInscription((int)$inscription->id, 1);
            $moyenneS2 = $moyenneSemestrePourInscription((int)$inscription->id, 2);
            $moyenneAnnuelle = round(($moyenneS1 + $moyenneS2) / 2, 2);

            $moyennesTable = '
                <table class="full-table" cellspacing="0" style="margin-top:10px;">
                    <tr>
                        <td class="border-td bg-grey bold-exo centered">Moy. 1er Sem : ' . number_format($moyenneS1, 2, ',', '.') . '</td>
                        <td class="border-td bg-grey bold-exo centered">Moy. 2e Sem : ' . number_format($moyenneS2, 2, ',', '.') . '</td>
                        <td class="border-td bg-grey bold-exo centered">Moy. Annuelle : ' . number_format($moyenneAnnuelle, 2, ',', '.') . '</td>
                    </tr>
                </table>
            ';
        }

        // ✅ Année académique (simple, sans casser la mise en page)
        $anneeScolaire = $inscription->anneeAcademique->code ?? now()->year;

        $content = str_replace(
            [
                '[EFPT]', '[EFPTTEL]', '[EFPTMAIL]',
                '[CLASSE]', '[SEMESTRE]', '[ANNEESCOLAIRE]',
                '[USER]', '[DATENAISSANCE]', '[LIEUNAISSANCE]', '[TEL]', '[EMAIL]', '[MATRICULE]',
                '[BODY]', '[MOYENNE]', '[MOYENNE_CLASSE]', '[RANG]', '[DATE]',
                '[RET_TOTAL]', '[ABS_TOTAL]', '[ABS_JUSTIFIEES]', '[ABS_NON_JUSTIFIEES]',
                '[TABLE_MOYENNES]', '[BLOC_MENTIONS]',
                '[NbreIns]'
            ],
            [
                $classe->etablissement->nom ?? '---',
                $classe->etablissement->telephone ?? '---',
                $classe->etablissement->email ?? '---',
                $classe->libelle ?? '',
                $semestre,
                $anneeScolaire,
                strtoupper(($apprenant->prenom ?? '') . ' ' . ($apprenant->nom ?? '')),
                $apprenant->date_naissance ?? '-',
                $apprenant->lieu_naissance ?? '-',
                $apprenant->telephone ?? '-',
                $apprenant->email ?? '-',
                $apprenant->matricule ?? '-',
                $body,
                $moyenne,
                number_format($moyenneClasse, 2, ',', '.'),
                $rangAffiche,
                now()->format('d/m/Y'),
                $this->formatHeures($hRetTotal),
                $this->formatHeures($hAbsTotal),
                $this->formatHeures($hAbsJust),
                $this->formatHeures($hAbsNon),
                $moyennesTable,
                $this->blocMentionsHtml($semestre),
                (string)$nbInscrits
            ],
            $template
        );

        // ✅ Compaction adaptative mesurée pour CHAQUE élève : le nombre de
        // matières visibles diffère selon les notes disponibles (les
        // matières sans note sont masquées), donc une échelle calibrée sur
        // un seul élève ne convient pas forcément aux autres. Concaténer
        // plusieurs documents <html>/<body> complets dans un seul PDF fait
        // que le parser HTML de Dompdf ne garde qu'un seul <body> : un
        // <style> par élève "fuit" alors sur tous les autres. On extrait
        // donc uniquement le contenu de chaque bulletin, on le scope avec
        // une classe unique, et on regroupe toute la CSS de compaction dans
        // l'unique <style> partagé du document final.
        $scopeClass = 'bulletin-' . $inscription->id;
        [$fittedDoc, $scale] = $this->fitContentOnePage($content, $pdfOptions, '.' . $scopeClass);

        $allCss .= $this->compactStyleFor($scale, '.' . $scopeClass);
        $html .= $this->extractBodyContent($fittedDoc) . '<div style="page-break-after: always;"></div>';
    }
 $html .= '<div style="page-break-before: always;"></div>';

    $html .= '
        <h3 style="text-align:center; margin: 10px 0 6px 0;">
            Tableau Récapitulatif des Résultats - Classe : ' . e($classe->libelle) . '
        </h3>

        <table style="width:100%; border-collapse:collapse; font-size:11px;">
            <thead>
                <tr style="background-color:#f1f1f1; border:1px solid #000;">
                    <th style="border:1px solid #000; padding:4px; width:6%;">N°</th>
                    <th style="border:1px solid #000; padding:4px; width:44%;">Apprenant</th>
                    <th style="border:1px solid #000; padding:4px; width:18%;">Moyenne</th>
                    <th style="border:1px solid #000; padding:4px; width:14%;">Rang</th>
                    <th style="border:1px solid #000; padding:4px; width:18%;">Mention</th>
                </tr>
            </thead>
            <tbody>
    ';

    $i = 1;
    foreach ($moyennes as $inscId => $moy) { // déjà trié décroissant
        $insc = $inscriptions->firstWhere('id', $inscId);
        $apprenant = $insc?->apprenant;

        $mention = $this->noteAppreciation($moy);
        $rangNum = $rangs[$inscId] ?? null;
        $rangTxt = $rangNum ? ($rangNum . ' / ' . $nbInscrits) : '-';

        $html .= '
            <tr>
                <td style="border:1px solid #000; padding:4px; text-align:center;">' . $i++ . '</td>
                <td style="border:1px solid #000; padding:4px;">' . strtoupper(($apprenant->prenom ?? '') . ' ' . ($apprenant->nom ?? '')) . '</td>
                <td style="border:1px solid #000; padding:4px; text-align:center;">' . number_format((float)$moy, 2, ',', '.') . '</td>
                <td style="border:1px solid #000; padding:4px; text-align:center;">' . $rangTxt . '</td>
                <td style="border:1px solid #000; padding:4px; text-align:center;">' . $mention . '</td>
            </tr>
        ';
    }

    $html .= '
            </tbody>
        </table>
    ';

    // ✅ Un seul document final : le <head>/<style> du template (avec toute
    // la CSS de compaction scopée par élève) + le contenu de tous les
    // bulletins en <body>, au lieu de N documents complets concaténés.
    $finalDocument = str_replace('</style>', $allCss . '</style>', $template);
    $finalDocument = $this->injectBodyContent($finalDocument, $html);

    $pdf = Pdf::loadHTML($finalDocument)->setPaper('A4', 'portrait');

    return $pdf->stream(
        'Bulletins_' . str_replace(' ', '_', $classe->libelle) . '_Semestre_' . $semestre . '.pdf'
    );
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

public function mesNotes($inscriptionId)
{
    $inscription = \App\Models\Inscription::with([
        'apprenant', 
        'classe.etablissement', 
        'classe.niveau_etude', 
        'anneeAcademique'
    ])->findOrFail($inscriptionId);

    $classeId = (int) $inscription->classe_id;
    $anneeId = $inscription->annee_academique_id;

    $matieres = \App\Models\Matiere::where('niveau_etude_id', $inscription->classe->niveau_etude->id)
        ->whereIn('id', function ($query) use ($classeId, $anneeId) {
            $query->select('matiere_id')
                  ->from('classe_formateur_matiere')
                  ->where('classe_id', $classeId)
                  ->when($anneeId, fn ($q) => $q->where('annee_academique_id', $anneeId))
                  ->whereNotNull('formateur_id');
        })
        ->get()
        ->keyBy('id');

    $evaluationsRaw = \App\Models\Evaluation::where('inscription_id', $inscriptionId)
        ->with('matiere')
        ->whereNotNull('note_composition')
        ->get();

    $evaluations = $evaluationsRaw->map(function($e) use ($matieres) {
        $matiere   = $matieres->get($e->matiere_id);
        $coef      = (float)($matiere?->coef ?? 0);
        $note_cc   = $e->note_cc !== null ? (float)$e->note_cc : null;
        $note_comp = $e->note_composition !== null ? (float)$e->note_composition : null;

        $moyenne = ($note_cc !== null && $note_comp !== null)
            ? round(($note_cc + $note_comp) / 2, 2)
            : null;

        // Calcul de l'appréciation basé sur la moyenne
        $appreciation = null;
        if ($moyenne !== null) {
            if ($moyenne < 10)           $appreciation = 'Insuffisant';
            elseif ($moyenne < 12)       $appreciation = 'Passable';
            elseif ($moyenne < 14)       $appreciation = 'Assez Bien';
            elseif ($moyenne < 16)       $appreciation = 'Bien';
            elseif ($moyenne < 18)       $appreciation = 'Bon Travail';
            else                         $appreciation = 'Très Bon Travail';
        }

        return [
            'matiere'          => $e->matiere->nom ?? '-',
            'coef'             => $coef > 0 ? $coef : '-',
            'note_cc'          => $note_cc,
            'note_composition' => $note_comp,
            'moyenne'          => $moyenne,
            'appreciation'     => $appreciation,
            'semestre'         => $e->semestre,
        ];
    });

    return view('apprenant.mes-notes', compact('evaluations', 'inscription'));
}

}