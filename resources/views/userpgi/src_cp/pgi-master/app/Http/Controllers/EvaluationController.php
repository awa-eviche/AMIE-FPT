<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Evaluation;
use App\Models\Inscription;
use App\Models\Matiere;
use App\Models\Apprenant;
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
        'inscription_id' => 'required|string',
        'matiere_id' => 'required|string',
      
        'semestre' => 'required|in:1,2',
        'appreciation'=> 'required',
        
        'note_cc' => 'required|numeric|max:20',
        'note_composition' => 'required|numeric|max:20',
    ]);

    $existingEvaluation = Evaluation::where('inscription_id', $request->inscription_id)
        ->where('matiere_id', $request->matiere_id)
        ->where('semestre', $request->semestre)
        ->exists();

    if ($existingEvaluation) {
        return redirect()->route('evaluation.index')
            ->withMessage('Vous avez déjà évalué cet apprenant pour ce semestre et cette matière.');
    }

    try {
        $evaluation = Evaluation::create([
            'inscription_id' => $request->inscription_id,
            'matiere_id' => $request->matiere_id,
            'semestre' => Session::get('selectedsemestre'),
            'appreciation' => $request->appreciation,
            'note_cc' => $request->note_cc,
            'note_composition' => $request->note_composition,
        ]);
        $this->logUserRepository->store(['action' => UserAction::AddEvaluation, 'model' => Model::Evaluation, 'new_object' => json_encode($evaluation)]);


        return redirect()->route('inscription.index')
            ->with('success', 'Évaluation enregistrée avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Une erreur s\'est produite lors de l\'enregistrement de l\'évaluation.');
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

    $request->validate([
        'matiere_id' => 'required',
        'semestre' => 'required',
        'appreciation' => 'required',
        'note_cc' => 'required|numeric|max:20',
        'note_composition' => 'required|numeric|max:20',
    ]);

    $evaluation->update($request->all());

    return redirect()->route('inscription.index')->with('success', 'Évaluation mise à jour avec succès.');
}


public function destroy($evaluationId)
{
    $evaluation = Evaluation::findOrFail($evaluationId);
    $evaluation->delete();

    return redirect()->route('inscription.index')->with('success', 'Évaluation supprimée avec succès.');
}

public function generatePDF($id)
{
  
    $semestre = session()->get('selectedsemestre');

    
    $inscription = Inscription::find($id);
    $evaluations = Evaluation::where('inscription_id', $inscription->id)
        ->where('semestre', $semestre) 
        ->get()
        ->keyBy('id');
    $matieres = Matiere::where('niveau_etude_id', $inscription->classe->niveau_etude->id)->get();

    // Initialiser les variables pour le calcul de la moyenne
    $sommeMoyennesPonderees = 0;
    $sommeCoefficients = 0;


    // Générer le contenu HTML du PDF
    $output = '</tr>';

    foreach ($matieres as $matiere) {
        // Récupérer l'évaluation correspondante pour cette matière
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

    $output .= '</tr>';

   
   $moyenneGenerale = $sommeCoefficients > 0 ? $sommeMoyennesPonderees / $sommeCoefficients : 0;

   
  
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->setFontCache(storage_path('fonts'));
    $options->set('isRemoteEnabled', true);
    $options->set('pdfBackend', 'CPDF');
    $options->setChroot(['/', storage_path('fonts')]);

  
    $template = file_get_contents('evaluation.html');
    $template = str_replace('[BODY]', $output, $template);
    setlocale(LC_TIME, 'fr_FR.UTF-8'); 
    $date = strftime('%e %B %Y'); 
    $template = str_replace('[DATE]', $date, $template);
    $template = str_replace('[USER]', $inscription->apprenant->nom . ' ' . $inscription->apprenant->prenom, $template);
    $template = str_replace('[DATENAISSANCE]', $inscription->apprenant->date_naissance ,$template);

    $template = str_replace('[LIEUNAISSANCE]', $inscription->apprenant->lieu_naissance, $template);
    $template = str_replace('[TEL]', $inscription->apprenant->telephone, $template);
    $template = str_replace('[EMAIL]', $inscription->apprenant->email, $template);
    $template = str_replace('[SEMESTRE]', $semestre, $template); 
    $template = str_replace('[CLASSE]', isset($inscription->classe->libelle) ? $inscription->classe->libelle : '', $template);
    $template = str_replace('[ANNEE]', isset($inscription->classe->niveau_etude->nom) ? $inscription->classe->niveau_etude->nom : '', $template);
    $template = str_replace('[ANNEESCOLAIRE]', isset($inscription->classe->annee_academique->code) ? $inscription->classe->annee_academique->code : '', $template);
    $template = str_replace('[EFPT]', isset($inscription->classe->etablissement->nom) ? $inscription->classe->etablissement->nom : '', $template);
    $template = str_replace('[EFPTTEL]', isset($inscription->classe->etablissement->telephone) ? $inscription->classe->etablissement->telephone : '', $template);
    $template = str_replace('[MOYENNE]', number_format($moyenneGenerale, 2, ',', '.'), $template); // Insérer la moyenne générale


  
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





}
