<?php

namespace App\Http\Controllers;
use App\Models\Competence;
use App\Models\Evalute;
use App\Models\Inscription;
use App\Models\Absence;
use App\Models\Classe;
use App\Models\Apprenant;
use App\Models\AnneeAcademique;
use App\Models\Etablissement;
use App\Models\Matiere;
use App\Models\DevoirAPC;
use Illuminate\Http\Request;
use App\Enums\UserAction;
use App\Repositories\LogUserRepository;
use App\Enums\Model;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
class InscriptionController extends Controller
{
    protected $logUserRepository;

    public function __construct(LogUserRepository $logUserRepository)
    {
        $this->middleware('auth');
        $this->logUserRepository = $logUserRepository;
       

    }

    public function index()
    {
     
        $userName = auth()->user()->nom;

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            $etablissementId = auth()->user()->personnel->etablissement_id;

            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }
            $classesIds = Classe::where('etablissement_id', $etablissementId)->pluck('id');
        } else {
            $classesIds = Classe::all()->pluck('id');
        }
        $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');

        $classe = session()->has('currentClasse') ? session()->get('currentClasse') : '';
        $currentClasse = $classe ? Classe::find($classe) : null;
        $classes = [$currentClasse];
        $matieres = $classe ? Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get() : [];

        $apprenants = Apprenant::whereIn('id', $apprenantsIds)->get();

        return view('inscription.index', compact('apprenants', 'matieres'));
    }

   
    public function create()
    {
        $annee_academiques = AnneeAcademique::all();

        $userName = auth()->user()->nom;

        if (auth()->user()->personnel && auth()->user()->personnel->etablissement_id) {
            
           
            $etablissementId = auth()->user()->personnel->etablissement_id;

            if (!$etablissementId) {
                return abort(403, "L'établissement de l'utilisateur actuel n'est pas valide.");
            }
            $classes = Classe::where('etablissement_id', $etablissementId)->get();

            $apprenants = Apprenant::where('etablissement_id', $etablissementId)->get();
        } else {
            $classes = Classe::all();
            $classesIds = Classe::all()->pluck('id');
            $apprenantsIds = Inscription::whereIn('classe_id', $classesIds)->pluck('apprenant_id');
            $apprenants = Apprenant::whereIn('apprenant_id', $apprenantsIds)->get();
        }

        return view('inscription.create', compact('classes', 'apprenants','annee_academiques'));
    }

    
    public function store(Request $request)
    {
        $request->validate([

            'apprenant_id' => 'required|string',
            'classe_id' => 'required|string',
            'annee_academique_id' => 'required|exists:annee_academiques,id',

        ]);


        $inscription = Inscription::create($request->all());
        $this->logUserRepository->store(['action' => UserAction::AddInscription, 'model' => Model::Inscription, 'new_object' => json_encode($inscription)]);


        return redirect()->route('inscription.index')

            ->withMessage('Inscription créé avec succès.');
    }

   
     public function show(Inscription $inscription)
    {
        $classeId = session('currentClasse');
        $currentClasse = $classeId ? Classe::find($classeId) : null;
        $matieres = collect();
        $competences = collect();
        $apprenants = $classeId ? Inscription::where('classe_id', $classeId)->get() : collect();
    
        if ($currentClasse && $currentClasse->niveau_etude) {
            if ($currentClasse->modalite === 'PPO') {
                $matieres = Matiere::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get();
            } elseif ($currentClasse->modalite === 'APC') {
                $competences = Competence::where('niveau_etude_id', $currentClasse->niveau_etude->id)->get();
            }
        }
    
        return view('inscription.show', [
            "inscription" => $inscription,
            "apprenants" => $apprenants,
            "classe" => $classeId,
            'matieres' => $matieres,
            'competences' => $competences,
            'currentClasse' => $currentClasse,
        ]);
    }
    

   
    public function edit(Inscription $inscription)
    {

        $classes = Classe::all();
        $apprenants = Apprenant::all();
        return view('inscription.edit', compact('inscription', 'classes', 'apprenants'));
    }


    public function update(Request $request, Inscription $inscription)
    {
        $request->validate([
            'apprenant_id' => 'required|string',
            'classe_id' => 'required|string',

        ]);

        $inscription->update($request->all());

        return redirect()->route('inscription.index')
            ->withMessage('Inscription mise à jour avec succès.');
    }

    public function destroy(Inscription $inscription)
    {

        $this->logUserRepository->store([
            'action' => UserAction::DeleteInscription, 'model' => Model::Inscription,
            'old_object' => json_encode($inscription)
        ]);
        $inscription->delete();

        return redirect()->route('inscription.index')
            ->withMessage('Inscription supprimé avec succès.');
    }

 function generateCompetenceClassePdf(string $id)
    {
        $inscriptions = Inscription::where('classe_id', $id)->get();
        $totalCompetence = Competence::where('niveau_etude_id', $inscriptions[0]->classe->niveau_etude_id)->get()->count();

        $legendes = [];
        array_push($legendes, '<li><span class="bold-exo">A</span> : Acquis</li>');
        array_push($legendes, '<li><span class="bold-exo">NA</span> : Non Acquis</li>');

        //Initialiser les compteurs et le output
        $cleCritere = 0;
        $ecKey = 0;
        $cptKey = 0;
        $start = 0;
        $end = 3;
        $body = '';
        $enteteKey = 0;

        while ($totalCompetence > $start) {
            $competences = Competence::where('niveau_etude_id', $inscriptions[0]->classe->niveau_etude_id)->offset($start)->limit($end)->get();

            $criteres = [];
            $rowspans = [];
            $labelsCompetences = '';
            foreach ($competences as $keyRow => $competence) {
                $labelsCompetences .= 'C' . ($enteteKey + 1);
                if ((sizeof($competences) - 1) > $keyRow) {
                    $labelsCompetences .= ' - ';
                }

                $rowspan = 0;
                foreach ($competence->elementCompetences as $ec) {
                    $rowspan += sizeof($ec->criteres);
                    $criteres = [...$criteres, ...$ec->criteres->toArray()];
                }
                $rowspans[$keyRow] = $rowspan;
                $enteteKey++;
            }

            $body .= '
            <p class="c-dispay">Compétences : ' . $labelsCompetences . '</p>
            <table class="full-table mb-1" style="margin-top: 1rem;font-size:80%" cellspacing="0">
            <tr style="page-break-before: avoid;">
                <td rowspan="3" align="center" class="border-td">Apprenants</td>';

            //Afficher la ligne des compétences
            foreach ($competences as $cptCompetence => $competence) {
                $body .= '
                        <td align="center" colspan="' . $rowspans[$cptCompetence] . '" class="border-td">C' . ($cptKey + 1) . '</td>
                ';
                array_push($legendes, '<li><span class="bold-exo">C' . ($cptKey + 1) . '</span> : ' . $competence->nom . '</li>');
                $cptKey++;
            }
            $body .= '
            </tr>
            ';

            $body .= '
            <tr style="page-break-before: avoid;">
            ';

            foreach ($competences as $key => $competence) {
                foreach ($competence->elementCompetences as $ec) {
                    $body .= '<td align="center" colspan="' . sizeof($ec->criteres) . '" class="border-td">EC' . ($ecKey + 1) . '</td>';
                    array_push($legendes, '<li><span class="bold-exo">EC' . ($ecKey + 1) . '</span> : ' . $ec->nom . '</li>');
                    $ecKey++;
                }

            }
            $body .= '
            </tr>
            ';

            $body .= '
            <tr style="page-break-before: avoid;">
            ';

            //Afficher la ligne des critères
            foreach ($competences as $key => $competence) {
                foreach ($competence->elementCompetences as $ec) {
                    foreach ($ec->criteres as $critereKey => $critere) {
                        $body .= '<td class="border-td">CRI' . ($cleCritere + 1) . '</td>';
                        array_push($legendes, '<li><span class="bold-exo">CRI' . ($cleCritere + 1) . '</span> : ' . $critere->libelle . '</li>');
                        $cleCritere++;
                    }
                }
            }
            $body .= '
            </tr>
            ';

            foreach ($inscriptions as $cleInscription => $inscription) {
                $rowspanCount = 0;
                $output = '';
                $evaluations = Evalute::where('inscription_id', $inscription->id)->get()->keyBy('id')->toArray();

                $body .= '
                <tr>
                    <td class="border-td">' . $inscription->apprenant->user->nom . ' ' . $inscription->apprenant->user->prenom . '</td>
                ';
                foreach ($competences as $key => $competence) {
                    foreach ($competence->elementCompetences as $ec) {
                        foreach ($ec->criteres as $critereKey => $critere) {
                            $findRow = null;
                            foreach ($evaluations as $evaluation) {
                                if ($evaluation['inscription_id'] == $inscription->id && $evaluation['critere_id'] == $critere->id) {
                                    $findRow = $evaluation;
                                    break;
                                }
                            }
                            if ($findRow) {
                                if ($findRow['acquis'])
                                    $body .= '<td class="border-td" align="center">A</td>';
                                elseif ($findRow['nonAcquis'])
                                    $body .= '<td class="border-td" align="center">NA</td>';
                            } else {
                                $body .= '<td class="border-td"></td>';
                            }
                        }
                    }
                }
                $body .= '
                </tr>
                ';
            }

            $body .= '
            </table>
            ';

            $start += 3;
        }

        $legende = '
        <div class="main-legend break" >
            <p align="center" class="bold-exo font-md">Légende</p><hr>
            <div class="legend-col" >
                <ul class="legende">';
        //Determiner la moyenne par colonne
        $limitBreak = intdiv(sizeof($legendes), 3);
        foreach ($legendes as $cleLegend => $legend) {
            $legende .= $legend;

            // Faire vérification pour passer à la deuxième colonne si nécessaire
            if ($cleLegend == ($limitBreak - 1)) {
                $legende .= '
                </ul>
                </div>
                <div class="legend-col">
                <ul class="legende">
                ';
            }

            // Faire vérification pour passer à la troisième colonne si nécessaire
            if ($cleLegend == ((2 * $limitBreak) - 1)) {
                $legende .= '
                </ul>
                </div>
                <div class="legend-col">
                <ul class="legende">
                ';
            }
        }
        $legende .= '</ul>
        </div><hr>';

        $entete = "Classe : " . $inscriptions[0]->classe->libelle .
            "<br><span>Niveau d'étude : " . $inscriptions[0]->classe->niveau_etude->libelle . "</span>
        <br><span>Métier : " . $inscriptions[0]->classe->niveau_etude->metier->libelle . "</span>
        <br><span>Année académique : " . $inscriptions[0]->classe->annee_academique->annee1 . " - " . $inscriptions[0]->classe->annee_academique->annee2 . "</span>";
        $template = file_get_contents('classe_competence.html');
        $template = str_replace('[BODY]', $body, $template);
        $template = str_replace('[LEGENDE]', $legende, $template);
        $template = str_replace('[DATE]', date('d/m/Y'), $template);
        $template = str_replace('[USER]', $entete, $template);
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->setFontCache(storage_path('fonts'));
        $options->set('isRemoteEnabled', true);
        $options->set('pdfBackend', 'CPDF');
        $options->setChroot([
            '/',
            storage_path('fonts'),
        ]);

        $dompdf->loadHTML($template);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $nom = 'Carnet_de_competence_classe.pdf';
        $dompdf->stream($nom, array("Attachment" => false));

    }

// public function generateCompetencePdfAncien(string $id)
// {
//     $semestre = session()->get('selectedsemestre1');

//     $inscription = Inscription::with(
//         'apprenant',
//         'classe.niveau_etude',
//         'classe.annee_academique',
//         'classe.etablissement'
//     )->findOrFail($id);

//     // Charger toutes les évaluations avec relations
//     $evaluations = Evalute::with('critere.elementCompetence.competence')
//         ->where('inscription_id', $inscription->id)
//         ->when($semestre, fn($query) => $query->where('semestre', $semestre))
//         ->get()
//         ->keyBy('critere_id');

//     $competencesGenerales = Competence::where('niveau_etude_id', $inscription->classe->niveau_etude_id)
//         ->where('type', 'generale')
//         ->with('elementCompetences.criteres')
//         ->get();

//     $competencesParticulieres = Competence::where('niveau_etude_id', $inscription->classe->niveau_etude_id)
//         ->where('type', 'particuliere')
//         ->with('elementCompetences.criteres')
//         ->get();

//     // Génération du tableau
//     $generateTable = function($competencesType, $evaluations) {
//         $html = '';

//         foreach ($competencesType as $competence) {
//             // Premier critère unique par compétence
//             $critere = $competence->elementCompetences
//                                   ->flatMap->criteres
//                                   ->unique('id')
//                                   ->first();

//             if ($critere) {
//                 $evaluation = $evaluations[$critere->id] ?? null;

//                 $note = $evaluation?->note ?? null;
//                 $date = $evaluation?->date ? date('d-m-Y', strtotime($evaluation->date)) : '-';

//                 // 👉 Attribution automatique des observations
//                 $obs = '-';
//                 if ($note !== null) {
//                     if ($note >= 0 && $note <= 10) {
//                         $obs = 'Passable';
//                     } elseif ($note >= 12 && $note <= 13) {
//                         $obs = 'Assez bien';
//                     } elseif ($note >= 14 && $note <= 16) {
//                         $obs = 'Bien';
//                     } elseif ($note >= 17 && $note <= 18) {
//                         $obs = 'Très bien';
//                     }
//                 }

//                 $html .= '<tr>';
//                 $html .= '<td class="border-td">'.htmlspecialchars($competence->nom).'</td>';
//                 $html .= '<td class="border-td">'.htmlspecialchars($critere->libelle).'</td>';
//                 $html .= '<td class="border-td" align="center">'.($note ?? '-').'</td>';
//                 $html .= '<td class="border-td" align="center">'.$date.'</td>';
//                 $html .= '<td class="border-td">'.htmlspecialchars($obs).'</td>';
//                 $html .= '</tr>';
//             }
//         }

//         return $html;
//     };

//     $tableGenerale = '
//     <tr>
//         <td colspan="6" class="bold-exo" 
//             style="background-color:#e0e0e0; text-align:center;">
//             Compétences Générales
//         </td>
//     </tr>'
//     . $generateTable($competencesGenerales, $evaluations);

//     $tableParticulier = '
//     <tr>
//         <td colspan="6" class="bold-exo" 
//             style="background-color:#e0e0e0; text-align:center;">
//             Compétences Particulières
//         </td>
//     </tr>'
//     . $generateTable($competencesParticulieres, $evaluations);

//     // Injection dans le template
//     $template = file_get_contents('competence.html');
//     $template = str_replace('[BODY]', $tableGenerale . $tableParticulier, $template);

//     setlocale(LC_TIME, 'fr_FR.UTF-8');
//     $date = strftime('%e %B %Y');
//     $template = str_replace('[DATE]', $date, $template);
//     $template = str_replace('[USER]', $inscription->apprenant->nom . ' ' . $inscription->apprenant->prenom, $template);
//     $template = str_replace('[DATENAISSANCE]', $inscription->apprenant->date_naissance, $template);
//     $template = str_replace('[LIEUNAISSANCE]', $inscription->apprenant->lieu_naissance, $template);
//     $template = str_replace('[TEL]', $inscription->apprenant->telephone, $template);
//     $template = str_replace('[EMAIL]', $inscription->apprenant->email, $template);
//     $template = str_replace('[SEMESTRE]', $semestre ? ($semestre == 1 ? '1' : '2') : 'Tous les semestres', $template);
//     $template = str_replace('[MATRICULE]', $inscription->apprenant->matricule, $template);
//     $template = str_replace('[CLASSE]', $inscription->classe->libelle ?? '', $template);
//     $template = str_replace('[ANNEE]', $inscription->classe->niveau_etude->nom ?? '', $template);
//     $template = str_replace('[ANNEESCOLAIRE]', $inscription->classe->annee_academique->code ?? '', $template);
//     $template = str_replace('[EFPT]', $inscription->classe->etablissement->nom ?? '', $template);
//     $template = str_replace('[EFPTTEL]', $inscription->classe->etablissement->telephone ?? '', $template);

//     $dompdf = new Dompdf();
//     $dompdf->getOptions()->set('isRemoteEnabled', true);
//     $dompdf->loadHTML($template);
//     $dompdf->setPaper('A4', 'portrait');
//     $dompdf->render();

//     return response($dompdf->output(), 200)
//         ->header('Content-Type', 'application/pdf')
//         ->header('Content-Disposition', 'inline; filename="Carnet_de_Competence.pdf"');
// }


// public function generateClassePdfAncien(string $classeId)
// {
//     $semestre = request('semestre'); 

//     $classe = Classe::with(['etablissement', 'niveau_etude', 'annee_academique'])
//         ->findOrFail($classeId);

  
//     $inscriptions = Inscription::with('apprenant')
//         ->where('classe_id', $classe->id)
//         ->get();

//     $competencesGenerales = Competence::where('niveau_etude_id', $classe->niveau_etude_id)
//         ->where('type', 'generale')
//         ->with(['elementCompetences.criteres'])
//         ->orderBy('id')
//         ->get();

//     $competencesParticulieres = Competence::where('niveau_etude_id', $classe->niveau_etude_id)
//         ->where('type', 'particuliere')
//         ->with(['elementCompetences.criteres'])
//         ->orderBy('id')
//         ->get();

//     $htmlGlobal = '';
//     $total = $inscriptions->count();
//     $index = 0;

//     foreach ($inscriptions as $inscription) {
//         $index++;
//         $templatePath = resource_path('views/pdf/competence.html');
//         $template = is_file($templatePath) ? file_get_contents($templatePath) : file_get_contents('competence.html');
//  $evaluations = \App\Models\Evalute::with('critere.elementCompetence.competence')
//             ->where('inscription_id', $inscription->id)
//             ->when($semestre, fn($q) => $q->where('semestre', $semestre))
//             ->get()
//             ->keyBy('critere_id'); 
//         $generateTable = function ($titreSection, $competences, $evaluations) {
//             $html = '
//             <tr>
//                 <td colspan="6" class="bold-exo" style="background-color:#e0e0e0; text-align:center;">'
//                 . htmlspecialchars($titreSection) .
//                 '</td>
//             </tr>';

//             foreach ($competences as $competence) {
//                 $ecList = $competence->elementCompetences ?? collect();
//                 $ecCount = $ecList->count();

//                 if ($ecCount === 0) {
//                     $html .= '
//                     <tr>
//                         <td class="border-td">'.htmlspecialchars(($competence->code ?? '').' '.($competence->nom ?? $competence->libelle ?? '')).'</td>
//                         <td class="border-td" colspan="5" style="text-align:center;">Aucun élément de compétence</td>
//                     </tr>';
//                     continue;
//                 }
//                 $firstEc = true;
//                 foreach ($ecList as $ec) {
//                     $criteres = $ec->criteres ?? collect();
//                     $notes = [];
//                     $latestDate = null;

//                     foreach ($criteres as $critere) {
//                         if (isset($evaluations[$critere->id])) {
//                             $ev = $evaluations[$critere->id];

//                             if ($ev->note !== null) {
//                                 $notes[] = $ev->note;
//                             }

//                             if (!empty($ev->date)) {
//                                 $d = strtotime($ev->date);
//                                 if ($latestDate === null || $d > $latestDate) {
//                                     $latestDate = $d;
//                                 }
//                             }
//                         }
//                     }

                   
//                     $noteAgg = '-';
//                     if (count($notes) > 0) {
//                         $noteAgg = round(array_sum($notes) / count($notes), 2);
//                     }

                   
//                     $obs = '-';
//                     if ($noteAgg !== '-' && is_numeric($noteAgg)) {
//                         if ($noteAgg < 10)        $obs = 'Passable';
//                         elseif ($noteAgg < 12)    $obs = 'Assez bien';
//                         elseif ($noteAgg < 15)    $obs = 'Bien';
//                         else                      $obs = 'Très bien';
//                     }

//                     $dateStr = $latestDate ? date('d/m/Y', $latestDate) : '-';

//                     $seuil = $ec->seuil ?? '70%';

//                     $html .= '<tr>';

                    
//                     if ($firstEc) {
//                         $html .= '
//                         <td class="border-td" rowspan="'.intval($ecCount).'">'
//                         . htmlspecialchars(($competence->code ?? '').' '.($competence->nom ?? $competence->libelle ?? '')) .
//                         '</td>';
//                         $firstEc = false;
//                     }

                 
//                     $html .= '
//                         <td class="border-td">'
//                         . htmlspecialchars(trim(($ec->code ?? '').' '.(($ec->nom ?? $ec->libelle ?? '')))) .
//                         '</td>';

                  
//                     $html .= '
//                         <td class="border-td" align="left">'.$seuil.'</td>
//                         <td class="border-td" align="center">'.$noteAgg.'</td>
//                         <td class="border-td" align="center">'.$dateStr.'</td>
//                         <td class="border-td">'.htmlspecialchars($obs).'</td>
//                     </tr>';
//                 }
//             }

//             return $html;
//         };

       
//         $body = $generateTable('Compétences Générales', $competencesGenerales, $evaluations)
//               . $generateTable('Compétences Particulières', $competencesParticulieres, $evaluations);

     
//         $template = str_replace('[BODY]', $body, $template);

       
//         try {
//             $dateNow = \Carbon\Carbon::now()->locale('fr')->isoFormat('D MMMM YYYY');
//         } catch (\Throwable $e) {
//             setlocale(LC_TIME, 'fr_FR.UTF-8');
//             $dateNow = strftime('%e %B %Y');
//         }

//         $template = str_replace('[DATE]', $dateNow, $template);
//         $template = str_replace('[USER]', trim(($inscription->apprenant->nom ?? '').' '.($inscription->apprenant->prenom ?? '')), $template);
//         $template = str_replace('[DATENAISSANCE]', $inscription->apprenant->date_naissance ?? '-', $template);
//         $template = str_replace('[LIEUNAISSANCE]', $inscription->apprenant->lieu_naissance ?? '-', $template);
//         $template = str_replace('[TEL]', $inscription->apprenant->telephone ?? '-', $template);
//         $template = str_replace('[EMAIL]', $inscription->apprenant->email ?? '-', $template);
//         $template = str_replace('[SEMESTRE]', $semestre ? "Semestre $semestre" : "Tous les semestres", $template);
//         $template = str_replace('[MATRICULE]', $inscription->apprenant->matricule ?? '-', $template);
//         $template = str_replace('[CLASSE]', $classe->libelle ?? '-', $template);
//         $template = str_replace('[ANNEE]', $classe->niveau_etude->nom ?? '-', $template);
//         $template = str_replace('[ANNEESCOLAIRE]', $inscription->anneeAcademique->code ?? '', $template);
//         $template = str_replace('[EFPT]', $classe->etablissement->nom ?? '-', $template);
//         $template = str_replace('[EFPTTEL]', $classe->etablissement->telephone ?? '-', $template);

        
//         $htmlGlobal .= $template;

//         if ($index < $total) {
//             $htmlGlobal .= '<div style="page-break-after: always;"></div>';
//         }
//     }

    
//     $pdf = Pdf::loadHTML($htmlGlobal)->setPaper('a4', 'portrait');
//     return $pdf->stream('Bulletins_Classe_'.$classe->libelle.'.pdf');
// }


public function generateCompetencePdf(string $id)
{
    $semestre = session()->get('selectedsemestre1'); // peut être null
    $semestreInt = $semestre ? (int) $semestre : null;

    // ✅ Charger l'apprenant et sa classe
    $inscription = Inscription::with([
        'apprenant',
        'classe.niveau_etude',
        'classe.etablissement',
        'anneeAcademique', // si relation existe
    ])->findOrFail($id);

    $niveauId = (int) $inscription->classe->niveau_etude_id;

    // ✅ Compétences (SANS critères) + disciplines (ressources)
    $competencesGenerales = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'generale')
        ->with('ressources')
        ->orderBy('nom')
        ->get();

    $competencesParticulieres = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'particuliere')
        ->with('ressources')
        ->orderBy('nom')
        ->get();

    // ✅ Toutes les ressources concernées
    $ressourceIds = $competencesGenerales
        ->merge($competencesParticulieres)
        ->flatMap(fn ($c) => ($c->ressources ?? collect())->pluck('id'))
        ->filter()
        ->unique()
        ->values()
        ->all();

    // ✅ Évaluations (intégration = composition) depuis evalutes (APC uniquement)
    $evalQuery = Evalute::query()
        ->where('inscription_id', (int) $inscription->id)
       
        ->whereIn('ressource_id', $ressourceIds);

    if ($semestreInt) {
        $evalQuery->where('semestre', $semestreInt);
    }

    $evalByRessource = $evalQuery
        ->get(['ressource_id', 'composition'])
        ->keyBy('ressource_id');

    // ✅ MCC = AVG(note) depuis DevoirAPC
    $mccQuery = DevoirAPC::query()
        ->where('inscription_id', (int) $inscription->id)
        ->whereIn('ressource_id', $ressourceIds)
        ->whereNotNull('note');

    if ($semestreInt) {
        $mccQuery->where('semestre', $semestreInt);
    }

    $mccRows = $mccQuery
        ->selectRaw('ressource_id, ROUND(AVG(note),2) as mcc')
        ->groupBy('ressource_id')
        ->get();

    $mccByRessource = [];
    foreach ($mccRows as $r) {
        $mccByRessource[(int) $r->ressource_id] = (float) $r->mcc;
    }

    // ✅ helper appréciation
    $obsFromNote = function ($note) {
        if (!is_numeric($note)) return '-';
        $note = (float) $note;
        if ($note < 10) return 'Insuffisant';
        if ($note < 12) return 'Passable';
        if ($note < 14) return 'Assez bien';
        if ($note < 16) return 'Bien';
        return 'Très bien';
    };

    /**
     * =========================================================
     * ✅ HTML COMPETENCES GENERALES (rowspan + fallback MCC)
     * =========================================================
     */
    $htmlGenerales = '';

    foreach ($competencesGenerales as $comp) {
        $ressources = ($comp->ressources ?? collect())->unique('id')->values();

        if ($ressources->isEmpty()) {
            $htmlGenerales .= "
            <tr>
                <td class='border-td bold-exo wrap' style='width:28%'>".htmlspecialchars($comp->nom)."</td>
                <td class='border-td wrap' style='width:32%'>Aucune discipline</td>
                <td class='border-td num' style='width:10%'>-</td>
                <td class='border-td num' style='width:12%'>-</td>
                <td class='border-td wrap' style='width:18%'>-</td>
            </tr>";
            continue;
        }

        $first = true;
        $rowspan = $ressources->count();

        foreach ($ressources as $res) {
            $mcc = $mccByRessource[$res->id] ?? null;

            $eval = $evalByRessource[$res->id] ?? null;
            $integrationRaw = $eval?->composition; // peut être null

            // ✅ règle générale : si pas d’intégration => MCC devient intégration
            $integrationEffective = ($integrationRaw === null || $integrationRaw === '')
                ? $mcc
                : (float) $integrationRaw;

            $app = $obsFromNote($integrationEffective);

            $mccTxt = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
            $intTxt = is_numeric($integrationEffective) ? number_format((float)$integrationEffective, 2) : '-';

            $htmlGenerales .= "<tr>";

            if ($first) {
                $htmlGenerales .= "
                <td rowspan='{$rowspan}' class='border-td bold-exo wrap' style='width:28%'>
                    ".htmlspecialchars($comp->nom)."
                </td>";
                $first = false;
            }

            $htmlGenerales .= "
                <td class='border-td wrap' style='width:32%'>".htmlspecialchars($res->nom)."</td>
                <td class='border-td num' style='width:10%'>{$mccTxt}</td>
                <td class='border-td num' style='width:12%'>{$intTxt}</td>
                <td class='border-td wrap' style='width:18%'>{$app}</td>
            </tr>";
        }
    }

    if (trim($htmlGenerales) === '') {
        $htmlGenerales = "
        <tr>
            <td colspan='5' class='border-td' align='center'>Aucune compétence générale</td>
        </tr>";
    }

  
    $htmlParticulieres = '';

    foreach ($competencesParticulieres as $comp) {
        $ressources = ($comp->ressources ?? collect())->unique('id')->values();

        if ($ressources->isEmpty()) {
            $htmlParticulieres .= "
            <tr>
                <td class='border-td bold-exo wrap' style='width:28%'>".htmlspecialchars($comp->nom)."</td>
                <td class='border-td wrap' style='width:32%'>Aucune discipline</td>
                <td class='border-td num' style='width:10%'>-</td>
                <td class='border-td num' style='width:12%'>-</td>
                <td class='border-td wrap' style='width:18%'>-</td>
            </tr>";
            continue;
        }

        $first = true;
        $rowspan = $ressources->count();

        foreach ($ressources as $res) {
            $mcc = $mccByRessource[$res->id] ?? null;

            $eval = $evalByRessource[$res->id] ?? null;
            $integration = $eval?->composition; // ici on affiche tel quel (si vide => '-')

            $mccTxt = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
            $intTxt = is_numeric($integration) ? number_format((float)$integration, 2) : '-';

            $app = is_numeric($integration) ? $obsFromNote((float)$integration) : '-';

            $htmlParticulieres .= "<tr>";

            if ($first) {
                $htmlParticulieres .= "
                <td rowspan='{$rowspan}' class='border-td bold-exo wrap' style='width:28%'>
                    ".htmlspecialchars($comp->nom)."
                </td>";
                $first = false;
            }

            $htmlParticulieres .= "
                <td class='border-td wrap' style='width:32%'>".htmlspecialchars($res->nom)."</td>
                <td class='border-td num' style='width:10%'>{$mccTxt}</td>
                <td class='border-td num' style='width:12%'>{$intTxt}</td>
                <td class='border-td wrap' style='width:18%'>{$app}</td>
            </tr>";
        }
    }

    if (trim($htmlParticulieres) === '') {
        $htmlParticulieres = "
        <tr>
            <td colspan='5' class='border-td' align='center'>Aucune compétence particulière</td>
        </tr>";
    }

    
     // $nbAbsences = $absencesSemestre->where('type', 'absence')->where('justifie', false);
    // $nbRetards  = $absencesSemestre->where('type', 'retard')->count();
    // $absencesSemestre = Absence::where('inscription_id', (int) $inscription->id)
    // ->when($semestreInt, fn($q) => $q->where('semestre', (int) $semestreInt))
    // ->get();
   $absencesSemestre = Absence::where('inscription_id', (int) $inscription->id)
    ->when($semestreInt, fn($q) => $q->where('semestre', (int) $semestreInt))
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


    // ✅ Template (chemin robuste)
    $templatePath = public_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = base_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = resource_path('views/competence.html');

    $template = file_get_contents($templatePath);

    // ✅ Inject CSS anti-débordement (Dompdf friendly)
    $antiOverflowCss = "
        .full-table{ width:100%; border-collapse:collapse; table-layout:fixed; }
        .border-td{ border:1px solid #000; padding:.25em; font-size:11px; vertical-align:top; white-space:normal; }
        .wrap{ word-wrap:break-word; overflow-wrap:break-word; }
        .num{ text-align:center; white-space:nowrap; }
    ";
    $template = str_replace('</style>', $antiOverflowCss . "\n</style>", $template);

    // Logo
    $logoPath = public_path('assets/images/titleHead.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }
    $template = str_replace('[LOGO]', $logoBase64, $template);

    // ✅ Blocs
    $template = str_replace('[BODYRESSOURCE]', $htmlGenerales, $template);
    $template = str_replace('[BODYCOMP]', $htmlParticulieres, $template);
   $fmt = fn($n) => rtrim(rtrim(number_format((float)$n, 2, '.', ''), '0'), '.');

$template = str_replace('[NB_ABSENCES]', $fmt($hAbsTotal), $template);
$template = str_replace('[NB_RETARDS]',  $fmt($hRetTotal), $template);


      setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr');
$dateNow = strftime('%e %B %Y');
$dateNow = trim($dateNow);

    
    $anneeScolaire = $inscription->anneeAcademique->code
        ?? ($inscription->classe->annee_academique->code ?? '');

    $replace = [
        '[DATE]' => $dateNow,
        '[USER]' => $inscription->apprenant->nom . ' ' . $inscription->apprenant->prenom,
        '[DATENAISSANCE]' => $inscription->apprenant->date_naissance,
        '[LIEUNAISSANCE]' => $inscription->apprenant->lieu_naissance,
        '[TEL]' => $inscription->apprenant->telephone,
        '[EMAIL]' => $inscription->apprenant->email,
        '[SEMESTRE]' => $semestreInt ?: 'Tous',
        '[MATRICULE]' => $inscription->apprenant->matricule,
        '[CLASSE]' => $inscription->classe->libelle,
        '[ANNEE]' => $inscription->classe->niveau_etude->nom,
        '[ANNEESCOLAIRE]' => $anneeScolaire,
        '[EFPT]' => $inscription->classe->etablissement->nom,
        '[EFPTTEL]' => $inscription->classe->etablissement->telephone,
        '[EFPTMAIL]' => $inscription->classe->etablissement->email,
    ];

    $template = str_replace(array_keys($replace), array_values($replace), $template);

    // ✅ Dompdf
    $dompdf = new Dompdf();
    $dompdf->getOptions()->set('isRemoteEnabled', true);
    $dompdf->loadHtml($template);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Carnet_de_Competence.pdf"');
}



public function generateClassePdf(string $classe_id)
{
    $semestre = session()->get('selectedsemestre1'); // peut être null
    $semestreInt = $semestre ? (int) $semestre : null;

    $classe = Classe::with([
        'niveau_etude',
        'etablissement',
        'inscriptions.apprenant',
        'annee_academique', // si relation existe côté classe
    ])->findOrFail($classe_id);

    $niveauId = (int) $classe->niveau_etude_id;

    $competencesGenerales = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'generale')
        ->with('ressources')
        ->orderBy('nom')
        ->get();

    $competencesParticulieres = Competence::query()
        ->where('niveau_etude_id', $niveauId)
        ->where('type', 'particuliere')
        ->with('ressources')
        ->orderBy('nom')
        ->get();

    // ✅ Toutes les ressources concernées
    $ressourceIds = $competencesGenerales
        ->merge($competencesParticulieres)
        ->flatMap(fn ($c) => ($c->ressources ?? collect())->pluck('id'))
        ->filter()
        ->unique()
        ->values()
        ->all();

    $inscriptionIds = $classe->inscriptions->pluck('id')->filter()->values()->all();

    // helper appréciation
    $obsFromNote = function ($note) {
        if (!is_numeric($note)) return '-';
        $note = (float) $note;
        if ($note < 10) return 'Insuffisant';
        if ($note < 12) return 'Passable';
        if ($note < 14) return 'Assez bien';
        if ($note < 16) return 'Bien';
        return 'Très bien';
    };

    // ✅ Précharger toutes les intégrations (Evalute.composition) APC de la classe
    $evalMap = []; // [inscription_id][ressource_id] => composition
    if (!empty($inscriptionIds) && !empty($ressourceIds)) {
        $evalQuery = Evalute::query()
            ->whereIn('inscription_id', $inscriptionIds)
            ->whereIn('ressource_id', $ressourceIds);

        if ($semestreInt) {
            $evalQuery->where('semestre', $semestreInt);
        }

        $evalRows = $evalQuery->get(['inscription_id', 'ressource_id', 'composition']);

        foreach ($evalRows as $e) {
            $evalMap[(int)$e->inscription_id][(int)$e->ressource_id] = $e->composition;
        }
    }

    // ✅ Précharger tous les MCC (AVG(note)) depuis DevoirAPC
    $mccMap = []; // [inscription_id][ressource_id] => mcc
    if (!empty($inscriptionIds) && !empty($ressourceIds)) {
        $mccQuery = DevoirAPC::query()
            ->whereIn('inscription_id', $inscriptionIds)
            ->whereIn('ressource_id', $ressourceIds)
            ->whereNotNull('note');

        if ($semestreInt) {
            $mccQuery->where('semestre', $semestreInt);
        }

        $mccRows = $mccQuery
            ->selectRaw('inscription_id, ressource_id, ROUND(AVG(note),2) as mcc')
            ->groupBy('inscription_id', 'ressource_id')
            ->get();

        foreach ($mccRows as $r) {
            $mccMap[(int)$r->inscription_id][(int)$r->ressource_id] = (float)$r->mcc;
        }
    }

    // ✅ Charger template (chemin robuste)
    $templatePath = public_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = base_path('competence.html');
    if (!file_exists($templatePath)) $templatePath = resource_path('views/competence.html');

    $templateRaw = file_get_contents($templatePath);

    // ✅ Inject CSS anti-débordement dompdf
    $antiOverflowCss = "
        .full-table{ width:100%; border-collapse:collapse; table-layout:fixed; }
        .border-td{ border:1px solid #000; padding:.25em; font-size:11px; vertical-align:top; white-space:normal; }
        .wrap{ word-wrap:break-word; overflow-wrap:break-word; }
        .num{ text-align:center; white-space:nowrap; }
    ";
    $templateRaw = str_replace('</style>', $antiOverflowCss . "\n</style>", $templateRaw);

    // ✅ Logo
    $logoPath = public_path('assets/images/titleHead.png');
    $logoBase64 = '';
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }
    $templateRaw = str_replace('[LOGO]', $logoBase64, $templateRaw);

    // ✅ format heures
    $fmt = fn($n) => rtrim(rtrim(number_format((float)$n, 2, '.', ''), '0'), '.');

    // ✅ Génération bulletins
    $bulletins = '';

    foreach ($classe->inscriptions as $inscription) {

        $inscId = (int) $inscription->id;

        /**
         * =========================
         * ✅ HTML GÉNÉRALES (rowspan + fallback MCC)
         * =========================
         */
        $htmlGenerales = '';

        foreach ($competencesGenerales as $comp) {
            $ressources = ($comp->ressources ?? collect())->unique('id')->values();

            if ($ressources->isEmpty()) {
                $htmlGenerales .= "
                <tr>
                    <td class='border-td bold-exo wrap' style='width:28%'>".htmlspecialchars($comp->nom)."</td>
                    <td class='border-td wrap' style='width:32%'>Aucune discipline</td>
                    <td class='border-td num' style='width:10%'>-</td>
                    <td class='border-td num' style='width:12%'>-</td>
                    <td class='border-td wrap' style='width:18%'>-</td>
                </tr>";
                continue;
            }

            $first = true;
            $rowspan = $ressources->count();

            foreach ($ressources as $res) {
                $resId = (int) $res->id;

                $mcc = $mccMap[$inscId][$resId] ?? null;
                $compositionRaw = $evalMap[$inscId][$resId] ?? null;

                // ✅ règle générale : si pas d’intégration => MCC
                $integrationEffective = ($compositionRaw === null || $compositionRaw === '')
                    ? $mcc
                    : (float)$compositionRaw;

                $mccTxt = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
                $intTxt = is_numeric($integrationEffective) ? number_format((float)$integrationEffective, 2) : '-';
                $app    = $obsFromNote($integrationEffective);

                $htmlGenerales .= "<tr>";

                if ($first) {
                    $htmlGenerales .= "
                    <td rowspan='{$rowspan}' class='border-td bold-exo wrap' style='width:28%>
                        ".htmlspecialchars($comp->nom)."
                    </td>";
                    $first = false;
                }

                $htmlGenerales .= "
                    <td class='border-td wrap' style='width:32%'>".htmlspecialchars($res->nom)."</td>
                    <td class='border-td num' style='width:10%'>{$mccTxt}</td>
                    <td class='border-td num' style='width:12%'>{$intTxt}</td>
                    <td class='border-td wrap' style='width:18%'>{$app}</td>
                </tr>";
            }
        }

        if (trim($htmlGenerales) === '') {
            $htmlGenerales = "
            <tr>
                <td colspan='5' class='border-td' align='center'>Aucune compétence générale</td>
            </tr>";
        }

        /**
         * =========================
         * ✅ HTML PARTICULIÈRES
         * =========================
         */
        $htmlParticulieres = '';

        foreach ($competencesParticulieres as $comp) {
            $ressources = ($comp->ressources ?? collect())->unique('id')->values();

            if ($ressources->isEmpty()) {
                $htmlParticulieres .= "
                <tr>
                    <td class='border-td bold-exo wrap' style='width:28%'>".htmlspecialchars($comp->nom)."</td>
                    <td class='border-td wrap' style='width:32%'>Aucune discipline</td>
                    <td class='border-td num' style='width:10%'>-</td>
                    <td class='border-td num' style='width:12%'>-</td>
                    <td class='border-td wrap' style='width:18%'>-</td>
                </tr>";
                continue;
            }

            $first = true;
            $rowspan = $ressources->count();

            foreach ($ressources as $res) {
                $resId = (int) $res->id;

                $mcc = $mccMap[$inscId][$resId] ?? null;
                $integration = $evalMap[$inscId][$resId] ?? null; // pas de fallback ici (particulière)

                $mccTxt = is_numeric($mcc) ? number_format((float)$mcc, 2) : '-';
                $intTxt = is_numeric($integration) ? number_format((float)$integration, 2) : '-';
                $app    = is_numeric($integration) ? $obsFromNote((float)$integration) : '-';

                $htmlParticulieres .= "<tr>";

                if ($first) {
                    $htmlParticulieres .= "
                    <td rowspan='{$rowspan}' class='border-td bold-exo wrap' style='width:28%'>
                        ".htmlspecialchars($comp->nom)."
                    </td>";
                    $first = false;
                }

                $htmlParticulieres .= "
                    <td class='border-td wrap' style='width:32%'>".htmlspecialchars($res->nom)."</td>
                    <td class='border-td num' style='width:10%'>{$mccTxt}</td>
                    <td class='border-td num' style='width:12%'>{$intTxt}</td>
                    <td class='border-td wrap' style='width:18%'>{$app}</td>
                </tr>";
            }
        }

        if (trim($htmlParticulieres) === '') {
            $htmlParticulieres = "
            <tr>
                <td colspan='5' class='border-td' align='center'>Aucune compétence particulière</td>
            </tr>";
        }

        /**
         * =========================
         * ✅ ABSENCES / RETARDS (HEURES)
         * =========================
         */
        $absencesSemestre = Absence::where('inscription_id', (int) $inscription->id)
            ->when($semestreInt, fn($q) => $q->where('semestre', (int) $semestreInt))
            ->get();

        $hAbsJust = (float) $absencesSemestre->where('type','absence')->where('justifie', 1)->sum('nombre_heure_absence');

        $hAbsNon = (float) $absencesSemestre->where('type','absence')
            ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
            ->sum('nombre_heure_absence');

        $hRetJust = (float) $absencesSemestre->where('type','retard')->where('justifie', 1)->sum('nombre_heure_retard');

        $hRetNon = (float) $absencesSemestre->where('type','retard')
            ->filter(fn($r) => (int)$r->justifie === 0 || (int)$r->nonjustifie === 1)
            ->sum('nombre_heure_retard');

        $hAbsTotal = $hAbsJust + $hAbsNon;
        $hRetTotal = $hRetJust + $hRetNon;

        // ✅ Date
   setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr');
$dateNow = strftime('%e %B %Y');
$dateNow = trim($dateNow);

        // ✅ Année scolaire
        $anneeScolaire = $inscription->anneeAcademique->code
            ?? ($classe->annee_academique->code ?? '');

        // ✅ Remplacements page
        $page = $templateRaw;
        $page = str_replace('[BODYRESSOURCE]', $htmlGenerales, $page);
        $page = str_replace('[BODYCOMP]', $htmlParticulieres, $page);

        // ✅ ICI : heures (et pas $nbAbsences/$nbRetards)
        $page = str_replace('[NB_ABSENCES]', $fmt($hAbsTotal), $page);
        $page = str_replace('[NB_RETARDS]',  $fmt($hRetTotal), $page);

        $replace = [
            '[DATE]' => $dateNow,
            '[USER]' => ($inscription->apprenant->nom ?? '') . ' ' . ($inscription->apprenant->prenom ?? ''),
            '[DATENAISSANCE]' => $inscription->apprenant->date_naissance ?? '',
            '[LIEUNAISSANCE]' => $inscription->apprenant->lieu_naissance ?? '',
            '[TEL]' => $inscription->apprenant->telephone ?? '',
            '[EMAIL]' => $inscription->apprenant->email ?? '',
            '[SEMESTRE]' => $semestreInt ?: 'Tous',
            '[MATRICULE]' => $inscription->apprenant->matricule ?? '',
            '[CLASSE]' => $classe->libelle ?? '',
            '[ANNEE]' => $classe->niveau_etude->nom ?? '',
            '[ANNEESCOLAIRE]' => $anneeScolaire,
            '[EFPT]' => $classe->etablissement->nom ?? '',
            '[EFPTTEL]' => $classe->etablissement->telephone ?? '',
            '[EFPTMAIL]' => $classe->etablissement->email ?? '',
        ];

        $page = str_replace(array_keys($replace), array_values($replace), $page);

        $bulletins .= $page . '<div style="page-break-after: always;"></div>';
    }

    // ✅ Dompdf unique pour toute la classe
    $dompdf = new Dompdf();
    $dompdf->getOptions()->set('isRemoteEnabled', true);
    $dompdf->loadHtml($bulletins);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="Carnets_Classe_'.$classe->libelle.'.pdf"');
}


public function suspendre($id)
{
    $inscription = Inscription::findOrFail($id);

    // On suppose qu’il y a un champ "statut" dans la table inscriptions
    // (exemples : 'active', 'suspendu', 'termine', etc.)
    $nouveauStatut = $inscription->statut === 'suspendu' ? 'active' : 'suspendu';
    $inscription->update(['statut' => $nouveauStatut]);

    // Journaliser l’action
    $this->logUserRepository->store([
        'action' => UserAction::UpdateInscription,
        'model' => Model::Inscription,
        'old_object' => json_encode(['ancien_statut' => $inscription->statut]),
        'new_object' => json_encode(['nouveau_statut' => $nouveauStatut]),
    ]);

    return redirect()->back()->withMessage("L'inscription a été mise à jour : statut = {$nouveauStatut}");
}


/**
 * Marquer un apprenant comme ayant abandonné ou le réactiver.
 */
public function abandonner($id)
{
    $inscription = Inscription::findOrFail($id);

    // 🔁 Changement de statut
    $nouveauStatut = $inscription->statut === 'abandonne' ? 'actif' : 'abandonne';
    $inscription->update(['statut' => $nouveauStatut]);

    // 🧾 Journalisation
    $this->logUserRepository->store([
        'action' => UserAction::UpdateInscription,
        'model' => Model::Inscription,
        'old_object' => json_encode(['ancien_statut' => $inscription->statut]),
        'new_object' => json_encode(['nouveau_statut' => $nouveauStatut]),
    ]);

    // ✅ Message de retour
    $message = $nouveauStatut === 'abandonne'
        ? "L'apprenant a été marqué comme ayant abandonné."
        : "L'apprenant a été réactivé avec succès.";

    return redirect()->back()->withMessage($message);
}




}
