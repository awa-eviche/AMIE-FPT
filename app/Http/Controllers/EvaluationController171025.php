<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Evaluation;
use App\Models\Inscription;
use App\Models\Matiere;
use App\Models\Apprenant;
use App\Models\HistoryNote;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade as PDF;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;


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
    
        // ✅ Vérification d’accès AVANT toute modification
        if (
            !$user->hasRole('superadmin') &&
            (!$classe || !$classe->formateurs()
                ->where('personnel_etablissement_id', $personnel?->id)
                ->exists())
        ) {
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
    
        // ✅ Vérification d’accès AVANT suppression
        if (
            !$user->hasRole('superadmin') &&
            (!$classe || !$classe->formateurs()
                ->where('personnel_etablissement_id', $personnel?->id)
                ->exists())
        ) {
            abort(403, 'Vous n’êtes pas autorisé à supprimer les évaluations de cette classe.');
        }
        $evaluation->delete();

        return redirect()->route('inscription.index')->with('success', 'Évaluation supprimée avec succès.');
    }

public function generatePDF($id)
{
    $semestre = session()->get('selectedsemestre');

    $inscription = Inscription::find($id);
    $matieres = Matiere::where('niveau_etude_id', $inscription->classe->niveau_etude->id)->get();

    // --- Calcul de la moyenne générale pour un semestre (fonction réutilisable) ---
    $calculerMoyenneSemestre = function($insc, $semestreNum) use ($matieres) {
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

    // Moyennes de l'apprenant pour les deux semestres
    $moyenneS1 = $calculerMoyenneSemestre($inscription, 1);
    $moyenneS2 = $calculerMoyenneSemestre($inscription, 2);
    $moyenneAnnuelle = ($moyenneS1 + $moyenneS2) / 2;

    // Moyenne du semestre courant (pour le tableau principal)
    $moyenneCourante = $calculerMoyenneSemestre($inscription, $semestre);

    // --- Calcul du rang et de la moyenne de la classe ---
    $inscriptionsClasse = Inscription::where('classe_id', $inscription->classe_id)->get();
    $moyennesClasse = [];

    foreach ($inscriptionsClasse as $insc) {
        $moyennesClasse[$insc->id] = $calculerMoyenneSemestre($insc, $semestre);
    }

    // Trier les moyennes (ordre décroissant)
    arsort($moyennesClasse);

    // Position (rang)
    $position = array_search($inscription->id, array_keys($moyennesClasse)) + 1;
    $effectifClasse = count($moyennesClasse);
    $rangTexte = $position . 'e sur ' . $effectifClasse;

    // Moyenne de la classe (moyenne des moyennes)
    $moyenneClasse = count($moyennesClasse) > 0 ? array_sum($moyennesClasse) / count($moyennesClasse) : 0;

    // --- Générer le tableau des moyennes (affiché seulement au 2e semestre) ---
    $moyennesTable = '';
    if ($semestre == 2) {
        $moyennesTable = '
            <table class="full-table" cellspacing="0" style="margin-top: 10px;">
                <tr>
                    <td class="border-td bg-grey bold-exo">Moyenne 1er Semestre</td>
                    <td class="border-td">'.number_format($moyenneS1, 2, ',', '.').'</td>
                </tr>
                <tr>
                    <td class="border-td bg-grey bold-exo">Moyenne 2e Semestre</td>
                    <td class="border-td">'.number_format($moyenneS2, 2, ',', '.').'</td>
                </tr>
                <tr>
                    <td class="border-td bg-grey bold-exo">Moyenne Générale Annuelle</td>
                    <td class="border-td">'.number_format($moyenneAnnuelle, 2, ',', '.').'</td>
                </tr>
            </table>
        ';
    }

    // --- Récupération des évaluations pour le semestre sélectionné (pour le tableau des matières) ---
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

    // --- Préparer le PDF ---
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

  // Forcer la locale en français (UTF-8)
setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr');

// Formater la date en français
$date = strftime('%e %B %Y');
$template = str_replace('[DATE]', ucfirst($date), $template);


    // Remplacement des infos Apprenant et Classe
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
}
