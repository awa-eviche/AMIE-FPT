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
            ]);
        
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

    // Matieres de la classe (PPO)
    $matieres = Matiere::where('niveau_etude_id', $inscription->classe->niveau_etude->id)->get();

    
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
        ->keyBy('matiere_id');

    // --- Construction du tableau du bulletin (avec TOTAL) ---
    $output = '';
    $sumTotal = 0.0;
    $sumCoef  = 0.0;

    foreach ($matieres as $matiere) {

        $evaluation = $evaluations->get($matiere->id);

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

$hAbsJust = (float) $absencesSemestre->where('type','absence')->where('justifie', 1)->sum('nombre_heure_absence');

$hAbsNon = (float) $absencesSemestre->where('type','absence')
    ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
    ->sum('nombre_heure_absence');

$hRetJust = (float) $absencesSemestre->where('type','retard')->where('justifie', 1)->sum('nombre_heure_retard');

$hRetNon = (float) $absencesSemestre->where('type','retard')
    ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
    ->sum('nombre_heure_retard');
;

$hAbsTotal = $hAbsJust + $hAbsNon;
$hRetTotal = $hRetJust + $hRetNon;

    // --- PDF ---
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->setFontCache(storage_path('fonts'));
    $options->set('isRemoteEnabled', true);
    $options->set('pdfBackend', 'GD');
    $options->setChroot(['/', storage_path('fonts')]);
    $dompdf->setOptions($options);

    $template = file_get_contents('evaluation.html');

    // injecter contenu
    $template = str_replace('[BODY]', $output, $template);
    $template = str_replace('[TABLE_MOYENNES]', $moyennesTable, $template);
    $template = str_replace('[RANG]', $rangTexte, $template);
    $template = str_replace('[MOYENNE_CLASSE]', number_format($moyenneClasse, 2, ',', '.'), $template);

    // absences
      $fmt = fn($n) => rtrim(rtrim(number_format((float)$n, 2, '.', ''), '0'), '.');

$template = str_replace('[NB_ABSENCES]', $fmt($hAbsTotal), $template);
$template = str_replace('[NB_RETARDS]',  $fmt($hRetTotal), $template);
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
    $semestre = (int) $semestre;

    $classe = Classe::with(['etablissement', 'inscriptions.apprenant', 'niveau_etude'])
        ->findOrFail($classe_id);

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
    $matieres = Matiere::where('niveau_etude_id', $classe->niveau_etude->id)->get();

    // --- moyenne matière ---
    $moyenneMatiereFn = function ($note_cc, $note_composition) {
        if ($note_cc === null || $note_composition === null) return null;
        return (((float)$note_cc + (float)$note_composition) / 2);
    };

    // --- format heures ---
    $fmt = fn($n) => rtrim(rtrim(number_format((float)$n, 2, '.', ''), '0'), '.');

    // ✅ Calcul moyennes pondérées pour tous (pour rangs)
    $moyennes = [];

    foreach ($inscriptions as $inscription) {
        $evaluations = Evaluation::where('inscription_id', $inscription->id)
            ->where('semestre', $semestre)
            ->get()
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

        $moyennes[$inscription->id] = $sumCoef > 0 ? round($sumTotal / $sumCoef, 2) : 0.0;
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

    // ✅ Moyenne semestre par inscription (S1/S2) si semestre=2
    $moyenneSemestrePourInscription = function (int $inscriptionId, int $sem) use ($matieres, $moyenneMatiereFn) {
        $evaluations = Evaluation::where('inscription_id', $inscriptionId)
            ->where('semestre', $sem)
            ->get()
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

    // 🔹 Bulletins
    foreach ($inscriptions as $inscription) {
        $apprenant = $inscription->apprenant;

        // ✅ Absences / retards (heures)
        $absencesSemestre = Absence::where('inscription_id', (int)$inscription->id)
            ->where('semestre', (int)$semestre)
            ->get();

        $hAbsJust = (float)$absencesSemestre->where('type', 'absence')->where('justifie', 1)->sum('nombre_heure_absence');
        $hAbsNon  = (float)$absencesSemestre->where('type', 'absence')
            ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
            ->sum('nombre_heure_absence');

        $hRetJust = (float)$absencesSemestre->where('type', 'retard')->where('justifie', 1)->sum('nombre_heure_retard');
        $hRetNon  = (float)$absencesSemestre->where('type', 'retard')
            ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
            ->sum('nombre_heure_retard');

        $hAbsTotal = $hAbsJust + $hAbsNon;
        $hRetTotal = $hRetJust + $hRetNon;

        // ✅ Evaluations du semestre courant
        $evaluations = Evaluation::where('inscription_id', $inscription->id)
            ->where('semestre', $semestre)
            ->get()
            ->keyBy('matiere_id');

        $body = '';
        $sumTotal = 0.0;
        $sumCoef  = 0.0;

        foreach ($matieres as $matiere) {
            $coef = (float)($matiere->coef ?? 0);
            $eval = $evaluations->get($matiere->id);

            $note_cc   = $eval?->note_cc;
            $note_comp = $eval?->note_composition;

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

        // ✅ Année académique (simple, sans casser la mise en page)
        $anneeScolaire = $inscription->anneeAcademique->code ?? now()->year;

        $content = str_replace(
            [
                '[EFPT]', '[EFPTTEL]', '[EFPTMAIL]',
                '[CLASSE]', '[SEMESTRE]', '[ANNEESCOLAIRE]',
                '[USER]', '[DATENAISSANCE]', '[LIEUNAISSANCE]', '[TEL]', '[EMAIL]', '[MATRICULE]',
                '[BODY]', '[MOYENNE]', '[MOYENNE_CLASSE]', '[RANG]', '[DATE]',
                '[NB_ABSENCES]', '[NB_RETARDS]',
                '[TABLE_MOYENNES]',
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
                $fmt($hAbsTotal),
                $fmt($hRetTotal),
                $moyennesTable,
                (string)$nbInscrits
            ],
            $template
        );

        $html .= '<div style="page-break-after: always;">' . $content . '</div>';
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
    $pdf = Pdf::loadHTML($html)->setPaper('A4', 'portrait');

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



}